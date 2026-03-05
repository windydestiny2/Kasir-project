<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'ML Dashboard' }}</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('asset/plugins/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('asset/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('asset/dist/css/adminlte.min.css') }}">
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <!-- jQuery -->
    <script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body class="sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Header -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('ml.dashboard') }}" class="nav-link">
                    <i class="fas fa-brain"></i> ML Dashboard
                </a>
            </li>
        </ul>
    </nav>

    <!-- Sidebar -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <span class="brand-text font-weight-light">Sugoiiyaki</span>
        </a>
        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('ml.dashboard') }}" class="nav-link active">
                            <i class="nav-icon fas fa-brain"></i>
                            <p>ML Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('logout') }}" class="nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Logout</p>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <!-- Content Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"><i class="fas fa-brain"></i> ML Dashboard</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <div class="content">
        <div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-brain"></i> Machine Learning Dashboard
                    </h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">

                    @if(isset($error))
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Warning:</strong> {{ $error }}
                        </div>
                    @endif

                    <!-- Model Status Section -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4><i class="fas fa-info-circle"></i> Model Status</h4>
                            <div class="row" id="model-status">
                                @if($modelsStatus)
                                    @foreach($modelsStatus as $model => $status)
                                        <div class="col-md-4">
                                            @php
                                                $isTrained = isset($status['status']) && $status['status'] === 'trained';
                                                $displayName = ucfirst(str_replace('_', ' ', $model));
                                            @endphp
                                            <div class="small-box bg-{{ $isTrained ? 'success' : 'warning' }}">
                                                <div class="inner">
                                                    <h3>{{ $isTrained ? 'OK' : 'N/A' }}</h3>
                                                    <p>{{ $displayName }}</p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-{{ $isTrained ? 'check-circle' : 'exclamation-triangle' }}"></i>
                                                </div>
                                                <a href="#" class="small-box-footer">
                                                    Status: {{ $isTrained ? 'Trained' : 'Not Trained' }}
                                                    @if(isset($status['data_points']))
                                                        ({{ $status['data_points'] }} data points)
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            Model status tidak tersedia
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Training Buttons -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h4><i class="fas fa-cogs"></i> Training Models</h4>
                            <div class="row">
                                <div class="col-md-4">
                                    <button id="train-menu" class="btn btn-primary btn-block">
                                        <i class="fas fa-utensils"></i> Train Menu Recommendation
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button id="train-revenue" class="btn btn-success btn-block">
                                        <i class="fas fa-chart-line"></i> Train Revenue Forecasting
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button id="train-seasonal" class="btn btn-info btn-block">
                                        <i class="fas fa-calendar-alt"></i> Train Seasonal Pattern
                                    </button>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="auto-refresh-toggle" checked>
                                    <label class="custom-control-label" for="auto-refresh-toggle">
                                        <small>Auto-refresh predictions every 30 seconds</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Predictions Section -->
                    <div class="row">
                        <!-- Menu Recommendations -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-utensils"></i> Menu Recommendations
                                    </h5>
                                </div>
                                <div class="card-body" id="menu-recommendations">
                                    @if($menuRecommendations && isset($menuRecommendations['status']) && $menuRecommendations['status'] === 'success')
                                        @if(isset($menuRecommendations['recommendations']) && is_array($menuRecommendations['recommendations']))
                                            <div class="list-group">
                                                @foreach($menuRecommendations['recommendations'] as $item)
                                                    <div class="list-group-item">
                                                        <strong>{{ $item['menu_name'] ?? 'N/A' }}</strong>
                                                        <br>
                                                        <small class="text-muted">
                                                            Confidence: {{ isset($item['popularity_score']) ? number_format($item['popularity_score'], 1) : 'N/A' }}%
                                                        </small>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-muted">Belum ada rekomendasi tersedia</p>
                                        @endif
                                    @else
                                        <p class="text-muted">Tidak ada data rekomendasi</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Revenue Prediction -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-chart-line"></i> Revenue Prediction
                                    </h5>
                                </div>
                                <div class="card-body" id="revenue-prediction">
                                    @if($revenuePrediction && isset($revenuePrediction['status']) && $revenuePrediction['status'] === 'success' && isset($revenuePrediction['prediction']))
                                        <div class="text-center">
                                            <h2 class="text-success">
                                                Rp {{ number_format($revenuePrediction['prediction']['predicted_revenue'], 0, ',', '.') }}
                                            </h2>
                                            <p class="text-muted">Prediksi Revenue Hari Ini</p>
                                            @if(isset($revenuePrediction['prediction']['confidence_interval']))
                                                <small>Confidence Interval: Rp {{ number_format($revenuePrediction['prediction']['confidence_interval']['lower'], 0, ',', '.') }} - Rp {{ number_format($revenuePrediction['prediction']['confidence_interval']['upper'], 0, ',', '.') }}</small>
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-muted">Tidak ada data prediksi</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Seasonal Patterns -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">
                                        <i class="fas fa-calendar-alt"></i> Seasonal Patterns
                                    </h5>
                                </div>
                                <div class="card-body" id="seasonal-patterns">
                                    @if($seasonalPatterns && isset($seasonalPatterns['status']) && $seasonalPatterns['status'] === 'success')
                                        <div class="mb-3">
                                            @if(isset($seasonalPatterns['best_performing_day']))
                                                <div class="alert alert-success">
                                                    <strong>Best Performing Day:</strong> {{ $seasonalPatterns['best_performing_day']['day_name'] ?? 'N/A' }}
                                                    <br>
                                                    <small>Orders: {{ $seasonalPatterns['best_performing_day']['total_orders'] ?? 'N/A' }}, Revenue: Rp {{ number_format($seasonalPatterns['best_performing_day']['total_revenue'] ?? 0, 0, ',', '.') }}</small>
                                                </div>
                                            @endif

                                            @if(isset($seasonalPatterns['today_analysis']))
                                                <div class="alert alert-info">
                                                    <strong>Today's Analysis:</strong> {{ $seasonalPatterns['today_analysis']['day_name'] ?? 'N/A' }}
                                                    <br>
                                                    <small>Expected Orders: {{ $seasonalPatterns['today_analysis']['expected_orders'] ?? 'N/A' }}, Expected Revenue: Rp {{ number_format($seasonalPatterns['today_analysis']['expected_revenue'] ?? 0, 0, ',', '.') }}</small>
                                                </div>
                                            @endif

                                            @if(isset($seasonalPatterns['trend_analysis']))
                                                <div class="alert alert-warning">
                                                    <strong>Trend Analysis:</strong>
                                                    <br>
                                                    <small>Direction: {{ $seasonalPatterns['trend_analysis']['trend_direction'] ?? 'N/A' }}, Change: {{ number_format($seasonalPatterns['trend_analysis']['trend_percentage'] ?? 0, 1) }}%</small>
                                                </div>
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-muted">Tidak ada data pola</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for AJAX calls -->
<script>
$(document).ready(function() {
    // Setup CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Train Menu Recommendation
    $('#train-menu').click(function() {
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Training...');

        $.post('/ml/train/menu-recommendation', {_token: $('meta[name="csrf-token"]').attr('content')}, function(data) {
            if (data.success) {
                toastr.success(data.message);
                location.reload();
            } else {
                toastr.error(data.message);
            }
        }).fail(function() {
            toastr.error('Gagal training model');
        }).always(function() {
            $('#train-menu').prop('disabled', false).html('<i class="fas fa-utensils"></i> Train Menu Recommendation');
        });
    });

    // Train Revenue Forecasting
    $('#train-revenue').click(function() {
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Training...');

        $.post('/ml/train/revenue-forecasting', {_token: $('meta[name="csrf-token"]').attr('content')}, function(data) {
            if (data.success) {
                toastr.success(data.message);
                location.reload();
            } else {
                toastr.error(data.message);
            }
        }).fail(function() {
            toastr.error('Gagal training model');
        }).always(function() {
            $('#train-revenue').prop('disabled', false).html('<i class="fas fa-chart-line"></i> Train Revenue Forecasting');
        });
    });

    // Train Seasonal Pattern
    $('#train-seasonal').click(function() {
        $(this).prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Training...');

        $.post('/ml/train/seasonal-pattern', {_token: $('meta[name="csrf-token"]').attr('content')}, function(data) {
            if (data.success) {
                toastr.success(data.message);
                location.reload();
            } else {
                toastr.error(data.message);
            }
        }).fail(function() {
            toastr.error('Gagal training model');
        }).always(function() {
            $('#train-seasonal').prop('disabled', false).html('<i class="fas fa-calendar-alt"></i> Train Seasonal Pattern');
        });
    });

    // Auto refresh predictions every 30 seconds
    let autoRefreshInterval = setInterval(function() {
        if (!$('#auto-refresh-toggle').is(':checked')) {
            return; // Skip if auto-refresh is disabled
        }

        // Refresh menu recommendations
        $.get('/ml/predict/menu-recommendations', function(data) {
            if (data.status === 'success' && data.recommendations) {
                let html = '<div class="list-group">';
                data.recommendations.forEach(function(item) {
                    html += '<div class="list-group-item">' +
                            '<strong>' + item.product_name + '</strong><br>' +
                            '<small class="text-muted">Confidence: ' + (item.confidence * 100).toFixed(1) + '%</small>' +
                            '</div>';
                });
                html += '</div>';
                $('#menu-recommendations').html(html);
            }
        }).fail(function() {
            console.log('Failed to refresh menu recommendations');
        });

        // Refresh revenue prediction
        $.get('/ml/predict/revenue', function(data) {
            if (data.status === 'success' && data.prediction) {
                let html = '<div class="text-center">' +
                          '<h2 class="text-success">Rp ' + data.prediction.predicted_revenue.toLocaleString('id-ID') + '</h2>' +
                          '<p class="text-muted">Prediksi Revenue Hari Ini</p>';
                if (data.prediction.confidence_interval) {
                    html += '<small>Confidence Interval: Rp ' + data.prediction.confidence_interval.lower.toLocaleString('id-ID') + ' - Rp ' + data.prediction.confidence_interval.upper.toLocaleString('id-ID') + '</small>';
                }
                html += '</div>';
                $('#revenue-prediction').html(html);
            }
        }).fail(function() {
            console.log('Failed to refresh revenue prediction');
        });

        // Refresh seasonal patterns
        $.get('/ml/predict/seasonal-patterns', function(data) {
            if (data.status === 'success') {
                let html = '<div class="mb-3">';
                if (data.best_performing_day) {
                    html += '<div class="alert alert-success">' +
                            '<strong>Best Performing Day:</strong> ' + data.best_performing_day.day_name +
                            '<br><small>Orders: ' + data.best_performing_day.total_orders + ', Revenue: Rp ' + data.best_performing_day.total_revenue.toLocaleString('id-ID') + '</small>' +
                            '</div>';
                }
                if (data.today_analysis) {
                    html += '<div class="alert alert-info">' +
                            '<strong>Today\'s Analysis:</strong> ' + data.today_analysis.day_name +
                            '<br><small>Expected Orders: ' + data.today_analysis.expected_orders + ', Expected Revenue: Rp ' + data.today_analysis.expected_revenue.toLocaleString('id-ID') + '</small>' +
                            '</div>';
                }
                if (data.trend_analysis) {
                    html += '<div class="alert alert-warning">' +
                            '<strong>Trend Analysis:</strong>' +
                            '<br><small>Direction: ' + data.trend_analysis.trend_direction + ', Change: ' + data.trend_analysis.trend_percentage.toFixed(1) + '%</small>' +
                            '</div>';
                }
                html += '</div>';
                $('#seasonal-patterns').html(html);
            }
        }).fail(function() {
            console.log('Failed to refresh seasonal patterns');
        });
    }, 30000); // 30 seconds

    // Handle auto-refresh toggle
    $('#auto-refresh-toggle').change(function() {
        if ($(this).is(':checked')) {
            toastr.info('Auto-refresh enabled');
        } else {
            toastr.info('Auto-refresh disabled');
        }
    });
});
</script>

        </div><!-- /.container-fluid -->
        </div><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Footer -->
    <footer class="main-footer">
        <strong>Version 1.0.0</strong>
    </footer>
</div><!-- /.wrapper -->

<!-- Bootstrap JS -->
<script src="{{ asset('asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE JS -->
<script src="{{ asset('asset/dist/js/adminlte.min.js') }}"></script>

</body>
</html>