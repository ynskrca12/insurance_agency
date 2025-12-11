@extends('layouts.app')

@section('title', 'Yenileme Takvimi')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="bi bi-calendar3 me-2"></i>Yenileme Takvimi
    </h1>
    <a href="{{ route('renewals.index') }}" class="btn btn-secondary">
        <i class="bi bi-list me-2"></i>Liste Görünümü
    </a>
</div>

<!-- Ay Seçimi -->
<div class="card mb-3 border-0 shadow-sm">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-md-4">
                <div class="btn-group w-100">
                    <a href="{{ route('renewals.calendar', ['month' => $startDate->copy()->subMonth()->month, 'year' => $startDate->copy()->subMonth()->year]) }}"
                       class="btn btn-outline-primary">
                        <i class="bi bi-chevron-left"></i> Önceki Ay
                    </a>
                    <a href="{{ route('renewals.calendar', ['month' => now()->month, 'year' => now()->year]) }}"
                       class="btn btn-outline-primary">
                        Bugün
                    </a>
                    <a href="{{ route('renewals.calendar', ['month' => $startDate->copy()->addMonth()->month, 'year' => $startDate->copy()->addMonth()->year]) }}"
                       class="btn btn-outline-primary">
                        Sonraki Ay <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <h4 class="mb-0">{{ $startDate->locale('tr')->isoFormat('MMMM YYYY') }}</h4>
            </div>
            <div class="col-md-4 text-end">
                <div class="d-inline-block me-3">
                    <span class="badge bg-danger">Kritik</span> ≤ 7 gün
                </div>
                <div class="d-inline-block me-3">
                    <span class="badge bg-warning">Yaklaşan</span> ≤ 30 gün
                </div>
                <div class="d-inline-block">
                    <span class="badge bg-info">Normal</span> > 30 gün
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Takvim -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-bordered mb-0" style="table-layout: fixed;">
                <thead class="bg-light">
                    <tr>
                        <th class="text-center py-3">Pazartesi</th>
                        <th class="text-center py-3">Salı</th>
                        <th class="text-center py-3">Çarşamba</th>
                        <th class="text-center py-3">Perşembe</th>
                        <th class="text-center py-3">Cuma</th>
                        <th class="text-center py-3">Cumartesi</th>
                        <th class="text-center py-3">Pazar</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $currentDate = $startDate->copy()->startOfWeek();
                        $endOfCalendar = $endDate->copy()->endOfWeek();
                        $today = now()->format('Y-m-d');
                    @endphp

                    @while($currentDate <= $endOfCalendar)
                        <tr style="height: 150px;">
                            @for($i = 0; $i < 7; $i++)
                                @php
                                    $dateKey = $currentDate->format('Y-m-d');
                                    $dayRenewals = $renewals->get($dateKey, collect());
                                    $isCurrentMonth = $currentDate->month === $month;
                                    $isToday = $dateKey === $today;
                                @endphp
                                <td class="p-2 align-top {{ !$isCurrentMonth ? 'bg-light' : '' }} {{ $isToday ? 'border-primary border-3' : '' }}">
                                    <!-- Gün Başlığı -->
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong class="{{ $isToday ? 'text-primary' : ($isCurrentMonth ? '' : 'text-muted') }}">
                                            {{ $currentDate->day }}
                                        </strong>
                                        @if($dayRenewals->isNotEmpty())
                                            <span class="badge bg-secondary">{{ $dayRenewals->count() }}</span>
                                        @endif
                                    </div>

                                    <!-- Yenilemeler -->
                                    @foreach($dayRenewals->take(3) as $renewal)
                                        @php
                                            $daysUntil = now()->diffInDays($renewal->renewal_date, false);
                                            $badgeColor = $daysUntil <= 0 ? 'danger' : ($daysUntil <= 7 ? 'danger' : ($daysUntil <= 30 ? 'warning' : 'info'));
                                        @endphp
                                        <a href="{{ route('renewals.show', $renewal) }}"
                                           class="d-block text-decoration-none mb-1">
                                            <div class="badge bg-{{ $badgeColor }} text-start w-100 text-truncate"
                                                 style="font-size: 0.7rem; padding: 0.25rem 0.5rem;"
                                                 title="{{ $renewal->policy->customer->name }} - {{ $renewal->policy->policy_number }}">
                                                <i class="bi bi-circle-fill me-1" style="font-size: 0.5rem;"></i>
                                                {{ Str::limit($renewal->policy->customer->name, 15) }}
                                            </div>
                                        </a>
                                    @endforeach

                                    @if($dayRenewals->count() > 3)
                                        <div class="text-center">
                                            <small class="text-muted">+{{ $dayRenewals->count() - 3 }} daha</small>
                                        </div>
                                    @endif
                                </td>
                                @php
                                    $currentDate->addDay();
                                @endphp
                            @endfor
                        </tr>
                    @endwhile
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Özet İstatistikler -->
<div class="row g-3 mt-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="text-danger mb-0">{{ $renewals->flatten()->filter(fn($r) => $r->days_until_renewal <= 7)->count() }}</h3>
                <small class="text-muted">Kritik (7 gün)</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="text-warning mb-0">{{ $renewals->flatten()->filter(fn($r) => $r->days_until_renewal > 7 && $r->days_until_renewal <= 30)->count() }}</h3>
                <small class="text-muted">Yaklaşan (30 gün)</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="text-primary mb-0">{{ $renewals->flatten()->count() }}</h3>
                <small class="text-muted">Toplam (Bu Ay)</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="text-info mb-0">{{ number_format($renewals->flatten()->sum(fn($r) => $r->policy->premium_amount), 2) }} ₺</h3>
                <small class="text-muted">Toplam Prim</small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .table-bordered td {
        vertical-align: top !important;
    }

    .badge {
        cursor: pointer;
        transition: all 0.2s;
    }

    .badge:hover {
        transform: translateX(3px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    }
</style>
@endpush
