@extends('layouts.guest')

@section('title', 'Kayıt Ol')

@section('content')
<div class="auth-card">
    <!-- Header -->
    <div class="auth-header">
        <i class="bi bi-person-plus" style="font-size: 3rem;"></i>
        <h3 class="mt-3 mb-0">Hesap Oluştur</h3>
        <p class="mb-0">Yeni bir hesap oluşturun</p>
    </div>

    <!-- Body -->
    <div class="auth-body">
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <strong>Hata!</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}" id="registerForm">
            @csrf

            <!-- Name -->
            <div class="form-floating mb-3">
                <input type="text"
                       class="form-control @error('name') is-invalid @enderror"
                       id="name"
                       name="name"
                       placeholder="Ad Soyad"
                       value="{{ old('name') }}"
                       required
                       autofocus>
                <label for="name">
                    <i class="bi bi-person me-2"></i>Ad Soyad
                </label>
                @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email -->
            <div class="form-floating mb-3">
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       id="email"
                       name="email"
                       placeholder="E-posta"
                       value="{{ old('email') }}"
                       required>
                <label for="email">
                    <i class="bi bi-envelope me-2"></i>E-posta Adresi
                </label>
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone -->
            <div class="form-floating mb-3">
                <input type="text"
                       class="form-control @error('phone') is-invalid @enderror"
                       id="phone"
                       name="phone"
                       placeholder="Telefon"
                       value="{{ old('phone') }}">
                <label for="phone">
                    <i class="bi bi-telephone me-2"></i>Telefon (Opsiyonel)
                </label>
                @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-floating mb-3">
                <input type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       id="password"
                       name="password"
                       placeholder="Şifre"
                       required>
                <label for="password">
                    <i class="bi bi-lock me-2"></i>Şifre
                </label>
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="text-muted">En az 6 karakter</small>
            </div>

            <!-- Password Confirmation -->
            <div class="form-floating mb-3">
                <input type="password"
                       class="form-control"
                       id="password_confirmation"
                       name="password_confirmation"
                       placeholder="Şifre Tekrar"
                       required>
                <label for="password_confirmation">
                    <i class="bi bi-lock-fill me-2"></i>Şifre Tekrar
                </label>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-person-plus me-2"></i>
                    Kayıt Ol
                </button>
            </div>
        </form>

        <hr class="my-4">

        <div class="text-center">
            <p class="text-muted mb-0">
                Zaten hesabınız var mı?
                <a href="{{ route('login') }}" class="text-decoration-none">
                    Giriş Yap
                </a>
            </p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Form validasyonu
    $('#registerForm').on('submit', function(e) {
        let password = $('#password').val();
        let passwordConfirm = $('#password_confirmation').val();

        if (password !== passwordConfirm) {
            e.preventDefault();
            alert('Şifreler eşleşmiyor!');
            return false;
        }

        if (password.length < 6) {
            e.preventDefault();
            alert('Şifre en az 6 karakter olmalıdır!');
            return false;
        }
    });

    // Telefon formatı
    $('#phone').on('input', function() {
        let value = $(this).val().replace(/\D/g, '');
        if (value.length > 10) {
            value = value.slice(0, 10);
        }
        $(this).val(value);
    });
});
</script>
@endpush
