@extends('layouts.app')

@section('title', 'Ödeme Raporları')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">
            <i class="bi bi-cash-coin me-2"></i>Ödeme Raporları
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
        <form method="GET" action="{{ route('reports.payments') }}">
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
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body text-center">
                <h2 class="mb-0">{{ number_format($stats['total_collected'], 2) }} ₺</h2>
                <small>Toplam Tahsilat</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-primary">{{ number_format($stats['total_payments']) }}</h2>
                <small class="text-muted">Ödeme Sayısı</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-warning">{{ number_format($pendingPayments, 2) }} ₺</h2>
                <small class="text-muted">Bekleyen Ödemeler</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h2 class="mb-0 text-danger">{{ number_format($overduePayments, 2) }} ₺</h2>
                <small class="text-muted">Gecikmiş Ödemeler</small>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Günlük Tahsilat Trendi -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-graph-up me-2"></i>Günlük Tahsilat Trendi
                </h5>
            </div>
            <div class="card-body">
                <canvas id="dailyCollectionsChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Ödeme Yöntemi Dağılımı -->
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-pie-chart me-2"></i>Ödeme Yöntemi Dağılımı
                </h5>
            </div>
            <div class="card-body">
                <canvas id="paymentMethodChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Ödeme Yöntemleri Detay -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-credit-card me-2"></i>Ödeme Yöntemlerine Göre Detay
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Ödeme Yöntemi</th>
                                <th class="text-end">İşlem Sayısı</th>
                                <th class="text-end">Toplam Tutar</th>
                                <th class="text-end">Ortalama</th>
                                <th class="text-end">Oran</th>
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
                                    <i class="bi bi-{{ $methodIcons[$method->payment_method] ?? 'cash' }} me-2"></i>
                                    <strong>{{ $methodLabels[$method->payment_method] ?? $method->payment_method }}</strong>
                                </td>
                                <td class="text-end">{{ number_format($method->count) }}</td>
                                <td class="text-end">
                                    <strong class="text-success">{{ number_format($method->total_amount, 2) }} ₺</strong>
                                </td>
                                <td class="text-end">{{ number_format($method->total_amount / $method->count, 2) }} ₺</td>
                                <td class="text-end">
                                    @php
                                        $percentage = $stats['total_collected'] > 0 ? ($method->total_amount / $stats['total_collected']) * 100 : 0;
                                    @endphp
                                    <div class="progress" style="height: 20px; min-width: 100px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $percentage }}%">
                                            {{ number_format($percentage, 1) }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light">
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
    </div>

    <!-- Nakit Akışı Özeti -->
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bi bi-wallet2 me-2"></i>Nakit Akışı Özeti
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <div class="p-3 bg-light rounded">
                            <h4 class="text-success mb-1">{{ number_format($stats['cash_payments'], 2) }} ₺</h4>
                            <small class="text-muted">Nakit Tahsilat</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-light rounded">
                            <h4 class="text-info mb-1">{{ number_format($stats['card_payments'], 2) }} ₺</h4>
                            <small class="text-muted">Kart Tahsilat</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-light rounded">
                            <h4 class="text-warning mb-1">{{ number_format($pendingPayments, 2) }} ₺</h4>
                            <small class="text-muted">Bekleyen</small>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 bg-light rounded">
                            <h4 class="text-danger mb-1">{{ number_format($overduePayments, 2) }} ₺</h4>
                            <small class="text-muted">Gecikmiş</small>
                        </div>
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
// Günlük Tahsilat Trendi
const dailyCtx = document.getElementById('dailyCollectionsChart').getContext('2d');
new Chart(dailyCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($dailyCollections->pluck('date')) !!},
        datasets: [{
            label: 'Tahsilat (₺)',
            data: {!! json_encode($dailyCollections->pluck('total_amount')) !!},
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

// Ödeme Yöntemi Dağılımı
const methodCtx = document.getElementById('paymentMethodChart').getContext('2d');
new Chart(methodCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($paymentsByMethod->pluck('payment_method')->map(function($method) {
            $labels = ['cash' => 'Nakit', 'credit_card' => 'Kredi Kartı', 'bank_transfer' => 'Havale/EFT', 'check' => 'Çek', 'pos' => 'POS'];
            return $labels[$method] ?? $method;
        })) !!},
        datasets: [{
            data: {!! json_encode($paymentsByMethod->pluck('total_amount')) !!},
            backgroundColor: [
                'rgba(75, 192, 192, 0.8)',
                'rgba(54, 162, 235, 0.8)',
                'rgba(255, 206, 86, 0.8)',
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
