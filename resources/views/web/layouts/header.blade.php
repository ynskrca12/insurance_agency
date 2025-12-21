<nav class="navbar navbar-expand-lg  navbar-web py-3">
    <div class="container px-3 px-md-0 py-0">
        <a href="{{ route('home') }}" class="navbar-brand">
            <img src="{{ asset('logosysnew.png') }}" alt="syslogo" style="width: 28px;" class="">
            <span>Sigorta Yönetim Sistemi</span>
        </a>

        <ul class="navbar-nav">
            <li><a href="{{ route('home') }}" class="nav-link">Anasayfa</a></li>
            <li><a href="{{ route('about') }}" class="nav-link">Hakkımızda</a></li>
            <li><a href="{{ route('modules') }}" class="nav-link">Modüller</a></li>
            <li><a href="{{ route('pricing') }}" class="nav-link">Paketler</a></li>
            <li><a href="{{ route('what-is-crm') }}" class="nav-link">CRM Nedir?</a></li>
            <li><a href="{{ route('contact') }}" class="nav-link">İletişim</a></li>
            @guest
                <li><a href="{{ route('login') }}" class="btn btn-login">Giriş Yap</a></li>
                <li><a href="{{ route('demo.form') }}" class="btn btn-demo">Ücretsiz Demo</a></li>
            @else
                <li><a href="{{ route('dashboard') }}" class="btn btn-dashboard">Panel</a></li>
            @endguest
        </ul>

        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</nav>
