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

    .customer-link {
        color: #212529;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .customer-link:hover {
        color: #0d6efd;
    }

    .dataTables_length, .dataTables_filter {
        padding: 1rem 1.25rem;
    }

    .dataTables_info, .dataTables_paginate {
        padding: 1rem 1.25rem;
    }
    .dt-buttons {
        margin-bottom: 1rem;
    }
    .dt-buttons .btn {
        margin-left: 0.5rem;
        margin-right: 0.5rem;
    }
    .btn-secondary {
        border: 1px solid #dcdcdc;
        background: #f8f8f8;
        color: #333;
    }
    .btn-secondary:hover {
        background: #e7e7e7;
    }
        .dataTables_paginate .paginate_button {
        padding: 0px 2px;
        margin: 0 2px;
        border-radius: 6px;
        cursor: pointer;
    }

    .dataTables_paginate .paginate_button.current {
        background: #1f3c88 !important;
        color: white !important;
        border-color: #1f3c88 !important;
    }

    .dataTables_paginate .paginate_button:hover:not(.current) {
        background: #f1f1f1;
    }
    .filter-card,
    .main-card {
        background: #ffffff;
        border: 1px solid #dcdcdc;
        border-radius: 8px;
    }
    .main-card .card-body {
        padding: 1.5rem;
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
                <p class="text-muted mb-0 small" id="policyCount">
                    Toplam <strong>{{ number_format($policies->count()) }}</strong> poliçe listeleniyor
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
            <div class="row g-3">
                <!-- Poliçe Türü -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small text-muted mb-1">Poliçe Türü</label>
                    <select id="filterPolicyType" class="form-select">
                        <option value="">Tüm Türler</option>
                        <option value="Kasko">Kasko</option>
                        <option value="Trafik">Trafik</option>
                        <option value="Konut">Konut</option>
                        <option value="DASK">DASK</option>
                        <option value="Sağlık">Sağlık</option>
                        <option value="Hayat">Hayat</option>
                        <option value="TSS">TSS</option>
                    </select>
                </div>

                <!-- Durum -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small text-muted mb-1">Durum</label>
                    <select id="filterStatus" class="form-select">
                        <option value="">Tüm Durumlar</option>
                        <option value="Aktif">Aktif</option>
                        <option value="Yaklaşan">Yaklaşan</option>
                        <option value="Kritik">Kritik</option>
                        <option value="Dolmuş">Dolmuş</option>
                        <option value="Yenilendi">Yenilendi</option>
                        <option value="İptal">İptal</option>
                    </select>
                </div>

                <!-- Sigorta Şirketi -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label small text-muted mb-1">Sigorta Şirketi</label>
                    <select id="filterCompany" class="form-select">
                        <option value="">Tüm Şirketler</option>
                        @foreach($insuranceCompanies as $company)
                        <option value="{{ $company->code }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Başlangıç Tarihi -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small text-muted mb-1">Başlangıç Tarihi</label>
                    <input type="date" id="filterDateFrom" class="form-control">
                </div>

                <!-- Bitiş Tarihi -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small text-muted mb-1">Bitiş Tarihi</label>
                    <input type="date" id="filterDateTo" class="form-control">
                </div>

                <!-- Temizle Butonu -->
                <div class="col-lg-1 col-md-6">
                    <label class="form-label small text-muted mb-1 d-none d-md-block">&nbsp;</label>
                    <button type="button" class="btn btn-secondary w-100 action-btn" onclick="clearFilters()">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablo -->
    <div class="main-card card">
        <div class="card-body">
            <table id="policiesTable" class="table table-hover">
                <thead>
                    <tr>
                        <th width="50">#</th>
                            <th>Poliçe No</th>
                            <th>Müşteri</th>
                            <th>Tür</th>
                            <th>Şirket</th>
                            <th>Araç/Adres</th>
                            <th>Bitiş Tarihi</th>
                            <th>Prim Tutarı</th>
                            <th>Durum</th>
                            <th width="150">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach($policies as $index => $policy)
    <tr>
        <td></td>
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
                            <td data-sort="{{ $policy->end_date->format('Y-m-d') }}">
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
                            <td data-order="{{ $policy->premium_amount }}">
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

    const table = initDataTable('#policiesTable', {
        pageLength: 10,
        columnDefs: [
            { orderable: false, targets: [9] },
        ]
    });

    // Filtreler
    $('#filterPolicyType, #filterStatus, #filterCompany, #filterDateFrom, #filterDateTo').on('change', function() {
        const policyType = $('#filterPolicyType').val();
        const status = $('#filterStatus').val();
        const company = $('#filterCompany').val();
        const dateFrom = $('#filterDateFrom').val();
        const dateTo = $('#filterDateTo').val();

        // Tüm custom filtreleri temizle
        $.fn.dataTable.ext.search = [];

        // Poliçe türü filtresi
        if (policyType) {
            table.column(3).search(policyType);
        } else {
            table.column(3).search('');
        }

        // Durum filtresi
        if (status) {
            table.column(8).search(status);
        } else {
            table.column(8).search('');
        }

        // Şirket filtresi
        if (company) {
            table.column(4).search(company);
        } else {
            table.column(4).search('');
        }

        // Tarih filtresi
        if (dateFrom || dateTo) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const dateStr = data[6]; // Tarih sütunu
                    if (!dateStr || dateStr === '-') return true;

                    // İlk satırdaki tarihi parse et
                    const dateParts = dateStr.split('<br>')[0].trim().match(/\d{2}\.\d{2}\.\d{4}/);
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
        $('#policyCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> poliçe`);
    });

    // İlk yüklemede toplam sayıyı güncelle
    const info = table.page.info();
    $('#policyCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> poliçe`);
});

function clearFilters() {
    $('#filterPolicyType, #filterStatus, #filterCompany, #filterDateFrom, #filterDateTo').val('');

    // Tüm custom filtreleri temizle
    $.fn.dataTable.ext.search = [];

    const table = $('#policiesTable').DataTable();
    table.search('').columns().search('').draw();
}

function deletePolicy(policyId) {
    if (confirm(' DİKKAT!\n\nBu poliçeyi silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        const form = document.getElementById('deleteForm');
        form.action = '/panel/policies/' + policyId;
        form.submit();
    }
}
</script>
@endpush
