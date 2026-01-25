@extends('layouts.app')

@section('title', 'Müşteri Analiz Raporu')

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

    .segment-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .segment-card {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .segment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .segment-card.vip {
        border-left: 4px solid #ffd700;
        background: linear-gradient(135deg, #fffbf0 0%, #ffffff 100%);
    }

    .segment-card.risk {
        border-left: 4px solid #dc3545;
        background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
    }

    .segment-card.potential {
        border-left: 4px solid #0dcaf0;
        background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%);
    }

    .segment-card.active {
        border-left: 4px solid #28a745;
        background: linear-gradient(135deg, #f0fff4 0%, #ffffff 100%);
    }

    .segment-card.passive {
        border-left: 4px solid #6c757d;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    }

    .segment-icon {
        font-size: 2rem;
        margin-bottom: 0.75rem;
    }

    .segment-card.vip .segment-icon { color: #ffd700; }
    .segment-card.risk .segment-icon { color: #dc3545; }
    .segment-card.potential .segment-icon { color: #0dcaf0; }
    .segment-card.active .segment-icon { color: #28a745; }
    .segment-card.passive .segment-icon { color: #6c757d; }

    .segment-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        line-height: 1;
    }

    .segment-label {
        font-size: 0.875rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .table-modern {
        margin-bottom: 0;
    }

    .table-modern thead {
        background: #fafafa;
        border-bottom: 2px solid #e8e8e8;
    }

    .table-modern thead th {
        border: none;
        color: #495057;
        font-weight: 600;
        font-size: 0.8125rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 1.25rem;
        white-space: nowrap;
    }

    .table-modern tbody td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #f5f5f5;
    }

    .table-modern tbody tr:hover {
        background: #fafafa;
    }

    .rank-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2rem;
        height: 2rem;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.875rem;
    }

    .rank-badge.gold {
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        color: #000000;
    }

    .rank-badge.silver {
        background: linear-gradient(135deg, #c0c0c0 0%, #e8e8e8 100%);
        color: #000000;
    }

    .rank-badge.bronze {
        background: linear-gradient(135deg, #cd7f32 0%, #e59866 100%);
        color: #ffffff;
    }

    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.5rem;
        }

        .segment-value {
            font-size: 1.5rem;
        }

        .chart-container {
            height: 250px;
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
                    <i class="bi bi-people me-2"></i>Müşteri Analiz Raporu
                </h1>
                <p class="text-muted mb-0">
                    <i class="bi bi-info-circle me-1"></i>
                    Detaylı müşteri segmentasyonu ve analiz
                </p>
            </div>
            <a href="{{ route('reports.index') }}" class="btn btn-light">
                <i class="bi bi-arrow-left me-2"></i>Geri
            </a>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="filter-card card">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.customers') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-5 col-md-6">
                        <label class="form-label">Başlangıç Tarihi</label>
                        <input type="date" class="form-control" name="start_date" value="{{ $startDate }}">
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <label class="form-label">Bitiş Tarihi</label>
                        <input type="date" class="form-control" name="end_date" value="{{ $endDate }}">
                    </div>
                    <div class="col-lg-2 col-md-12">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-funnel me-2"></i>Filtrele
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Genel İstatistikler -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card primary">
                <div class="stat-value">{{ number_format($stats['total_customers']) }}</div>
                <div class="stat-label">Toplam Müşteri</div>
                <div class="stat-meta">
                    <i class="bi bi-plus-circle me-1"></i>
                    {{ number_format($stats['new_customers_30d']) }} yeni (30 gün)
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card success">
                <div class="stat-value">{{ number_format($stats['active_customers']) }}</div>
                <div class="stat-label">Aktif Müşteri</div>
                <div class="stat-meta">
                    %{{ number_format(($stats['total_customers'] > 0 ? ($stats['active_customers'] / $stats['total_customers']) * 100 : 0), 1) }} oran
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card info">
                <div class="stat-value">{{ number_format($stats['customers_with_policies']) }}</div>
                <div class="stat-label">Poliçeli Müşteri</div>
                <div class="stat-meta">
                    Ort: {{ number_format($stats['avg_policies_per_customer'], 1) }} poliçe/müşteri
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card warning">
                <div class="stat-value">%{{ number_format($stats['contact_quality'], 0) }}</div>
                <div class="stat-label">İletişim Kalitesi</div>
                <div class="stat-meta">
                    {{ number_format($stats['with_email']) }} email, {{ number_format($stats['with_phone']) }} telefon
                </div>
            </div>
        </div>
    </div>

    <!-- Segment Analizi -->
    <div class="chart-card card mb-4">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-diagram-3"></i>
                <span>Müşteri Segmentasyonu</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="segment-grid">
                <div class="segment-card vip">
                    <div class="segment-icon">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="segment-value">{{ number_format($segments['vip']) }}</div>
                    <div class="segment-label">VIP Müşteri</div>
                    <small class="text-muted d-block mt-2">5+ poliçe veya 50K+ prim</small>
                </div>
                <div class="segment-card active">
                    <div class="segment-icon">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div class="segment-value">{{ number_format($segments['active']) }}</div>
                    <div class="segment-label">Aktif Müşteri</div>
                    <small class="text-muted d-block mt-2">Son 6 ayda poliçe var</small>
                </div>
                <div class="segment-card risk">
                    <div class="segment-icon">
                        <i class="bi bi-exclamation-triangle-fill"></i>
                    </div>
                    <div class="segment-value">{{ number_format($segments['risk']) }}</div>
                    <div class="segment-label">Risk Müşteri</div>
                    <small class="text-muted d-block mt-2">6+ aydır yeni poliçe yok</small>
                </div>
                <div class="segment-card potential">
                    <div class="segment-icon">
                        <i class="bi bi-lightning-fill"></i>
                    </div>
                    <div class="segment-value">{{ number_format($segments['potential']) }}</div>
                    <div class="segment-label">Potansiyel</div>
                    <small class="text-muted d-block mt-2">Henüz müşteri değil</small>
                </div>
                <div class="segment-card passive">
                    <div class="segment-icon">
                        <i class="bi bi-dash-circle-fill"></i>
                    </div>
                    <div class="segment-value">{{ number_format($segments['passive']) }}</div>
                    <div class="segment-label">Pasif Müşteri</div>
                    <small class="text-muted d-block mt-2">Hiç poliçesi yok</small>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row g-4 mb-4">
        <!-- Müşteri Büyüme Trendi -->
        <div class="col-lg-8">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-graph-up"></i>
                        <span>Müşteri Büyüme Trendi (Son 12 Ay)</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="growthChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Churn Analizi -->
        <div class="col-lg-4">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-person-x"></i>
                        <span>Churn Analizi</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="stat-value text-danger">
                            %{{ number_format($churnAnalysis['churn_rate'], 1) }}
                        </div>
                        <div class="stat-label text-muted">Churn Oranı</div>
                        <small class="text-muted d-block mt-2">
                            {{ number_format($churnAnalysis['churned_count']) }} müşteri kaybedildi
                        </small>
                    </div>

                    @if($churnAnalysis['lost_reasons']->isNotEmpty())
                    <div class="mt-4">
                        <h6 class="text-muted mb-3">En Sık Kayıp Nedenleri:</h6>
                        @foreach($churnAnalysis['lost_reasons'] as $reason)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted small">{{ ucfirst($reason->lost_reason) }}</span>
                            <span class="badge bg-danger">{{ $reason->count }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Demografik Dağılım -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-calendar-range"></i>
                        <span>Yaş Dağılımı</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="ageChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-geo-alt"></i>
                        <span>Şehir Dağılımı (Top 10)</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="cityChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- LTV Analizi & Top Spenders -->
    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-currency-exchange"></i>
                        <span>LTV Analizi</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="stat-value text-success">
                            {{ number_format($ltvAnalysis['avg_ltv'], 2) }} ₺
                        </div>
                        <div class="stat-label text-muted">Ortalama LTV</div>
                    </div>
                    <div class="text-center">
                        <div class="stat-value text-primary" style="font-size: 1.5rem;">
                            {{ number_format($ltvAnalysis['total_ltv'], 2) }} ₺
                        </div>
                        <div class="stat-label text-muted">Toplam LTV</div>
                        <small class="text-muted d-block mt-2">
                            Tüm müşterilerin toplam değeri
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-trophy"></i>
                        <span>En Yüksek Prim Ödeyenler (Top 10)</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">Sıra</th>
                                    <th>Müşteri</th>
                                    <th class="text-end">Poliçe Sayısı</th>
                                    <th class="text-end">Toplam Prim</th>
                                    <th class="text-end">Ort. Prim</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topSpenders as $index => $customer)
                                <tr>
                                    <td>
                                        @if($index === 0)
                                            <span class="rank-badge gold">1</span>
                                        @elseif($index === 1)
                                            <span class="rank-badge silver">2</span>
                                        @elseif($index === 2)
                                            <span class="rank-badge bronze">3</span>
                                        @else
                                            <span class="text-muted fw-semibold">{{ $index + 1 }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <strong>{{ $customer->name }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                <i class="bi bi-telephone me-1"></i>{{ $customer->phone }}
                                                @if($customer->city)
                                                    <i class="bi bi-geo-alt ms-2 me-1"></i>{{ $customer->city }}
                                                @endif
                                            </small>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge bg-primary">{{ number_format($customer->policy_count) }}</span>
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-success">{{ number_format($customer->total_premium, 2) }} ₺</strong>
                                    </td>
                                    <td class="text-end">
                                        <span class="text-muted">{{ number_format($customer->avg_premium, 2) }} ₺</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
Chart.defaults.font.family = 'Inter, system-ui, -apple-system, sans-serif';
Chart.defaults.font.size = 13;
Chart.defaults.color = '#495057';

// Yaş Dağılımı
const ageCtx = document.getElementById('ageChart').getContext('2d');
new Chart(ageCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode(array_keys($demographics['age_groups'])) !!},
        datasets: [{
            data: {!! json_encode(array_values($demographics['age_groups'])) !!},
            backgroundColor: [
                'rgba(102, 126, 234, 0.85)',
                'rgba(118, 75, 162, 0.85)',
                'rgba(255, 206, 86, 0.85)',
                'rgba(75, 192, 192, 0.85)',
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
                labels: { padding: 15, usePointStyle: true }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                borderRadius: 8,
            }
        },
        cutout: '65%'
    }
});

// Şehir Dağılımı
const cityCtx = document.getElementById('cityChart').getContext('2d');
new Chart(cityCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($cityDistribution->pluck('city')) !!},
        datasets: [{
            label: 'Müşteri Sayısı',
            data: {!! json_encode($cityDistribution->pluck('count')) !!},
            backgroundColor: 'rgba(40, 167, 69, 0.85)',
            borderColor: 'rgb(40, 167, 69)',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
        },
        scales: {
            x: {
                beginAtZero: true,
                grid: { color: 'rgba(0, 0, 0, 0.05)' }
            },
            y: {
                grid: { display: false }
            }
        }
    }
});
</script>
@endpush
