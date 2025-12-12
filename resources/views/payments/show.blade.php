@extends('layouts.app')

@section('title', 'Ödeme Detayı')

@push('styles')
<style>
    .detail-header {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .info-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        margin-bottom: 1.5rem;
        overflow: hidden;
    }

    .info-card .card-header {
        background: #fafafa;
        border-bottom: 1px solid #e8e8e8;
        padding: 1rem 1.25rem;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-title i {
        color: #6c757d;
        font-size: 1.125rem;
    }

    .info-item {
        padding: 0.75rem 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-size: 0.8125rem;
        color: #6c757d;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-size: 1rem;
        color: #212529;
        font-weight: 600;
    }

    .action-btn {
        border-radius: 8px;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #dcdcdc;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        border-color: #b0b0b0;
    }

    .badge-modern {
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 8px;
        font-size: 0.9375rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .amount-display {
        text-align: center;
        padding: 2rem 1.5rem;
    }

    .amount-value {
        font-size: 2.5rem;
        font-weight: 700;
        color: #28a745;
        line-height: 1;
    }

    .amount-label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 0.5rem;
    }

    .payment-method-display {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
    }

    .payment-method-display i {
        font-size: 1.25rem;
        color: #495057;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .summary-box {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 1rem;
        text-align: center;
    }

    .summary-box.success {
        background: #e8f5e9;
        border-color: #c8e6c9;
    }

    .summary-box.warning {
        background: #fff8e1;
        border-color: #ffe082;
    }

    .summary-box.info {
        background: #e3f2fd;
        border-color: #90caf9;
    }

    .summary-label {
        font-size: 0.8125rem;
        color: #6c757d;
        margin-bottom: 0.375rem;
    }

    .summary-value {
        font-size: 1.125rem;
        font-weight: 700;
        color: #212529;
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
        padding: 0.875rem 1rem;
    }

    .table-modern tbody td {
        padding: 0.875rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f5f5f5;
    }

    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    .table-modern tbody tr:hover {
        background: #fafafa;
    }

    .table-modern tbody tr.current-installment {
        background: #e8f4fd;
        border-left: 3px solid #0d6efd;
    }

    .timeline {
        position: relative;
        padding-left: 2rem;
    }

    .timeline-item {
        position: relative;
        padding-bottom: 1.5rem;
    }

    .timeline-item:last-child {
        padding-bottom: 0;
    }

    .timeline-marker {
        position: absolute;
        left: -2rem;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        border: 3px solid;
    }

    .timeline-marker.success {
        background: #28a745;
        border-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.2);
    }

    .timeline-marker.danger {
        background: #dc3545;
        border-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.2);
    }

    .timeline-item::before {
        content: '';
        position: absolute;
        left: -1.4375rem;
        top: 1rem;
        bottom: -1.5rem;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item:last-child::before {
        display: none;
    }

    .timeline-content {
        padding-left: 1rem;
    }

    .timeline-title {
        font-size: 1rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.25rem;
    }

    .timeline-meta {
        font-size: 0.875rem;
        color: #6c757d;
        margin: 0;
    }

    .customer-link {
        color: #212529;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .customer-link:hover {
        color: #0d6efd;
    }

    .notes-box {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 1.25rem;
        margin-top: 1.5rem;
    }

    .notes-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.75rem;
    }

    .notes-content {
        font-size: 0.9375rem;
        color: #212529;
        line-height: 1.6;
        margin: 0;
    }

    @media (max-width: 768px) {
        .amount-value {
            font-size: 2rem;
        }

        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="detail-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="flex-grow-1">
                <h1 class="h3 mb-1 fw-bold text-dark">
                    <i class="bi bi-credit-card me-2"></i>Ödeme Detayı
                </h1>
                <p class="text-muted mb-0 small">
                    {{ $payment->payment_date->format('d.m.Y H:i') }}
                </p>
            </div>
            <div class="d-flex gap-2 align-items-center flex-wrap">
                @php
                    $statusConfig = [
                        'completed' => ['color' => 'success', 'label' => 'Tamamlandı', 'icon' => 'check-circle-fill'],
                        'pending' => ['color' => 'warning', 'label' => 'Bekliyor', 'icon' => 'clock'],
                        'failed' => ['color' => 'danger', 'label' => 'Başarısız', 'icon' => 'x-circle-fill'],
                        'cancelled' => ['color' => 'secondary', 'label' => 'İptal', 'icon' => 'slash-circle-fill'],
                    ];
                    $status = $statusConfig[$payment->status] ?? ['color' => 'secondary', 'label' => $payment->status, 'icon' => 'circle-fill'];
                @endphp
                <span class="badge badge-modern bg-{{ $status['color'] }}">
                    <i class="bi bi-{{ $status['icon'] }}"></i>
                    {{ $status['label'] }}
                </span>

                @if($payment->status === 'completed')
                <form method="POST" action="{{ route('payments.cancel', $payment) }}" class="d-inline">
                    @csrf
                    <button type="button"
                            class="btn btn-danger action-btn"
                            onclick="confirmCancel(this)">
                        <i class="bi bi-x-circle me-2"></i>İptal Et
                    </button>
                </form>
                @endif

                <a href="{{ route('payments.index') }}" class="btn btn-light action-btn">
                    <i class="bi bi-arrow-left me-2"></i>Geri
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Sol Sidebar -->
        <div class="col-lg-4">
            <!-- Müşteri Bilgileri -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-person"></i>
                        <span>Müşteri Bilgileri</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">Müşteri Adı</div>
                        <div class="info-value">
                            <a href="{{ route('customers.show', $payment->customer) }}" class="customer-link">
                                {{ $payment->customer->name }}
                            </a>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Telefon</div>
                        <div class="info-value">
                            <a href="tel:{{ $payment->customer->phone }}" class="text-decoration-none text-dark">
                                <i class="bi bi-telephone me-1"></i>{{ $payment->customer->phone }}
                            </a>
                        </div>
                    </div>

                    @if($payment->customer->email)
                    <div class="info-item">
                        <div class="info-label">E-posta</div>
                        <div class="info-value">
                            <a href="mailto:{{ $payment->customer->email }}" class="text-decoration-none text-dark">
                                <i class="bi bi-envelope me-1"></i>{{ $payment->customer->email }}
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($payment->customer->city)
                    <div class="info-item">
                        <div class="info-label">Şehir</div>
                        <div class="info-value">
                            <i class="bi bi-geo-alt me-1"></i>{{ $payment->customer->city }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Poliçe Bilgileri -->
            @if($payment->policy)
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-file-earmark-text"></i>
                        <span>Poliçe Bilgileri</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-label">Poliçe Numarası</div>
                        <div class="info-value">
                            <a href="{{ route('policies.show', $payment->policy) }}" class="text-decoration-none text-primary">
                                {{ $payment->policy->policy_number }}
                            </a>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Poliçe Türü</div>
                        <div class="info-value">{{ $payment->policy->policy_type_label }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Sigorta Şirketi</div>
                        <div class="info-value">{{ $payment->policy->insuranceCompany->name }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Prim Tutarı</div>
                        <div class="info-value text-success">{{ number_format($payment->policy->premium_amount, 2) }} ₺</div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Ödeme Tutarı -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-cash"></i>
                        <span>Ödeme Tutarı</span>
                    </h6>
                </div>
                <div class="card-body amount-display">
                    <div class="amount-value">{{ number_format($payment->amount, 2) }} ₺</div>
                    <div class="amount-label">Ödenen Tutar</div>
                </div>
            </div>
        </div>

        <!-- Ana İçerik -->
        <div class="col-lg-8">
            <!-- Ödeme Bilgileri -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-info-circle"></i>
                        <span>Ödeme Bilgileri</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="info-item">
                                <div class="info-label">Ödeme Tarihi</div>
                                <div class="info-value">
                                    <i class="bi bi-calendar-check me-1"></i>
                                    {{ $payment->payment_date->format('d.m.Y H:i') }}
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Ödeme Yöntemi</div>
                                <div class="info-value">
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
                                    <div class="payment-method-display">
                                        <i class="bi bi-{{ $methodIcons[$payment->payment_method] ?? 'cash' }}"></i>
                                        <span>{{ $methodLabels[$payment->payment_method] ?? $payment->payment_method }}</span>
                                    </div>
                                </div>
                            </div>

                            @if($payment->payment_reference)
                            <div class="info-item">
                                <div class="info-label">Referans Numarası</div>
                                <div class="info-value font-monospace">{{ $payment->payment_reference }}</div>
                            </div>
                            @endif
                        </div>

                        <div class="col-md-6">
                            @if($payment->installment)
                            <div class="info-item">
                                <div class="info-label">Taksit Bilgisi</div>
                                <div class="info-value">
                                    <span class="badge bg-info" style="padding: 0.5rem 1rem; font-size: 0.9375rem;">
                                        {{ $payment->installment->installment_number }}/{{ $payment->installment->paymentPlan->installment_count }} Taksit
                                    </span>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Vade Tarihi</div>
                                <div class="info-value">{{ $payment->installment->due_date->format('d.m.Y') }}</div>
                            </div>
                            @endif

                            <div class="info-item">
                                <div class="info-label">Ödeme Durumu</div>
                                <div class="info-value">
                                    <span class="badge badge-modern bg-{{ $status['color'] }}">
                                        <i class="bi bi-{{ $status['icon'] }}"></i>
                                        {{ $status['label'] }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($payment->notes)
                    <div class="notes-box">
                        <div class="notes-title">
                            <i class="bi bi-sticky me-1"></i>
                            Notlar
                        </div>
                        <p class="notes-content">{{ $payment->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Ödeme Planı -->
            @if($payment->installment && $payment->installment->paymentPlan)
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-calendar3"></i>
                        <span>Ödeme Planı Durumu</span>
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $plan = $payment->installment->paymentPlan;
                    @endphp

                    <!-- Özet Kartlar -->
                    <div class="summary-grid">
                        <div class="summary-box">
                            <div class="summary-label">Toplam Tutar</div>
                            <div class="summary-value">{{ number_format($plan->total_amount, 2) }} ₺</div>
                        </div>
                        <div class="summary-box success">
                            <div class="summary-label">Ödenen</div>
                            <div class="summary-value text-success">{{ number_format($plan->paid_amount, 2) }} ₺</div>
                        </div>
                        <div class="summary-box warning">
                            <div class="summary-label">Kalan</div>
                            <div class="summary-value text-warning">{{ number_format($plan->remaining_amount, 2) }} ₺</div>
                        </div>
                        <div class="summary-box info">
                            <div class="summary-label">İlerleme</div>
                            <div class="summary-value text-info">%{{ number_format($plan->payment_progress, 1) }}</div>
                        </div>
                    </div>

                    <!-- Taksitler Tablosu -->
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Taksit</th>
                                    <th>Vade Tarihi</th>
                                    <th>Tutar</th>
                                    <th>Durum</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($plan->installments->sortBy('installment_number') as $inst)
                                <tr class="{{ $inst->id === $payment->installment->id ? 'current-installment' : '' }}">
                                    <td>
                                        <strong>{{ $inst->installment_number }}</strong>
                                        @if($inst->id === $payment->installment->id)
                                            <i class="bi bi-arrow-left text-primary ms-1" title="Bu ödeme"></i>
                                        @endif
                                    </td>
                                    <td>{{ $inst->due_date->format('d.m.Y') }}</td>
                                    <td><strong>{{ number_format($inst->amount, 2) }} ₺</strong></td>
                                    <td>
                                        @if($inst->status === 'paid')
                                            <span class="badge bg-success">Ödendi</span>
                                        @elseif($inst->status === 'overdue')
                                            <span class="badge bg-danger">Gecikmiş</span>
                                        @else
                                            <span class="badge bg-warning">Bekliyor</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- İşlem Geçmişi -->
            <div class="info-card card">
                <div class="card-header">
                    <h6 class="card-title">
                        <i class="bi bi-clock-history"></i>
                        <span>İşlem Geçmişi</span>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="timeline-marker success"></div>
                            <div class="timeline-content">
                                <div class="timeline-title">Ödeme Kaydedildi</div>
                                <p class="timeline-meta">
                                    {{ $payment->created_at->format('d.m.Y H:i') }}
                                    @if($payment->createdBy)
                                        • {{ $payment->createdBy->name }}
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if($payment->status === 'cancelled')
                        <div class="timeline-item">
                            <div class="timeline-marker danger"></div>
                            <div class="timeline-content">
                                <div class="timeline-title">Ödeme İptal Edildi</div>
                                <p class="timeline-meta">
                                    {{ $payment->cancelled_at->format('d.m.Y H:i') }}
                                    @if($payment->cancelledBy)
                                        • {{ $payment->cancelledBy->name }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function confirmCancel(button) {
    if (confirm('⚠️ DİKKAT!\n\nBu ödemeyi iptal etmek istediğinizden emin misiniz?\n\n• Bu işlem geri alınamaz!\n• Taksit planı etkilenecektir.\n\nDevam etmek istiyor musunuz?')) {
        // Loading overlay
        $('body').append(`
            <div class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                 style="background: rgba(0,0,0,0.5); z-index: 9999;">
                <div class="spinner-border text-light" style="width: 3rem; height: 3rem;"></div>
            </div>
        `);

        button.closest('form').submit();
    }
}
</script>
@endpush
