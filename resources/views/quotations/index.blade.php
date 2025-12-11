@extends('layouts.app')

@section('title', 'Teklifler')

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
        border-radius: 12px;
        background: #ffffff;
        padding: 1.25rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        border-color: #b0b0b0;
        background: #fafafa;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        line-height: 1;
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
        overflow: hidden;
    }

    .filter-card .card-body {
        padding: 1.5rem;
    }

    .form-control,
    .form-select {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 0.625rem 0.875rem;
        font-size: 0.9375rem;
        transition: all 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #999;
        box-shadow: 0 0 0 3px rgba(153, 153, 153, 0.1);
    }

    .input-group-text {
        border: 1px solid #dcdcdc;
        border-right: none;
        background: #fafafa;
        color: #6c757d;
        border-radius: 8px 0 0 8px;
    }

    .input-group .form-control {
        border-left: none;
        border-radius: 0 8px 8px 0;
    }

    .input-group .form-control:focus {
        border-left: none;
    }

    .action-btn {
        border-radius: 8px;
        padding: 0.625rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #dcdcdc;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        border-color: #b0b0b0;
    }

    .btn-primary.action-btn {
        border-color: #0d6efd;
    }

    .table-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
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
        white-space: nowrap;
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

    .quotation-number {
        font-weight: 600;
        color: #0d6efd;
        font-size: 0.9375rem;
    }

    .customer-link {
        color: #212529;
        text-decoration: none;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .customer-link:hover {
        color: #0d6efd;
    }

    .badge-modern {
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.8125rem;
    }

    .badge-pill {
        border-radius: 50px;
    }

    .action-buttons {
        display: flex;
        gap: 0.25rem;
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
        background: #ffffff;
        color: #6c757d;
        transition: all 0.3s ease;
    }

    .btn-icon:hover {
        transform: translateY(-2px);
        border-color: #999;
    }

    .btn-icon.btn-view:hover {
        background: #0dcaf0;
        border-color: #0dcaf0;
        color: #ffffff;
    }

    .btn-icon.btn-edit:hover {
        background: #ffc107;
        border-color: #ffc107;
        color: #ffffff;
    }

    .btn-icon.btn-share:hover {
        background: #0d6efd;
        border-color: #0d6efd;
        color: #ffffff;
    }

    .btn-icon.btn-delete:hover {
        background: #dc3545;
        border-color: #dc3545;
        color: #ffffff;
    }

    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state i {
        color: #d0d0d0;
        margin-bottom: 1.5rem;
    }

    .empty-state h5 {
        color: #6c757d;
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .empty-state p {
        color: #9ca3af;
        margin-bottom: 1.5rem;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-row {
        animation: fadeIn 0.4s ease forwards;
    }

    @media (max-width: 768px) {
        .action-buttons {
            flex-wrap: wrap;
        }

        .table-modern {
            font-size: 0.875rem;
        }

        .stat-value {
            font-size: 1.5rem;
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
                    <i class="bi bi-file-earmark-text me-2"></i>Teklifler
                </h1>
                <p class="text-muted mb-0 small">Toplam {{ $quotations->total() }} teklif bulundu</p>
            </div>
            <a href="{{ route('quotations.create') }}" class="btn btn-primary action-btn">
                <i class="bi bi-plus-circle me-2"></i>Yeni Teklif Oluştur
            </a>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <div class="col-lg col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-value text-primary">{{ number_format($stats['total']) }}</div>
                <div class="stat-label">Toplam Teklif</div>
            </div>
        </div>
        <div class="col-lg col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-value text-info">{{ number_format($stats['sent']) }}</div>
                <div class="stat-label">Gönderildi</div>
            </div>
        </div>
        <div class="col-lg col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-value text-warning">{{ number_format($stats['approved']) }}</div>
                <div class="stat-label">Onaylandı</div>
            </div>
        </div>
        <div class="col-lg col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-value text-success">{{ number_format($stats['converted']) }}</div>
                <div class="stat-label">Dönüştürüldü</div>
            </div>
        </div>
        <div class="col-lg col-md-4 col-sm-6">
            <div class="stat-card">
                <div class="stat-value text-danger">{{ number_format($stats['expired']) }}</div>
                <div class="stat-label">Süresi Doldu</div>
            </div>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="filter-card card">
        <div class="card-body">
            <form method="GET" action="{{ route('quotations.index') }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    <!-- Arama -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Arama</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text"
                                   class="form-control"
                                   name="search"
                                   placeholder="Teklif no, müşteri ara..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Durum -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Durum</label>
                        <select name="status" class="form-select">
                            <option value="">Tümü</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Taslak</option>
                            <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Gönderildi</option>
                            <option value="viewed" {{ request('status') === 'viewed' ? 'selected' : '' }}>Görüntülendi</option>
                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Onaylandı</option>
                            <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                            <option value="converted" {{ request('status') === 'converted' ? 'selected' : '' }}>Dönüştürüldü</option>
                            <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Süresi Doldu</option>
                        </select>
                    </div>

                    <!-- Tür -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Teklif Türü</label>
                        <select name="quotation_type" class="form-select">
                            <option value="">Tümü</option>
                            <option value="kasko" {{ request('quotation_type') === 'kasko' ? 'selected' : '' }}>Kasko</option>
                            <option value="trafik" {{ request('quotation_type') === 'trafik' ? 'selected' : '' }}>Trafik</option>
                            <option value="konut" {{ request('quotation_type') === 'konut' ? 'selected' : '' }}>Konut</option>
                            <option value="dask" {{ request('quotation_type') === 'dask' ? 'selected' : '' }}>DASK</option>
                            <option value="saglik" {{ request('quotation_type') === 'saglik' ? 'selected' : '' }}>Sağlık</option>
                            <option value="hayat" {{ request('quotation_type') === 'hayat' ? 'selected' : '' }}>Hayat</option>
                            <option value="tss" {{ request('quotation_type') === 'tss' ? 'selected' : '' }}>TSS</option>
                        </select>
                    </div>

                    <!-- Geçerlilik -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Geçerlilik</label>
                        <select name="date_filter" class="form-select">
                            <option value="">Tümü</option>
                            <option value="valid" {{ request('date_filter') === 'valid' ? 'selected' : '' }}>Geçerli</option>
                            <option value="expired" {{ request('date_filter') === 'expired' ? 'selected' : '' }}>Süresi Dolmuş</option>
                        </select>
                    </div>

                    <!-- Sıralama -->
                    <div class="col-lg-2 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Sıralama</label>
                        <select name="sort" class="form-select">
                            <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>En Yeni</option>
                            <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>En Eski</option>
                            <option value="price_low" {{ request('sort') === 'price_low' ? 'selected' : '' }}>Fiyat (Düşük-Yüksek)</option>
                            <option value="price_high" {{ request('sort') === 'price_high' ? 'selected' : '' }}>Fiyat (Yüksek-Düşük)</option>
                        </select>
                    </div>

                    <!-- Filtrele Butonu -->
                    <div class="col-lg-1 col-md-12">
                        <button type="submit" class="btn btn-primary action-btn w-100">
                            <i class="bi bi-funnel"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tablo -->
    <div class="table-card card">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>Teklif No</th>
                        <th>Müşteri</th>
                        <th>Tür</th>
                        <th>Şirket</th>
                        <th>En Düşük</th>
                        <th>Geçerlilik</th>
                        <th>Görüntülenme</th>
                        <th>Durum</th>
                        <th class="text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotations as $quotation)
                    <tr class="fade-in-row">
                        <td>
                            <span class="quotation-number">{{ $quotation->quotation_number }}</span>
                        </td>
                        <td>
                            <a href="{{ route('customers.show', $quotation->customer) }}" class="customer-link">
                                {{ $quotation->customer->name }}
                            </a>
                            <br>
                            <small class="text-muted">{{ $quotation->customer->phone }}</small>
                        </td>
                        <td>
                            <span class="badge badge-modern badge-pill bg-info">
                                {{ ucfirst($quotation->quotation_type) }}
                            </span>
                        </td>
                        <td>
                            <strong>{{ $quotation->items->count() }}</strong>
                            <small class="text-muted">şirket</small>
                        </td>
                        <td>
                            @if($quotation->lowest_price_item)
                                <strong class="text-success">{{ number_format($quotation->lowest_price_item->premium_amount, 2) }} ₺</strong>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div class="fw-semibold">{{ $quotation->valid_until->format('d.m.Y') }}</div>
                            @if($quotation->isValid())
                                <small class="text-success">
                                    <i class="bi bi-check-circle-fill me-1"></i>Geçerli
                                </small>
                            @else
                                <small class="text-danger">
                                    <i class="bi bi-x-circle-fill me-1"></i>Doldu
                                </small>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $quotation->view_count }}</strong>
                            <small class="text-muted">kez</small>
                        </td>
                        <td>
                            @php
                                $statusConfig = [
                                    'draft' => ['color' => 'secondary', 'label' => 'Taslak'],
                                    'sent' => ['color' => 'info', 'label' => 'Gönderildi'],
                                    'viewed' => ['color' => 'primary', 'label' => 'Görüntülendi'],
                                    'approved' => ['color' => 'warning', 'label' => 'Onaylandı'],
                                    'rejected' => ['color' => 'danger', 'label' => 'Reddedildi'],
                                    'converted' => ['color' => 'success', 'label' => 'Dönüştürüldü'],
                                    'expired' => ['color' => 'dark', 'label' => 'Süresi Doldu'],
                                ];
                                $config = $statusConfig[$quotation->status] ?? ['color' => 'secondary', 'label' => $quotation->status];
                            @endphp
                            <span class="badge badge-modern bg-{{ $config['color'] }}">
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="action-buttons">
                                <a href="{{ route('quotations.show', $quotation) }}"
                                   class="btn-icon btn-view"
                                   title="Detay">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($quotation->status !== 'converted')
                                <a href="{{ route('quotations.edit', $quotation) }}"
                                   class="btn-icon btn-edit"
                                   title="Düzenle">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endif
                                <button type="button"
                                        class="btn-icon btn-share"
                                        onclick="copyShareLink('{{ $quotation->share_url }}')"
                                        title="Link Kopyala">
                                    <i class="bi bi-share"></i>
                                </button>
                                @if($quotation->status !== 'converted')
                                <button type="button"
                                        class="btn-icon btn-delete"
                                        onclick="deleteQuotation({{ $quotation->id }})"
                                        title="Sil">
                                    <i class="bi bi-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <i class="bi bi-inbox"></i>
                                <h5>Teklif Bulunamadı</h5>
                                <p class="mb-3">
                                    @if(request()->hasAny(['search', 'status', 'quotation_type', 'date_filter']))
                                        Arama kriterlerinize uygun teklif bulunamadı.
                                    @else
                                        Henüz hiç teklif oluşturulmamış.
                                    @endif
                                </p>
                                <a href="{{ route('quotations.create') }}" class="btn btn-primary action-btn">
                                    <i class="bi bi-plus-circle me-2"></i>İlk Teklifi Oluştur
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($quotations->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $quotations->links() }}
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
function deleteQuotation(quotationId) {
    if (confirm('⚠️ Bu teklifi silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        const form = document.getElementById('deleteForm');
        form.action = '/panel/quotations/' + quotationId;

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

function copyShareLink(url) {
    navigator.clipboard.writeText(url).then(function() {
        // Modern toast notification
        const toast = `
            <div class="alert alert-success alert-dismissible fade show" role="alert"
                 style="position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>Başarılı!</strong> Paylaşım linki kopyalandı.
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        $('body').append(toast);

        setTimeout(function() {
            $('.alert').fadeOut(300, function() { $(this).remove(); });
        }, 3000);
    }, function() {
        prompt('Linki manuel olarak kopyalayın:', url);
    });
}

$(document).ready(function() {
    // Filtre değişimi otomatik gönderim
    $('select[name="status"], select[name="quotation_type"], select[name="date_filter"], select[name="sort"]')
        .on('change', function() {
            $('#filterForm').submit();
        });

    // Arama input debounce
    let searchTimeout;
    $('input[name="search"]').on('input', function() {
        clearTimeout(searchTimeout);
        const value = $(this).val();

        if (value.length >= 3 || value.length === 0) {
            searchTimeout = setTimeout(function() {
                $('#filterForm').submit();
            }, 600);
        }
    });

    // Satır animasyonları
    let delay = 0;
    $('.fade-in-row').each(function() {
        $(this).css({
            'animation-delay': delay + 's',
            'opacity': '0'
        });
        delay += 0.05;
    });

    setTimeout(function() {
        $('.fade-in-row').css('opacity', '1');
    }, 50);
});
</script>
@endpush
