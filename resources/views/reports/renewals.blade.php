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

    .priority-badge {
        padding: 0.375rem 0.75rem;
        font-weight: 600;
        border-radius: 6px;
        font-size: 0.8125rem;
        display: inline-block;
    }

    .progress-modern {
        height: 1.5rem;
        border-radius: 8px;
        background: #e9ecef;
        overflow: hidden;
        min-width: 120px;
    }

    .progress-bar-modern {
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.75rem;
        transition: width 0.6s ease;
    }

    .reason-name {
        font-weight: 500;
        color: #212529;
    }

    .reason-count {
        font-weight: 600;
        color: #495057;
    }

    .reason-badge {
        padding: 0.375rem 0.75rem;
        font-weight: 600;
        border-radius: 6px;
        font-size: 0.8125rem;
    }

    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
        color: #9ca3af;
    }

    .empty-state i {
        font-size: 3rem;
        color: #d0d0d0;
        margin-bottom: 1rem;
    }

    .empty-state p {
        margin: 0;
        font-size: 0.875rem;
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
                    <i class="bi bi-arrow-repeat me-2"></i>Yenileme Raporları
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
            <form method="GET" action="{{ route('reports.renewals') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-5 col-md-6">
                        <label class="form-label">Başlangıç Tarihi</label>
                        <input type="date"
                               class="form-control"
                               name="start_date"
                               value="{{ $startDate }}">
                    </div>
                    <div class="col-lg-5 col-md-6">
                        <label class="form-label">Bitiş Tarihi</label>
                        <input type="date"
                               class="form-control"
                               name="end_date"
                               value="{{ $endDate }}">
                    </div>
                    <div class="col-lg-2 col-md-12">
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
                <div class="stat-value text-primary">{{ number_format($stats['total_renewals']) }}</div>
                <div class="stat-label">Toplam Yenileme</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-success">{{ number_format($stats['renewed']) }}</div>
                <div class="stat-label">Yenilendi</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-warning">{{ number_format($stats['pending_renewals']) }}</div>
                <div class="stat-label">Bekliyor</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card primary">
                <div class="stat-value">%{{ number_format($stats['success_rate'], 1) }}</div>
                <div class="stat-label">Başarı Oranı</div>
            </div>
        </div>
    </div>

    <!-- Grafikler -->
    <div class="row g-4 mb-4">
        <!-- Haftalık Yenileme Trendi -->
        <div class="col-lg-8">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-graph-up"></i>
                        <span>Haftalık Yenileme Trendi</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="weeklyRenewalsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Durum Dağılımı -->
        <div class="col-lg-4">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-pie-chart"></i>
                        <span>Durum Dağılımı</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="statusDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablolar -->
    <div class="row g-4">
        <!-- Öncelik Dağılımı -->
        <div class="col-lg-6">
            <div class="table-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span>Öncelik Dağılımı</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Öncelik Seviyesi</th>
                                    <th class="text-end">Adet</th>
                                    <th class="text-end">Dağılım Oranı</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $priorityLabels = [
                                        'low' => 'Düşük',
                                        'normal' => 'Normal',
                                        'high' => 'Yüksek',
                                        'critical' => 'Kritik',
                                    ];
                                    $priorityColors = [
                                        'low' => 'secondary',
                                        'normal' => 'info',
                                        'high' => 'warning',
                                        'critical' => 'danger',
                                    ];
                                @endphp
                                @foreach($renewalsByPriority as $priority)
                                <tr>
                                    <td>
                                        <span class="priority-badge bg-{{ $priorityColors[$priority->priority] ?? 'secondary' }}">
                                            {{ $priorityLabels[$priority->priority] ?? $priority->priority }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <strong>{{ number_format($priority->count) }}</strong>
                                    </td>
                                    <td class="text-end">
                                        @php
                                            $percentage = $stats['total_renewals'] > 0 ? ($priority->count / $stats['total_renewals']) * 100 : 0;
                                        @endphp
                                        <div class="progress-modern">
                                            <div class="progress-bar-modern bg-{{ $priorityColors[$priority->priority] ?? 'secondary' }}"
                                                 style="width: {{ $percentage }}%">
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

        <!-- Kayıp Nedenleri -->
        <div class="col-lg-6">
            <div class="table-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-x-circle"></i>
                        <span>Kayıp Nedenleri Analizi</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    @if($lostReasons->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Kayıp Nedeni</th>
                                    <th class="text-end">Adet</th>
                                    <th class="text-end">Oran</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $reasonLabels = [
                                        'price' => 'Fiyat',
                                        'service' => 'Hizmet Kalitesi',
                                        'competitor' => 'Rakip Firma',
                                        'customer_decision' => 'Müşteri Kararı',
                                        'other' => 'Diğer Nedenler',
                                    ];
                                @endphp
                                @foreach($lostReasons as $reason)
                                <tr>
                                    <td>
                                        <span class="reason-name">{{ $reasonLabels[$reason->lost_reason] ?? $reason->lost_reason }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="reason-count">{{ number_format($reason->count) }}</span>
                                    </td>
                                    <td class="text-end">
                                        @php
                                            $percentage = $stats['lost'] > 0 ? ($reason->count / $stats['lost']) * 100 : 0;
                                        @endphp
                                        <span class="badge reason-badge bg-danger">{{ number_format($percentage, 1) }}%</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p>Kayıp kaydı bulunmuyor</p>
                    </div>
                    @endif
                </div>
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

// Haftalık Yenileme Trendi
const weeklyCtx = document.getElementById('weeklyRenewalsChart').getContext('2d');
new Chart(weeklyCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($weeklyRenewals->pluck('week')) !!},
        datasets: [
            {
                label: 'Yenilendi',
                data: {!! json_encode($weeklyRenewals->pluck('renewed')) !!},
                backgroundColor: 'rgba(40, 167, 69, 0.85)',
                borderColor: 'rgb(40, 167, 69)',
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false,
            },
            {
                label: 'Kayıp',
                data: {!! json_encode($weeklyRenewals->pluck('lost')) !!},
                backgroundColor: 'rgba(220, 53, 69, 0.85)',
                borderColor: 'rgb(220, 53, 69)',
                borderWidth: 2,
                borderRadius: 6,
                borderSkipped: false,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
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
            x: {
                stacked: false,
                grid: {
                    display: false
                },
                border: {
                    display: false
                }
            },
            y: {
                stacked: false,
                beginAtZero: true,
                grid: {
                    color: 'rgba(0, 0, 0, 0.05)',
                    drawBorder: false
                },
                border: {
                    display: false
                },
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Durum Dağılımı
const statusCtx = document.getElementById('statusDistributionChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($renewalsByStatus->pluck('status')->map(function($status) {
            $labels = [
                'pending' => 'Bekliyor',
                'contacted' => 'İletişimde',
                'renewed' => 'Yenilendi',
                'lost' => 'Kayıp'
            ];
            return $labels[$status] ?? $status;
        })) !!},
        datasets: [{
            data: {!! json_encode($renewalsByStatus->pluck('count')) !!},
            backgroundColor: [
                'rgba(255, 193, 7, 0.85)',
                'rgba(13, 202, 240, 0.85)',
                'rgba(40, 167, 69, 0.85)',
                'rgba(220, 53, 69, 0.85)'
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
                        return context.label + ': ' + value + ' (' + percentage + '%)';
                    }
                }
            }
        },
        cutout: '65%'
    }
});
</script>
@endpush
