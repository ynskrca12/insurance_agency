@extends('layouts.app')

@section('title', 'Kampanyalar')

@push('styles')
<style>
    .page-header {
        padding: 12px 0;
        margin-bottom: 1rem;
    }

    .stat-card {
        border: 1px solid #dcdcdc;
        border-radius: 20px;
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
        font-size: 2rem;
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

    .btn-primary.action-btn {
        border-color: #0d6efd;
    }

    .btn-info.action-btn {
        border-color: #0dcaf0;
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
    .campaign-title {
        color: #212529;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9375rem;
        transition: color 0.2s ease;
    }

    .campaign-title:hover {
        color: #0d6efd;
    }

    .campaign-subject {
        color: #6c757d;
        font-size: 0.8125rem;
        margin-top: 0.25rem;
    }

    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.375rem 0.75rem;
        background: #f8f9fa;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 500;
        border: 1px solid #dee2e6;
    }

    .recipient-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
        font-weight: 600;
        border-radius: 6px;
        font-size: 0.875rem;
        background: #e7f3ff;
        color: #0066cc;
        border: 1px solid #b3d9ff;
    }

    .sent-count {
        color: #28a745;
        font-size: 0.8125rem;
        margin-top: 0.375rem;
        font-weight: 500;
    }

    .badge-modern {
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.8125rem;
    }

    .action-buttons {
        display: flex;
        gap: 0.25rem;
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

    .btn-icon.btn-send:hover {
        background: #28a745;
        border-color: #28a745;
        color: #ffffff;
    }

    .btn-icon.btn-delete:hover {
        background: #dc3545;
        border-color: #dc3545;
        color: #ffffff;
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
</style>

<style>
    /* ============================================
       MOBILE OPTIMIZATION - ULTRA PREMIUM
    ============================================ */

    /* Mobile Cards Container */
    .mobile-cards-container {
        display: none;
    }

    /* Campaign Card Mobile - Premium Design */
    .campaign-card-mobile {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        padding: 1.25rem;
        margin-bottom: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        overflow: hidden;
    }

    .campaign-card-mobile:active {
        transform: scale(0.97);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    /* Type Gradient Top Bar */
    .campaign-card-mobile::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
    }

    .campaign-card-mobile.sms::before {
        background: linear-gradient(90deg, #3b82f6 0%, #2563eb 100%);
    }

    .campaign-card-mobile.email::before {
        background: linear-gradient(90deg, #0ea5e9 0%, #0284c7 100%);
    }

    .campaign-card-mobile.whatsapp::before {
        background: linear-gradient(90deg, #10b981 0%, #059669 100%);
    }

    /* Status Corner Badge */
    .campaign-status-corner {
        position: absolute;
        top: 0;
        right: 0;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 55px 55px 0;
    }

    .campaign-status-corner.draft {
        border-color: transparent #f59e0b transparent transparent;
    }

    .campaign-status-corner.scheduled {
        border-color: transparent #0ea5e9 transparent transparent;
    }

    .campaign-status-corner.sending {
        border-color: transparent #3b82f6 transparent transparent;
    }

    .campaign-status-corner.sent {
        border-color: transparent #10b981 transparent transparent;
    }

    .campaign-status-corner.failed {
        border-color: transparent #ef4444 transparent transparent;
    }

    .campaign-status-icon {
        position: absolute;
        top: 8px;
        right: 8px;
        color: white;
        font-size: 14px;
        font-weight: 700;
    }

    /* Card Header */
    .campaign-card-header {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 14px;
        padding-bottom: 14px;
        border-bottom: 2px solid #f1f5f9;
    }

    .campaign-type-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .campaign-type-icon.sms {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }

    .campaign-type-icon.email {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        color: white;
    }

    .campaign-type-icon.whatsapp {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .campaign-header-content {
        flex: 1;
        min-width: 0;
        padding-right: 50px;
    }

    .campaign-card-title {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .campaign-card-subject {
        font-size: 12px;
        color: #64748b;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Recipients Box */
    .campaign-recipients-box {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px;
        border-radius: 12px;
        margin-bottom: 12px;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 2px solid #93c5fd;
    }

    .campaign-recipients-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: #3b82f6;
        box-shadow: 0 3px 10px rgba(59, 130, 246, 0.2);
    }

    .campaign-recipients-content {
        flex: 1;
        margin-left: 12px;
    }

    .campaign-recipients-label {
        font-size: 10px;
        color: #1e40af;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .campaign-recipients-value {
        font-size: 22px;
        font-weight: 800;
        color: #1e40af;
        line-height: 1;
    }

    .campaign-recipients-sent {
        text-align: right;
    }

    .campaign-sent-label {
        font-size: 9px;
        color: #059669;
        font-weight: 700;
        text-transform: uppercase;
    }

    .campaign-sent-value {
        font-size: 16px;
        font-weight: 700;
        color: #059669;
        display: flex;
        align-items: center;
        gap: 4px;
        justify-content: flex-end;
    }

    /* Info Rows */
    .campaign-info-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        background: #f8fafc;
        border-radius: 10px;
        margin-bottom: 10px;
    }

    .campaign-info-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        background: white;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    .campaign-info-content {
        flex: 1;
    }

    .campaign-info-label {
        font-size: 10px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .campaign-info-value {
        font-size: 13px;
        color: #1e293b;
        font-weight: 600;
    }

    /* Target Badge */
    .campaign-target-badge {
        display: inline-flex;
        align-items: center;
        padding: 5px 12px;
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border: 1px solid #86efac;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        color: #059669;
    }

    /* Schedule Alert */
    .campaign-schedule-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 12px;
        background: linear-gradient(135deg, #fff7ed 0%, #fed7aa 100%);
        border: 2px solid #fdba74;
    }

    .campaign-schedule-icon {
        font-size: 24px;
        color: #ea580c;
    }

    .campaign-schedule-content {
        flex: 1;
    }

    .campaign-schedule-text {
        font-size: 13px;
        font-weight: 700;
        color: #ea580c;
        line-height: 1.3;
    }

    .campaign-schedule-date {
        font-size: 11px;
        color: #ea580c;
        opacity: 0.85;
        font-weight: 600;
        margin-top: 2px;
    }

    /* Card Actions */
    .campaign-card-actions {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        padding-top: 12px;
        border-top: 2px solid #f1f5f9;
    }

    .campaign-card-actions.two-cols {
        grid-template-columns: repeat(2, 1fr);
    }

    .campaign-action-btn {
        padding: 12px;
        border: 2px solid #e2e8f0;
        background: white;
        border-radius: 12px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        text-decoration: none;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }

    .campaign-action-btn:active {
        transform: scale(0.93);
    }

    .campaign-action-btn i {
        font-size: 20px;
    }

    .campaign-action-btn span {
        font-size: 11px;
        font-weight: 700;
    }

    .campaign-action-btn.view {
        border-color: #0ea5e9;
        background: linear-gradient(135deg, #e0f7ff 0%, #bae6fd 100%);
    }

    .campaign-action-btn.view i {
        color: #0ea5e9;
    }

    .campaign-action-btn.view span {
        color: #0ea5e9;
    }

    .campaign-action-btn.send {
        border-color: #10b981;
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
    }

    .campaign-action-btn.send i {
        color: #10b981;
    }

    .campaign-action-btn.send span {
        color: #10b981;
    }

    .campaign-action-btn.delete {
        border-color: #ef4444;
        background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
    }

    .campaign-action-btn.delete i {
        color: #ef4444;
    }

    .campaign-action-btn.delete span {
        color: #ef4444;
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
        padding: 12px 16px 12px 44px;
        border: 2px solid #e2e8f0;
        border-radius: 12px;
        font-size: 14px;
        background: #f8fafc;
        transition: all 0.3s ease;
    }

    .mobile-search-input:focus {
        outline: none;
        border-color: #3b82f6;
        background: white;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
    }

    .mobile-search-icon {
        position: absolute;
        left: 16px;
        top: 24px;
        color: #64748b;
        font-size: 18px;
    }

    /* Empty State */
    .empty-state-mobile {
        text-align: center;
        padding: 80px 20px;
    }

    .empty-state-mobile i {
        font-size: 72px;
        background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 20px;
    }

    .empty-state-mobile h3 {
        font-size: 20px;
        color: #1e293b;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .empty-state-mobile p {
        font-size: 14px;
        color: #64748b;
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
            padding: 0 16px 12px 16px;
            margin-bottom: 16px;
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
            font-size: 1.375rem;
        }

        .stat-label {
            font-size: 0.7rem;
        }

        /* Filter Card Mobile */
        .filter-card {
            margin: 0 16px 16px 16px !important;
            border-radius: 12px;
        }

        .filter-card .card-body {
            padding: 12px;
        }

        .filter-card .row {
            gap: 10px;
        }

        .filter-card .col-lg-3,
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
            font-size: 1.25rem;
        }

        .campaign-card-mobile {
            padding: 1rem;
        }

        .campaign-type-icon {
            width: 44px;
            height: 44px;
            font-size: 20px;
        }

        .campaign-recipients-value {
            font-size: 20px;
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
                    <i class="bi bi-megaphone me-2"></i>Kampanyalar
                </h1>
                <p class="text-muted mb-0 small" id="campaignCount">
                    Toplam <strong>{{ $campaigns->count() }}</strong> kampanya kaydı bulundu
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('campaigns.templates') }}" class="btn btn-info action-btn text-white">
                    <i class="bi bi-file-earmark-text me-2"></i>Şablonlar
                </a>
                <a href="{{ route('campaigns.create') }}" class="btn btn-primary action-btn">
                    <i class="bi bi-plus-circle me-2"></i>Yeni Kampanya
                </a>
            </div>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-primary">{{ number_format($stats['total']) }}</div>
                <div class="stat-label">Toplam Kampanya</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-warning">{{ number_format($stats['draft']) }}</div>
                <div class="stat-label">Taslak</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-info">{{ number_format($stats['scheduled']) }}</div>
                <div class="stat-label">Zamanlanmış</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-success">{{ number_format($stats['sent']) }}</div>
                <div class="stat-label">Gönderildi</div>
            </div>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="filter-card card">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <!-- Durum -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Durum</label>
                    <select id="filterStatus" class="form-select">
                        <option value="">Tümü</option>
                        <option value="Taslak">Taslak</option>
                        <option value="Zamanlanmış">Zamanlanmış</option>
                        <option value="Gönderiliyor">Gönderiliyor</option>
                        <option value="Gönderildi">Gönderildi</option>
                        <option value="Başarısız">Başarısız</option>
                    </select>
                </div>

                <!-- Tip -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Kampanya Tipi</label>
                    <select id="filterType" class="form-select">
                        <option value="">Tümü</option>
                        <option value="SMS">SMS</option>
                        <option value="E-posta">E-posta</option>
                        <option value="WhatsApp">WhatsApp</option>
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
    <input type="text" id="mobileSearch" class="mobile-search-input" placeholder="Kampanya ara...">
</div>

<!-- Mobile: Premium Card Görünümü -->
<div class="mobile-cards-container">
    @forelse($campaigns as $campaign)
        @php
            // Type Config
            $typeConfig = [
                'sms' => ['icon' => 'chat-dots', 'label' => 'SMS', 'class' => 'sms'],
                'email' => ['icon' => 'envelope', 'label' => 'E-posta', 'class' => 'email'],
                'whatsapp' => ['icon' => 'whatsapp', 'label' => 'WhatsApp', 'class' => 'whatsapp'],
            ];
            $type = $typeConfig[$campaign->type] ?? ['icon' => 'chat', 'label' => $campaign->type, 'class' => 'sms'];

            // Status Config
            $statusConfig = [
                'draft' => ['color' => 'warning', 'label' => 'Taslak', 'class' => 'draft', 'icon' => 'bi-pencil-square'],
                'scheduled' => ['color' => 'info', 'label' => 'Zamanlanmış', 'class' => 'scheduled', 'icon' => 'bi-clock'],
                'sending' => ['color' => 'primary', 'label' => 'Gönderiliyor', 'class' => 'sending', 'icon' => 'bi-arrow-repeat'],
                'sent' => ['color' => 'success', 'label' => 'Gönderildi', 'class' => 'sent', 'icon' => 'bi-check-circle'],
                'failed' => ['color' => 'danger', 'label' => 'Başarısız', 'class' => 'failed', 'icon' => 'bi-x-circle'],
            ];
            $status = $statusConfig[$campaign->status] ?? ['color' => 'secondary', 'label' => $campaign->status, 'class' => 'draft', 'icon' => 'bi-circle'];

            // Target Labels
            $targetLabels = [
                'all' => 'Tüm Müşteriler',
                'active_customers' => 'Aktif Müşteriler',
                'policy_type' => 'Poliçe Türü',
                'city' => 'Şehir',
                'custom' => 'Özel',
            ];
        @endphp

        <div class="campaign-card-mobile {{ $type['class'] }}" data-campaign-id="{{ $campaign->id }}">
            <!-- Status Corner Badge -->
            <div class="campaign-status-corner {{ $status['class'] }}">
                <i class="campaign-status-icon {{ $status['icon'] }}"></i>
            </div>

            <!-- Card Header -->
            <div class="campaign-card-header">
                <div class="campaign-type-icon {{ $type['class'] }}">
                    <i class="bi bi-{{ $type['icon'] }}"></i>
                </div>
                <div class="campaign-header-content">
                    <div class="campaign-card-title">{{ $campaign->name }}</div>
                    @if($campaign->subject)
                        <div class="campaign-card-subject">{{ $campaign->subject }}</div>
                    @endif
                </div>
            </div>

            <!-- Recipients Box -->
            <div class="campaign-recipients-box">
                <div class="campaign-recipients-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="campaign-recipients-content">
                    <div class="campaign-recipients-label">Toplam Alıcı</div>
                    <div class="campaign-recipients-value">{{ number_format($campaign->total_recipients) }}</div>
                </div>
                @if($campaign->sent_count > 0)
                <div class="campaign-recipients-sent">
                    <div class="campaign-sent-label">Gönderildi</div>
                    <div class="campaign-sent-value">
                        <i class="bi bi-check-circle-fill"></i>
                        {{ number_format($campaign->sent_count) }}
                    </div>
                </div>
                @endif
            </div>

            <!-- Info Rows -->
            <div class="campaign-info-row">
                <div class="campaign-info-icon">
                    <i class="bi bi-{{ $type['icon'] }}"></i>
                </div>
                <div class="campaign-info-content">
                    <div class="campaign-info-label">Kampanya Tipi</div>
                    <div class="campaign-info-value">{{ $type['label'] }}</div>
                </div>
            </div>

            <div class="campaign-info-row">
                <div class="campaign-info-icon">
                    <i class="bi bi-bullseye"></i>
                </div>
                <div class="campaign-info-content">
                    <div class="campaign-info-label">Hedef Kitle</div>
                    <div class="campaign-info-value">
                        <span class="campaign-target-badge">
                            {{ $targetLabels[$campaign->target_type] ?? $campaign->target_type }}
                        </span>
                    </div>
                </div>
            </div>

            @if($campaign->scheduled_at)
            <!-- Schedule Alert -->
            <div class="campaign-schedule-alert">
                <i class="bi bi-calendar-event campaign-schedule-icon"></i>
                <div class="campaign-schedule-content">
                    <div class="campaign-schedule-text">Zamanlanmış Gönderim</div>
                    <div class="campaign-schedule-date">
                        {{ $campaign->scheduled_at->format('d.m.Y - H:i') }}
                    </div>
                </div>
            </div>
            @else
            <div class="campaign-info-row">
                <div class="campaign-info-icon">
                    <i class="bi bi-calendar"></i>
                </div>
                <div class="campaign-info-content">
                    <div class="campaign-info-label">Oluşturulma Tarihi</div>
                    <div class="campaign-info-value">
                        {{ $campaign->created_at->format('d.m.Y - H:i') }}
                    </div>
                </div>
            </div>
            @endif

            <!-- Card Actions -->
            @if(in_array($campaign->status, ['draft', 'scheduled']))
                <div class="campaign-card-actions">
                    <a href="{{ route('campaigns.show', $campaign) }}" class="campaign-action-btn view">
                        <i class="bi bi-eye"></i>
                        <span>Detay</span>
                    </a>

                    <form method="POST" action="{{ route('campaigns.send', $campaign) }}" style="margin: 0;">
                        @csrf
                        <button type="button"
                                class="campaign-action-btn send"
                                onclick="confirmSendMobile(this)"
                                style="width: 100%;">
                            <i class="bi bi-send"></i>
                            <span>Gönder</span>
                        </button>
                    </form>

                    <button onclick="deleteCampaign({{ $campaign->id }})" class="campaign-action-btn delete">
                        <i class="bi bi-trash"></i>
                        <span>Sil</span>
                    </button>
                </div>
            @else
                <div class="campaign-card-actions two-cols">
                    <a href="{{ route('campaigns.show', $campaign) }}" class="campaign-action-btn view">
                        <i class="bi bi-eye"></i>
                        <span>Detayları Gör</span>
                    </a>

                    <div class="campaign-action-btn" style="opacity: 0.5; cursor: not-allowed;">
                        <i class="bi bi-check-circle"></i>
                        <span>{{ $status['label'] }}</span>
                    </div>
                </div>
            @endif
        </div>
    @empty
        <div class="empty-state-mobile">
            <i class="bi bi-megaphone"></i>
            <h3>Kampanya Bulunamadı</h3>
            <p>Henüz kampanya kaydı bulunmamaktadır.</p>
        </div>
    @endforelse
</div>

    <!-- Desktop: Tablo Görünümü -->
    <div class="table-card desktop-table-container">
        <div class="card-body">
            <table class="table table-hover" id="campaignsTable">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Kampanya Adı</th>
                        <th>Tip</th>
                        <th>Hedef Kitle</th>
                        <th>Alıcı Sayısı</th>
                        <th>Tarih</th>
                        <th>Durum</th>
                        <th>Oluşturan Kişi</th>
                        <th width="120" class="text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($campaigns as $campaign)
                    <tr>
                        <td></td>
                        <td>
                            <a href="{{ route('campaigns.show', $campaign) }}" class="campaign-title">
                                {{ $campaign->name }}
                            </a>
                            @if($campaign->subject)
                            <div class="campaign-subject">{{ Str::limit($campaign->subject, 60) }}</div>
                            @endif
                        </td>
                        <td>
                            @php
                                $typeConfig = [
                                    'sms' => ['icon' => 'chat-dots', 'label' => 'SMS', 'color' => 'primary'],
                                    'email' => ['icon' => 'envelope', 'label' => 'E-posta', 'color' => 'info'],
                                    'whatsapp' => ['icon' => 'whatsapp', 'label' => 'WhatsApp', 'color' => 'success'],
                                ];
                                $type = $typeConfig[$campaign->type] ?? ['icon' => 'chat', 'label' => $campaign->type, 'color' => 'secondary'];
                            @endphp
                            <span class="type-badge">
                                <i class="bi bi-{{ $type['icon'] }} text-{{ $type['color'] }}"></i>
                                <span>{{ $type['label'] }}</span>
                            </span>
                        </td>
                        <td>
                            @php
                                $targetLabels = [
                                    'all' => 'Tüm Müşteriler',
                                    'active_customers' => 'Aktif Müşteriler',
                                    'policy_type' => 'Poliçe Türü',
                                    'city' => 'Şehir',
                                    'custom' => 'Özel',
                                ];
                            @endphp
                            <small class="text-muted">{{ $targetLabels[$campaign->target_type] ?? $campaign->target_type }}</small>
                        </td>
                        <td>
                            <span class="recipient-badge">
                                <i class="bi bi-people-fill me-1"></i>
                                {{ number_format($campaign->total_recipients) }}
                            </span>
                            @if($campaign->sent_count > 0)
                                <div class="sent-count">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    {{ number_format($campaign->sent_count) }} gönderildi
                                </div>
                            @endif
                        </td>
                        <td data-sort="{{ $campaign->scheduled_at ? $campaign->scheduled_at->format('Y-m-d H:i:s') : $campaign->created_at->format('Y-m-d H:i:s') }}">
                            @if($campaign->scheduled_at)
                                <div class="fw-semibold">{{ $campaign->scheduled_at->format('d.m.Y') }}</div>
                                <small class="text-muted">{{ $campaign->scheduled_at->format('H:i') }}</small>
                            @else
                                <div class="fw-semibold">{{ $campaign->created_at->format('d.m.Y') }}</div>
                                <small class="text-muted">{{ $campaign->created_at->format('H:i') }}</small>
                            @endif
                        </td>
                        <td>
                            @php
                                $statusConfig = [
                                    'draft' => ['color' => 'warning', 'label' => 'Taslak'],
                                    'scheduled' => ['color' => 'info', 'label' => 'Zamanlanmış'],
                                    'sending' => ['color' => 'primary', 'label' => 'Gönderiliyor'],
                                    'sent' => ['color' => 'success', 'label' => 'Gönderildi'],
                                    'failed' => ['color' => 'danger', 'label' => 'Başarısız'],
                                ];
                                $status = $statusConfig[$campaign->status] ?? ['color' => 'secondary', 'label' => $campaign->status];
                            @endphp
                            <span class="badge badge-modern bg-{{ $status['color'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td>
                            <span class="text-muted">{{ $campaign->createdBy->name }}</span>
                        </td>
                        <td class="text-end">
                            <div class="action-buttons">
                                <a href="{{ route('campaigns.show', $campaign) }}"
                                   class="btn-icon btn-view"
                                   title="Detay">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(in_array($campaign->status, ['draft', 'scheduled']))
                                <form method="POST" action="{{ route('campaigns.send', $campaign) }}" class="d-inline">
                                    @csrf
                                    <button type="button"
                                            class="btn-icon btn-send"
                                            onclick="confirmSend(this)"
                                            title="Gönder">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </form>
                                <button type="button"
                                        class="btn-icon btn-delete"
                                        onclick="deleteCampaign({{ $campaign->id }})"
                                        title="Sil">
                                    <i class="bi bi-trash"></i>
                                </button>
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

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function confirmSend(button) {
    if (confirm('⚠️ Kampanyayı göndermek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        button.closest('form').submit();
    }
}

function deleteCampaign(campaignId) {
    if (confirm('⚠️ Bu kampanyayı silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        const form = document.getElementById('deleteForm');
        form.action = '/panel/campaigns/' + campaignId;
        form.submit();
    }
}

$(document).ready(function() {
    // ✅ DataTable başlat
    const table = initDataTable('#campaignsTable', {
        order: [[5, 'desc']], // Tarihe göre sırala
        pageLength: 25,
        columnDefs: [
            { orderable: false, searchable: false, targets: 0 }, // Sıra numarası
            { orderable: false, targets: [7] }, // İşlemler
            { targets: 5, type: 'date' } // Tarih
        ]
    });

    // ✅ Filtreler
    $('#filterStatus, #filterType, #filterDateFrom, #filterDateTo').on('change', function() {
        const status = $('#filterStatus').val();
        const type = $('#filterType').val();
        const dateFrom = $('#filterDateFrom').val();
        const dateTo = $('#filterDateTo').val();

        // Tüm custom filtreleri temizle
        $.fn.dataTable.ext.search = [];

        // Durum filtresi
        if (status) {
            table.column(6).search(status);
        } else {
            table.column(6).search('');
        }

        // Tip filtresi
        if (type) {
            table.column(2).search(type);
        } else {
            table.column(2).search('');
        }

        // Tarih aralığı filtresi
        if (dateFrom || dateTo) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const dateStr = data[5]; // Tarih sütunu
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
        $('#campaignCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> kampanya`);
    });

    // İlk yüklemede toplam sayıyı güncelle
    const info = table.page.info();
    $('#campaignCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> kampanya`);
});

function clearFilters() {
    $('#filterStatus, #filterType, #filterDateFrom, #filterDateTo').val('');
    $.fn.dataTable.ext.search = [];
    const table = $('#campaignsTable').DataTable();
    table.search('').columns().search('').draw();
}
</script>

<script>
// Mobile send confirmation
function confirmSendMobile(button) {
    if (confirm(' Kampanyayı göndermek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        button.closest('form').submit();
    }
}

$(document).ready(function() {

    // Mobile Search
    $('#mobileSearch').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        filterMobileCards(searchTerm);
    });

    // Mobile Filter Function
    function filterMobileCards(searchTerm = '') {
        const status = $('#filterStatus').val();
        const type = $('#filterType').val();

        let visibleCount = 0;

        $('.campaign-card-mobile').each(function() {
            const $card = $(this);
            const cardText = $card.text().toLowerCase();
            const cardStatus = $card.find('.campaign-status-corner').attr('class');
            const cardType = $card.find('.campaign-type-icon').attr('class');

            let show = true;

            // Search filter
            if (searchTerm && !cardText.includes(searchTerm)) {
                show = false;
            }

            // Status filter
            if (status) {
                const statusMatch = cardStatus.includes(status.toLowerCase());
                if (!statusMatch) {
                    show = false;
                }
            }

            // Type filter
            if (type) {
                const typeMatch = cardType.includes(type.toLowerCase());
                if (!typeMatch) {
                    show = false;
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
            $('#campaignCount').html(`Gösterilen: <strong>${visibleCount}</strong> / <strong>{{ $campaigns->count() }}</strong> kampanya`);
        }
    }

    // Filter change event for mobile
    $('#filterStatus, #filterType').on('change', function() {
        if (window.innerWidth <= 768) {
            filterMobileCards($('#mobileSearch').val().toLowerCase());
        }
    });
});

// Update clearFilters function
function clearFilters() {
    $('#filterStatus, #filterType, #filterDateFrom, #filterDateTo').val('');
    $('#mobileSearch').val('');

    $.fn.dataTable.ext.search = [];

    const table = $('#campaignsTable').DataTable();
    table.search('').columns().search('').draw();

    // Reset mobile cards
    $('.campaign-card-mobile').show();

    if (window.innerWidth <= 768) {
        $('#campaignCount').html(`Toplam: <strong>{{ $campaigns->count() }}</strong> kampanya`);
    }
}
</script>
@endpush
