@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="bi bi-speedometer2 me-2"></i>Dashboard
    </h1>
    <div class="text-muted">
        <i class="bi bi-calendar3"></i>
        {{ now()->isoFormat('D MMMM YYYY, dddd') }}
    </div>
</div>

<!-- İstatistik Kartları -->
<div class="row g-3 mb-4">
    <!-- Toplam Müşteri -->
    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Toplam Müşteri</h6>
                        <h2 class="mb-0">{{ number_format($stats['total_customers']) }}</h2>
                    </div>
                    <div class="text-primary" style="font-size: 2.5rem;">
                        <i class="bi bi-people"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toplam Poliçe -->
    <div class="col-md-3">
        <div class="card stat-card" style="border-left-color: #28a745;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Toplam Poliçe</h6>
                        <h2 class="mb-0">{{ number_format($stats['total_policies']) }}</h2>
                    </div>
                    <div class="text-success" style="font-size: 2.5rem;">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Süresi Yaklaşan -->
    <div class="col-md-3">
        <div class="card stat-card" style="border-left-color: #ffc107;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Süresi Yaklaşan</h6>
                        <h2 class="mb-0">{{ number_format($stats['expiring_soon']) }}</h2>
                    </div>
                    <div class="text-warning" style="font-size: 2.5rem;">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bekleyen Görevler -->
    <div class="col-md-3">
        <div class="card stat-card" style="border-left-color: #dc3545;">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-muted mb-2">Bekleyen Görev</h6>
                        <h2 class="mb-0">{{ number_format($stats['pending_tasks']) }}</h2>
                    </div>
                    <div class="text-danger" style="font-size: 2.5rem;">
                        <i class="bi bi-check-square"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Süresi Yaklaşan Poliçeler -->
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-exclamation-circle text-warning me-2"></i>
                    Süresi Yaklaşan Poliçeler
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Müşteri</th>
                                <th>Poliçe No</th>
                                <th>Tür</th>
                                <th>Bitiş Tarihi</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($expiringPolicies as $policy)
                            <tr>
                                <td>{{ $policy->customer->name }}</td>
                                <td>{{ $policy->policy_number }}</td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $policy->policy_type_label }}
                                    </span>
                                </td>
                                <td>{{ $policy->end_date->format('d.m.Y') }}</td>
                                <td>
                                    @if($policy->status === 'critical')
                                        <span class="badge bg-danger">Kritik</span>
                                    @else
                                        <span class="badge bg-warning">Yaklaşıyor</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">
                                    Süresi yaklaşan poliçe bulunmuyor.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Son Müşteriler -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-person-plus text-primary me-2"></i>
                    Son Eklenen Müşteriler
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @forelse($recentCustomers as $customer)
                    <a href="{{ route('customers.show', $customer) }}"
                       class="list-group-item list-group-item-action border-0 px-0">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <div class="avatar bg-primary text-white rounded-circle d-flex align-items-center justify-content-center"
                                     style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">{{ $customer->name }}</h6>
                                <small class="text-muted">{{ $customer->phone }}</small>
                            </div>
                        </div>
                    </a>
                    @empty
                    <p class="text-muted text-center mb-0">Henüz müşteri eklenmemiş.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Sayfa yüklendiğinde animasyonlar
    $('.stat-card').each(function(index) {
        $(this).hide().delay(100 * index).fadeIn(500);
    });
});
</script>
@endpush
