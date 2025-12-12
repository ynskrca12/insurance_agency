@extends('layouts.app')

@section('title', 'Satış Raporları')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">
            <i class="bi bi-graph-up me-2"></i>Satış Raporları
        </h1>
        <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($startDate)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d.m.Y') }}</p>
    </div>
    <div>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exportModal">
            <i class="bi bi-file-earmark-excel me-2"></i>Excel'e Aktar
        </button>
        <a href="{{ route('reports.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Geri
        </a>
    </div>
</div>

<!-- Filtreler -->
<div class="card mb-3 border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.sales') }}">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Başlangıç Tarihi</label>
                    <input type="date" class="form-control" name="start_date" value="{{ $startDate }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Bitiş Tarihi</label>
                    <input type="date" class="form-control" name="end_date" value="{{ $endDate }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Gruplama</label>
                    <select class="form-select" name="group_by">
                        <option value="day" {{ $groupBy === 'day' ? 'selected' : '' }}>Günlük</option>
                        <option value="week" {{ $groupBy === 'week' ? 'selected' : '' }}>Haftalık</option>
                        <option value="month" {{ $groupBy === 'month' ? 'selected' : '' }}>Aylık</option>
                        <option value="year" {{ $groupBy === 'year' ? 'selected' : '' }}>Yıllık</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-2"></i>Filtrele
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- İstatistik Kartları -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-primary">{{ number_format($stats['total_policies']) }}</h2>
                <small class="text-muted">Toplam Poliçe</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-success">{{ number_format($stats['total_premium'], 2) }} ₺</h2>
                <small class="text-muted">Toplam Prim</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-warning">{{ number_format($stats['total_commission'], 2) }} ₺</h2>
                <small class="text-muted">Toplam Komisyon</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-info">{{ number_format($stats['average_premium'], 2) }} ₺</h2>
                <small class="text-muted">Ortalama Prim</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Zaman Serisi Grafiği -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-graph-up me-2"></i>Satış Trendi
                </h5>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Poliçe Türü Dağılımı -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-pie-chart me-2"></i>Poliçe Türü Dağılımı
                </h5>
            </div>
            <div class="card-body">
                <canvas id="policyTypeChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Sigorta Şirketi Dağılımı -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-building me-2"></i>Sigorta Şirketlerine Göre Dağılım
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Şirket</th>
                                <th class="text-end">Poliçe Sayısı</th>
                                <th class="text-end">Toplam Prim</th>
                                <th class="text-end">Oran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($companyDistribution as $company)
                            <tr>
                                <td>
                                    <strong>{{ $company->insuranceCompany->name ?? 'Bilinmiyor' }}</strong>
                                </td>
                                <td class="text-end">{{ number_format($company->count) }}</td>
                                <td class="text-end">{{ number_format($company->total_premium, 2) }} ₺</td>
                                <td class="text-end">
                                    @php
                                        $percentage = $stats['total_premium'] > 0 ? ($company->total_premium / $stats['total_premium']) * 100 : 0;
                                    @endphp
                                    <div class="progress" style="height: 20px;">
                                        <div class="progress-bar" role="progressbar" style="width: {{ $percentage }}%">
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

    <!-- En İyi Performans -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-trophy me-2"></i>En İyi Performans Gösteren Ürünler
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($topPolicyTypes as $index => $type)
                    <div class="col-md-4 mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-primary">#{{ $index + 1 }}</span>
                                    <h4 class="mb-0 text-success">{{ number_format($type->total_premium, 0) }} ₺</h4>
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
                                <h6>{{ $typeLabels[$type->policy_type] ?? $type->policy_type }}</h6>
                                <small class="text-muted">{{ $type->count }} adet poliçe</small>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-file-earmark-excel me-2"></i>Excel'e Aktar
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('reports.export') }}">
                @csrf
                <input type="hidden" name="type" value="sales">
                <input type="hidden" name="start_date" value="{{ $startDate }}">
                <input type="hidden" name="end_date" value="{{ $endDate }}">
                <div class="modal-body">
                    <p>Satış raporunu Excel formatında indirmek istediğinizden emin misiniz?</p>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Rapor {{ \Carbon\Carbon::parse($startDate)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d.m.Y') }} tarihleri arasındaki verileri içerecektir.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-success">
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
// Satış Trendi Grafiği
const salesCtx = document.getElementById('salesChart').getContext('2d');
new Chart(salesCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($timeSeriesData->pluck('period')) !!},
        datasets: [{
            label: 'Prim Tutarı (₺)',
            data: {!! json_encode($timeSeriesData->pluck('total_premium')) !!},
            borderColor: 'rgb(75, 192, 192)',
            backgroundColor: 'rgba(75, 192, 192, 0.1)',
            tension: 0.4,
            fill: true
        }, {
            label: 'Poliçe Sayısı',
            data: {!! json_encode($timeSeriesData->pluck('policy_count')) !!},
            borderColor: 'rgb(255, 99, 132)',
            backgroundColor: 'rgba(255, 99, 132, 0.1)',
            tension: 0.4,
            fill: true,
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
        scales: {
            y: {
                type: 'linear',
                display: true,
                position: 'left',
            },
            y1: {
                type: 'linear',
                display: true,
                position: 'right',
                grid: {
                    drawOnChartArea: false,
                },
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
                'rgba(255, 99, 132, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)',
                'rgba(199, 199, 199, 0.8)'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>
@endpush
