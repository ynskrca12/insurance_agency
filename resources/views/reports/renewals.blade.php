@extends('layouts.app')

@section('title', 'Yenileme Raporları')

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

    .stat-card.success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border-color: #28a745;
        color: #ffffff;
    }

    .stat-card.danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border-color: #dc3545;
        color: #ffffff;
    }

    .stat-card.warning {
        background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
        border-color: #ffc107;
        color: #000000;
    }

    .stat-card.info {
        background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);
        border-color: #0dcaf0;
        color: #ffffff;
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

    .impact-box {
        border: 2px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .impact-box:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .impact-box.positive {
        border-color: #28a745;
        background: linear-gradient(135deg, #f0fff4 0%, #ffffff 100%);
    }

    .impact-box.negative {
        border-color: #dc3545;
        background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
    }

    .impact-box.neutral {
        border-color: #0dcaf0;
        background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%);
    }

    .impact-value {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .impact-box.positive .impact-value { color: #28a745; }
    .impact-box.negative .impact-value { color: #dc3545; }
    .impact-box.neutral .impact-value { color: #0dcaf0; }

    .impact-label {
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

    .priority-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-weight: 600;
        font-size: 0.8125rem;
    }

    .priority-high {
        background: #dc3545;
        color: #ffffff;
    }

    .priority-medium {
        background: #ffc107;
        color: #000000;
    }

    .priority-low {
        background: #6c757d;
        color: #ffffff;
    }

    .projection-card {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        transition: all 0.3s ease;
    }

    .projection-card:hover {
        transform: translateY(-2px);
        border-color: #0dcaf0;
        box-shadow: 0 4px 12px rgba(13, 202, 240, 0.15);
    }

    .projection-month {
        font-size: 0.875rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
    }

    .projection-count {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0dcaf0;
        margin-bottom: 0.5rem;
    }

    .projection-revenue {
        font-size: 1rem;
        font-weight: 600;
        color: #28a745;
    }

    .lost-reason-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 1rem;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        transition: all 0.3s ease;
    }

    .lost-reason-item:hover {
        background: #f8f9fa;
        border-color: #dc3545;
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
                    <i class="bi bi-arrow-repeat me-2"></i>Yenileme Raporları
                </h1>
                <p class="text-muted mb-0">
                    <i class="bi bi-calendar-range me-1"></i>
                    {{ \Carbon\Carbon::parse($startDate)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d.m.Y') }}
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
            <form method="GET" action="{{ route('reports.renewals') }}">
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
            <div class="stat-card info">
                <div class="stat-value">{{ number_format($stats['total_renewals']) }}</div>
                <div class="stat-label">Toplam Yenileme</div>
                <div class="stat-meta">
                    Dönem içinde bitiş tarihi gelen
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card success">
                <div class="stat-value">{{ number_format($stats['renewed']) }}</div>
                <div class="stat-label">Yenilendi</div>
                <div class="stat-meta">
                    %{{ number_format($stats['success_rate'], 1) }} başarı oranı
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card danger">
                <div class="stat-value">{{ number_format($stats['lost']) }}</div>
                <div class="stat-label">Kaybedildi</div>
                <div class="stat-meta">
                    Müşteri kayıp analizi
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card warning">
                <div class="stat-value">{{ number_format($stats['pending']) }}</div>
                <div class="stat-label">Beklemede</div>
                <div class="stat-meta">
                    Ort: {{ number_format($stats['avg_renewal_time'], 0) }} gün
                </div>
            </div>
        </div>
    </div>

    <!-- Parasal Etki -->
    <div class="chart-card card mb-4">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-currency-exchange"></i>
                <span>Parasal Etki Analizi</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-lg-4">
                    <div class="impact-box positive">
                        <div class="impact-value">
                            +{{ number_format($financialImpact['renewed_revenue'], 2) }} ₺
                        </div>
                        <div class="impact-label">Yenilenen Gelir</div>
                        <small class="text-muted d-block mt-2">
                            Komisyon: +{{ number_format($financialImpact['renewed_commission'], 2) }} ₺
                        </small>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="impact-box negative">
                        <div class="impact-value">
                            -{{ number_format($financialImpact['lost_revenue'], 2) }} ₺
                        </div>
                        <div class="impact-label">Kaybedilen Gelir</div>
                        <small class="text-muted d-block mt-2">
                            Komisyon: -{{ number_format($financialImpact['lost_commission'], 2) }} ₺
                        </small>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="impact-box neutral">
                        <div class="impact-value">
                            {{ $financialImpact['net_impact'] >= 0 ? '+' : '' }}{{ number_format($financialImpact['net_impact'], 2) }} ₺
                        </div>
                        <div class="impact-label">Net Etki</div>
                        <small class="text-muted d-block mt-2">
                            Net Kom: {{ number_format($financialImpact['net_commission_impact'], 2) }} ₺
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gelecek Projeksiyonu -->
    <div class="chart-card card mb-4">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-calendar-plus"></i>
                <span>Gelecek 3 Ay Projeksiyonu</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @foreach($futureProjection as $month)
                <div class="col-lg-4">
                    <div class="projection-card">
                        <div class="projection-month">{{ $month['month'] }}</div>
                        <div class="projection-count">{{ number_format($month['count']) }} Yenileme</div>
                        <div class="projection-revenue">{{ number_format($month['expected_revenue'], 2) }} ₺</div>
                        <small class="text-muted d-block mt-2">Beklenen Gelir</small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Şirket Bazlı -->
        <div class="col-lg-6">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-building"></i>
                        <span>Şirket Bazlı Başarı</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="companyChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Branş Bazlı -->
        <div class="col-lg-6">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-pie-chart"></i>
                        <span>Branş Bazlı Retention</span>
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

    <!-- Haftalık Trend -->
    <div class="chart-card card mb-4">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-graph-up"></i>
                <span>Haftalık Trend</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="trendChart"></canvas>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <!-- Kayıp Nedenleri -->
        <div class="col-lg-5">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-x-circle"></i>
                        <span>Kayıp Nedenleri</span>
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($lostReasons as $reason)
                    <div class="lost-reason-item">
                        <span class="text-capitalize">{{ $reason->lost_reason }}</span>
                        <span class="badge bg-danger">{{ $reason->count }}</span>
                    </div>
                    @empty
                    <div class="text-center text-muted py-4">
                        <i class="bi bi-check-circle fs-3 d-block mb-2"></i>
                        Kayıp yok
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Risk -->
        <div class="col-lg-7">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span>Kritik Yenilemeler</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Öncelik</th>
                                    <th>Müşteri</th>
                                    <th>Poliçe</th>
                                    <th>Bitiş</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($riskAnalysis['critical_renewals']->take(5) as $renewal)
                                <tr>
                                    <td>
                                        <span class="priority-badge priority-{{ $renewal->priority }}">
                                            {{ strtoupper($renewal->priority) }}
                                        </span>
                                    </td>
                                    <td>
                                        <strong>{{ $renewal->policy->customer->name ?? 'N/A' }}</strong>
                                    </td>
                                    <td>
                                        <small>{{ $renewal->policy->policy_number ?? '-' }}</small>
                                    </td>
                                    <td>
                                        <small class="text-danger">
                                            {{ \Carbon\Carbon::parse($renewal->renewal_date)->format('d.m.Y') }}
                                        </small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        Kritik yok
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Arama Listesi -->
    <div class="chart-card card">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-telephone"></i>
                <span>Öncelikli Arama Listesi</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Öncelik</th>
                            <th>Müşteri</th>
                            <th>Telefon</th>
                            <th>Poliçe</th>
                            <th>Şirket</th>
                            <th>Bitiş</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($priorityCallList as $renewal)
                        <tr>
                            <td>
                                <span class="priority-badge priority-{{ $renewal->priority }}">
                                    {{ strtoupper($renewal->priority) }}
                                </span>
                            </td>
                            <td>{{ $renewal->policy->customer->name ?? 'N/A' }}</td>
                            <td>
                                <a href="tel:{{ $renewal->policy->customer->phone ?? '' }}">
                                    {{ $renewal->policy->customer->phone ?? '-' }}
                                </a>
                            </td>
                            <td><small>{{ $renewal->policy->policy_number ?? '-' }}</small></td>
                            <td><small>{{ $renewal->policy->insuranceCompany->name ?? '-' }}</small></td>
                            <td>
                                <small>{{ \Carbon\Carbon::parse($renewal->renewal_date)->format('d.m.Y') }}</small>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">Liste boş</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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

// Şirket Chart
const companyCtx = document.getElementById('companyChart').getContext('2d');
new Chart(companyCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($companyRenewalSuccess->pluck('company.name')) !!},
        datasets: [{
            label: 'Başarı (%)',
            data: {!! json_encode($companyRenewalSuccess->pluck('success_rate')) !!},
            backgroundColor: 'rgba(40, 167, 69, 0.85)',
            borderColor: 'rgb(40, 167, 69)',
            borderWidth: 2,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, max: 100 },
            x: { grid: { display: false } }
        }
    }
});

// Branş Chart
const branchCtx = document.getElementById('branchChart').getContext('2d');
new Chart(branchCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($branchRetention->pluck('type')) !!},
        datasets: [{
            data: {!! json_encode($branchRetention->pluck('retention_rate')) !!},
            backgroundColor: [
                'rgba(102, 126, 234, 0.85)',
                'rgba(118, 75, 162, 0.85)',
                'rgba(255, 206, 86, 0.85)',
                'rgba(75, 192, 192, 0.85)',
                'rgba(153, 102, 255, 0.85)',
            ],
            borderColor: '#ffffff',
            borderWidth: 3,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom' }
        },
        cutout: '65%'
    }
});

// Trend Chart
const trendCtx = document.getElementById('trendChart').getContext('2d');
new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($weeklyTrend->pluck('week')) !!},
        datasets: [
            {
                label: 'Yenilenen',
                data: {!! json_encode($weeklyTrend->pluck('renewed')) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                borderColor: 'rgb(40, 167, 69)',
                borderWidth: 3,
                fill: true,
            },
            {
                label: 'Kaybedilen',
                data: {!! json_encode($weeklyTrend->pluck('lost')) !!},
                backgroundColor: 'rgba(220, 53, 69, 0.1)',
                borderColor: 'rgb(220, 53, 69)',
                borderWidth: 3,
                fill: true,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endpush
