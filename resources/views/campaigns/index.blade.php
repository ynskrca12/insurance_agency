@extends('layouts.app')

@section('title', 'Kampanyalar')

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

    .input-group-text {
        border: 1px solid #dcdcdc;
        border-right: none;
        background: #fafafa;
        color: #6c757d;
        border-radius: 8px 0 0 8px;
    }

    .input-group .form-control {
        border-left: none;
        border-radius: 0 8px 8px 0;
    }

    .input-group .form-control:focus {
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

    .btn-info.action-btn {
        border-color: #0dcaf0;
    }

    .table-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        overflow: hidden;
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
        white-space: nowrap;
    }

    .table-modern tbody td {
        padding: 1rem 1.25rem;
        vertical-align: middle;
        border-bottom: 1px solid #f5f5f5;
    }

    .table-modern tbody tr:last-child td {
        border-bottom: none;
    }

    .table-modern tbody tr:hover {
        background: #fafafa;
    }

    .campaign-title {
        color: #212529;
        text-decoration: none;
        font-weight: 600;
        transition: color 0.2s ease;
    }

    .campaign-title:hover {
        color: #0d6efd;
    }

    .campaign-subject {
        color: #6c757d;
        font-size: 0.8125rem;
        margin-top: 0.25rem;
    }

    .type-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.375rem;
        padding: 0.25rem 0.625rem;
        background: #f8f9fa;
        border-radius: 6px;
        font-size: 0.8125rem;
    }

    .recipient-badge {
        padding: 0.375rem 0.75rem;
        font-weight: 600;
        border-radius: 6px;
        font-size: 0.8125rem;
        background: #e9ecef;
        color: #495057;
        border: 1px solid #dee2e6;
    }

    .sent-count {
        color: #28a745;
        font-size: 0.8125rem;
        margin-top: 0.25rem;
    }

    .badge-modern {
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.8125rem;
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

    .btn-icon.btn-send:hover {
        background: #28a745;
        border-color: #28a745;
        color: #ffffff;
    }

    .btn-icon.btn-delete:hover {
        background: #dc3545;
        border-color: #dc3545;
        color: #ffffff;
    }

    .action-buttons {
        display: flex;
        gap: 0.25rem;
    }

    .empty-state {
        padding: 4rem 2rem;
        text-align: center;
    }

    .empty-state i {
        font-size: 5rem;
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

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-row {
        animation: fadeIn 0.4s ease forwards;
    }

    @media (max-width: 768px) {
        .table-modern {
            font-size: 0.875rem;
        }

        .stat-value {
            font-size: 1.5rem;
        }

        .action-buttons {
            flex-wrap: wrap;
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
                <h1 class="h3 mb-1 fw-bold text-dark">
                    <i class="bi bi-megaphone me-2"></i>Kampanyalar
                </h1>
                <p class="text-muted mb-0 small">Toplam {{ $campaigns->total() }} kampanya kaydı bulundu</p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('campaigns.templates') }}" class="btn btn-info action-btn">
                    <i class="bi bi-file-earmark-text me-2"></i>Şablonlar
                </a>
                <a href="{{ route('campaigns.create') }}" class="btn btn-primary action-btn">
                    <i class="bi bi-plus-circle me-2"></i>Yeni Kampanya
                </a>
            </div>
        </div>
    </div>

    <!-- İstatistik Kartları -->
    <div class="row g-3 mb-4">
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-primary">{{ number_format($stats['total']) }}</div>
                <div class="stat-label">Toplam Kampanya</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-warning">{{ number_format($stats['draft']) }}</div>
                <div class="stat-label">Taslak</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-info">{{ number_format($stats['scheduled']) }}</div>
                <div class="stat-label">Zamanlanmış</div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="stat-card">
                <div class="stat-value text-success">{{ number_format($stats['sent']) }}</div>
                <div class="stat-label">Gönderildi</div>
            </div>
        </div>
    </div>

    <!-- Filtreler -->
    <div class="filter-card card">
        <div class="card-body">
            <form method="GET" action="{{ route('campaigns.index') }}" id="filterForm">
                <div class="row g-3 align-items-end">
                    <!-- Arama -->
                    <div class="col-lg-4 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Arama</label>
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text"
                                   class="form-control"
                                   name="search"
                                   placeholder="Kampanya ara..."
                                   value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Durum -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Durum</label>
                        <select name="status" class="form-select">
                            <option value="">Tümü</option>
                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Taslak</option>
                            <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Zamanlanmış</option>
                            <option value="sending" {{ request('status') === 'sending' ? 'selected' : '' }}>Gönderiliyor</option>
                            <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Gönderildi</option>
                            <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Başarısız</option>
                        </select>
                    </div>

                    <!-- Tip -->
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label small fw-semibold text-muted mb-2">Kampanya Tipi</label>
                        <select name="type" class="form-select">
                            <option value="">Tümü</option>
                            <option value="sms" {{ request('type') === 'sms' ? 'selected' : '' }}>SMS</option>
                            <option value="email" {{ request('type') === 'email' ? 'selected' : '' }}>E-posta</option>
                            <option value="whatsapp" {{ request('type') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                        </select>
                    </div>

                    <!-- Filtrele Butonu -->
                    <div class="col-lg-2 col-md-12">
                        <button type="submit" class="btn btn-primary action-btn w-100">
                            <i class="bi bi-funnel"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Tablo -->
    <div class="table-card card">
        <div class="table-responsive">
            <table class="table table-modern">
                <thead>
                    <tr>
                        <th>Kampanya Adı</th>
                        <th>Tip</th>
                        <th>Hedef Kitle</th>
                        <th>Alıcı Sayısı</th>
                        <th>Tarih</th>
                        <th>Durum</th>
                        <th class="text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                    <tr class="fade-in-row">
                        <td>
                            <a href="{{ route('campaigns.show', $campaign) }}" class="campaign-title">
                                {{ $campaign->name }}
                            </a>
                            @if($campaign->subject)
                            <div class="campaign-subject">{{ Str::limit($campaign->subject, 60) }}</div>
                            @endif
                        </td>
                        <td>
                            @php
                                $typeConfig = [
                                    'sms' => ['icon' => 'chat-dots', 'label' => 'SMS', 'color' => 'primary'],
                                    'email' => ['icon' => 'envelope', 'label' => 'E-posta', 'color' => 'info'],
                                    'whatsapp' => ['icon' => 'whatsapp', 'label' => 'WhatsApp', 'color' => 'success'],
                                ];
                                $type = $typeConfig[$campaign->type] ?? ['icon' => 'chat', 'label' => $campaign->type, 'color' => 'secondary'];
                            @endphp
                            <span class="type-badge">
                                <i class="bi bi-{{ $type['icon'] }} text-{{ $type['color'] }}"></i>
                                <span>{{ $type['label'] }}</span>
                            </span>
                        </td>
                        <td>
                            @php
                                $targetLabels = [
                                    'all' => 'Tüm Müşteriler',
                                    'active_customers' => 'Aktif Müşteriler',
                                    'policy_type' => 'Poliçe Türü',
                                    'city' => 'Şehir',
                                    'custom' => 'Özel',
                                ];
                            @endphp
                            <small>{{ $targetLabels[$campaign->target_type] ?? $campaign->target_type }}</small>
                        </td>
                        <td>
                            <span class="recipient-badge">{{ number_format($campaign->total_recipients) }}</span>
                            @if($campaign->sent_count > 0)
                                <div class="sent-count">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    {{ number_format($campaign->sent_count) }} gönderildi
                                </div>
                            @endif
                        </td>
                        <td>
                            @if($campaign->scheduled_at)
                                <div class="fw-semibold">{{ $campaign->scheduled_at->format('d.m.Y') }}</div>
                                <small class="text-muted">{{ $campaign->scheduled_at->format('H:i') }}</small>
                            @else
                                <small class="text-muted">{{ $campaign->created_at->format('d.m.Y H:i') }}</small>
                            @endif
                        </td>
                        <td>
                            @php
                                $statusConfig = [
                                    'draft' => ['color' => 'warning', 'label' => 'Taslak'],
                                    'scheduled' => ['color' => 'info', 'label' => 'Zamanlanmış'],
                                    'sending' => ['color' => 'primary', 'label' => 'Gönderiliyor'],
                                    'sent' => ['color' => 'success', 'label' => 'Gönderildi'],
                                    'failed' => ['color' => 'danger', 'label' => 'Başarısız'],
                                ];
                                $status = $statusConfig[$campaign->status] ?? ['color' => 'secondary', 'label' => $campaign->status];
                            @endphp
                            <span class="badge badge-modern bg-{{ $status['color'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td class="text-end">
                            <div class="action-buttons">
                                <a href="{{ route('campaigns.show', $campaign) }}"
                                   class="btn-icon btn-view"
                                   title="Detay">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(in_array($campaign->status, ['draft', 'scheduled']))
                                <form method="POST" action="{{ route('campaigns.send', $campaign) }}" class="d-inline">
                                    @csrf
                                    <button type="button"
                                            class="btn-icon btn-send"
                                            onclick="confirmSend(this)"
                                            title="Gönder">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </form>
                                <button type="button"
                                        class="btn-icon btn-delete"
                                        onclick="deleteCampaign({{ $campaign->id }})"
                                        title="Sil">
                                    <i class="bi bi-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="bi bi-megaphone"></i>
                                <h5>Kampanya Bulunamadı</h5>
                                <p>
                                    @if(request()->hasAny(['search', 'status', 'type']))
                                        Arama kriterlerinize uygun kampanya bulunamadı.
                                    @else
                                        Henüz hiç kampanya oluşturulmamış.
                                    @endif
                                </p>
                                @if(!request()->hasAny(['search', 'status', 'type']))
                                <a href="{{ route('campaigns.create') }}" class="btn btn-primary action-btn">
                                    <i class="bi bi-plus-circle me-2"></i>İlk Kampanyayı Oluştur
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if($campaigns->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $campaigns->links() }}
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
function confirmSend(button) {
    if (confirm('⚠️ Kampanyayı göndermek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        // Loading state
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        // Submit form
        button.closest('form').submit();
    }
}

function deleteCampaign(campaignId) {
    if (confirm('⚠️ Bu kampanyayı silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        // Loading overlay
        $('body').append(`
            <div class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                 style="background: rgba(0,0,0,0.5); z-index: 9999;">
                <div class="spinner-border text-light" style="width: 3rem; height: 3rem;"></div>
            </div>
        `);

        const form = document.getElementById('deleteForm');
        form.action = '/panel/campaigns/' + campaignId;
        form.submit();
    }
}

$(document).ready(function() {
    // Filtre değişimi otomatik gönderim
    $('select[name="status"], select[name="type"]').on('change', function() {
        $('#filterForm').submit();
    });

    // Arama input debounce
    let searchTimeout;
    $('input[name="search"]').on('input', function() {
        clearTimeout(searchTimeout);
        const value = $(this).val();

        if (value.length >= 3 || value.length === 0) {
            searchTimeout = setTimeout(function() {
                $('#filterForm').submit();
            }, 600);
        }
    });

    // Satır animasyonları
    let delay = 0;
    $('.fade-in-row').each(function() {
        $(this).css({
            'animation-delay': delay + 's',
            'opacity': '0'
        });
        delay += 0.05;
    });

    setTimeout(function() {
        $('.fade-in-row').css('opacity', '1');
    }, 50);
});
</script>
@endpush
