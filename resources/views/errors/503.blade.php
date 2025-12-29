<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>503 - Bakım Modu | CoreSoft Digital</title>

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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            color: #f59e0b;
            margin-bottom: 20px;
            animation: rotate 3s linear infinite;
        }

        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
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
    </style>
</head>
<body>
    <div class="error-container">
        <img src="{{ asset('logosysnew.png') }}" alt="Logo" class="logo">
        <div class="error-card">
            <i class="bi bi-tools error-icon"></i>
            <h1 class="error-title">Bakım Çalışması</h1>
            <p class="error-description">
                Sistemimiz şu anda bakım modunda. Lütfen daha sonra tekrar deneyin.
            </p>
        </div>
    </div>
</body>
</html>
