<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Girişi - Sigorta Yönetim Sistemi</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Admin Auth CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/auth.css') }}">
</head>
<body>

<div class="admin-login-page">
    <div class="admin-login-card">
        <!-- Header -->
        <div class="admin-login-header">
            <div class="admin-logo">
                <i class="bi bi-shield-lock"></i>
            </div>
            <h1>Admin Panel</h1>
            <p>Yönetim paneline giriş yapın</p>
        </div>

        <!-- Success Alert -->
        @if(session('success'))
        <div class="admin-alert success">
            <i class="bi bi-check-circle-fill"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif

        <!-- Error Alert -->
        @if(session('error'))
        <div class="admin-alert error">
            <i class="bi bi-x-circle-fill"></i>
            <span>{{ session('error') }}</span>
        </div>
        @endif

        <!-- Validation Errors -->
        @if ($errors->any())
        <div class="admin-alert error">
            <i class="bi bi-x-circle-fill"></i>
            <span>{{ $errors->first() }}</span>
        </div>
        @endif

        <!-- Login Form -->
        <form method="POST" action="{{ route('admin.login.post') }}" class="admin-login-form">
            @csrf

            <!-- Email -->
            <div class="admin-form-group">
                <label for="email" class="admin-form-label">E-posta Adresi</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    class="admin-form-input @error('email') is-invalid @enderror"
                    placeholder="admin@example.com"
                    value="{{ old('email') }}"
                    required
                    autofocus
                >
                @error('email')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="admin-form-group">
                <label for="password" class="admin-form-label">Şifre</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    class="admin-form-input @error('password') is-invalid @enderror"
                    placeholder="••••••••"
                    required
                >
                @error('password')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="admin-remember">
                <input
                    type="checkbox"
                    id="remember"
                    name="remember"
                    {{ old('remember') ? 'checked' : '' }}
                >
                <label for="remember">Beni Hatırla</label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="admin-submit-btn">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Giriş Yap</span>
            </button>
        </form>

        <!-- Footer -->
        <div class="admin-login-footer">
            <p>Kullanıcı girişi mi arıyorsunuz?</p>
            <a href="{{ route('login') }}">
                <i class="bi bi-arrow-left"></i>
                Kullanıcı Girişine Dön
            </a>
        </div>
    </div>
</div>

</body>
</html>
