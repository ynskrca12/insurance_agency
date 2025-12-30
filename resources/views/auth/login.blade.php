<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap - Sigorta Yönetim Sistemi</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('logosysnew.png') }}">


    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">
</head>
<body>

<div class="login-page">
    <div class="login-container">
        <!-- Back Link -->
        <a href="{{ route('home') }}" class="login-back-link">
            <i class="bi bi-arrow-left"></i>
            Anasayfaya Dön
        </a>

        <!-- Login Card -->
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <img src="{{asset('logosysnew.png')}}" alt="">
                </div>
                <h1>Giriş Yap</h1>
                <p>14 günlük demo hesabınıza giriş yapın</p>
            </div>

            @if(session('success'))
            <div class="login-alert success">
                <i class="bi bi-check-circle-fill"></i>
                <span>{{ session('success') }}</span>
            </div>
            @endif

            @if(session('error'))
            <div class="login-alert error">
                <i class="bi bi-x-circle-fill"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            @if ($errors->any())
            <div class="login-alert error">
                <i class="bi bi-x-circle-fill"></i>
                <span>{{ $errors->first() }}</span>
            </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}" class="login-form">
                @csrf

                <div class="login-form-group">
                    <label for="email" class="login-form-label">E-posta</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="login-form-input @error('email') is-invalid @enderror"
                        placeholder="ornek@email.com"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                    @error('email')
                        <span class="login-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="login-form-group">
                    <label for="password" class="login-form-label">Şifre</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="login-form-input @error('password') is-invalid @enderror"
                        placeholder="••••••••"
                        required
                    >
                    @error('password')
                        <span class="login-form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="login-remember">
                    <input
                        type="checkbox"
                        id="remember"
                        name="remember"
                        {{ old('remember') ? 'checked' : '' }}
                    >
                    <label for="remember">Beni Hatırla</label>
                </div>

                <button type="submit" class="login-submit-button">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Giriş Yap
                </button>
            </form>

            <div class="login-footer">
                <p>Henüz hesabınız yok mu?</p>
                <a href="{{ route('demo.form') }}">
                    <i class="bi bi-plus-circle"></i>
                    Ücretsiz Demo Hesabı Oluştur
                </a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
