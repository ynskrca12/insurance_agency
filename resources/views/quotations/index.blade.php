@extends('layouts.app')

@section('title', 'Teklifler')

@push('styles')
<style>
    .stat-card {
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        background: #ffffff;
        transition: all 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .stat-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .badge-status {
        padding: 0.35rem 0.75rem;
        font-size: 0.8125rem;
        font-weight: 500;
        border-radius: 6px;
    }

    .email-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
        background: #f1f5f9;
        color: #64748b;
    }

    .email-indicator.sent {
        background: #dbeafe;
        color: #1e40af;
    }

    .view-count {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        font-size: 0.75rem;
        color: #64748b;
    }

    .validity-badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
        border-radius: 4px;
    }

    .validity-badge.valid {
        background: #dcfce7;
        color: #166534;
    }

    .validity-badge.expired {
        background: #fee2e2;
        color: #991b1b;
    }

    .table-actions {
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
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">
                <i class="bi bi-file-earmark-text me-2"></i>Teklifler
            </h1>
            <p class="text-muted mb-0 small">Tüm sigorta tekliflerinizi yönetin</p>
        </div>
        <a href="{{ route('quotations.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Yeni Teklif
        </a>
    </div>

    <!-- Stats -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted small">Toplam Teklif</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['total'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-info bg-opacity-10 text-info me-3">
                        <i class="bi bi-send-check"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted small">Gönderildi</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['sent'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-warning bg-opacity-10 text-warning me-3">
                        <i class="bi bi-hand-thumbs-up"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted small">Onaylandı</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['approved'] }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="d-flex align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success me-3">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div>
                        <h6 class="mb-0 text-muted small">Dönüştürüldü</h6>
                        <h3 class="mb-0 fw-bold">{{ $stats['converted'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('quotations.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-semibold">Ara</label>
                    <input type="text"
                           class="form-control"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Teklif no, müşteri adı...">
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Durum</label>
                    <select class="form-select" name="status">
                        <option value="">Tümü</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Taslak</option>
                        <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Gönderildi</option>
                        <option value="viewed" {{ request('status') === 'viewed' ? 'selected' : '' }}>Görüntülendi</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Onaylandı</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                        <option value="converted" {{ request('status') === 'converted' ? 'selected' : '' }}>Dönüştürüldü</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Tür</label>
                    <select class="form-select" name="quotation_type">
                        <option value="">Tümü</option>
                        <option value="kasko" {{ request('quotation_type') === 'kasko' ? 'selected' : '' }}>Kasko</option>
                        <option value="trafik" {{ request('quotation_type') === 'trafik' ? 'selected' : '' }}>Trafik</option>
                        <option value="konut" {{ request('quotation_type') === 'konut' ? 'selected' : '' }}>Konut</option>
                        <option value="dask" {{ request('quotation_type') === 'dask' ? 'selected' : '' }}>DASK</option>
                        <option value="saglik" {{ request('quotation_type') === 'saglik' ? 'selected' : '' }}>Sağlık</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Başlangıç</label>
                    <input type="date" class="form-control" name="date_from" value="{{ request('date_from') }}">
                </div>

                <div class="col-md-2">
                    <label class="form-label small fw-semibold">Bitiş</label>
                    <input type="date" class="form-control" name="date_to" value="{{ request('date_to') }}">
                </div>

                <div class="col-md-1 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="quotationsTable">
                    <thead class="table-light">
                        <tr>
                            <th>Teklif No</th>
                            <th>Müşteri</th>
                            <th>Tür</th>
                            <th>Şirket Sayısı</th>
                            <th>En Düşük Fiyat</th>
                            <th>Email/Görüntüleme</th>
                            <th>Geçerlilik</th>
                            <th>Durum</th>
                            <th>Tarih</th>
                            <th class="text-center">İşlemler</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($quotations as $quotation)
                        <tr>
                            <td>
                                <a href="{{ route('quotations.show', $quotation) }}"
                                   class="text-decoration-none fw-semibold text-dark">
                                    {{ $quotation->quotation_number }}
                                </a>
                            </td>

                            <td>
                                <a href="{{ route('customers.show', $quotation->customer) }}"
                                   class="text-decoration-none text-dark">
                                    {{ $quotation->customer->name }}
                                </a>
                                <br>
                                <small class="text-muted">
                                    <i class="bi bi-telephone"></i> {{ $quotation->customer->phone }}
                                </small>
                            </td>

                            <td>
                                <span class="badge bg-info bg-opacity-10 text-info">
                                    {{ $quotation->typeDisplay }}
                                </span>
                            </td>

                            <td>
                                <span class="badge bg-primary bg-opacity-10 text-primary">
                                    {{ $quotation->items->count() }} firma
                                </span>
                            </td>

                            <td>
                                @if($quotation->lowest_price_item)
                                <strong class="text-success">
                                    {{ number_format($quotation->lowest_price_item->premium_amount, 2) }} ₺
                                </strong>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <!-- Email Durumu -->
                                    @if($quotation->email_sent_count > 0)
                                    <span class="email-indicator sent" title="Email gönderildi">
                                        <i class="bi bi-envelope-check-fill"></i>
                                        {{ $quotation->email_sent_count }}x
                                    </span>
                                    @else
                                    <span class="email-indicator" title="Email gönderilmedi">
                                        <i class="bi bi-envelope"></i>
                                        Gönderilmedi
                                    </span>
                                    @endif

                                    <!-- Görüntüleme -->
                                    @if($quotation->view_count > 0)
                                    <span class="view-count" title="Görüntülenme sayısı">
                                        <i class="bi bi-eye-fill"></i>
                                        {{ $quotation->view_count }}x
                                    </span>
                                    @endif
                                </div>
                            </td>

                            <td>
                                @if($quotation->isValid())
                                <span class="validity-badge valid">
                                    <i class="bi bi-check-circle-fill"></i>
                                    {{ $quotation->valid_until->format('d.m.Y') }}
                                </span>
                                @else
                                <span class="validity-badge expired">
                                    <i class="bi bi-x-circle-fill"></i>
                                    Doldu
                                </span>
                                @endif
                            </td>

                            <td>
                                @php
                                    $statusColors = [
                                        'draft' => 'secondary',
                                        'sent' => 'info',
                                        'viewed' => 'primary',
                                        'approved' => 'warning',
                                        'rejected' => 'danger',
                                        'converted' => 'success',
                                    ];
                                    $color = $statusColors[$quotation->status] ?? 'secondary';
                                @endphp
                                <span class="badge badge-status bg-{{ $color }}">
                                    {{ [
                                        'draft' => 'Taslak',
                                        'sent' => 'Gönderildi',
                                        'viewed' => 'Görüntülendi',
                                        'approved' => 'Onaylandı',
                                        'rejected' => 'Reddedildi',
                                        'converted' => 'Dönüştürüldü',
                                    ][$quotation->status] ?? $quotation->status }}
                                </span>
                            </td>

                            <td>
                                <small class="text-muted">
                                    {{ $quotation->created_at->format('d.m.Y') }}
                                    <br>
                                    {{ $quotation->created_at->format('H:i') }}
                                </small>
                            </td>

                            <td>
                                <div class="table-actions justify-content-center">
                                    <!-- Görüntüle -->
                                    <a href="{{ route('quotations.show', $quotation) }}"
                                       class="btn btn-sm btn-icon btn-info"
                                       title="Görüntüle">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <!-- Düzenle -->
                                    @if($quotation->status !== 'converted')
                                    <a href="{{ route('quotations.edit', $quotation) }}"
                                       class="btn btn-sm btn-icon btn-warning"
                                       title="Düzenle">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endif

                                    <!-- Email Gönder -->
                                    @if($quotation->status !== 'converted')
                                    <button type="button"
                                            class="btn btn-sm btn-icon btn-primary"
                                            onclick="openEmailModal({{ $quotation->id }}, '{{ $quotation->customer->email }}', '{{ $quotation->customer->name }}')"
                                            title="Email Gönder">
                                        <i class="bi bi-envelope"></i>
                                    </button>
                                    @endif

                                    <!-- Link Kopyala -->
                                    <button type="button"
                                            class="btn btn-sm btn-icon btn-secondary"
                                            onclick="copyLink('{{ $quotation->share_url }}')"
                                            title="Link Kopyala">
                                        <i class="bi bi-share"></i>
                                    </button>

                                    <!-- Sil -->
                                    @if($quotation->status !== 'converted')
                                    <form method="POST"
                                          action="{{ route('quotations.destroy', $quotation) }}"
                                          class="d-inline"
                                          onsubmit="return confirm('Bu teklifi silmek istediğinizden emin misiniz?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-icon btn-danger"
                                                title="Sil">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 4rem; color: #d0d0d0;"></i>
                                <h6 class="text-muted mt-3">Henüz teklif bulunmuyor</h6>
                                <a href="{{ route('quotations.create') }}" class="btn btn-primary mt-2">
                                    <i class="bi bi-plus-circle me-2"></i>İlk Teklifi Oluştur
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Quick Email Modal -->
<div class="modal fade" id="quickEmailModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-envelope me-2"></i>Hızlı Email Gönder
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="quickEmailForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alıcı Email</label>
                        <input type="email" class="form-control" id="quick_email" name="recipient_email" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Alıcı Adı</label>
                        <input type="text" class="form-control" id="quick_name" name="recipient_name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-send me-2"></i>Gönder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#quotationsTable').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/tr.json'
        },
        order: [[8, 'desc']],
        pageLength: 25,
        columnDefs: [
            { orderable: false, targets: [9] }
        ]
    });
});

function openEmailModal(quotationId, email, name) {
    $('#quick_email').val(email);
    $('#quick_name').val(name);
    $('#quickEmailForm').attr('action', `/panel/quotations/${quotationId}/send-email`);
    $('#quickEmailModal').modal('show');
}

function copyLink(url) {
    navigator.clipboard.writeText(url).then(function() {
        const toast = `
            <div class="alert alert-success alert-dismissible fade show position-fixed top-0 end-0 m-3" role="alert" style="z-index: 9999;">
                <i class="bi bi-check-circle-fill me-2"></i>Link kopyalandı!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        $('body').append(toast);
        setTimeout(function() {
            $('.alert').fadeOut(300, function() { $(this).remove(); });
        }, 3000);
    });
}
</script>
@endpush
