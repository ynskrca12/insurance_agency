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

    .stat-card.success {
        background: linear-gradient(135deg, #28a745 0%, #34ce57 100%);
        border-color: #28a745;
        color: #ffffff;
    }

    .stat-card.warning {
        background: linear-gradient(135deg, #ffc107 0%, #ffca2c 100%);
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

    .stat-card:not(.primary):not(.success):not(.warning) .stat-label {
        color: #6c757d;
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

    /* ✅ YENİ: Vade kartları */
    .vade-card {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        height: 100%;
        transition: all 0.3s ease;
    }

    .vade-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .vade-card.green {
        border-left: 4px solid #28a745;
        background: linear-gradient(135deg, #f0fff4 0%, #ffffff 100%);
    }

    .vade-card.yellow {
        border-left: 4px solid #ffc107;
        background: linear-gradient(135deg, #fffbf0 0%, #ffffff 100%);
    }

    .vade-card.red {
        border-left: 4px solid #dc3545;
        background: linear-gradient(135deg, #fff5f5 0%, #ffffff 100%);
    }

    .vade-card.blue {
        border-left: 4px solid #0dcaf0;
        background: linear-gradient(135deg, #f0f9ff 0%, #ffffff 100%);
    }

    .vade-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.75rem;
    }

    .vade-value {
        font-size: 1.5rem;
        font-weight: 700;
        line-height: 1;
    }

    .vade-card.green .vade-value {
        color: #28a745;
    }

    .vade-card.yellow .vade-value {
        color: #ffc107;
    }

    .vade-card.red .vade-value {
        color: #dc3545;
    }

    .vade-card.blue .vade-value {
        color: #0dcaf0;
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

        .vade-value {
            font-size: 1.25rem;
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
                    <span>{{ \Carbon\Carbon::parse($displayStartDate)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($displayEndDate)->format('d.m.Y') }}</span>
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

    <!-- ✅ YENİ: CARİ ENTEGRASYONLU İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card primary">
                <div class="stat-value">{{ number_format($stats['total_commission'], 2) }} ₺</div>
                <div class="stat-label">Toplam Komisyon</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card success">
                <div class="stat-value">{{ number_format($stats['collected_commission'], 2) }} ₺</div>
                <div class="stat-label">Tahsil Edilen</div>
                <div class="stat-meta">
                    <i class="bi bi-check-circle me-1"></i>
                    %{{ number_format($stats['collection_rate'], 1) }} tahsilat oranı
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card warning">
                <div class="stat-value">{{ number_format($stats['pending_commission'], 2) }} ₺</div>
                <div class="stat-label">Bekleyen Komisyon</div>
                <div class="stat-meta">
                    <i class="bi bi-clock me-1"></i>
                    %{{ number_format(100 - $stats['collection_rate'], 1) }} henüz tahsil edilmedi
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-info">{{ number_format($stats['total_policies']) }}</div>
                <div class="stat-label">Poliçe Sayısı</div>
                <div class="stat-meta">
                    Ort: {{ number_format($stats['average_commission'], 2) }} ₺
                </div>
            </div>
        </div>
    </div>

    <!-- ✅ YENİ: Vade Durumu Kartları -->
    {{-- <div class="chart-card card mb-4">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-calendar-check"></i>
                <span>Komisyon Vade Durumu</span>
            </h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-lg-3 col-md-6">
                    <div class="vade-card green">
                        <div class="vade-title">
                            <i class="bi bi-check-circle me-1"></i>
                            Vadesinde Tahsil Edilen
                        </div>
                        <div class="vade-value">
                            {{ number_format($vadeDurumu['vadesinde'], 2) }} ₺
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="vade-card yellow">
                        <div class="vade-title">
                            <i class="bi bi-exclamation-triangle me-1"></i>
                            Vadesi Yaklaşan (30 gün)
                        </div>
                        <div class="vade-value">
                            {{ number_format($vadeDurumu['vadesi_yaklasan'], 2) }} ₺
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="vade-card red">
                        <div class="vade-title">
                            <i class="bi bi-x-circle me-1"></i>
                            Vade Aşımı
                        </div>
                        <div class="vade-value">
                            {{ number_format($vadeDurumu['vade_asimi'], 2) }} ₺
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="vade-card blue">
                        <div class="vade-title">
                            <i class="bi bi-calendar-plus me-1"></i>
                            İleri Tarihli (30+ gün)
                        </div>
                        <div class="vade-value">
                            {{ number_format($vadeDurumu['ileri_tarihli'], 2) }} ₺
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}



    <!-- ✅ YENİ: Satış Temsilcisi Komisyon Performansı -->
    <div class="table-card card mb-4">
        <div class="card-header">
            <h5 class="chart-title">
                <i class="bi bi-person-badge"></i>
                <span>Satış Temsilcisi Komisyon Performansı (Top 10)</span>
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
                            <th class="text-end">Toplam Komisyon</th>
                            <th class="text-end">Ort. Kom. Oranı</th>
                            <th class="text-end">Tahsilat Oranı</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($salesRepCommission as $index => $rep)
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
                                <strong>{{ $rep->creator->name ?? 'Sistem' }}</strong>
                            </td>
                            <td class="text-end">
                                <span class="badge bg-primary">{{ number_format($rep->policy_count) }}</span>
                            </td>
                            <td class="text-end">
                                <span class="commission-value">{{ number_format($rep->total_commission, 2) }} ₺</span>
                            </td>
                            <td class="text-end">
                                <span class="badge rate-badge bg-info">%{{ number_format($rep->avg_commission_rate, 2) }}</span>
                            </td>
                            <td class="text-end">
                                @php
                                    $rateColor = $rep->collection_rate >= 70 ? 'success' : ($rep->collection_rate >= 40 ? 'warning' : 'danger');
                                @endphp
                                <span class="badge bg-{{ $rateColor }}">
                                    %{{ number_format($rep->collection_rate, 1) }}
                                </span>
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
                    @if($salesRepCommission->isNotEmpty())
                    <tfoot>
                        <tr>
                            <th colspan="2">Toplam</th>
                            <th class="text-end">{{ number_format($salesRepCommission->sum('policy_count')) }}</th>
                            <th class="text-end">{{ number_format($salesRepCommission->sum('total_commission'), 2) }} ₺</th>
                            <th colspan="2"></th>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <!-- Sigorta Şirketine Göre Komisyon Tablosu -->
    <div class="table-card card mt-3">
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
