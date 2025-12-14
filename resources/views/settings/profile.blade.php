@extends('layouts.app')

@section('title', 'Profil Ayarları')

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

    .avatar-container {
        text-align: center;
        margin-bottom: 2rem;
    }

    .avatar-preview {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        margin: 0 auto 1rem;
        border: 4px solid #e9ecef;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
    }

    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .avatar-circle {
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #0d6efd 0%, #0dcaf0 100%);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 3rem;
        font-weight: 700;
    }

    .avatar-upload {
        max-width: 300px;
        margin: 0 auto;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 0.9375rem;
    }

    .form-label .text-danger {
        font-weight: 600;
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

    .form-control.is-invalid {
        border-color: #dc3545;
    }

    .form-control.is-invalid:focus {
        border-color: #dc3545;
        box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
    }

    .form-control[readonly] {
        background: #f8f9fa;
        color: #6c757d;
        cursor: not-allowed;
    }

    .helper-text {
        font-size: 0.8125rem;
        color: #6c757d;
        margin-top: 0.375rem;
        display: block;
    }

    .btn-submit {
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    .password-card .card-header {
        background: #fff8e1;
        border-bottom: 1px solid #ffe082;
    }

    .password-card .card-title {
        color: #f57c00;
    }

    .password-card .card-title i {
        color: #f57c00;
    }

    @media (max-width: 768px) {
        .settings-sidebar {
            position: static;
        }

        .avatar-preview {
            width: 100px;
            height: 100px;
        }

        .avatar-circle {
            font-size: 2.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="h3 mb-0 fw-bold text-dark">
            <i class="bi bi-person me-2"></i>Profil Ayarları
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
                    <a href="{{ route('settings.profile') }}" class="settings-menu-item active">
                        <i class="bi bi-person"></i>
                        <span>Profil Ayarları</span>
                    </a>
                    <a href="{{ route('settings.security') }}" class="settings-menu-item">
                        <i class="bi bi-shield-check"></i>
                        <span>Güvenlik</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9">
            <!-- Profil Bilgileri -->
            <div class="settings-card card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="bi bi-person-circle"></i>
                        <span>Profil Bilgileri</span>
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.updateProfile') }}" enctype="multipart/form-data" id="profileForm">
                        @csrf

                        <!-- Avatar Upload -->
                        <div class="avatar-container">
                            <div class="avatar-preview" id="avatarPreview">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}">
                                @else
                                    <div class="avatar-circle">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="avatar-upload">
                                <input type="file"
                                       class="form-control"
                                       id="avatar"
                                       name="avatar"
                                       accept="image/*"
                                       onchange="previewAvatar(this)">
                                <small class="helper-text">PNG, JPG, GIF - Maksimum 2MB</small>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">
                                    Ad Soyad <span class="text-danger">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       id="name"
                                       name="name"
                                       value="{{ old('name', $user->name) }}"
                                       required
                                       placeholder="Adınızı ve soyadınızı girin">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="email" class="form-label">
                                    E-posta Adresi <span class="text-danger">*</span>
                                </label>
                                <input type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       id="email"
                                       name="email"
                                       value="{{ old('email', $user->email) }}"
                                       required
                                       placeholder="email@example.com">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="phone" class="form-label">Telefon</label>
                                <input type="text"
                                       class="form-control"
                                       id="phone"
                                       name="phone"
                                       value="{{ old('phone', $user->phone) }}"
                                       placeholder="0555 123 45 67">
                                <small class="helper-text">İletişim telefon numaranız</small>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Kullanıcı Rolü</label>
                                <input type="text"
                                       class="form-control"
                                       value="{{ $user->role_label }}"
                                       readonly>
                                <small class="helper-text">Rol değiştirilemez</small>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary btn-submit">
                                <i class="bi bi-check-circle me-2"></i>Profili Güncelle
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Şifre Değiştir -->
            <div class="settings-card password-card card">
                <div class="card-header">
                    <h5 class="card-title">
                        <i class="bi bi-key"></i>
                        <span>Şifre Değiştir</span>
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('settings.updatePassword') }}" id="passwordForm">
                        @csrf

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="current_password" class="form-label">
                                    Mevcut Şifre <span class="text-danger">*</span>
                                </label>
                                <input type="password"
                                       class="form-control @error('current_password') is-invalid @enderror"
                                       id="current_password"
                                       name="current_password"
                                       required
                                       placeholder="Mevcut şifrenizi girin">
                                @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label">
                                    Yeni Şifre <span class="text-danger">*</span>
                                </label>
                                <input type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       id="password"
                                       name="password"
                                       required
                                       placeholder="Yeni şifrenizi girin">
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="helper-text">Minimum 8 karakter uzunluğunda olmalı</small>
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">
                                    Yeni Şifre (Tekrar) <span class="text-danger">*</span>
                                </label>
                                <input type="password"
                                       class="form-control"
                                       id="password_confirmation"
                                       name="password_confirmation"
                                       required
                                       placeholder="Yeni şifrenizi tekrar girin">
                                <small class="helper-text">Şifrelerin eşleşmesi gerekiyor</small>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-warning btn-submit">
                                <i class="bi bi-shield-check me-2"></i>Şifreyi Değiştir
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            const preview = document.getElementById('avatarPreview');
            preview.innerHTML = `<img src="${e.target.result}" alt="Avatar Preview">`;
        }

        reader.readAsDataURL(input.files[0]);
    }
}

$(document).ready(function() {
    // Profile form submit animasyonu
    $('#profileForm').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>Güncelleniyor...');
    });

    // Password form submit animasyonu
    $('#passwordForm').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>Değiştiriliyor...');
    });

    // Input focus'ta invalid class'ı kaldır
    $('.form-control').on('focus', function() {
        $(this).removeClass('is-invalid');
    });

    // Password match validation
    $('#password_confirmation').on('input', function() {
        const password = $('#password').val();
        const confirmation = $(this).val();

        if (password && confirmation) {
            if (password !== confirmation) {
                $(this).addClass('is-invalid');
            } else {
                $(this).removeClass('is-invalid');
            }
        }
    });
});
</script>
@endpush
