@extends('layouts.app')

@section('title', 'Müşteriler')

@section('content')

<style>
    /* Mevcut stilleriniz aynen kalacak */
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

    .btn-secondary {
        border: 1px solid #dcdcdc;
        background: #f8f8f8;
        color: #333;
    }

    .btn-secondary:hover {
        background: #e7e7e7;
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
</style>

<style>

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

<!-- Tablo -->
<div class="main-card card">
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

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display:none">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
$(document).ready(function() {

    const table = initDataTable('#customersTable', {
        // order: [[6, 'desc']],
        pageLength: 10,
        columnDefs: [
            { orderable: false, targets: [7] },
            // {
            //     targets: 6,
            //     render: function(data, type, row) {
            //         if (type === 'sort') {
            //             // Sıralama için Y-m-d formatını kullan
            //             const parts = data.split('.');
            //             if (parts.length === 3) {
            //                 return parts[2] + '-' + parts[1] + '-' + parts[0];
            //             }
            //         }
            //         return data;
            //     }
            // }
        ]
    });

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
                    const dateStr = data[6]; // Tarih sütunu
                    if (!dateStr || dateStr === '-') return true;

                    // Tarihi parse et (d.m.Y formatından)
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
    });

    table.on('draw', function() {
        const info = table.page.info();
        $('#customerCount').text(`Gösterilen: ${info.recordsDisplay} / ${info.recordsTotal} müşteri`);
    });

    const info = table.page.info();
    $('#customerCount').text(`Gösterilen: ${info.recordsDisplay} / ${info.recordsTotal} müşteri`);
});

function clearFilters() {
    $('#filterStatus, #filterCity, #filterDateFrom, #filterDateTo').val('');

    // Tüm custom filtreleri temizle
    $.fn.dataTable.ext.search = [];

    const table = $('#customersTable').DataTable();
    table.search('').columns().search('').draw();
}

function deleteCustomer(id) {
    if (!confirm('Bu müşteriyi silmek istediğinize emin misiniz?')) return;
    const form = document.getElementById('deleteForm');
    form.action = '/panel/customers/' + id;
    form.submit();
}
</script>
@endpush
