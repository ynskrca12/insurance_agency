@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stat-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        border-color: #b0b0b0;
        transform: translateY(-2px);
    }

    .stat-card .card-body {
        padding: 1.5rem;
    }

    .stat-icon {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        border: 1px solid #e8e8e8;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #212529;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.875rem;
        color: #6c757d;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-trend {
        font-size: 0.8125rem;
        font-weight: 500;
    }

    .content-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
    }

    .content-card .card-header {
        background: #fafafa;
        border-bottom: 1px solid #e8e8e8;
        padding: 1.25rem 1.5rem;
    }

    .content-card .card-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .table-modern {
        margin-bottom: 0;
    }

    .table-modern thead th {
        background: #f8f9fa;
        border: none;
        color: #495057;
        font-weight: 600;
        font-size: 0.8125rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 1.25rem;
    }

    .table-modern tbody td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #f5f5f5;
    }

    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    .table-modern tbody tr:hover {
        background: #fafafa;
    }

    .customer-list-item {
        padding: 1rem;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 1rem;
        text-decoration: none;
        color: inherit;
    }

    .customer-list-item:last-child {
        border-bottom: none;
    }

    .customer-list-item:hover {
        background: #f8f9fa;
        border-radius: 8px;
    }

    .customer-avatar {
        width: 3rem;
        height: 3rem;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
        font-weight: 600;
        border: 1px solid #e0e0e0;
        flex-shrink: 0;
    }

    .customer-info h6 {
        font-size: 0.9375rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.25rem;
    }

    .customer-info small {
        color: #6c757d;
        font-size: 0.8125rem;
    }

    .badge-modern {
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.8125rem;
    }

    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
        color: #6c757d;
    }

    .empty-state i {
        color: #d0d0d0;
        margin-bottom: 1rem;
    }

    .quick-action-btn {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .quick-action-btn:hover {
        border-color: #b0b0b0;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .stat-card .card-body {
            padding: 1.25rem;
        }

        .stat-icon {
            width: 3rem;
            height: 3rem;
            font-size: 1.5rem;
        }

        .stat-value {
            font-size: 1.75rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">

    <!-- İstatistik Kartları -->
    <div class="row g-4 mb-4">
        <!-- Toplam Müşteri -->
        <div class="col-lg-3 col-md-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="stat-label mb-2">Toplam Müşteri</div>
                            <div class="stat-value">{{ number_format($stats['total_customers']) }}</div>
                            <div class="stat-trend text-success">
                                <i class="bi bi-arrow-up me-1"></i>
                                <span>Aktif sistem</span>
                            </div>
                        </div>
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Toplam Poliçe -->
        <div class="col-lg-3 col-md-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="stat-label mb-2">Toplam Poliçe</div>
                            <div class="stat-value">{{ number_format($stats['total_policies']) }}</div>
                            <div class="stat-trend text-muted">
                                <i class="bi bi-graph-up me-1"></i>
                                <span>Tüm poliçeler</span>
                            </div>
                        </div>
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Süresi Yaklaşan -->
        <div class="col-lg-3 col-md-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="stat-label mb-2">Süresi Yaklaşan</div>
                            <div class="stat-value">{{ number_format($stats['expiring_soon']) }}</div>
                            <div class="stat-trend text-warning">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                <span>Dikkat gerekli</span>
                            </div>
                        </div>
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-clock-history"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bekleyen Görevler -->
        <div class="col-lg-3 col-md-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="stat-label mb-2">Bekleyen Görev</div>
                            <div class="stat-value">{{ number_format($stats['pending_tasks']) }}</div>
                            <div class="stat-trend text-danger">
                                <i class="bi bi-list-check me-1"></i>
                                <span>Yapılacaklar</span>
                            </div>
                        </div>
                        <div class="stat-icon bg-danger bg-opacity-10 text-danger">
                            <i class="bi bi-check-square"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- İçerik Kartları -->
    <div class="row g-4">
        <!-- Süresi Yaklaşan Poliçeler -->
        <div class="col-lg-8">
            <div class="content-card card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-exclamation-circle text-warning"></i>
                            <span>Süresi Yaklaşan Poliçeler</span>
                        </h5>
                        <a href="#" class="quick-action-btn btn-light">
                            <span>Tümünü Gör</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($expiringPolicies->isEmpty())
                        <div class="empty-state">
                            <i class="bi bi-check-circle"></i>
                            <h6 class="text-muted mb-1">Harika!</h6>
                            <p class="text-muted small mb-0">Süresi yaklaşan poliçe bulunmuyor.</p>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-modern">
                                <thead>
                                    <tr>
                                        <th>Müşteri</th>
                                        <th>Poliçe No</th>
                                        <th>Poliçe Türü</th>
                                        <th>Bitiş Tarihi</th>
                                        <th>Kalan Süre</th>
                                        <th>Durum</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($expiringPolicies as $policy)
                                    <tr>
                                        <td>
                                            <a href="{{ route('customers.show', $policy->customer) }}"
                                               class="text-decoration-none text-dark fw-semibold">
                                                {{ $policy->customer->name }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="text-muted">{{ $policy->policy_number }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-modern bg-info">
                                                {{ $policy->policy_type_label }}
                                            </span>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $policy->end_date->format('d.m.Y') }}
                                            </small>
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                {{ $policy->end_date->diffForHumans() }}
                                            </small>
                                        </td>
                                        <td>
                                            @if($policy->status === 'critical')
                                                <span class="badge badge-modern bg-danger">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                                    Kritik
                                                </span>
                                            @else
                                                <span class="badge badge-modern bg-warning">
                                                    <i class="bi bi-clock me-1"></i>
                                                    Yaklaşıyor
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Son Eklenen Müşteriler -->
        <div class="col-lg-4">
            <div class="content-card card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">
                            <i class="bi bi-person-plus text-primary"></i>
                            <span>Son Müşteriler</span>
                        </h5>
                        <a href="{{ route('customers.index') }}" class="quick-action-btn btn-light">
                            <span>Tümü</span>
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    @if($recentCustomers->isEmpty())
                        <div class="empty-state">
                            <i class="bi bi-people"></i>
                            <h6 class="text-muted mb-1">Müşteri Yok</h6>
                            <p class="text-muted small mb-3">Henüz müşteri eklenmemiş.</p>
                            <a href="{{ route('customers.create') }}" class="btn btn-sm btn-primary">
                                <i class="bi bi-plus-circle me-1"></i>
                                Müşteri Ekle
                            </a>
                        </div>
                    @else
                        <div class="customer-list">
                            @foreach($recentCustomers as $customer)
                            <a href="{{ route('customers.show', $customer) }}" class="customer-list-item">
                                <div class="customer-avatar bg-primary bg-opacity-10 text-primary">
                                    {{ strtoupper(mb_substr($customer->name, 0, 1)) }}
                                </div>
                                <div class="customer-info flex-grow-1">
                                    <h6 class="mb-0">{{ $customer->name }}</h6>
                                    <small>{{ $customer->phone }}</small>
                                </div>
                                <div>
                                    <i class="bi bi-chevron-right text-muted"></i>
                                </div>
                            </a>
                            @endforeach
                        </div>

                        <div class="px-3 py-3 bg-light border-top">
                            <a href="{{ route('customers.create') }}" class="btn btn-sm btn-primary w-100">
                                <i class="bi bi-plus-circle me-2"></i>
                                Yeni Müşteri Ekle
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Görev Özeti -->
<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Açık Görevlerim</small>
                        <h4 class="mb-0 text-primary">{{ $taskStats['my_open_tasks'] }}</h4>
                    </div>
                    <div class="text-primary" style="font-size: 2rem;">
                        <i class="bi bi-check2-square"></i>
                    </div>
                </div>
                <a href="{{ route('tasks.index', ['assigned_to' => 'me']) }}" class="stretched-link"></a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Gecikmiş Görevler</small>
                        <h4 class="mb-0 text-danger">{{ $taskStats['overdue_tasks'] }}</h4>
                    </div>
                    <div class="text-danger" style="font-size: 2rem;">
                        <i class="bi bi-exclamation-triangle"></i>
                    </div>
                </div>
                <a href="{{ route('tasks.index', ['assigned_to' => 'me', 'date_filter' => 'overdue']) }}" class="stretched-link"></a>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <small class="text-muted">Bugün Yapılacak</small>
                        <h4 class="mb-0 text-warning">{{ $taskStats['due_today'] }}</h4>
                    </div>
                    <div class="text-warning" style="font-size: 2rem;">
                        <i class="bi bi-calendar3"></i>
                    </div>
                </div>
                <a href="{{ route('tasks.index', ['assigned_to' => 'me', 'date_filter' => 'today']) }}" class="stretched-link"></a>
            </div>
        </div>
    </div>
</div>
    <!-- Hızlı Aksiyonlar -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="content-card card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-lightning text-primary"></i>
                        <span>Hızlı İşlemler</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ route('customers.create') }}" class="quick-action-btn btn-light d-flex flex-column align-items-center text-center p-3 w-100">
                                <i class="bi bi-person-plus-fill mb-2" style="font-size: 2rem;"></i>
                                <strong>Yeni Müşteri</strong>
                                <small class="text-muted">Müşteri ekle</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="quick-action-btn btn-light d-flex flex-column align-items-center text-center p-3 w-100">
                                <i class="bi bi-file-earmark-plus-fill mb-2" style="font-size: 2rem;"></i>
                                <strong>Yeni Poliçe</strong>
                                <small class="text-muted">Poliçe oluştur</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="quick-action-btn btn-light d-flex flex-column align-items-center text-center p-3 w-100">
                                <i class="bi bi-calculator-fill mb-2" style="font-size: 2rem;"></i>
                                <strong>Yeni Teklif</strong>
                                <small class="text-muted">Teklif hazırla</small>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6">
                            <a href="#" class="quick-action-btn btn-light d-flex flex-column align-items-center text-center p-3 w-100">
                                <i class="bi bi-graph-up-arrow mb-2" style="font-size: 2rem;"></i>
                                <strong>Raporlar</strong>
                                <small class="text-muted">Rapor görüntüle</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // İstatistik kartlarını animasyonlu göster
    $('.stat-card').each(function(index) {
        $(this).css('opacity', '0');
        setTimeout(() => {
            $(this).animate({opacity: 1}, 400);
        }, index * 100);
    });

    // Kart hover efektleri
    $('.stat-card').hover(
        function() {
            $(this).find('.stat-icon').css('transform', 'scale(1.1)');
        },
        function() {
            $(this).find('.stat-icon').css('transform', 'scale(1)');
        }
    );

    // İkon animasyonları
    $('.stat-icon').css('transition', 'transform 0.3s ease');
});
</script>
@endpush
