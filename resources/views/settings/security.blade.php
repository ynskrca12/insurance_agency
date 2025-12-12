@extends('layouts.app')

@section('title', 'Güvenlik Ayarları')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="bi bi-shield-check me-2"></i>Güvenlik Ayarları
    </h1>
</div>

<!-- Ayar Menüsü -->
<div class="row g-3">
    <div class="col-md-3">
        <div class="list-group">
            <a href="{{ route('settings.index') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-building me-2"></i>Genel Ayarlar
            </a>
            <a href="{{ route('settings.users') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-people me-2"></i>Kullanıcılar
            </a>
            <a href="{{ route('settings.profile') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-person me-2"></i>Profil Ayarları
            </a>
            <a href="{{ route('settings.security') }}" class="list-group-item list-group-item-action active">
                <i class="bi bi-shield-check me-2"></i>Güvenlik
            </a>
        </div>
    </div>

    <div class="col-md-9">
        <form method="POST" action="{{ route('settings.updateSecurity') }}">
            @csrf

            <!-- Oturum Ayarları -->
            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-clock-history me-2"></i>Oturum Ayarları
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="session_timeout" class="form-label">Oturum Zaman Aşımı (Dakika)</label>
                        <input type="number"
                               class="form-control"
                               id="session_timeout"
                               name="session_timeout"
                               value="{{ old('session_timeout', $settings['session_timeout'] ?? 120) }}"
                               min="5"
                               max="1440">
                        <small class="text-muted">Kullanıcı bu süre boyunca aktif değilse otomatik çıkış yapılır</small>
                    </div>

                    <div class="mb-3">
                        <label for="max_login_attempts" class="form-label">Maksimum Giriş Denemesi</label>
                        <input type="number"
                               class="form-control"
                               id="max_login_attempts"
                               name="max_login_attempts"
                               value="{{ old('max_login_attempts', $settings['max_login_attempts'] ?? 5) }}"
                               min="3"
                               max="10">
                        <small class="text-muted">Bu sayıda başarısız denemeden sonra hesap geçici olarak kilitlenir</small>
                    </div>
                </div>
            </div>

            <!-- Şifre Politikaları -->
            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="bi bi-key me-2"></i>Şifre Politikaları
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="password_expiry_days" class="form-label">Şifre Geçerlilik Süresi (Gün)</label>
                        <input type="number"
                               class="form-control"
                               id="password_expiry_days"
                               name="password_expiry_days"
                               value="{{ old('password_expiry_days', $settings['password_expiry_days'] ?? 90) }}"
                               min="0"
                               max="365">
                        <small class="text-muted">0 = Süresiz, Kullanıcılar bu süre sonunda şifre değiştirmeye zorlanır</small>
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
                </div>
            </div>

            <!-- İki Faktörlü Kimlik Doğrulama -->
            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-phone me-2"></i>İki Faktörlü Kimlik Doğrulama
                    </h5>
                </div>
                <div class="card-body">
                    <div class="form-check">
                        <input class="form-check-input"
                               type="checkbox"
                               id="two_factor_enabled"
                               name="two_factor_enabled"
                               value="1"
                               {{ ($settings['two_factor_enabled'] ?? false) ? 'checked' : '' }}>
                        <label class="form-check-label" for="two_factor_enabled">
                            İki faktörlü kimlik doğrulamayı etkinleştir
                        </label>
                    </div>
                    <small class="text-muted">Yakında aktif edilecek</small>
                </div>
            </div>

            <!-- Kaydet -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Güvenlik Ayarlarını Kaydet
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
