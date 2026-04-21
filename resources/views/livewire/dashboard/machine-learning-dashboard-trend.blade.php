<div class="row mb-4">
    <!-- Trend Analysis Decision Support - Landscape -->
    <div class="col-12">
        <div class="card h-100">
            <div class="card-header bg-gradient-danger text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-trend-up mr-2"></i>
                    Analisis Tren & Decision Making - Landscape View
                </h5>
            </div>
            <div class="card-body">
                @if(isset($seasonalPatterns['status']) && $seasonalPatterns['status'] == 'success')
                    <div class="row text-center">
                        <!-- Current Trend -->
                        <div class="col-md-3 mb-4">
                            <div class="bg-gradient-success text-white p-4 rounded-lg shadow">
                                <i class="fas fa-trending-up fa-2x mb-2"></i>
                                <h4>{{ number_format($seasonalPatterns['trend_analysis']['trend_percentage'], 1) }}%</h4>
                                <p class="mb-0">Trend {{ $seasonalPatterns['trend_analysis']['trend_direction'] == 'up' ? 'Naik' : 'Turun' }}</p>
                                <small class="opacity-75">({{ $seasonalPatterns['trend_analysis']['analysis_period_days'] }} hari)</small>
                            </div>
                        </div>

                        <!-- Peak Hours -->
                        <div class="col-md-3 mb-4">
                            <div class="bg-gradient-warning text-white p-4 rounded-lg shadow">
                                <i class="fas fa-clock fa-2x mb-2"></i>
                                <h4>{{ implode(', ', $seasonalPatterns['today_analysis']['peak_hours']) }}</h4>
                                <p class="mb-0">Peak Hours Hari Ini</p>
                                <small class="opacity-75">{{ $seasonalPatterns['today_analysis']['day_name'] }}</small>
                            </div>
                        </div>

                        <!-- Best Day -->
                        <div class="col-md-3 mb-4">
                            <div class="bg-gradient-info text-white p-4 rounded-lg shadow">
                                <i class="fas fa-trophy fa-2x mb-2"></i>
                                <h4>{{ $seasonalPatterns['best_performing_day']['day_name'] }}</h4>
                                <p class="mb-0">Hari Terbaik</p>
                                <small class="opacity-75">Rp {{ number_format($seasonalPatterns['best_performing_day']['avg_revenue_per_day'], 0, ',', '.') }}/hari</small>
                            </div>
                        </div>

                        <!-- Expected Today -->
                        <div class="col-md-3 mb-4">
                            <div class="bg-gradient-primary text-white p-4 rounded-lg shadow">
                                <i class="fas fa-calendar-day fa-2x mb-2"></i>
                                <h4>{{ $seasonalPatterns['today_analysis']['expected_orders'] }} Orders</h4>
                                <p class="mb-0">Estimasi {{ $seasonalPatterns['today_analysis']['day_name'] }}</p>
                                <small class="opacity-75">Rp {{ number_format($seasonalPatterns['today_analysis']['expected_revenue'], 0, ',', '.') }}</small>
                            </div>
                        </div>
                    </div>

                    <!-- Decision Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="text-primary mb-3"><i class="fas fa-lightbulb mr-2"></i> Decision Making Berdasarkan Tren:</h6>
                            @if($seasonalPatterns['trend_analysis']['trend_percentage'] > 5)
                                <div class="alert alert-success">
                                    <i class="fas fa-arrow-up mr-2"></i>
                                    <strong>Tren Naik Kuat:</strong> Tingkatkan stok & staff. Promosikan menu top performer. Target revenue +15%.
                                </div>
                            @elseif($seasonalPatterns['trend_analysis']['trend_percentage'] > 0)
                                <div class="alert alert-info">
                                    <i class="fas fa-arrow-up-right-from-square mr-2"></i>
                                    <strong>Tren Stabil Naik:</strong> Maintain operasional normal. Monitor peak hours {{ implode(', ', $seasonalPatterns['today_analysis']['peak_hours']) }}.
                                </div>
                            @elseif($seasonalPatterns['trend_analysis']['trend_percentage'] > -5)
                                <div class="alert alert-warning">
                                    <i class="fas fa-minus mr-2"></i>
                                    <strong>Tren Stabil:</strong> Fokus efisiensi cost. Persiapkan {{ $seasonalPatterns['today_analysis']['expected_orders'] }} orders.
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    <i class="fas fa-arrow-down mr-2"></i>
                                    <strong>Tren Turun:</strong> Optimasi menu high-margin. Kurangi stok low-performer. Review pricing.
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 pt-3 border-top text-right">
                        <small class="text-muted">
                            <i class="fas fa-clock"></i> Diperbarui: {{ now()->format('d/m/Y H:i') }}
                            | Last Trained: {{ \Carbon\Carbon::parse($seasonalPatterns['model_info']['last_trained'])->format('d/m/Y H:i') }}
                        </small>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                        <p>Model analisis tren siap digunakan</p>
                        <small class="text-muted">Latih model seasonal pattern terlebih dahulu</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
