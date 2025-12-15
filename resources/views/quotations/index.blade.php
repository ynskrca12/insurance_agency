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

    .table-card .card-body {
        padding: 1.5rem;
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

    /* DataTables */
    .dataTables_length, .dataTables_filter {
        padding: 1rem 1.25rem;
    }

    .dataTables_info, .dataTables_paginate {
        padding: 1rem 1.25rem;
    }

    .btn-secondary {
        border: 1px solid #dcdcdc;
        background: #f8f8f8;
        color: #333;
    }

    .btn-secondary:hover {
        background: #e7e7e7;
    }
    .dt-buttons .btn {
        margin-right: 0.5rem;
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
                <p class="text-muted mb-0 small" id="quotationCount">
                    Toplam <strong>{{ $quotations->count() }}</strong> teklif bulundu
                </p>
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
            <div class="row g-3 align-items-end">
                <!-- Durum -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Durum</label>
                    <select id="filterStatus" class="form-select">
                        <option value="">Tümü</option>
                        <option value="Taslak">Taslak</option>
                        <option value="Gönderildi">Gönderildi</option>
                        <option value="Görüntülendi">Görüntülendi</option>
                        <option value="Onaylandı">Onaylandı</option>
                        <option value="Reddedildi">Reddedildi</option>
                        <option value="Dönüştürüldü">Dönüştürüldü</option>
                        <option value="Süresi Doldu">Süresi Doldu</option>
                    </select>
                </div>

                <!-- Tür -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Teklif Türü</label>
                    <select id="filterQuotationType" class="form-select">
                        <option value="">Tümü</option>
                        <option value="Kasko">Kasko</option>
                        <option value="Trafik">Trafik</option>
                        <option value="Konut">Konut</option>
                        <option value="Dask">DASK</option>
                        <option value="Saglik">Sağlık</option>
                        <option value="Hayat">Hayat</option>
                        <option value="Tss">TSS</option>
                    </select>
                </div>

                <!-- Başlangıç Tarihi -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Başlangıç Tarihi</label>
                    <input type="date" id="filterDateFrom" class="form-control">
                </div>

                <!-- Bitiş Tarihi -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Bitiş Tarihi</label>
                    <input type="date" id="filterDateTo" class="form-control">
                </div>

                <!-- Temizle Butonu -->
                <div class="col-lg-1 col-md-12">
                    <button type="button" class="btn btn-secondary action-btn w-100" onclick="clearFilters()">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablo -->
    <div class="table-card card">
        <div class="card-body">
            <table class="table table-hover" id="quotationsTable">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Teklif No</th>
                        <th>Müşteri</th>
                        <th>Tür</th>
                        <th>Şirket</th>
                        <th>En Düşük</th>
                        <th>Geçerlilik</th>
                        <th>Görüntülenme</th>
                        <th>Durum</th>
                        <th width="150">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($quotations as $index => $quotation)
                    <tr>
                        <td></td> <!-- Boş, DataTables dolduracak -->
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
                        <td data-order="{{ $quotation->lowest_price_item ? $quotation->lowest_price_item->premium_amount : 0 }}">
                            @if($quotation->lowest_price_item)
                                <strong class="text-success">{{ number_format($quotation->lowest_price_item->premium_amount, 2) }} ₺</strong>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td data-sort="{{ $quotation->valid_until->format('Y-m-d') }}">
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
                        <td>
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // ✅ DataTable başlat
    const table = initDataTable('#quotationsTable', {
        order: [[6, 'desc']], // Geçerlilik tarihine göre sırala
        pageLength: 10,
        columnDefs: [
            { orderable: false, searchable: false, targets: 0 }, // Sıra numarası
            { orderable: false, targets: [9] }, // İşlemler
            { targets: 5, type: 'num' }, // En düşük fiyat
            { targets: 6, type: 'date' } // Geçerlilik tarihi
        ]
    });

    // ✅ Filtreler
    $('#filterStatus, #filterQuotationType, #filterDateFrom, #filterDateTo').on('change', function() {
        const status = $('#filterStatus').val();
        const quotationType = $('#filterQuotationType').val();
        const dateFrom = $('#filterDateFrom').val();
        const dateTo = $('#filterDateTo').val();

        // Tüm custom filtreleri temizle
        $.fn.dataTable.ext.search = [];

        // Durum filtresi
        if (status) {
            table.column(8).search(status);
        } else {
            table.column(8).search('');
        }

        // Tür filtresi
        if (quotationType) {
            table.column(3).search(quotationType);
        } else {
            table.column(3).search('');
        }

        // Tarih filtresi (geçerlilik tarihi)
        if (dateFrom || dateTo) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const dateStr = data[6]; // Geçerlilik sütunu
                    if (!dateStr || dateStr === '-') return true;

                    // Tarihi parse et
                    const dateParts = dateStr.match(/\d{2}\.\d{2}\.\d{4}/);
                    if (!dateParts) return true;

                    const parts = dateParts[0].split('.');
                    const rowDate = new Date(parts[2], parts[1] - 1, parts[0]);
                    const startDate = dateFrom ? new Date(dateFrom) : null;
                    const endDate = dateTo ? new Date(dateTo) : null;

                    if (startDate && rowDate < startDate) return false;
                    if (endDate && rowDate > endDate) return false;

                    return true;
                }
            );
        }

        table.draw();
    });

    // Sayfa değişince toplam sayıyı güncelle
    table.on('draw', function() {
        const info = table.page.info();
        $('#quotationCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> teklif`);
    });

    // İlk yüklemede toplam sayıyı güncelle
    const info = table.page.info();
    $('#quotationCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> teklif`);
});

function clearFilters() {
    $('#filterStatus, #filterQuotationType, #filterDateFrom, #filterDateTo').val('');
    $.fn.dataTable.ext.search = [];
    const table = $('#quotationsTable').DataTable();
    table.search('').columns().search('').draw();
}

function deleteQuotation(quotationId) {
    if (confirm('⚠️ Bu teklifi silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        const form = document.getElementById('deleteForm');
        form.action = '/panel/quotations/' + quotationId;
        form.submit();
    }
}

function copyShareLink(url) {
    navigator.clipboard.writeText(url).then(function() {
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
</script>
@endpush
