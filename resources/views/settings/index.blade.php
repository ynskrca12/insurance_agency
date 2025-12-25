@extends('layouts.app')

@section('title', 'Genel Ayarlar')

@push('styles')
<style>
    .page-header {
        padding: 12px 0;
        margin-bottom: 1rem;
    }

    .settings-sidebar {
        position: sticky;
        top: 2rem;
    }

    .settings-menu {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        overflow: hidden;
        background: #ffffff;
    }

    .settings-menu-item {
        padding: 1rem 1.25rem;
        border-bottom: 1px solid #f0f0f0;
        color: #495057;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .settings-menu-item:last-child {
        border-bottom: none;
    }

    .settings-menu-item:hover {
        background: #f8f9fa;
        color: #212529;
    }

    .settings-menu-item.active {
        background: #0d6efd;
        color: #ffffff;
    }

    .settings-menu-item.active i {
        color: #ffffff;
    }

    .settings-menu-item i {
        font-size: 1.125rem;
        color: #6c757d;
    }

    .quick-actions-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
        margin-top: 1.5rem;
    }

    .quick-actions-card .card-header {
        background: #fff8e1;
        border-bottom: 1px solid #ffe082;
        padding: 1rem 1.25rem;
    }

    .quick-actions-title {
        color: #f57c00;
        font-size: 1rem;
        font-weight: 600;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .quick-actions-card .card-body {
        padding: 1.25rem;
    }

    .quick-action-btn {
        border-radius: 8px;
        padding: 0.75rem 1rem;
        font-weight: 500;
        border: 1px solid #dcdcdc;
        background: #ffffff;
        color: #495057;
        transition: all 0.3s ease;
        width: 100%;
        text-align: left;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .quick-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .quick-action-btn.btn-cache {
        border-color: #0d6efd;
        color: #0d6efd;
    }

    .quick-action-btn.btn-cache:hover {
        background: #0d6efd;
        color: #ffffff;
    }

    .quick-action-btn.btn-backup {
        border-color: #28a745;
        color: #28a745;
    }

    .quick-action-btn.btn-backup:hover {
        background: #28a745;
        color: #ffffff;
    }

    .settings-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .settings-card .card-header {
        background: #fafafa;
        border-bottom: 1px solid #e8e8e8;
        padding: 1.25rem 1.5rem;
    }

    .card-title {
        color: #212529;
        font-size: 1.125rem;
        font-weight: 600;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .card-title i {
        color: #6c757d;
        font-size: 1.25rem;
    }

    .settings-card .card-body {
        padding: 1.5rem;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 0.9375rem;
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

    textarea.form-control {
        resize: vertical;
    }

    .save-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
    }

    .save-card .card-body {
        padding: 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-save {
        border-radius: 8px;
        padding: 0.875rem 2rem;
        font-weight: 600;
        font-size: 1rem;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3);
    }

    .save-info {
        color: #6c757d;
        font-size: 0.8125rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    @media (max-width: 768px) {
        .settings-sidebar {
            position: static;
        }

        .save-card .card-body {
            flex-direction: column;
            gap: 1rem;
            align-items: stretch;
        }

        .btn-save {
            width: 100%;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="h4 mb-0 fw-bold text-dark">
            <i class="bi bi-gear me-2"></i>Genel Ayarlar
        </h1>
    </div>

    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="settings-sidebar">
                <!-- Settings Menu -->
                <div class="settings-menu">
                    <a href="{{ route('settings.index') }}" class="settings-menu-item active">
                        <i class="bi bi-building"></i>
                        <span>Genel Ayarlar</span>
                    </a>
                    <a href="{{ route('settings.users') }}" class="settings-menu-item">
                        <i class="bi bi-people"></i>
                        <span>Kullanıcılar</span>
                    </a>
                    <a href="{{ route('settings.profile') }}" class="settings-menu-item">
                        <i class="bi bi-person"></i>
                        <span>Profil Ayarları</span>
                    </a>
                    <a href="{{ route('settings.security') }}" class="settings-menu-item">
                        <i class="bi bi-shield-check"></i>
                        <span>Güvenlik</span>
                    </a>
                </div>

                <!-- Quick Actions -->
                <div class="quick-actions-card card">
                    <div class="card-header">
                        <h6 class="quick-actions-title">
                            <i class="bi bi-lightning"></i>
                            <span>Hızlı İşlemler</span>
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <form method="POST" action="{{ route('settings.clearCache') }}">
                                @csrf
                                <button type="submit" class="quick-action-btn btn-cache">
                                    <i class="bi bi-arrow-clockwise"></i>
                                    <span>Önbellek Temizle</span>
                                </button>
                            </form>
                            <form method="POST" action="{{ route('settings.backup') }}">
                                @csrf
                                <button type="submit" class="quick-action-btn btn-backup">
                                    <i class="bi bi-download"></i>
                                    <span>Yedek Al</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <form method="POST" action="{{ route('settings.updateGeneral') }}" id="settingsForm">
                @csrf

                <!-- Şirket Bilgileri -->
                <div class="settings-card card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bi bi-building"></i>
                            <span>Şirket Bilgileri</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="company_name" class="form-label">Şirket Adı</label>
                                <input type="text"
                                       class="form-control"
                                       id="company_name"
                                       name="company_name"
                                       value="{{ old('company_name', $settings['company_name'] ?? '') }}"
                                       placeholder="Şirket adınızı girin">
                            </div>

                            <div class="col-md-6">
                                <label for="company_email" class="form-label">E-posta Adresi</label>
                                <input type="email"
                                       class="form-control"
                                       id="company_email"
                                       name="company_email"
                                       value="{{ old('company_email', $settings['company_email'] ?? '') }}"
                                       placeholder="info@example.com">
                            </div>

                            <div class="col-md-6">
                                <label for="company_phone" class="form-label">Telefon</label>
                                <input type="text"
                                       class="form-control"
                                       id="company_phone"
                                       name="company_phone"
                                       value="{{ old('company_phone', $settings['company_phone'] ?? '') }}"
                                       placeholder="0212 123 45 67">
                            </div>

                            <div class="col-md-6">
                                <label for="company_tax_number" class="form-label">Vergi Numarası</label>
                                <input type="text"
                                       class="form-control"
                                       id="company_tax_number"
                                       name="company_tax_number"
                                       value="{{ old('company_tax_number', $settings['company_tax_number'] ?? '') }}"
                                       placeholder="1234567890">
                            </div>

                            <div class="col-md-6">
                                <label for="company_tax_office" class="form-label">Vergi Dairesi</label>
                                <input type="text"
                                       class="form-control"
                                       id="company_tax_office"
                                       name="company_tax_office"
                                       value="{{ old('company_tax_office', $settings['company_tax_office'] ?? '') }}"
                                       placeholder="Kadıköy Vergi Dairesi">
                            </div>

                            <div class="col-12">
                                <label for="company_address" class="form-label">Şirket Adresi</label>
                                <textarea class="form-control"
                                          id="company_address"
                                          name="company_address"
                                          rows="3"
                                          placeholder="Tam adresinizi girin">{{ old('company_address', $settings['company_address'] ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sistem Ayarları -->
                <div class="settings-card card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bi bi-sliders"></i>
                            <span>Sistem Ayarları</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label for="timezone" class="form-label">Saat Dilimi</label>
                                <select class="form-select" id="timezone" name="timezone">
                                    <option value="Europe/Istanbul" {{ ($settings['timezone'] ?? 'Europe/Istanbul') === 'Europe/Istanbul' ? 'selected' : '' }}>
                                        İstanbul (UTC+3)
                                    </option>
                                    <option value="UTC" {{ ($settings['timezone'] ?? '') === 'UTC' ? 'selected' : '' }}>
                                        UTC (Evrensel)
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="date_format" class="form-label">Tarih Formatı</label>
                                <select class="form-select" id="date_format" name="date_format">
                                    <option value="d.m.Y" {{ ($settings['date_format'] ?? 'd.m.Y') === 'd.m.Y' ? 'selected' : '' }}>
                                        GG.AA.YYYY (31.12.2024)
                                    </option>
                                    <option value="Y-m-d" {{ ($settings['date_format'] ?? '') === 'Y-m-d' ? 'selected' : '' }}>
                                        YYYY-MM-DD (2024-12-31)
                                    </option>
                                    <option value="m/d/Y" {{ ($settings['date_format'] ?? '') === 'm/d/Y' ? 'selected' : '' }}>
                                        MM/DD/YYYY (12/31/2024)
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="currency" class="form-label">Para Birimi</label>
                                <select class="form-select" id="currency" name="currency">
                                    <option value="TRY" {{ ($settings['currency'] ?? 'TRY') === 'TRY' ? 'selected' : '' }}>
                                        Türk Lirası (₺)
                                    </option>
                                    <option value="USD" {{ ($settings['currency'] ?? '') === 'USD' ? 'selected' : '' }}>
                                        Amerikan Doları ($)
                                    </option>
                                    <option value="EUR" {{ ($settings['currency'] ?? '') === 'EUR' ? 'selected' : '' }}>
                                        Euro (€)
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Card -->
                <div class="save-card card">
                    <div class="card-body">
                        <div class="save-info">
                            <i class="bi bi-info-circle"></i>
                            <span>Değişiklikler kaydedilmeden önce kaybolabilir</span>
                        </div>
                        <button type="submit" class="btn btn-primary btn-save">
                            <i class="bi bi-check-circle me-2"></i>Ayarları Kaydet
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Form submit animasyonu
    $('#settingsForm').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>Kaydediliyor...');
    });

    // Input focus'ta border rengi değişimi
    $('.form-control, .form-select').on('focus', function() {
        $(this).removeClass('is-invalid');
    });

    // Unsaved changes uyarısı
    let formChanged = false;

    $('#settingsForm input, #settingsForm textarea, #settingsForm select').on('change', function() {
        formChanged = true;
    });

    $(window).on('beforeunload', function() {
        if (formChanged) {
            return 'Kaydedilmemiş değişiklikler var. Sayfadan çıkmak istediğinizden emin misiniz?';
        }
    });

    $('#settingsForm').on('submit', function() {
        formChanged = false;
    });
});
</script>
@endpush
