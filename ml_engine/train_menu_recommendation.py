#!/usr/bin/env python3
"""
Menu Recommendation Model Training Script
Train the model to predict popular menus for each day of the week
"""

import sys
import os
sys.path.append(os.path.dirname(os.path.abspath(__file__)))

from app import MLService
import logging

def main():
    """Main training function"""
    print("🚀 Starting Menu Recommendation Model Training...")
    print("=" * 50)

    # Initialize ML Service
    ml_service = MLService()

    # Train the model
    print("📊 Training menu recommendation model...")
    result = ml_service.train_menu_recommendation_model()

    print(f"Status: {result['status']}")
    print(f"Message: {result['message']}")

    if result['status'] == 'success':
        print(f"✅ Model trained successfully with {result['data_points']} data points")

        # Test the model
        print("\n🧪 Testing model predictions...")
        test_result = ml_service.predict_menu_recommendations()

        if test_result['status'] == 'success':
            print(f"📅 Day of week: {test_result['day_of_week']}")
            print("🎯 Top 3 Menu Recommendations:")
            for i, rec in enumerate(test_result['recommendations'], 1):
                print(f"  {i}. {rec['menu_name']} (Score: {rec['popularity_score']:.2f})")
        else:
            print(f"❌ Test failed: {test_result['message']}")

    print("\n✅ Training completed!")

if __name__ == "__main__":
    main()