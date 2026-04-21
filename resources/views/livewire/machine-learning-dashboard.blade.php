<div>
    <!-- API Status Card -->
    <div class="row">
        <div class="col-12">
            <div class="card {{ $apiStatus['status'] === 'connected' ? 'card-success' : 'card-danger' }}">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-server mr-2"></i>
                        ML API Status
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" wire:click="refreshData">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    @if($loading)
                        <div class="text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            <p class="mt-2">Loading ML data...</p>
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Status:</strong>
                                <span class="badge {{ $apiStatus['status'] === 'connected' ? 'badge-success' : 'badge-danger' }}">
                                    {{ ucfirst($apiStatus['status']) }}
                                </span>
                            </div>
                            <div class="col-md-6">
                                <strong>Message:</strong> {{ $apiStatus['message'] ?? 'Unknown' }}
                            </div>
                        </div>
                        @if($error)
                            <div class="alert alert-danger mt-3">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                {{ $error }}
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(!$loading && $apiStatus['status'] === 'connected')
    <!-- Menu Recommendations -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-utensils mr-2"></i>
                        Menu Recommendations
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">
                        Persentase menunjukkan pangsa <strong>order item rows</strong> untuk menu ini terhadap total order item rows pada hari yang sama.
                        Jadi 14.9% berarti menu ini mewakili sekitar 14.9% dari baris order item teratas hari ini.
                    </p>
                    @if(empty($menuRecommendations))
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            No menu recommendations available. Please train the menu recommendation model first.
                        </div>
                    @else
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="menuSelect">Select Menu to View Tomorrow's Prediction:</label>
                                    <select class="form-control" id="menuSelect" wire:change="updateMenuSelection($event.target.value)">
                                        <option value="">-- Choose a menu item --</option>
                                        @foreach($menuRecommendations as $menu)
                                            <option value="{{ $menu['product_id'] ?? $loop->index }}">
                                                {{ $menu['product_name'] ?? 'Unknown' }} (Score: {{ number_format($menu['score'] ?? 0, 2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        @if(!empty($selectedMenuId) && !empty($menuTomorrowPrediction))
                        <div class="alert alert-success mb-3">
                            <h6>Tomorrow's Prediction for Selected Menu:</h6>
                            <ul class="mb-0">
                                <li><strong>Product:</strong> {{ $menuTomorrowPrediction['product_name'] ?? 'N/A' }}</li>
                                <li><strong>Tomorrow's Score:</strong> {{ number_format($menuTomorrowPrediction['score'] ?? 0, 3) }}</li>
                                <li><strong>Predicted Sales:</strong> {{ $menuTomorrowPrediction['predicted_sales'] ?? 0 }}</li>
                                <li><strong>Confidence:</strong> {{ number_format(($menuTomorrowPrediction['confidence'] ?? 0) * 100, 1) }}%</li>
                            </ul>
                        </div>
                        @endif

                        <div class="row">
                            @foreach($menuRecommendations as $recommendation)
                            <div class="col-md-4 mb-3">
                                <div class="card border-primary">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $recommendation['product_name'] ?? 'Unknown Product' }}</h5>
                                        <p class="card-text">
                                            <strong>Score:</strong> {{ number_format($recommendation['score'] ?? 0, 3) }}<br>
                                            <strong>Confidence:</strong> {{ number_format(($recommendation['confidence'] ?? 0) * 100, 1) }}%<br>
                                            <strong>Predicted Sales:</strong> {{ $recommendation['predicted_sales'] ?? 0 }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Menu Decision Support Insights -->
    @if(!empty($menuInsights))
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-success">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Pengambilan Keputusan - Menu & Promosi
                    </h3>
                </div>
                <div class="card-body">
                    @foreach($menuInsights as $insight)
                        <div class="card mb-3 {{ $insight['priority'] === 'high' ? 'border-danger' : 'border-info' }}">
                            <div class="card-header {{ $insight['priority'] === 'high' ? 'bg-danger' : 'bg-info' }} text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-{{ $insight['type'] === 'co_purchase' ? 'link' : 'cubes' }} mr-2"></i>
                                    {{ $insight['title'] }}
                                </h6>
                            </div>
                            <div class="card-body">
                                <!-- Reasoning -->
                                <div class="mb-3">
                                    <h6 class="font-weight-bold">💭 Analisis:</h6>
                                    <p class="text-muted">{{ $insight['reasoning'] }}</p>
                                </div>

                                <!-- Actions -->
                                @if(!empty($insight['actions']))
                                <div class="mb-3">
                                    <h6 class="font-weight-bold">✅ Rekomendasi Aksi:</h6>
                                    <ul class="list-unstyled">
                                        @foreach($insight['actions'] as $action)
                                        <li class="mb-2">
                                            <div class="badge badge-{{ $action['priority'] === 1 ? 'danger' : 'warning' }} mr-2">
                                                Priority {{ $action['priority'] ?? 'N/A' }}
                                            </div>
                                            <strong>{{ $action['action'] ?? $action }}</strong>
                                            @if(is_array($action) && isset($action['detail']))
                                                <br><small class="text-muted">{{ $action['detail'] }}</small>
                                            @endif
                                            @if(is_array($action) && isset($action['impact']))
                                                <br><small class="text-success">📈 Impact: {{ $action['impact'] }}</small>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif

                                <!-- Supplies -->
                                @if(!empty($insight['supplies']))
                                <div class="mb-3">
                                    <h6 class="font-weight-bold">📦 Persiapan Bahan Baku:</h6>
                                    <table class="table table-sm table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>Menu</th>
                                                <th>Level</th>
                                                <th>Jumlah</th>
                                                <th>Persentase</th>
                                                <th>Catatan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($insight['supplies'] as $supply)
                                            <tr>
                                                <td><strong>{{ $supply['menu'] }}</strong></td>
                                                <td>
                                                    <span class="badge badge-{{ $supply['level'] === 'BANYAK' ? 'danger' : ($supply['level'] === 'NORMAL' ? 'warning' : 'success') }}">
                                                        {{ $supply['level'] }}
                                                    </span>
                                                </td>
                                                <td>{{ $supply['expected_qty'] }} porsi</td>
                                                <td>{{ $supply['percentage'] }}</td>
                                                <td><small>{{ $supply['note'] }}</small></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Revenue Predictions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line mr-2"></i>
                        Revenue Predictions
                    </h3>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">
                        Prediksi pendapatan minggu &amp; bulan depan berdasarkan model forecasting dari data historis order. 
                        Ubah &#39;Expected Orders&#39; untuk simulasi skenario berbeda. 
                        Trend analysis menunjukkan arah perubahan pendapatan terbaru (increasing/decreasing).
                    </p>
                    @if(empty($revenuePredictions))
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            No revenue predictions available. Please train the revenue forecasting model first.
                        </div>
                    @else
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expectedOrders">Expected Orders (Enter as integer):</label>
                                    <input type="number" 
                                           class="form-control" 
                                           id="expectedOrders" 
                                           wire:change="updateExpectedOrders($event.target.value)"
                                           placeholder="Enter expected number of orders"
                                           min="0"
                                           step="1">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text">Next Week Prediction</span>
                                        <span class="info-box-number">Rp {{ number_format($revenuePredictions['next_week_prediction'] ?? 0, 0, ',', '.') }}</span>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" style="width: {{ min(100, ($revenuePredictions['confidence'] ?? 0) * 100) }}%"></div>
                                        </div>
                                        <span class="progress-description">
                                            Confidence: {{ number_format(($revenuePredictions['confidence'] ?? 0) * 100, 1) }}%
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box bg-light">
                                    <div class="info-box-content">
                                        <span class="info-box-text">Next Month Prediction</span>
                                        <span class="info-box-number">Rp {{ number_format($revenuePredictions['next_month_prediction'] ?? 0, 0, ',', '.') }}</span>
                                        <div class="progress">
                                            <div class="progress-bar bg-info" style="width: {{ min(100, ($revenuePredictions['monthly_confidence'] ?? 0) * 100) }}%"></div>
                                        </div>
                                        <span class="progress-description">
                                            Confidence: {{ number_format(($revenuePredictions['monthly_confidence'] ?? 0) * 100, 1) }}%
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if(isset($revenuePredictions['trend']))
                        <div class="row mt-3">
                            <div class="col-12">
                                <h5>Revenue Trend Analysis</h5>
                                <div class="alert alert-{{ $revenuePredictions['trend']['direction'] === 'increasing' ? 'success' : ($revenuePredictions['trend']['direction'] === 'decreasing' ? 'warning' : 'info') }}">
                                    <i class="fas fa-{{ $revenuePredictions['trend']['direction'] === 'increasing' ? 'arrow-up' : ($revenuePredictions['trend']['direction'] === 'decreasing' ? 'arrow-down' : 'minus') }} mr-2"></i>
                                    Revenue trend: {{ ucfirst($revenuePredictions['trend']['direction']) }}
                                    ({{ number_format($revenuePredictions['trend']['change_percent'], 1) }}% change)
                                </div>
                            </div>
                        </div>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Decision Support Insights -->
    @if(!empty($revenueInsights))
    <div class="row">
        <div class="col-12">
            <div class="card card-outline card-warning">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-lightbulb mr-2"></i>
                        Pengambilan Keputusan - Operasional & Staffing
                    </h3>
                </div>
                <div class="card-body">
                    @foreach($revenueInsights as $insight)
                        <div class="card mb-3 {{ $insight['priority'] === 'high' ? 'border-danger' : 'border-warning' }}">
                            <div class="card-header {{ $insight['priority'] === 'high' ? 'bg-danger' : 'bg-warning' }} text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-{{ $insight['type'] === 'revenue_performance' ? 'chart-bar' : ($insight['type'] === 'staffing' ? 'users' : 'cogs') }} mr-2"></i>
                                    {{ $insight['title'] }}
                                </h6>
                            </div>
                            <div class="card-body">
                                <!-- Status Badge -->
                                @if(isset($insight['status']))
                                <div class="mb-3">
                                    <span class="badge badge-{{ 
                                        $insight['status'] === 'SANGAT BAGUS' ? 'success' : 
                                        ($insight['status'] === 'BAGUS' ? 'info' : 
                                        ($insight['status'] === 'MENURUN' ? 'warning' : 'danger'))
                                    }} p-2">
                                        📊 Status: {{ $insight['status'] }}
                                    </span>
                                </div>
                                @elseif(isset($insight['summary']))
                                <div class="mb-3">
                                    <span class="badge badge-info p-2">
                                        {{ $insight['summary'] }}
                                    </span>
                                </div>
                                @endif

                                <!-- Reasoning -->
                                <div class="mb-3">
                                    <h6 class="font-weight-bold">💭 Analisis:</h6>
                                    <p class="text-muted">{{ $insight['reasoning'] }}</p>
                                </div>

                                <!-- Performance Metrics -->
                                @if(!empty($insight['performance_metrics']))
                                <div class="mb-3">
                                    <h6 class="font-weight-bold">📈 Metrik Performa:</h6>
                                    <table class="table table-sm table-bordered">
                                        <tbody>
                                            <tr>
                                                <td><strong>Prediksi Hari Ini</strong></td>
                                                <td>Rp {{ number_format($insight['performance_metrics']['predicted'], 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Rata-rata Historis</strong></td>
                                                <td>Rp {{ number_format($insight['performance_metrics']['average'], 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Selisih</strong></td>
                                                <td class="{{ $insight['performance_metrics']['difference'] >= 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ $insight['performance_metrics']['difference'] >= 0 ? '+' : '' }}Rp {{ number_format($insight['performance_metrics']['difference'], 0, ',', '.') }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Persentase Perubahan</strong></td>
                                                <td class="{{ $insight['performance_metrics']['percentage_diff'] >= 0 ? 'text-success' : 'text-danger' }}">
                                                    {{ $insight['performance_metrics']['percentage_diff'] >= 0 ? '+' : '' }}{{ number_format($insight['performance_metrics']['percentage_diff'], 1) }}%
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Confidence Range (95%)</strong></td>
                                                <td>Rp {{ number_format($insight['performance_metrics']['confidence_lower'], 0, ',', '.') }} - Rp {{ number_format($insight['performance_metrics']['confidence_upper'], 0, ',', '.') }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                @endif

                                <!-- Actions -->
                                @if(!empty($insight['actions']))
                                <div class="mb-3">
                                    <h6 class="font-weight-bold">✅ Rekomendasi Aksi:</h6>
                                    @foreach($insight['actions'] as $action)
                                        <div class="alert alert-light border-left border-{{ 
                                            isset($action['priority']) && $action['priority'] === 'HIGH' ? 'danger' : 'warning'
                                        }} mb-2">
                                            <h6 class="mb-2">{{ $action['action'] ?? $action }}</h6>
                                            @if(is_array($action))
                                                @if(isset($action['reason']))
                                                    <small class="text-muted"><strong>Alasan:</strong> {{ $action['reason'] }}</small><br>
                                                @endif
                                                @if(isset($action['detail']))
                                                    <small class="text-muted"><strong>Detail:</strong> {{ $action['detail'] }}</small><br>
                                                @endif
                                                @if(isset($action['estimated_staff']))
                                                    <small class="text-info"><strong>Estimasi Staff:</strong> {{ $action['estimated_staff'] }} orang</small><br>
                                                @endif
                                                @if(isset($action['impact']))
                                                    <small class="text-success"><strong>Impact:</strong> {{ $action['impact'] }}</small><br>
                                                @endif
                                                @if(isset($action['price_breakdown']))
                                                    <small class="text-info"><strong>Breakdown Harga:</strong> {{ $action['price_breakdown'] }}</small><br>
                                                @endif
                                                @if(isset($action['note']))
                                                    <small class="text-warning"><strong>Catatan:</strong> {{ $action['note'] }}</small><br>
                                                @endif
                                                @if(isset($action['preparation']))
                                                    <small class="text-info"><strong>Persiapan:</strong> {{ $action['preparation'] }}</small><br>
                                                @endif
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                @endif

                                <!-- Peak Hours -->
                                @if(!empty($insight['peak_hours']))
                                <div class="mb-3">
                                    <h6 class="font-weight-bold">⏰ Jam-jam Puncak Hari Ini:</h6>
                                    <div class="btn-group" role="group">
                                        @foreach($insight['peak_hours'] as $hour)
                                            <button type="button" class="btn btn-sm btn-outline-primary">{{ $hour }}</button>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Seasonal Patterns -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        Seasonal Patterns & Peak Hours
                    </h3>
                </div>
                <div class="card-body">
                    @if(empty($seasonalPatterns))
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            No seasonal patterns available. Please train the seasonal pattern model first.
                        </div>
                    @else
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Today's Statistics</h5>
                                <div class="list-group">
                                    <div class="list-group-item">
                                        <strong>Average Orders per Day:</strong> {{ $seasonalPatterns['today_stats']['avg_orders_per_day'] ?? 0 }}
                                    </div>
                                    <div class="list-group-item">
                                        <strong>Average Revenue per Day:</strong> Rp {{ number_format($seasonalPatterns['today_stats']['avg_revenue_per_day'] ?? 0, 0, ',', '.') }}
                                    </div>
                                    <div class="list-group-item">
                                        <strong>Median Orders:</strong> {{ $seasonalPatterns['today_stats']['median_orders_per_day'] ?? 0 }}
                                    </div>
                                    <div class="list-group-item">
                                        <strong>Median Revenue:</strong> Rp {{ number_format($seasonalPatterns['today_stats']['median_revenue_per_day'] ?? 0, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>Peak Hours Today</h5>
                                @if(empty($seasonalPatterns['peak_hours']))
                                    <div class="alert alert-warning">
                                        No peak hours data available for today.
                                    </div>
                                @else
                                    <div class="list-group">
                                        @foreach($seasonalPatterns['peak_hours'] as $peak)
                                        <div class="list-group-item">
                                            <strong>{{ $peak['hour'] ?? 'Unknown' }}:00</strong>
                                            <br>
                                            <small>Orders: {{ $peak['avg_orders'] ?? 0 }} | Revenue: Rp {{ number_format($peak['avg_revenue'] ?? 0, 0, ',', '.') }}</small>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Model Status -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-cogs mr-2"></i>
                        Model Training Status
                    </h3>
                </div>
                <div class="card-body">
                    @if(empty($modelStatus))
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            No model status information available.
                        </div>
                    @else
                        <div class="row">
                            @foreach($modelStatus as $model => $status)
                            <div class="col-md-4 mb-3">
                                <div class="card {{ $status['trained'] ? 'border-success' : 'border-warning' }}">
                                    <div class="card-body text-center">
                                        <i class="fas fa-{{ $status['trained'] ? 'check-circle' : 'exclamation-triangle' }} fa-2x mb-2 {{ $status['trained'] ? 'text-success' : 'text-warning' }}"></i>
                                        <h6>{{ ucfirst(str_replace('_', ' ', $model)) }}</h6>
                                        <p class="mb-1">
                                            <strong>Status:</strong>
                                            <span class="badge {{ $status['trained'] ? 'badge-success' : 'badge-warning' }}">
                                                {{ $status['trained'] ? 'Trained' : 'Not Trained' }}
                                            </span>
                                        </p>
                                        @if($status['last_trained'])
                                            <small class="text-muted">
                                                Last trained: {{ \Carbon\Carbon::parse($status['last_trained'])->format('d M Y H:i') }}
                                            </small>
                                        @endif
                                        @if(isset($status['accuracy']))
                                            <br>
                                            <small class="text-muted">
                                                Accuracy: {{ number_format($status['accuracy'] * 100, 1) }}%
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>