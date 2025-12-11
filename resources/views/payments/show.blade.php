@extends('layouts.app')

@section('title', 'Ödeme Detayı')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">
            <i class="bi bi-credit-card me-2"></i>Ödeme Detayı
        </h1>
        <p class="text-muted mb-0">
            {{ $payment->payment_date->format('d.m.Y H:i') }}
        </p>
    </div>
    <div>
        @php
            $statusConfig = [
                'completed' => ['color' => 'success', 'label' => 'Tamamlandı'],
                'pending' => ['color' => 'warning', 'label' => 'Bekliyor'],
                'failed' => ['color' => 'danger', 'label' => 'Başarısız'],
                'cancelled' => ['color' => 'secondary', 'label' => 'İptal'],
            ];
            $status = $statusConfig[$payment->status] ?? ['color' => 'secondary', 'label' => $payment->status];
        @endphp
        <span class="badge bg-{{ $status['color'] }} fs-6 me-2">
            {{ $status['label'] }}
        </span>

        @if($payment->status === 'completed')
        <form method="POST" action="{{ route('payments.cancel', $payment) }}" class="d-inline">
            @csrf
            <button type="submit"
                    class="btn btn-danger"
                    onclick="return confirm('Bu ödemeyi iptal etmek istediğinizden emin misiniz?')">
                <i class="bi bi-x-circle me-2"></i>İptal Et
            </button>
        </form>
        @endif

        <a href="{{ route('payments.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Geri
        </a>
    </div>
</div>

<div class="row g-3">
    <!-- Sol Kolon -->
    <div class="col-md-4">
        <!-- Müşteri Bilgileri -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-primary text-white">
                <h6 class="mb-0">
                    <i class="bi bi-person me-2"></i>Müşteri Bilgileri
                </h6>
            </div>
            <div class="card-body">
                <h5 class="mb-3">
                    <a href="{{ route('customers.show', $payment->customer) }}" class="text-decoration-none">
                        {{ $payment->customer->name }}
                    </a>
                </h5>
                <div class="mb-2">
                    <i class="bi bi-telephone text-muted me-2"></i>
                    <a href="tel:{{ $payment->customer->phone }}" class="text-decoration-none">
                        {{ $payment->customer->phone }}
                    </a>
                </div>
                @if($payment->customer->email)
                <div class="mb-2">
                    <i class="bi bi-envelope text-muted me-2"></i>
                    <a href="mailto:{{ $payment->customer->email }}" class="text-decoration-none">
                        {{ $payment->customer->email }}
                    </a>
                </div>
                @endif
                @if($payment->customer->city)
                <div>
                    <i class="bi bi-geo-alt text-muted me-2"></i>
                    {{ $payment->customer->city }}
                </div>
                @endif
            </div>
        </div>

        <!-- Poliçe Bilgileri -->
        @if($payment->policy)
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">
                    <i class="bi bi-file-earmark-text me-2"></i>Poliçe Bilgileri
                </h6>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Poliçe No</small>
                    <p class="mb-0">
                        <a href="{{ route('policies.show', $payment->policy) }}" class="text-decoration-none">
                            <strong>{{ $payment->policy->policy_number }}</strong>
                        </a>
                    </p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Tür</small>
                    <p class="mb-0"><strong>{{ $payment->policy->policy_type_label }}</strong></p>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Şirket</small>
                    <p class="mb-0"><strong>{{ $payment->policy->insuranceCompany->name }}</strong></p>
                </div>
                <div>
                    <small class="text-muted">Prim Tutarı</small>
                    <p class="mb-0"><strong>{{ number_format($payment->policy->premium_amount, 2) }} ₺</strong></p>
                </div>
            </div>
        </div>
        @endif

        <!-- Ödeme Tutarı -->
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-success text-white">
                <h6 class="mb-0">
                    <i class="bi bi-cash me-2"></i>Ödeme Tutarı
                </h6>
            </div>
            <div class="card-body text-center">
                <h2 class="mb-0 text-success">{{ number_format($payment->amount, 2) }} ₺</h2>
            </div>
        </div>
    </div>

    <!-- Sağ Kolon -->
    <div class="col-md-8">
        <!-- Ödeme Bilgileri -->
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">
                    <i class="bi bi-info-circle me-2"></i>Ödeme Bilgileri
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <small class="text-muted">Ödeme Tarihi</small>
                            <p class="mb-0"><strong>{{ $payment->payment_date->format('d.m.Y H:i') }}</strong></p>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">Ödeme Yöntemi</small>
                            <p class="mb-0">
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
                                <i class="bi bi-{{ $methodIcons[$payment->payment_method] ?? 'cash' }} me-2"></i>
                                <strong>{{ $methodLabels[$payment->payment_method] ?? $payment->payment_method }}</strong>
                            </p>
                        </div>

                        @if($payment->payment_reference)
                        <div class="mb-3">
                            <small class="text-muted">Referans No</small>
                            <p class="mb-0"><strong>{{ $payment->payment_reference }}</strong></p>
                        </div>
                        @endif
                    </div>

                    <div class="col-md-6">
                        @if($payment->installment)
                        <div class="mb-3">
                            <small class="text-muted">Taksit Bilgisi</small>
                            <p class="mb-0">
                                <span class="badge bg-info">
                                    {{ $payment->installment->installment_number }}/{{ $payment->installment->paymentPlan->installment_count }}
                                </span>
                            </p>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">Vade Tarihi</small>
                            <p class="mb-0"><strong>{{ $payment->installment->due_date->format('d.m.Y') }}</strong></p>
                        </div>
                        @endif

                        <div class="mb-3">
                            <small class="text-muted">Durum</small>
                            <p class="mb-0">
                                <span class="badge bg-{{ $status['color'] }}">
                                    {{ $status['label'] }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                @if($payment->notes)
                <hr>
                <div>
                    <small class="text-muted">Notlar</small>
                    <p class="mb-0">{{ $payment->notes }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Ödeme Planı (Eğer taksitli ödeme ise) -->
        @if($payment->installment && $payment->installment->paymentPlan)
        <div class="card mb-3 border-0 shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0">
                    <i class="bi bi-calendar3 me-2"></i>Ödeme Planı
                </h6>
            </div>
            <div class="card-body">
                @php
                    $plan = $payment->installment->paymentPlan;
                @endphp

                <!-- Özet Kartlar -->
                <div class="row g-3 mb-3">
                    <div class="col-md-3">
                        <div class="card bg-light">
                            <div class="card-body text-center py-2">
                                <small class="text-muted">Toplam</small>
                                <h6 class="mb-0">{{ number_format($plan->total_amount, 2) }} ₺</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center py-2">
                                <small>Ödenen</small>
                                <h6 class="mb-0">{{ number_format($plan->paid_amount, 2) }} ₺</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark">
                            <div class="card-body text-center py-2">
                                <small>Kalan</small>
                                <h6 class="mb-0">{{ number_format($plan->remaining_amount, 2) }} ₺</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center py-2">
                                <small>İlerleme</small>
                                <h6 class="mb-0">%{{ number_format($plan->payment_progress, 1) }}</h6>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Taksitler Tablosu -->
                <div class="table-responsive">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <th>Taksit</th>
                                <th>Vade</th>
                                <th>Tutar</th>
                                <th>Durum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plan->installments->sortBy('installment_number') as $inst)
                            <tr class="{{ $inst->id === $payment->installment->id ? 'table-primary' : '' }}">
                                <td>
                                    {{ $inst->installment_number }}
                                    @if($inst->id === $payment->installment->id)
                                        <i class="bi bi-arrow-left text-primary ms-1"></i>
                                    @endif
                                </td>
                                <td>{{ $inst->due_date->format('d.m.Y') }}</td>
                                <td>{{ number_format($inst->amount, 2) }} ₺</td>
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
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h6 class="mb-0">
                    <i class="bi bi-clock-history me-2"></i>İşlem Geçmişi
                </h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <strong>Ödeme Kaydedildi</strong>
                            <p class="text-muted mb-0">
                                {{ $payment->created_at->format('d.m.Y H:i') }}
                                @if($payment->createdBy)
                                    - {{ $payment->createdBy->name }}
                                @endif
                            </p>
                        </div>
                    </div>

                    @if($payment->status === 'cancelled')
                    <div class="timeline-item">
                        <div class="timeline-marker bg-danger"></div>
                        <div class="timeline-content">
                            <strong>Ödeme İptal Edildi</strong>
                            <p class="text-muted mb-0">
                                {{ $payment->cancelled_at->format('d.m.Y H:i') }}
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    padding-bottom: 20px;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: -30px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 0 0 2px #dee2e6;
}

.timeline-item::before {
    content: '';
    position: absolute;
    left: -24px;
    top: 12px;
    bottom: -20px;
    width: 2px;
    background: #dee2e6;
}

.timeline-item:last-child::before {
    display: none;
}

.timeline-content {
    padding-left: 15px;
}
</style>
@endpush
