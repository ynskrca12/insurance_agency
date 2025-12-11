@extends('layouts.app')

@section('title', 'Taksit Planları')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">
            <i class="bi bi-calendar3 me-2"></i>Taksit Planları
        </h1>
        <p class="text-muted mb-0">Toplam: {{ $installments->total() }} taksit</p>
    </div>
    <div>
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#bulkReminderModal">
            <i class="bi bi-send me-2"></i>Toplu Hatırlatıcı
        </button>
        <a href="{{ route('payments.index') }}" class="btn btn-secondary">
            <i class="bi bi-credit-card me-2"></i>Ödemeler
        </a>
    </div>
</div>

<!-- İstatistik Kartları -->
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h5 class="mb-0 text-warning">{{ number_format($stats['total_pending'], 2) }} ₺</h5>
                <small class="text-muted">Bekleyen Toplam</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h5 class="mb-0 text-danger">{{ number_format($stats['overdue_count']) }}</h5>
                <small class="text-muted">Gecikmiş ({{ number_format($stats['overdue_amount'], 2) }} ₺)</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h5 class="mb-0 text-info">{{ number_format($stats['due_today_count']) }}</h5>
                <small class="text-muted">Bugün Vadesi Dolan</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h5 class="mb-0 text-primary">{{ number_format($stats['upcoming_7_count']) }}</h5>
                <small class="text-muted">7 Gün İçinde</small>
            </div>
        </div>
    </div>
</div>

<!-- Filtreler -->
<div class="card mb-3 border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('payments.installments') }}" id="filterForm">
            <div class="row g-3">
                <!-- Arama -->
                <div class="col-md-4">
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
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Bekliyor</option>
                        <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Ödendi</option>
                        <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Gecikmiş</option>
                    </select>
                </div>

                <!-- Tarih Filtresi -->
                <div class="col-md-3">
                    <select name="date_filter" class="form-select">
                        <option value="">Tüm Tarihler</option>
                        <option value="due_today" {{ request('date_filter') === 'due_today' ? 'selected' : '' }}>Bugün Vadesi Dolan</option>
                        <option value="overdue" {{ request('date_filter') === 'overdue' ? 'selected' : '' }}>Gecikmiş</option>
                        <option value="upcoming_7" {{ request('date_filter') === 'upcoming_7' ? 'selected' : '' }}>7 Gün İçinde</option>
                        <option value="upcoming_30" {{ request('date_filter') === 'upcoming_30' ? 'selected' : '' }}>30 Gün İçinde</option>
                    </select>
                </div>

                <!-- Buton -->
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel me-2"></i>Filtrele
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
                        <th class="ps-4">Müşteri</th>
                        <th>Poliçe</th>
                        <th>Taksit</th>
                        <th>Vade Tarihi</th>
                        <th>Kalan Gün</th>
                        <th>Tutar</th>
                        <th>Durum</th>
                        <th class="pe-4 text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($installments as $installment)
                    @php
                        $daysUntilDue = now()->diffInDays($installment->due_date, false);
                        $isOverdue = $daysUntilDue < 0;
                        $isDueToday = $daysUntilDue === 0;
                        $isCritical = $daysUntilDue > 0 && $daysUntilDue <= 7;
                    @endphp
                    <tr class="{{ $isOverdue ? 'table-danger' : ($isDueToday ? 'table-warning' : '') }}">
                        <td class="ps-4">
                            <a href="{{ route('customers.show', $installment->paymentPlan->customer) }}"
                               class="text-decoration-none text-dark">
                                {{ $installment->paymentPlan->customer->name }}
                            </a>
                            <br>
                            <small class="text-muted">{{ $installment->paymentPlan->customer->phone }}</small>
                        </td>
                        <td>
                            <a href="{{ route('policies.show', $installment->paymentPlan->policy) }}"
                               class="text-decoration-none">
                                {{ $installment->paymentPlan->policy->policy_number }}
                            </a>
                        </td>
                        <td>
                            <span class="badge bg-info">
                                {{ $installment->installment_number }}/{{ $installment->paymentPlan->installment_count }}
                            </span>
                        </td>
                        <td>
                            <strong>{{ $installment->due_date->format('d.m.Y') }}</strong>
                        </td>
                        <td>
                            @if($isOverdue)
                                <span class="badge bg-danger">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    {{ abs($daysUntilDue) }} gün geçti
                                </span>
                            @elseif($isDueToday)
                                <span class="badge bg-warning text-dark">
                                    <i class="bi bi-clock me-1"></i>
                                    Bugün
                                </span>
                            @elseif($isCritical)
                                <span class="badge bg-warning">
                                    {{ $daysUntilDue }} gün
                                </span>
                            @else
                                <span class="text-muted">{{ $daysUntilDue }} gün</span>
                            @endif
                        </td>
                        <td>
                            <strong class="text-success">{{ number_format($installment->amount, 2) }} ₺</strong>
                        </td>
                        <td>
                            @php
                                $statusConfig = [
                                    'pending' => ['color' => 'warning', 'label' => 'Bekliyor'],
                                    'paid' => ['color' => 'success', 'label' => 'Ödendi'],
                                    'overdue' => ['color' => 'danger', 'label' => 'Gecikmiş'],
                                ];
                                $status = $statusConfig[$installment->status] ?? ['color' => 'secondary', 'label' => $installment->status];
                            @endphp
                            <span class="badge bg-{{ $status['color'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="btn-group btn-group-sm">
                                @if($installment->status === 'pending' || $installment->status === 'overdue')
                                <button type="button"
                                        class="btn btn-outline-success"
                                        data-bs-toggle="modal"
                                        data-bs-target="#paymentModal"
                                        onclick="setInstallmentData({{ $installment->id }}, '{{ $installment->paymentPlan->customer->name }}', '{{ $installment->paymentPlan->policy->policy_number }}', {{ $installment->installment_number }}, {{ $installment->amount }})"
                                        title="Ödeme Kaydet">
                                    <i class="bi bi-cash"></i>
                                </button>
                                <form method="POST" action="{{ route('payments.sendReminder', $installment) }}" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-outline-info"
                                            title="Hatırlatıcı Gönder">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </form>
                                @endif
                                @if($installment->payment)
                                <a href="{{ route('payments.show', $installment->payment) }}"
                                   class="btn btn-outline-primary"
                                   title="Ödeme Detayı">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mb-0 mt-2">Taksit kaydı bulunmuyor.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
@if($installments->hasPages())
<div class="mt-3">
    {{ $installments->links() }}
</div>
@endif

<!-- Ödeme Kaydet Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-cash me-2"></i>Ödeme Kaydet
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('payments.store') }}">
                @csrf
                <input type="hidden" name="installment_id" id="installment_id">
                <div class="modal-body">
                    <div class="alert alert-info" id="payment_info">
                        <!-- JavaScript ile doldurulacak -->
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ödeme Tutarı (₺) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="amount" id="payment_amount" step="0.01" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ödeme Tarihi <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="payment_date" value="{{ now()->format('Y-m-d') }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ödeme Yöntemi <span class="text-danger">*</span></label>
                        <select class="form-select" name="payment_method" required>
                            <option value="cash">Nakit</option>
                            <option value="credit_card">Kredi Kartı</option>
                            <option value="bank_transfer">Havale/EFT</option>
                            <option value="check">Çek</option>
                            <option value="pos">POS</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Referans No</label>
                        <input type="text" class="form-control" name="payment_reference" placeholder="Dekont no, işlem no vb.">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Notlar</label>
                        <textarea class="form-control" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-2"></i>Ödemeyi Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

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
            <form method="POST" action="{{ route('payments.bulkSendReminders') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Hedef Grup</label>
                        <select class="form-select" name="filter" required>
                            <option value="overdue">Gecikmiş Ödemeler ({{ $stats['overdue_count'] }} adet)</option>
                            <option value="due_today">Bugün Vadesi Dolan ({{ $stats['due_today_count'] }} adet)</option>
                            <option value="upcoming_7">7 Gün İçinde ({{ $stats['upcoming_7_count'] }} adet)</option>
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
function setInstallmentData(id, customer, policy, installmentNo, amount) {
    document.getElementById('installment_id').value = id;
    document.getElementById('payment_amount').value = amount;
    document.getElementById('payment_info').innerHTML = `
        <strong>Müşteri:</strong> ${customer}<br>
        <strong>Poliçe:</strong> ${policy}<br>
        <strong>Taksit:</strong> ${installmentNo}. Taksit<br>
        <strong>Tutar:</strong> ${parseFloat(amount).toFixed(2)} ₺
    `;
}

$(document).ready(function() {
    // Filtre değişimi otomatik gönderim
    $('select[name="status"], select[name="date_filter"]')
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
