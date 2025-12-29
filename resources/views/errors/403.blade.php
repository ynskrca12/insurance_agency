<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>403 - Erişim Engellendi | CoreSoft Digital</title>

    <link rel="icon" type="image/png" href="{{ asset('logosysnew.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .error-container {
            text-align: center;
            padding: 40px;
            max-width: 600px;
        }

        .logo {
            width: 180px;
            margin-bottom: 30px;
            filter: drop-shadow(0 10px 30px rgba(0, 0, 0, 0.3));
        }

        .error-card {
            background: white;
            border-radius: 30px;
            padding: 50px 40px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .error-icon {
            font-size: 100px;
            color: #ef4444;
            margin-bottom: 20px;
        }

        .error-code {
            font-size: 100px;
            font-weight: 900;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 20px;
        }

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
        }

        .btn-custom {
            padding: 15px 35px;
            border-radius: 50px;
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(239, 68, 68, 0.5);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <img src="{{ asset('logosysnew.png') }}" alt="Logo" class="logo">
        <div class="error-card">
            <i class="bi bi-shield-x error-icon"></i>
            <div class="error-code">403</div>
            <h1 class="error-title">Erişim Engellendi</h1>
            <p class="error-description">
                Bu sayfaya erişim yetkiniz bulunmamaktadır.
            </p>
            <a href="{{ route('home') }}" class="btn-custom">
                <i class="bi bi-house-door"></i>
                Ana Sayfaya Dön
            </a>
        </div>
    </div>
</body>
</html>
