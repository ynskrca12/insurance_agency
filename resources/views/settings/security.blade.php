@extends('layouts.app')

@section('title', 'Güvenlik Ayarları')

@push('styles')
<style>
    .page-header {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
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

    .form-control {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 0.625rem 0.875rem;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #999;
        box-shadow: 0 0 0 3px rgba(153, 153, 153, 0.1);
    }

    .helper-text {
        font-size: 0.8125rem;
        color: #6c757d;
        margin-top: 0.375rem;
        display: block;
    }

    .form-check {
        padding: 1rem;
        background: #f8f9fa;
        border-radius: 8px;
        margin-bottom: 1rem;
    }

    .form-check:last-child {
        margin-bottom: 0;
    }

    .form-check-input {
        width: 3rem;
        height: 1.5rem;
        cursor: pointer;
        border: 2px solid #dcdcdc;
    }

    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }

    .form-check-label {
        cursor: pointer;
        font-weight: 500;
        color: #495057;
        padding-left: 0.5rem;
        font-size: 1rem;
    }

    .security-warning {
        background: #fff3cd;
        border: 1px solid #ffc107;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 1rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .security-warning i {
        color: #f57c00;
        font-size: 1.5rem;
    }

    .security-warning-text {
        color: #856404;
        font-size: 0.875rem;
    }

    .info-box {
        background: #e8f4fd;
        border: 1px solid #b3d9ff;
        border-radius: 8px;
        padding: 1rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: start;
        gap: 0.75rem;
    }

    .info-box i {
        color: #0066cc;
        font-size: 1.25rem;
        margin-top: 0.125rem;
    }

    .info-box-text {
        color: #0066cc;
        font-size: 0.8125rem;
        line-height: 1.5;
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
        <h1 class="h3 mb-0 fw-bold text-dark">
            <i class="bi bi-shield-check me-2"></i>Güvenlik Ayarları
        </h1>
    </div>

    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-lg-3">
            <div class="settings-sidebar">
                <div class="settings-menu">
                    <a href="{{ route('settings.index') }}" class="settings-menu-item">
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
                    <a href="{{ route('settings.security') }}" class="settings-menu-item active">
                        <i class="bi bi-shield-check"></i>
                        <span>Güvenlik</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <form method="POST" action="{{ route('settings.updateSecurity') }}" id="securityForm">
                @csrf

                <!-- Oturum Ayarları -->
                <div class="settings-card card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bi bi-clock-history"></i>
                            <span>Oturum Ayarları</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="session_timeout" class="form-label">Oturum Zaman Aşımı (Dakika)</label>
                            <input type="number"
                                   class="form-control"
                                   id="session_timeout"
                                   name="session_timeout"
                                   value="{{ old('session_timeout', $settings['session_timeout'] ?? 120) }}"
                                   min="5"
                                   max="1440">
                            <small class="helper-text">Kullanıcı bu süre boyunca aktif değilse otomatik çıkış yapılır</small>
                        </div>

                        <div>
                            <label for="max_login_attempts" class="form-label">Maksimum Giriş Denemesi</label>
                            <input type="number"
                                   class="form-control"
                                   id="max_login_attempts"
                                   name="max_login_attempts"
                                   value="{{ old('max_login_attempts', $settings['max_login_attempts'] ?? 5) }}"
                                   min="3"
                                   max="10">
                            <small class="helper-text">Bu sayıda başarısız denemeden sonra hesap geçici olarak kilitlenir</small>
                        </div>

                        <div class="security-warning">
                            <i class="bi bi-exclamation-triangle"></i>
                            <div class="security-warning-text">
                                Bu ayarları değiştirmek tüm kullanıcıları etkileyecektir. Değişikliklerden önce kullanıcıları bilgilendirin.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Şifre Politikaları -->
                <div class="settings-card card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bi bi-key"></i>
                            <span>Şifre Politikaları</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="password_expiry_days" class="form-label">Şifre Geçerlilik Süresi (Gün)</label>
                            <input type="number"
                                   class="form-control"
                                   id="password_expiry_days"
                                   name="password_expiry_days"
                                   value="{{ old('password_expiry_days', $settings['password_expiry_days'] ?? 90) }}"
                                   min="0"
                                   max="365">
                            <small class="helper-text">0 = Süresiz. Kullanıcılar bu süre sonunda şifre değiştirmeye zorlanır</small>
                        </div>

                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="force_password_change"
                                   name="force_password_change"
                                   value="1"
                                   {{ ($settings['force_password_change'] ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="force_password_change">
                                İlk girişte şifre değiştirmeye zorla
                            </label>
                        </div>

                        <div class="info-box">
                            <i class="bi bi-info-circle"></i>
                            <div class="info-box-text">
                                Güçlü şifre politikaları, hesap güvenliğini artırır. Kullanıcılarınızın düzenli olarak şifre değiştirmesini sağlayarak güvenliği maksimize edin.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- İki Faktörlü Kimlik Doğrulama -->
                <div class="settings-card card">
                    <div class="card-header">
                        <h5 class="card-title">
                            <i class="bi bi-phone"></i>
                            <span>İki Faktörlü Kimlik Doğrulama</span>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   id="two_factor_enabled"
                                   name="two_factor_enabled"
                                   value="1"
                                   disabled
                                   {{ ($settings['two_factor_enabled'] ?? false) ? 'checked' : '' }}>
                            <label class="form-check-label" for="two_factor_enabled">
                                İki faktörlü kimlik doğrulamayı etkinleştir
                            </label>
                        </div>

                        <div class="info-box mt-3">
                            <i class="bi bi-clock-history"></i>
                            <div class="info-box-text">
                                <strong>Yakında Aktif Edilecek:</strong> İki faktörlü kimlik doğrulama özelliği şu anda geliştirme aşamasında. Bu özellik aktif edildiğinde, kullanıcılarınız giriş yaparken ek güvenlik katmanından faydalanabilecekler.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Card -->
                <div class="save-card card">
                    <div class="card-body">
                        <div class="save-info">
                            <i class="bi bi-info-circle"></i>
                            <span>Güvenlik ayarları sistemdeki tüm kullanıcıları etkiler</span>
                        </div>
                        <button type="submit" class="btn btn-primary btn-save">
                            <i class="bi bi-shield-check me-2"></i>Güvenlik Ayarlarını Kaydet
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
    $('#securityForm').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>Kaydediliyor...');
    });

    // Input değişikliklerini izle
    let formChanged = false;

    $('#securityForm input').on('change', function() {
        formChanged = true;
    });

    // Sayfa ayrılırken uyar
    $(window).on('beforeunload', function() {
        if (formChanged) {
            return 'Kaydedilmemiş güvenlik ayarları var. Sayfadan çıkmak istediğinizden emin misiniz?';
        }
    });

    $('#securityForm').on('submit', function() {
        formChanged = false;
    });

    // Session timeout validation
    $('#session_timeout').on('input', function() {
        const value = parseInt($(this).val());
        if (value < 5) {
            $(this).val(5);
        } else if (value > 1440) {
            $(this).val(1440);
        }
    });

    // Max login attempts validation
    $('#max_login_attempts').on('input', function() {
        const value = parseInt($(this).val());
        if (value < 3) {
            $(this).val(3);
        } else if (value > 10) {
            $(this).val(10);
        }
    });

    // Password expiry validation
    $('#password_expiry_days').on('input', function() {
        const value = parseInt($(this).val());
        if (value < 0) {
            $(this).val(0);
        } else if (value > 365) {
            $(this).val(365);
        }
    });
});
</script>
@endpush
