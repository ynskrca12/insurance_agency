<header class="admin-navbar">
    <div class="navbar-left">
        <!-- Mobile Toggle -->
        <button class="navbar-toggle">
            <i class="bi bi-list"></i>
        </button>

        <!-- Breadcrumb -->
        <div class="navbar-breadcrumb">
            <span class="breadcrumb-item">Admin</span>
            <i class="bi bi-chevron-right breadcrumb-separator"></i>
            <span class="breadcrumb-item active">@yield('page-title', 'Dashboard')</span>
        </div>
    </div>

    <div class="navbar-right">
        <!-- Search -->
        <div class="navbar-search">
            <i class="bi bi-search navbar-search-icon"></i>
            <input
                type="text"
                class="navbar-search-input"
                placeholder="Ara..."
            >
        </div>

        <!-- Notifications -->
        <button class="navbar-icon-btn" data-tooltip="Bildirimler">
            <i class="bi bi-bell"></i>
            <span class="navbar-icon-badge">3</span>
        </button>

        <!-- Settings -->
        <a href="{{ route('admin.settings') }}" class="navbar-icon-btn" data-tooltip="Ayarlar">
            <i class="bi bi-gear"></i>
        </a>

        <!-- User Website Link -->
        <a href="{{ route('home') }}" class="navbar-icon-btn" data-tooltip="Siteye Git" target="_blank">
            <i class="bi bi-box-arrow-up-right"></i>
        </a>
    </div>
</header>
