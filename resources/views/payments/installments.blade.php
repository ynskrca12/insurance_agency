@extends('layouts.app')

@section('title', 'Taksit Planları')

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

    .stat-sublabel {
        font-size: 0.75rem;
        color: #9ca3af;
        margin-top: 0.25rem;
    }

    .filter-card {
        border: 1px solid #dcdcdc;
        border-radius: 20px;
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

    .btn-primary.action-btn,
    .btn-success.action-btn {
        border-color: transparent;
    }

    .table-card {
        border: 1px solid #dcdcdc;
        border-radius: 20px;
        background: #ffffff;
        overflow: hidden;
    }

    .table-card .card-body {
        padding: 1.5rem;
    }
    .table-card td {
        vertical-align: middle;
    }

    .table-modern tbody tr.row-overdue {
        background: #fff5f5 !important;
        border-left: 3px solid #dc3545;
    }

    .table-modern tbody tr.row-due-today {
        background: #fffbf0 !important;
        border-left: 3px solid #ffc107;
    }

    .table-modern tbody tr.row-critical {
        background: #fff9f0 !important;
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
        justify-content: end;
        gap: 0.25rem;
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
</style>
@push('styles')
<style>
    /* ============================================
       MOBILE OPTIMIZATION - PROFESSIONAL
    ============================================ */

    /* Mobile Cards Container */
    .mobile-cards-container {
        display: none;
    }

    /* Installment Card Mobile */
    .installment-card-mobile {
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

    .installment-card-mobile:active {
        transform: scale(0.98);
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
    }

    /* Status Stripe */
    .installment-card-stripe {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
    }

    .installment-card-stripe.overdue {
        background: linear-gradient(180deg, #ef4444 0%, #dc2626 100%);
    }

    .installment-card-stripe.today {
        background: linear-gradient(180deg, #f59e0b 0%, #d97706 100%);
    }

    .installment-card-stripe.critical {
        background: linear-gradient(180deg, #ff9800 0%, #e65100 100%);
    }

    .installment-card-stripe.normal {
        background: linear-gradient(180deg, #10b981 0%, #059669 100%);
    }

    /* Card Header */
    .installment-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 12px;
        padding-bottom: 12px;
        padding-left: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .installment-card-customer {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }

    .installment-card-phone {
        font-size: 11px;
        color: #94a3b8;
        font-weight: 500;
    }

    .installment-card-status-badge {
        flex-shrink: 0;
        margin-left: 8px;
    }

    /* Amount Alert Box */
    .installment-amount-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 16px;
        border-radius: 10px;
        margin-bottom: 12px;
        margin-left: 12px;
        margin-right: 12px;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border: 2px solid #86efac;
    }

    .installment-amount-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #10b981;
        box-shadow: 0 2px 8px rgba(16, 185, 129, 0.2);
    }

    .installment-amount-content {
        flex: 1;
        margin-left: 12px;
    }

    .installment-amount-label {
        font-size: 10px;
        color: #059669;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .installment-amount-value {
        font-size: 22px;
        font-weight: 800;
        color: #059669;
        line-height: 1;
    }

    /* Due Date Alert */
    .installment-due-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 8px;
        margin-bottom: 12px;
        margin-left: 12px;
        margin-right: 12px;
    }

    .installment-due-alert.overdue {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border: 1px solid #fca5a5;
    }

    .installment-due-alert.today {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border: 1px solid #fcd34d;
    }

    .installment-due-alert.critical {
        background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
        border: 1px solid #ffb74d;
    }

    .installment-due-alert.normal {
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border: 1px solid #cbd5e1;
    }

    .installment-due-icon {
        font-size: 22px;
    }

    .installment-due-content {
        flex: 1;
    }

    .installment-due-text {
        font-size: 13px;
        font-weight: 700;
        line-height: 1.3;
    }

    .installment-due-date {
        font-size: 11px;
        opacity: 0.8;
        font-weight: 600;
    }

    /* Card Body - Grid */
    .installment-card-body {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 12px;
        margin-bottom: 12px;
        padding-left: 12px;
    }

    .installment-info-item {
        display: flex;
        flex-direction: column;
    }

    .installment-info-label {
        font-size: 10px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 4px;
    }

    .installment-info-value {
        font-size: 13px;
        color: #1e293b;
        font-weight: 600;
    }

    .installment-info-value a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 700;
    }

    /* Installment Number Badge */
    .installment-number-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 12px;
        background: #e8f4fd;
        border: 1px solid #b3d9ff;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        color: #0066cc;
    }

    /* Card Actions */
    .installment-card-actions {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
        padding-left: 12px;
        padding-top: 12px;
        border-top: 1px solid #f1f5f9;
    }

    .installment-card-actions.three-cols {
        grid-template-columns: repeat(3, 1fr);
    }

    .installment-action-btn {
        padding: 10px;
        border: 1px solid #e2e8f0;
        background: white;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .installment-action-btn:active {
        transform: scale(0.95);
    }

    .installment-action-btn i {
        font-size: 18px;
    }

    .installment-action-btn span {
        font-size: 11px;
        font-weight: 700;
    }

    .installment-action-btn.pay {
        border-color: #10b981;
        background: #f0fdf4;
    }

    .installment-action-btn.pay i {
        color: #10b981;
    }

    .installment-action-btn.pay span {
        color: #10b981;
    }

    .installment-action-btn.remind {
        border-color: #0ea5e9;
        background: #e0f7ff;
    }

    .installment-action-btn.remind i {
        color: #0ea5e9;
    }

    .installment-action-btn.remind span {
        color: #0ea5e9;
    }

    .installment-action-btn.view {
        border-color: #2563eb;
        background: #eff6ff;
    }

    .installment-action-btn.view i {
        color: #2563eb;
    }

    .installment-action-btn.view span {
        color: #2563eb;
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

        .page-header .d-flex.gap-2 {
            width: 100%;
            margin-top: 12px;
        }

        .page-header .btn {
            flex: 1;
            font-size: 0.8125rem;
            padding: 0.5rem 0.75rem;
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

        .stat-sublabel {
            font-size: 0.65rem;
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
        .filter-card .col-lg-3,
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

        /* Modal Mobile */
        .modal-modern .modal-dialog {
            margin: 0.5rem;
        }

        .modal-modern .modal-header,
        .modal-modern .modal-body,
        .modal-modern .modal-footer {
            padding: 1rem;
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

        .installment-card-mobile {
            padding: 0.875rem;
        }

        .installment-amount-value {
            font-size: 20px;
        }

        .installment-card-actions.three-cols {
            grid-template-columns: repeat(2, 1fr);
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
                    <i class="bi bi-calendar3 me-2"></i>Taksit Planları
                </h1>
                <p class="text-muted mb-0 small" id="installmentCount">
                    Toplam <strong>{{ $installments->count() }}</strong> taksit kaydı bulundu
                </p>
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
    <div class="filter-card">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <!-- Durum -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Durum</label>
                    <select id="filterStatus" class="form-select">
                        <option value="">Tümü</option>
                        <option value="Bekliyor">Bekliyor</option>
                        <option value="Ödendi">Ödendi</option>
                        <option value="Gecikmiş">Gecikmiş</option>
                    </select>
                </div>

                <!-- Vade Durumu -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Vade Durumu</label>
                    <select id="filterDateFilter" class="form-select">
                        <option value="">Tüm Tarihler</option>
                        <option value="due_today">Bugün Vadesi Dolan</option>
                        <option value="overdue">Gecikmiş</option>
                        <option value="upcoming_7">7 Gün İçinde</option>
                        <option value="upcoming_30">30 Gün İçinde</option>
                    </select>
                </div>

                <!-- Başlangıç Tarihi -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Başlangıç Vade Tarihi</label>
                    <input type="date" id="filterDateFrom" class="form-control">
                </div>

                <!-- Bitiş Tarihi -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Bitiş Vade Tarihi</label>
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
    <input type="text" id="mobileSearch" class="mobile-search-input" placeholder="Müşteri, poliçe ara...">
</div>

<!-- Mobile: Card Görünümü -->
<div class="mobile-cards-container">
    @forelse($installments as $installment)
        @php
            $daysUntilDue = now()->startOfDay()->diffInDays($installment->due_date->startOfDay(), false);
            $isOverdue = $daysUntilDue < 0;
            $isDueToday = $daysUntilDue === 0;
            $isCritical = $daysUntilDue > 0 && $daysUntilDue <= 7;

            // Stripe & Alert Config
            if ($isOverdue) {
                $stripeClass = 'overdue';
                $alertClass = 'overdue';
                $alertIcon = 'bi-exclamation-triangle-fill';
                $alertColor = '#ef4444';
                $alertText = abs($daysUntilDue) . ' gün geçti';
            } elseif ($isDueToday) {
                $stripeClass = 'today';
                $alertClass = 'today';
                $alertIcon = 'bi-clock-fill';
                $alertColor = '#f59e0b';
                $alertText = 'Bugün';
            } elseif ($isCritical) {
                $stripeClass = 'critical';
                $alertClass = 'critical';
                $alertIcon = 'bi-exclamation-circle-fill';
                $alertColor = '#ff9800';
                $alertText = $daysUntilDue . ' gün kaldı';
            } else {
                $stripeClass = 'normal';
                $alertClass = 'normal';
                $alertIcon = 'bi-calendar-check';
                $alertColor = '#64748b';
                $alertText = $daysUntilDue . ' gün kaldı';
            }

            // Status Config
            $statusConfig = [
                'pending' => ['color' => 'warning', 'label' => 'Bekliyor'],
                'paid' => ['color' => 'success', 'label' => 'Ödendi'],
                'overdue' => ['color' => 'danger', 'label' => 'Gecikmiş'],
            ];
            $status = $statusConfig[$installment->status] ?? ['color' => 'secondary', 'label' => $installment->status];
        @endphp

        <div class="installment-card-mobile" data-installment-id="{{ $installment->id }}" data-days="{{ $daysUntilDue }}">
            <!-- Status Stripe -->
            <div class="installment-card-stripe {{ $stripeClass }}"></div>

            <!-- Card Header -->
            <div class="installment-card-header">
                <div style="flex: 1; min-width: 0;">
                    <div class="installment-card-customer">
                        {{ $installment->paymentPlan->customer->name }}
                    </div>
                    <div class="installment-card-phone">
                        <i class="bi bi-telephone"></i> {{ $installment->paymentPlan->customer->phone }}
                    </div>
                </div>
                <div class="installment-card-status-badge">
                    <span class="badge badge-modern bg-{{ $status['color'] }}">
                        {{ $status['label'] }}
                    </span>
                </div>
            </div>

            <!-- Amount Box -->
            <div class="installment-amount-box">
                <div class="installment-amount-icon">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div class="installment-amount-content">
                    <div class="installment-amount-label">Taksit Tutarı</div>
                    <div class="installment-amount-value">{{ number_format($installment->amount, 2) }}₺</div>
                </div>
            </div>

            <!-- Due Date Alert -->
            <div class="installment-due-alert {{ $alertClass }}">
                <i class="bi {{ $alertIcon }}" style="color: {{ $alertColor }}; font-size: 22px;"></i>
                <div class="installment-due-content">
                    <div class="installment-due-text" style="color: {{ $alertColor }}">
                        {{ $alertText }}
                    </div>
                    <div class="installment-due-date" style="color: {{ $alertColor }}">
                        Vade: {{ $installment->due_date->format('d.m.Y') }}
                    </div>
                </div>
            </div>

            <!-- Card Body -->
            <div class="installment-card-body">
                <!-- Poliçe No -->
                <div class="installment-info-item">
                    <div class="installment-info-label">Poliçe Numarası</div>
                    <div class="installment-info-value">
                        <a href="{{ route('policies.show', $installment->paymentPlan->policy) }}">
                            {{ $installment->paymentPlan->policy->policy_number }}
                        </a>
                    </div>
                </div>

                <!-- Taksit -->
                <div class="installment-info-item">
                    <div class="installment-info-label">Taksit Bilgisi</div>
                    <div class="installment-info-value">
                        <span class="installment-number-badge">
                            {{ $installment->installment_number }}/{{ $installment->paymentPlan->installment_count }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Card Actions -->
            @if($installment->status === 'pending' || $installment->status === 'overdue')
                <div class="installment-card-actions three-cols">
                    <button type="button"
                            class="installment-action-btn pay"
                            data-bs-toggle="modal"
                            data-bs-target="#paymentModal"
                            onclick="setInstallmentData({{ $installment->id }}, '{{ addslashes($installment->paymentPlan->customer->name) }}', '{{ $installment->paymentPlan->policy->policy_number }}', {{ $installment->installment_number }}, {{ $installment->amount }})">
                        <i class="bi bi-cash"></i>
                        <span>Ödeme</span>
                    </button>

                    <form method="POST" action="{{ route('payments.sendReminder', $installment) }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="installment-action-btn remind" style="width: 100%;">
                            <i class="bi bi-send"></i>
                            <span>Hatırlat</span>
                        </button>
                    </form>

                    <a href="{{ route('customers.show', $installment->paymentPlan->customer) }}"
                       class="installment-action-btn view">
                        <i class="bi bi-eye"></i>
                        <span>Müşteri</span>
                    </a>
                </div>
            @else
                <div class="installment-card-actions">
                    @if($installment->payment)
                        <a href="{{ route('payments.show', $installment->payment) }}"
                           class="installment-action-btn view">
                            <i class="bi bi-eye"></i>
                            <span>Ödeme Detayı</span>
                        </a>
                    @endif

                    <a href="{{ route('customers.show', $installment->paymentPlan->customer) }}"
                       class="installment-action-btn view">
                        <i class="bi bi-person"></i>
                        <span>Müşteri</span>
                    </a>
                </div>
            @endif
        </div>
    @empty
        <div class="empty-state-mobile">
            <i class="bi bi-calendar3"></i>
            <h3>Taksit Bulunamadı</h3>
            <p>Henüz taksit kaydı bulunmamaktadır.</p>
        </div>
    @endforelse
</div>

    <!-- Desktop: Tablo Görünümü -->
    <div class="table-card desktop-table-container">
        <div class="card-body">
            <table class="table table-hover" id="installmentsTable">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Müşteri</th>
                        <th>Poliçe</th>
                        <th>Taksit</th>
                        <th>Vade Tarihi</th>
                        <th>Kalan Süre</th>
                        <th>Tutar</th>
                        <th>Durum</th>
                        <th width="150" class="text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($installments as $index => $installment)
                    @php
                        $daysUntilDue = now()->startOfDay()->diffInDays($installment->due_date->startOfDay(), false);
                        $isOverdue = $daysUntilDue < 0;
                        $isDueToday = $daysUntilDue === 0;
                        $isCritical = $daysUntilDue > 0 && $daysUntilDue <= 7;

                        $rowClass = '';
                        if ($isOverdue) $rowClass = 'row-overdue';
                        elseif ($isDueToday) $rowClass = 'row-due-today';
                        elseif ($isCritical) $rowClass = 'row-critical';
                    @endphp
                    <tr class="{{ $rowClass }}" data-days="{{ $daysUntilDue }}" data-date-filter="">
                        <td></td>
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
                        <td data-sort="{{ $installment->due_date->format('Y-m-d') }}">
                            <div class="fw-semibold">{{ $installment->due_date->format('d.m.Y') }}</div>
                        </td>
                        <td data-order="{{ $daysUntilDue }}">
                            @if($isOverdue)
                                 @if ($installment->status == 'paid')
                                     <span class="badge badge-modern bg-success }}">
                                        Ödendi
                                    </span>
                                @else
                                    <span class="days-badge overdue">
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                        {{ abs($daysUntilDue) }} gün geçti
                                    </span>
                                @endif
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
                        <td data-order="{{ $installment->amount }}">
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
    // ✅ DataTable başlat
    const table = initDataTable('#installmentsTable', {
        order: [[5, 'asc']], // Kalan süreye göre sırala
        pageLength: 25,
        columnDefs: [
            { orderable: false, searchable: false, targets: 0 }, // Sıra numarası
            { orderable: false, targets: [8] }, // İşlemler
            { targets: 4, type: 'date' }, // Vade tarihi
            { targets: 5, type: 'num' }, // Kalan süre
            { targets: 6, type: 'num' } // Tutar
        ],
        createdRow: function(row, data, dataIndex) {
            // Satır sınıflarını koru
            const tr = $(row);
            const daysLeft = parseInt(tr.attr('data-days'));

            if (daysLeft < 0) {
                tr.addClass('row-overdue');
            } else if (daysLeft === 0) {
                tr.addClass('row-due-today');
            } else if (daysLeft > 0 && daysLeft <= 7) {
                tr.addClass('row-critical');
            }
        }
    });

    // ✅ Filtreler
    $('#filterStatus, #filterDateFilter, #filterDateFrom, #filterDateTo').on('change', function() {
        const status = $('#filterStatus').val();
        const dateFilter = $('#filterDateFilter').val();
        const dateFrom = $('#filterDateFrom').val();
        const dateTo = $('#filterDateTo').val();

        // Tüm custom filtreleri temizle
        $.fn.dataTable.ext.search = [];

        // Durum filtresi
        if (status) {
            table.column(7).search(status);
        } else {
            table.column(7).search('');
        }

        // Vade durumu filtresi
        if (dateFilter) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const row = table.row(dataIndex).node();
                    const daysLeft = parseInt($(row).attr('data-days'));

                    switch(dateFilter) {
                        case 'due_today':
                            return daysLeft === 0;
                        case 'overdue':
                            return daysLeft < 0;
                        case 'upcoming_7':
                            return daysLeft > 0 && daysLeft <= 7;
                        case 'upcoming_30':
                            return daysLeft > 0 && daysLeft <= 30;
                        default:
                            return true;
                    }
                }
            );
        }

        // Tarih aralığı filtresi
        if (dateFrom || dateTo) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const dateStr = data[4]; // Vade tarihi sütunu
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
        $('#installmentCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> taksit`);
    });

    // İlk yüklemede toplam sayıyı güncelle
    const info = table.page.info();
    $('#installmentCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> taksit`);

    // Form submit animasyonu
    $('#paymentForm, #bulkReminderForm').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>İşleniyor...');
    });
});

function clearFilters() {
    $('#filterStatus, #filterDateFilter, #filterDateFrom, #filterDateTo').val('');
    $.fn.dataTable.ext.search = [];
    const table = $('#installmentsTable').DataTable();
    table.search('').columns().search('').draw();
}
</script>

<script>

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
        const dateFilter = $('#filterDateFilter').val();

        let visibleCount = 0;

        $('.installment-card-mobile').each(function() {
            const $card = $(this);
            const cardText = $card.text().toLowerCase();
            const cardStatus = $card.find('.badge-modern').text().trim();
            const cardDays = parseInt($card.attr('data-days'));

            let show = true;

            // Search filter
            if (searchTerm && !cardText.includes(searchTerm)) {
                show = false;
            }

            // Status filter
            if (status && cardStatus !== status) {
                show = false;
            }

            // Date filter
            if (dateFilter) {
                switch(dateFilter) {
                    case 'due_today':
                        show = show && cardDays === 0;
                        break;
                    case 'overdue':
                        show = show && cardDays < 0;
                        break;
                    case 'upcoming_7':
                        show = show && cardDays > 0 && cardDays <= 7;
                        break;
                    case 'upcoming_30':
                        show = show && cardDays > 0 && cardDays <= 30;
                        break;
                }
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
            $('#installmentCount').html(`Gösterilen: <strong>${visibleCount}</strong> / <strong>{{ $installments->count() }}</strong> taksit`);
        }
    }

    // Filter change event for mobile
    $('#filterStatus, #filterDateFilter').on('change', function() {
        if (window.innerWidth <= 768) {
            filterMobileCards($('#mobileSearch').val().toLowerCase());
        }
    });
});

// Update clearFilters function
function clearFilters() {
    $('#filterStatus, #filterDateFilter, #filterDateFrom, #filterDateTo').val('');
    $('#mobileSearch').val('');

    $.fn.dataTable.ext.search = [];

    const table = $('#installmentsTable').DataTable();
    table.search('').columns().search('').draw();

    // Reset mobile cards
    $('.installment-card-mobile').show();

    if (window.innerWidth <= 768) {
        $('#installmentCount').html(`Toplam: <strong>{{ $installments->count() }}</strong> taksit`);
    }
}
</script>
@endpush
