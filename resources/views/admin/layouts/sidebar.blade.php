<aside class="admin-sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <i class="bi bi-shield-check"></i>
        </div>
        <div class="sidebar-logo-text">
            <h2>SigortaCRM</h2>
            <span>Admin Panel</span>
        </div>
    </div>

    <!-- Menu -->
    <nav class="sidebar-menu">
        <!-- Dashboard -->
        <div class="sidebar-menu-section">
            <div class="sidebar-menu-title">Ana Menü</div>
            <ul class="sidebar-menu-list">
                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Blog -->
        <div class="sidebar-menu-section">
            <div class="sidebar-menu-title">İçerik Yönetimi</div>
            <ul class="sidebar-menu-list">
                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.blogs.index') }}" class="sidebar-menu-link">
                        <i class="bi bi-file-text"></i>
                        <span>Blog Yazıları</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.blogs.create') }}" class="sidebar-menu-link">
                        <i class="bi bi-plus-circle"></i>
                        <span>Yeni Yazı Ekle</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Demo Users -->
        <div class="sidebar-menu-section">
            <div class="sidebar-menu-title">Kullanıcılar</div>
            <ul class="sidebar-menu-list">
                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.demo-users.index') }}" class="sidebar-menu-link">
                        <i class="bi bi-people"></i>
                        <span>Demo Kullanıcılar</span>
                        @php
                            $activeCount = \App\Models\DemoUser::whereHas('user')->count();
                        @endphp
                        @if($activeCount > 0)
                            <span class="sidebar-menu-badge">{{ $activeCount }}</span>
                        @endif
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.contact-messages.index') }}" class="sidebar-menu-link">
                        <i class="bi bi-envelope"></i>
                        <span>İletişim Mesajları</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Settings -->
        <div class="sidebar-menu-section">
            <div class="sidebar-menu-title">Sistem</div>
            <ul class="sidebar-menu-list">
                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.settings') }}" class="sidebar-menu-link">
                        <i class="bi bi-gear"></i>
                        <span>Ayarlar</span>
                    </a>
                </li>
                <li class="sidebar-menu-item">
                    <a href="{{ route('admin.activity-log') }}" class="sidebar-menu-link">
                        <i class="bi bi-clock-history"></i>
                        <span>Aktivite Kayıtları</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- User Info -->
    <div class="sidebar-footer">
        <div class="sidebar-user">
            <div class="sidebar-user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="sidebar-user-info">
                <span class="sidebar-user-name">{{ auth()->user()->name }}</span>
                <span class="sidebar-user-role">Administrator</span>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="sidebar-user-logout" data-tooltip="Çıkış Yap">
                    <i class="bi bi-box-arrow-right"></i>
                </button>
            </form>
        </div>
    </div>
</aside>
