@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<!-- Page Header -->
<div class="page-header">
    <h1 class="page-title">Dashboard</h1>
    <p class="page-subtitle">Sigorta Yönetim Sistemi - Genel Bakış</p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <!-- Total Demo Users -->
    <div class="stat-card primary">
        <div class="stat-card-header">
            <span class="stat-card-title">Toplam Demo Kullanıcı</span>
            <div class="stat-card-icon">
                <i class="bi bi-people"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $stats['total_demo_users'] ?? 0 }}</div>
        <div class="stat-card-change up">
            <i class="bi bi-arrow-up"></i>
            <span>+12% bu ay</span>
        </div>
    </div>

    <!-- Active Demo Users -->
    <div class="stat-card success">
        <div class="stat-card-header">
            <span class="stat-card-title">Aktif Demo Hesapları</span>
            <div class="stat-card-icon">
                <i class="bi bi-person-check"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $stats['active_demo_users'] ?? 0 }}</div>
        <div class="stat-card-change up">
            <i class="bi bi-arrow-up"></i>
            <span>+8% bu ay</span>
        </div>
    </div>

    <!-- Total Blog Posts -->
    <div class="stat-card warning">
        <div class="stat-card-header">
            <span class="stat-card-title">Blog Yazıları</span>
            <div class="stat-card-icon">
                <i class="bi bi-file-text"></i>
            </div>
        </div>
        {{-- <div class="stat-card-value">{{ $stats['total_posts'] ?? 0 }}</div> --}}
        <div class="stat-card-change up">
            <i class="bi bi-arrow-up"></i>
            <span>+3 yeni yazı</span>
        </div>
    </div>

    <!-- Contact Messages -->
    <div class="stat-card danger">
        <div class="stat-card-header">
            <span class="stat-card-title">Yeni Mesajlar</span>
            <div class="stat-card-icon">
                <i class="bi bi-envelope"></i>
            </div>
        </div>
        <div class="stat-card-value"> 0</div>
        <div class="stat-card-change down">
            <i class="bi bi-arrow-down"></i>
            <span>-2% bu hafta</span>
        </div>
    </div>
</div>

<!-- Recent Demo Users & Quick Actions -->
<div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px; margin-bottom: 32px;">

    <!-- Recent Demo Users -->
    <div class="data-card">
        <div class="data-card-header">
            <h3 class="data-card-title">Son Demo Kayıtları</h3>
            <a href="{{ route('admin.demo-users.index') }}" class="btn-primary">
                Tümünü Gör
                <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="data-card-body" style="padding: 0;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Firma</th>
                        <th>E-posta</th>
                        <th>Telefon</th>
                        <th>Kayıt Tarihi</th>
                        <th>Durum</th>
                        <th>İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentDemoUsers ?? [] as $demoUser)
                    <tr>
                        <td>
                            <div style="font-weight: 600;">{{ $demoUser->company_name }}</div>
                            <div style="font-size: 12px; color: #64748b;">{{ $demoUser->full_name }}</div>
                        </td>
                        <td>{{ $demoUser->email }}</td>
                        <td>{{ $demoUser->phone }}</td>
                        <td>{{ $demoUser->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            @if($demoUser->trial_ends_at && $demoUser->trial_ends_at->isFuture())
                                <span class="badge success">Aktif</span>
                            @else
                                <span class="badge danger">Süresi Doldu</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.demo-users.show', $demoUser->id) }}"
                               class="btn-icon"
                               data-tooltip="Detaylar">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #64748b;">
                            <i class="bi bi-inbox" style="font-size: 48px; margin-bottom: 16px; display: block;"></i>
                            Henüz demo kullanıcı kaydı bulunmuyor.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="data-card">
        <div class="data-card-header">
            <h3 class="data-card-title">Hızlı İşlemler</h3>
        </div>
        <div class="data-card-body">
            <div class="quick-actions">
                <a href="{{ route('admin.blogs.create') }}" class="quick-action-card">
                    <div class="quick-action-icon primary">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                    <div class="quick-action-content">
                        <h4>Yeni Blog Yazısı</h4>
                        <p>Blog yazısı ekle</p>
                    </div>
                </a>

                <a href="{{ route('admin.demo-users.index') }}" class="quick-action-card">
                    <div class="quick-action-icon success">
                        <i class="bi bi-people"></i>
                    </div>
                    <div class="quick-action-content">
                        <h4>Demo Kullanıcılar</h4>
                        <p>Kullanıcıları yönet</p>
                    </div>
                </a>

                <a href="{{ route('admin.contact-messages.index') }}" class="quick-action-card">
                    <div class="quick-action-icon warning">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div class="quick-action-content">
                        <h4>Mesajlar</h4>
                        <p>İletişim mesajları</p>
                    </div>
                </a>

                <a href="{{ route('admin.settings') }}" class="quick-action-card">
                    <div class="quick-action-icon danger">
                        <i class="bi bi-gear"></i>
                    </div>
                    <div class="quick-action-content">
                        <h4>Ayarlar</h4>
                        <p>Sistem ayarları</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">

    <!-- Demo Registrations Chart -->
    <div class="data-card">
        <div class="data-card-header">
            <h3 class="data-card-title">Demo Kayıtları (Son 7 Gün)</h3>
        </div>
        <div class="data-card-body">
            <canvas id="demoRegistrationsChart" height="200"></canvas>
        </div>
    </div>

    <!-- Activity Overview -->
    <div class="data-card">
        <div class="data-card-header">
            <h3 class="data-card-title">Aktivite Özeti</h3>
        </div>
        <div class="data-card-body">
            <div class="activity-list">
                <div class="activity-item">
                    <div class="activity-icon primary">
                        <i class="bi bi-person-plus"></i>
                    </div>
                    <div class="activity-content">
                        <h4>Yeni Demo Kaydı</h4>
                        <p>{{ $stats['today_registrations'] ?? 0 }} kayıt bugün</p>
                    </div>
                    <div class="activity-time">2 saat önce</div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon success">
                        <i class="bi bi-file-text"></i>
                    </div>
                    <div class="activity-content">
                        <h4>Blog Yazısı Yayınlandı</h4>
                        {{-- <p>{{ $stats['published_today'] ?? 0 }} yazı bugün</p> --}}
                    </div>
                    <div class="activity-time">5 saat önce</div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon warning">
                        <i class="bi bi-envelope"></i>
                    </div>
                    <div class="activity-content">
                        <h4>Yeni İletişim Mesajı</h4>
                        <p> 0 mesaj bugün</p>
                    </div>
                    <div class="activity-time">1 gün önce</div>
                </div>

                <div class="activity-item">
                    <div class="activity-icon danger">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="activity-content">
                        <h4>Demo Süresi Doldu</h4>
                        <p>{{ $stats['expired_demos'] ?? 0 }} hesap süresi doldu</p>
                    </div>
                    <div class="activity-time">2 gün önce</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
/* Admin Table */
.admin-table {
    width: 100%;
    border-collapse: collapse;
}

.admin-table thead {
    background: var(--admin-light);
    border-bottom: 2px solid var(--admin-border);
}

.admin-table th {
    padding: 16px;
    text-align: left;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #64748b;
}

.admin-table td {
    padding: 16px;
    border-bottom: 1px solid var(--admin-border);
    font-size: 14px;
}

.admin-table tbody tr:hover {
    background: var(--admin-light);
}

.btn-icon {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    background: var(--admin-light);
    color: var(--admin-dark);
    text-decoration: none;
    transition: all 0.3s ease;
}

.btn-icon:hover {
    background: var(--admin-primary);
    color: #ffffff;
}

/* Quick Actions */
.quick-actions {
    display: grid;
    gap: 16px;
}

.quick-action-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    border-radius: 12px;
    border: 1px solid var(--admin-border);
    text-decoration: none;
    transition: all 0.3s ease;
}

.quick-action-card:hover {
    border-color: var(--admin-primary);
    background: rgba(37, 99, 235, 0.02);
    transform: translateX(4px);
}

.quick-action-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}

.quick-action-icon.primary {
    background: rgba(37, 99, 235, 0.1);
    color: var(--admin-primary);
}

.quick-action-icon.success {
    background: rgba(16, 185, 129, 0.1);
    color: var(--admin-success);
}

.quick-action-icon.warning {
    background: rgba(245, 158, 11, 0.1);
    color: var(--admin-warning);
}

.quick-action-icon.danger {
    background: rgba(239, 68, 68, 0.1);
    color: var(--admin-danger);
}

.quick-action-content h4 {
    font-size: 14px;
    font-weight: 700;
    color: var(--admin-dark);
    margin-bottom: 4px;
}

.quick-action-content p {
    font-size: 12px;
    color: #64748b;
    margin: 0;
}

/* Activity List */
.activity-list {
    display: grid;
    gap: 16px;
}

.activity-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    border-radius: 12px;
    border: 1px solid var(--admin-border);
}

.activity-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

.activity-icon.primary {
    background: rgba(37, 99, 235, 0.1);
    color: var(--admin-primary);
}

.activity-icon.success {
    background: rgba(16, 185, 129, 0.1);
    color: var(--admin-success);
}

.activity-icon.warning {
    background: rgba(245, 158, 11, 0.1);
    color: var(--admin-warning);
}

.activity-icon.danger {
    background: rgba(239, 68, 68, 0.1);
    color: var(--admin-danger);
}

.activity-content {
    flex: 1;
}

.activity-content h4 {
    font-size: 14px;
    font-weight: 600;
    color: var(--admin-dark);
    margin-bottom: 4px;
}

.activity-content p {
    font-size: 12px;
    color: #64748b;
    margin: 0;
}

.activity-time {
    font-size: 12px;
    color: #94a3b8;
}
</style>
@endpush

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
// Demo Registrations Chart
const ctx = document.getElementById('demoRegistrationsChart');
if (ctx) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData['labels'] ?? ['Pzt', 'Sal', 'Çar', 'Per', 'Cum', 'Cmt', 'Paz']) !!},
            datasets: [{
                label: 'Demo Kayıtları',
                data: {!! json_encode($chartData['data'] ?? [12, 19, 15, 25, 22, 30, 28]) !!},
                borderColor: '#2563eb',
                backgroundColor: 'rgba(37, 99, 235, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointRadius: 6,
                pointHoverRadius: 8,
                pointBackgroundColor: '#2563eb',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    borderRadius: 8,
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 13
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: {
                            size: 12
                        }
                    }
                }
            }
        }
    });
}
</script>
@endpush
