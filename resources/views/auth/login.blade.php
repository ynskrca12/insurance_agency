@extends('layouts.guest')

@section('title', 'Giriş Yap')

@section('content')
<div class="auth-card">
    <!-- Header -->
    <div class="auth-header">
        <i class="bi bi-shield-check" style="font-size: 3rem;"></i>
        <h4 class="mt-2 mb-4">Sigorta Yönetim Paneli</h4>
    </div>

    <!-- Body -->
    <div class="auth-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            {{ $errors->first() }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" id="loginForm">
            @csrf

            <!-- Email -->
            <div class="form-floating mb-3">
                <input type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       id="email"
                       name="email"
                       placeholder="E-posta"
                       value="{{ old('email') }}"
                       required
                       autofocus>
                <label for="email">
                    <i class="bi bi-envelope me-2"></i>E-posta Adresi
                </label>
                @error('email')
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
            </div>

            <!-- Remember Me -->
            <div class="form-check mb-3">
                <input class="form-check-input"
                       type="checkbox"
                       name="remember"
                       id="remember">
                <label class="form-check-label" for="remember">
                    Beni Hatırla
                </label>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Giriş Yap
                </button>
            </div>
        </form>

        <hr class="my-4">

        <div class="text-center">
            <p class="text-muted mb-0">
                Hesabınız yok mu?
                <a href="{{ route('register') }}" class="text-decoration-none">
                    Kayıt Ol
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
    $('#loginForm').on('submit', function(e) {
        let email = $('#email').val();
        let password = $('#password').val();

        if (!email || !password) {
            e.preventDefault();
            alert('Lütfen tüm alanları doldurun.');
            return false;
        }
    });

    // Enter tuşu ile form gönderimi
    $('#password').on('keypress', function(e) {
        if (e.which === 13) {
            $('#loginForm').submit();
        }
    });
});
</script>
@endpush
