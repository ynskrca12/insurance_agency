<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Giriş Yap - Sigorta Yönetim Paneli</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f6f6f6;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .auth-card {
            background: #ffffff;
            border: 1px solid #dcdcdc;
            border-radius: 8px;
            padding: 2rem;
            width: 100%;
            max-width: 380px;
        }

        .auth-title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1f3c88;
            margin-bottom: 0.4rem;
            text-align: center;
        }

        .auth-subtitle {
            font-size: 0.9rem;
            color: #6c757d;
            text-align: center;
            margin-bottom: 1.7rem;
        }

        .form-control {
            border: 1px solid #dcdcdc;
            border-radius: 10px;
            height: 46px;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #1f3c88;
            box-shadow: none;
        }

        .btn-primary {
            background: #1f3c88;
            border: 1px solid #1f3c88;
            height: 46px;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .btn-primary:hover {
            background: #182f6d;
            border-color: #182f6d;
        }

        .form-check-input:checked {
            background-color: #1f3c88;
            border-color: #1f3c88;
        }

        .auth-footer {
            text-align: center;
            margin-top: 1.2rem;
        }

        .auth-footer a {
            color: #1f3c88;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .auth-footer a:hover {
            text-decoration: underline;
        }

        .alert {
            border: none;
            border-radius: 6px;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

       @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')

</body>
</html>
