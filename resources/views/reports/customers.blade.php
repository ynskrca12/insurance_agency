@extends('layouts.app')

@section('title', 'Müşteri Analizleri')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">
            <i class="bi bi-people me-2"></i>Müşteri Analizleri
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
        <form method="GET" action="{{ route('reports.customers') }}">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label">Başlangıç Tarihi</label>
                    <input type="date" class="form-control" name="start_date" value="{{ $startDate }}">
                </div>
                <div class="col-md-5">
                    <label class="form-label">Bitiş Tarihi</label>
                    <input type="date" class="form-control" name="end_date" value="{{ $endDate }}">
                </div>
                <div class="col-md-2">
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
                <h2 class="mb-0 text-primary">{{ number_format($stats['total_customers']) }}</h2>
                <small class="text-muted">Toplam Müşteri</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-success">{{ number_format($stats['active_customers']) }}</h2>
                <small class="text-muted">Aktif Müşteri</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-info">{{ number_format($stats['new_customers']) }}</h2>
                <small class="text-muted">Yeni Müşteri</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-warning">{{ number_format($avgPoliciesPerCustomer, 1) }}</h2>
                <small class="text-muted">Müşteri Başına Poliçe</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Aylık Yeni Müşteri Trendi -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-graph-up me-2"></i>Yeni Müşteri Trendi
                </h5>
            </div>
            <div class="card-body">
                <canvas id="newCustomersChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Yaş Dağılımı -->
    {{-- <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-pie-chart me-2"></i>Yaş Dağılımı
                </h5>
            </div>
            <div class="card-body">
                <canvas id="ageDistributionChart" height="300"></canvas>
            </div>
        </div>
    </div> --}}

    <!-- Şehre Göre Dağılım -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-geo-alt me-2"></i>Şehre Göre Müşteri Dağılımı
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Şehir</th>
                                <th class="text-end">Müşteri Sayısı</th>
                                <th class="text-end">Oran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customersByCity as $city)
                            <tr>
                                <td><strong>{{ $city->city }}</strong></td>
                                <td class="text-end">{{ number_format($city->count) }}</td>
                                <td class="text-end">
                                    @php
                                        $percentage = $stats['total_customers'] > 0 ? ($city->count / $stats['total_customers']) * 100 : 0;
                                    @endphp
                                    <div class="progress" style="height: 20px; min-width: 100px;">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $percentage }}%">
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
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-trophy me-2"></i>En Değerli Müşteriler (Top 10)
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Müşteri</th>
                                <th class="text-end">Poliçe</th>
                                <th class="text-end">Toplam Prim</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topCustomers as $index => $customer)
                            <tr>
                                <td>
                                    @if($index < 3)
                                        <span class="badge bg-warning text-dark">{{ $index + 1 }}</span>
                                    @else
                                        <span class="text-muted">{{ $index + 1 }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('customers.show', $customer) }}" class="text-decoration-none">
                                        {{ $customer->name }}
                                    </a>
                                    <br>
                                    <small class="text-muted">{{ $customer->phone }}</small>
                                </td>
                                <td class="text-end">
                                    <span class="badge bg-info">{{ $customer->policy_count }}</span>
                                </td>
                                <td class="text-end">
                                    <strong class="text-success">{{ number_format($customer->total_premium, 2) }} ₺</strong>
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Yeni Müşteri Trendi
const newCustomersCtx = document.getElementById('newCustomersChart').getContext('2d');
new Chart(newCustomersCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlyNewCustomers->pluck('month')) !!},
        datasets: [{
            label: 'Yeni Müşteri Sayısı',
            data: {!! json_encode($monthlyNewCustomers->pluck('count')) !!},
            borderColor: 'rgb(54, 162, 235)',
            backgroundColor: 'rgba(54, 162, 235, 0.1)',
            tension: 0.4,
            fill: true
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
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Yaş Dağılımı

</script>
@endpush
