@extends('admin.layouts.app')

@section('title', 'Demo Kullanıcılar')
@section('page-title', 'Demo Kullanıcılar')

@section('content')

<!-- Page Header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Demo Kullanıcılar</h1>
        <p class="page-subtitle">Tüm demo hesaplarını görüntüleyin ve yönetin</p>
    </div>
</div>

<!-- Success Message -->
@if(session('success'))
<div class="admin-alert success" style="margin-bottom: 24px;">
    <i class="bi bi-check-circle-fill"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- Stats Cards -->
<div class="stats-grid" style="margin-bottom: 32px;">
    <div class="stat-card primary">
        <div class="stat-card-header">
            <span class="stat-card-title">Toplam Kayıt</span>
            <div class="stat-card-icon">
                <i class="bi bi-people"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $stats['total'] }}</div>
    </div>

    <div class="stat-card success">
        <div class="stat-card-header">
            <span class="stat-card-title">Aktif Demolar</span>
            <div class="stat-card-icon">
                <i class="bi bi-person-check"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $stats['active'] }}</div>
    </div>

    <div class="stat-card danger">
        <div class="stat-card-header">
            <span class="stat-card-title">Süresi Dolmuş</span>
            <div class="stat-card-icon">
                <i class="bi bi-clock-history"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $stats['expired'] }}</div>
    </div>

    <div class="stat-card warning">
        <div class="stat-card-header">
            <span class="stat-card-title">Bugün Kayıt</span>
            <div class="stat-card-icon">
                <i class="bi bi-calendar-check"></i>
            </div>
        </div>
        <div class="stat-card-value">{{ $stats['today'] }}</div>
    </div>
</div>

<!-- Users Table -->
<div class="data-card">
    <div class="data-card-header">
        <h3 class="data-card-title">
            Demo Kullanıcılar
        </h3>
    </div>
    <div class="data-card-body">
        <table id="demoUsersTable" class="display responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Firma</th>
                    <th>Ad Soyad</th>
                    <th>E-posta</th>
                    <th>Telefon</th>
                    <th>Şehir</th>
                    <th>Kayıt Tarihi</th>
                    <th>Demo Bitiş</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($demoUsers as $demoUser)
                <tr>
                    <!-- Firma -->
                    <td>{{ $demoUser->company_name }}</td>

                    <!-- Ad Soyad -->
                    <td>{{ $demoUser->full_name }}</td>

                    <!-- E-posta -->
                    <td>
                        <a href="mailto:{{ $demoUser->email }}" style="color: var(--admin-primary); text-decoration: none;">
                            {{ $demoUser->email }}
                        </a>
                    </td>

                    <!-- Telefon -->
                    <td>
                        <a href="tel:{{ $demoUser->phone }}" style="color: var(--admin-dark); text-decoration: none;">
                            {{ $demoUser->phone }}
                        </a>
                    </td>

                    <!-- Şehir -->
                    <td>{{ $demoUser->city ?: '-' }}</td>

                    <!-- Kayıt Tarihi -->
                    <td data-order="{{ $demoUser->created_at->timestamp }}">
                        {{ $demoUser->created_at->format('d.m.Y H:i') }}
                    </td>

                    <!-- Demo Bitiş -->
                    <td data-order="{{ $demoUser->trial_ends_at ? $demoUser->trial_ends_at->timestamp : 0 }}">
                        {{ $demoUser->trial_ends_at ? $demoUser->trial_ends_at->format('d.m.Y H:i') : '-' }}
                    </td>

                    <!-- Durum -->
                    <td>
                        @if($demoUser->trial_ends_at && $demoUser->trial_ends_at->isFuture())
                        <span class="badge-active">Aktif</span>
                        @else
                        <span class="badge-expired">Süresi Doldu</span>
                        @endif
                    </td>

                    <!-- İşlemler -->
                    <td>
                        <div class="action-buttons">
                            <a
                                href="{{ route('admin.demo-users.show', $demoUser) }}"
                                class="btn-action btn-view"
                                title="Detaylar"
                            >
                                <i class="bi bi-eye"></i>
                            </a>

                            <form
                                method="POST"
                                action="{{ route('admin.demo-users.destroy', $demoUser) }}"
                                style="display: inline;"
                                onsubmit="return confirm('Bu kullanıcıyı ve TÜM VERİLERİNİ silmek istediğinize emin misiniz?')"
                            >
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn-action btn-delete"
                                    title="Sil"
                                >
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('styles')
<style>
/* DataTables Custom Styling */
.dataTables_wrapper {
    font-family: 'Inter', sans-serif;
}

/* Search Box */
.dataTables_filter {
    margin-bottom: 20px;
}

.dataTables_filter label {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 600;
    color: var(--admin-dark);
}

.dataTables_filter input {
    padding: 10px 16px;
    border: 2px solid var(--admin-border);
    border-radius: 10px;
    font-size: 14px;
    width: 300px;
    transition: all 0.3s ease;
}

.dataTables_filter input:focus {
    outline: none;
    border-color: var(--admin-primary);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

/* Length Menu */
.dataTables_length {
    margin-bottom: 20px;
}

.dataTables_length label {
    display: flex;
    align-items: center;
    gap: 12px;
    font-weight: 600;
    color: var(--admin-dark);
}

.dataTables_length select {
    padding: 8px 32px 8px 12px;
    border: 2px solid var(--admin-border);
    border-radius: 10px;
    font-size: 14px;
    background: white;
    cursor: pointer;
}

/* Info & Pagination Container */
.dataTables_info,
.dataTables_paginate {
    margin-top: 20px;
    padding-top: 20px;
    border-top: 1px solid var(--admin-border);
}

.dataTables_info {
    color: #64748b;
    font-size: 14px;
}

/* Pagination */
.dataTables_paginate {
    display: flex;
    gap: 8px;
}

.dataTables_paginate .paginate_button {
    padding: 8px 14px;
    border: 2px solid var(--admin-border);
    border-radius: 8px;
    background: white;
    color: var(--admin-dark);
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-block;
}

.dataTables_paginate .paginate_button:hover {
    background: var(--admin-primary);
    border-color: var(--admin-primary);
    color: white;
}

.dataTables_paginate .paginate_button.current {
    background: var(--admin-primary);
    border-color: var(--admin-primary);
    color: white;
}

.dataTables_paginate .paginate_button.disabled {
    opacity: 0.5;
    cursor: not-allowed;
}

.dataTables_paginate .paginate_button.disabled:hover {
    background: white;
    border-color: var(--admin-border);
    color: var(--admin-dark);
}

/* Table */
table.dataTable {
    width: 100% !important;
    border-collapse: separate;
    border-spacing: 0;
}

table.dataTable thead th {
    background: var(--admin-light);
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 16px;
    border-bottom: 2px solid var(--admin-border);
    text-align: left;
}

table.dataTable tbody td {
    padding: 16px;
    border-bottom: 1px solid var(--admin-border);
    font-size: 14px;
    color: var(--admin-dark);
    vertical-align: middle;
}

table.dataTable tbody tr:hover {
    background: var(--admin-light);
}

/* Sorting Icons */
table.dataTable thead .sorting,
table.dataTable thead .sorting_asc,
table.dataTable thead .sorting_desc {
    position: relative;
    cursor: pointer;
}

table.dataTable thead .sorting:after,
table.dataTable thead .sorting_asc:after,
table.dataTable thead .sorting_desc:after {
    position: absolute;
    right: 8px;
    font-family: 'Bootstrap Icons';
    font-size: 12px;
    opacity: 0.5;
}

table.dataTable thead .sorting:after {
    content: "\f229";
}

table.dataTable thead .sorting_asc:after {
    content: "\f145";
    opacity: 1;
    color: var(--admin-primary);
}

table.dataTable thead .sorting_desc:after {
    content: "\f148";
    opacity: 1;
    color: var(--admin-primary);
}

/* Custom Badges */
.badge-active {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: rgba(16, 185, 129, 0.1);
    color: var(--admin-success);
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}

.badge-active:before {
    content: "\f26a";
    font-family: 'Bootstrap Icons';
}

.badge-expired {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: rgba(239, 68, 68, 0.1);
    color: var(--admin-danger);
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}

.badge-expired:before {
    content: "\f623";
    font-family: 'Bootstrap Icons';
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 8px;
    justify-content: center;
}

.btn-action {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-view {
    background: rgba(37, 99, 235, 0.1);
    color: var(--admin-primary);
}

.btn-view:hover {
    background: var(--admin-primary);
    color: white;
    transform: translateY(-2px);
}

.btn-delete {
    background: rgba(239, 68, 68, 0.1);
    color: var(--admin-danger);
}

.btn-delete:hover {
    background: var(--admin-danger);
    color: white;
    transform: translateY(-2px);
}

/* Processing Indicator */
.dataTables_processing {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px 40px;
    border: 2px solid var(--admin-border);
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    font-weight: 600;
    color: var(--admin-primary);
}

/* Empty State */
.dataTables_empty {
    padding: 80px 40px !important;
    text-align: center;
    color: #64748b;
}

/* Responsive */
@media (max-width: 768px) {
    .dataTables_filter input {
        width: 100%;
    }

    .dataTables_length,
    .dataTables_filter {
        text-align: center;
    }

    .dataTables_length label,
    .dataTables_filter label {
        flex-direction: column;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#demoUsersTable').DataTable({
        // Dil Ayarları (Türkçe)
        language: {
            search: "Ara:",
            lengthMenu: "Göster _MENU_ kayıt",
            info: "Toplam _TOTAL_ kayıttan _START_ - _END_ arası gösteriliyor",
            infoEmpty: "Kayıt bulunamadı",
            infoFiltered: "(_MAX_ kayıt içinden filtrelendi)",
            zeroRecords: "Eşleşen kayıt bulunamadı",
            emptyTable: "Tabloda veri bulunmuyor",
            paginate: {
                first: "İlk",
                previous: "Önceki",
                next: "Sonraki",
                last: "Son"
            },
            processing: "İşleniyor..."
        },

        // Sayfalama
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "Tümü"]],

        // Sıralama
        order: [[5, 'desc']], // Kayıt tarihine göre azalan

        // Responsive
        responsive: true,

        // Column Definitions
        columnDefs: [
            {
                targets: [8], // İşlemler sütunu
                orderable: false,
                searchable: false
            },
            {
                targets: [7], // Durum sütunu
                orderable: false
            }
        ],

        // Dom Layout
        dom: '<"row"<"col-sm-6"l><"col-sm-6"f>>rt<"row"<"col-sm-6"i><"col-sm-6"p>>',

        // Processing
        processing: true,

        // Auto Width
        autoWidth: false
    });
});
</script>
@endpush
