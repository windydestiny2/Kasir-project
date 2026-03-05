<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MLController extends Controller
{
    private $mlApiUrl = 'http://127.0.0.1:5002';

    /**
     * Display ML Dashboard
     */
    public function dashboard()
    {
        try {
            // Get all model statuses
            $statusResponse = $this->callMlApi('GET', '/models/status');
            $modelsStatus = $statusResponse['models'] ?? null;

            // Get menu recommendations
            $menuRecommendations = $this->callMlApi('GET', '/predict/menu-recommendations');

            // Get revenue prediction
            $revenuePrediction = $this->callMlApi('GET', '/predict/revenue');

            // Get seasonal patterns
            $seasonalPatterns = $this->callMlApi('GET', '/predict/seasonal-patterns');

            return view('ml.dashboard', [
                'title' => 'ML Dashboard',
                'modelsStatus' => $modelsStatus,
                'menuRecommendations' => $menuRecommendations,
                'revenuePrediction' => $revenuePrediction,
                'seasonalPatterns' => $seasonalPatterns
            ]);

        } catch (\Exception $e) {
            Log::error('ML Dashboard Error: ' . $e->getMessage());
            return view('ml.dashboard', [
                'title' => 'ML Dashboard',
                'error' => 'Tidak dapat terhubung ke ML Service. Pastikan Python API sedang berjalan.',
                'modelsStatus' => null,
                'menuRecommendations' => null,
                'revenuePrediction' => null,
                'seasonalPatterns' => null
            ]);
        }
    }

    /**
     * Train Menu Recommendation Model
     */
    public function trainMenuRecommendation()
    {
        try {
            $result = $this->callMlApi('POST', '/train/menu-recommendation');

            if ($result && isset($result['status']) && $result['status'] === 'success') {
                return response()->json([
                    'success' => true,
                    'message' => 'Menu recommendation model berhasil ditraining!',
                    'data' => $result
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Gagal training model'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Train Menu Recommendation Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Train Revenue Forecasting Model
     */
    public function trainRevenueForecasting()
    {
        try {
            $result = $this->callMlApi('POST', '/train/revenue-forecasting');

            if ($result && isset($result['status']) && $result['status'] === 'success') {
                return response()->json([
                    'success' => true,
                    'message' => 'Revenue forecasting model berhasil ditraining!',
                    'data' => $result
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Gagal training model'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Train Revenue Forecasting Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Train Seasonal Pattern Model
     */
    public function trainSeasonalPattern()
    {
        try {
            $result = $this->callMlApi('POST', '/train/seasonal-pattern');

            if ($result && isset($result['status']) && $result['status'] === 'success') {
                return response()->json([
                    'success' => true,
                    'message' => 'Seasonal pattern model berhasil ditraining!',
                    'data' => $result
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Gagal training model'
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Train Seasonal Pattern Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get Menu Recommendations (AJAX)
     */
    public function getMenuRecommendations()
    {
        try {
            $result = $this->callMlApi('GET', '/predict/menu-recommendations');
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak dapat mengambil rekomendasi menu'
            ]);
        }
    }

    /**
     * Get Revenue Prediction (AJAX)
     */
    public function getRevenuePrediction()
    {
        try {
            $result = $this->callMlApi('GET', '/predict/revenue');
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak dapat mengambil prediksi revenue'
            ]);
        }
    }

    /**
     * Get Seasonal Patterns (AJAX)
     */
    public function getSeasonalPatterns()
    {
        try {
            $result = $this->callMlApi('GET', '/predict/seasonal-patterns');
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Tidak dapat mengambil analisis pola'
            ]);
        }
    }

    /**
     * Helper method to call ML API
     */
    private function callMlApi($method, $endpoint, $data = [])
    {
        try {
            $url = $this->mlApiUrl . $endpoint;

            $response = Http::timeout(30)->$method($url, $data);

            if ($response->successful()) {
                return $response->json();
            } else {
                Log::error("ML API Error: {$response->status()} - {$response->body()}");
                return null;
            }
        } catch (\Exception $e) {
            Log::error("ML API Connection Error: {$e->getMessage()}");
            return null;
        }
    }
}
