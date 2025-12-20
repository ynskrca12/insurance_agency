@extends('admin.layouts.app')

@section('title', 'Blog Yazıları')
@section('page-title', 'Blog Yazıları')

@section('content')

<!-- Page Header -->
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">Blog Yazıları</h1>
            <p class="page-subtitle">Tüm blog yazılarını görüntüleyin ve yönetin</p>
        </div>
        <a href="{{ route('admin.blogs.create') }}" class="btn-primary">
            <i class="bi bi-plus-circle"></i>
            Yeni Blog Ekle
        </a>
    </div>
</div>

<!-- Success Message -->
@if(session('success'))
<div class="admin-alert success" style="margin-bottom: 24px;">
    <i class="bi bi-check-circle-fill"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- Blogs Table -->
<div class="data-card">
    <div class="data-card-header">
        <h3 class="data-card-title">Blog Yazıları</h3>
    </div>
    <div class="data-card-body">
        <table id="blogsTable" class="display responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Görsel</th>
                    <th>Başlık</th>
                    <th>Etiketler</th>
                    <th>Yayın Tarihi</th>
                    <th>Durum</th>
                    <th>İşlemler</th>
                </tr>
            </thead>
            <tbody>
                @foreach($blogs as $blog)
                <tr>
                    <!-- Görsel -->
                    <td>
                        @if($blog->featured_image)
                        <img
                            src="{{ $blog->getImageUrl() }}"
                            alt="{{ $blog->title }}"
                            class="blog-thumbnail"
                        >
                        @else
                        <div class="blog-thumbnail-placeholder">
                            <i class="bi bi-image"></i>
                        </div>
                        @endif
                    </td>

                    <!-- Başlık -->
                    <td>
                        <div class="blog-title">{{ $blog->title }}</div>
                        @if($blog->is_featured)
                        <span class="badge-featured">
                            <i class="bi bi-star-fill"></i> Öne Çıkan
                        </span>
                        @endif
                    </td>

                    <!-- Etiketler -->
                    <td>
                        @if($blog->tags && count($blog->tags) > 0)
                        <div class="blog-tags">
                            @foreach(array_slice($blog->tags, 0, 2) as $tag)
                            <span class="badge-tag">{{ $tag }}</span>
                            @endforeach
                            @if(count($blog->tags) > 2)
                            <span class="badge-more">+{{ count($blog->tags) - 2 }}</span>
                            @endif
                        </div>
                        @else
                        <span class="text-muted">-</span>
                        @endif
                    </td>

                    <!-- Yayın Tarihi -->
                    <td data-order="{{ $blog->published_at ? $blog->published_at->timestamp : 0 }}">
                        {{ $blog->published_at ? $blog->published_at->format('d.m.Y H:i') : '-' }}
                    </td>

                    <!-- Durum -->
                    <td>
                        @if($blog->isPublished())
                        <span class="badge-published">Yayında</span>
                        @else
                        <span class="badge-draft">Taslak</span>
                        @endif
                    </td>

                    <!-- İşlemler -->
                    <td>
                        <div class="action-buttons">
                            <!-- Görüntüle -->
                            <a
                                href="{{ $blog->getUrl() }}"
                                target="_blank"
                                class="btn-action btn-view"
                                title="Görüntüle"
                            >
                                <i class="bi bi-eye"></i>
                            </a>

                            <!-- Düzenle -->
                            <a
                                href="{{ route('admin.blogs.edit', $blog) }}"
                                class="btn-action btn-edit"
                                title="Düzenle"
                            >
                                <i class="bi bi-pencil"></i>
                            </a>

                            <!-- Sil -->
                            <form
                                method="POST"
                                action="{{ route('admin.blogs.destroy', $blog) }}"
                                style="display: inline;"
                                onsubmit="return confirm('Bu blog yazısını silmek istediğinize emin misiniz?')"
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

/* Blog Thumbnail */
.blog-thumbnail {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 8px;
    display: block;
}

.blog-thumbnail-placeholder {
    width: 50px;
    height: 50px;
    background: var(--admin-light);
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
}

.blog-thumbnail-placeholder i {
    font-size: 20px;
}

/* Blog Title */
.blog-title {
    font-weight: 600;
    margin-bottom: 4px;
    max-width: 400px;
}

/* Badges */
.badge-featured {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    padding: 4px 10px;
    background: rgba(245, 158, 11, 0.1);
    color: var(--admin-warning);
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
}

.badge-tag {
    display: inline-block;
    padding: 4px 10px;
    background: rgba(16, 185, 129, 0.1);
    color: var(--admin-success);
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    margin-right: 4px;
    margin-bottom: 4px;
}

.badge-more {
    display: inline-block;
    padding: 4px 10px;
    background: #e2e8f0;
    color: #64748b;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
}

.badge-published {
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

.badge-published:before {
    content: "\f26a";
    font-family: 'Bootstrap Icons';
}

.badge-draft {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 12px;
    background: rgba(245, 158, 11, 0.1);
    color: var(--admin-warning);
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}

.badge-draft:before {
    content: "\f4be";
    font-family: 'Bootstrap Icons';
}

/* Blog Tags Container */
.blog-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
}

/* Text Muted */
.text-muted {
    color: #94a3b8;
    font-size: 12px;
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

.btn-edit {
    background: rgba(16, 185, 129, 0.1);
    color: var(--admin-success);
}

.btn-edit:hover {
    background: var(--admin-success);
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

    .blog-title {
        max-width: 200px;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#blogsTable').DataTable({
        // Dil Ayarları (Türkçe)
        language: {
            search: "Ara:",
            lengthMenu: "Göster _MENU_ kayıt",
            info: "Toplam _TOTAL_ kayıttan _START_ - _END_ arası gösteriliyor",
            infoEmpty: "Kayıt bulunamadı",
            infoFiltered: "(_MAX_ kayıt içinden filtrelendi)",
            zeroRecords: "Eşleşen kayıt bulunamadı",
            emptyTable: "Henüz blog yazısı yok. İlk blog yazınızı oluşturmak için 'Yeni Blog Ekle' butonuna tıklayın.",
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

        // Sıralama (Yayın tarihine göre azalan)
        order: [[3, 'desc']],

        // Responsive
        responsive: true,

        // Column Definitions
        columnDefs: [
            {
                targets: [0], // Görsel sütunu
                orderable: false,
                searchable: false
            },
            {
                targets: [5], // İşlemler sütunu
                orderable: false,
                searchable: false
            },
            {
                targets: [4], // Durum sütunu
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
