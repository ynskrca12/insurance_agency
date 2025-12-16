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

    .table-card .card-body {
        padding: 1.5rem;
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

    /* DataTables */
    .dataTables_length, .dataTables_filter {
        padding: 1rem 1.25rem;
    }

    .dataTables_info, .dataTables_paginate {
        padding: 1rem 1.25rem;
    }

    .dt-buttons {
        margin-bottom: 1rem;
    }

    .dt-buttons .btn {
        margin-left: 0.5rem;
        margin-right: 0.5rem;
    }

    .btn-secondary {
        border: 1px solid #dcdcdc;
        background: #f8f8f8;
        color: #333;
    }

    .btn-secondary:hover {
        background: #e7e7e7;
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
                <p class="text-muted mb-0 small" id="paymentCount">
                    Toplam <strong>{{ $payments->count() }}</strong> ödeme kaydı bulundu
                </p>
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
            <div class="row g-3 align-items-end">
                <!-- Durum -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Durum</label>
                    <select id="filterStatus" class="form-select">
                        <option value="">Tümü</option>
                        <option value="Tamamlandı">Tamamlandı</option>
                        <option value="Bekliyor">Bekliyor</option>
                        <option value="Başarısız">Başarısız</option>
                        <option value="İptal">İptal</option>
                    </select>
                </div>

                <!-- Ödeme Yöntemi -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Yöntem</label>
                    <select id="filterPaymentMethod" class="form-select">
                        <option value="">Tümü</option>
                        <option value="Nakit">Nakit</option>
                        <option value="Kredi Kartı">Kredi Kartı</option>
                        <option value="Havale/EFT">Havale/EFT</option>
                        <option value="Çek">Çek</option>
                        <option value="POS">POS</option>
                    </select>
                </div>

                <!-- Başlangıç Tarihi -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Başlangıç</label>
                    <input type="date" id="filterDateFrom" class="form-control">
                </div>

                <!-- Bitiş Tarihi -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Bitiş</label>
                    <input type="date" id="filterDateTo" class="form-control">
                </div>

                <!-- Temizle Butonu -->
                <div class="col-lg-1 col-md-12">
                    <button type="button" class="btn btn-secondary action-btn w-100" onclick="clearFilters()">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablo -->
    <div class="table-card card">
        <div class="card-body">
            <table class="table table-hover" id="paymentsTable">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Tarih</th>
                        <th>Referans No</th>
                        <th>Müşteri</th>
                        <th>Poliçe</th>
                        <th>Taksit</th>
                        <th>Tutar</th>
                        <th>Yöntem</th>
                        <th>Durum</th>
                        <th width="100" class="text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $index => $payment)
                    <tr>
                        <td></td>
                        <td data-sort="{{ $payment->payment_date->format('Y-m-d H:i:s') }}">
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
                        <td data-order="{{ $payment->amount }}">
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmCancel(button) {
    if (confirm('⚠️ Bu ödemeyi iptal etmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        button.closest('form').submit();
    }
}

$(document).ready(function() {
    // ✅ DataTable başlat
    const table = initDataTable('#paymentsTable', {
        order: [[1, 'desc']], // Tarihe göre sırala (en yeni önce)
        pageLength: 25,
        columnDefs: [
            { orderable: false, searchable: false, targets: 0 }, // Sıra numarası
            { orderable: false, targets: [9] }, // İşlemler
            { targets: 1, type: 'date' }, // Tarih
            { targets: 6, type: 'num' } // Tutar
        ]
    });

    // ✅ Filtreler
    $('#filterStatus, #filterPaymentMethod, #filterDateFrom, #filterDateTo').on('change', function() {
        const status = $('#filterStatus').val();
        const paymentMethod = $('#filterPaymentMethod').val();
        const dateFrom = $('#filterDateFrom').val();
        const dateTo = $('#filterDateTo').val();

        // Tüm custom filtreleri temizle
        $.fn.dataTable.ext.search = [];

        // Durum filtresi
        if (status) {
            table.column(8).search(status);
        } else {
            table.column(8).search('');
        }

        // Ödeme yöntemi filtresi
        if (paymentMethod) {
            table.column(7).search(paymentMethod);
        } else {
            table.column(7).search('');
        }

        // Tarih aralığı filtresi
        if (dateFrom || dateTo) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const dateStr = data[1]; // Tarih sütunu
                    if (!dateStr || dateStr === '-') return true;

                    const dateParts = dateStr.match(/\d{2}\.\d{2}\.\d{4}/);
                    if (!dateParts) return true;

                    const parts = dateParts[0].split('.');
                    const rowDate = new Date(parts[2], parts[1] - 1, parts[0]);
                    const startDate = dateFrom ? new Date(dateFrom) : null;
                    const endDate = dateTo ? new Date(dateTo) : null;

                    if (startDate && rowDate < startDate) return false;
                    if (endDate && rowDate > endDate) return false;

                    return true;
                }
            );
        }

        table.draw();
    });

    // Sayfa değişince toplam sayıyı güncelle
    table.on('draw', function() {
        const info = table.page.info();
        $('#paymentCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> ödeme`);
    });

    // İlk yüklemede toplam sayıyı güncelle
    const info = table.page.info();
    $('#paymentCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> ödeme`);
});

function clearFilters() {
    $('#filterStatus, #filterPaymentMethod, #filterDateFrom, #filterDateTo').val('');
    $.fn.dataTable.ext.search = [];
    const table = $('#paymentsTable').DataTable();
    table.search('').columns().search('').draw();
}
</script>
@endpush
