@extends('layouts.app')

@section('title', 'Sigorta Şirketleri')

@push('styles')
<style>
    .page-header {
        padding: 12px 0;
        margin-bottom: 1rem;
    }

    .stat-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        padding: 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        border-color: #b0b0b0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
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
        background: #ffffff;
        border: 1px solid #dcdcdc;
        border-right: none;
        color: #6c757d;
    }

    .input-group .form-control {
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

    .company-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        transition: all 0.3s ease;
        height: 100%;
        overflow: hidden;
    }

    .company-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.12);
        border-color: #b0b0b0;
    }

    .company-card .card-body {
        padding: 1.5rem;
        text-align: center;
    }

    .company-logo {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 1rem;
        margin-bottom: 1rem;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .company-logo img {
        max-height: 80px;
        max-width: 100%;
        object-fit: contain;
    }

    .company-logo-placeholder {
        color: #9ca3af;
        font-size: 2.5rem;
    }

    .company-name {
        font-size: 1.125rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .company-code {
        padding: 0.25rem 0.75rem;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
        color: #495057;
        display: inline-block;
    }

    .status-badge {
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.8125rem;
        display: inline-block;
    }

    .contact-info {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 0.75rem;
        margin-bottom: 1rem;
        text-align: left;
    }

    .contact-item {
        font-size: 0.8125rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .contact-item:last-child {
        margin-bottom: 0;
    }

    .contact-item i {
        color: #9ca3af;
        width: 1rem;
    }

    .stats-box {
        background: #e8f4fd;
        border: 1px solid #b3d9ff;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .stats-value {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0d6efd;
        line-height: 1;
        margin-bottom: 0.25rem;
    }

    .stats-label {
        font-size: 0.75rem;
        color: #0066cc;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    .card-actions {
        display: grid;
        gap: 0.5rem;
    }

    .btn-detail {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
        background: #ffffff;
        color: #0dcaf0;
    }

    .btn-detail:hover {
        background: #0dcaf0;
        border-color: #0dcaf0;
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-group-modern {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 0.5rem;
    }

    .btn-icon {
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        padding: 0.5rem;
        background: #ffffff;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .btn-icon:hover {
        transform: translateY(-1px);
    }

    .btn-icon.btn-edit {
        color: #ffc107;
        border-color: #ffc107;
    }

    .btn-icon.btn-edit:hover {
        background: #ffc107;
        color: #ffffff;
    }

    .btn-icon.btn-toggle {
        color: #6c757d;
        border-color: #6c757d;
    }

    .btn-icon.btn-toggle:hover {
        background: #6c757d;
        color: #ffffff;
    }

    .btn-icon.btn-toggle.active {
        color: #28a745;
        border-color: #28a745;
    }

    .btn-icon.btn-toggle.active:hover {
        background: #28a745;
        color: #ffffff;
    }

    .btn-icon.btn-delete {
        color: #dc3545;
        border-color: #dc3545;
    }

    .btn-icon.btn-delete:hover {
        background: #dc3545;
        color: #ffffff;
    }

    .empty-state {
        padding: 5rem 2rem;
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

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .company-card {
        animation: fadeInUp 0.4s ease forwards;
    }

    @media (max-width: 768px) {
        .stat-value {
            font-size: 1.5rem;
        }

        .stats-value {
            font-size: 1.25rem;
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
                <h1 class="h4 mb-1 fw-bold text-dark">
                    <i class="bi bi-building me-2"></i>Sigorta Şirketleri
                </h1>
                <p class="text-muted mb-0 small">Toplam {{ $companies->total() }} şirket kaydı bulundu</p>
            </div>
            <a href="{{ route('insurance-companies.create') }}" class="btn btn-primary action-btn">
                <i class="bi bi-plus-circle me-2"></i>Yeni Şirket
            </a>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-primary">{{ number_format($stats['total']) }}</div>
                <div class="stat-label">Toplam Şirket</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-success">{{ number_format($stats['active']) }}</div>
                <div class="stat-label">Aktif</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-secondary">{{ number_format($stats['inactive']) }}</div>
                <div class="stat-label">Pasif</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-info">{{ number_format($stats['total_policies']) }}</div>
                <div class="stat-label">Toplam Poliçe</div>
            </div>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="filter-card card">
        <div class="card-body">
            <form method="GET" action="{{ route('insurance-companies.index') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-lg-6 col-md-12">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text"
                                   class="form-control"
                                   name="search"
                                   placeholder="Şirket adı veya kodu ile ara..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-8">
                        <select name="is_active" class="form-select">
                            <option value="">Tüm Durumlar</option>
                            <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif Şirketler</option>
                            <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Pasif Şirketler</option>
                        </select>
                    </div>

                    <div class="col-lg-2 col-md-4">
                        <button type="submit" class="btn btn-primary action-btn w-100">
                            <i class="bi bi-funnel me-2"></i>Filtrele
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Şirket Kartları -->
    <div class="row g-4">
        @forelse($companies as $company)
        <div class="col-xl-3 col-lg-4 col-md-6">
            <div class="company-card card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="company-logo">
                        @if($company->logo)
                            <img src="{{ asset('insurance_companies/' . $company->logo) }}"
                                 alt="{{ $company->name }}">
                        @else
                            <i class="bi bi-building company-logo-placeholder"></i>
                        @endif
                    </div>

                    <!-- Şirket Bilgileri -->
                    <h5 class="company-name">{{ $company->name }}</h5>
                    <div class="mb-3">
                        <span class="company-code">{{ $company->code }}</span>
                    </div>

                    <!-- Durum -->
                    <div class="mb-3">
                        <span class="badge status-badge bg-{{ $company->status_color }}">
                            {{ $company->status_label }}
                        </span>
                    </div>

                    <!-- İletişim -->
                    @if($company->phone || $company->email)
                    <div class="contact-info">
                        @if($company->phone)
                        <div class="contact-item">
                            <i class="bi bi-telephone"></i>
                            <span>{{ $company->phone }}</span>
                        </div>
                        @endif
                        @if($company->email)
                        <div class="contact-item">
                            <i class="bi bi-envelope"></i>
                            <span>{{ $company->email }}</span>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- İstatistikler -->
                    <div class="stats-box">
                        <div class="stats-value">{{ number_format($company->policies_count) }}</div>
                        <div class="stats-label">Poliçe Sayısı</div>
                    </div>

                    <!-- Butonlar -->
                    <div class="card-actions">
                        <a href="{{ route('insurance-companies.show', $company) }}"
                           class="btn btn-detail">
                            <i class="bi bi-eye me-2"></i>Detay Görüntüle
                        </a>
                        <div class="btn-group-modern">
                            <a href="{{ route('insurance-companies.edit', $company) }}"
                               class="btn-icon btn-edit"
                               title="Düzenle">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <button type="button"
                                    class="btn-icon btn-toggle {{ $company->is_active ? '' : 'active' }}"
                                    onclick="toggleStatus({{ $company->id }}, {{ $company->is_active ? 'false' : 'true' }})"
                                    title="{{ $company->is_active ? 'Pasif Yap' : 'Aktif Yap' }}">
                                <i class="bi bi-power"></i>
                            </button>
                            <button type="button"
                                    class="btn-icon btn-delete"
                                    onclick="deleteCompany({{ $company->id }})"
                                    title="Sil">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="company-card card">
                <div class="card-body">
                    <div class="empty-state">
                        <i class="bi bi-building"></i>
                        <h5>Sigorta Şirketi Bulunamadı</h5>
                        <p>Henüz hiç sigorta şirketi eklenmemiş.</p>
                        <a href="{{ route('insurance-companies.create') }}" class="btn btn-primary action-btn">
                            <i class="bi bi-plus-circle me-2"></i>İlk Şirketi Ekle
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($companies->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $companies->links() }}
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
function deleteCompany(companyId) {
    if (confirm('⚠️ Bu sigorta şirketini silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        // Loading overlay
        $('body').append(`
            <div class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                 style="background: rgba(0,0,0,0.5); z-index: 9999;">
                <div class="spinner-border text-light" style="width: 3rem; height: 3rem;"></div>
            </div>
        `);

        const form = document.getElementById('deleteForm');
        form.action = '/panel/insurance-companies/' + companyId;
        form.submit();
    }
}

function toggleStatus(companyId, newStatus) {
    const statusText = newStatus === 'true' ? 'aktif' : 'pasif';

    if (confirm(`Bu şirketi ${statusText} yapmak istediğinizden emin misiniz?`)) {
        $.ajax({
            url: `/panel/insurance-companies/${companyId}/toggle-status`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert('Bir hata oluştu: ' + response.message);
                }
            },
            error: function() {
                alert('Durum değiştirilemedi. Lütfen tekrar deneyin.');
            }
        });
    }
}

$(document).ready(function() {
    // Filtre değişimi otomatik gönderim
    $('select[name="is_active"]').on('change', function() {
        $('#filterForm').submit();
    });

    // Arama input debounce
    let searchTimeout;
    $('input[name="search"]').on('input', function() {
        clearTimeout(searchTimeout);
        const value = $(this).val();

        if (value.length >= 2 || value.length === 0) {
            searchTimeout = setTimeout(function() {
                $('#filterForm').submit();
            }, 600);
        }
    });
});
</script>
@endpush
