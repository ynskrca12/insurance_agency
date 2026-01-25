@extends('layouts.app')

@section('title', 'Satış Performans Raporu')

@push('styles')
<style>
    .page-header {
        padding: 12px 0;
        margin-bottom: 1rem;
    }

    .filter-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        margin-bottom: 1.5rem;
    }

    .filter-card .card-body {
        padding: 1.5rem;
    }

    .stat-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .stat-card.primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-color: #667eea;
        color: #ffffff;
    }

    .stat-card.success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border-color: #28a745;
        color: #ffffff;
    }

    .stat-card.info {
        background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);
        border-color: #0dcaf0;
        color: #ffffff;
    }

    .stat-card.warning {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        border-color: #ffc107;
        color: #000000;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.8125rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
        opacity: 0.9;
    }

    .stat-meta {
        font-size: 0.75rem;
        margin-top: 0.5rem;
        opacity: 0.8;
    }

    .growth-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        padding: 0.25rem 0.5rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .growth-badge.positive {
        background: rgba(40, 167, 69, 0.15);
        color: #28a745;
    }

    .growth-badge.negative {
        background: rgba(220, 53, 69, 0.15);
        color: #dc3545;
    }

    .chart-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .chart-card .card-header {
        background: #fafafa;
        border-bottom: 1px solid #e8e8e8;
        padding: 1.25rem 1.5rem;
    }

    .chart-title {
        color: #212529;
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .chart-card .card-body {
        padding: 1.5rem;
    }

    .chart-container {
        position: relative;
        height: 300px;
    }

    .leaderboard-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        margin-bottom: 0.75rem;
        transition: all 0.3s ease;
    }

    .leaderboard-item:hover {
        transform: translateX(5px);
        border-color: #667eea;
        box-shadow: 0 2px 8px rgba(102, 126, 234, 0.15);
    }

    .rank-badge {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 3rem;
        height: 3rem;
        border-radius: 50%;
        font-weight: 700;
        font-size: 1.25rem;
        margin-right: 1rem;
    }

    .rank-badge.gold {
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        color: #000000;
        box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
    }

    .rank-badge.silver {
        background: linear-gradient(135deg, #c0c0c0 0%, #e8e8e8 100%);
        color: #000000;
        box-shadow: 0 4px 12px rgba(192, 192, 192, 0.4);
    }

    .rank-badge.bronze {
        background: linear-gradient(135deg, #cd7f32 0%, #e59866 100%);
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(205, 127, 50, 0.4);
    }

    .rank-badge.default {
        background: #f8f9fa;
        color: #6c757d;
        border: 2px solid #dee2e6;
    }

    .rep-info {
        flex: 1;
    }

    .rep-name {
        font-size: 1.125rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.25rem;
    }

    .rep-stats {
        display: flex;
        gap: 1.5rem;
        font-size: 0.875rem;
        color: #6c757d;
    }

    .rep-stat {
        display: flex;
        align-items: center;
        gap: 0.375rem;
    }

    .target-progress {
        margin-top: 1rem;
    }

    .progress {
        height: 2rem;
        border-radius: 8px;
        background: #f0f0f0;
    }

    .progress-bar {
        border-radius: 8px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .portfolio-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .portfolio-item {
        background: #f8f9fa;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.25rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .portfolio-item:hover {
        transform: translateY(-2px);
        border-color: #667eea;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.1);
    }

    .portfolio-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 0.25rem;
    }

    .portfolio-label {
        font-size: 0.8125rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.5rem;
        }

        .chart-container {
            height: 250px;
        }

        .rep-stats {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h4 mb-2 fw-bold text-dark">
                    <i class="bi bi-trophy me-2"></i>
                    @if($viewMode === 'personal')
                        Kişisel Performans
                    @else
                        Satış Performans Raporu
                    @endif
                </h1>
                @if($selectedRep)
                    <p class="text-muted mb-0">
                        <i class="bi bi-person-circle me-1"></i>
                        {{ $selectedRep->name }}
                    </p>
                @endif
            </div>
            <a href="{{ route('reports.index') }}" class="btn btn-light">
                <i class="bi bi-arrow-left me-2"></i>Geri
            </a>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="filter-card card">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.salesPerformance') }}">
                <div class="row g-3 align-items-end">
                    @if($viewMode === 'manager')
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Satış Temsilcisi</label>
                        <select name="rep_id" class="form-select">
                            @foreach($salesReps as $rep)
                                <option value="{{ $rep->id }}" {{ $rep->id == $selectedRep->id ? 'selected' : '' }}>
                                    {{ $rep->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Başlangıç</label>
                        <input type="date" class="form-control" name="start_date" value="{{ $startDate }}">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Bitiş</label>
                        <input type="date" class="form-control" name="end_date" value="{{ $endDate }}">
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel me-2"></i>Filtrele
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Kişisel Metrikler -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card primary">
                <div class="stat-value">{{ number_format($personalMetrics['total_policies']) }}</div>
                <div class="stat-label">Toplam Poliçe</div>
                <div class="stat-meta">
                    @if($personalMetrics['policy_growth'] > 0)
                        <span class="growth-badge positive">
                            <i class="bi bi-arrow-up"></i>
                            %{{ number_format(abs($personalMetrics['policy_growth']), 1) }}
                        </span>
                    @elseif($personalMetrics['policy_growth'] < 0)
                        <span class="growth-badge negative">
                            <i class="bi bi-arrow-down"></i>
                            %{{ number_format(abs($personalMetrics['policy_growth']), 1) }}
                        </span>
                    @endif
                    önceki aya göre
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card success">
                <div class="stat-value">{{ number_format($personalMetrics['total_commission'], 2) }} ₺</div>
                <div class="stat-label">Toplam Komisyon</div>
                <div class="stat-meta">
                    Ort: {{ number_format($personalMetrics['avg_policy_value'], 2) }} ₺ / poliçe
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card info">
                <div class="stat-value">%{{ number_format($personalMetrics['collection_rate'], 1) }}</div>
                <div class="stat-label">Tahsilat Oranı</div>
                <div class="stat-meta">
                    <i class="bi bi-{{ $personalMetrics['collection_rate'] >= 70 ? 'check-circle' : 'exclamation-circle' }}"></i>
                    {{ $personalMetrics['collection_rate'] >= 70 ? 'Hedef üstü' : 'Geliştirilmeli' }}
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card warning">
                <div class="stat-value">%{{ number_format($personalMetrics['avg_commission_rate'], 1) }}</div>
                <div class="stat-label">Ort. Komisyon Oranı</div>
                <div class="stat-meta">
                    {{ number_format($personalMetrics['total_premium'], 2) }} ₺ prim
                </div>
            </div>
        </div>
    </div>

    <!-- Hedef vs Gerçekleşme -->
    <div class="chart-card card mb-4">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-bullseye"></i>
                <span>Hedef vs Gerçekleşme</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="target-progress">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="fw-semibold">Aylık Hedef: {{ number_format($targetVsActual['target_premium'], 2) }} ₺</span>
                            <span class="fw-semibold">Gerçekleşen: {{ number_format($targetVsActual['actual_premium'], 2) }} ₺</span>
                        </div>
                        <div class="progress">
                            <div class="progress-bar bg-{{ $targetVsActual['achievement_rate'] >= 100 ? 'success' : ($targetVsActual['achievement_rate'] >= 70 ? 'warning' : 'danger') }}"
                                 style="width: {{ min(100, $targetVsActual['achievement_rate']) }}%">
                                %{{ number_format($targetVsActual['achievement_rate'], 1) }}
                            </div>
                        </div>
                        @if($targetVsActual['remaining'] > 0)
                            <small class="text-muted d-block mt-2">
                                <i class="bi bi-info-circle me-1"></i>
                                Hedefe {{ number_format($targetVsActual['remaining'], 2) }} ₺ kaldı
                            </small>
                        @else
                            <small class="text-success d-block mt-2">
                                <i class="bi bi-check-circle me-1"></i>
                                Hedef aşıldı! Tebrikler! 🎉
                            </small>
                        @endif
                    </div>
                </div>
                <div class="col-md-4 text-center">
                    <div class="stat-value text-{{ $targetVsActual['achievement_rate'] >= 100 ? 'success' : 'warning' }}">
                        %{{ number_format($targetVsActual['achievement_rate'], 0) }}
                    </div>
                    <div class="stat-label text-muted">Başarı Oranı</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Müşteri Portföy Analizi -->
        <div class="col-lg-6">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-people"></i>
                        <span>Müşteri Portföy Analizi</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="portfolio-grid">
                        <div class="portfolio-item">
                            <div class="portfolio-value">{{ number_format($customerPortfolio['total_customers']) }}</div>
                            <div class="portfolio-label">Toplam Müşteri</div>
                        </div>
                        <div class="portfolio-item">
                            <div class="portfolio-value">{{ number_format($customerPortfolio['active_customers']) }}</div>
                            <div class="portfolio-label">Aktif Müşteri</div>
                        </div>
                        <div class="portfolio-item">
                            <div class="portfolio-value">{{ number_format($customerPortfolio['new_customers_30d']) }}</div>
                            <div class="portfolio-label">Yeni (30 Gün)</div>
                        </div>
                        <div class="portfolio-item">
                            <div class="portfolio-value">%{{ number_format($customerPortfolio['retention_rate'], 0) }}</div>
                            <div class="portfolio-label">Retention</div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Ortalama LTV:</span>
                            <span class="fw-bold text-primary">{{ number_format($customerPortfolio['avg_ltv'], 2) }} ₺</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">Poliçeli Müşteri:</span>
                            <span class="fw-bold">{{ number_format($customerPortfolio['customers_with_policies']) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Branş Bazlı Performans -->
        <div class="col-lg-6">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-pie-chart"></i>
                        <span>Branş Bazlı Performans</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="branchChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Aylık Performans Trendi -->
    <div class="chart-card card mb-4">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-graph-up"></i>
                <span>Aylık Performans Trendi (Son 6 Ay)</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Leaderboard (Sadece Manager Görünümünde) -->
    @if($viewMode === 'manager')
    <div class="chart-card card">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-award"></i>
                <span>Leaderboard - En İyi Performans Gösteren Temsilciler</span>
            </h5>
        </div>
        <div class="card-body">
            @foreach($leaderboard as $index => $rep)
                <div class="leaderboard-item">
                    <div class="rank-badge {{ $index === 0 ? 'gold' : ($index === 1 ? 'silver' : ($index === 2 ? 'bronze' : 'default')) }}">
                        {{ $index + 1 }}
                    </div>
                    <div class="rep-info">
                        <div class="rep-name">{{ $rep->creator->name ?? 'Sistem' }}</div>
                        <div class="rep-stats">
                            <div class="rep-stat">
                                <i class="bi bi-file-earmark-text"></i>
                                <span>{{ number_format($rep->policy_count) }} poliçe</span>
                            </div>
                            <div class="rep-stat">
                                <i class="bi bi-currency-exchange"></i>
                                <span>{{ number_format($rep->total_commission, 2) }} ₺ komisyon</span>
                            </div>
                            <div class="rep-stat">
                                <i class="bi bi-percent"></i>
                                <span>%{{ number_format($rep->collection_rate, 1) }} tahsilat</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
Chart.defaults.font.family = 'Inter, system-ui, -apple-system, sans-serif';
Chart.defaults.font.size = 13;
Chart.defaults.color = '#495057';

// Branş Bazlı Performans
const branchCtx = document.getElementById('branchChart').getContext('2d');
new Chart(branchCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($branchPerformance->pluck('policy_type')->map(function($type) {
            $labels = ['kasko' => 'Kasko', 'trafik' => 'Trafik', 'konut' => 'Konut', 'dask' => 'DASK', 'saglik' => 'Sağlık', 'hayat' => 'Hayat', 'tss' => 'TSS'];
            return $labels[$type] ?? $type;
        })) !!},
        datasets: [{
            data: {!! json_encode($branchPerformance->pluck('total_commission')) !!},
            backgroundColor: [
                'rgba(102, 126, 234, 0.85)',
                'rgba(118, 75, 162, 0.85)',
                'rgba(255, 206, 86, 0.85)',
                'rgba(75, 192, 192, 0.85)',
                'rgba(153, 102, 255, 0.85)',
                'rgba(255, 159, 64, 0.85)',
                'rgba(201, 203, 207, 0.85)'
            ],
            borderColor: '#ffffff',
            borderWidth: 3,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 15,
                    font: { size: 12 },
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                borderRadius: 8,
                callbacks: {
                    label: function(context) {
                        const value = context.parsed;
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((value / total) * 100).toFixed(1);
                        return context.label + ': ' + value.toLocaleString('tr-TR', {
                            minimumFractionDigits: 2
                        }) + ' ₺ (' + percentage + '%)';
                    }
                }
            }
        },
        cutout: '65%'
    }
});

// Aylık Performans Trendi
const trendCtx = document.getElementById('trendChart').getContext('2d');
new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlyTrend->pluck('month')) !!},
        datasets: [
            {
                label: 'Komisyon (₺)',
                data: {!! json_encode($monthlyTrend->pluck('commission')) !!},
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderColor: 'rgb(102, 126, 234)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: 'rgb(102, 126, 234)',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
            },
            {
                label: 'Poliçe Sayısı',
                data: {!! json_encode($monthlyTrend->pluck('policies')) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                borderColor: 'rgb(40, 167, 69)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 5,
                pointBackgroundColor: 'rgb(40, 167, 69)',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                yAxisID: 'y1',
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
            mode: 'index',
            intersect: false,
        },
        plugins: {
            legend: {
                display: true,
                position: 'top',
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                borderRadius: 8,
            }
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)',
                },
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString('tr-TR') + ' ₺';
                    }
                }
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                grid: {
                    drawOnChartArea: false,
                },
                ticks: {
                    callback: function(value) {
                        return value + ' adet';
                    }
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});
</script>
@endpush