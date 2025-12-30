<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Genel Bakış') - Sigorta Yönetim Paneli</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('public/logosysnew.png') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --sidebar-width: 260px;
            --navbar-height: 72px;

            /* Modern Color Palette - Trust & Professional */
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --primary-light: #3b82f6;

            --secondary: #0ea5e9;
            --secondary-dark: #0284c7;

            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;

            --neutral-50: #f8fafc;
            --neutral-100: #f1f5f9;
            --neutral-200: #e2e8f0;
            --neutral-300: #cbd5e1;
            --neutral-400: #94a3b8;
            --neutral-500: #64748b;
            --neutral-600: #475569;
            --neutral-700: #334155;
            --neutral-800: #1e293b;
            --neutral-900: #0f172a;

            /* Shadows */
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-size: 0.9rem;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--neutral-50);
            color: var(--neutral-800);
        }

        /* ============================================
           NAVBAR - ULTRA MODERN DESIGN
        ============================================ */
        .top-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: var(--navbar-height);
            background: #ffffff;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--neutral-200);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
            z-index: 1030;
            display: flex;
            align-items: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar-container {
            width: 100%;
            max-width: 100%;
            display: grid;
            grid-template-columns: 230px 1fr 340px;
            align-items: center;
            padding: 0 32px;
        }

        /* ============================================
           LOGO SECTION - PREMIUM
        ============================================ */
        .navbar-logo {
            display: flex;
            align-items: center;
            gap: 14px;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .navbar-logo:hover {
            transform: translateY(-1px);
        }

        .logo-image-wrapper {
            position: relative;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .navbar-logo img {
            width: 34px;
            height: 34px;
        }

        .navbar-logo-text {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .navbar-logo-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--neutral-900);
            line-height: 1.2;
            letter-spacing: -0.02em;
        }

        .navbar-logo-subtitle {
            font-size: 11px;
            color: var(--neutral-500);
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* ============================================
           DEMO BANNER - ANIMATED PREMIUM
        ============================================ */
        .demo-banner-wrapper {
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            padding: 0;
            height: 42px;
        }

        /* Animated gradient background */
        .demo-banner-wrapper::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 200%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.1),
                transparent
            );
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { left: -100%; }
            100% { left: 100%; }
        }

        .demo-banner-content {
            display: flex;
            align-items: center;
            white-space: nowrap;
            animation: scroll-left 30s linear infinite;
            padding: 0;
        }

        .demo-banner-item {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 11px 40px;
            color: #000;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.01em;
        }

        .demo-icon {
            width: 23px;
            height: 23px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            animation: bounce-subtle 2s ease-in-out infinite;
        }

        .demo-icon i {
            font-size: 13px;
        }

        @keyframes scroll-left {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        @keyframes bounce-subtle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-3px); }
        }

        /* ============================================
           USER SECTION - ULTRA MODERN
        ============================================ */
        .navbar-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 14px;
        }

        .user-info-card {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 6px 6px 14px;
            background: var(--neutral-50);
            border: 1px solid var(--neutral-200);
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .user-info-card:hover {
            background: white;
            border-color: var(--primary-light);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.12);
            transform: translateY(-1px);
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 0.02em;
            box-shadow: 0 2px 8px rgba(37, 99, 235, 0.25);
        }

        .user-details {
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding-right: 8px;
        }

        .user-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--neutral-900);
            line-height: 1.2;
            letter-spacing: -0.01em;
        }

        .user-role {
            font-size: 11px;
            font-weight: 600;
            color: var(--neutral-500);
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        /* Divider */
        .navbar-divider {
            width: 1px;
            height: 32px;
            background: var(--neutral-200);
        }

        /* Logout Button - Premium */
        .logout-btn {
            position: relative;
            padding: 10px 20px;
            background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            overflow: hidden;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .logout-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                90deg,
                transparent,
                rgba(255, 255, 255, 0.2),
                transparent
            );
            transition: left 0.5s ease;
        }

        .logout-btn:hover::before {
            left: 100%;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.4);
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
        }

        .logout-btn:active {
            transform: translateY(0);
        }

        .logout-btn i {
            font-size: 15px;
            transition: transform 0.3s ease;
        }

        .logout-btn:hover i {
            transform: translateX(2px);
        }

        /* ============================================
           SIDEBAR - MODERN
        ============================================ */
        .sidebar {
            position: fixed;
            top: var(--navbar-height);
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 24px 0;
            width: var(--sidebar-width);
            background: white;
            border-right: 1px solid var(--neutral-200);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.02);
        }

        .sidebar-sticky {
            position: sticky;
            top: 0;
            height: calc(100vh - var(--navbar-height));
            padding: 0 16px;
            overflow-x: hidden;
            overflow-y: auto;
        }

        /* Custom Scrollbar */
        .sidebar-sticky::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar-sticky::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-sticky::-webkit-scrollbar-thumb {
            background: var(--neutral-300);
            border-radius: 10px;
        }

        .sidebar-sticky::-webkit-scrollbar-thumb:hover {
            background: var(--neutral-400);
        }

        .sidebar .nav-link {
            font-weight: 600;
            font-size: 14px;
            color: var(--neutral-600);
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 4px;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link:hover {
            background: var(--neutral-100);
            color: var(--neutral-900);
            transform: translateX(2px);
        }

        .sidebar .nav-link.active {
            color: var(--primary);
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.1), rgba(59, 130, 246, 0.05));
            font-weight: 700;
        }

        .sidebar .nav-link i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
            font-size: 18px;
        }

        .badge {
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 700;
        }

        .bg-light {
            background: transparent;
        }

        /* ============================================
           MAIN CONTENT
        ============================================ */
        main {
            margin-left: var(--sidebar-width);
            padding-top: var(--navbar-height);
            min-height: 100vh;
        }

        .content-wrapper {
            padding: 20px 0px;
        }

        /* ============================================
           RESPONSIVE
        ============================================ */
        @media (max-width: 1200px) {
            .navbar-container {
                grid-template-columns: 200px 1fr 320px;
            }
        }

        @media (max-width: 992px) {
            .navbar-container {
                grid-template-columns: auto 1fr auto;
            }

            .navbar-logo-text {
                display: none;
            }

            .demo-banner-item {
                padding: 11px 30px;
                font-size: 12px;
            }
        }

        @media (max-width: 768px) {
            :root {
                --navbar-height: 60px;
            }

            .navbar-container {
                grid-template-columns: 1fr auto;
                gap: 12px;
                padding: 0 16px;
            }

            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.show {
                transform: translateX(0);
            }

            main {
                margin-left: 0;
            }

            .demo-banner-wrapper {
                display: none;
            }

            .user-details {
                display: none;
            }

            .navbar-divider {
                display: none;
            }

            .logout-btn {
                padding: 10px 14px;
            }
        }

        /* ============================================
           ANIMATIONS
        ============================================ */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .top-navbar {
            animation: fadeIn 0.6s ease-out;
        }

        /* Hover Effects */
        .hover-lift {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-2px);
        }
    </style>

    <style>
        /* ============================================
        MOBİL OPTİMİZASYON - PROFESYONEL
        ============================================ */

        /* Mobile Menu Toggle Button */
        .mobile-menu-toggle {
            display: none;
            position: fixed;
            top: 2px;
            right: 16px;
            z-index: 1050;
            background: white;
            border: 2px solid var(--neutral-200);
            border-radius: 10px;
            padding: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .mobile-menu-toggle:hover {
            background: var(--neutral-50);
            border-color: var(--primary);
        }

        .mobile-menu-toggle span {
            display: block;
            width: 22px;
            height: 2px;
            background: var(--neutral-800);
            margin: 4px 0;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .mobile-menu-toggle.active span:nth-child(1) {
            transform: rotate(45deg) translate(5px, 5px);
        }

        .mobile-menu-toggle.active span:nth-child(2) {
            opacity: 0;
        }

        .mobile-menu-toggle.active span:nth-child(3) {
            transform: rotate(-45deg) translate(7px, -7px);
        }

        /* Mobile Sidebar Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            z-index: 1020;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.show {
            display: block;
            opacity: 1;
        }

        @media (max-width: 768px) {
            .top-navbar {
                height: 60px;
                padding: 0 !important;
            }

            .navbar-container {
                grid-template-columns: auto 1fr auto;
                gap: 8px;
                padding: 0 60px 0 16px !important;
            }

            .navbar-logo {
                gap: 10px;
            }

            .logo-image-wrapper {
                width: 36px;
                height: 36px;
            }

            .navbar-logo img {
                width: 28px;
                height: 28px;
            }

            .navbar-logo-text {
                display: none !important;
            }

            .navbar-actions {
                gap: 8px;
            }

            .user-info-card {
                padding: 4px;
                gap: 0;
            }

            .user-avatar {
                width: 32px;
                height: 32px;
                font-size: 13px;
            }

            .user-details {
                display: none !important;
            }

            .navbar-divider {
                display: none !important;
            }

            .logout-btn {
                padding: 8px 12px;
                gap: 0;
            }

            .logout-btn i {
                font-size: 18px;
                margin: 0;
            }
            .mobile-menu-toggle {
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }

            .sidebar {
                position: fixed;
                top: -65px;
                left: -280px;
                bottom: 0;
                width: 280px;
                z-index: 1040;
                padding: 80px 0 24px;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            }

            .sidebar.show {
                transform: translateX(280px);
                left: -280px;
            }

            .sidebar-sticky {
                height: calc(100vh - 80px);
                padding: 0 12px;
            }

            .sidebar .nav-link {
                font-size: 15px;
                padding: 14px 16px;
                margin-bottom: 6px;
            }

            .sidebar .nav-link i {
                font-size: 20px;
                margin-right: 14px;
            }

            .sidebar hr {
                margin: 16px 12px !important;
            }

            .sidebar .dropdown-menu {
                position: static !important;
                transform: none !important;
                box-shadow: none;
                border: none;
                background: var(--neutral-50);
                margin: 4px 0 8px 0;
                border-radius: 8px;
            }

            .sidebar .dropdown-item {
                padding: 10px 16px 10px 48px;
                font-size: 14px;
            }

            .sidebar .dropdown-toggle::after {
                margin-left: auto;
            }

            main {
                margin-left: 0 !important;
                padding-top: 60px !important;
            }

            .breadcrumb {
                font-size: 12px;
                padding: 8px 0;
                margin-bottom: 16px;
            }

            .breadcrumb-item {
                max-width: 120px;
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
            }

            .alert {
                font-size: 13px;
                padding: 12px;
                margin-bottom: 16px;
            }

            .card {
                margin-bottom: 16px;
                border-radius: 12px;
            }

            .card-body {
                padding: 16px;
            }

            .btn {
                font-size: 13px;
                padding: 10px 16px;
            }

            .btn-sm {
                font-size: 12px;
                padding: 6px 12px;
            }

            .table-responsive {
                margin: 0 -16px;
                border-radius: 0;
            }

            .table {
                font-size: 13px;
            }

            .table th,
            .table td {
                padding: 10px 8px;
            }

            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                margin-bottom: 12px;
            }

            .dataTables_wrapper .dataTables_length select {
                font-size: 13px;
                padding: 6px 8px;
            }

            .dataTables_wrapper .dataTables_filter input {
                font-size: 13px;
                padding: 6px 12px;
            }

            .dataTables_wrapper .dt-buttons {
                margin-bottom: 12px;
            }

            .dataTables_wrapper .dt-buttons .btn {
                font-size: 12px;
                padding: 6px 10px;
                margin: 2px;
            }

            .form-label {
                font-size: 13px;
                margin-bottom: 6px;
            }

            .form-control,
            .form-select {
                font-size: 14px;
                padding: 10px 12px;
            }

            .form-text {
                font-size: 11px;
            }

            .modal-dialog {
                margin: 10px;
            }

            .modal-content {
                border-radius: 16px;
            }

            .modal-header,
            .modal-footer {
                padding: 16px;
            }

            .modal-body {
                padding: 20px 16px;
            }

            .stat-card {
                margin-bottom: 12px;
                padding: 16px;
                border-radius: 12px;
            }

            .stat-card h3 {
                font-size: 24px;
            }

            .stat-card p {
                font-size: 13px;
            }

            .page-header {
                margin-bottom: 20px;
            }

            .page-header h1 {
                font-size: 22px;
                margin-bottom: 8px;
            }

            .page-header .btn {
                width: 100%;
                margin-top: 12px;
            }
        }
        @media (max-width: 374px) {
            .navbar-container {
                padding: 0 50px 0 12px !important;
            }

            .mobile-menu-toggle {
                left: 12px;
                padding: 8px;
            }

            .mobile-menu-toggle span {
                width: 20px;
            }

            .sidebar {
                width: 260px;
            }

            .sidebar.show {
                transform: translateX(260px);
            }

            .logout-btn {
                padding: 6px 10px;
            }

            .user-info-card {
                padding: 2px;
            }

            .user-avatar {
                width: 28px;
                height: 28px;
                font-size: 12px;
            }
        }

        @media (max-width: 768px) and (orientation: landscape) {
            .sidebar {
                width: 260px;
            }

            .sidebar.show {
                transform: translateX(260px);
            }

            .sidebar-sticky {
                height: calc(100vh - 60px);
                padding-top: 60px;
            }
        }

        @media (min-width: 769px) and (max-width: 992px) {
            .navbar-container {
                grid-template-columns: 180px 1fr 280px;
                padding: 0 24px;
            }

            .demo-banner-item {
                padding: 11px 24px;
                font-size: 12px;
            }

            .sidebar {
                width: 240px;
            }

            main {
                margin-left: 240px;
            }

            .content-wrapper {
                padding: 10px 0;
            }
        }
    </style>

    <script type="application/ld+json">
        {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Sigorta Yönetim Sistemi",
        "url": "https://sigortayonetimsistemi.com",
        "logo": "https://sigortayonetimsistemi.com/logosysnew.png"
        }
    </script>

    @stack('styles')
</head>
<body>
    <!-- Top Navbar -->
    <nav class="top-navbar">
        <div class="navbar-container">
            <!-- Logo Section -->
            <a href="{{ route('dashboard') }}" class="navbar-logo">
                <div class="logo-image-wrapper">
                    <img src="{{ asset('public/logosysnew.png') }}" alt="Logo">
                </div>
                <div class="navbar-logo-text">
                    <span class="navbar-logo-title">Sigorta</span>
                    <span class="navbar-logo-subtitle">Yönetim Sistemi</span>
                </div>
            </a>

            <!-- Demo Banner - Animated Scroll -->
            <div class="demo-banner-wrapper">
                <div class="demo-banner-content">
                    <!-- First Set -->
                    <div class="demo-banner-item">
                        <span class="demo-icon">
                            <i class="bi bi-gift-fill"></i>
                        </span>
                        <span>14 Gün Ücretsiz Demo Sürümü</span>
                    </div>
                    <div class="demo-banner-item">
                        <span class="demo-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </span>
                        <span>Tüm Özelliklere Tam Erişim</span>
                    </div>
                    <div class="demo-banner-item">
                        <span class="demo-icon">
                            <i class="bi bi-headset"></i>
                        </span>
                        <span>Tam Sürüm İçin Bizimle İletişime Geçin</span>
                    </div>

                    <!-- Duplicate for seamless loop -->
                    <div class="demo-banner-item">
                        <span class="demo-icon">
                            <i class="bi bi-gift-fill"></i>
                        </span>
                        <span>14 Gün Ücretsiz Demo Sürümü</span>
                    </div>
                    <div class="demo-banner-item">
                        <span class="demo-icon">
                            <i class="bi bi-check-circle-fill"></i>
                        </span>
                        <span>Tüm Özelliklere Tam Erişim</span>
                    </div>
                    <div class="demo-banner-item">
                        <span class="demo-icon">
                            <i class="bi bi-headset"></i>
                        </span>
                        <span>Tam Sürüm İçin Bizimle İletişime Geçin</span>
                    </div>
                </div>
            </div>

            <!-- User Actions -->
            <div class="navbar-actions">
                <!-- User Info Card -->
                <div class="user-info-card">
                    <div class="user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="user-details">
                        <span class="user-name">{{ auth()->user()->name }}</span>
                        <span class="user-role">{{ auth()->user()->role_label }}</span>
                    </div>
                </div>

                <!-- Divider -->
                <div class="navbar-divider"></div>

                <!-- Logout Button -->
                <!-- <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="logout-btn hover-lift">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Çıkış Yap</span>
                    </button>
                </form> -->
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse" id="sidebarMenu">
                <div class="sidebar-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                               href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2"></i>
                                Genel Bakış
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}"
                               href="{{ route('customers.index') }}">
                                <i class="bi bi-people"></i>
                                Müşteriler
                                @php
                                    $allCustomers = \App\Models\Customer::where('created_by', auth()->id())->count();
                                @endphp
                                    <span class="badge bg-light text-dark ms-auto">{{ $allCustomers }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('policies.*') ? 'active' : '' }}"
                               href="{{ route('policies.index') }}">
                                <i class="bi bi-file-earmark-text"></i>
                                Poliçeler
                                @php
                                    $allPolicies = \App\Models\Policy::where('created_by', auth()->id())->count();
                                @endphp
                                    <span class="badge bg-light text-dark ms-auto">{{ $allPolicies }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('quotations.index') }}">
                                <i class="bi bi-file-earmark-plus"></i>
                                Teklifler
                                @php
                                    $draftQuotations = \App\Models\Quatation::where('status', 'draft')->count();
                                @endphp
                                    <span class="badge bg-light text-dark ms-auto">{{ $draftQuotations }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('renewals.*') ? 'active' : '' }}"
                            href="{{ route('renewals.index') }}">
                                <i class="bi bi-arrow-repeat"></i>
                                Yenilemeler
                                @php
                                    $criticalCount = \App\Models\PolicyRenewal::critical()->count();
                                @endphp

                                    <span class="badge bg-danger ms-auto">{{ $criticalCount }}</span>

                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}"
                            href="{{ route('payments.installments') }}">
                                <i class="bi bi-credit-card"></i>
                                Ödemeler
                                 @php
                                    $payments = \App\Models\Payment::completed()->count();
                                @endphp
                                    <span class="badge bg-success ms-auto">{{ $payments }}</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('tasks.*') ? 'active' : '' }}"
                            href="{{ route('tasks.index') }}">
                                <i class="bi bi-check2-square"></i>
                                Görevler
                                @php
                                    $myOpenTasks = \App\Models\Task::where('assigned_to', auth()->id())
                                        ->whereNotIn('status', ['completed', 'cancelled'])
                                        ->count();
                                @endphp

                                    <span class="badge bg-light text-dark ms-auto">{{ $myOpenTasks }}</span>

                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('campaigns.*') ? 'active' : '' }}"
                            href="{{ route('campaigns.index') }}">
                                <i class="bi bi-megaphone"></i>
                                Kampanyalar
                                @php
                                    $draftCampaigns = \App\Models\Campaign::where('status', 'draft')->count();
                                @endphp

                                    <span class="badge bg-light text-dark ms-auto">{{ $draftCampaigns }}</span>

                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}"
                            href="{{ route('reports.index') }}">
                                <i class="bi bi-graph-up"></i>
                                Raporlar
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('insurance-companies.*') ? 'active' : '' }}"
                            href="{{ route('insurance-companies.index') }}">
                                <i class="bi bi-building"></i>
                                Sigorta Şirketleri
                                @php
                                    $activeCompanies = \App\Models\InsuranceCompany::where('is_active', true)->count();
                                @endphp

                                    <span class="badge bg-light text-dark ms-auto">{{ $activeCompanies }}</span>

                            </a>
                        </li>

                        <!-- Settings Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->routeIs('settings.*') ? 'active' : '' }}"
                            href="#"
                            id="settingsDropdown"
                            role="button"
                            data-bs-toggle="dropdown">
                                <i class="bi bi-gear"></i>
                                Ayarlar
                            </a>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item" href="{{ route('settings.index') }}">
                                        <i class="bi bi-building me-2"></i>Genel Ayarlar
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('settings.users') }}">
                                        <i class="bi bi-people me-2"></i>Kullanıcılar
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('settings.profile') }}">
                                        <i class="bi bi-person me-2"></i>Profil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('settings.security') }}">
                                        <i class="bi bi-shield-check me-2"></i>Güvenlik
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <!-- Logout Button -->
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" class="logout-btn hover-lift w-100 d-flex justify-content-center">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    <span>Çıkış Yap</span>
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="content-wrapper">
                    <!-- Breadcrumb -->
                    @if(isset($breadcrumbs))
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb">
                            @foreach($breadcrumbs as $breadcrumb)
                                @if($loop->last)
                                    <li class="breadcrumb-item active">{{ $breadcrumb['title'] }}</li>
                                @else
                                    <li class="breadcrumb-item">
                                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                                    </li>
                                @endif
                            @endforeach
                        </ol>
                    </nav>
                    @endif

                    <!-- Alerts -->
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

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

                    <!-- Page Content -->
                    @yield('content')
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>

    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <!-- Global DataTable Init Script -->
    <script>
        // Türkçe dil desteği
        const dataTableTurkish = {
            "sDecimal": ",",
            "sEmptyTable": "Tabloda herhangi bir veri mevcut değil",
            "sInfo": "_TOTAL_ kayıttan _START_ - _END_ arası gösteriliyor",
            "sInfoEmpty": "Kayıt yok",
            "sInfoFiltered": "(_MAX_ kayıt içerisinden bulunan)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "Sayfada _MENU_ kayıt göster",
            "sLoadingRecords": "Yükleniyor...",
            "sProcessing": "İşleniyor...",
            "sSearch": "Ara:",
            "sZeroRecords": "Eşleşen kayıt bulunamadı",
            "oPaginate": {
                "sFirst": "İlk",
                "sLast": "Son",
                "sNext": "Sonraki",
                "sPrevious": "Önceki"
            },
            "oAria": {
                "sSortAscending": ": artan sütun sıralamasını aktifleştir",
                "sSortDescending": ": azalan sütun sıralamasını aktifleştir"
            },
            "select": {
                "rows": {
                    "_": "%d kayıt seçildi",
                    "0": "",
                    "1": "1 kayıt seçildi"
                }
            }
        };

        // Global DataTable fonksiyonu
        function initDataTable(tableId, options = {}) {
            const defaultOptions = {
                language: dataTableTurkish,
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tümü"]],
                dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>Brtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="bi bi-file-earmark-excel"></i> Excel',
                        className: 'btn btn-success btn-sm',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        title: 'Export_' + new Date().toLocaleDateString('tr-TR')
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="bi bi-file-earmark-pdf"></i> PDF',
                        className: 'btn btn-danger btn-sm',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        title: 'Export_' + new Date().toLocaleDateString('tr-TR'),
                        customize: function(doc) {
                            doc.defaultStyle.fontSize = 9;
                            doc.styles.tableHeader.fontSize = 10;
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="bi bi-printer"></i> Yazdır',
                        className: 'btn btn-info btn-sm',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        },
                        title: 'Export'
                    }
                ],
                responsive: true,
                processing: true,
                stateSave: true,
            };

            const table = $(tableId).DataTable({
                ...defaultOptions,
                ...options
            });

            table.on('order.dt search.dt draw.dt', function () {
                let i = 1;
                table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
                    this.data(i++);
                });
            }).draw();

            return table;
        }
    </script>

    <!-- Mobile Menu Script -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile menu elements
        const mobileToggle = document.createElement('button');
        mobileToggle.className = 'mobile-menu-toggle';
        mobileToggle.innerHTML = '<span></span><span></span><span></span>';
        mobileToggle.setAttribute('aria-label', 'Menu');

        // Sidebar overlay
        const sidebarOverlay = document.createElement('div');
        sidebarOverlay.className = 'sidebar-overlay';

        // Add elements to body
        document.body.appendChild(mobileToggle);
        document.body.appendChild(sidebarOverlay);

        const sidebar = document.getElementById('sidebarMenu');

        // Toggle menu
        function toggleMenu() {
            mobileToggle.classList.toggle('active');
            sidebar.classList.toggle('show');
            sidebarOverlay.classList.toggle('show');
            document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
        }

        // Close menu
        function closeMenu() {
            mobileToggle.classList.remove('active');
            sidebar.classList.remove('show');
            sidebarOverlay.classList.remove('show');
            document.body.style.overflow = '';
        }

        // Event listeners
        mobileToggle.addEventListener('click', toggleMenu);
        sidebarOverlay.addEventListener('click', closeMenu);

        // Close on navigation
        const navLinks = sidebar.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    // Don't close for dropdown toggles
                    if (!this.classList.contains('dropdown-toggle')) {
                        closeMenu();
                    }
                }
            });
        });

        // Close on window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeMenu();
            }
        });

        // Handle dropdown in mobile
        const dropdownToggle = document.getElementById('settingsDropdown');
        if (dropdownToggle) {
            dropdownToggle.addEventListener('click', function(e) {
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    const dropdownMenu = this.nextElementSibling;
                    dropdownMenu.classList.toggle('show');
                }
            });
        }
    });
    </script>

    @stack('scripts')
</body>
</html>
