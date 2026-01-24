@extends('layouts.app')

@section('title', 'Satış Raporları')

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
        overflow: hidden;
    }

    .filter-card .card-body {
        padding: 1.5rem;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 0.9375rem;
    }

    .form-control,
    .form-select {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 0.625rem 0.875rem;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #999;
        box-shadow: 0 0 0 3px rgba(153, 153, 153, 0.1);
    }

    .action-btn {
        border-radius: 8px;
        padding: 0.625rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #dcdcdc;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        border-color: #b0b0b0;
    }

    .btn-primary.action-btn {
        border-color: #0d6efd;
    }

    .btn-success.action-btn {
        border-color: #28a745;
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
        border-color: #b0b0b0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.8125rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
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

    .chart-title i {
        color: #6c757d;
        font-size: 1.25rem;
    }

    .chart-card .card-body {
        padding: 1.5rem;
    }

    .chart-container {
        position: relative;
        height: 300px;
    }

    .table-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
    }

    .table-card .card-header {
        background: #fafafa;
        border-bottom: 1px solid #e8e8e8;
        padding: 1.25rem 1.5rem;
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

    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    .table-modern tbody tr:hover {
        background: #fafafa;
    }

    .table-modern tfoot {
        background: #f8f9fa;
        border-top: 2px solid #dee2e6;
    }

    .table-modern tfoot th {
        padding: 1rem 1.25rem;
        font-weight: 700;
        color: #212529;
    }

    .company-name {
        font-weight: 600;
        color: #212529;
    }

    .progress-modern {
        height: 1.5rem;
        border-radius: 8px;
        background: #e9ecef;
        overflow: hidden;
        min-width: 120px;
    }

    .progress-bar-modern {
        background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.75rem;
        transition: width 0.6s ease;
    }

    .performance-card {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        background: #f8f9fa;
        transition: all 0.3s ease;
        height: 100%;
    }

    .performance-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
    }

    .performance-card .card-body {
        padding: 1.25rem;
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

    .performance-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #28a745;
        line-height: 1;
    }

    .performance-title {
        font-size: 1rem;
        font-weight: 600;
        color: #212529;
        margin: 0.5rem 0;
    }

    .performance-meta {
        font-size: 0.8125rem;
        color: #6c757d;
    }

    .period-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6c757d;
        font-size: 0.9375rem;
    }

    .rep-name {
        font-weight: 600;
        color: #212529;
    }

    .amount-value {
        font-weight: 700;
        color: #28a745;
    }

    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.5rem;
        }

        .performance-value {
            font-size: 1.25rem;
        }

        .chart-container {
            height: 250px;
        }

        .progress-modern {
            min-width: 80px;
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
                    <i class="bi bi-graph-up me-2"></i>Satış Raporları
                </h1>
                <div class="period-info">
                    <i class="bi bi-calendar-range"></i>
                    <span>{{ \Carbon\Carbon::parse($displayStartDate)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($displayEndDate)->format('d.m.Y') }}</span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('reports.index') }}" class="btn btn-light action-btn">
                    <i class="bi bi-arrow-left me-2"></i>Geri
                </a>
            </div>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="filter-card card">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.sales') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Başlangıç Tarihi</label>
                        <input type="date"
                               class="form-control"
                               name="start_date"
                               value="{{ $startDate }}">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Bitiş Tarihi</label>
                        <input type="date"
                               class="form-control"
                               name="end_date"
                               value="{{ $endDate }}">
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label">Gruplama Türü</label>
                        <select class="form-select" name="group_by">
                            <option value="day" {{ $groupBy === 'day' ? 'selected' : '' }}>Günlük</option>
                            <option value="week" {{ $groupBy === 'week' ? 'selected' : '' }}>Haftalık</option>
                            <option value="month" {{ $groupBy === 'month' ? 'selected' : '' }}>Aylık</option>
                            <option value="year" {{ $groupBy === 'year' ? 'selected' : '' }}>Yıllık</option>
                        </select>
                    </div>
                    <div class="col-lg-3 col-md-12">
                        <button type="submit" class="btn btn-primary action-btn w-100">
                            <i class="bi bi-funnel me-2"></i>Filtrele
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-primary">{{ number_format($stats['total_policies']) }}</div>
                <div class="stat-label">Toplam Poliçe</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-success">{{ number_format($stats['total_premium'], 2) }} ₺</div>
                <div class="stat-label">Toplam Prim</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-warning">{{ number_format($stats['total_commission'], 2) }} ₺</div>
                <div class="stat-label">Toplam Komisyon</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-info">{{ number_format($stats['average_premium'], 2) }} ₺</div>
                <div class="stat-label">Ortalama Prim</div>
            </div>
        </div>
    </div>

    <!-- YENİ: Satış Trendi Line Chart -->
    <div class="chart-card card mb-4">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-graph-up-arrow"></i>
                <span>Satış Trendi</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="chart-container">
                <canvas id="salesTrendChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Grafikler -->
    <div class="row g-4 mb-4">
        <!-- Sigorta Şirketi Dağılımı Tablosu -->
        <div class="col-lg-8">
            <div class="table-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-building"></i>
                        <span>Sigorta Şirketlerine Göre Dağılım</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Şirket Adı</th>
                                    <th class="text-end">Poliçe Sayısı</th>
                                    <th class="text-end">Toplam Prim</th>
                                    <th class="text-end">Dağılım Oranı</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($companyDistribution as $company)
                                <tr>
                                    <td>
                                        <span class="company-name">{{ $company->insuranceCompany->name ?? 'Bilinmiyor' }}</span>
                                    </td>
                                    <td class="text-end">
                                        <strong>{{ number_format($company->count) }}</strong>
                                    </td>
                                    <td class="text-end">
                                        <strong class="text-success">{{ number_format($company->total_premium, 2) }} ₺</strong>
                                    </td>
                                    <td class="text-end">
                                        @php
                                            $percentage = $stats['total_premium'] > 0 ? ($company->total_premium / $stats['total_premium']) * 100 : 0;
                                        @endphp
                                        <div class="progress-modern">
                                            <div class="progress-bar-modern" style="width: {{ $percentage }}%">
                                                {{ number_format($percentage, 1) }}%
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Poliçe Türü Dağılımı -->
        <div class="col-lg-4">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-pie-chart"></i>
                        <span>Poliçe Türü Dağılımı</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="policyTypeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- YENİ: Branş Bazlı Detaylı Analiz -->
    <div class="table-card card mb-4">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-bar-chart-line"></i>
                <span>Branş Bazlı Detaylı Analiz</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Branş</th>
                            <th class="text-end">Poliçe Sayısı</th>
                            <th class="text-end">Toplam Prim</th>
                            <th class="text-end">Toplam Komisyon</th>
                            <th class="text-end">Ort. Prim</th>
                            <th class="text-end">Ort. Kom. Oranı</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $typeLabels = [
                                'kasko' => 'Kasko',
                                'trafik' => 'Trafik',
                                'konut' => 'Konut',
                                'dask' => 'DASK',
                                'saglik' => 'Sağlık',
                                'hayat' => 'Hayat',
                                'tss' => 'Tamamlayıcı Sağlık',
                            ];
                        @endphp
                        @foreach($branchAnalysis as $branch)
                        <tr>
                            <td><strong>{{ $typeLabels[$branch->policy_type] ?? $branch->policy_type }}</strong></td>
                            <td class="text-end">{{ number_format($branch->policy_count) }}</td>
                            <td class="text-end">
                                <span class="amount-value">{{ number_format($branch->total_premium, 2) }} ₺</span>
                            </td>
                            <td class="text-end">
                                <span class="text-success fw-bold">{{ number_format($branch->total_commission, 2) }} ₺</span>
                            </td>
                            <td class="text-end">{{ number_format($branch->avg_premium, 2) }} ₺</td>
                            <td class="text-end">
                                <span class="badge bg-info">%{{ number_format($branch->avg_commission_rate, 2) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Toplam</th>
                            <th class="text-end">{{ number_format($branchAnalysis->sum('policy_count')) }}</th>
                            <th class="text-end">{{ number_format($branchAnalysis->sum('total_premium'), 2) }} ₺</th>
                            <th class="text-end">{{ number_format($branchAnalysis->sum('total_commission'), 2) }} ₺</th>
                            <th colspan="2"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- YENİ: Satış Temsilcisi Performans Tablosu -->
    <div class="table-card card mb-4">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-person-badge"></i>
                <span>Satış Temsilcisi Performansı (Top 10)</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th style="width: 60px;">Sıra</th>
                            <th>Temsilci</th>
                            <th class="text-end">Poliçe Sayısı</th>
                            <th class="text-end">Toplam Prim</th>
                            <th class="text-end">Toplam Komisyon</th>
                            <th class="text-end">Ort. Poliçe Değeri</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($salesRepPerformance as $index => $rep)
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
                                <span class="rep-name">{{ $rep->creator->name ?? 'Sistem' }}</span>
                            </td>
                            <td class="text-end">
                                <span class="badge bg-primary">{{ number_format($rep->policy_count) }}</span>
                            </td>
                            <td class="text-end">
                                <span class="amount-value">{{ number_format($rep->total_premium, 2) }} ₺</span>
                            </td>
                            <td class="text-end">
                                <span class="text-success fw-bold">{{ number_format($rep->total_commission, 2) }} ₺</span>
                            </td>
                            <td class="text-end">
                                <span class="text-muted">{{ number_format($rep->avg_premium, 2) }} ₺</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Veri bulunmuyor
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                    @if($salesRepPerformance->isNotEmpty())
                    <tfoot>
                        <tr>
                            <th colspan="2">Toplam</th>
                            <th class="text-end">{{ number_format($salesRepPerformance->sum('policy_count')) }}</th>
                            <th class="text-end">{{ number_format($salesRepPerformance->sum('total_premium'), 2) }} ₺</th>
                            <th class="text-end">{{ number_format($salesRepPerformance->sum('total_commission'), 2) }} ₺</th>
                            <th></th>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- En İyi Performans Gösteren Ürünler -->
    <div class="chart-card card">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-trophy"></i>
                <span>En İyi Performans Gösteren Ürünler</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @foreach($topPolicyTypes as $index => $type)
                <div class="col-lg-4 col-md-6">
                    <div class="performance-card card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                @if($index === 0)
                                    <span class="rank-badge gold">#1</span>
                                @elseif($index === 1)
                                    <span class="rank-badge silver">#2</span>
                                @elseif($index === 2)
                                    <span class="rank-badge bronze">#3</span>
                                @else
                                    <span class="badge bg-secondary">#{{ $index + 1 }}</span>
                                @endif
                                <div class="performance-value">{{ number_format($type->total_premium, 0) }} ₺</div>
                            </div>
                            @php
                                $typeLabels = [
                                    'kasko' => 'Kasko',
                                    'trafik' => 'Trafik',
                                    'konut' => 'Konut',
                                    'dask' => 'DASK',
                                    'saglik' => 'Sağlık',
                                    'hayat' => 'Hayat',
                                    'tss' => 'Tamamlayıcı Sağlık',
                                ];
                            @endphp
                            <h6 class="performance-title">{{ $typeLabels[$type->policy_type] ?? $type->policy_type }}</h6>
                            <small class="performance-meta">{{ number_format($type->count) }} adet poliçe satıldı</small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Chart.js Global Ayarları
Chart.defaults.font.family = 'Inter, system-ui, -apple-system, sans-serif';
Chart.defaults.font.size = 13;
Chart.defaults.color = '#495057';

// YENİ: Satış Trendi Line Chart
const trendCtx = document.getElementById('salesTrendChart').getContext('2d');
new Chart(trendCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($timeSeriesData->pluck('period')) !!},
        datasets: [{
            label: 'Toplam Prim (₺)',
            data: {!! json_encode($timeSeriesData->pluck('total_premium')) !!},
            backgroundColor: 'rgba(13, 110, 253, 0.1)',
            borderColor: 'rgb(13, 110, 253)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: '#ffffff',
            pointBorderColor: 'rgb(13, 110, 253)',
            pointBorderWidth: 2,
            yAxisID: 'y',
        }, {
            label: 'Poliçe Sayısı',
            data: {!! json_encode($timeSeriesData->pluck('policy_count')) !!},
            backgroundColor: 'rgba(40, 167, 69, 0.1)',
            borderColor: 'rgb(40, 167, 69)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: '#ffffff',
            pointBorderColor: 'rgb(40, 167, 69)',
            pointBorderWidth: 2,
            yAxisID: 'y1',
        }]
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
                position: 'top',
                labels: {
                    padding: 15,
                    font: {
                        size: 13,
                        weight: '500'
                    },
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                borderRadius: 8,
                titleFont: {
                    size: 13,
                    weight: '600'
                },
                bodyFont: {
                    size: 13
                },
                callbacks: {
                    label: function(context) {
                        let label = context.dataset.label || '';
                        if (label) {
                            label += ': ';
                        }
                        if (context.datasetIndex === 0) {
                            label += context.parsed.y.toLocaleString('tr-TR', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            }) + ' ₺';
                        } else {
                            label += context.parsed.y + ' adet';
                        }
                        return label;
                    }
                }
            }
        },
        scales: {
            x: {
                grid: {
                    display: false
                },
                border: {
                    display: false
                }
            },
            y: {
                type: 'linear',
                display: true,
                position: 'left',
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)',
                    drawBorder: false
                },
                border: {
                    display: false
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
                beginAtZero: true,
                grid: {
                    drawOnChartArea: false,
                },
                border: {
                    display: false
                },
                ticks: {
                    callback: function(value) {
                        return value + ' adet';
                    }
                }
            },
        }
    }
});

// Poliçe Türü Grafiği
const policyTypeCtx = document.getElementById('policyTypeChart').getContext('2d');
new Chart(policyTypeCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($policyTypeDistribution->pluck('policy_type')->map(function($type) {
            $labels = [
                'kasko' => 'Kasko',
                'trafik' => 'Trafik',
                'konut' => 'Konut',
                'dask' => 'DASK',
                'saglik' => 'Sağlık',
                'hayat' => 'Hayat',
                'tss' => 'TSS',
            ];
            return $labels[$type] ?? $type;
        })) !!},
        datasets: [{
            data: {!! json_encode($policyTypeDistribution->pluck('count')) !!},
            backgroundColor: [
                'rgba(220, 53, 69, 0.85)',
                'rgba(13, 110, 253, 0.85)',
                'rgba(255, 193, 7, 0.85)',
                'rgba(13, 202, 240, 0.85)',
                'rgba(111, 66, 193, 0.85)',
                'rgba(253, 126, 20, 0.85)',
                'rgba(108, 117, 125, 0.85)'
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
                    font: {
                        size: 12
                    },
                    usePointStyle: true,
                    pointStyle: 'circle'
                }
            },
            tooltip: {
                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                padding: 12,
                borderRadius: 8,
                titleFont: {
                    size: 13,
                    weight: '600'
                },
                bodyFont: {
                    size: 13
                },
                callbacks: {
                    label: function(context) {
                        const value = context.parsed;
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = ((value / total) * 100).toFixed(1);
                        return context.label + ': ' + value + ' adet (' + percentage + '%)';
                    }
                }
            }
        },
        cutout: '65%'
    }
});
</script>
@endpush
