@extends('layouts.app')

@section('title', 'Sigorta Şirketleri')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">
            <i class="bi bi-building me-2"></i>Sigorta Şirketleri
        </h1>
        <p class="text-muted mb-0">Toplam: {{ $companies->total() }} şirket</p>
    </div>
    <a href="{{ route('insurance-companies.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Yeni Şirket
    </a>
</div>

<!-- İstatistik Kartları -->
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-primary">{{ number_format($stats['total']) }}</h3>
                <small class="text-muted">Toplam Şirket</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-success">{{ number_format($stats['active']) }}</h3>
                <small class="text-muted">Aktif</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-secondary">{{ number_format($stats['inactive']) }}</h3>
                <small class="text-muted">Pasif</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-info">{{ number_format($stats['total_policies']) }}</h3>
                <small class="text-muted">Toplam Poliçe</small>
            </div>
        </div>
    </div>
</div>

<!-- Filtreler -->
<div class="card mb-3 border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('insurance-companies.index') }}" id="filterForm">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text"
                               class="form-control border-start-0"
                               name="search"
                               placeholder="Şirket ara..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-4">
                    <select name="is_active" class="form-select">
                        <option value="">Tüm Durumlar</option>
                        <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Pasif</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-funnel"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Şirket Kartları -->
<div class="row g-3">
    @forelse($companies as $company)
    <div class="col-md-6 col-lg-4 col-xl-3">
        <div class="card border-0 shadow-sm h-100 hover-card">
            <div class="card-body text-center">
                <!-- Logo -->
                <div class="company-logo mb-3">
                    @if($company->logo)
                        <img src="{{ asset('storage/' . $company->logo) }}"
                             alt="{{ $company->name }}"
                             class="img-fluid rounded"
                             style="max-height: 80px; max-width: 150px;">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                             style="height: 80px;">
                            <i class="bi bi-building text-muted" style="font-size: 2rem;"></i>
                        </div>
                    @endif
                </div>

                <!-- Şirket Bilgileri -->
                <h5 class="card-title mb-1">{{ $company->name }}</h5>
                <p class="text-muted small mb-2">
                    <span class="badge bg-secondary">{{ $company->code }}</span>
                </p>

                <!-- Durum -->
                <div class="mb-3">
                    <span class="badge bg-{{ $company->status_color }}">
                        {{ $company->status_label }}
                    </span>
                </div>

                <!-- İletişim -->
                @if($company->phone || $company->email)
                <div class="text-start mb-3">
                    @if($company->phone)
                    <small class="text-muted d-block">
                        <i class="bi bi-telephone me-1"></i>{{ $company->phone }}
                    </small>
                    @endif
                    @if($company->email)
                    <small class="text-muted d-block">
                        <i class="bi bi-envelope me-1"></i>{{ $company->email }}
                    </small>
                    @endif
                </div>
                @endif

                <!-- İstatistikler -->
                <div class="bg-light p-2 rounded mb-3">
                    <div class="row text-center">
                        <div class="col-12">
                            <h4 class="mb-0 text-primary">{{ number_format($company->policies_count) }}</h4>
                            <small class="text-muted">Poliçe Sayısı</small>
                        </div>
                    </div>
                </div>

                <!-- Butonlar -->
                <div class="d-grid gap-2">
                    <a href="{{ route('insurance-companies.show', $company) }}"
                       class="btn btn-sm btn-outline-info">
                        <i class="bi bi-eye me-1"></i>Detay
                    </a>
                    <div class="btn-group">
                        <a href="{{ route('insurance-companies.edit', $company) }}"
                           class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <button type="button"
                                class="btn btn-sm btn-outline-{{ $company->is_active ? 'secondary' : 'success' }}"
                                onclick="toggleStatus({{ $company->id }}, {{ $company->is_active ? 'false' : 'true' }})">
                            <i class="bi bi-power"></i>
                        </button>
                        <button type="button"
                                class="btn btn-sm btn-outline-danger"
                                onclick="deleteCompany({{ $company->id }})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-building text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mb-3 mt-2">Henüz sigorta şirketi bulunmuyor.</p>
                <a href="{{ route('insurance-companies.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-2"></i>İlk Şirketi Ekle
                </a>
            </div>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($companies->hasPages())
<div class="mt-3">
    {{ $companies->links() }}
</div>
@endif

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('styles')
<style>
.hover-card {
    transition: transform 0.2s, box-shadow 0.2s;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
</style>
@endpush

@push('scripts')
<script>
function deleteCompany(companyId) {
    if (confirm('Bu şirketi silmek istediğinizden emin misiniz?')) {
        const form = document.getElementById('deleteForm');
        form.action = '/panel/insurance-companies/' + companyId;
        form.submit();
    }
}

function toggleStatus(companyId, newStatus) {
    const statusText = newStatus ? 'aktif' : 'pasif';
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
                alert('Durum değiştirilemedi.');
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
            }, 500);
        }
    });
});
</script>
@endpush
