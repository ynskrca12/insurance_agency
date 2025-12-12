@extends('layouts.app')

@section('title', 'Ödemeler')

@push('styles')
<style>
    .page-header {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        padding: 1.25rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        border-color: #b0b0b0;
        background: #fafafa;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        line-height: 1;
    }

    .stat-label {
        font-size: 0.8125rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .filter-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .filter-card .card-body {
        padding: 1.5rem;
    }

    .form-control,
    .form-select {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 0.625rem 0.875rem;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #999;
        box-shadow: 0 0 0 3px rgba(153, 153, 153, 0.1);
    }

    .input-group-text {
        border: 1px solid #dcdcdc;
        border-right: none;
        background: #fafafa;
        color: #6c757d;
        border-radius: 8px 0 0 8px;
    }

    .input-group .form-control {
        border-left: none;
        border-radius: 0 8px 8px 0;
    }

    .input-group .form-control:focus {
        border-left: none;
    }

    .action-btn {
        border-radius: 8px;
        padding: 0.625rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #dcdcdc;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        border-color: #b0b0b0;
    }

    .btn-primary.action-btn {
        border-color: #0d6efd;
    }

    .table-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
    }

    .table-modern {
        margin-bottom: 0;
    }

    .table-modern thead {
        background: #fafafa;
        border-bottom: 2px solid #e8e8e8;
    }

    .table-modern thead th {
        border: none;
        color: #495057;
        font-weight: 600;
        font-size: 0.8125rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 1.25rem;
        white-space: nowrap;
    }

    .table-modern tbody td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #f5f5f5;
    }

    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    .table-modern tbody tr:hover {
        background: #fafafa;
    }

    .payment-ref {
        font-weight: 600;
        color: #0d6efd;
        font-size: 0.9375rem;
        font-family: 'Courier New', monospace;
    }

    .customer-link {
        color: #212529;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .customer-link:hover {
        color: #0d6efd;
    }

    .badge-modern {
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.8125rem;
    }

    .badge-installment {
        background: #e8f4fd;
        color: #0066cc;
        border: 1px solid #b3d9ff;
        padding: 0.25rem 0.625rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .amount-value {
        font-size: 1.125rem;
        font-weight: 700;
        color: #28a745;
    }

    .payment-method-icon {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.25rem 0.625rem;
        background: #f8f9fa;
        border-radius: 6px;
        font-size: 0.8125rem;
        color: #495057;
    }

    .btn-icon {
        width: 2rem;
        height: 2rem;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid #dcdcdc;
        background: #ffffff;
        color: #6c757d;
        transition: all 0.3s ease;
    }

    .btn-icon:hover {
        transform: translateY(-2px);
        border-color: #999;
    }

    .btn-icon.btn-view:hover {
        background: #0dcaf0;
        border-color: #0dcaf0;
        color: #ffffff;
    }

    .btn-icon.btn-cancel:hover {
        background: #dc3545;
        border-color: #dc3545;
        color: #ffffff;
    }

    .action-buttons {
        display: flex;
        gap: 0.25rem;
    }

    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state i {
        font-size: 5rem;
        color: #d0d0d0;
        margin-bottom: 1.5rem;
    }

    .empty-state h5 {
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .empty-state p {
        color: #9ca3af;
        margin-bottom: 0;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-row {
        animation: fadeIn 0.4s ease forwards;
    }

    @media (max-width: 768px) {
        .table-modern {
            font-size: 0.875rem;
        }

        .stat-value {
            font-size: 1.5rem;
        }

        .action-buttons {
            flex-wrap: wrap;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-1 fw-bold text-dark">
                    <i class="bi bi-credit-card me-2"></i>Ödemeler
                </h1>
                <p class="text-muted mb-0 small">Toplam {{ $payments->total() }} ödeme kaydı bulundu</p>
            </div>
            <a href="{{ route('payments.installments') }}" class="btn btn-primary action-btn">
                <i class="bi bi-calendar3 me-2"></i>Taksit Planları
            </a>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-success">{{ number_format($stats['total'], 2) }} ₺</div>
                <div class="stat-label">Toplam Tahsilat</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-primary">{{ number_format($stats['completed'], 2) }} ₺</div>
                <div class="stat-label">Tamamlanan</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-warning">{{ number_format($stats['pending'], 2) }} ₺</div>
                <div class="stat-label">Bekleyen</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-danger">{{ number_format($stats['failed'], 2) }} ₺</div>
                <div class="stat-label">Başarısız</div>
            </div>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="filter-card card">
        <div class="card-body">
            <form method="GET" action="{{ route('payments.index') }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    <!-- Arama -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Arama</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text"
                                   class="form-control"
                                   name="search"
                                   placeholder="Müşteri, poliçe ara..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Durum -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Durum</label>
                        <select name="status" class="form-select">
                            <option value="">Tümü</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Tamamlandı</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Bekliyor</option>
                            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Başarısız</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>İptal</option>
                        </select>
                    </div>

                    <!-- Ödeme Yöntemi -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Yöntem</label>
                        <select name="payment_method" class="form-select">
                            <option value="">Tümü</option>
                            <option value="cash" {{ request('payment_method') === 'cash' ? 'selected' : '' }}>Nakit</option>
                            <option value="credit_card" {{ request('payment_method') === 'credit_card' ? 'selected' : '' }}>Kredi Kartı</option>
                            <option value="bank_transfer" {{ request('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Havale/EFT</option>
                            <option value="check" {{ request('payment_method') === 'check' ? 'selected' : '' }}>Çek</option>
                            <option value="pos" {{ request('payment_method') === 'pos' ? 'selected' : '' }}>POS</option>
                        </select>
                    </div>

                    <!-- Tarih Başlangıç -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Başlangıç</label>
                        <input type="date"
                               class="form-control"
                               name="date_from"
                               value="{{ request('date_from') }}">
                    </div>

                    <!-- Tarih Bitiş -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Bitiş</label>
                        <input type="date"
                               class="form-control"
                               name="date_to"
                               value="{{ request('date_to') }}">
                    </div>

                    <!-- Filtrele Butonu -->
                    <div class="col-lg-1 col-md-12">
                        <button type="submit" class="btn btn-primary action-btn w-100">
                            <i class="bi bi-funnel"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tablo -->
    <div class="table-card card">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>Tarih</th>
                        <th>Referans No</th>
                        <th>Müşteri</th>
                        <th>Poliçe</th>
                        <th>Taksit</th>
                        <th>Tutar</th>
                        <th>Yöntem</th>
                        <th>Durum</th>
                        <th class="text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr class="fade-in-row">
                        <td>
                            <div class="fw-semibold">{{ $payment->payment_date->format('d.m.Y') }}</div>
                            <small class="text-muted">{{ $payment->payment_date->format('H:i') }}</small>
                        </td>
                        <td>
                            @if($payment->payment_reference)
                                <span class="payment-ref">{{ $payment->payment_reference }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('customers.show', $payment->customer) }}" class="customer-link">
                                {{ $payment->customer->name }}
                            </a>
                            <br>
                            <small class="text-muted">{{ $payment->customer->phone }}</small>
                        </td>
                        <td>
                            @if($payment->policy)
                                <a href="{{ route('policies.show', $payment->policy) }}" class="text-decoration-none">
                                    {{ $payment->policy->policy_number }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($payment->installment)
                                <span class="badge-installment">
                                    {{ $payment->installment->installment_number }}/{{ $payment->installment->paymentPlan->installment_count }}
                                </span>
                            @else
                                <span class="text-muted small">Tek Ödeme</span>
                            @endif
                        </td>
                        <td>
                            <span class="amount-value">{{ number_format($payment->amount, 2) }} ₺</span>
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
                            <span class="payment-method-icon">
                                <i class="bi bi-{{ $methodIcons[$payment->payment_method] ?? 'cash' }}"></i>
                                <span>{{ $methodLabels[$payment->payment_method] ?? $payment->payment_method }}</span>
                            </span>
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
                            <span class="badge badge-modern bg-{{ $status['color'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="action-buttons">
                                <a href="{{ route('payments.show', $payment) }}"
                                   class="btn-icon btn-view"
                                   title="Detay">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($payment->status === 'completed')
                                <form method="POST" action="{{ route('payments.cancel', $payment) }}" class="d-inline">
                                    @csrf
                                    <button type="button"
                                            class="btn-icon btn-cancel"
                                            onclick="confirmCancel(this)"
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
                        <td colspan="9">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <h5>Ödeme Bulunamadı</h5>
                                <p>
                                    @if(request()->hasAny(['search', 'status', 'payment_method', 'date_from', 'date_to']))
                                        Arama kriterlerinize uygun ödeme bulunamadı.
                                    @else
                                        Henüz hiç ödeme kaydı bulunmuyor.
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($payments->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $payments->links() }}
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function confirmCancel(button) {
    if (confirm('⚠️ Bu ödemeyi iptal etmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        // Loading state
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        // Submit form
        button.closest('form').submit();
    }
}

$(document).ready(function() {
    // Filtre değişimi otomatik gönderim
    $('select[name="status"], select[name="payment_method"]')
        .on('change', function() {
            $('#filterForm').submit();
        });

    // Tarih değişimi otomatik gönderim
    $('input[name="date_from"], input[name="date_to"]')
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
            }, 600);
        }
    });

    // Satır animasyonları
    let delay = 0;
    $('.fade-in-row').each(function() {
        $(this).css({
            'animation-delay': delay + 's',
            'opacity': '0'
        });
        delay += 0.05;
    });

    setTimeout(function() {
        $('.fade-in-row').css('opacity', '1');
    }, 50);
});
</script>
@endpush
