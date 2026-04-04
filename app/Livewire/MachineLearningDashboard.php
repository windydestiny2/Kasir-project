<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MachineLearningDashboard extends Component
{
    public $loading = true;
    public $error = null;
    public $apiStatus = [];
    public $menuRecommendations = [];
    public $revenuePredictions = [];
    public $seasonalPatterns = [];
    public $modelStatus = [];
    public $expectedOrders = 0;
    public $selectedMenuId = null;
    public $menuTomorrowPrediction = [];

    public function mount()
    {
        $this->loadMLData();
    }

    public function loadMLData()
    {
        $this->loading = true;
        $this->error = null;

        try {
            // Flask API URL - adjust if needed
            $flaskUrl = env('ML_API_URL', 'http://127.0.0.1:5003');

            // Test API connectivity
            $this->apiStatus = $this->testApiConnection($flaskUrl);

            if ($this->apiStatus['status'] === 'connected') {
                // Load menu recommendations
                $this->menuRecommendations = $this->fetchMenuRecommendations($flaskUrl);

                // Load revenue predictions
                $this->revenuePredictions = $this->fetchRevenuePredictions($flaskUrl);

                // Load seasonal patterns
                $this->seasonalPatterns = $this->fetchSeasonalPatterns($flaskUrl);

                // Load model status
                $this->modelStatus = $this->fetchModelStatus($flaskUrl);
            }
        } catch (\Exception $e) {
            $this->error = 'Failed to load ML data: ' . $e->getMessage();
            $this->apiStatus = ['status' => 'error', 'message' => $e->getMessage()];
            Log::error('ML Dashboard Error: ' . $e->getMessage());
        }

        $this->loading = false;
    }

    private function testApiConnection($baseUrl)
    {
        try {
            $response = Http::timeout(10)->get($baseUrl . '/health');
            if ($response->successful()) {
                return ['status' => 'connected', 'message' => 'ML API is running'];
            } else {
                return ['status' => 'error', 'message' => 'API returned status ' . $response->status()];
            }
        } catch (\Exception $e) {
            return ['status' => 'error', 'message' => 'Cannot connect to ML API: ' . $e->getMessage()];
        }
    }

    private function fetchMenuRecommendations($baseUrl)
    {
        try {
            $response = Http::timeout(30)->get($baseUrl . '/predict/menu-recommendations');
            if ($response->successful()) {
                $data = $response->json();
                // If response is directly the recommendations array or has 'recommendations' key
                if (is_array($data) && isset($data['recommendations'])) {
                    return $data['recommendations'];
                } elseif (is_array($data)) {
                    return $data;
                }
                return [];
            }
            return [];
        } catch (\Exception $e) {
            Log::error('Failed to fetch menu recommendations: ' . $e->getMessage());
            return [];
        }
    }

    private function fetchRevenuePredictions($baseUrl)
    {
        try {
            $response = Http::timeout(30)->get($baseUrl . '/predict/revenue');
            if ($response->successful()) {
                $data = $response->json();
                return $data;
            }
            return [];
        } catch (\Exception $e) {
            Log::error('Failed to fetch revenue predictions: ' . $e->getMessage());
            return [];
        }
    }

    private function fetchSeasonalPatterns($baseUrl)
    {
        try {
            $response = Http::timeout(30)->get($baseUrl . '/predict/seasonal-patterns');
            if ($response->successful()) {
                $data = $response->json();
                return $data;
            }
            return [];
        } catch (\Exception $e) {
            Log::error('Failed to fetch seasonal patterns: ' . $e->getMessage());
            return [];
        }
    }

    private function fetchModelStatus($baseUrl)
    {
        try {
            $response = Http::timeout(30)->get($baseUrl . '/models/status');
            if ($response->successful()) {
                $data = $response->json();
                return $data;
            }
            return [];
        } catch (\Exception $e) {
            Log::error('Failed to fetch model status: ' . $e->getMessage());
            return [];
        }
    }

    public function refreshData()
    {
        $this->loadMLData();
        $this->dispatch('data-refreshed');
    }

    public function updateExpectedOrders($value)
    {
        $this->expectedOrders = (int) $value;
        // Fetch updated revenue predictions based on expected orders
        try {
            $flaskUrl = env('ML_API_URL', 'http://127.0.0.1:5003');
            $response = Http::timeout(30)->get($flaskUrl . '/predict/revenue', [
                'expected_orders' => $this->expectedOrders
            ]);
            if ($response->successful()) {
                $this->revenuePredictions = $response->json();
            }
        } catch (\Exception $e) {
            Log::error('Failed to update revenue predictions: ' . $e->getMessage());
        }
    }

    public function updateMenuSelection($value)
    {
        $this->selectedMenuId = $value;
        // Fetch tomorrow's prediction for selected menu
        try {
            $flaskUrl = env('ML_API_URL', 'http://127.0.0.1:5003');
            // Calculate tomorrow's day of week (1=Monday, 7=Sunday)
            $tomorrowDayOfWeek = (now()->addDay()->dayOfWeek % 7) + 1;
            $response = Http::timeout(30)->get($flaskUrl . '/predict/menu-recommendations', [
                'day_of_week' => $tomorrowDayOfWeek
            ]);
            if ($response->successful()) {
                $data = $response->json();
                // Find the specific menu item from the response
                if (is_array($data)) {
                    foreach ($data as $item) {
                        if (($item['product_id'] ?? $item['id'] ?? null) == $value) {
                            $this->menuTomorrowPrediction = $item;
                            break;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch menu tomorrow prediction: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.machine-learning-dashboard');
    }
}