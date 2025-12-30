<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Sigorta acentenizi dijitalleştirin. Modern, güçlü ve kolay kullanımlı sigorta yönetim sistemi.')">
    <meta name="keywords" content="@yield('meta_keywords', 'sigorta yönetim sistemi, crm, acente yazılımı, poliçe takip')">
    <title>@yield('title', 'Acentenizi Dijitalleştirin') - Sigorta Yönetim Sistemi</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('logosysnew.png') }}">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('web/css/style.css') }}">

        <script type="application/ld+json">
            {
            "@@context": "https://schema.org",
            "@type": "Organization",
            "name": "Sigorta Yönetim Sistemi",
            "url": "https://sigortayonetimsistemi.com",
            "logo": "https://sigortayonetimsistemi.com/logosysnew.png"
            }
        </script>

    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    @include('web.layouts.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('web.layouts.footer')

    <!-- Custom JS -->
    <script src="{{ asset('web/js/main.js') }}"></script>

    @stack('scripts')
</body>
</html>
