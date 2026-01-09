@extends('layouts.app')

@section('title', 'Görevler')

@push('styles')
<style>
    .page-header {
        padding: 12px 0;
        margin-bottom: 1rem;
        }
        /* Genel */
        body {
            background-color: #f4f6f9;
        }

        .page-header h1 {
            font-size: 1.25rem;
            font-weight: 600;
        }

        .page-header p {
            font-size: 0.875rem;
        }

        /* Kart Yapısı */
        .card {
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            box-shadow: none;
        }

        .card-body {
            padding: 1.25rem;
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

    .dt-buttons .btn {
        margin-right: 0.5rem;
    }

    .row-overdue {
        background-color: #fff5f5 !important;
    }

    .badge-modern {
        font-weight: 500;
        font-size: 0.75rem;
        padding: 0.35em 0.6em;
        border-radius: 4px;
    }

    .category-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.75rem;
        color: #374151;
    }

    .user-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .avatar-circle {
        width: 28px;
        height: 28px;
        border-radius: 50%;
        background: #e5e7eb;
        color: #374151;
        font-size: 0.75rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .action-buttons {
        display: flex;
        justify-content: flex-end;
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
    .btn-icon.btn-delete:hover {
        background: #dc3545;
        border-color: #dc3545;
        color: #ffffff;
    }

    .dataTables_length,
    .dataTables_filter,
    .dataTables_info,
    .dataTables_paginate {
        font-size: 0.75rem;
        padding: 0.75rem 0;
    }

    .dt-buttons .btn {
        font-size: 0.75rem;
        padding: 0.35rem 0.6rem;
    }

    .customer-link {
        color: #212529;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }
    .task-title {
        font-weight: 600;
        color: #001f4d;
        font-size: 0.9375rem;
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

    /* Task Card Mobile - Premium Design */
    .task-card-mobile {
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

    .task-card-mobile:active {
        transform: scale(0.97);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
    }

    /* Gradient Overlay Effect */
    .task-card-mobile::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 50%, #ec4899 100%);
        opacity: 0.8;
    }

    .task-card-mobile.overdue::before {
        background: linear-gradient(90deg, #ef4444 0%, #dc2626 100%);
    }

    /* Priority Corner Badge */
    .task-priority-corner {
        position: absolute;
        top: 0;
        right: 0;
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 50px 50px 0;
    }

    .task-priority-corner.low {
        border-color: transparent #94a3b8 transparent transparent;
    }

    .task-priority-corner.normal {
        border-color: transparent #0ea5e9 transparent transparent;
    }

    .task-priority-corner.high {
        border-color: transparent #f59e0b transparent transparent;
    }

    .task-priority-corner.urgent {
        border-color: transparent #ef4444 transparent transparent;
    }

    .task-priority-icon {
        position: absolute;
        top: 8px;
        right: 8px;
        color: white;
        font-size: 14px;
        font-weight: 700;
    }

    /* Card Header */
    .task-card-header {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        margin-bottom: 14px;
        padding-bottom: 14px;
        border-bottom: 2px solid #f1f5f9;
    }

    .task-category-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .task-category-icon.call {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
    }

    .task-category-icon.meeting {
        background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        color: white;
    }

    .task-category-icon.follow_up {
        background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
        color: white;
    }

    .task-category-icon.document {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .task-category-icon.renewal {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        color: white;
    }

    .task-category-icon.payment {
        background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
        color: white;
    }

    .task-category-icon.quotation {
        background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
        color: white;
    }

    .task-category-icon.other {
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: white;
    }

    .task-header-content {
        flex: 1;
        min-width: 0;
    }

    .task-card-title {
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

    .task-card-description {
        font-size: 13px;
        color: #64748b;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Status Badge */
    .task-status-badge-mobile {
        position: absolute;
        top: 14px;
        right: 14px;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    /* Due Date Alert */
    .task-due-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px;
        border-radius: 12px;
        margin-bottom: 12px;
    }

    .task-due-alert.overdue {
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
        border: 2px solid #fca5a5;
    }

    .task-due-alert.today {
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
        border: 2px solid #fcd34d;
    }

    .task-due-alert.upcoming {
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
        border: 2px solid #93c5fd;
    }

    .task-due-alert.normal {
        background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
        border: 2px solid #86efac;
    }

    .task-due-icon {
        font-size: 24px;
    }

    .task-due-content {
        flex: 1;
    }

    .task-due-text {
        font-size: 13px;
        font-weight: 700;
        line-height: 1.3;
    }

    .task-due-date {
        font-size: 11px;
        opacity: 0.85;
        font-weight: 600;
        margin-top: 2px;
    }

    /* Info Row */
    .task-info-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 12px;
        background: #f8fafc;
        border-radius: 10px;
        margin-bottom: 12px;
    }

    .task-info-icon {
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

    .task-info-content {
        flex: 1;
    }

    .task-info-label {
        font-size: 10px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .task-info-value {
        font-size: 13px;
        color: #1e293b;
        font-weight: 600;
    }

    .task-info-value a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 700;
    }

    /* Assigned User */
    .task-assigned-user {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        border-radius: 10px;
        margin-bottom: 12px;
    }

    .task-user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        color: white;
        font-size: 16px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 10px rgba(59, 130, 246, 0.3);
    }

    .task-user-info {
        flex: 1;
    }

    .task-user-label {
        font-size: 10px;
        color: #64748b;
        font-weight: 700;
        text-transform: uppercase;
        margin-bottom: 2px;
    }

    .task-user-name {
        font-size: 14px;
        color: #1e293b;
        font-weight: 700;
    }

    /* Card Actions */
    .task-card-actions {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        padding-top: 12px;
        border-top: 2px solid #f1f5f9;
    }

    .task-action-btn {
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

    .task-action-btn:active {
        transform: scale(0.93);
    }

    .task-action-btn i {
        font-size: 20px;
    }

    .task-action-btn span {
        font-size: 11px;
        font-weight: 700;
    }

    .task-action-btn.view {
        border-color: #3b82f6;
        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
    }

    .task-action-btn.view i {
        color: #3b82f6;
    }

    .task-action-btn.view span {
        color: #3b82f6;
    }

    .task-action-btn.edit {
        border-color: #f59e0b;
        background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 100%);
    }

    .task-action-btn.edit i {
        color: #f59e0b;
    }

    .task-action-btn.edit span {
        color: #f59e0b;
    }

    .task-action-btn.delete {
        border-color: #ef4444;
        background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
    }

    .task-action-btn.delete i {
        color: #ef4444;
    }

    .task-action-btn.delete span {
        color: #ef4444;
    }

    .task-action-btn.disabled {
        opacity: 0.4;
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

        .task-card-mobile {
            padding: 1rem;
        }

        .task-category-icon {
            width: 40px;
            height: 40px;
            font-size: 18px;
        }

        .task-card-actions {
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
        }
    }
</style>

    {{-- TASKS PAGE - STAT CARDS --}}
<style>
    .task-stat-card {
        position: relative;
        border-radius: 12px;
        padding: 1.125rem;
        overflow: hidden;
        border: none;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        gap: 0.625rem;
        cursor: pointer;
    }

    .task-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
    }

    /* Content */
    .task-stat-content {
        z-index: 2;
        position: relative;
    }

    .task-stat-value {
        font-size: 1.625rem;
        font-weight: 800;
        color: #ffffff;
        line-height: 1;
        margin-bottom: 0.375rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .task-stat-label {
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: rgba(255, 255, 255, 0.85);
    }

    /* Background Icon */
    .task-stat-bg {
        position: absolute;
        bottom: -12px;
        right: -12px;
        font-size: 100px;
        color: rgba(255, 255, 255, 0.08);
        z-index: 1;
        line-height: 1;
        pointer-events: none;
        transform: rotate(-15deg);
        transition: all 0.4s ease;
    }

    .task-stat-card:hover .task-stat-bg {
        transform: rotate(-10deg) scale(1.05);
        color: rgba(255, 255, 255, 0.12);
    }

    /* Pulse Badge (Gecikmiş için) */
    .task-stat-pulse {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 10px;
        height: 10px;
        background: #ffffff;
        border-radius: 50%;
        z-index: 3;
        animation: taskPulse 2s infinite;
    }

    @keyframes taskPulse {
        0%, 100% {
            opacity: 1;
            transform: scale(1);
            box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7);
        }
        50% {
            opacity: 0.7;
            transform: scale(1.1);
            box-shadow: 0 0 0 6px rgba(255, 255, 255, 0);
        }
    }

    /* ========================================
    COLOR VARIANTS
    ======================================== */

    /* Primary - Mavi (Toplam) */
    .task-stat-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    }

    .task-stat-primary:hover {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    }

    /* Warning - Turuncu (Bekliyor) */
    .task-stat-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    .task-stat-warning:hover {
        background: linear-gradient(135deg, #d97706 0%, #b45309 100%);
    }

    /* Info - Cyan (Devam Ediyor) */
    .task-stat-info {
        background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%);
    }

    .task-stat-info:hover {
        background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
    }

    /* Success - Yeşil (Tamamlandı) */
    .task-stat-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .task-stat-success:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
    }

    /* Danger - Kırmızı (Gecikmiş) */
    .task-stat-danger {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
    }

    .task-stat-danger:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    }

    /* Dark - Koyu Gri (Benim) */
    .task-stat-dark {
        background: linear-gradient(135deg, #475569 0%, #334155 100%);
    }

    .task-stat-dark:hover {
        background: linear-gradient(135deg, #334155 0%, #1e293b 100%);
    }

    /* ========================================
    RESPONSIVE
    ======================================== */

    @media (max-width: 1400px) {
        .task-stat-value {
            font-size: 1.5rem;
        }

        .task-stat-bg {
            font-size: 90px;
        }
    }

    @media (max-width: 1200px) {
        .task-stat-value {
            font-size: 1.375rem;
        }

        .task-stat-bg {
            font-size: 80px;
        }
    }

    @media (max-width: 992px) {
        .task-stat-card {
            padding: 1rem;
        }

        .task-stat-value {
            font-size: 1.25rem;
        }
    }

    @media (max-width: 768px) {
        .task-stat-value {
            font-size: 1.125rem;
        }

        .task-stat-label {
            font-size: 0.688rem;
        }

        .task-stat-bg {
            font-size: 70px;
            bottom: -10px;
            right: -10px;
        }
    }

    @media (max-width: 576px) {
        .task-stat-card {
            padding: 0.875rem;
        }

        .task-stat-value {
            font-size: 1rem;
        }

        .task-stat-label {
            font-size: 0.625rem;
        }

        .task-stat-bg {
            font-size: 60px;
        }
    }

    /* ========================================
    ANIMATION
    ======================================== */

    @keyframes scaleIn {
        from {
            opacity: 0;
            transform: scale(0.9);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .task-stat-card {
        animation: scaleIn 0.4s ease-out;
    }

    .task-stat-card:nth-child(1) { animation-delay: 0s; }
    .task-stat-card:nth-child(2) { animation-delay: 0.05s; }
    .task-stat-card:nth-child(3) { animation-delay: 0.1s; }
    .task-stat-card:nth-child(4) { animation-delay: 0.15s; }
    .task-stat-card:nth-child(5) { animation-delay: 0.2s; }
    .task-stat-card:nth-child(6) { animation-delay: 0.25s; }

    /* ========================================
    CLICK EFFECT
    ======================================== */

    .task-stat-card:active {
        transform: translateY(-2px) scale(0.98);
    }

    /* Hover overlay */
    .task-stat-card::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0);
        transition: all 0.3s ease;
        z-index: 3;
        pointer-events: none;
    }

    .task-stat-card:hover::after {
        background: rgba(255, 255, 255, 0.1);
    }

    /* ========================================
    SHAKE EFFECT (Gecikmiş için)
    ======================================== */

    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-1px); }
        20%, 40%, 60%, 80% { transform: translateX(1px); }
    }

    .task-stat-danger:hover {
        animation: shake 0.5s ease;
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
                    <i class="bi bi-check2-square me-2"></i>Görevler
                </h1>
                <p class="text-muted mb-0 small" id="taskCount">
                    Toplam <strong>{{ $tasks->count() }}</strong> görev kaydı bulundu
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('tasks.kanban') }}" class="btn btn-info action-btn text-white">
                    <i class="bi bi-kanban me-2"></i>Kanban
                </a>
                <a href="{{ route('tasks.create') }}" class="btn btn-primary action-btn">
                    <i class="bi bi-plus-circle me-2"></i>Yeni Görev
                </a>
            </div>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <!-- Toplam -->
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="task-stat-card task-stat-primary">
                <div class="task-stat-content">
                    <div class="task-stat-value">{{ number_format($stats['total']) }}</div>
                    <div class="task-stat-label">Toplam</div>
                </div>
                <div class="task-stat-bg">
                    <i class="bi bi-list-task"></i>
                </div>
            </div>
        </div>

        <!-- Bekliyor -->
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="task-stat-card task-stat-warning">
                <div class="task-stat-content">
                    <div class="task-stat-value">{{ number_format($stats['pending']) }}</div>
                    <div class="task-stat-label">Bekliyor</div>
                </div>
                <div class="task-stat-bg">
                    <i class="bi bi-hourglass-split"></i>
                </div>
            </div>
        </div>

        <!-- Devam Ediyor -->
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="task-stat-card task-stat-info">
                <div class="task-stat-content">
                    <div class="task-stat-value">{{ number_format($stats['in_progress']) }}</div>
                    <div class="task-stat-label">Devam Ediyor</div>
                </div>
                <div class="task-stat-bg">
                    <i class="bi bi-arrow-repeat"></i>
                </div>
            </div>
        </div>

        <!-- Tamamlandı -->
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="task-stat-card task-stat-success">
                <div class="task-stat-content">
                    <div class="task-stat-value">{{ number_format($stats['completed']) }}</div>
                    <div class="task-stat-label">Tamamlandı</div>
                </div>
                <div class="task-stat-bg">
                    <i class="bi bi-check-circle"></i>
                </div>
            </div>
        </div>

        <!-- Gecikmiş -->
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="task-stat-card task-stat-danger">
                <div class="task-stat-content">
                    <div class="task-stat-value">{{ number_format($stats['overdue']) }}</div>
                    <div class="task-stat-label">Gecikmiş</div>
                </div>
                <div class="task-stat-bg">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                @if($stats['overdue'] > 0)
                    <span class="task-stat-pulse"></span>
                @endif
            </div>
        </div>

        <!-- Benim -->
        <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="task-stat-card task-stat-dark">
                <div class="task-stat-content">
                    <div class="task-stat-value">{{ number_format($stats['my_tasks']) }}</div>
                    <div class="task-stat-label">Benim</div>
                </div>
                <div class="task-stat-bg">
                    <i class="bi bi-person-check"></i>
                </div>
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
                        <option value="Bekliyor">Bekliyor</option>
                        <option value="Devam Ediyor">Devam Ediyor</option>
                        <option value="Tamamlandı">Tamamlandı</option>
                        <option value="İptal">İptal</option>
                    </select>
                </div>

                <!-- Öncelik -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Öncelik</label>
                    <select id="filterPriority" class="form-select">
                        <option value="">Tümü</option>
                        <option value="Düşük">Düşük</option>
                        <option value="Normal">Normal</option>
                        <option value="Yüksek">Yüksek</option>
                        <option value="Acil">Acil</option>
                    </select>
                </div>

                <!-- Kategori -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Kategori</label>
                    <select id="filterCategory" class="form-select">
                        <option value="">Tümü</option>
                        <option value="Arama">Arama</option>
                        <option value="Toplantı">Toplantı</option>
                        <option value="Takip">Takip</option>
                        <option value="Evrak">Evrak</option>
                        <option value="Yenileme">Yenileme</option>
                        <option value="Ödeme">Ödeme</option>
                        <option value="Teklif">Teklif</option>
                        <option value="Diğer">Diğer</option>
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
    <input type="text" id="mobileSearch" class="mobile-search-input" placeholder="Görev ara...">
</div>

<!-- Mobile: Premium Card Görünümü -->
<div class="mobile-cards-container">
    @forelse($tasks as $task)
        @php
            $isOverdue = $task->due_date < now() && !in_array($task->status, ['completed', 'cancelled']);

            // Due Date Alert Config
            if ($isOverdue) {
                $dueAlertClass = 'overdue';
                $dueIcon = 'bi-exclamation-triangle-fill';
                $dueColor = '#ef4444';
                $dueText = 'Gecikmiş!';
            } elseif ($task->due_date->isToday()) {
                $dueAlertClass = 'today';
                $dueIcon = 'bi-clock-fill';
                $dueColor = '#f59e0b';
                $dueText = 'Bugün Bitiyor';
            } elseif ($task->due_date->diffInDays(now()) <= 3) {
                $dueAlertClass = 'upcoming';
                $dueIcon = 'bi-calendar-event';
                $dueColor = '#3b82f6';
                $dueText = $task->due_date->diffInDays(now()) . ' gün kaldı';
            } else {
                $dueAlertClass = 'normal';
                $dueIcon = 'bi-calendar-check';
                $dueColor = '#10b981';
                $dueText = $task->due_date->diffInDays(now()) . ' gün kaldı';
            }

            // Category Config
            $categoryConfig = [
                'call' => ['icon' => 'telephone', 'label' => 'Arama', 'class' => 'call'],
                'meeting' => ['icon' => 'people', 'label' => 'Toplantı', 'class' => 'meeting'],
                'follow_up' => ['icon' => 'arrow-repeat', 'label' => 'Takip', 'class' => 'follow_up'],
                'document' => ['icon' => 'file-earmark-text', 'label' => 'Evrak', 'class' => 'document'],
                'renewal' => ['icon' => 'arrow-clockwise', 'label' => 'Yenileme', 'class' => 'renewal'],
                'payment' => ['icon' => 'cash', 'label' => 'Ödeme', 'class' => 'payment'],
                'quotation' => ['icon' => 'file-earmark-plus', 'label' => 'Teklif', 'class' => 'quotation'],
                'other' => ['icon' => 'three-dots', 'label' => 'Diğer', 'class' => 'other'],
            ];
            $category = $categoryConfig[$task->category] ?? ['icon' => 'circle', 'label' => $task->category, 'class' => 'other'];

            // Priority Config
            $priorityConfig = [
                'low' => ['color' => 'secondary', 'label' => 'Düşük', 'class' => 'low'],
                'normal' => ['color' => 'info', 'label' => 'Normal', 'class' => 'normal'],
                'high' => ['color' => 'warning', 'label' => 'Yüksek', 'class' => 'high'],
                'urgent' => ['color' => 'danger', 'label' => 'Acil', 'class' => 'urgent'],
            ];
            $priority = $priorityConfig[$task->priority] ?? ['color' => 'secondary', 'label' => $task->priority, 'class' => 'normal'];

            // Status Config
            $statusConfig = [
                'pending' => ['color' => 'warning', 'label' => 'Bekliyor'],
                'in_progress' => ['color' => 'info', 'label' => 'Devam Ediyor'],
                'completed' => ['color' => 'success', 'label' => 'Tamamlandı'],
                'cancelled' => ['color' => 'secondary', 'label' => 'İptal'],
            ];
            $status = $statusConfig[$task->status] ?? ['color' => 'secondary', 'label' => $task->status];
        @endphp

        <div class="task-card-mobile {{ $isOverdue ? 'overdue' : '' }}" data-task-id="{{ $task->id }}">
            <!-- Priority Corner Badge -->
            <div class="task-priority-corner {{ $priority['class'] }}">
                <i class="task-priority-icon bi bi-exclamation-circle-fill"></i>
            </div>

            <!-- Status Badge -->
            <div class="task-status-badge-mobile bg-{{ $status['color'] }}">
                {{ $status['label'] }}
            </div>

            <!-- Card Header -->
            <div class="task-card-header">
                <div class="task-category-icon {{ $category['class'] }}">
                    <i class="bi bi-{{ $category['icon'] }}"></i>
                </div>
                <div class="task-header-content">
                    <div class="task-card-title">{{ $task->title }}</div>
                    @if($task->description)
                        <div class="task-card-description">{{ $task->description }}</div>
                    @endif
                </div>
            </div>

            <!-- Due Date Alert -->
            <div class="task-due-alert {{ $dueAlertClass }}">
                <i class="bi {{ $dueIcon }}" style="color: {{ $dueColor }}; font-size: 24px;"></i>
                <div class="task-due-content">
                    <div class="task-due-text" style="color: {{ $dueColor }}">
                        {{ $dueText }}
                    </div>
                    <div class="task-due-date" style="color: {{ $dueColor }}">
                        {{ $task->due_date->format('d.m.Y') }}
                        @if($task->due_date->format('H:i') !== '00:00')
                            - {{ $task->due_date->format('H:i') }}
                        @endif
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            @if($task->customer)
            <div class="task-info-row">
                <div class="task-info-icon">
                    <i class="bi bi-person"></i>
                </div>
                <div class="task-info-content">
                    <div class="task-info-label">Müşteri</div>
                    <div class="task-info-value">
                        <a href="{{ route('customers.show', $task->customer) }}">
                            {{ $task->customer->name }}
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Assigned User -->
            <div class="task-assigned-user">
                <div class="task-user-avatar">
                    {{ substr($task->assignedTo->name, 0, 1) }}
                </div>
                <div class="task-user-info">
                    <div class="task-user-label">Atanan Kişi</div>
                    <div class="task-user-name">{{ $task->assignedTo->name }}</div>
                </div>
                <span class="badge badge-modern bg-{{ $priority['color'] }}">
                    {{ $priority['label'] }}
                </span>
            </div>

            <!-- Card Actions -->
            <div class="task-card-actions">
                <a href="{{ route('tasks.show', $task) }}" class="task-action-btn view">
                    <i class="bi bi-eye"></i>
                    <span>Detay</span>
                </a>

                @if(!in_array($task->status, ['completed', 'cancelled']))
                    <a href="{{ route('tasks.edit', $task) }}" class="task-action-btn edit">
                        <i class="bi bi-pencil"></i>
                        <span>Düzenle</span>
                    </a>
                @else
                    <div class="task-action-btn edit disabled">
                        <i class="bi bi-pencil"></i>
                        <span>Düzenle</span>
                    </div>
                @endif

                <button onclick="deleteTask({{ $task->id }})" class="task-action-btn delete">
                    <i class="bi bi-trash"></i>
                    <span>Sil</span>
                </button>
            </div>
        </div>
    @empty
        <div class="empty-state-mobile">
            <i class="bi bi-check2-square"></i>
            <h3>Görev Bulunamadı</h3>
            <p>Henüz görev kaydı bulunmamaktadır.</p>
        </div>
    @endforelse
</div>

    <!-- Desktop: Tablo Görünümü -->
    <div class="table-card desktop-table-container">
        <div class="card-body">
            <table class="table table-hover" id="tasksTable">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Görev</th>
                        <th>Kategori</th>
                        <th>Müşteri</th>
                        <th>Atanan</th>
                        <th>Vade Tarihi</th>
                        <th>Öncelik</th>
                        <th>Durum</th>
                        <th>Oluşturan Kişi</th>
                        <th width="120" class="text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tasks as $index => $task)
                    @php
                        $isOverdue = $task->due_date < now() && !in_array($task->status, ['completed', 'cancelled']);
                    @endphp
                    <tr class="{{ $isOverdue ? 'row-overdue' : '' }}" data-overdue="{{ $isOverdue ? '1' : '0' }}">
                        <td></td>
                        <td>
                            <a href="{{ route('tasks.show', $task) }}" class="task-title">
                                {{ $task->title }}
                            </a>
                            @if($task->description)
                            <div class="task-description">{{ Str::limit($task->description, 60) }}</div>
                            @endif
                        </td>
                        <td>
                            @php
                                $categoryConfig = [
                                    'call' => ['icon' => 'telephone', 'label' => 'Arama'],
                                    'meeting' => ['icon' => 'people', 'label' => 'Toplantı'],
                                    'follow_up' => ['icon' => 'arrow-repeat', 'label' => 'Takip'],
                                    'document' => ['icon' => 'file-earmark-text', 'label' => 'Evrak'],
                                    'renewal' => ['icon' => 'arrow-clockwise', 'label' => 'Yenileme'],
                                    'payment' => ['icon' => 'cash', 'label' => 'Ödeme'],
                                    'quotation' => ['icon' => 'file-earmark-plus', 'label' => 'Teklif'],
                                    'other' => ['icon' => 'three-dots', 'label' => 'Diğer'],
                                ];
                                $category = $categoryConfig[$task->category] ?? ['icon' => 'circle', 'label' => $task->category];
                            @endphp
                            <span class="category-badge">
                                <i class="bi bi-{{ $category['icon'] }}"></i>
                                <span>{{ $category['label'] }}</span>
                            </span>
                        </td>
                        <td>
                            @if($task->customer)
                                <a href="{{ route('customers.show', $task->customer) }}" class="text-decoration-none customer-link">
                                    {{ $task->customer->name }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="user-info">
                                <div class="avatar-circle">
                                    {{ substr($task->assignedTo->name, 0, 1) }}
                                </div>
                                <span class="user-name">{{ Str::limit($task->assignedTo->name, 15) }}</span>
                            </div>
                        </td>
                        <td data-sort="{{ $task->due_date->format('Y-m-d H:i:s') }}">
                            <div class="fw-semibold">{{ $task->due_date->format('d.m.Y') }}</div>
                            @if($task->due_date->format('H:i') !== '00:00')
                                <small class="text-muted">{{ $task->due_date->format('H:i') }}</small>
                            @endif
                        </td>
                        <td>
                            @php
                                $priorityConfig = [
                                    'low' => ['color' => 'secondary', 'label' => 'Düşük'],
                                    'normal' => ['color' => 'info', 'label' => 'Normal'],
                                    'high' => ['color' => 'warning', 'label' => 'Yüksek'],
                                    'urgent' => ['color' => 'danger', 'label' => 'Acil'],
                                ];
                                $priority = $priorityConfig[$task->priority] ?? ['color' => 'secondary', 'label' => $task->priority];
                            @endphp
                            <span class="badge badge-modern bg-{{ $priority['color'] }}">
                                {{ $priority['label'] }}
                            </span>
                        </td>
                        <td>
                            @php
                                $statusConfig = [
                                    'pending' => ['color' => 'warning', 'label' => 'Bekliyor'],
                                    'in_progress' => ['color' => 'info', 'label' => 'Devam Ediyor'],
                                    'completed' => ['color' => 'success', 'label' => 'Tamamlandı'],
                                    'cancelled' => ['color' => 'secondary', 'label' => 'İptal'],
                                ];
                                $status = $statusConfig[$task->status] ?? ['color' => 'secondary', 'label' => $task->status];
                            @endphp
                            <span class="badge badge-modern bg-{{ $status['color'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td>
                            <span class="text-muted">{{ $task->assignedBy->name }}</span>
                        </td>
                        <td class="text-end">
                            <div class="action-buttons">
                                <a href="{{ route('tasks.show', $task) }}"
                                   class="btn-icon btn-view"
                                   title="Detay">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(!in_array($task->status, ['completed', 'cancelled']))
                                <a href="{{ route('tasks.edit', $task) }}"
                                   class="btn-icon btn-edit"
                                   title="Düzenle">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endif
                                <button type="button"
                                        class="btn-icon btn-delete"
                                        onclick="deleteTask({{ $task->id }})"
                                        title="Sil">
                                    <i class="bi bi-trash"></i>
                                </button>
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
function deleteTask(taskId) {
    if (confirm('⚠️ Bu görevi silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        const form = document.getElementById('deleteForm');
        form.action = '/panel/tasks/' + taskId;
        form.submit();
    }
}

$(document).ready(function() {
    // ✅ DataTable başlat
    const table = initDataTable('#tasksTable', {
        order: [[5, 'asc']], // Vade tarihine göre sırala
        pageLength: 25,
        columnDefs: [
            { orderable: false, searchable: false, targets: 0 }, // Sıra numarası
            { orderable: false, targets: [8] }, // İşlemler
            { targets: 5, type: 'date' } // Vade tarihi
        ],
        createdRow: function(row, data, dataIndex) {
            // Gecikmiş satır sınıfını koru
            const tr = $(row);
            if (tr.attr('data-overdue') === '1') {
                tr.addClass('row-overdue');
            }
        }
    });

    // ✅ Filtreler
    $('#filterStatus, #filterPriority, #filterCategory, #filterDateFrom, #filterDateTo').on('change', function() {
        const status = $('#filterStatus').val();
        const priority = $('#filterPriority').val();
        const category = $('#filterCategory').val();
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

        // Öncelik filtresi
        if (priority) {
            table.column(6).search(priority);
        } else {
            table.column(6).search('');
        }

        // Kategori filtresi
        if (category) {
            table.column(2).search(category);
        } else {
            table.column(2).search('');
        }

        // Tarih aralığı filtresi
        if (dateFrom || dateTo) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const dateStr = data[5]; // Vade tarihi sütunu
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
        $('#taskCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> görev`);
    });

    // İlk yüklemede toplam sayıyı güncelle
    const info = table.page.info();
    $('#taskCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> görev`);
});

function clearFilters() {
    $('#filterStatus, #filterPriority, #filterCategory, #filterDateFrom, #filterDateTo').val('');
    $.fn.dataTable.ext.search = [];
    const table = $('#tasksTable').DataTable();
    table.search('').columns().search('').draw();
}
</script>

<script>

$(document).ready(function() {

    // Mobile Search
    $('#mobileSearch').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        filterMobileCards(searchTerm);
    });

    // Mobile Filter Function
    function filterMobileCards(searchTerm = '') {
        const status = $('#filterStatus').val();
        const priority = $('#filterPriority').val();
        const category = $('#filterCategory').val();

        let visibleCount = 0;

        $('.task-card-mobile').each(function() {
            const $card = $(this);
            const cardText = $card.text().toLowerCase();
            const cardStatus = $card.find('.task-status-badge-mobile').text().trim();
            const cardPriority = $card.find('.task-assigned-user .badge').text().trim();
            const cardCategory = $card.find('.task-card-header .task-category-icon').attr('class');

            let show = true;

            // Search filter
            if (searchTerm && !cardText.includes(searchTerm)) {
                show = false;
            }

            // Status filter
            if (status && cardStatus !== status) {
                show = false;
            }

            // Priority filter
            if (priority && cardPriority !== priority) {
                show = false;
            }

            // Category filter
            if (category) {
                const categoryMatch = cardCategory.includes(category.toLowerCase().replace(' ', '_'));
                if (!categoryMatch) {
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
            $('#taskCount').html(`Gösterilen: <strong>${visibleCount}</strong> / <strong>{{ $tasks->count() }}</strong> görev`);
        }
    }

    // Filter change event for mobile
    $('#filterStatus, #filterPriority, #filterCategory').on('change', function() {
        if (window.innerWidth <= 768) {
            filterMobileCards($('#mobileSearch').val().toLowerCase());
        }
    });
});

// Update clearFilters function
function clearFilters() {
    $('#filterStatus, #filterPriority, #filterCategory, #filterDateFrom, #filterDateTo').val('');
    $('#mobileSearch').val('');

    $.fn.dataTable.ext.search = [];

    const table = $('#tasksTable').DataTable();
    table.search('').columns().search('').draw();

    // Reset mobile cards
    $('.task-card-mobile').show();

    if (window.innerWidth <= 768) {
        $('#taskCount').html(`Toplam: <strong>{{ $tasks->count() }}</strong> görev`);
    }
}
</script>
@endpush
