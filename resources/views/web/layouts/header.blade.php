<!-- Top Announcement Banner - Animated & Live -->
<div class="top-announcement-bar" id="topBanner">
    <div class="announcement-content">
        <!-- First Set -->
        <div class="announcement-item">
            <span class="announcement-icon">
                <i class="bi bi-gift-fill"></i>
            </span>
            <span><strong>14 Gün Ücretsiz Demo!</strong> Kredi kartı bilgisi gerekmez</span>
        </div>

        <div class="announcement-item">
            <span class="announcement-badge">YENİ</span>
            <span>Detaylı Raporlama</span>
        </div>

        <div class="announcement-item">
            <span class="announcement-icon">
                <i class="bi bi-percent"></i>
            </span>
            <span>İlk 10 Kullanıcıya <strong>%20 İndirim</strong></span>
        </div>

        <div class="announcement-item">
            <span class="announcement-icon">
                <i class="bi bi-headset"></i>
            </span>
            <span>7/24 Teknik Destek</span>
        </div>

        <div class="announcement-item">
            <span class="announcement-icon">
                <i class="bi bi-shield-check"></i>
            </span>
            <span>Banka Seviyesi Güvenlik</span>
        </div>


        <!-- Duplicate for seamless loop -->
        <div class="announcement-item">
            <span class="announcement-icon">
                <i class="bi bi-gift-fill"></i>
            </span>
            <span><strong>14 Gün Ücretsiz Demo!</strong> Kredi kartı bilgisi gerekmez</span>
        </div>

        <div class="announcement-item">
            <span class="announcement-badge">YENİ</span>
            <span>Detaylı Raporlama</span>
        </div>

        <div class="announcement-item">
            <span class="announcement-icon">
                <i class="bi bi-percent"></i>
            </span>
            <span>İlk 50 Kullanıcıya <strong>%20 İndirim</strong></span>
        </div>

        <div class="announcement-item">
            <span class="announcement-icon">
                <i class="bi bi-headset"></i>
            </span>
            <span>7/24 Teknik Destek</span>
        </div>

        <div class="announcement-item">
            <span class="announcement-icon">
                <i class="bi bi-shield-check"></i>
            </span>
            <span>Banka Seviyesi Güvenlik</span>
        </div>

    </div>

    <!-- Close Button -->
    <!-- <button class="announcement-close" onclick="closeAnnouncement()">
        <i class="bi bi-x"></i>
    </button> -->
</div>

<!-- Main Navbar -->
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
                <li><a href="{{ route('login') }}" class="btn btn-login mb-2 mb-md-0">Giriş Yap</a></li>
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




<style>
/* ============================================
   TOP ANNOUNCEMENT BANNER - ANIMATED
============================================ */
.top-announcement-bar {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    position: relative;
    overflow: hidden;
    z-index: 1040;
}

.top-announcement-bar::before {
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

.announcement-content {
    display: flex;
    align-items: center;
    white-space: nowrap;
    animation: scroll-announcement 40s linear infinite;
    padding: 12px 0;
}

.announcement-item {
    display: inline-flex;
    align-items: center;
    gap: 12px;
    padding: 0 60px;
    color: white;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.3px;
}

.announcement-icon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: bounce-icon 2s ease-in-out infinite;
}

.announcement-icon i {
    font-size: 14px;
}

.announcement-badge {
    padding: 4px 10px;
    background: #10b981;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    animation: pulse-badge 2s ease-in-out infinite;
}

@keyframes scroll-announcement {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

@keyframes bounce-icon {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-4px); }
}

@keyframes pulse-badge {
    0%, 100% {
        transform: scale(1);
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    }
    50% {
        transform: scale(1.05);
        box-shadow: 0 0 0 8px rgba(16, 185, 129, 0);
    }
}

.announcement-close {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 28px;
    height: 28px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    z-index: 10;
}

.announcement-close:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-50%) rotate(90deg);
}


/* ============================================
   MOBILE MENU
============================================ */
.mobile-menu-toggle {
    display: none;
    flex-direction: column;
    gap: 5px;
    background: transparent;
    border: none;
    cursor: pointer;
    padding: 8px;
}

.mobile-menu-toggle span {
    width: 25px;
    height: 3px;
    background: #1e293b;
    border-radius: 3px;
    transition: all 0.3s ease;
}

.mobile-menu-toggle.active span:nth-child(1) {
    transform: rotate(45deg) translate(8px, 8px);
}

.mobile-menu-toggle.active span:nth-child(2) {
    opacity: 0;
}

.mobile-menu-toggle.active span:nth-child(3) {
    transform: rotate(-45deg) translate(7px, -7px);
}

.mobile-menu-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1050;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.mobile-menu-overlay.active {
    display: block;
    opacity: 1;
}

.mobile-menu {
    position: fixed;
    top: 0;
    right: -100%;
    width: 300px;
    height: 100vh;
    background: white;
    z-index: 1060;
    transition: right 0.3s ease;
    overflow-y: auto;
    box-shadow: -4px 0 20px rgba(0, 0, 0, 0.1);
}

.mobile-menu.active {
    right: 0;
}

.mobile-menu-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 20px;
    border-bottom: 1px solid #e2e8f0;
}

.mobile-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    font-weight: 700;
    font-size: 16px;
    color: #1e293b;
}

.mobile-menu-close {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #64748b;
}

.mobile-nav-list {
    list-style: none;
    padding: 20px 0;
    margin: 0;
}

.mobile-nav-list li a {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 20px;
    color: #475569;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
}

.mobile-nav-list li a:hover,
.mobile-nav-list li a.active {
    background: rgba(37, 99, 235, 0.05);
    color: #2563eb;
}

.mobile-nav-list li a i {
    font-size: 18px;
}

.mobile-menu-actions {
    padding: 20px;
    border-top: 1px solid #e2e8f0;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.btn-login-mobile,
.btn-demo-mobile,
.btn-dashboard-mobile {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    font-weight: 700;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-login-mobile {
    background: transparent;
    color: #2563eb;
    border: 2px solid #2563eb;
}

.btn-demo-mobile,
.btn-dashboard-mobile {
    background: linear-gradient(135deg, #2563eb 0%, #1e40af 100%);
    color: white;
    border: none;
}

/* ============================================
   RESPONSIVE
============================================ */
@media (max-width: 992px) {
    .desktop-menu {
        display: none;
    }

    .mobile-menu-toggle {
        display: flex;
    }
}

@media (max-width: 768px) {
    .announcement-item {
        padding: 0 40px;
        font-size: 13px;
    }

    .announcement-close {
        right: 10px;
    }

    .navbar-brand span {
        font-size: 16px;
    }
}
</style>

<script>
// Close announcement banner
//function closeAnnouncement() {
//    const banner = document.getElementById('topBanner');
//    banner.style.transform = 'translateY(-100%)';
//    setTimeout(() => {
//        banner.style.display = 'none';
//    }, 300);
//
//    // Save to localStorage
//    localStorage.setItem('announcementClosed', 'true');
//}
//
//// Check if announcement was closed
//if (localStorage.getItem('announcementClosed') === 'true') {
//    document.getElementById('topBanner').style.display = 'none';
//}

// Mobile menu functions
function toggleMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const overlay = document.getElementById('mobileMenuOverlay');
    const toggle = document.querySelector('.mobile-menu-toggle');

    menu.classList.toggle('active');
    overlay.classList.toggle('active');
    toggle.classList.toggle('active');
    document.body.style.overflow = menu.classList.contains('active') ? 'hidden' : '';
}

function closeMobileMenu() {
    const menu = document.getElementById('mobileMenu');
    const overlay = document.getElementById('mobileMenuOverlay');
    const toggle = document.querySelector('.mobile-menu-toggle');

    menu.classList.remove('active');
    overlay.classList.remove('active');
    toggle.classList.remove('active');
    document.body.style.overflow = '';
}

// Sticky navbar on scroll
window.addEventListener('scroll', function() {
    const navbar = document.getElementById('mainNavbar');
    if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
    } else {
        navbar.classList.remove('scrolled');
    }
});
</script>
