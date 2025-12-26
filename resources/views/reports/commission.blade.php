@extends('layouts.app')

@section('title', 'Komisyon Raporları')

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

    .form-control {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 0.625rem 0.875rem;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
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

    .stat-card.primary {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border-color: #28a745;
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

    .stat-card:not(.primary) .stat-label {
        color: #6c757d;
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

    .amount-value {
        font-weight: 600;
        color: #212529;
    }

    .commission-value {
        font-weight: 700;
        color: #28a745;
        font-size: 1rem;
    }

    .rate-badge {
        padding: 0.375rem 0.75rem;
        font-weight: 600;
        border-radius: 6px;
        font-size: 0.8125rem;
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
                    <i class="bi bi-wallet2 me-2"></i>Komisyon Raporları
                </h1>
                <div class="period-info">
                    <i class="bi bi-calendar-range"></i>
                    <span>{{ \Carbon\Carbon::parse($startDate)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d.m.Y') }}</span>
                </div>
            </div>
            <a href="{{ route('reports.index') }}" class="btn btn-light action-btn">
                <i class="bi bi-arrow-left me-2"></i>Geri
            </a>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="filter-card card">
        <div class="card-body">
            <form method="GET" action="{{ route('reports.commission') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label">Başlangıç Tarihi</label>
                        <input type="date"
                               class="form-control"
                               name="start_date"
                               value="{{ $startDate }}">
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label">Bitiş Tarihi</label>
                        <input type="date"
                               class="form-control"
                               name="end_date"
                               value="{{ $endDate }}">
                    </div>
                    <div class="col-lg-4 col-md-12">
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
            <div class="stat-card primary">
                <div class="stat-value">{{ number_format($stats['total_commission'], 2) }} ₺</div>
                <div class="stat-label">Toplam Komisyon</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-primary">{{ number_format($stats['total_policies']) }}</div>
                <div class="stat-label">Poliçe Sayısı</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-info">{{ number_format($stats['average_commission'], 2) }} ₺</div>
                <div class="stat-label">Ortalama Komisyon</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-warning">%{{ number_format($stats['commission_rate'], 2) }}</div>
                <div class="stat-label">Ortalama Kom. Oranı</div>
            </div>
        </div>
    </div>

    <!-- Grafikler -->
    <div class="row g-4 mb-4">
        <!-- Aylık Komisyon Trendi -->
        <div class="col-lg-8">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-graph-up"></i>
                        <span>Aylık Komisyon Trendi</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="commissionTrendChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Poliçe Türüne Göre Komisyon -->
        <div class="col-lg-4">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-pie-chart"></i>
                        <span>Ürün Bazlı Dağılım</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="commissionByTypeChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sigorta Şirketine Göre Komisyon Tablosu -->
    <div class="table-card card">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-building"></i>
                <span>Sigorta Şirketlerine Göre Komisyon Analizi</span>
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
                            <th class="text-end">Toplam Komisyon</th>
                            <th class="text-end">Ort. Kom. Oranı</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commissionByCompany as $company)
                        <tr>
                            <td>
                                <span class="company-name">{{ $company->insuranceCompany->name ?? 'Bilinmiyor' }}</span>
                            </td>
                            <td class="text-end">
                                <span class="amount-value">{{ number_format($company->policy_count) }}</span>
                            </td>
                            <td class="text-end">
                                <span class="amount-value">{{ number_format($company->total_premium, 2) }} ₺</span>
                            </td>
                            <td class="text-end">
                                <span class="commission-value">{{ number_format($company->total_commission, 2) }} ₺</span>
                            </td>
                            <td class="text-end">
                                <span class="badge rate-badge bg-info">%{{ number_format($company->avg_commission_rate, 2) }}</span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Toplam</th>
                            <th class="text-end">{{ number_format($commissionByCompany->sum('policy_count')) }}</th>
                            <th class="text-end">{{ number_format($commissionByCompany->sum('total_premium'), 2) }} ₺</th>
                            <th class="text-end">{{ number_format($commissionByCompany->sum('total_commission'), 2) }} ₺</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
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

// Aylık Komisyon Trendi
const trendCtx = document.getElementById('commissionTrendChart').getContext('2d');
new Chart(trendCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($monthlyCommission->pluck('month')) !!},
        datasets: [{
            label: 'Komisyon (₺)',
            data: {!! json_encode($monthlyCommission->pluck('total_commission')) !!},
            backgroundColor: 'rgba(40, 167, 69, 0.85)',
            borderColor: 'rgb(40, 167, 69)',
            borderWidth: 2,
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
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
                        return 'Komisyon: ' + context.parsed.y.toLocaleString('tr-TR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }) + ' ₺';
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
            }
        }
    }
});

// Poliçe Türüne Göre Komisyon
const typeCtx = document.getElementById('commissionByTypeChart').getContext('2d');
new Chart(typeCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($commissionByType->pluck('policy_type')->map(function($type) {
            $labels = [
                'kasko' => 'Kasko',
                'trafik' => 'Trafik',
                'konut' => 'Konut',
                'dask' => 'DASK',
                'saglik' => 'Sağlık',
                'hayat' => 'Hayat',
                'tss' => 'TSS'
            ];
            return $labels[$type] ?? $type;
        })) !!},
        datasets: [{
            data: {!! json_encode($commissionByType->pluck('total_commission')) !!},
            backgroundColor: [
                'rgba(255, 99, 132, 0.85)',
                'rgba(54, 162, 235, 0.85)',
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
                        return context.label + ': ' + value.toLocaleString('tr-TR', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        }) + ' ₺ (' + percentage + '%)';
                    }
                }
            }
        },
        cutout: '65%'
    }
});
</script>
@endpush
