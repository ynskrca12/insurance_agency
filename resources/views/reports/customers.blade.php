@extends('layouts.app')

@section('title', 'Müşteri Analizleri')

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

    .city-name {
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
        background: linear-gradient(135deg, #0dcaf0 0%, #0d6efd 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.75rem;
        transition: width 0.6s ease;
    }

    .rank-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        font-weight: 700;
        font-size: 0.875rem;
    }

    .rank-badge.gold {
        background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
        color: #000000;
        box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
    }

    .rank-badge.silver {
        background: linear-gradient(135deg, #c0c0c0 0%, #e8e8e8 100%);
        color: #000000;
        box-shadow: 0 2px 8px rgba(192, 192, 192, 0.3);
    }

    .rank-badge.bronze {
        background: linear-gradient(135deg, #cd7f32 0%, #e59866 100%);
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(205, 127, 50, 0.3);
    }

    .customer-link {
        color: #212529;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .customer-link:hover {
        color: #0d6efd;
    }

    .customer-phone {
        color: #6c757d;
        font-size: 0.8125rem;
    }

    .policy-count-badge {
        padding: 0.375rem 0.75rem;
        font-weight: 600;
        border-radius: 6px;
        font-size: 0.8125rem;
    }

    .premium-value {
        font-weight: 700;
        color: #28a745;
        font-size: 1rem;
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
                    <i class="bi bi-people me-2"></i>Müşteri Analizleri
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
            <form method="GET" action="{{ route('reports.customers') }}">
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
                <div class="stat-value text-primary">{{ number_format($stats['total_customers']) }}</div>
                <div class="stat-label">Toplam Müşteri</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-success">{{ number_format($stats['active_customers']) }}</div>
                <div class="stat-label">Aktif Müşteri</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-info">{{ number_format($stats['new_customers']) }}</div>
                <div class="stat-label">Yeni Müşteri</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-warning">{{ number_format($avgPoliciesPerCustomer, 1) }}</div>
                <div class="stat-label">Müşteri Başına Poliçe</div>
            </div>
        </div>
    </div>

    <!-- Grafikler ve Tablolar -->
    <div class="row g-4">
        <!-- Aylık Yeni Müşteri Trendi -->
        <div class="col-lg-12">
            <div class="chart-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-graph-up"></i>
                        <span>Yeni Müşteri Trendi</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="newCustomersChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Şehre Göre Dağılım -->
        <div class="col-lg-6">
            <div class="table-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-geo-alt"></i>
                        <span>Şehre Göre Müşteri Dağılımı</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Şehir</th>
                                    <th class="text-end">Müşteri Sayısı</th>
                                    <th class="text-end">Dağılım Oranı</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customersByCity as $city)
                                <tr>
                                    <td>
                                        <span class="city-name">{{ $city->city }}</span>
                                    </td>
                                    <td class="text-end">
                                        <strong>{{ number_format($city->count) }}</strong>
                                    </td>
                                    <td class="text-end">
                                        @php
                                            $percentage = $stats['total_customers'] > 0 ? ($city->count / $stats['total_customers']) * 100 : 0;
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

        <!-- En Değerli Müşteriler -->
        <div class="col-lg-6">
            <div class="table-card card">
                <div class="card-header">
                    <h5 class="chart-title">
                        <i class="bi bi-trophy"></i>
                        <span>En Değerli Müşteriler (Top 10)</span>
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th style="width: 60px;">Sıra</th>
                                    <th>Müşteri Bilgileri</th>
                                    <th class="text-end">Poliçe</th>
                                    <th class="text-end">Toplam Prim</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topCustomers as $index => $customer)
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
                                        <a href="{{ route('customers.show', $customer) }}" class="customer-link">
                                            {{ $customer->name }}
                                        </a>
                                        <div class="customer-phone">{{ $customer->phone }}</div>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge policy-count-badge bg-info">{{ $customer->policy_count }}</span>
                                    </td>
                                    <td class="text-end">
                                        <span class="premium-value">{{ number_format($customer->total_premium, 2) }} ₺</span>
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
// Chart.js Global Ayarları
Chart.defaults.font.family = 'Inter, system-ui, -apple-system, sans-serif';
Chart.defaults.font.size = 13;
Chart.defaults.color = '#495057';

// Yeni Müşteri Trendi
const newCustomersCtx = document.getElementById('newCustomersChart').getContext('2d');
new Chart(newCustomersCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlyNewCustomers->pluck('month')) !!},
        datasets: [{
            label: 'Yeni Müşteri Sayısı',
            data: {!! json_encode($monthlyNewCustomers->pluck('count')) !!},
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
                        return 'Yeni Müşteri: ' + context.parsed.y + ' kişi';
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
                    stepSize: 1,
                    callback: function(value) {
                        return value + ' kişi';
                    }
                }
            }
        },
        interaction: {
            intersect: false,
            mode: 'index'
        }
    }
});
</script>
@endpush
