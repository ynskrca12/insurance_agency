@extends('layouts.app')

@section('title', 'Genel Ayarlar')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">
        <i class="bi bi-gear me-2"></i>Genel Ayarlar
    </h1>
</div>

<!-- Ayar Menüsü -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="list-group">
            <a href="{{ route('settings.index') }}" class="list-group-item list-group-item-action active">
                <i class="bi bi-building me-2"></i>Genel Ayarlar
            </a>
            <a href="{{ route('settings.users') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-people me-2"></i>Kullanıcılar
            </a>
            <a href="{{ route('settings.profile') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-person me-2"></i>Profil Ayarları
            </a>
            <a href="{{ route('settings.security') }}" class="list-group-item list-group-item-action">
                <i class="bi bi-shield-check me-2"></i>Güvenlik
            </a>
        </div>

        <!-- Hızlı İşlemler -->
        <div class="card mt-3 border-0 shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0">
                    <i class="bi bi-lightning me-2"></i>Hızlı İşlemler
                </h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <form method="POST" action="{{ route('settings.clearCache') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-primary w-100">
                            <i class="bi bi-arrow-clockwise me-2"></i>Önbellek Temizle
                        </button>
                    </form>
                    <form method="POST" action="{{ route('settings.backup') }}">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-success w-100">
                            <i class="bi bi-download me-2"></i>Yedek Al
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-9">
        <form method="POST" action="{{ route('settings.updateGeneral') }}">
            @csrf

            <!-- Şirket Bilgileri -->
            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-building me-2"></i>Şirket Bilgileri
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
                                   value="{{ old('company_name', $settings['company_name'] ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label for="company_email" class="form-label">E-posta</label>
                            <input type="email"
                                   class="form-control"
                                   id="company_email"
                                   name="company_email"
                                   value="{{ old('company_email', $settings['company_email'] ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label for="company_phone" class="form-label">Telefon</label>
                            <input type="text"
                                   class="form-control"
                                   id="company_phone"
                                   name="company_phone"
                                   value="{{ old('company_phone', $settings['company_phone'] ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label for="company_tax_number" class="form-label">Vergi Numarası</label>
                            <input type="text"
                                   class="form-control"
                                   id="company_tax_number"
                                   name="company_tax_number"
                                   value="{{ old('company_tax_number', $settings['company_tax_number'] ?? '') }}">
                        </div>

                        <div class="col-md-6">
                            <label for="company_tax_office" class="form-label">Vergi Dairesi</label>
                            <input type="text"
                                   class="form-control"
                                   id="company_tax_office"
                                   name="company_tax_office"
                                   value="{{ old('company_tax_office', $settings['company_tax_office'] ?? '') }}">
                        </div>

                        <div class="col-12">
                            <label for="company_address" class="form-label">Adres</label>
                            <textarea class="form-control"
                                      id="company_address"
                                      name="company_address"
                                      rows="3">{{ old('company_address', $settings['company_address'] ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sistem Ayarları -->
            <div class="card mb-3 border-0 shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-sliders me-2"></i>Sistem Ayarları
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
                                    UTC
                                </option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="date_format" class="form-label">Tarih Formatı</label>
                            <select class="form-select" id="date_format" name="date_format">
                                <option value="d.m.Y" {{ ($settings['date_format'] ?? 'd.m.Y') === 'd.m.Y' ? 'selected' : '' }}>
                                    GG.AA.YYYY
                                </option>
                                <option value="Y-m-d" {{ ($settings['date_format'] ?? '') === 'Y-m-d' ? 'selected' : '' }}>
                                    YYYY-MM-DD
                                </option>
                                <option value="m/d/Y" {{ ($settings['date_format'] ?? '') === 'm/d/Y' ? 'selected' : '' }}>
                                    MM/DD/YYYY
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
                                    Dolar ($)
                                </option>
                                <option value="EUR" {{ ($settings['currency'] ?? '') === 'EUR' ? 'selected' : '' }}>
                                    Euro (€)
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kaydet -->
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Ayarları Kaydet
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
