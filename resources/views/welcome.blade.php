<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sigorta Yönetim Sistemi</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero-section {
            text-align: center;
            color: white;
        }

        .hero-icon {
            font-size: 6rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            margin-bottom: 3rem;
            opacity: 0.9;
        }

        .btn-hero {
            padding: 1rem 3rem;
            font-size: 1.2rem;
            border-radius: 50px;
            transition: all 0.3s;
        }

        .btn-hero:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .features {
            margin-top: 5rem;
        }

        .feature-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            margin: 1rem;
            transition: all 0.3s;
        }

        .feature-card:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="hero-section">
            <i class="bi bi-shield-check hero-icon"></i>
            <h1 class="hero-title">Sigorta Yönetim Sistemi</h1>
            <p class="hero-subtitle">Modern, Güvenli ve Kullanıcı Dostu Acente Paneli</p>

            <div class="d-flex justify-content-center gap-3">
                <a href="{{ url('/panel/login') }}" class="btn btn-light btn-hero">
                    <i class="bi bi-box-arrow-in-right me-2"></i>
                    Panele Giriş
                </a>
                <a href="{{ route('register') }}" class="btn btn-outline-light btn-hero">
                    <i class="bi bi-person-plus me-2"></i>
                    Kayıt Ol
                </a>
            </div>

            <!-- Özellikler -->
            <div class="features">
                <div class="row">
                    <div class="col-md-3">
                        <div class="feature-card">
                            <i class="bi bi-people feature-icon"></i>
                            <h5>Müşteri Yönetimi</h5>
                            <p class="small">Tüm müşterilerinizi tek platformda yönetin</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-card">
                            <i class="bi bi-file-earmark-text feature-icon"></i>
                            <h5>Poliçe Takibi</h5>
                            <p class="small">Poliçeleri izleyin, otomatik yenileyin</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-card">
                            <i class="bi bi-cash-stack feature-icon"></i>
                            <h5>Ödeme Planları</h5>
                            <p class="small">Taksit ve ödeme takibi kolayca</p>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="feature-card">
                            <i class="bi bi-graph-up feature-icon"></i>
                            <h5>Raporlama</h5>
                            <p class="small">Detaylı analiz ve raporlar</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-5">
                <p class="small opacity-75">
                    © 2025 Sigorta Yönetim Sistemi. Tüm hakları saklıdır.
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
