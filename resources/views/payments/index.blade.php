@extends('layouts.app')

@section('title', 'Ödemeler')

@push('styles')
<style>
    .page-header {
        padding: 12px 0;
        margin-bottom: 1rem;
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

<style>
    /* ============================================
       MOBILE OPTIMIZATION - PROFESSIONAL
    ============================================ */

    /* Mobile Cards Container */
    .mobile-cards-container {
        display: none;
    }

    /* Payment Card Mobile */
    .payment-card-mobile {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .payment-card-mobile:active {
        transform: scale(0.98);
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
    }

    /* Status Stripe */
    .payment-card-stripe {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
    }

    .payment-card-stripe.completed {
        background: linear-gradient(180deg, #10b981 0%, #059669 100%);
    }

    .payment-card-stripe.pending {
        background: linear-gradient(180deg, #f59e0b 0%, #d97706 100%);
    }

    .payment-card-stripe.failed {
        background: linear-gradient(180deg, #ef4444 0%, #dc2626 100%);
    }

    .payment-card-stripe.cancelled {
        background: linear-gradient(180deg, #6c757d 0%, #495057 100%);
    }

    /* Reference Badge */
    .payment-ref-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #f1f5f9;
        border: 1px solid #cbd5e1;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 700;
        font-family: 'Courier New', monospace;
        color: #475569;
    }

    /* Card Header */
    .payment-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
        padding-bottom: 12px;
        padding-left: 12px;
        padding-right: 60px;
        border-bottom: 1px solid #f1f5f9;
    }

    .payment-card-customer {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .payment-card-phone {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
    }

    .payment-card-status-badge {
        flex-shrink: 0;
        margin-left: 8px;
    }

    /* Amount Hero Box */
    .payment-amount-hero {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 18px;
        border-radius: 12px;
        margin-bottom: 12px;
        margin-left: 12px;
        margin-right: 12px;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border: 2px solid #86efac;
        position: relative;
        overflow: hidden;
    }

    .payment-amount-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.3) 0%, transparent 70%);
    }

    .payment-amount-content {
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .payment-amount-label {
        font-size: 11px;
        color: #059669;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .payment-amount-value {
        font-size: 28px;
        font-weight: 800;
        color: #059669;
        line-height: 1;
        text-shadow: 0 2px 4px rgba(5, 150, 105, 0.1);
    }

    /* Date & Method Info */
    .payment-info-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        background: #f8fafc;
        border-radius: 8px;
        margin-bottom: 12px;
        margin-left: 12px;
        margin-right: 12px;
    }

    .payment-info-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    .payment-info-content {
        flex: 1;
    }

    .payment-info-label {
        font-size: 10px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .payment-info-value {
        font-size: 13px;
        color: #1e293b;
        font-weight: 600;
    }

    /* Card Body - Grid */
    .payment-card-body {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 12px;
        padding-left: 12px;
    }

    .payment-detail-item {
        display: flex;
        flex-direction: column;
    }

    .payment-detail-label {
        font-size: 10px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .payment-detail-value {
        font-size: 13px;
        color: #1e293b;
        font-weight: 600;
    }

    .payment-detail-value a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 700;
    }

    /* Installment Badge */
    .payment-installment-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        background: #e8f4fd;
        border: 1px solid #b3d9ff;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        color: #0066cc;
    }

    /* Card Actions */
    .payment-card-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
        padding-left: 12px;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }

    .payment-action-btn {
        padding: 10px;
        border: 1px solid #e2e8f0;
        background: white;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        text-decoration: none;
        transition: all 0.2s ease;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
    }

    .payment-action-btn:active {
        transform: scale(0.95);
    }

    .payment-action-btn i {
        font-size: 16px;
    }

    .payment-action-btn.view {
        border-color: #0ea5e9;
        background: #e0f7ff;
        color: #0ea5e9;
    }

    .payment-action-btn.cancel {
        border-color: #ef4444;
        background: #fef2f2;
        color: #ef4444;
    }

    .payment-action-btn.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    /* Mobile Search Bar */
    .mobile-search-bar {
        display: none;
        position: sticky;
        top: 60px;
        z-index: 100;
        background: white;
        padding: 12px 0;
        margin: -16px 0 16px 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .mobile-search-input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        background: #f8fafc;
    }

    .mobile-search-input:focus {
        outline: none;
        border-color: #2563eb;
        background: white;
    }

    .mobile-search-icon {
        position: absolute;
        left: 14px;
        top: 22px;
        color: #64748b;
    }

    /* Empty State */
    .empty-state-mobile {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state-mobile i {
        font-size: 64px;
        color: #cbd5e1;
        margin-bottom: 16px;
    }

    .empty-state-mobile h3 {
        font-size: 18px;
        color: #475569;
        margin-bottom: 8px;
    }

    .empty-state-mobile p {
        font-size: 14px;
        color: #94a3b8;
    }

    /* ============================================
       RESPONSIVE - MOBILE VIEW
    ============================================ */
    @media (max-width: 768px) {
        /* Container Padding */
        .container-fluid {
            padding: 0 !important;
        }

        /* Page Header Mobile */
        .page-header {
            margin: 0 16px 16px 16px;
            padding: 1rem;
            border-radius: 8px;
        }

        .page-header h1 {
            font-size: 1.125rem !important;
        }

        .page-header p {
            font-size: 0.8125rem;
        }

        .page-header .d-flex {
            flex-direction: column;
            align-items: flex-start !important;
        }

        .page-header .btn {
            width: 100%;
            margin-top: 12px;
        }

        /* Stats Cards Mobile */
        .row.g-3.mb-4 {
            margin: 0 16px 16px 16px !important;
            gap: 8px !important;
        }

        .row.g-3.mb-4 > div {
            padding: 0 !important;
        }

        .stat-card {
            padding: 0.875rem;
        }

        .stat-value {
            font-size: 1.25rem;
        }

        .stat-label {
            font-size: 0.7rem;
        }

        /* Filter Card Mobile */
        .filter-card {
            margin: 0 16px 16px 16px !important;
            border-radius: 8px;
        }

        .filter-card .card-body {
            padding: 12px;
        }

        .filter-card .row {
            gap: 10px;
        }

        .filter-card .col-lg-2,
        .filter-card .col-lg-1,
        .filter-card .col-md-6,
        .filter-card .col-md-12 {
            width: 100%;
            padding: 0;
        }

        .filter-card label {
            font-size: 11px;
            margin-bottom: 4px;
        }

        .filter-card .form-select,
        .filter-card .form-control {
            font-size: 13px;
            padding: 8px 12px;
        }

        /* Hide Desktop Table */
        .table-card {
            display: none !important;
        }

        /* Show Mobile Cards */
        .mobile-cards-container {
            display: block;
            padding: 0 16px;
        }

        /* Show Mobile Search */
        .mobile-search-bar {
            display: block;
            margin: 0 16px 16px 16px;
        }
    }

    /* Small Mobile */
    @media (max-width: 374px) {
        .page-header h1 {
            font-size: 1rem !important;
        }

        .stat-value {
            font-size: 1.125rem;
        }

        .payment-card-mobile {
            padding: 0.875rem;
        }

        .payment-amount-value {
            font-size: 24px;
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
                <h1 class="h4 mb-1 fw-bold text-dark">
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

    <!-- Mobile: Search Bar -->
<div class="mobile-search-bar">
    <i class="bi bi-search mobile-search-icon"></i>
    <input type="text" id="mobileSearch" class="mobile-search-input" placeholder="Müşteri, referans ara...">
</div>

<!-- Mobile: Card Görünümü -->
<div class="mobile-cards-container">
    @forelse($payments as $payment)
        @php
            // Status Config
            $statusConfig = [
                'completed' => ['color' => 'success', 'label' => 'Tamamlandı', 'stripe' => 'completed'],
                'pending' => ['color' => 'warning', 'label' => 'Bekliyor', 'stripe' => 'pending'],
                'failed' => ['color' => 'danger', 'label' => 'Başarısız', 'stripe' => 'failed'],
                'cancelled' => ['color' => 'secondary', 'label' => 'İptal', 'stripe' => 'cancelled'],
            ];
            $status = $statusConfig[$payment->status] ?? ['color' => 'secondary', 'label' => $payment->status, 'stripe' => 'cancelled'];

            // Payment Method Config
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

        <div class="payment-card-mobile" data-payment-id="{{ $payment->id }}">
            <!-- Status Stripe -->
            <div class="payment-card-stripe {{ $status['stripe'] }}"></div>

            <!-- Reference Badge -->
            @if($payment->payment_reference)
                <div class="payment-ref-badge">{{ $payment->payment_reference }}</div>
            @endif

            <!-- Card Header -->
            <div class="payment-card-header">
                <div style="flex: 1; min-width: 0;">
                    <div class="payment-card-customer">{{ $payment->customer->name }}</div>
                    <div class="payment-card-phone">
                        <i class="bi bi-telephone"></i> {{ $payment->customer->phone }}
                    </div>
                </div>
                <div class="payment-card-status-badge">
                    <span class="badge badge-modern bg-{{ $status['color'] }}">
                        {{ $status['label'] }}
                    </span>
                </div>
            </div>

            <!-- Amount Hero -->
            <div class="payment-amount-hero">
                <div class="payment-amount-content">
                    <div class="payment-amount-label">Ödenen Tutar</div>
                    <div class="payment-amount-value">{{ number_format($payment->amount, 2) }}₺</div>
                </div>
            </div>

            <!-- Date & Method Info -->
            <div class="payment-info-row">
                <div class="payment-info-icon">
                    <i class="bi bi-calendar-event"></i>
                </div>
                <div class="payment-info-content">
                    <div class="payment-info-label">Ödeme Tarihi</div>
                    <div class="payment-info-value">
                        {{ $payment->payment_date->format('d.m.Y') }} - {{ $payment->payment_date->format('H:i') }}
                    </div>
                </div>
            </div>

            <div class="payment-info-row">
                <div class="payment-info-icon">
                    <i class="bi bi-{{ $methodIcons[$payment->payment_method] ?? 'cash' }}"></i>
                </div>
                <div class="payment-info-content">
                    <div class="payment-info-label">Ödeme Yöntemi</div>
                    <div class="payment-info-value">
                        {{ $methodLabels[$payment->payment_method] ?? $payment->payment_method }}
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="payment-card-body">
                <!-- Poliçe -->
                <div class="payment-detail-item">
                    <div class="payment-detail-label">Poliçe Numarası</div>
                    <div class="payment-detail-value">
                        @if($payment->policy)
                            <a href="{{ route('policies.show', $payment->policy) }}">
                                {{ $payment->policy->policy_number }}
                            </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                </div>

                <!-- Taksit -->
                <div class="payment-detail-item">
                    <div class="payment-detail-label">Taksit Bilgisi</div>
                    <div class="payment-detail-value">
                        @if($payment->installment)
                            <span class="payment-installment-badge">
                                {{ $payment->installment->installment_number }}/{{ $payment->installment->paymentPlan->installment_count }}
                            </span>
                        @else
                            <small class="text-muted">Tek Ödeme</small>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Card Actions -->
            <div class="payment-card-actions">
                <a href="{{ route('payments.show', $payment) }}" class="payment-action-btn view">
                    <i class="bi bi-eye"></i>
                    <span>Detayları Gör</span>
                </a>

                @if($payment->status === 'completed')
                    <form method="POST" action="{{ route('payments.cancel', $payment) }}" style="margin: 0;">
                        @csrf
                        <button type="button"
                                class="payment-action-btn cancel"
                                onclick="confirmCancelMobile(this)"
                                style="width: 100%;">
                            <i class="bi bi-x-circle"></i>
                            <span>İptal Et</span>
                        </button>
                    </form>
                @else
                    <div class="payment-action-btn cancel disabled">
                        <i class="bi bi-x-circle"></i>
                        <span>İptal Et</span>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="empty-state-mobile">
            <i class="bi bi-credit-card"></i>
            <h3>Ödeme Bulunamadı</h3>
            <p>Henüz ödeme kaydı bulunmamaktadır.</p>
        </div>
    @endforelse
</div>

    <!-- Desktop: Tablo Görünümü -->
    <div class="table-card card desktop-table-container">
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

<script>
// Mobile cancel confirmation
function confirmCancelMobile(button) {
    if (confirm('⚠️ Bu ödemeyi iptal etmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        button.closest('form').submit();
    }
}

// ... Mevcut confirmCancel function ...

$(document).ready(function() {
    // ... Mevcut DataTable kodu ...

    // Mobile Search
    $('#mobileSearch').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        filterMobileCards(searchTerm);
    });

    // Mobile Filter Function
    function filterMobileCards(searchTerm = '') {
        const status = $('#filterStatus').val();
        const paymentMethod = $('#filterPaymentMethod').val();

        let visibleCount = 0;

        $('.payment-card-mobile').each(function() {
            const $card = $(this);
            const cardText = $card.text().toLowerCase();
            const cardStatus = $card.find('.payment-card-status-badge .badge').text().trim();
            const cardMethod = $card.find('.payment-info-row').eq(1).find('.payment-info-value').text().trim();

            let show = true;

            // Search filter
            if (searchTerm && !cardText.includes(searchTerm)) {
                show = false;
            }

            // Status filter
            if (status && cardStatus !== status) {
                show = false;
            }

            // Payment method filter
            if (paymentMethod && cardMethod !== paymentMethod) {
                show = false;
            }

            if (show) {
                $card.show();
                visibleCount++;
            } else {
                $card.hide();
            }
        });

        // Update count for mobile
        if (window.innerWidth <= 768) {
            $('#paymentCount').html(`Gösterilen: <strong>${visibleCount}</strong> / <strong>{{ $payments->count() }}</strong> ödeme`);
        }
    }

    // Filter change event for mobile
    $('#filterStatus, #filterPaymentMethod').on('change', function() {
        if (window.innerWidth <= 768) {
            filterMobileCards($('#mobileSearch').val().toLowerCase());
        }
    });
});

// Update clearFilters function
function clearFilters() {
    $('#filterStatus, #filterPaymentMethod, #filterDateFrom, #filterDateTo').val('');
    $('#mobileSearch').val('');

    $.fn.dataTable.ext.search = [];

    const table = $('#paymentsTable').DataTable();
    table.search('').columns().search('').draw();

    // Reset mobile cards
    $('.payment-card-mobile').show();

    if (window.innerWidth <= 768) {
        $('#paymentCount').html(`Toplam: <strong>{{ $payments->count() }}</strong> ödeme`);
    }
}
</script>
@endpush
