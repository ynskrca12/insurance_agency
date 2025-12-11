@extends('layouts.app')

@section('title', 'Poliçe Yenilemeleri')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">
            <i class="bi bi-arrow-repeat me-2"></i>Poliçe Yenilemeleri
        </h1>
        <p class="text-muted mb-0">Toplam: {{ $renewals->total() }} yenileme</p>
    </div>
    <div>
        <a href="{{ route('renewals.calendar') }}" class="btn btn-info">
            <i class="bi bi-calendar3 me-2"></i>Takvim Görünümü
        </a>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bulkReminderModal">
            <i class="bi bi-send me-2"></i>Toplu Hatırlatıcı
        </button>
    </div>
</div>

<!-- İstatistik Kartları -->
<div class="row g-3 mb-3">
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-primary">{{ number_format($stats['total']) }}</h3>
                <small class="text-muted">Toplam</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-warning">{{ number_format($stats['pending']) }}</h3>
                <small class="text-muted">Bekliyor</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-info">{{ number_format($stats['contacted']) }}</h3>
                <small class="text-muted">İletişimde</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-danger">{{ number_format($stats['critical']) }}</h3>
                <small class="text-muted">Kritik</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-success">{{ number_format($stats['renewed']) }}</h3>
                <small class="text-muted">Yenilendi</small>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-secondary">{{ number_format($stats['lost']) }}</h3>
                <small class="text-muted">Kaybedildi</small>
            </div>
        </div>
    </div>
</div>

<!-- Filtreler -->
<div class="card mb-3 border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('renewals.index') }}" id="filterForm">
            <div class="row g-3">
                <!-- Arama -->
                <div class="col-md-3">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text"
                               class="form-control border-start-0"
                               name="search"
                               placeholder="Poliçe no, müşteri ara..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Durum -->
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Tüm Durumlar</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Bekliyor</option>
                        <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>İletişimde</option>
                        <option value="renewed" {{ request('status') === 'renewed' ? 'selected' : '' }}>Yenilendi</option>
                        <option value="lost" {{ request('status') === 'lost' ? 'selected' : '' }}>Kaybedildi</option>
                    </select>
                </div>

                <!-- Öncelik -->
                <div class="col-md-2">
                    <select name="priority" class="form-select">
                        <option value="">Tüm Öncelikler</option>
                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Düşük</option>
                        <option value="normal" {{ request('priority') === 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>Yüksek</option>
                        <option value="critical" {{ request('priority') === 'critical' ? 'selected' : '' }}>Kritik</option>
                    </select>
                </div>

                <!-- Tarih Filtresi -->
                <div class="col-md-3">
                    <select name="date_filter" class="form-select">
                        <option value="">Tüm Tarihler</option>
                        <option value="critical" {{ request('date_filter') === 'critical' ? 'selected' : '' }}>Kritik (7 Gün)</option>
                        <option value="upcoming" {{ request('date_filter') === 'upcoming' ? 'selected' : '' }}>Yaklaşan (30 Gün)</option>
                        <option value="overdue" {{ request('date_filter') === 'overdue' ? 'selected' : '' }}>Gecikmiş</option>
                    </select>
                </div>

                <!-- Buton -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i> Filtrele
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Tablo -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Poliçe No</th>
                        <th>Müşteri</th>
                        <th>Tür</th>
                        <th>Şirket</th>
                        <th>Yenileme Tarihi</th>
                        <th>Kalan Gün</th>
                        <th>Öncelik</th>
                        <th>Durum</th>
                        <th class="pe-4 text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($renewals as $renewal)
                    @php
                        $daysLeft = $renewal->days_until_renewal;
                        $isOverdue = $daysLeft < 0;
                        $isCritical = $daysLeft >= 0 && $daysLeft <= 7;
                        $isUrgent = $daysLeft > 7 && $daysLeft <= 30;
                    @endphp
                    <tr class="{{ $isOverdue ? 'table-danger' : ($isCritical ? 'table-warning' : '') }}">
                        <td class="ps-4">
                            <a href="{{ route('policies.show', $renewal->policy) }}" class="text-decoration-none">
                                <strong>{{ $renewal->policy->policy_number }}</strong>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('customers.show', $renewal->policy->customer) }}"
                               class="text-decoration-none text-dark">
                                {{ $renewal->policy->customer->name }}
                            </a>
                            <br>
                            <small class="text-muted">{{ $renewal->policy->customer->phone }}</small>
                        </td>
                        <td>
                            <span class="badge rounded-pill bg-info">
                                {{ $renewal->policy->policy_type_label }}
                            </span>
                        </td>
                        <td>
                            <small>{{ $renewal->policy->insuranceCompany->code }}</small>
                        </td>
                        <td>
                            <strong>{{ $renewal->renewal_date->format('d.m.Y') }}</strong>
                        </td>
                        <td>
                            @if($isOverdue)
                                <span class="badge bg-danger">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    {{ abs($daysLeft) }} gün geçti
                                </span>
                            @elseif($isCritical)
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-clock me-1"></i>
                                    {{ $daysLeft }} gün
                                </span>
                            @elseif($isUrgent)
                                <span class="badge bg-info">
                                    {{ $daysLeft }} gün
                                </span>
                            @else
                                <span class="text-muted">{{ $daysLeft }} gün</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $priorityConfig = [
                                    'low' => ['color' => 'secondary', 'label' => 'Düşük'],
                                    'normal' => ['color' => 'info', 'label' => 'Normal'],
                                    'high' => ['color' => 'warning', 'label' => 'Yüksek'],
                                    'critical' => ['color' => 'danger', 'label' => 'Kritik'],
                                ];
                                $priority = $priorityConfig[$renewal->priority] ?? ['color' => 'secondary', 'label' => 'Normal'];
                            @endphp
                            <span class="badge bg-{{ $priority['color'] }}">
                                {{ $priority['label'] }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusConfig = [
                                    'pending' => ['color' => 'warning', 'label' => 'Bekliyor'],
                                    'contacted' => ['color' => 'info', 'label' => 'İletişimde'],
                                    'renewed' => ['color' => 'success', 'label' => 'Yenilendi'],
                                    'lost' => ['color' => 'danger', 'label' => 'Kaybedildi'],
                                ];
                                $status = $statusConfig[$renewal->status] ?? ['color' => 'secondary', 'label' => $renewal->status];
                            @endphp
                            <span class="badge bg-{{ $status['color'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('renewals.show', $renewal) }}"
                                   class="btn btn-outline-info"
                                   title="Detay">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($renewal->status === 'pending')
                                <form method="POST" action="{{ route('renewals.sendReminder', $renewal) }}" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-outline-success"
                                            title="Hatırlatıcı Gönder">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mb-0 mt-2">Yenileme kaydı bulunmuyor.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
@if($renewals->hasPages())
<div class="mt-3">
    {{ $renewals->links() }}
</div>
@endif

<!-- Toplu Hatırlatıcı Modal -->
<div class="modal fade" id="bulkReminderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-send me-2"></i>Toplu Hatırlatıcı Gönder
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('renewals.bulkSendReminders') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Hedef Grup</label>
                        <select class="form-select" name="filter" required>
                            <option value="critical">Kritik (7 gün içinde - {{ $stats['critical'] }} adet)</option>
                            <option value="upcoming">Yaklaşan (30 gün içinde)</option>
                            <option value="all">Tümü (Bekliyor + İletişimde)</option>
                        </select>
                    </div>
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Seçilen gruptaki tüm müşterilere SMS hatırlatıcısı gönderilecektir.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-send me-2"></i>Gönder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Filtre değişimi otomatik gönderim
    $('select[name="status"], select[name="priority"], select[name="date_filter"]')
        .on('change', function() {
            $('#filterForm').submit();
        });

    // Arama input debounce
    let searchTimeout;
    $('input[name="search"]').on('input', function() {
        clearTimeout(searchTimeout);
        const value = $(this).val();

        if (value.length >= 3 || value.length === 0) {
            searchTimeout = setTimeout(function() {
                $('#filterForm').submit();
            }, 500);
        }
    });
});
</script>
@endpush
