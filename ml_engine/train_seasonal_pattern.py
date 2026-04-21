#!/usr/bin/env python3
"""
Seasonal Pattern Detection Model Training Script
Train model untuk mendeteksi pola musiman dalam data penjualan, seperti hari-hari dengan penjualan tinggi atau rendah, 
dan tren musiman lainnya. Model ini akan digunakan untuk memberikan analisis pola musiman setiap harinya.
"""

import sys
import os
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from app import MLService
import logging

def main():
    """Main training function"""
    print("📊 Starting Seasonal Pattern Detection Model Training...")
    print("=" * 50)

    # Initialize ML Service
    ml_service = MLService()

    # Train the model
    print("🔍 Analyzing seasonal patterns...")
    result = ml_service.train_seasonal_pattern_model()

    print(f"Status: {result['status']}")
    print(f"Message: {result['message']}")

    if result['status'] == 'success':
        print(f"✅ Model trained successfully with {result['data_points']} data points")
        print(f"📈 Trend: {result['trend_percentage']:.1f}%")

        # Test the model
        print("\n🧪 Testing seasonal pattern analysis...")
        test_result = ml_service.get_seasonal_patterns()

        if test_result['status'] == 'success':
            today = test_result['today_analysis']
            best_day = test_result['best_performing_day']
            trend = test_result['trend_analysis']

            print(f"📅 Today ({today['day_name']}):")
            print(f"  • Expected orders: {today['expected_orders']}")
            print(f"  • Expected revenue: Rp {today['expected_revenue']:,.0f}")
            print(f"  • Peak hours: {', '.join(today['peak_hours'])}")

            best_revenue = best_day.get('avg_revenue_per_day', best_day.get('median_revenue_per_day', 0))
            print(f"\n🏆 Best day: {best_day['day_name']} (Rp {best_revenue:,.0f})")

            print(f"\n📈 Trend: {trend['trend_percentage']:.1f}% ({trend['trend_direction']})")
        else:
            print(f"❌ Test failed: {test_result['message']}")

    print("\n✅ Training completed!")

if __name__ == "__main__":
    main()