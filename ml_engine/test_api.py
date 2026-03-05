#!/usr/bin/env python3
"""
Test script for ML API endpoints
"""

import requests
import json

BASE_URL = "http://127.0.0.1:5000"

def test_health():
    """Test health check"""
    print("🩺 Testing Health Check...")
    try:
        response = requests.get(f"{BASE_URL}/health")
        if response.status_code == 200:
            print("✅ Health check passed")
            return True
        else:
            print(f"❌ Health check failed: {response.status_code}")
            return False
    except Exception as e:
        print(f"❌ Health check error: {str(e)}")
        return False

def test_models_status():
    """Test models status"""
    print("\n📊 Testing Models Status...")
    try:
        response = requests.get(f"{BASE_URL}/models/status")
        if response.status_code == 200:
            data = response.json()
            print("✅ Models status retrieved")
            print("📋 Current models status:")
            for model_name, status in data['models'].items():
                print(f"  • {model_name}: {status['status']}")
            return True
        else:
            print(f"❌ Models status failed: {response.status_code}")
            return False
    except Exception as e:
        print(f"❌ Models status error: {str(e)}")
        return False

def test_menu_predictions():
    """Test menu predictions"""
    print("\n🎯 Testing Menu Predictions...")
    try:
        response = requests.get(f"{BASE_URL}/predict/menu-recommendations")
        if response.status_code == 200:
            data = response.json()
            if data['status'] == 'success':
                print("✅ Menu predictions successful")
                print(f"📅 Day of week: {data['day_of_week']}")
                print("🎯 Top recommendations:")
                for rec in data['recommendations']:
                    print(f"  • {rec['menu_name']} (Score: {rec['popularity_score']:.2f})")
                return True
            else:
                print(f"❌ Menu predictions failed: {data['message']}")
                return False
        else:
            print(f"❌ Menu predictions HTTP error: {response.status_code}")
            return False
    except Exception as e:
        print(f"❌ Menu predictions error: {str(e)}")
        return False

def test_revenue_predictions():
    """Test revenue predictions"""
    print("\n💰 Testing Revenue Predictions...")
    try:
        response = requests.get(f"{BASE_URL}/predict/revenue")
        if response.status_code == 200:
            data = response.json()
            if data['status'] == 'success':
                print("✅ Revenue predictions successful")
                pred = data['prediction']
                conf = pred['confidence_interval']
                print(f"💰 Predicted: Rp {pred['predicted_revenue']:,.0f}")
                print(f"📊 Range: Rp {conf['lower']:,.0f} - Rp {conf['upper']:,.0f}")
                return True
            else:
                print(f"❌ Revenue predictions failed: {data['message']}")
                return False
        else:
            print(f"❌ Revenue predictions HTTP error: {response.status_code}")
            return False
    except Exception as e:
        print(f"❌ Revenue predictions error: {str(e)}")
        return False

def test_train_revenue_model():
    """Test revenue model training"""
    print("\n🚀 Testing Revenue Model Training...")
    try:
        response = requests.post(f"{BASE_URL}/train/revenue-forecasting")
        if response.status_code == 200:
            data = response.json()
            print(f"✅ Training result: {data['status']}")
            print(f"📝 Message: {data['message']}")
            if data['status'] == 'success':
                print(f"📊 R² Score: {data.get('r2_score', 'N/A'):.3f}")
            return data['status'] == 'success'
        else:
            print(f"❌ Training HTTP error: {response.status_code}")
            return False
    except Exception as e:
        print(f"❌ Training error: {str(e)}")
        return False

def test_seasonal_patterns():
    """Test seasonal pattern analysis"""
    print("\n📊 Testing Seasonal Pattern Analysis...")
    try:
        response = requests.get(f"{BASE_URL}/predict/seasonal-patterns")
        if response.status_code == 200:
            data = response.json()
            if data['status'] == 'success':
                print("✅ Seasonal patterns successful")
                today = data['today_analysis']
                print(f"📅 Today: {today['day_name']}")
                print(f"💰 Expected revenue: Rp {today['expected_revenue']:,.0f}")
                print(f"🕐 Peak hours: {', '.join(today['peak_hours'])}")
                return True
            else:
                print(f"❌ Seasonal patterns failed: {data['message']}")
                return False
        else:
            print(f"❌ Seasonal patterns HTTP error: {response.status_code}")
            return False
    except Exception as e:
        print(f"❌ Seasonal patterns error: {str(e)}")
        return False

def test_train_seasonal_model():
    """Test seasonal model training"""
    print("\n🚀 Testing Seasonal Model Training...")
    try:
        response = requests.post(f"{BASE_URL}/train/seasonal-pattern")
        if response.status_code == 200:
            data = response.json()
            print(f"✅ Training result: {data['status']}")
            print(f"📝 Message: {data['message']}")
            if data['status'] == 'success':
                print(f"📈 Trend: {data.get('trend_percentage', 0):.1f}%")
            return data['status'] == 'success'
        else:
            print(f"❌ Training HTTP error: {response.status_code}")
            return False
    except Exception as e:
        print(f"❌ Training error: {str(e)}")
        return False

def main():
    """Main test function"""
    print("🧪 ML API Test Suite")
    print("=" * 30)

    # Run all tests
    tests = [
        ("Health Check", test_health),
        ("Models Status", test_models_status),
        ("Menu Model Training", test_train_model),
        ("Menu Predictions", test_menu_predictions),
        ("Revenue Model Training", test_train_revenue_model),
        ("Revenue Predictions", test_revenue_predictions),
        ("Seasonal Model Training", test_train_seasonal_model),
        ("Seasonal Pattern Analysis", test_seasonal_patterns),
    ]

    passed = 0
    total = len(tests)

    for test_name, test_func in tests:
        print(f"\n🔍 Running: {test_name}")
        if test_func():
            passed += 1
        print("-" * 20)

    print(f"\n📊 Test Results: {passed}/{total} tests passed")

    if passed == total:
        print("🎉 All tests passed! ML API is ready.")
    else:
        print("⚠️  Some tests failed. Check the logs.")

if __name__ == "__main__":
    main()