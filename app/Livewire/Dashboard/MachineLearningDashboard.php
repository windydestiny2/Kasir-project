<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class MachineLearningDashboard extends Component
{
    public $menuRecommendations = [];
    public $revenuePrediction = [];
    public $seasonalPatterns = [];
    public $modelsStatus = [];
    public $menuInsights = [];
    public $revenueInsights = [];
    public $isLoading = true;
    public $errorMessage = '';

    public function mount()
    {
        $this->loadMLData();
    }

    public function loadMLData()
    {
        $this->isLoading = true;
        $this->errorMessage = '';

        try {
            // Load menu recommendations
            $menuResponse = Http::timeout(10)->get('http://127.0.0.1:5003/predict/menu-recommendations');
            if ($menuResponse->successful()) {
                $this->menuRecommendations = $menuResponse->json();
            }

            // Load revenue prediction
            $revenueResponse = Http::timeout(10)->get('http://127.0.0.1:5003/predict/revenue');
            if ($revenueResponse->successful()) {
                $this->revenuePrediction = $revenueResponse->json();
            }

            // Load seasonal patterns
            $seasonalResponse = Http::timeout(10)->get('http://127.0.0.1:5003/predict/seasonal-patterns');
            if ($seasonalResponse->successful()) {
                $this->seasonalPatterns = $seasonalResponse->json();
            }

            // Load models status
            $statusResponse = Http::timeout(10)->get('http://127.0.0.1:5003/models/status');
            if ($statusResponse->successful()) {
                $this->modelsStatus = $statusResponse->json();
            }

            // Load menu decision insights
            $menuInsightsResponse = Http::timeout(10)->get('http://127.0.0.1:5003/insights/menu-recommendations');
            if ($menuInsightsResponse->successful()) {
                $this->menuInsights = $menuInsightsResponse->json();
            }

            // Load revenue decision insights
            $revenueInsightsResponse = Http::timeout(10)->get('http://127.0.0.1:5003/insights/revenue');
            if ($revenueInsightsResponse->successful()) {
                $this->revenueInsights = $revenueInsightsResponse->json();
            }

        } catch (\Exception $e) {
            $this->errorMessage = 'Tidak dapat terhubung ke ML Engine. Pastikan service Flask berjalan.';
            \Log::error('ML Dashboard Error: ' . $e->getMessage());
        }

        $this->isLoading = false;
    }

    public function refreshData()
    {
        $this->loadMLData();
        $this->dispatch('show-toast', ['message' => 'Data ML berhasil diperbarui', 'type' => 'success']);
    }

    public function render()
    {
        return view('livewire.dashboard.machine-learning-dashboard');
    }
}

