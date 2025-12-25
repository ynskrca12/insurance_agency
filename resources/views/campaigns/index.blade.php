@extends('layouts.app')

@section('title', 'Kampanyalar')

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

    .table-card .card-body {
        padding: 1.5rem;
    }

    .campaign-title {
        color: #212529;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9375rem;
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
        padding: 0.375rem 0.75rem;
        background: #f8f9fa;
        border-radius: 6px;
        font-size: 0.8125rem;
        font-weight: 500;
        border: 1px solid #dee2e6;
    }

    .recipient-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
        font-weight: 600;
        border-radius: 6px;
        font-size: 0.875rem;
        background: #e7f3ff;
        color: #0066cc;
        border: 1px solid #b3d9ff;
    }

    .sent-count {
        color: #28a745;
        font-size: 0.8125rem;
        margin-top: 0.375rem;
        font-weight: 500;
    }

    .badge-modern {
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.8125rem;
    }

    .action-buttons {
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

    /* DataTables */
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
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="page-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h4 mb-1 fw-bold text-dark">
                    <i class="bi bi-megaphone me-2"></i>Kampanyalar
                </h1>
                <p class="text-muted mb-0 small" id="campaignCount">
                    Toplam <strong>{{ $campaigns->count() }}</strong> kampanya kaydı bulundu
                </p>
            </div>
            <div class="d-flex gap-2">
                <a href="{{ route('campaigns.templates') }}" class="btn btn-info action-btn text-white">
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
            <div class="row g-3 align-items-end">
                <!-- Durum -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Durum</label>
                    <select id="filterStatus" class="form-select">
                        <option value="">Tümü</option>
                        <option value="Taslak">Taslak</option>
                        <option value="Zamanlanmış">Zamanlanmış</option>
                        <option value="Gönderiliyor">Gönderiliyor</option>
                        <option value="Gönderildi">Gönderildi</option>
                        <option value="Başarısız">Başarısız</option>
                    </select>
                </div>

                <!-- Tip -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Kampanya Tipi</label>
                    <select id="filterType" class="form-select">
                        <option value="">Tümü</option>
                        <option value="SMS">SMS</option>
                        <option value="E-posta">E-posta</option>
                        <option value="WhatsApp">WhatsApp</option>
                    </select>
                </div>

                <!-- Başlangıç Tarihi -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Başlangıç</label>
                    <input type="date" id="filterDateFrom" class="form-control">
                </div>

                <!-- Bitiş Tarihi -->
                <div class="col-lg-2 col-md-6">
                    <label class="form-label small fw-semibold text-muted mb-2">Bitiş</label>
                    <input type="date" id="filterDateTo" class="form-control">
                </div>

                <!-- Temizle Butonu -->
                <div class="col-lg-1 col-md-12">
                    <button type="button" class="btn btn-secondary action-btn w-100" onclick="clearFilters()">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tablo -->
    <div class="table-card card">
        <div class="card-body">
            <table class="table table-hover" id="campaignsTable">
                <thead>
                    <tr>
                        <th width="50">#</th>
                        <th>Kampanya Adı</th>
                        <th>Tip</th>
                        <th>Hedef Kitle</th>
                        <th>Alıcı Sayısı</th>
                        <th>Tarih</th>
                        <th>Durum</th>
                        <th width="120" class="text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($campaigns as $campaign)
                    <tr>
                        <td></td>
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
                            <small class="text-muted">{{ $targetLabels[$campaign->target_type] ?? $campaign->target_type }}</small>
                        </td>
                        <td>
                            <span class="recipient-badge">
                                <i class="bi bi-people-fill me-1"></i>
                                {{ number_format($campaign->total_recipients) }}
                            </span>
                            @if($campaign->sent_count > 0)
                                <div class="sent-count">
                                    <i class="bi bi-check-circle-fill me-1"></i>
                                    {{ number_format($campaign->sent_count) }} gönderildi
                                </div>
                            @endif
                        </td>
                        <td data-sort="{{ $campaign->scheduled_at ? $campaign->scheduled_at->format('Y-m-d H:i:s') : $campaign->created_at->format('Y-m-d H:i:s') }}">
                            @if($campaign->scheduled_at)
                                <div class="fw-semibold">{{ $campaign->scheduled_at->format('d.m.Y') }}</div>
                                <small class="text-muted">{{ $campaign->scheduled_at->format('H:i') }}</small>
                            @else
                                <div class="fw-semibold">{{ $campaign->created_at->format('d.m.Y') }}</div>
                                <small class="text-muted">{{ $campaign->created_at->format('H:i') }}</small>
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
function confirmSend(button) {
    if (confirm('⚠️ Kampanyayı göndermek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        button.disabled = true;
        button.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        button.closest('form').submit();
    }
}

function deleteCampaign(campaignId) {
    if (confirm('⚠️ Bu kampanyayı silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        const form = document.getElementById('deleteForm');
        form.action = '/panel/campaigns/' + campaignId;
        form.submit();
    }
}

$(document).ready(function() {
    // ✅ DataTable başlat
    const table = initDataTable('#campaignsTable', {
        order: [[5, 'desc']], // Tarihe göre sırala
        pageLength: 25,
        columnDefs: [
            { orderable: false, searchable: false, targets: 0 }, // Sıra numarası
            { orderable: false, targets: [7] }, // İşlemler
            { targets: 5, type: 'date' } // Tarih
        ]
    });

    // ✅ Filtreler
    $('#filterStatus, #filterType, #filterDateFrom, #filterDateTo').on('change', function() {
        const status = $('#filterStatus').val();
        const type = $('#filterType').val();
        const dateFrom = $('#filterDateFrom').val();
        const dateTo = $('#filterDateTo').val();

        // Tüm custom filtreleri temizle
        $.fn.dataTable.ext.search = [];

        // Durum filtresi
        if (status) {
            table.column(6).search(status);
        } else {
            table.column(6).search('');
        }

        // Tip filtresi
        if (type) {
            table.column(2).search(type);
        } else {
            table.column(2).search('');
        }

        // Tarih aralığı filtresi
        if (dateFrom || dateTo) {
            $.fn.dataTable.ext.search.push(
                function(settings, data, dataIndex) {
                    const dateStr = data[5]; // Tarih sütunu
                    if (!dateStr || dateStr === '-') return true;

                    const dateParts = dateStr.match(/\d{2}\.\d{2}\.\d{4}/);
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
        $('#campaignCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> kampanya`);
    });

    // İlk yüklemede toplam sayıyı güncelle
    const info = table.page.info();
    $('#campaignCount').html(`Gösterilen: <strong>${info.recordsDisplay}</strong> / <strong>${info.recordsTotal}</strong> kampanya`);
});

function clearFilters() {
    $('#filterStatus, #filterType, #filterDateFrom, #filterDateTo').val('');
    $.fn.dataTable.ext.search = [];
    const table = $('#campaignsTable').DataTable();
    table.search('').columns().search('').draw();
}
</script>
@endpush
