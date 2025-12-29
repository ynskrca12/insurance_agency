<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>500 - Sunucu Hatası | CoreSoft Digital Sigorta Yönetim Sistemi</title>
    <meta name="description" content="Bir sunucu hatası oluştu. Lütfen daha sonra tekrar deneyin.">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logosysnew.png') }}">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated Background */
        .animated-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .gear {
            position: absolute;
            opacity: 0.1;
        }

        .gear:nth-child(1) {
            top: 20%;
            left: 15%;
            width: 100px;
            height: 100px;
            animation: rotate 10s linear infinite;
        }

        .gear:nth-child(2) {
            top: 60%;
            left: 70%;
            width: 150px;
            height: 150px;
            animation: rotate-reverse 15s linear infinite;
        }

        .gear:nth-child(3) {
            top: 40%;
            left: 80%;
            width: 80px;
            height: 80px;
            animation: rotate 12s linear infinite;
        }

        @keyframes rotate {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes rotate-reverse {
            from {
                transform: rotate(360deg);
            }
            to {
                transform: rotate(0deg);
            }
        }

        /* Main Container */
        .error-container {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 40px;
            max-width: 600px;
            width: 90%;
        }

        /* Logo */
        .logo-container {
            margin-bottom: 30px;
            animation: fadeInDown 1s ease-out;
        }

        .logo {
            width: 180px;
            height: auto;
            filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.3));
        }

        /* Error Card */
        .error-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 50px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: fadeInUp 1s ease-out;
        }

        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* 500 Icon */
        .error-icon {
            font-size: 100px;
            color: #f5576c;
            margin-bottom: 20px;
            animation: shake 2s infinite;
        }

        @keyframes shake {
            0%, 100% {
                transform: rotate(0deg);
            }
            10%, 30%, 50%, 70%, 90% {
                transform: rotate(-5deg);
            }
            20%, 40%, 60%, 80% {
                transform: rotate(5deg);
            }
        }

        /* 500 Number */
        .error-code {
            font-size: 100px;
            font-weight: 900;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            line-height: 1;
            margin-bottom: 20px;
        }

        /* Title & Description */
        .error-title {
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 15px;
        }

        .error-description {
            font-size: 16px;
            color: #64748b;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        /* Status Box */
        .status-box {
            background: #fef2f2;
            border-left: 4px solid #ef4444;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: left;
        }

        .status-box h3 {
            font-size: 14px;
            font-weight: 700;
            color: #991b1b;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .status-box ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .status-box li {
            font-size: 14px;
            color: #7f1d1d;
            padding: 5px 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .status-box li i {
            color: #ef4444;
        }

        /* Buttons */
        .btn-container {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-custom {
            padding: 15px 35px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 15px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            box-shadow: 0 10px 30px rgba(245, 87, 108, 0.4);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(245, 87, 108, 0.5);
        }

        .btn-secondary-custom {
            background: white;
            color: #f5576c;
            border: 2px solid #f5576c;
        }

        .btn-secondary-custom:hover {
            background: #f5576c;
            color: white;
            transform: translateY(-2px);
        }

        /* Loading Spinner */
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .error-code {
                font-size: 70px;
            }

            .error-icon {
                font-size: 70px;
            }

            .error-title {
                font-size: 24px;
            }

            .error-card {
                padding: 40px 25px;
            }

            .logo {
                width: 140px;
            }

            .btn-container {
                flex-direction: column;
            }

            .btn-custom {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background -->
    <div class="animated-bg">
        <i class="bi bi-gear-fill gear" style="font-size: 100px; color: white;"></i>
        <i class="bi bi-gear-fill gear" style="font-size: 150px; color: white;"></i>
        <i class="bi bi-gear-fill gear" style="font-size: 80px; color: white;"></i>
    </div>

    <!-- Error Container -->
    <div class="error-container">
        <!-- Logo -->
        <div class="logo-container">
            <img src="{{ asset('logosysnew.png') }}" alt="CoreSoft Digital Logo" class="logo">
        </div>

        <!-- Error Card -->
        <div class="error-card">
            <i class="bi bi-exclamation-octagon-fill error-icon"></i>
            <div class="error-code">500</div>
            <h1 class="error-title">Sunucu Hatası</h1>
            <p class="error-description">
                Üzgünüz, sunucuda bir hata oluştu. Teknik ekibimiz bu sorunu çözmek için çalışıyor.
                <br>Lütfen birkaç dakika sonra tekrar deneyin.
            </p>

            <!-- Status Box -->
            <div class="status-box">
                <h3><i class="bi bi-tools"></i> Ne Yapabilirsiniz?</h3>
                <ul>
                    <li>
                        <i class="bi bi-arrow-clockwise"></i>
                        Sayfayı yenileyin
                    </li>
                    <li>
                        <i class="bi bi-clock-history"></i>
                        Birkaç dakika bekleyip tekrar deneyin
                    </li>
                    <li>
                        <i class="bi bi-house-door"></i>
                        Ana sayfaya dönün
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="btn-container">
                <button onclick="location.reload()" class="btn-custom btn-primary-custom">
                    <span class="loading-spinner"></span>
                    Sayfayı Yenile
                </button>
                <a href="{{ route('home') }}" class="btn-custom btn-secondary-custom">
                    <i class="bi bi-house-door"></i>
                    Ana Sayfaya Dön
                </a>
            </div>
        </div>
    </div>
</body>
</html>
