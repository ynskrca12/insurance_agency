@extends('layouts.app')

@section('title', 'Yenileme Raporları')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">
            <i class="bi bi-arrow-repeat me-2"></i>Yenileme Raporları
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
        <form method="GET" action="{{ route('reports.renewals') }}">
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
                <h2 class="mb-0 text-primary">{{ number_format($stats['total_renewals']) }}</h2>
                <small class="text-muted">Toplam Yenileme</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-success">{{ number_format($stats['renewed']) }}</h2>
                <small class="text-muted">Yenilendi</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-warning">{{ number_format($stats['pending_renewals']) }}</h2>
                <small class="text-muted">Bekliyor</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body text-center">
                <h2 class="mb-0">%{{ number_format($stats['success_rate'], 1) }}</h2>
                <small>Başarı Oranı</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Haftalık Yenileme Trendi -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-graph-up me-2"></i>Haftalık Yenileme Trendi
                </h5>
            </div>
            <div class="card-body">
                <canvas id="weeklyRenewalsChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Durum Dağılımı -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-pie-chart me-2"></i>Durum Dağılımı
                </h5>
            </div>
            <div class="card-body">
                <canvas id="statusDistributionChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Öncelik Dağılımı -->
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-exclamation-triangle me-2"></i>Öncelik Dağılımı
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Öncelik</th>
                                <th class="text-end">Adet</th>
                                <th class="text-end">Oran</th>
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
                                    <span class="badge bg-{{ $priorityColors[$priority->priority] ?? 'secondary' }}">
                                        {{ $priorityLabels[$priority->priority] ?? $priority->priority }}
                                    </span>
                                </td>
                                <td class="text-end">{{ number_format($priority->count) }}</td>
                                <td class="text-end">
                                    @php
                                        $percentage = $stats['total_renewals'] > 0 ? ($priority->count / $stats['total_renewals']) * 100 : 0;
                                    @endphp
                                    <div class="progress" style="height: 20px; min-width: 100px;">
                                        <div class="progress-bar bg-{{ $priorityColors[$priority->priority] ?? 'secondary' }}"
                                             role="progressbar"
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
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-x-circle me-2"></i>Kayıp Nedenleri
                </h5>
            </div>
            <div class="card-body">
                @if($lostReasons->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-hover table-sm">
                        <thead>
                            <tr>
                                <th>Neden</th>
                                <th class="text-end">Adet</th>
                                <th class="text-end">Oran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $reasonLabels = [
                                    'price' => 'Fiyat',
                                    'service' => 'Hizmet',
                                    'competitor' => 'Rakip',
                                    'customer_decision' => 'Müşteri Kararı',
                                    'other' => 'Diğer',
                                ];
                            @endphp
                            @foreach($lostReasons as $reason)
                            <tr>
                                <td>{{ $reasonLabels[$reason->lost_reason] ?? $reason->lost_reason }}</td>
                                <td class="text-end">{{ number_format($reason->count) }}</td>
                                <td class="text-end">
                                    @php
                                        $percentage = $stats['lost'] > 0 ? ($reason->count / $stats['lost']) * 100 : 0;
                                    @endphp
                                    <span class="badge bg-danger">{{ number_format($percentage, 1) }}%</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center mb-0">Kayıp kaydı bulunmuyor.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
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
                backgroundColor: 'rgba(75, 192, 192, 0.8)'
            },
            {
                label: 'Kayıp',
                data: {!! json_encode($weeklyRenewals->pluck('lost')) !!},
                backgroundColor: 'rgba(255, 99, 132, 0.8)'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                stacked: false
            },
            y: {
                stacked: false,
                beginAtZero: true
            }
        }
    }
});

// Durum Dağılımı
const statusCtx = document.getElementById('statusDistributionChart').getContext('2d');
new Chart(statusCtx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($renewalsByStatus->pluck('status')->map(function($status) {
            $labels = ['pending' => 'Bekliyor', 'contacted' => 'İletişimde', 'renewed' => 'Yenilendi', 'lost' => 'Kayıp'];
            return $labels[$status] ?? $status;
        })) !!},
        datasets: [{
            data: {!! json_encode($renewalsByStatus->pluck('count')) !!},
            backgroundColor: [
                'rgba(255, 206, 86, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(255, 99, 132, 0.8)'
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
