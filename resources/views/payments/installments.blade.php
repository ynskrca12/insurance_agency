@extends('layouts.app')

@section('title', 'Taksit Planları')

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

    .stat-sublabel {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 0.25rem;
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

    .btn-primary.action-btn,
    .btn-success.action-btn {
        border-color: transparent;
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

    .table-modern tbody tr.row-overdue {
        background: #fff5f5;
        border-left: 3px solid #dc3545;
    }

    .table-modern tbody tr.row-due-today {
        background: #fffbf0;
        border-left: 3px solid #ffc107;
    }

    .table-modern tbody tr.row-critical {
        background: #fff9f0;
        border-left: 3px solid #ff9800;
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

    .days-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.75rem;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 600;
    }

    .days-badge.overdue {
        background: #ffebee;
        color: #c62828;
        border: 1px solid #ef5350;
    }

    .days-badge.today {
        background: #fff8e1;
        color: #f57c00;
        border: 1px solid #ffb74d;
    }

    .days-badge.critical {
        background: #fff3e0;
        color: #e65100;
        border: 1px solid #ff9800;
    }

    .amount-value {
        font-size: 1.125rem;
        font-weight: 700;
        color: #28a745;
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

    .btn-icon.btn-pay:hover {
        background: #28a745;
        border-color: #28a745;
        color: #ffffff;
    }

    .btn-icon.btn-remind:hover {
        background: #0dcaf0;
        border-color: #0dcaf0;
        color: #ffffff;
    }

    .btn-icon.btn-view:hover {
        background: #0d6efd;
        border-color: #0d6efd;
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

    .modal-modern .modal-content {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .modal-modern .modal-header {
        border: none;
        padding: 1.25rem 1.5rem;
    }

    .modal-modern .modal-body {
        padding: 1.5rem;
    }

    .modal-modern .modal-footer {
        background: #fafafa;
        border-top: 1px solid #e9ecef;
        padding: 1rem 1.5rem;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 0.9375rem;
    }

    .info-box {
        background: #e8f4fd;
        border: 1px solid #b3d9ff;
        border-radius: 10px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
    }

    .info-box-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #0066cc;
        margin-bottom: 0.75rem;
    }

    .info-detail {
        margin-bottom: 0.5rem;
        font-size: 0.9375rem;
    }

    .info-detail:last-child {
        margin-bottom: 0;
    }

    .info-detail strong {
        color: #495057;
        font-weight: 600;
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
                    <i class="bi bi-calendar3 me-2"></i>Taksit Planları
                </h1>
                <p class="text-muted mb-0 small">Toplam {{ $installments->total() }} taksit kaydı bulundu</p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-success action-btn" data-bs-toggle="modal" data-bs-target="#bulkReminderModal">
                    <i class="bi bi-send me-2"></i>Toplu Hatırlatıcı
                </button>
                <a href="{{ route('payments.index') }}" class="btn btn-light action-btn">
                    <i class="bi bi-credit-card me-2"></i>Ödemeler
                </a>
            </div>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-warning">{{ number_format($stats['total_pending'], 2) }} ₺</div>
                <div class="stat-label">Bekleyen Toplam</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-danger">{{ number_format($stats['overdue_count']) }}</div>
                <div class="stat-label">Gecikmiş Taksitler</div>
                <div class="stat-sublabel">{{ number_format($stats['overdue_amount'], 2) }} ₺</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-info">{{ number_format($stats['due_today_count']) }}</div>
                <div class="stat-label">Bugün Vadesi Dolan</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-primary">{{ number_format($stats['upcoming_7_count']) }}</div>
                <div class="stat-label">7 Gün İçinde</div>
            </div>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="filter-card card">
        <div class="card-body">
            <form method="GET" action="{{ route('payments.installments') }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    <!-- Arama -->
                    <div class="col-lg-4 col-md-6">
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
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Bekliyor</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Ödendi</option>
                            <option value="overdue" {{ request('status') === 'overdue' ? 'selected' : '' }}>Gecikmiş</option>
                        </select>
                    </div>

                    <!-- Tarih Filtresi -->
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Vade Durumu</label>
                        <select name="date_filter" class="form-select">
                            <option value="">Tüm Tarihler</option>
                            <option value="due_today" {{ request('date_filter') === 'due_today' ? 'selected' : '' }}>Bugün Vadesi Dolan</option>
                            <option value="overdue" {{ request('date_filter') === 'overdue' ? 'selected' : '' }}>Gecikmiş</option>
                            <option value="upcoming_7" {{ request('date_filter') === 'upcoming_7' ? 'selected' : '' }}>7 Gün İçinde</option>
                            <option value="upcoming_30" {{ request('date_filter') === 'upcoming_30' ? 'selected' : '' }}>30 Gün İçinde</option>
                        </select>
                    </div>

                    <!-- Filtrele Butonu -->
                    <div class="col-lg-2 col-md-12">
                        <button type="submit" class="btn btn-primary action-btn w-100">
                            <i class="bi bi-funnel me-2"></i>Filtrele
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
                        <th>Müşteri</th>
                        <th>Poliçe</th>
                        <th>Taksit</th>
                        <th>Vade Tarihi</th>
                        <th>Kalan Süre</th>
                        <th>Tutar</th>
                        <th>Durum</th>
                        <th class="text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($installments as $installment)
                    @php
                        $daysUntilDue = now()->diffInDays($installment->due_date, false);
                        $isOverdue = $daysUntilDue < 0;
                        $isDueToday = $daysUntilDue === 0;
                        $isCritical = $daysUntilDue > 0 && $daysUntilDue <= 7;

                        $rowClass = '';
                        if ($isOverdue) $rowClass = 'row-overdue';
                        elseif ($isDueToday) $rowClass = 'row-due-today';
                        elseif ($isCritical) $rowClass = 'row-critical';
                    @endphp
                    <tr class="fade-in-row {{ $rowClass }}">
                        <td>
                            <a href="{{ route('customers.show', $installment->paymentPlan->customer) }}" class="customer-link">
                                {{ $installment->paymentPlan->customer->name }}
                            </a>
                            <br>
                            <small class="text-muted">{{ $installment->paymentPlan->customer->phone }}</small>
                        </td>
                        <td>
                            <a href="{{ route('policies.show', $installment->paymentPlan->policy) }}" class="text-decoration-none">
                                {{ $installment->paymentPlan->policy->policy_number }}
                            </a>
                        </td>
                        <td>
                            <span class="badge-installment">
                                {{ $installment->installment_number }}/{{ $installment->paymentPlan->installment_count }}
                            </span>
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $installment->due_date->format('d.m.Y') }}</div>
                        </td>
                        <td>
                            @if($isOverdue)
                                <span class="days-badge overdue">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    {{ abs($daysUntilDue) }} gün geçti
                                </span>
                            @elseif($isDueToday)
                                <span class="days-badge today">
                                    <i class="bi bi-clock-fill"></i>
                                    Bugün
                                </span>
                            @elseif($isCritical)
                                <span class="days-badge critical">
                                    <i class="bi bi-exclamation-circle-fill"></i>
                                    {{ $daysUntilDue }} gün
                                </span>
                            @else
                                <span class="text-muted small">{{ $daysUntilDue }} gün</span>
                            @endif
                        </td>
                        <td>
                            <span class="amount-value">{{ number_format($installment->amount, 2) }} ₺</span>
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
                            <span class="badge badge-modern bg-{{ $status['color'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="action-buttons">
                                @if($installment->status === 'pending' || $installment->status === 'overdue')
                                <button type="button"
                                        class="btn-icon btn-pay"
                                        data-bs-toggle="modal"
                                        data-bs-target="#paymentModal"
                                        onclick="setInstallmentData({{ $installment->id }}, '{{ addslashes($installment->paymentPlan->customer->name) }}', '{{ $installment->paymentPlan->policy->policy_number }}', {{ $installment->installment_number }}, {{ $installment->amount }})"
                                        title="Ödeme Kaydet">
                                    <i class="bi bi-cash"></i>
                                </button>
                                <form method="POST" action="{{ route('payments.sendReminder', $installment) }}" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="btn-icon btn-remind"
                                            title="Hatırlatıcı Gönder">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </form>
                                @endif
                                @if($installment->payment)
                                <a href="{{ route('payments.show', $installment->payment) }}"
                                   class="btn-icon btn-view"
                                   title="Ödeme Detayı">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <h5>Taksit Bulunamadı</h5>
                                <p>
                                    @if(request()->hasAny(['search', 'status', 'date_filter']))
                                        Arama kriterlerinize uygun taksit bulunamadı.
                                    @else
                                        Henüz hiç taksit kaydı bulunmuyor.
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
    @if($installments->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $installments->links() }}
    </div>
    @endif
</div>

<!-- Ödeme Kaydet Modal -->
<div class="modal fade modal-modern" id="paymentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-cash me-2"></i>Ödeme Kaydet
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('payments.store') }}" id="paymentForm">
                @csrf
                <input type="hidden" name="installment_id" id="installment_id">
                <div class="modal-body">
                    <div class="info-box" id="payment_info">
                        <!-- JavaScript ile doldurulacak -->
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Ödeme Tutarı (₺) <span class="text-danger">*</span>
                        </label>
                        <input type="number"
                               class="form-control"
                               name="amount"
                               id="payment_amount"
                               step="0.01"
                               placeholder="0.00"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Ödeme Tarihi <span class="text-danger">*</span>
                        </label>
                        <input type="date"
                               class="form-control"
                               name="payment_date"
                               value="{{ now()->format('Y-m-d') }}"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Ödeme Yöntemi <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" name="payment_method" required>
                            <option value="">Seçiniz</option>
                            <option value="cash">Nakit</option>
                            <option value="credit_card">Kredi Kartı</option>
                            <option value="bank_transfer">Havale/EFT</option>
                            <option value="check">Çek</option>
                            <option value="pos">POS</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Referans Numarası</label>
                        <input type="text"
                               class="form-control"
                               name="payment_reference"
                               placeholder="Dekont no, işlem no vb. (opsiyonel)">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Notlar</label>
                        <textarea class="form-control"
                                  name="notes"
                                  rows="3"
                                  placeholder="Ödeme hakkında notlar (opsiyonel)..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light action-btn" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>İptal
                    </button>
                    <button type="submit" class="btn btn-success action-btn">
                        <i class="bi bi-check-circle me-2"></i>Ödemeyi Kaydet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Toplu Hatırlatıcı Modal -->
<div class="modal fade modal-modern" id="bulkReminderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-send me-2"></i>Toplu Hatırlatıcı Gönder
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('payments.bulkSendReminders') }}" id="bulkReminderForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Hedef Grup Seçimi</label>
                        <select class="form-select" name="filter" required>
                            <option value="">Grup seçiniz</option>
                            <option value="overdue">Gecikmiş Ödemeler ({{ $stats['overdue_count'] }} adet)</option>
                            <option value="due_today">Bugün Vadesi Dolan ({{ $stats['due_today_count'] }} adet)</option>
                            <option value="upcoming_7">7 Gün İçinde ({{ $stats['upcoming_7_count'] }} adet)</option>
                        </select>
                    </div>

                    <div class="info-box">
                        <div class="info-box-title">
                            <i class="bi bi-info-circle me-1"></i>
                            Bilgilendirme
                        </div>
                        <p class="mb-0">Seçilen gruptaki tüm müşterilere SMS hatırlatıcısı gönderilecektir.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light action-btn" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>İptal
                    </button>
                    <button type="submit" class="btn btn-success action-btn">
                        <i class="bi bi-send me-2"></i>Hatırlatıcı Gönder
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
        <div class="info-box-title">Taksit Bilgileri</div>
        <div class="info-detail"><strong>Müşteri:</strong> ${customer}</div>
        <div class="info-detail"><strong>Poliçe:</strong> ${policy}</div>
        <div class="info-detail"><strong>Taksit:</strong> ${installmentNo}. Taksit</div>
        <div class="info-detail"><strong>Tutar:</strong> ${parseFloat(amount).toFixed(2)} ₺</div>
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
            }, 600);
        }
    });

    // Form submit animasyonu
    $('#paymentForm, #bulkReminderForm').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>İşleniyor...');
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
