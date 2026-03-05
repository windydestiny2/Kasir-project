# Machine Learning Engine for Kasir-Project

## 📋 Overview
Machine Learning service untuk sistem kasir dengan kemampuan prediksi real-time untuk:
- Menu recommendations berdasarkan hari
- Revenue forecasting harian
- Seasonal pattern detection

## 🛠️ Setup Instructions

### 1. Install Python & Dependencies
```bash
# Install Python 3.8+ jika belum ada
# macOS
brew install python3

# Windows/Linux - download dari python.org

# Setup virtual environment
cd ml_engine
python3 -m venv venv
source venv/bin/activate  # macOS/Linux
# venv\Scripts\activate   # Windows

# Install packages
pip install -r requirements.txt
```

### 2. Configure Database
Edit file `.env` sesuai konfigurasi database Laravel Anda:
```env
DB_HOST=localhost
DB_USER=root
DB_PASSWORD=
DB_NAME=db_kasir
DB_PORT=3306
```

### 3. Test Setup
```bash
# Test API
python test_api.py

# Train menu recommendation model
python train_menu_recommendation.py
```

### 4. Run ML API Server
```bash
python app.py
```
Server akan berjalan di `http://127.0.0.1:5000`

## 📊 API Endpoints

### Health Check
```
GET /health
```
Response: Status server dan timestamp

### Model Training
```
POST /train/menu-recommendation
```
Train model rekomendasi menu

### Predictions
```
GET /predict/menu-recommendations?day_of_week=1
```
Get rekomendasi menu (day_of_week optional, default hari ini)

### Models Status
```
GET /models/status
```
Check status semua model yang sudah ditraining

## 🔧 Integration dengan Laravel

### 1. Install Guzzle HTTP Client
```bash
composer require guzzlehttp/guzzle
```

### 2. Buat Controller untuk ML
```php
// app/Http/Controllers/MLController.php
use Illuminate\Support\Facades\Http;

class MLController extends Controller
{
    public function getMenuRecommendations()
    {
        $response = Http::get('http://127.0.0.1:5000/predict/menu-recommendations');
        return $response->json();
    }
}
```

### 3. Route
```php
// routes/web.php
Route::get('/ml/menu-recommendations', [MLController::class, 'getMenuRecommendations']);
```

## 📈 Model Details

### Menu Recommendation Model
- **Algorithm**: Popularity-based scoring
- **Features**: Day of week, menu sales count, revenue
- **Output**: Top 3 menu recommendations per hari
- **Accuracy**: Based on historical patterns

### Revenue Forecasting Model (Coming Soon)
- **Algorithm**: Linear Regression
- **Features**: Historical revenue, day patterns
- **Output**: Revenue prediction with confidence interval

### Seasonal Pattern Detection (Coming Soon)
- **Algorithm**: Time series analysis
- **Features**: Daily sales patterns
- **Output**: Peak hours, best days, trends

## 📁 Project Structure
```
ml_engine/
├── app.py              # Main Flask API server
├── requirements.txt    # Python dependencies
├── .env               # Configuration
├── test_api.py        # API testing script
├── train_menu_recommendation.py  # Model training
├── models/            # Trained models storage
├── logs/              # Application logs
└── README.md          # This file
```

## 🚀 Development Roadmap

### Week 1: Menu Recommendation ✅
- [x] Basic Flask API setup
- [x] Database connection
- [x] Menu recommendation model
- [x] API endpoints
- [x] Laravel integration

### Week 2: Revenue Forecasting
- [ ] Linear regression model
- [ ] Revenue prediction API
- [ ] Confidence intervals
- [ ] Dashboard integration

### Week 3: Seasonal Patterns
- [ ] Time series analysis
- [ ] Pattern detection
- [ ] Peak hours identification
- [ ] Trend analysis

### Week 4: Production & Testing
- [ ] Error handling
- [ ] Performance optimization
- [ ] Documentation
- [ ] Final testing

## 📞 Support
Untuk pertanyaan atau issues, check logs di folder `logs/`