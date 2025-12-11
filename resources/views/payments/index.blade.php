@extends('layouts.app')

@section('title', 'Ödemeler')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">
            <i class="bi bi-credit-card me-2"></i>Ödemeler
        </h1>
        <p class="text-muted mb-0">Toplam: {{ $payments->total() }} ödeme</p>
    </div>
    <a href="{{ route('payments.installments') }}" class="btn btn-primary">
        <i class="bi bi-calendar3 me-2"></i>Taksit Planları
    </a>
</div>

<!-- İstatistik Kartları -->
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h5 class="mb-0 text-success">{{ number_format($stats['total'], 2) }} ₺</h5>
                <small class="text-muted">Toplam Tahsilat</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h5 class="mb-0 text-primary">{{ number_format($stats['completed'], 2) }} ₺</h5>
                <small class="text-muted">Tamamlanan</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h5 class="mb-0 text-warning">{{ number_format($stats['pending'], 2) }} ₺</h5>
                <small class="text-muted">Bekleyen</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h5 class="mb-0 text-danger">{{ number_format($stats['failed'], 2) }} ₺</h5>
                <small class="text-muted">Başarısız</small>
            </div>
        </div>
    </div>
</div>

<!-- Filtreler -->
<div class="card mb-3 border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('payments.index') }}" id="filterForm">
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
                               placeholder="Müşteri, poliçe ara..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                <!-- Durum -->
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Tüm Durumlar</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Bekliyor</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Başarısız</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>İptal</option>
                    </select>
                </div>

                <!-- Ödeme Yöntemi -->
                <div class="col-md-2">
                    <select name="payment_method" class="form-select">
                        <option value="">Tüm Yöntemler</option>
                        <option value="cash" {{ request('payment_method') === 'cash' ? 'selected' : '' }}>Nakit</option>
                        <option value="credit_card" {{ request('payment_method') === 'credit_card' ? 'selected' : '' }}>Kredi Kartı</option>
                        <option value="bank_transfer" {{ request('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Havale/EFT</option>
                        <option value="check" {{ request('payment_method') === 'check' ? 'selected' : '' }}>Çek</option>
                        <option value="pos" {{ request('payment_method') === 'pos' ? 'selected' : '' }}>POS</option>
                    </select>
                </div>

                <!-- Tarih Başlangıç -->
                <div class="col-md-2">
                    <input type="date"
                           class="form-control"
                           name="date_from"
                           placeholder="Başlangıç"
                           value="{{ request('date_from') }}">
                </div>

                <!-- Tarih Bitiş -->
                <div class="col-md-2">
                    <input type="date"
                           class="form-control"
                           name="date_to"
                           placeholder="Bitiş"
                           value="{{ request('date_to') }}">
                </div>

                <!-- Buton -->
                <div class="col-md-1">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i>
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
                        <th class="ps-4">Tarih</th>
                        <th>Referans No</th>
                        <th>Müşteri</th>
                        <th>Poliçe</th>
                        <th>Taksit</th>
                        <th>Tutar</th>
                        <th>Yöntem</th>
                        <th>Durum</th>
                        <th class="pe-4 text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td class="ps-4">
                            <strong>{{ $payment->payment_date->format('d.m.Y') }}</strong>
                            <br>
                            <small class="text-muted">{{ $payment->payment_date->format('H:i') }}</small>
                        </td>
                        <td>
                            @if($payment->payment_reference)
                                <strong class="text-primary">{{ $payment->payment_reference }}</strong>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('customers.show', $payment->customer) }}"
                               class="text-decoration-none text-dark">
                                {{ $payment->customer->name }}
                            </a>
                            <br>
                            <small class="text-muted">{{ $payment->customer->phone }}</small>
                        </td>
                        <td>
                            @if($payment->policy)
                                <a href="{{ route('policies.show', $payment->policy) }}"
                                   class="text-decoration-none">
                                    {{ $payment->policy->policy_number }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($payment->installment)
                                <span class="badge bg-info">
                                    {{ $payment->installment->installment_number }}/{{ $payment->installment->paymentPlan->installment_count }}
                                </span>
                            @else
                                <span class="text-muted">Tek Ödeme</span>
                            @endif
                        </td>
                        <td>
                            <strong class="text-success">{{ number_format($payment->amount, 2) }} ₺</strong>
                        </td>
                        <td>
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
                            <i class="bi bi-{{ $methodIcons[$payment->payment_method] ?? 'cash' }} me-1"></i>
                            <small>{{ $methodLabels[$payment->payment_method] ?? $payment->payment_method }}</small>
                        </td>
                        <td>
                            @php
                                $statusConfig = [
                                    'completed' => ['color' => 'success', 'label' => 'Tamamlandı'],
                                    'pending' => ['color' => 'warning', 'label' => 'Bekliyor'],
                                    'failed' => ['color' => 'danger', 'label' => 'Başarısız'],
                                    'cancelled' => ['color' => 'secondary', 'label' => 'İptal'],
                                ];
                                $status = $statusConfig[$payment->status] ?? ['color' => 'secondary', 'label' => $payment->status];
                            @endphp
                            <span class="badge bg-{{ $status['color'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('payments.show', $payment) }}"
                                   class="btn btn-outline-info"
                                   title="Detay">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($payment->status === 'completed')
                                <form method="POST" action="{{ route('payments.cancel', $payment) }}" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-outline-danger"
                                            onclick="return confirm('Bu ödemeyi iptal etmek istediğinizden emin misiniz?')"
                                            title="İptal Et">
                                        <i class="bi bi-x-circle"></i>
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
                            <p class="text-muted mb-0 mt-2">Henüz ödeme kaydı bulunmuyor.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
@if($payments->hasPages())
<div class="mt-3">
    {{ $payments->links() }}
</div>
@endif
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Filtre değişimi otomatik gönderim
    $('select[name="status"], select[name="payment_method"]')
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
