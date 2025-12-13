@extends('layouts.app')

@section('title', 'Ödeme Raporları')

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

    .method-name {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .method-name i {
        font-size: 1.125rem;
        color: #6c757d;
    }

    .method-name strong {
        font-weight: 600;
        color: #212529;
    }

    .amount-value {
        font-weight: 700;
        color: #28a745;
        font-size: 1rem;
    }

    .progress-modern {
        height: 1.5rem;
        border-radius: 8px;
        background: #e9ecef;
        overflow: hidden;
        min-width: 120px;
    }

    .progress-bar-modern {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.75rem;
        transition: width 0.6s ease;
    }

    .cashflow-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
    }

    .cashflow-item {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
    }

    .cashflow-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.08);
    }

    .cashflow-value {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        line-height: 1;
    }

    .cashflow-label {
        font-size: 0.8125rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
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

        .cashflow-value {
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
                    <i class="bi bi-cash-coin me-2"></i>Ödeme Raporları
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
            <form method="GET" action="{{ route('reports.payments') }}">
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
            <div class="stat-card primary">
                <div class="stat-value">{{ number_format($stats['total_collected'], 2) }} ₺</div>
                <div class="stat-label">Toplam Tahsilat</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-primary">{{ number_format($stats['total_payments']) }}</div>
                <div class="stat-label">Ödeme Sayısı</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-warning">{{ number_format($pendingPayments, 2) }} ₺</div>
                <div class="stat-label">Bekleyen Ödemeler</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-danger">{{ number_format($overduePayments, 2) }} ₺</div>
                <div class="stat-label">Gecikmiş Ödemeler</div>
            </div>
        </div>
    </div>

    <!-- Grafikler -->
    <div class="row g-4 mb-4">
        <!-- Günlük Tahsilat Trendi -->
        <div class="col-lg-8">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-graph-up"></i>
                        <span>Günlük Tahsilat Trendi</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="dailyCollectionsChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ödeme Yöntemi Dağılımı -->
        <div class="col-lg-4">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-pie-chart"></i>
                        <span>Ödeme Yöntemi Dağılımı</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="paymentMethodChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Ödeme Yöntemleri Detay Tablosu -->
    <div class="table-card card mb-4">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-credit-card"></i>
                <span>Ödeme Yöntemlerine Göre Detay</span>
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-modern">
                    <thead>
                        <tr>
                            <th>Ödeme Yöntemi</th>
                            <th class="text-end">İşlem Sayısı</th>
                            <th class="text-end">Toplam Tutar</th>
                            <th class="text-end">Ortalama</th>
                            <th class="text-end">Dağılım Oranı</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $methodLabels = [
                                'cash' => 'Nakit',
                                'credit_card' => 'Kredi Kartı',
                                'bank_transfer' => 'Havale/EFT',
                                'check' => 'Çek',
                                'pos' => 'POS',
                            ];
                            $methodIcons = [
                                'cash' => 'cash',
                                'credit_card' => 'credit-card',
                                'bank_transfer' => 'bank',
                                'check' => 'receipt',
                                'pos' => 'credit-card-2-front',
                            ];
                        @endphp
                        @foreach($paymentsByMethod as $method)
                        <tr>
                            <td>
                                <div class="method-name">
                                    <i class="bi bi-{{ $methodIcons[$method->payment_method] ?? 'cash' }}"></i>
                                    <strong>{{ $methodLabels[$method->payment_method] ?? $method->payment_method }}</strong>
                                </div>
                            </td>
                            <td class="text-end">
                                <strong>{{ number_format($method->count) }}</strong>
                            </td>
                            <td class="text-end">
                                <span class="amount-value">{{ number_format($method->total_amount, 2) }} ₺</span>
                            </td>
                            <td class="text-end">
                                <span class="text-muted">{{ number_format($method->total_amount / $method->count, 2) }} ₺</span>
                            </td>
                            <td class="text-end">
                                @php
                                    $percentage = $stats['total_collected'] > 0 ? ($method->total_amount / $stats['total_collected']) * 100 : 0;
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
                    <tfoot>
                        <tr>
                            <th>Toplam</th>
                            <th class="text-end">{{ number_format($paymentsByMethod->sum('count')) }}</th>
                            <th class="text-end">{{ number_format($paymentsByMethod->sum('total_amount'), 2) }} ₺</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Nakit Akışı Özeti -->
    <div class="cashflow-card card">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-wallet2"></i>
                <span>Nakit Akışı Özeti</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <div class="cashflow-item">
                        <div class="cashflow-value text-success">{{ number_format($stats['cash_payments'], 2) }} ₺</div>
                        <div class="cashflow-label">Nakit Tahsilat</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="cashflow-item">
                        <div class="cashflow-value text-info">{{ number_format($stats['card_payments'], 2) }} ₺</div>
                        <div class="cashflow-label">Kart Tahsilat</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="cashflow-item">
                        <div class="cashflow-value text-warning">{{ number_format($pendingPayments, 2) }} ₺</div>
                        <div class="cashflow-label">Bekleyen</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="cashflow-item">
                        <div class="cashflow-value text-danger">{{ number_format($overduePayments, 2) }} ₺</div>
                        <div class="cashflow-label">Gecikmiş</div>
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
// Chart.js Global Ayarları
Chart.defaults.font.family = 'Inter, system-ui, -apple-system, sans-serif';
Chart.defaults.font.size = 13;
Chart.defaults.color = '#495057';

// Günlük Tahsilat Trendi
const dailyCtx = document.getElementById('dailyCollectionsChart').getContext('2d');
new Chart(dailyCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($dailyCollections->pluck('date')) !!},
        datasets: [{
            label: 'Tahsilat (₺)',
            data: {!! json_encode($dailyCollections->pluck('total_amount')) !!},
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
                        return 'Tahsilat: ' + context.parsed.y.toLocaleString('tr-TR', {
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

// Ödeme Yöntemi Dağılımı
const methodCtx = document.getElementById('paymentMethodChart').getContext('2d');
new Chart(methodCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($paymentsByMethod->pluck('payment_method')->map(function($method) {
            $labels = [
                'cash' => 'Nakit',
                'credit_card' => 'Kredi Kartı',
                'bank_transfer' => 'Havale/EFT',
                'check' => 'Çek',
                'pos' => 'POS'
            ];
            return $labels[$method] ?? $method;
        })) !!},
        datasets: [{
            data: {!! json_encode($paymentsByMethod->pluck('total_amount')) !!},
            backgroundColor: [
                'rgba(40, 167, 69, 0.85)',
                'rgba(54, 162, 235, 0.85)',
                'rgba(255, 206, 86, 0.85)',
                'rgba(153, 102, 255, 0.85)',
                'rgba(255, 159, 64, 0.85)'
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
