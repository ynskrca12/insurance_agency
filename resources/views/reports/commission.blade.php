@extends('layouts.app')

@section('title', 'Komisyon Raporları')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">
            <i class="bi bi-wallet2 me-2"></i>Komisyon Raporları
        </h1>
        <p class="text-muted mb-0">{{ \Carbon\Carbon::parse($startDate)->format('d.m.Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d.m.Y') }}</p>
    </div>
    <a href="{{ route('reports.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Geri
    </a>
</div>

<!-- Filtreler -->
<div class="card mb-3 border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('reports.commission') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Başlangıç Tarihi</label>
                    <input type="date" class="form-control" name="start_date" value="{{ $startDate }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Bitiş Tarihi</label>
                    <input type="date" class="form-control" name="end_date" value="{{ $endDate }}">
                </div>
                <div class="col-md-4">
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
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body text-center">
                <h2 class="mb-0">{{ number_format($stats['total_commission'], 2) }} ₺</h2>
                <small>Toplam Komisyon</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-primary">{{ number_format($stats['total_policies']) }}</h2>
                <small class="text-muted">Poliçe Sayısı</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-info">{{ number_format($stats['average_commission'], 2) }} ₺</h2>
                <small class="text-muted">Ortalama Komisyon</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-warning">%{{ number_format($stats['commission_rate'], 2) }}</h2>
                <small class="text-muted">Ortalama Komisyon Oranı</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Aylık Komisyon Trendi -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-graph-up me-2"></i>Aylık Komisyon Trendi
                </h5>
            </div>
            <div class="card-body">
                <canvas id="commissionTrendChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Poliçe Türüne Göre Komisyon -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-pie-chart me-2"></i>Ürün Bazlı Dağılım
                </h5>
            </div>
            <div class="card-body">
                <canvas id="commissionByTypeChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Sigorta Şirketine Göre Komisyon -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-building me-2"></i>Sigorta Şirketlerine Göre Komisyon Analizi
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
                                <th class="text-end">Toplam Komisyon</th>
                                <th class="text-end">Ort. Kom. Oranı</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($commissionByCompany as $company)
                            <tr>
                                <td>
                                    <strong>{{ $company->insuranceCompany->name ?? 'Bilinmiyor' }}</strong>
                                </td>
                                <td class="text-end">{{ number_format($company->policy_count) }}</td>
                                <td class="text-end">{{ number_format($company->total_premium, 2) }} ₺</td>
                                <td class="text-end">
                                    <strong class="text-success">{{ number_format($company->total_commission, 2) }} ₺</strong>
                                </td>
                                <td class="text-end">
                                    <span class="badge bg-info">%{{ number_format($company->avg_commission_rate, 2) }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
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
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Aylık Komisyon Trendi
const trendCtx = document.getElementById('commissionTrendChart').getContext('2d');
new Chart(trendCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($monthlyCommission->pluck('month')) !!},
        datasets: [{
            label: 'Komisyon (₺)',
            data: {!! json_encode($monthlyCommission->pluck('total_commission')) !!},
            backgroundColor: 'rgba(75, 192, 192, 0.8)',
            borderColor: 'rgb(75, 192, 192)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Poliçe Türüne Göre Komisyon
const typeCtx = document.getElementById('commissionByTypeChart').getContext('2d');
new Chart(typeCtx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($commissionByType->pluck('policy_type')->map(function($type) {
            $labels = ['kasko' => 'Kasko', 'trafik' => 'Trafik', 'konut' => 'Konut', 'dask' => 'DASK', 'saglik' => 'Sağlık', 'hayat' => 'Hayat', 'tss' => 'TSS'];
            return $labels[$type] ?? $type;
        })) !!},
        datasets: [{
            data: {!! json_encode($commissionByType->pluck('total_commission')) !!},
            backgroundColor: [
                'rgba(255, 99, 132, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(153, 102, 255, 0.8)',
                'rgba(255, 159, 64, 0.8)'
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
