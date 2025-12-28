@extends('layouts.app')

@section('title', 'Müşteriler')

@section('content')

<style>
    .page-header h1 {
        font-size: 1.4rem;
        font-weight: 600;
        color: #1f3c88;
    }

    .page-header p {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .filter-card,
    .main-card {
        background: #ffffff;
        border: 1px solid #dcdcdc;
        border-radius: 8px;
    }

    .filter-card .card-body {
        padding: 1.2rem 1.3rem;
    }

    .main-card .card-body {
        padding: 1.5rem;
    }

    .form-select,
    .form-control,
    .input-group-text {
        border: 1px solid #dcdcdc !important;
        border-radius: 6px;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #1f3c88 !important;
        box-shadow: none !important;
    }

    .btn-primary {
        background: #1f3c88;
        border-color: #1f3c88;
    }

    .btn-primary:hover {
        background: #162f6e;
        border-color: #162f6e;
    }

    .table thead {
        background: #f5f5f5;
    }

    .table th {
        font-size: 0.85rem;
        font-weight: 600;
        color: #1f3c88;
    }

    .table td {
        vertical-align: middle;
        font-size: 0.9rem;
    }

    .action-btn {
        border: 1px solid #dcdcdc;
        background: #ffffff;
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 6px;
        padding: 0;
    }

    .action-btn:hover {
        background: #f1f1f1;
    }

    .table-hover tbody tr:hover {
        background-color: #fafafa;
    }

    /* DataTables butonları özelleştirme */
    .dt-buttons {
        margin-bottom: 1rem;
    }

    .dt-buttons .btn {
        margin-right: 0.5rem;
    }

    .dataTables_length {
        float: left;
        padding: 10px 0;
    }

    .dataTables_length select {
        border: 1px solid #dcdcdc;
        border-radius: 6px;
        padding: 5px 10px;
        margin: 0 5px;
    }

    .dataTables_filter {
        float: right;
        padding: 10px 0;
    }

    .dataTables_filter input {
        border: 1px solid #dcdcdc;
        border-radius: 6px;
        padding: 5px 10px;
        margin-left: 5px;
    }

    .dataTables_info {
        padding: 10px 0;
    }

    .dataTables_paginate {
        padding: 10px 0;
        float: right;
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

    .dt-buttons {
        margin-bottom: 1rem;
        display: inline-block;
    }

    .dt-buttons .btn {
        margin-right: 0.5rem;
    }

    .dataTables_processing {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 200px;
        margin-left: -100px;
        margin-top: -26px;
        text-align: center;
        padding: 1rem;
        background: white;
        border: 1px solid #dcdcdc;
        border-radius: 6px;
    }

    /* ============================================
       MOBILE CARD VIEW - PROFESSIONAL
    ============================================ */
    .mobile-cards-container {
        display: none;
    }

    .customer-card {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 16px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        transition: all 0.3s ease;
    }

    .customer-card:active {
        transform: scale(0.98);
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.08);
    }

    .customer-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        margin-bottom: 12px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .customer-card-title {
        flex: 1;
    }

    .customer-card-name {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .customer-card-id {
        font-size: 12px;
        color: #64748b;
        font-weight: 500;
    }

    .customer-card-status {
        flex-shrink: 0;
    }

    .customer-card-body {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 12px;
    }

    .customer-info-row {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
    }

    .customer-info-icon {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #f1f5f9;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        flex-shrink: 0;
    }

    .customer-info-content {
        flex: 1;
        min-width: 0;
    }

    .customer-info-label {
        font-size: 11px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .customer-info-value {
        font-size: 14px;
        color: #1e293b;
        font-weight: 500;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .customer-card-stats {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
        padding: 12px 0;
        border-top: 1px solid #f1f5f9;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 12px;
    }

    .customer-stat-item {
        text-align: center;
    }

    .customer-stat-value {
        font-size: 20px;
        font-weight: 700;
        color: #1f3c88;
        margin-bottom: 2px;
    }

    .customer-stat-label {
        font-size: 11px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
    }

    .customer-card-actions {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }

    .customer-action-btn {
        padding: 10px;
        border: 1px solid #e2e8f0;
        background: white;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .customer-action-btn:active {
        transform: scale(0.95);
    }

    .customer-action-btn i {
        font-size: 18px;
        color: #475569;
    }

    .customer-action-btn span {
        font-size: 11px;
        color: #64748b;
        font-weight: 600;
    }

    .customer-action-btn.view {
        border-color: #3b82f6;
        background: #eff6ff;
    }

    .customer-action-btn.view i {
        color: #3b82f6;
    }

    .customer-action-btn.edit {
        border-color: #f59e0b;
        background: #fffbeb;
    }

    .customer-action-btn.edit i {
        color: #f59e0b;
    }

    .customer-action-btn.delete {
        border-color: #ef4444;
        background: #fef2f2;
    }

    .customer-action-btn.delete i {
        color: #ef4444;
    }

    /* VIP Badge */
    .vip-badge {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
        padding: 3px 8px;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Status Badges */
    .status-badge {
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* Mobile Search & Filter */
    .mobile-search-bar {
        display: none;
        position: sticky;
        top: 60px;
        z-index: 100;
        background: white;
        padding: 12px 16px;
        margin: -16px -16px 16px -16px;
        border-bottom: 1px solid #e2e8f0;
    }

    .mobile-search-input {
        width: 100%;
        padding: 10px 16px 10px 40px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        font-size: 14px;
        background: #f8fafc;
    }

    .mobile-search-input:focus {
        outline: none;
        border-color: #1f3c88;
        background: white;
    }

    .mobile-search-icon {
        position: absolute;
        left: 28px;
        top: 22px;
        color: #64748b;
    }

    .mobile-filter-btn {
        position: absolute;
        right: 28px;
        top: 18px;
        background: #1f3c88;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 8px;
        font-size: 14px;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }

    .empty-state i {
        font-size: 64px;
        color: #cbd5e1;
        margin-bottom: 16px;
    }

    .empty-state h3 {
        font-size: 18px;
        color: #475569;
        margin-bottom: 8px;
    }

    .empty-state p {
        font-size: 14px;
        color: #94a3b8;
    }

    /* ============================================
       RESPONSIVE - MOBILE VIEW
    ============================================ */
    @media (max-width: 768px) {
        /* Hide desktop table */
        .desktop-table-container {
            display: none !important;
        }

        /* Show mobile cards */
        .mobile-cards-container {
            display: block;
        }

        /* Show mobile search */
        .mobile-search-bar {
            display: block;
        }

        /* Page Header Mobile */
        .page-header {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 12px;
        }

        .page-header h1 {
            font-size: 1.2rem;
        }

        .page-header .btn {
            width: 100%;
        }

        /* Filter Card Mobile */
        .filter-card {
            margin-bottom: 16px;
        }

        .filter-card .card-body {
            padding: 12px;
        }

        .filter-card .row {
            gap: 12px;
        }

        .filter-card .col-md-2,
        .filter-card .col-md-4 {
            width: 100%;
        }

        .filter-card label {
            font-size: 12px;
            margin-bottom: 4px;
        }

        .filter-card .form-select,
        .filter-card .form-control {
            font-size: 14px;
        }

        /* Main Card Mobile */
        .main-card {
            border: none;
            background: transparent;
            box-shadow: none;
        }

        .main-card .card-body {
            padding: 0;
        }
    }

    /* Tablet */
    @media (min-width: 769px) and (max-width: 992px) {
        .customer-card-actions {
            grid-template-columns: repeat(3, 1fr);
        }
    }
</style>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4 page-header">
    <div>
        <h1><i class="bi bi-people me-2"></i>Müşteriler</h1>
        <p id="customerCount">Toplam: {{ $customers->count() }} müşteri</p>
    </div>
    <a href="{{ route('customers.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Yeni Müşteri
    </a>
</div>

<!-- Filtreler -->
<div class="filter-card card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-2">
                <label class="form-label">Durum</label>
                <select id="filterStatus" class="form-select">
                    <option value="">Tümü</option>
                    <option value="Aktif">Aktif</option>
                    <option value="Potansiyel">Potansiyel</option>
                    <option value="Pasif">Pasif</option>
                    <option value="Kayıp">Kayıp</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Şehir</label>
                <select id="filterCity" class="form-select">
                    <option value="">Tümü</option>
                    @foreach($cities as $city)
                        <option value="{{ $city }}">{{ $city }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label">Başlangıç Tarihi</label>
                <input type="date" id="filterDateFrom" class="form-control">
            </div>

            <div class="col-md-2">
                <label class="form-label">Bitiş Tarihi</label>
                <input type="date" id="filterDateTo" class="form-control">
            </div>

            <div class="col-md-4">
                <button type="button" class="btn btn-secondary" onclick="clearFilters()">
                    <i class="bi bi-x-circle me-1"></i>Temizle
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Desktop: Tablo Görünümü -->
<div class="main-card card desktop-table-container">
    <div class="card-body">
        <table id="customersTable" class="table table-hover">
            <thead>
                <tr>
                    <th width="50">#</th>
                    <th>Müşteri Adı</th>
                    <th>İletişim</th>
                    <th>Şehir</th>
                    <th>Poliçe Sayısı</th>
                    <th>Durum</th>
                    <th>Kayıt Tarihi</th>
                    <th width="150">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <strong>{{ $customer->name }}</strong>
                        @if($customer->policies_count >= 3)
                            <span class="badge bg-warning text-dark ms-1">VIP</span>
                        @endif
                    </td>
                    <td>
                        <div><i class="bi bi-telephone me-1"></i>{{ $customer->phone }}</div>
                        @if($customer->email)
                            <small class="text-muted"><i class="bi bi-envelope me-1"></i>{{ $customer->email }}</small>
                        @endif
                    </td>
                    <td>{{ $customer->city ?? '-' }}</td>
                    <td><span class="badge bg-info">{{ $customer->policies_count }}</span></td>
                    <td>
                        @php
                            $map = [
                                'active' => ['success','Aktif'],
                                'potential' => ['warning','Potansiyel'],
                                'passive' => ['secondary','Pasif'],
                                'lost' => ['danger','Kayıp'],
                            ];
                        @endphp
                        <span class="badge bg-{{ $map[$customer->status][0] }}">
                            {{ $map[$customer->status][1] }}
                        </span>
                    </td>
                    <td data-sort="{{ $customer->created_at->format('Y-m-d') }}">
                        {{ $customer->created_at->format('d.m.Y') }}
                    </td>
                    <td>
                        <a href="{{ route('customers.show', $customer) }}" class="action-btn" title="Detay">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('customers.edit', $customer) }}" class="action-btn" title="Düzenle">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button class="action-btn" onclick="deleteCustomer({{ $customer->id }})" title="Sil">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Mobile: Card Görünümü -->
<div class="mobile-cards-container">
    <!-- Mobile Search Bar -->
    <div class="mobile-search-bar">
        <i class="bi bi-search mobile-search-icon"></i>
        <input type="text" id="mobileSearch" class="mobile-search-input" placeholder="Müşteri ara...">
    </div>

    <!-- Customer Cards -->
    <div id="mobileCustomersList">
        @forelse($customers as $customer)
            @php
                $statusMap = [
                    'active' => ['success','Aktif'],
                    'potential' => ['warning','Potansiyel'],
                    'passive' => ['secondary','Pasif'],
                    'lost' => ['danger','Kayıp'],
                ];
                $statusClass = $statusMap[$customer->status][0];
                $statusText = $statusMap[$customer->status][1];
            @endphp

            <div class="customer-card" data-customer-id="{{ $customer->id }}">
                <!-- Card Header -->
                <div class="customer-card-header">
                    <div class="customer-card-title">
                        <div class="customer-card-name">
                            <span>{{ $customer->name }}</span>
                            @if($customer->policies_count >= 3)
                                <span class="vip-badge">VIP</span>
                            @endif
                        </div>
                        <div class="customer-card-id">#{{ $customer->id }}</div>
                    </div>
                    <div class="customer-card-status">
                        <span class="status-badge bg-{{ $statusClass }} text-white">{{ $statusText }}</span>
                    </div>
                </div>

                <!-- Card Body -->
                <div class="customer-card-body">
                    <!-- Phone -->
                    <div class="customer-info-row">
                        <div class="customer-info-icon">
                            <i class="bi bi-telephone"></i>
                        </div>
                        <div class="customer-info-content">
                            <div class="customer-info-label">Telefon</div>
                            <div class="customer-info-value">{{ $customer->phone }}</div>
                        </div>
                    </div>

                    <!-- Email -->
                    @if($customer->email)
                    <div class="customer-info-row">
                        <div class="customer-info-icon">
                            <i class="bi bi-envelope"></i>
                        </div>
                        <div class="customer-info-content">
                            <div class="customer-info-label">E-posta</div>
                            <div class="customer-info-value">{{ $customer->email }}</div>
                        </div>
                    </div>
                    @endif

                    <!-- City -->
                    <div class="customer-info-row">
                        <div class="customer-info-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <div class="customer-info-content">
                            <div class="customer-info-label">Şehir</div>
                            <div class="customer-info-value">{{ $customer->city ?? 'Belirtilmemiş' }}</div>
                        </div>
                    </div>
                </div>

                <!-- Stats -->
                <div class="customer-card-stats">
                    <div class="customer-stat-item">
                        <div class="customer-stat-value">{{ $customer->policies_count }}</div>
                        <div class="customer-stat-label">Poliçe</div>
                    </div>
                    <div class="customer-stat-item">
                        <div class="customer-stat-value">{{ $customer->created_at->format('d.m.Y') }}</div>
                        <div class="customer-stat-label">Kayıt Tarihi</div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="customer-card-actions">
                    <a href="{{ route('customers.show', $customer) }}" class="customer-action-btn view">
                        <i class="bi bi-eye"></i>
                        <span>Detay</span>
                    </a>
                    <a href="{{ route('customers.edit', $customer) }}" class="customer-action-btn edit">
                        <i class="bi bi-pencil"></i>
                        <span>Düzenle</span>
                    </a>
                    <button onclick="deleteCustomer({{ $customer->id }})" class="customer-action-btn delete">
                        <i class="bi bi-trash"></i>
                        <span>Sil</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="bi bi-people"></i>
                <h3>Müşteri Bulunamadı</h3>
                <p>Henüz müşteri kaydı bulunmamaktadır.</p>
            </div>
        @endforelse
    </div>
</div>

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display:none">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Desktop DataTable
    const table = initDataTable('#customersTable', {
        pageLength: 10,
        columnDefs: [
            { orderable: false, targets: [7] },
        ]
    });

    // Desktop Filters
    $('#filterStatus, #filterCity, #filterDateFrom, #filterDateTo').on('change', function() {
        const status = $('#filterStatus').val();
        const city = $('#filterCity').val();
        const dateFrom = $('#filterDateFrom').val();
        const dateTo = $('#filterDateTo').val();

        $.fn.dataTable.ext.search = [];

        if (status) {
            table.column(5).search(status);
        } else {
            table.column(5).search('');
        }

        if (city) {
            table.column(3).search(city);
        } else {
            table.column(3).search('');
        }

        if (dateFrom || dateTo) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const dateStr = data[6];
                    if (!dateStr || dateStr === '-') return true;

                    const dateParts = dateStr.split('.');
                    if (dateParts.length !== 3) return true;

                    const rowDate = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
                    const startDate = dateFrom ? new Date(dateFrom) : null;
                    const endDate = dateTo ? new Date(dateTo) : null;

                    if (startDate && rowDate < startDate) return false;
                    if (endDate && rowDate > endDate) return false;

                    return true;
                }
            );
        }

        table.draw();
        filterMobileCards();
    });

    table.on('draw', function() {
        const info = table.page.info();
        $('#customerCount').text(`Gösterilen: ${info.recordsDisplay} / ${info.recordsTotal} müşteri`);
    });

    const info = table.page.info();
    $('#customerCount').text(`Gösterilen: ${info.recordsDisplay} / ${info.recordsTotal} müşteri`);

    // Mobile Search
    $('#mobileSearch').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        filterMobileCards(searchTerm);
    });

    // Mobile Filter Function
    function filterMobileCards(searchTerm = '') {
        const status = $('#filterStatus').val();
        const city = $('#filterCity').val();

        let visibleCount = 0;

        $('.customer-card').each(function() {
            const $card = $(this);
            const cardText = $card.text().toLowerCase();
            const cardStatus = $card.find('.status-badge').text().trim();
            const cardCity = $card.find('.customer-info-value').eq(2).text().trim();

            let show = true;

            // Search filter
            if (searchTerm && !cardText.includes(searchTerm)) {
                show = false;
            }

            // Status filter
            if (status && cardStatus !== status) {
                show = false;
            }

            // City filter
            if (city && cardCity !== city) {
                show = false;
            }

            if (show) {
                $card.show();
                visibleCount++;
            } else {
                $card.hide();
            }
        });

        // Update count for mobile
        if (window.innerWidth <= 768) {
            $('#customerCount').text(`Gösterilen: ${visibleCount} / {{ $customers->count() }} müşteri`);
        }
    }
});

function clearFilters() {
    $('#filterStatus, #filterCity, #filterDateFrom, #filterDateTo').val('');
    $('#mobileSearch').val('');

    $.fn.dataTable.ext.search = [];

    const table = $('#customersTable').DataTable();
    table.search('').columns().search('').draw();

    // Reset mobile cards
    $('.customer-card').show();
    $('#customerCount').text(`Toplam: {{ $customers->count() }} müşteri`);
}

function deleteCustomer(id) {
    if (!confirm('Bu müşteriyi silmek istediğinize emin misiniz?')) return;
    const form = document.getElementById('deleteForm');
    form.action = '/panel/customers/' + id;
    form.submit();
}
</script>
@endpush
