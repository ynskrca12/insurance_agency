/**
 * Admin Panel JavaScript
 * Modern & Professional
 */

document.addEventListener('DOMContentLoaded', function() {

    // ========================================
    // SIDEBAR TOGGLE (Mobile)
    // ========================================
    const sidebarToggle = document.querySelector('.navbar-toggle');
    const sidebar = document.querySelector('.admin-sidebar');
    const overlay = document.createElement('div');
    overlay.className = 'sidebar-overlay';

    if (sidebarToggle && sidebar) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');

            // Mobile overlay ekle
            if (sidebar.classList.contains('active')) {
                document.body.appendChild(overlay);
                overlay.classList.add('active');
            } else {
                overlay.classList.remove('active');
                setTimeout(() => {
                    if (document.body.contains(overlay)) {
                        document.body.removeChild(overlay);
                    }
                }, 300);
            }
        });

        // Overlay'e tıklayınca sidebar'ı kapat
        overlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            overlay.classList.remove('active');
            setTimeout(() => {
                if (document.body.contains(overlay)) {
                    document.body.removeChild(overlay);
                }
            }, 300);
        });
    }

    // ========================================
    // ACTIVE MENU ITEM
    // ========================================
    const currentPath = window.location.pathname;
    const menuLinks = document.querySelectorAll('.sidebar-menu-link');

    menuLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });

    // ========================================
    // AUTO HIDE ALERTS
    // ========================================
    const alerts = document.querySelectorAll('.alert-dismissible');

    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-20px)';
            setTimeout(() => {
                alert.remove();
            }, 300);
        }, 5000);
    });

    // ========================================
    // CONFIRM DELETE
    // ========================================
    const deleteButtons = document.querySelectorAll('[data-confirm-delete]');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            const message = this.getAttribute('data-confirm-delete') || 'Bu kaydı silmek istediğinize emin misiniz?';

            if (!confirm(message)) {
                e.preventDefault();
                return false;
            }
        });
    });

    // ========================================
    // TOOLTIPS (Simple implementation)
    // ========================================
    const tooltipElements = document.querySelectorAll('[data-tooltip]');

    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltipText = this.getAttribute('data-tooltip');
            const tooltip = document.createElement('div');
            tooltip.className = 'custom-tooltip';
            tooltip.textContent = tooltipText;
            document.body.appendChild(tooltip);

            const rect = this.getBoundingClientRect();
            tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
            tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + 'px';

            this._tooltip = tooltip;
        });

        element.addEventListener('mouseleave', function() {
            if (this._tooltip) {
                this._tooltip.remove();
                delete this._tooltip;
            }
        });
    });

    // ========================================
    // SEARCH FUNCTIONALITY
    // ========================================
    const searchInput = document.querySelector('.navbar-search-input');

    if (searchInput) {
        let searchTimeout;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);

            searchTimeout = setTimeout(() => {
                const searchTerm = this.value.toLowerCase();
                console.log('Searching for:', searchTerm);
                // Buraya search fonksiyonu eklenebilir
            }, 500);
        });
    }

    // ========================================
    // TABLE ROW CLICK
    // ========================================
    const clickableRows = document.querySelectorAll('[data-href]');

    clickableRows.forEach(row => {
        row.style.cursor = 'pointer';

        row.addEventListener('click', function(e) {
            // Eğer tıklanan element button, a, input değilse
            if (!e.target.closest('button, a, input, select, textarea')) {
                const href = this.getAttribute('data-href');
                if (href) {
                    window.location.href = href;
                }
            }
        });
    });

    // ========================================
    // STAT CARD ANIMATION
    // ========================================
    const statValues = document.querySelectorAll('.stat-card-value');

    const animateValue = (element, start, end, duration) => {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            const value = Math.floor(progress * (end - start) + start);
            element.textContent = value.toLocaleString('tr-TR');
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    };

    // Intersection Observer ile görünür olduğunda animate et
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.dataset.animated) {
                const targetValue = parseInt(entry.target.textContent.replace(/\./g, ''));
                entry.target.textContent = '0';
                animateValue(entry.target, 0, targetValue, 1000);
                entry.target.dataset.animated = 'true';
            }
        });
    }, { threshold: 0.5 });

    statValues.forEach(stat => observer.observe(stat));

    // ========================================
    // COPY TO CLIPBOARD
    // ========================================
    const copyButtons = document.querySelectorAll('[data-copy]');

    copyButtons.forEach(button => {
        button.addEventListener('click', function() {
            const textToCopy = this.getAttribute('data-copy');

            navigator.clipboard.writeText(textToCopy).then(() => {
                // Başarı mesajı göster
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="bi bi-check-lg"></i> Kopyalandı!';

                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 2000);
            }).catch(err => {
                console.error('Kopyalama hatası:', err);
            });
        });
    });

    // ========================================
    // SMOOTH SCROLL
    // ========================================
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href === '#') return;

            e.preventDefault();
            const target = document.querySelector(href);

            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // ========================================
    // FORM VALIDATION HELPER
    // ========================================
    const forms = document.querySelectorAll('.needs-validation');

    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
        });
    });
});

// ========================================
// GLOBAL HELPER FUNCTIONS
// ========================================

/**
 * Toast notification göster
 */
function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    toast.className = `admin-toast ${type}`;
    toast.innerHTML = `
        <i class="bi bi-${type === 'success' ? 'check-circle' : 'x-circle'}-fill"></i>
        <span>${message}</span>
    `;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.classList.add('show');
    }, 100);

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, 3000);
}

/**
 * Loading spinner göster/gizle
 */
function toggleLoading(show = true) {
    let loader = document.querySelector('.admin-loader');

    if (show) {
        if (!loader) {
            loader = document.createElement('div');
            loader.className = 'admin-loader';
            loader.innerHTML = '<div class="spinner"></div>';
            document.body.appendChild(loader);
        }
        loader.classList.add('active');
    } else {
        if (loader) {
            loader.classList.remove('active');
        }
    }
}

/**
 * Confirm dialog
 */
function confirmAction(message, callback) {
    if (confirm(message)) {
        callback();
    }
}

/**
 * Format number
 */
function formatNumber(num) {
    return new Intl.NumberFormat('tr-TR').format(num);
}

/**
 * Format currency
 */
function formatCurrency(amount) {
    return new Intl.NumberFormat('tr-TR', {
        style: 'currency',
        currency: 'TRY'
    }).format(amount);
}

/**
 * Format date
 */
function formatDate(date) {
    return new Intl.DateTimeFormat('tr-TR', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    }).format(new Date(date));
}
