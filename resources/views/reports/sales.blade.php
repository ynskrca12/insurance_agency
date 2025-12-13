@extends('layouts.app')

@section('title', 'Satış Raporları')

@push('styles')
<style>
    .page-header {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
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

    .modal-modern .modal-content {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .modal-modern .modal-header {
        border: none;
        padding: 1.25rem 1.5rem;
    }

    .modal-modern .modal-body {
        padding: 1.5rem;
    }

    .modal-modern .modal-footer {
        background: #fafafa;
        border-top: 1px solid #e9ecef;
        padding: 1rem 1.5rem;
    }

    .info-alert {
        background: #e8f4fd;
        border: 1px solid #b3d9ff;
        border-radius: 10px;
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        color: #0066cc;
    }

    .info-alert i {
        font-size: 1.25rem;
    }

    .period-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6c757d;
        font-size: 0.9375rem;
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
                <h1 class="h3 mb-2 fw-bold text-dark">
                    <i class="bi bi-graph-up me-2"></i>Satış Raporları
                </h1>
                <div class="period-info">
                    <i class="bi bi-calendar-range"></i>
                    <span>{{ \Carbon\Carbon::parse($startDate)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d.m.Y') }}</span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-success action-btn" data-bs-toggle="modal" data-bs-target="#exportModal">
                    <i class="bi bi-file-earmark-excel me-2"></i>Excel'e Aktar
                </button>
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

    <!-- Grafikler -->
    <div class="row g-4 mb-4">
        <!-- Satış Trendi -->
        <div class="col-lg-8">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-graph-up"></i>
                        <span>Satış Trendi</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="salesChart"></canvas>
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

    <!-- Sigorta Şirketi Dağılımı Tablosu -->
    <div class="table-card card mb-4">
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

<!-- Export Modal -->
<div class="modal fade modal-modern" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-file-earmark-excel me-2"></i>Excel'e Aktar
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('reports.export') }}" id="exportForm">
                @csrf
                <input type="hidden" name="type" value="sales">
                <input type="hidden" name="start_date" value="{{ $startDate }}">
                <input type="hidden" name="end_date" value="{{ $endDate }}">
                <div class="modal-body">
                    <p class="mb-3">Satış raporunu Excel formatında indirmek istediğinizden emin misiniz?</p>
                    <div class="info-alert">
                        <i class="bi bi-info-circle"></i>
                        <span>Rapor {{ \Carbon\Carbon::parse($startDate)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d.m.Y') }} tarihleri arasındaki verileri içerecektir.</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light action-btn" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>İptal
                    </button>
                    <button type="submit" class="btn btn-success action-btn">
                        <i class="bi bi-download me-2"></i>İndir
                    </button>
                </div>
            </form>
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

// Satış Trendi Grafiği
const salesCtx = document.getElementById('salesChart').getContext('2d');
new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($timeSeriesData->pluck('period')) !!},
        datasets: [{
            label: 'Prim Tutarı (₺)',
            data: {!! json_encode($timeSeriesData->pluck('total_premium')) !!},
            borderColor: 'rgb(13, 110, 253)',
            backgroundColor: 'rgba(13, 110, 253, 0.1)',
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: '#ffffff',
            pointBorderColor: 'rgb(13, 110, 253)',
            pointBorderWidth: 3,
            pointHoverBackgroundColor: 'rgb(13, 110, 253)',
            pointHoverBorderColor: '#ffffff',
            pointHoverBorderWidth: 3,
            yAxisID: 'y'
        }, {
            label: 'Poliçe Sayısı',
            data: {!! json_encode($timeSeriesData->pluck('policy_count')) !!},
            borderColor: 'rgb(220, 53, 69)',
            backgroundColor: 'rgba(220, 53, 69, 0.1)',
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            pointRadius: 5,
            pointHoverRadius: 7,
            pointBackgroundColor: '#ffffff',
            pointBorderColor: 'rgb(220, 53, 69)',
            pointBorderWidth: 3,
            pointHoverBackgroundColor: 'rgb(220, 53, 69)',
            pointHoverBorderColor: '#ffffff',
            pointHoverBorderWidth: 3,
            yAxisID: 'y1'
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
                }
            }
        },
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
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
                grid: {
                    drawOnChartArea: false,
                },
                border: {
                    display: false
                },
                ticks: {
                    stepSize: 1
                }
            },
            x: {
                grid: {
                    display: false
                },
                border: {
                    display: false
                }
            }
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

// Export form submit animasyonu
$('#exportForm').on('submit', function() {
    const submitBtn = $(this).find('button[type="submit"]');
    submitBtn.prop('disabled', true)
             .html('<span class="spinner-border spinner-border-sm me-2"></span>İndiriliyor...');
});
</script>
@endpush
