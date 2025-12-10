@extends('layouts.app')

@section('title', 'Müşteriler')

@section('content')

<style>
    /* Kurumsal sade görünüm */

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
        padding: 0;
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

    .status-badge {
        padding: 6px 10px;
        font-size: 0.75rem;
        border-radius: 6px;
        font-weight: 500;
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

</style>

<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4 page-header">
    <div>
        <h1><i class="bi bi-people me-2"></i>Müşteriler</h1>
        <p>Toplam: {{ $customers->total() }} müşteri</p>
    </div>
    <a href="{{ route('customers.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>Yeni Müşteri
    </a>
</div>

<!-- Filtreler -->
<div class="filter-card card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('customers.index') }}" id="filterForm">
            <div class="row g-3 align-items-end">

                <div class="col-md-4">
                    <label class="form-label">Arama</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control" name="search"
                               placeholder="Ad, telefon, e-posta veya TC..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Durum</label>
                    <select name="status" class="form-select">
                        <option value="">Tümü</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="potential" {{ request('status') === 'potential' ? 'selected' : '' }}>Potansiyel</option>
                        <option value="passive" {{ request('status') === 'passive' ? 'selected' : '' }}>Pasif</option>
                        <option value="lost" {{ request('status') === 'lost' ? 'selected' : '' }}>Kayıp</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Şehir</label>
                    <select name="city" class="form-select">
                        <option value="">Tümü</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('city') === $city ? 'selected' : '' }}>{{ $city }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="bi bi-funnel me-1"></i>Filtrele
                    </button>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle me-1"></i>Temizle
                    </a>
                </div>

            </div>
        </form>
    </div>
</div>

<!-- Tablo -->
<div class="main-card card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
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
                @forelse($customers as $customer)
                <tr>
                    <td>
                        <strong>{{ $customer->name }}</strong>
                        @if($customer->isVIP())
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

                    <td>
                        <span class="badge bg-info">{{ $customer->total_policies }}</span>
                    </td>

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

                    <td>
                        <small>{{ $customer->created_at->format('d.m.Y') }}</small>
                    </td>

                    <td>
                        <a href="{{ route('customers.show', $customer) }}" class="action-btn" title="Detay">
                            <i class="bi bi-eye"></i>
                        </a>

                        <a href="{{ route('customers.edit', $customer) }}" class="action-btn" title="Düzenle">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <button class="action-btn"
                                onclick="deleteCustomer({{ $customer->id }})"
                                title="Sil">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty

                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                        <p class="mt-2 mb-1">Henüz müşteri bulunmuyor.</p>
                        <a href="{{ route('customers.create') }}" class="btn btn-primary btn-sm mt-2">
                            <i class="bi bi-plus-circle me-1"></i> İlk Müşteriyi Ekle
                        </a>
                    </td>
                </tr>

                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if($customers->hasPages())
<div class="mt-3">
    {{ $customers->links() }}
</div>
@endif

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display:none">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
function deleteCustomer(id) {
    if (!confirm('Bu müşteriyi silmek istediğinize emin misiniz?')) return;

    const form = document.getElementById('deleteForm');
    form.action = '/customers/' + id;
    form.submit();
}

$(function() {
    let timeout;
    $('input[name="search"]').on('input', function() {
        clearTimeout(timeout);
        const val = $(this).val();

        if (val.length >= 3 || val.length === 0) {
            timeout = setTimeout(() => $('#filterForm').submit(), 400);
        }
    });

    $('select[name="status"], select[name="city"]').on('change', function() {
        $('#filterForm').submit();
    });
});
</script>
@endpush
