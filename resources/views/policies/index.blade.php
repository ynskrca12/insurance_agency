@extends('layouts.app')

@section('title', 'Poliçeler')

@push('styles')
<style>
    .page-header {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        border: 1px solid #dcdcdc;
        border-radius: 10px;
        background: #ffffff;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        border-color: #b0b0b0;
        transform: translateY(-2px);
    }

    .stat-card .card-body {
        padding: 1.25rem;
        text-align: center;
    }

    .stat-value {
        font-size: 1.75rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
    }

    .stat-label {
        font-size: 0.8125rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 500;
    }

    .filter-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        margin-bottom: 1.5rem;
    }

    .filter-card .card-body {
        padding: 1.5rem;
    }

    .table-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
    }

    .form-control,
    .form-select {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #999;
        box-shadow: 0 0 0 3px rgba(153, 153, 153, 0.1);
    }

    .input-group-text {
        background: #fafafa;
        border: 1px solid #dcdcdc;
        border-right: none;
        border-radius: 8px 0 0 8px;
        color: #6c757d;
    }

    .input-group .form-control {
        border-left: none;
        border-radius: 0 8px 8px 0;
    }

    .input-group .form-control:focus {
        border-left: 1px solid #999;
    }

    .table-modern {
        margin-bottom: 0;
    }

    .table-modern thead {
        background: #fafafa;
        border-bottom: 2px solid #e8e8e8;
    }

    .table-modern thead th {
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

    .table-modern tbody tr {
        transition: all 0.2s ease;
    }

    .table-modern tbody tr:hover {
        background: #f8f9fa;
    }

    .badge-modern {
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.8125rem;
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
    }

    .action-btn {
        border-radius: 8px;
        padding: 0.5rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #dcdcdc;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        border-color: #b0b0b0;
    }

    .btn-icon {
        width: 2rem;
        height: 2rem;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        border: 1px solid #dcdcdc;
        transition: all 0.3s ease;
    }

    .btn-icon:hover {
        transform: scale(1.05);
        border-color: #b0b0b0;
    }

    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state i {
        color: #d0d0d0;
        margin-bottom: 1.5rem;
    }

    .customer-link {
        color: #212529;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .customer-link:hover {
        color: #0d6efd;
    }

    .pagination {
        margin-top: 1.5rem;
    }

    @media (max-width: 768px) {
        .stat-card .card-body {
            padding: 1rem;
        }

        .stat-value {
            font-size: 1.5rem;
        }

        .filter-card .card-body {
            padding: 1rem;
        }

        .table-modern thead th,
        .table-modern tbody td {
            padding: 0.75rem;
            font-size: 0.875rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-1 fw-bold text-dark">
                    <i class="bi bi-file-earmark-text me-2"></i>Poliçe Yönetimi
                </h1>
                <p class="text-muted mb-0 small">
                    Toplam <strong>{{ number_format($policies->total()) }}</strong> poliçe listeleniyor
                </p>
            </div>
            <a href="{{ route('policies.create') }}" class="btn btn-primary action-btn">
                <i class="bi bi-plus-circle me-2"></i>Yeni Poliçe Ekle
            </a>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <div class="col-lg col-md-4 col-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="stat-value text-primary">{{ number_format($stats['total']) }}</div>
                    <div class="stat-label">Toplam Poliçe</div>
                </div>
            </div>
        </div>

        <div class="col-lg col-md-4 col-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="stat-value text-success">{{ number_format($stats['active']) }}</div>
                    <div class="stat-label">Aktif</div>
                </div>
            </div>
        </div>

        <div class="col-lg col-md-4 col-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="stat-value text-warning">{{ number_format($stats['expiring_soon']) }}</div>
                    <div class="stat-label">Süresi Yaklaşan</div>
                </div>
            </div>
        </div>

        <div class="col-lg col-md-4 col-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="stat-value text-danger">{{ number_format($stats['critical']) }}</div>
                    <div class="stat-label">Kritik</div>
                </div>
            </div>
        </div>

        <div class="col-lg col-md-4 col-6">
            <div class="stat-card card">
                <div class="card-body">
                    <div class="stat-value text-secondary">{{ number_format($stats['expired']) }}</div>
                    <div class="stat-label">Süresi Dolmuş</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="filter-card card">
        <div class="card-body">
            <form method="GET" action="{{ route('policies.index') }}" id="filterForm">
                <div class="row g-3">
                    <!-- Arama -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small text-muted mb-1">Arama</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text"
                                   class="form-control"
                                   name="search"
                                   placeholder="Poliçe no, plaka, müşteri..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Poliçe Türü -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small text-muted mb-1">Poliçe Türü</label>
                        <select name="policy_type" class="form-select">
                            <option value="">Tüm Türler</option>
                            <option value="kasko" {{ request('policy_type') === 'kasko' ? 'selected' : '' }}>Kasko</option>
                            <option value="trafik" {{ request('policy_type') === 'trafik' ? 'selected' : '' }}>Trafik</option>
                            <option value="konut" {{ request('policy_type') === 'konut' ? 'selected' : '' }}>Konut</option>
                            <option value="dask" {{ request('policy_type') === 'dask' ? 'selected' : '' }}>DASK</option>
                            <option value="saglik" {{ request('policy_type') === 'saglik' ? 'selected' : '' }}>Sağlık</option>
                            <option value="hayat" {{ request('policy_type') === 'hayat' ? 'selected' : '' }}>Hayat</option>
                            <option value="tss" {{ request('policy_type') === 'tss' ? 'selected' : '' }}>TSS</option>
                        </select>
                    </div>

                    <!-- Durum -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small text-muted mb-1">Durum</label>
                        <select name="status" class="form-select">
                            <option value="">Tüm Durumlar</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="expiring_soon" {{ request('status') === 'expiring_soon' ? 'selected' : '' }}>Yaklaşan</option>
                            <option value="critical" {{ request('status') === 'critical' ? 'selected' : '' }}>Kritik</option>
                            <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Süresi Dolmuş</option>
                            <option value="renewed" {{ request('status') === 'renewed' ? 'selected' : '' }}>Yenilendi</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>İptal</option>
                        </select>
                    </div>

                    <!-- Sigorta Şirketi -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small text-muted mb-1">Sigorta Şirketi</label>
                        <select name="insurance_company_id" class="form-select">
                            <option value="">Tüm Şirketler</option>
                            @foreach($insuranceCompanies as $company)
                            <option value="{{ $company->id }}" {{ request('insurance_company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tarih Filtresi -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small text-muted mb-1">Bitiş Tarihi</label>
                        <select name="date_filter" class="form-select">
                            <option value="">Tüm Tarihler</option>
                            <option value="expiring_30" {{ request('date_filter') === 'expiring_30' ? 'selected' : '' }}>30 Gün İçinde</option>
                            <option value="expiring_7" {{ request('date_filter') === 'expiring_7' ? 'selected' : '' }}>7 Gün İçinde</option>
                            <option value="expired" {{ request('date_filter') === 'expired' ? 'selected' : '' }}>Süresi Dolmuş</option>
                        </select>
                    </div>

                    <!-- Filtre Butonu -->
                    <div class="col-lg-1 col-md-6">
                        <label class="form-label small text-muted mb-1 d-none d-md-block">&nbsp;</label>
                        <button type="submit" class="btn btn-primary w-100 action-btn">
                            <i class="bi bi-funnel"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tablo -->
    <div class="table-card card">
        <div class="card-body p-0">
            @if($policies->isEmpty())
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <h5 class="text-muted mb-2">Poliçe Bulunamadı</h5>
                    <p class="text-muted mb-4">
                        @if(request()->hasAny(['search', 'policy_type', 'status', 'insurance_company_id', 'date_filter']))
                            Arama kriterlerinize uygun poliçe bulunamadı. Filtreleri değiştirip tekrar deneyin.
                        @else
                            Henüz hiç poliçe eklenmemiş. Yeni bir poliçe ekleyerek başlayın.
                        @endif
                    </p>
                    <div class="d-flex gap-2 justify-content-center">
                        @if(request()->hasAny(['search', 'policy_type', 'status', 'insurance_company_id', 'date_filter']))
                            <a href="{{ route('policies.index') }}" class="btn btn-light action-btn">
                                <i class="bi bi-x-circle me-2"></i>Filtreleri Temizle
                            </a>
                        @endif
                        <a href="{{ route('policies.create') }}" class="btn btn-primary action-btn">
                            <i class="bi bi-plus-circle me-2"></i>İlk Poliçeyi Ekle
                        </a>
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-modern">
                        <thead>
                            <tr>
                                <th>Poliçe No</th>
                                <th>Müşteri</th>
                                <th>Tür</th>
                                <th>Şirket</th>
                                <th>Araç/Adres</th>
                                <th>Bitiş Tarihi</th>
                                <th>Prim Tutarı</th>
                                <th>Durum</th>
                                <th class="text-center">İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($policies as $policy)
                            <tr>
                                <td>
                                    <strong class="text-primary">{{ $policy->policy_number }}</strong>
                                </td>
                                <td>
                                    <a href="{{ route('customers.show', $policy->customer) }}" class="customer-link">
                                        {{ $policy->customer->name }}
                                    </a>
                                    <br>
                                    <small class="text-muted">{{ $policy->customer->phone }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-modern bg-info">
                                        {{ $policy->policy_type_label }}
                                    </span>
                                </td>
                                <td>
                                    <span class="text-muted">{{ $policy->insuranceCompany->code }}</span>
                                </td>
                                <td>
                                    @if($policy->isVehiclePolicy())
                                        <strong>{{ $policy->vehicle_plate }}</strong><br>
                                        <small class="text-muted">{{ $policy->vehicle_brand }} {{ $policy->vehicle_model }}</small>
                                    @elseif($policy->isPropertyPolicy())
                                        <small class="text-muted">{{ Str::limit($policy->property_address, 30) }}</small>
                                    @else
                                        <small class="text-muted">-</small>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $policy->end_date->format('d.m.Y') }}</strong>
                                    <br>
                                    @php
                                        $daysLeft = $policy->days_until_expiry;
                                    @endphp
                                    @if($daysLeft > 0)
                                        <small class="text-muted">{{ $daysLeft }} gün kaldı</small>
                                    @elseif($daysLeft === 0)
                                        <small class="text-danger fw-semibold">Bugün bitiyor!</small>
                                    @else
                                        <small class="text-danger">{{ abs($daysLeft) }} gün önce</small>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ number_format($policy->premium_amount, 2) }} ₺</strong>
                                </td>
                                <td>
                                    @php
                                        $statusConfig = [
                                            'active' => ['color' => 'success', 'label' => 'Aktif', 'icon' => 'check-circle-fill'],
                                            'expiring_soon' => ['color' => 'warning', 'label' => 'Yaklaşan', 'icon' => 'clock-fill'],
                                            'critical' => ['color' => 'danger', 'label' => 'Kritik', 'icon' => 'exclamation-triangle-fill'],
                                            'expired' => ['color' => 'secondary', 'label' => 'Dolmuş', 'icon' => 'x-circle-fill'],
                                            'renewed' => ['color' => 'info', 'label' => 'Yenilendi', 'icon' => 'arrow-repeat'],
                                            'cancelled' => ['color' => 'dark', 'label' => 'İptal', 'icon' => 'slash-circle-fill'],
                                        ];
                                        $config = $statusConfig[$policy->status] ?? ['color' => 'secondary', 'label' => $policy->status, 'icon' => 'circle-fill'];
                                    @endphp
                                    <span class="badge badge-modern bg-{{ $config['color'] }}">
                                        <i class="bi bi-{{ $config['icon'] }}"></i>
                                        {{ $config['label'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('policies.show', $policy) }}"
                                           class="btn btn-light btn-icon"
                                           title="Detayları Görüntüle">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('policies.edit', $policy) }}"
                                           class="btn btn-light btn-icon"
                                           title="Düzenle">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button type="button"
                                                class="btn btn-light btn-icon text-danger"
                                                onclick="deletePolicy({{ $policy->id }})"
                                                title="Sil">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <!-- Pagination -->
    @if($policies->hasPages())
    <div class="d-flex justify-content-center">
        {{ $policies->links() }}
    </div>
    @endif
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function deletePolicy(policyId) {
    if (confirm('⚠️ DİKKAT!\n\nBu poliçeyi silmek istediğinizden emin misiniz?\n\n• Bu işlem geri alınamaz\n• Yenilenmiş poliçeler silinemez\n\nDevam etmek istiyor musunuz?')) {
        const form = document.getElementById('deleteForm');
        form.action = '/policies/' + policyId;

        // Loading overlay
        $('body').append(`
            <div class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                 style="background: rgba(0,0,0,0.5); z-index: 9999;">
                <div class="spinner-border text-light" style="width: 3rem; height: 3rem;"></div>
            </div>
        `);

        form.submit();
    }
}

$(document).ready(function() {
    // Select değişimi otomatik form gönderimi
    $('select[name="policy_type"], select[name="status"], select[name="insurance_company_id"], select[name="date_filter"]')
        .on('change', function() {
            $('#filterForm').submit();
        });

    // Arama input debounce (3+ karakter veya boş)
    let searchTimeout;
    $('input[name="search"]').on('input', function() {
        clearTimeout(searchTimeout);
        const value = $(this).val().trim();

        if (value.length >= 3 || value.length === 0) {
            searchTimeout = setTimeout(function() {
                $('#filterForm').submit();
            }, 600);
        }
    });

    // Arama inputuna enter tuşu
    $('input[name="search"]').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            $('#filterForm').submit();
        }
    });

    // İstatistik kartları animasyonu
    $('.stat-card').each(function(index) {
        $(this).css('opacity', '0');
        setTimeout(() => {
            $(this).animate({opacity: 1}, 400);
        }, index * 80);
    });

    // Tablo satırları fade-in animasyonu
    $('.table-modern tbody tr').each(function(index) {
        if (index < 10) { // İlk 10 satır için
            $(this).css('opacity', '0');
            setTimeout(() => {
                $(this).animate({opacity: 1}, 300);
            }, index * 50);
        }
    });
});
</script>
@endpush
