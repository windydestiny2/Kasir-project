#!/usr/bin/env python3
"""
Revenue Forecasting Model Training Script
Training linear regression model untuk memprediksi total pendapatan harian berdasarkan data penjualan historis, hari dalam minggu, dan faktor lainnya. Model ini akan digunakan untuk memberikan prediksi
"""

import sys
import os
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from app import MLService
import logging

def main():
    """Main training function"""
    print("💰 Starting Revenue Forecasting Model Training...")
    print("=" * 50)

    # Initialize ML Service
    ml_service = MLService()

    # Train the model
    print("📊 Training revenue forecasting model...")
    result = ml_service.train_revenue_forecasting_model()

    print(f"Status: {result['status']}")
    print(f"Message: {result['message']}")

    if result['status'] == 'success':
        print(f"✅ Model trained successfully with {result['data_points']} data points")
        print(f"📈 R² Score: {result['r2_score']:.3f}")
        print(f"📉 MSE: {result['mse']:.2f}")

        # Test the model
        print("\n🧪 Testing revenue predictions...")
        test_result = ml_service.predict_revenue()

        if test_result['status'] == 'success':
            pred = test_result['prediction']
            conf = pred['confidence_interval']
            print(f"💰 Predicted Revenue: Rp {pred['predicted_revenue']:,.0f}")
            print(f"📊 Confidence Interval: Rp {conf['lower']:,.0f} - Rp {conf['upper']:,.0f}")
            print(f"📅 Day of week: {pred['day_of_week']}")
            print(f"🛒 Expected orders: {pred['expected_orders']}")
        else:
            print(f"❌ Test failed: {test_result['message']}")

    print("\n✅ Training completed!")

if __name__ == "__main__":
    main()