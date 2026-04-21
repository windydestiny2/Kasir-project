<div>
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="card-title mb-0">
                        <i class="fas fa-brain mr-2"></i>
                        Dashboard Machine Learning - Kedai Sugoiiyaki
                    </h3>
                    <div class="card-tools">
                        <button wire:click="refreshData" class="btn btn-light btn-sm" wire:loading.attr="disabled">
                            <i class="fas fa-sync-alt" wire:loading.class="fa-spin"></i>
                            <span wire:loading.remove>Refresh Data</span>
                            <span wire:loading>Menyegarkan...</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-info"><i class="fas fa-utensils"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Menu Recommendation</span>
                                    <span class="info-box-number">
                                        @if(isset($menuRecommendations['status']) && $menuRecommendations['status'] == 'success')
                                            {{ count($menuRecommendations['recommendations']) }} Menu
                                        @else
                                            <small class="text-muted">Belum dilatih</small>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-success"><i class="fas fa-chart-line"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Revenue Prediction</span>
                                    <span class="info-box-number">
                                        @if(isset($revenuePrediction['status']) && $revenuePrediction['status'] == 'success')
                                            Rp {{ number_format($revenuePrediction['prediction']['predicted_revenue'], 0, ',', '.') }}
                                        @else
                                            <small class="text-muted">Belum dilatih</small>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-warning"><i class="fas fa-calendar-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Seasonal Analysis</span>
                                    <span class="info-box-number">
                                        @if(isset($seasonalPatterns['status']) && $seasonalPatterns['status'] == 'success')
                                            {{ $seasonalPatterns['today_analysis']['expected_orders'] }} Orders
                                        @else
                                            <small class="text-muted">Belum dilatih</small>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="info-box bg-light">
                                <span class="info-box-icon bg-danger"><i class="fas fa-cogs"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Model Status</span>
                                    <span class="info-box-number">
                                        @if(isset($modelsStatus['models']))
                                            {{ count(array_filter($modelsStatus['models'], fn($m) => $m['status'] == 'trained')) }}/3
                                        @else
                                            <small class="text-muted">Checking...</small>
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($errorMessage)
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i>
            {{ $errorMessage }}
        </div>
    @endif

    @if($isLoading)
        <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
                <span class="sr-only">Loading...</span>
            </div>
            <p class="mt-2">Memuat data Machine Learning...</p>
        </div>
    @else
        <!-- Decision Support - TOP PRIORITY SECTION -->
        <div class="row mb-4">
            <!-- Menu Decision Support -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-purple text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-lightbulb mr-2"></i>
                            Pengambilan Keputusan - Menu
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(isset($menuInsights['status']) && $menuInsights['status'] == 'success' && isset($menuInsights['insights']) && is_array($menuInsights['insights']) && !empty($menuInsights['insights']))
                            @foreach($menuInsights['insights'] as $insight)
                                <div class="mb-4 p-3 border rounded {{ data_get($insight, 'priority') == 'high' ? 'border-danger bg-light-danger' : 'border-info bg-light-info' }}">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6 class="mb-0">{{ data_get($insight, 'title', 'Insight') }}</h6>
                                        <span class="badge badge-{{ data_get($insight, 'priority') == 'high' ? 'danger' : 'info' }}">{{ strtoupper(data_get($insight, 'priority', 'MEDIUM')) }}</span>
                                    </div>
                                    <p class="text-muted small mb-2">{{ data_get($insight, 'reasoning') ?? data_get($insight, 'summary') ?? '' }}</p>
                                    
                                    @if(isset($insight['actions']) && is_array($insight['actions']))
                                        <h6 class="text-primary mb-2"><i class="fas fa-list mr-1"></i>Tindakan:</h6>
                                        <ul class="list-unstyled small">
                                            @foreach($insight['actions'] as $action)
                                                <li><i class="fas fa-check text-success mr-1"></i>{{ data_get($action, 'action') ?? (is_array($action) ? data_get($action, 'reason') : $action) ?? $action }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if(isset($insight['supplies']) && is_array($insight['supplies']))
                                        <div class="mt-3 pt-2 border-top">
                                            <h6 class="text-warning mb-2"><i class="fas fa-warehouse mr-1"></i>Bahan Baku:</h6>
                                            @foreach($insight['supplies'] as $supply)
                                                <div class="small">
                                                    <span class="font-weight-bold">{{ $supply['menu'] }}</span>: 
                                                    {{ $supply['level'] }} ({{ $supply['expected_qty'] }} porsi)
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            <div class="mt-3 pt-3 border-top text-right">
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> Diperbarui: {{ now()->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-brain text-info fa-3x mb-3"></i>
                                <p>Analisis keputusan menu siap digunakan</p>
                                <small class="text-muted">Pastikan model ML sudah dilatih</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Revenue Decision Support -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-gavel mr-2"></i>
                            Pengambilan Keputusan - Pendapatan
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(isset($revenueInsights['status']) && $revenueInsights['status'] == 'success' && isset($revenueInsights['insights']) && is_array($revenueInsights['insights']) && !empty($revenueInsights['insights']))
                            @foreach($revenueInsights['insights'] as $insight)
                                <div class="mb-4 p-3 border rounded {{ data_get($insight, 'priority') == 'high' ? 'border-danger bg-light-danger' : 'border-info bg-light-info' }}">
                                    <div class="d-flex justify-content-between mb-2">
                                        <h6 class="mb-0">{{ data_get($insight, 'title', 'Insight') }}</h6>
                                        <span class="badge badge-{{ data_get($insight, 'priority') == 'high' ? 'danger' : 'info' }}">{{ strtoupper(data_get($insight, 'priority', 'MEDIUM')) }}</span>
                                    </div>
                                    <p class="text-muted small mb-2">{{ data_get($insight, 'reasoning') ?? data_get($insight, 'summary') ?? '' }}</p>
                                    
                                    @if(isset($insight['actions']) && is_array($insight['actions']))
                                        <h6 class="text-primary mb-2"><i class="fas fa-list mr-1"></i>Tindakan:</h6>
                                        <ul class="list-unstyled small">
                                            @foreach($insight['actions'] as $action)
                                                <li><i class="fas fa-check text-success mr-1"></i>{{ data_get($action, 'action') ?? (is_array($action) ? data_get($action, 'reason') : $action) ?? $action }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    @if(isset($insight['peak_hours']))
                                        <div class="mt-2">
                                            <h6 class="text-warning mb-1"><i class="fas fa-clock mr-1"></i>Peak Hours:</h6>
                                            <span class="badge badge-warning">{{ implode(', ', $insight['peak_hours']) }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            <div class="mt-3 pt-3 border-top text-right">
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i> Diperbarui: {{ now()->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-balance-scale text-warning fa-3x mb-3"></i>
                                <p>Analisis keputusan pendapatan siap digunakan</p>
                                <small class="text-muted">Pastikan model ML sudah dilatih</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>


        <!-- Menu Recommendations Section -->
        <div class="row mb-4">
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-utensils mr-2"></i>
                            Rekomendasi Menu Hari Ini
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(isset($menuRecommendations['status']) && $menuRecommendations['status'] == 'success')
                            <div class="mb-3">
                                <small class="text-muted">
                                    Hari: {{ $menuRecommendations['day_of_week'] == 1 ? 'Senin' :
                                           ($menuRecommendations['day_of_week'] == 2 ? 'Selasa' :
                                           ($menuRecommendations['day_of_week'] == 3 ? 'Rabu' :
                                           ($menuRecommendations['day_of_week'] == 4 ? 'Kamis' :
                                           ($menuRecommendations['day_of_week'] == 5 ? 'Jumat' :
                                           ($menuRecommendations['day_of_week'] == 6 ? 'Sabtu' : 'Minggu'))))) }}
                                    | Data Points: {{ $menuRecommendations['data_points'] }}
                                </small>
                            </div>

                            @foreach($menuRecommendations['recommendations'] as $index => $rec)
                                <div class="d-flex justify-content-between align-items-center mb-3 p-3 border rounded">
                                    <div>
                                        <h6 class="mb-1">
                                            <span class="badge badge-primary mr-2">{{ $index + 1 }}</span>
                                            {{ $rec['menu_name'] }}
                                            @if($rec['topping']) <small class="text-muted">({{ $rec['topping'] }})</small> @endif
                                            @if($rec['ukuran']) <small class="text-muted">{{ $rec['ukuran'] }}</small> @endif
                                        </h6>
                                        <small class="text-muted">
                                            {{ $rec['order_count'] }} pesanan |
                                            Rp {{ number_format($rec['total_revenue'], 0, ',', '.') }} |
                                            {{ number_format($rec['percent'], 1) }}%
                                        </small>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-success font-weight-bold">
                                            Score: {{ number_format($rec['popularity_score'], 2) }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="mt-3 pt-3 border-top">
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i>
                                    Terakhir dilatih: {{ \Carbon\Carbon::parse($menuRecommendations['last_trained'])->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                                <p>Model rekomendasi menu belum dilatih</p>
                                <small class="text-muted">Jalankan training script untuk mengaktifkan fitur ini</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Revenue Prediction Section -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-chart-line mr-2"></i>
                            Prediksi Pendapatan
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(isset($revenuePrediction['status']) && $revenuePrediction['status'] == 'success')
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="text-center">
                                        <h4 class="text-success mb-0">
                                            Rp {{ number_format($revenuePrediction['prediction']['predicted_revenue'], 0, ',', '.') }}
                                        </h4>
                                        <small class="text-muted">Prediksi Pendapatan Hari Ini</small>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="border p-2 rounded text-center">
                                        <div class="text-info font-weight-bold">
                                            Rp {{ number_format($revenuePrediction['prediction']['confidence_interval']['lower'], 0, ',', '.') }}
                                        </div>
                                        <small class="text-muted">Batas Bawah (95% CI)</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="border p-2 rounded text-center">
                                        <div class="text-info font-weight-bold">
                                            Rp {{ number_format($revenuePrediction['prediction']['confidence_interval']['upper'], 0, ',', '.') }}
                                        </div>
                                        <small class="text-muted">Batas Atas (95% CI)</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6>Detail Prediksi:</h6>
                                <ul class="list-unstyled">
                                    <li><i class="fas fa-calendar-day text-primary"></i> Hari: {{ $revenuePrediction['prediction']['day_of_week'] == 1 ? 'Senin' : ($revenuePrediction['prediction']['day_of_week'] == 2 ? 'Selasa' : ($revenuePrediction['prediction']['day_of_week'] == 3 ? 'Rabu' : ($revenuePrediction['prediction']['day_of_week'] == 4 ? 'Kamis' : ($revenuePrediction['prediction']['day_of_week'] == 5 ? 'Jumat' : ($revenuePrediction['prediction']['day_of_week'] == 6 ? 'Sabtu' : 'Minggu'))))) }}</li>
                                    <li><i class="fas fa-shopping-cart text-success"></i> Estimasi Order: {{ $revenuePrediction['prediction']['expected_orders'] }}</li>
                                </ul>
                            </div>

                            <div class="row">
                                <div class="col-4">
                                    <div class="text-center p-2 bg-light rounded">
                                        <div class="font-weight-bold text-primary">
                                            Rp {{ number_format($revenuePrediction['prediction']['week']['predicted_revenue'], 0, ',', '.') }}
                                        </div>
                                        <small>Minggu Ini</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="text-center p-2 bg-light rounded">
                                        <div class="font-weight-bold text-primary">
                                            Rp {{ number_format($revenuePrediction['prediction']['month']['predicted_revenue'], 0, ',', '.') }}
                                        </div>
                                        <small>Bulan Ini</small>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="text-center p-2 bg-light rounded">
                                        <div class="font-weight-bold text-primary">
                                            Rp {{ number_format($revenuePrediction['prediction']['next_month']['predicted_revenue'], 0, ',', '.') }}
                                        </div>
                                        <small>Bulan Depan</small>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 pt-3 border-top">
                                <div class="row">
                                    <div class="col-6">
                                        <small class="text-muted">
                                            <i class="fas fa-chart-bar"></i>
                                            R² Score: {{ number_format($revenuePrediction['model_info']['r2_score'], 3) }}
                                        </small>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted">
                                            <i class="fas fa-database"></i>
                                            Data Points: {{ $revenuePrediction['model_info']['data_points'] }}
                                        </small>
                                    </div>
                                </div>
                                <small class="text-muted d-block">
                                    <i class="fas fa-clock"></i>
                                    Terakhir dilatih: {{ \Carbon\Carbon::parse($revenuePrediction['model_info']['last_trained'])->format('d/m/Y H:i') }}
                                </small>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                                <p>Model prediksi pendapatan belum dilatih</p>
                                <small class="text-muted">Jalankan training script untuk mengaktifkan fitur ini</small>
                            </div>
                        @endif
                    </div>
                </div>

                Revenue Decision Support
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-header bg-warning text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-gavel mr-2"></i>
                                Pengambilan Keputusan - Pendapatan
                            </h5>
                        </div>
                        <div class="card-body">
@if(isset($revenueInsights['status']) && $revenueInsights['status'] == 'success' && isset($revenueInsights['insights']) && is_array($revenueInsights['insights']) && !empty($revenueInsights['insights']))
                            @foreach($revenueInsights['insights'] as $insight)
                                    <div class="mb-4 p-3 border rounded {{ data_get($insight, 'priority') == 'high' ? 'border-danger bg-light-danger' : 'border-info bg-light-info' }}">
                                        <div class="d-flex justify-content-between mb-2">
                                            <h6 class="mb-0">{{ data_get($insight, 'title', 'Insight') }}</h6>
                                            <span class="badge badge-{{ data_get($insight, 'priority') == 'high' ? 'danger' : 'info' }}">{{ strtoupper(data_get($insight, 'priority', 'MEDIUM')) }}</span>
                                        </div>
                                        <p class="text-muted small mb-2">{{ data_get($insight, 'reasoning') ?? data_get($insight, 'summary') ?? '' }}</p>
                                        
                                        @if(isset($insight['actions']) && is_array($insight['actions']))
                                            <h6 class="text-primary mb-2"><i class="fas fa-list mr-1"></i>Tindakan:</h6>
                                            <ul class="list-unstyled small">
                                                @foreach($insight['actions'] as $action)
                                                    <li><i class="fas fa-check text-success mr-1"></i>{{ is_array($action) ? ($action['action'] ?? $action['reason'] ?? '') : $action }}</li>
                                                @endforeach
                                            </ul>
                                        @endif

                                        @if(isset($insight['peak_hours']))
                                            <div class="mt-2">
                                                <h6 class="text-warning mb-1"><i class="fas fa-clock mr-1"></i>Peak Hours:</h6>
                                                <span class="badge badge-warning">{{ implode(', ', $insight['peak_hours']) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                                <div class="mt-3 pt-3 border-top text-right">
                                    <small class="text-muted">
                                        <i class="fas fa-clock"></i> Diperbarui: {{ now()->format('d/m/Y H:i') }}
                                    </small>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-balance-scale text-warning fa-3x mb-3"></i>
                                    <p>Analisis keputusan pendapatan siap digunakan</p>
                                    <small class="text-muted">Pastikan model ML sudah dilatih</small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Seasonal Patterns Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-warning text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-calendar-alt mr-2"></i>
                            Analisis Pola Musiman & Tren Penjualan
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(isset($seasonalPatterns['status']) && $seasonalPatterns['status'] == 'success')
                            <div class="row">
                                <!-- Today Analysis -->
                                <div class="col-lg-4">
                                    <div class="card border-primary">
                                        <div class="card-header bg-primary text-white">
                                            <h6 class="mb-0">Analisis Hari Ini</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <strong>{{ $seasonalPatterns['today_analysis']['day_name'] }}</strong>
                                            </div>
                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <div class="p-2 bg-light rounded">
                                                        <div class="font-weight-bold text-primary">
                                                            {{ $seasonalPatterns['today_analysis']['expected_orders'] }}
                                                        </div>
                                                        <small>Estimasi Order</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="p-2 bg-light rounded">
                                                        <div class="font-weight-bold text-success">
                                                            Rp {{ number_format($seasonalPatterns['today_analysis']['expected_revenue'], 0, ',', '.') }}
                                                        </div>
                                                        <small>Estimasi Revenue</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-3">
                                                <small class="text-muted">
                                                    <i class="fas fa-clock"></i>
                                                    Peak Hours: {{ implode(', ', $seasonalPatterns['today_analysis']['peak_hours']) }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Best Performing Day -->
                                <div class="col-lg-4">
                                    <div class="card border-success">
                                        <div class="card-header bg-success text-white">
                                            <h6 class="mb-0">Hari Terbaik</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <strong>{{ $seasonalPatterns['best_performing_day']['day_name'] }}</strong>
                                            </div>
                                            <div class="row text-center">
                                                <div class="col-6">
                                                    <div class="p-2 bg-light rounded">
                                                        <div class="font-weight-bold text-primary">
                                                            {{ $seasonalPatterns['best_performing_day']['avg_orders_per_day'] }}
                                                        </div>
                                                        <small>Rata-rata Order</small>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="p-2 bg-light rounded">
                                                        <div class="font-weight-bold text-success">
                                                            Rp {{ number_format($seasonalPatterns['best_performing_day']['avg_revenue_per_day'], 0, ',', '.') }}
                                                        </div>
                                                        <small>Rata-rata Revenue</small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Trend Analysis -->
                                <div class="col-lg-4">
                                    <div class="card border-info">
                                        <div class="card-header bg-info text-white">
                                            <h6 class="mb-0">Analisis Tren</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <strong class="{{ $seasonalPatterns['trend_analysis']['trend_direction'] == 'up' ? 'text-success' : 'text-danger' }}">
                                                    Tren {{ $seasonalPatterns['trend_analysis']['trend_direction'] == 'up' ? 'Naik' : 'Turun' }}
                                                </strong>
                                            </div>
                                            <div class="text-center">
                                                <div class="p-2 bg-light rounded">
                                                    <div class="font-weight-bold {{ $seasonalPatterns['trend_analysis']['trend_percentage'] > 0 ? 'text-success' : 'text-danger' }}">
                                                        {{ number_format($seasonalPatterns['trend_analysis']['trend_percentage'], 1) }}%
                                                    </div>
                                                    <small>Perubahan dalam {{ $seasonalPatterns['trend_analysis']['analysis_period_days'] }} hari</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 pt-3 border-top">
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i>
                                    Terakhir dilatih: {{ \Carbon\Carbon::parse($seasonalPatterns['model_info']['last_trained'])->format('d/m/Y H:i') }}
                                    | Data Points: {{ $seasonalPatterns['model_info']['data_points'] }}
                                </small>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-exclamation-triangle text-warning fa-3x mb-3"></i>
                                <p>Model analisis pola musiman belum dilatih</p>
                                <small class="text-muted">Jalankan training script untuk mengaktifkan fitur ini</small>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Models Status Section -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-cogs mr-2"></i>
                            Status Model Machine Learning
                        </h5>
                    </div>
                    <div class="card-body">
                        @if(isset($modelsStatus['models']))
                            <div class="row">
                                @foreach($modelsStatus['models'] as $modelName => $status)
                                    <div class="col-lg-4 mb-3">
                                        <div class="card {{ $status['status'] == 'trained' ? 'border-success' : 'border-warning' }}">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <h6 class="mb-1">
                                                            @switch($modelName)
                                                                @case('menu_recommendation')
                                                                    Rekomendasi Menu
                                                                    @break
                                                                @case('revenue_forecasting')
                                                                    Prediksi Pendapatan
                                                                    @break
                                                                @case('seasonal_pattern')
                                                                    Pola Musiman
                                                                    @break
                                                                @default
                                                                    {{ ucwords(str_replace('_', ' ', $modelName)) }}
                                                            @endswitch
                                                        </h6>
                                                        <small class="text-muted">
                                                            @if($status['status'] == 'trained')
                                                                <i class="fas fa-check-circle text-success"></i>
                                                                Dilatih: {{ \Carbon\Carbon::parse($status['last_trained'])->format('d/m/Y H:i') }}
                                                            @else
                                                                <i class="fas fa-exclamation-triangle text-warning"></i>
                                                                Belum dilatih
                                                            @endif
                                                        </small>
                                                    </div>
                                                    <div class="text-right">
                                                        @if($status['status'] == 'trained')
                                                            <span class="badge badge-success">Active</span>
                                                            @if(isset($status['data_points']))
                                                                <br><small class="text-muted">{{ $status['data_points'] }} data points</small>
                                                            @endif
                                                            @if(isset($status['r2_score']))
                                                                <br><small class="text-muted">R²: {{ number_format($status['r2_score'], 3) }}</small>
                                                            @endif
                                                            @if(isset($status['trend_percentage']))
                                                                <br><small class="text-muted">Trend: {{ number_format($status['trend_percentage'], 1) }}%</small>
                                                            @endif
                                                        @else
                                                            <span class="badge badge-warning">Inactive</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-spinner fa-spin text-primary fa-3x mb-3"></i>
                                <p>Memeriksa status model...</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>