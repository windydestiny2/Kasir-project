"""
Machine Learning API for Kasir-Project
Flask-based ML service for real-time predictions
"""

from flask import Flask, jsonify, request
from flask_cors import CORS
import mysql.connector
import pandas as pd
import numpy as np
from datetime import datetime, timedelta
import joblib
import os
from dotenv import load_dotenv
import logging

# Load environment variables
load_dotenv()

# Configure logging
logging.basicConfig(
    filename='logs/ml_engine.log',
    level=logging.INFO,
    format='%(asctime)s - %(levelname)s - %(message)s'
)

app = Flask(__name__)
CORS(app)  # Enable CORS for Laravel integration

class DatabaseConnection:
    """Database connection manager"""
    def __init__(self):
        self.config = {
            'host': os.getenv('DB_HOST', 'localhost'),
            'user': os.getenv('DB_USER', 'root'),
            'password': os.getenv('DB_PASSWORD', ''),
            'database': os.getenv('DB_NAME', 'db_kasir'),
            'port': int(os.getenv('DB_PORT', 3306))
        }

    def get_connection(self):
        return mysql.connector.connect(**self.config)

class MLService:
    """Main ML Service Class"""
    def __init__(self):
        self.db = DatabaseConnection()
        self.model_path = 'models/'
        os.makedirs(self.model_path, exist_ok=True)

    def get_training_data(self):
        """Get training data from database"""
        try:
            conn = self.db.get_connection()
            cursor = conn.cursor(dictionary=True)

            # Get order data with menu details
            query = """
            SELECT
                o.id as order_id,
                o.total,
                o.created_at,
                DATE(o.created_at) as order_date,
                DAYOFWEEK(o.created_at) as day_of_week,
                HOUR(o.created_at) as order_hour,
                p.nm_produk as menu_name,
                t.name_toping as topping,
                u.nama as ukuran,
                oi.qty,
                oi.price,
                oi.total as item_total
            FROM orders o
            JOIN order_items oi ON o.id = oi.order_id
            JOIN products p ON oi.product_id = p.id
            LEFT JOIN topings t ON oi.toping_id = t.id
            LEFT JOIN ukurans u ON oi.ukuran_id = u.id
            WHERE o.created_at >= DATE_SUB(NOW(), INTERVAL 120 DAY)
            ORDER BY o.created_at DESC
            """

            cursor.execute(query)
            data = cursor.fetchall()

            cursor.close()
            conn.close()

            return pd.DataFrame(data)

        except Exception as e:
            logging.error(f"Error getting training data: {str(e)}")
            return pd.DataFrame()

    def train_menu_recommendation_model(self):
        """Train menu recommendation model"""
        try:
            df = self.get_training_data()

            if df.empty:
                return {"status": "error", "message": "No training data available"}

            # Group by day of week and menu to get popularity
            menu_popularity = df.groupby(['day_of_week', 'menu_name']).agg({
                'order_id': 'count',
                'total': 'sum'
            }).reset_index()

            menu_popularity.columns = ['day_of_week', 'menu_name', 'order_count', 'total_revenue']

            # Calculate popularity score
            menu_popularity['popularity_score'] = (
                menu_popularity['order_count'] * 0.6 +
                menu_popularity['total_revenue'] / menu_popularity['total_revenue'].max() * 0.4
            )

            # Save model
            model_data = {
                'menu_popularity': menu_popularity,
                'last_trained': datetime.now(),
                'data_points': len(df)
            }

            joblib.dump(model_data, f'{self.model_path}menu_recommendation.pkl')

            return {
                "status": "success",
                "message": f"Menu recommendation model trained with {len(df)} data points",
                "data_points": len(df)
            }

        except Exception as e:
            logging.error(f"Error training menu recommendation: {str(e)}")
            return {"status": "error", "message": str(e)}

    def predict_menu_recommendations(self, day_of_week=None):
        """Predict menu recommendations for a day"""
        try:
            if day_of_week is None:
                day_of_week = datetime.now().weekday() + 1  # MySQL style (1=Monday)

            # Load model
            model_file = f'{self.model_path}menu_recommendation.pkl'
            if not os.path.exists(model_file):
                return {"status": "error", "message": "Model not trained yet"}

            model_data = joblib.load(model_file)

            # Filter by day and get top 3
            day_data = model_data['menu_popularity'][
                model_data['menu_popularity']['day_of_week'] == day_of_week
            ]

            if day_data.empty:
                # Fallback to overall popularity
                day_data = model_data['menu_popularity']

            recommendations = day_data.nlargest(3, 'popularity_score')[
                ['menu_name', 'order_count', 'total_revenue', 'popularity_score']
            ].to_dict('records')

            return {
                "status": "success",
                "day_of_week": day_of_week,
                "recommendations": recommendations,
                "last_trained": model_data['last_trained'].isoformat(),
                "data_points": model_data['data_points']
            }

        except Exception as e:
            logging.error(f"Error predicting menu recommendations: {str(e)}")
    def train_revenue_forecasting_model(self):
        """Train revenue forecasting model using linear regression"""
        try:
            df = self.get_training_data()

            if df.empty:
                return {"status": "error", "message": "No training data available"}

            # Aggregate daily revenue
            daily_revenue = df.groupby('order_date').agg({
                'total': 'sum',
                'order_id': 'nunique'  # unique orders per day
            }).reset_index()

            daily_revenue.columns = ['date', 'total_revenue', 'order_count']
            daily_revenue['date'] = pd.to_datetime(daily_revenue['date'])
            daily_revenue = daily_revenue.sort_values('date')

            # Add day of week feature
            daily_revenue['day_of_week'] = daily_revenue['date'].dt.dayofweek + 1  # 1=Monday

            # Simple linear regression: revenue = a * day_of_week + b * order_count + c
            from sklearn.linear_model import LinearRegression
            from sklearn.model_selection import train_test_split
            from sklearn.metrics import mean_squared_error, r2_score

            # Features: day_of_week, order_count
            X = daily_revenue[['day_of_week', 'order_count']]
            y = daily_revenue['total_revenue']

            # Split data
            X_train, X_test, y_train, y_test = train_test_split(X, y, test_size=0.2, random_state=42)

            # Train model
            model = LinearRegression()
            model.fit(X_train, y_train)

            # Evaluate
            y_pred = model.predict(X_test)
            mse = mean_squared_error(y_test, y_pred)
            r2 = r2_score(y_test, y_pred)

            # Save model
            model_data = {
                'model': model,
                'feature_names': ['day_of_week', 'order_count'],
                'last_trained': datetime.now(),
                'data_points': len(daily_revenue),
                'mse': mse,
                'r2_score': r2,
                'training_data_stats': {
                    'avg_revenue': daily_revenue['total_revenue'].mean(),
                    'max_revenue': daily_revenue['total_revenue'].max(),
                    'min_revenue': daily_revenue['total_revenue'].min(),
                    'total_days': len(daily_revenue)
                }
            }

            joblib.dump(model_data, f'{self.model_path}revenue_forecasting.pkl')

            return {
                "status": "success",
                "message": f"Revenue forecasting model trained with {len(daily_revenue)} data points",
                "data_points": len(daily_revenue),
                "mse": mse,
                "r2_score": r2
            }

        except Exception as e:
            logging.error(f"Error training revenue forecasting: {str(e)}")
            return {"status": "error", "message": str(e)}

    def predict_revenue(self, day_of_week=None, expected_orders=None):
        """Predict revenue for a given day"""
        try:
            # Load model
            model_file = f'{self.model_path}revenue_forecasting.pkl'
            if not os.path.exists(model_file):
                return {"status": "error", "message": "Revenue forecasting model not trained yet"}

            model_data = joblib.load(model_file)

            # Default values
            if day_of_week is None:
                day_of_week = datetime.now().weekday() + 1

            if expected_orders is None:
                # Use average orders from training data
                expected_orders = model_data['training_data_stats']['total_days'] * 1.0  # rough estimate

            # Make prediction
            features = np.array([[day_of_week, expected_orders]])
            predicted_revenue = model_data['model'].predict(features)[0]

            # Calculate confidence interval (simple approach)
            std_error = np.sqrt(model_data['mse'])
            confidence_interval = 1.96 * std_error  # 95% confidence

            return {
                "status": "success",
                "prediction": {
                    "day_of_week": day_of_week,
                    "expected_orders": expected_orders,
                    "predicted_revenue": float(predicted_revenue),
                    "confidence_interval": {
                        "lower": float(max(0, predicted_revenue - confidence_interval)),
                        "upper": float(predicted_revenue + confidence_interval)
                    },
                    "currency": "IDR"
                },
                "model_info": {
                    "last_trained": model_data['last_trained'].isoformat(),
                    "data_points": model_data['data_points'],
                    "r2_score": model_data['r2_score'],
                    "training_avg_revenue": model_data['training_data_stats']['avg_revenue']
                }
            }

        except Exception as e:
            logging.error(f"Error predicting revenue: {str(e)}")
            return {"status": "error", "message": str(e)}

    def train_seasonal_pattern_model(self):
        """Train seasonal pattern detection model"""
        try:
            df = self.get_training_data()

            if df.empty:
                return {"status": "error", "message": "No training data available"}

            # Analyze patterns by day of week and hour
            df['order_hour'] = pd.to_datetime(df['created_at']).dt.hour

            # Daily patterns
            daily_patterns = df.groupby('day_of_week').agg({
                'total': ['count', 'sum', 'mean'],
                'order_id': 'nunique'
            }).round(2)

            daily_patterns.columns = ['total_orders', 'total_revenue', 'avg_order_value', 'unique_orders']
            daily_patterns = daily_patterns.reset_index()

            # Hourly patterns
            hourly_patterns = df.groupby(['day_of_week', 'order_hour']).agg({
                'total': ['count', 'sum']
            }).round(2)

            hourly_patterns.columns = ['hourly_orders', 'hourly_revenue']
            hourly_patterns = hourly_patterns.reset_index()

            # Peak hours analysis
            peak_hours = hourly_patterns.groupby('day_of_week').apply(
                lambda x: x.nlargest(3, 'hourly_orders')
            ).reset_index(drop=True)

            # Trend analysis (simple moving average)
            daily_trend = df.groupby('order_date').agg({
                'total': 'sum',
                'order_id': 'nunique'
            }).reset_index()

            daily_trend = daily_trend.sort_values('order_date')
            daily_trend['revenue_ma7'] = daily_trend['total'].rolling(window=7).mean()
            daily_trend['order_ma7'] = daily_trend['order_id'].rolling(window=7).mean()

            # Calculate trend direction
            recent_trend = daily_trend.tail(14)  # Last 2 weeks
            if len(recent_trend) >= 7:
                recent_avg = recent_trend['total'].tail(7).mean()
                previous_avg = recent_trend['total'].head(7).mean()
                trend_percentage = ((recent_avg - previous_avg) / previous_avg) * 100 if previous_avg > 0 else 0
            else:
                trend_percentage = 0

            # Save model
            model_data = {
                'daily_patterns': daily_patterns,
                'hourly_patterns': hourly_patterns,
                'peak_hours': peak_hours,
                'daily_trend': daily_trend,
                'trend_analysis': {
                    'trend_percentage': trend_percentage,
                    'trend_direction': 'up' if trend_percentage > 0 else 'down',
                    'analysis_period_days': len(daily_trend)
                },
                'last_trained': datetime.now(),
                'data_points': len(df)
            }

            joblib.dump(model_data, f'{self.model_path}seasonal_pattern.pkl')

            return {
                "status": "success",
                "message": f"Seasonal pattern model trained with {len(df)} data points",
                "data_points": len(df),
                "trend_percentage": trend_percentage
            }

        except Exception as e:
            logging.error(f"Error training seasonal pattern: {str(e)}")
            return {"status": "error", "message": str(e)}

    def get_seasonal_patterns(self):
        """Get seasonal pattern analysis"""
        try:
            # Load model
            model_file = f'{self.model_path}seasonal_pattern.pkl'
            if not os.path.exists(model_file):
                return {"status": "error", "message": "Seasonal pattern model not trained yet"}

            model_data = joblib.load(model_file)

            # Get today's day of week
            today_dow = datetime.now().weekday() + 1

            # Today's patterns
            today_patterns = model_data['daily_patterns'][
                model_data['daily_patterns']['day_of_week'] == today_dow
            ]

            if today_patterns.empty:
                today_stats = {"total_orders": 0, "total_revenue": 0, "avg_order_value": 0}
            else:
                today_stats = today_patterns.iloc[0].to_dict()

            # Peak hours for today
            today_peak_hours = model_data['peak_hours'][
                model_data['peak_hours']['day_of_week'] == today_dow
            ].head(3).to_dict('records')

            # Best performing day
            best_day = model_data['daily_patterns'].loc[
                model_data['daily_patterns']['total_revenue'].idxmax()
            ].to_dict()

            # Day names mapping
            day_names = {
                1: 'Senin', 2: 'Selasa', 3: 'Rabu', 4: 'Kamis',
                5: 'Jumat', 6: 'Sabtu', 7: 'Minggu'
            }

            return {
                "status": "success",
                "today_analysis": {
                    "day_of_week": today_dow,
                    "day_name": day_names.get(today_dow, 'Unknown'),
                    "expected_orders": today_stats['total_orders'],
                    "expected_revenue": today_stats['total_revenue'],
                    "avg_order_value": today_stats['avg_order_value'],
                    "peak_hours": [f"{hour}:00" for hour in [h['order_hour'] for h in today_peak_hours]]
                },
                "best_performing_day": {
                    "day_of_week": int(best_day['day_of_week']),
                    "day_name": day_names.get(int(best_day['day_of_week']), 'Unknown'),
                    "total_revenue": best_day['total_revenue'],
                    "total_orders": best_day['total_orders']
                },
                "trend_analysis": model_data['trend_analysis'],
                "model_info": {
                    "last_trained": model_data['last_trained'].isoformat(),
                    "data_points": model_data['data_points']
                }
            }

        except Exception as e:
            logging.error(f"Error getting seasonal patterns: {str(e)}")
            return {"status": "error", "message": str(e)}

# Initialize ML Service
ml_service = MLService()

@app.route('/health', methods=['GET'])
def health_check():
    """Health check endpoint"""
    return jsonify({
        "status": "healthy",
        "timestamp": datetime.now().isoformat(),
        "service": "ML Engine for Kasir-Project"
    })

@app.route('/train/menu-recommendation', methods=['POST'])
def train_menu_recommendation():
    """Train menu recommendation model"""
    result = ml_service.train_menu_recommendation_model()
    return jsonify(result)

@app.route('/train/revenue-forecasting', methods=['POST'])
def train_revenue_forecasting():
    """Train revenue forecasting model"""
    result = ml_service.train_revenue_forecasting_model()
    return jsonify(result)

@app.route('/predict/revenue', methods=['GET'])
def predict_revenue():
    """Predict revenue for today or specified day"""
    day_of_week = request.args.get('day_of_week', type=int)
    expected_orders = request.args.get('expected_orders', type=int)
    result = ml_service.predict_revenue(day_of_week, expected_orders)
    return jsonify(result)

@app.route('/predict/menu-recommendations', methods=['GET'])
def predict_menu_recommendations():
    """Predict menu recommendations for today or specified day"""
    day_of_week = request.args.get('day_of_week', type=int)
    result = ml_service.predict_menu_recommendations(day_of_week)
    return jsonify(result)

@app.route('/train/seasonal-pattern', methods=['POST'])
def train_seasonal_pattern():
    """Train seasonal pattern detection model"""
    result = ml_service.train_seasonal_pattern_model()
    return jsonify(result)

@app.route('/predict/seasonal-patterns', methods=['GET'])
def get_seasonal_patterns():
    """Get seasonal pattern analysis"""
    result = ml_service.get_seasonal_patterns()
    return jsonify(result)

@app.route('/models/status', methods=['GET'])
def get_models_status():
    """Get status of all trained models"""
    models_status = {}

    # Check menu recommendation model
    menu_model_file = f'{ml_service.model_path}menu_recommendation.pkl'
    if os.path.exists(menu_model_file):
        try:
            model_data = joblib.load(menu_model_file)
            models_status['menu_recommendation'] = {
                "status": "trained",
                "last_trained": model_data['last_trained'].isoformat(),
                "data_points": model_data['data_points']
            }
        except:
            models_status['menu_recommendation'] = {"status": "error"}
    else:
        models_status['menu_recommendation'] = {"status": "not_trained"}

    # Check revenue forecasting model
    revenue_model_file = f'{ml_service.model_path}revenue_forecasting.pkl'
    if os.path.exists(revenue_model_file):
        try:
            model_data = joblib.load(revenue_model_file)
            models_status['revenue_forecasting'] = {
                "status": "trained",
                "last_trained": model_data['last_trained'].isoformat(),
                "data_points": model_data['data_points'],
                "r2_score": model_data['r2_score']
            }
        except:
            models_status['revenue_forecasting'] = {"status": "error"}
    else:
        models_status['revenue_forecasting'] = {"status": "not_trained"}

    # Check seasonal pattern model
    seasonal_model_file = f'{ml_service.model_path}seasonal_pattern.pkl'
    if os.path.exists(seasonal_model_file):
        try:
            model_data = joblib.load(seasonal_model_file)
            models_status['seasonal_pattern'] = {
                "status": "trained",
                "last_trained": model_data['last_trained'].isoformat(),
                "data_points": model_data['data_points'],
                "trend_percentage": model_data['trend_analysis']['trend_percentage']
            }
        except:
            models_status['seasonal_pattern'] = {"status": "error"}
    else:
        models_status['seasonal_pattern'] = {"status": "not_trained"}

    return jsonify({
        "status": "success",
        "models": models_status
    })

if __name__ == '__main__':
    app.run(
        host='127.0.0.1',
        port=5000,
        debug=os.getenv('FLASK_DEBUG', 'True').lower() == 'true'
    )