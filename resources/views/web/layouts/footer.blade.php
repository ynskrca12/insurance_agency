<footer class="footer-web">
    <div class="footer-content">
        <!-- Şirket Bilgileri -->
        <div class="footer-section">
            <a href="{{ route('home') }}" class="navbar-brand text-white mb-2">
                <img src="{{ asset('logosysnew.png') }}" alt="syslogo" style="width: 28px;" class="">
                <span>Sigorta Yönetim Sistemi</span>
            </a>
            <p>
                Modern, güçlü ve kolay kullanımlı sigorta yönetim sistemi ile acentenizi dijitalleştirin.
            </p>
            <div class="footer-social">
                <a href="#" class="social-link" title="Facebook">
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="#" class="social-link" title="LinkedIn">
                    <i class="bi bi-linkedin"></i>
                </a>
                <a href="https://www.instagram.com/sigortayonetimsistemi/" class="social-link" title="Instagram">
                    <i class="bi bi-instagram"></i>
                </a>
            </div>
        </div>

        <!-- Hızlı Linkler -->
        <div class="footer-section">
            <h3>Hızlı Linkler</h3>
            <ul class="footer-links" style="padding-left: 0px !important">
                <li><a href="{{ route('home') }}">Anasayfa</a></li>
                <li><a href="{{ route('about') }}">Hakkımızda</a></li>
                <li><a href="{{ route('modules') }}">Modüller</a></li>
                <li><a href="{{ route('pricing') }}">Paketler</a></li>
                <li><a href="{{ route('what-is-crm') }}">CRM Nedir?</a></li>
            </ul>
        </div>

        <!-- Modüller -->
        <div class="footer-section">
            <h3>Modüller</h3>
            <ul class="footer-links" style="padding-left: 0px !important">
                <li><a href="{{ route('modules.customers') }}">Müşteri Yönetimi</a></li>
                <li><a href="{{ route('modules.policies') }}">Poliçe Yönetimi</a></li>
                <li><a href="{{ route('modules.quotations') }}">Teklif Yönetimi</a></li>
                <li><a href="{{ route('modules.payments') }}">Ödeme & Taksit</a></li>
                <li><a href="{{ route('modules.reports') }}">Raporlama</a></li>
            </ul>
        </div>

        <!-- İletişim -->
        <div class="footer-section footer-contact">
            <h3>İletişim</h3>
            <p>
                <i class="bi bi-geo-alt"></i>
                İstanbul, Türkiye
            </p>
            <p>
                <i class="bi bi-telephone"></i>
                +90 (212) 123 45 67
            </p>
            <p>
                <i class="bi bi-envelope"></i>
                info@sigortayonetimsistemi.com
            </p>
            <p>
                <i class="bi bi-clock"></i>
                Hafta içi 09:00 - 18:00
            </p>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Sigorta Yönetim Sistemi. Tüm hakları saklıdır.</p>
    </div>
</footer>
