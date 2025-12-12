@extends('layouts.app')

@section('title', 'Kampanyalar')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">
            <i class="bi bi-megaphone me-2"></i>Kampanyalar
        </h1>
        <p class="text-muted mb-0">Toplam: {{ $campaigns->total() }} kampanya</p>
    </div>
    <div>
        <a href="{{ route('campaigns.templates') }}" class="btn btn-info">
            <i class="bi bi-file-earmark-text me-2"></i>Şablonlar
        </a>
        <a href="{{ route('campaigns.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Yeni Kampanya
        </a>
    </div>
</div>

<!-- İstatistik Kartları -->
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-primary">{{ number_format($stats['total']) }}</h3>
                <small class="text-muted">Toplam Kampanya</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-warning">{{ number_format($stats['draft']) }}</h3>
                <small class="text-muted">Taslak</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-info">{{ number_format($stats['scheduled']) }}</h3>
                <small class="text-muted">Zamanlanmış</small>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <h3 class="mb-0 text-success">{{ number_format($stats['sent']) }}</h3>
                <small class="text-muted">Gönderildi</small>
            </div>
        </div>
    </div>
</div>

<!-- Filtreler -->
<div class="card mb-3 border-0 shadow-sm">
    <div class="card-body">
        <form method="GET" action="{{ route('campaigns.index') }}" id="filterForm">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text"
                               class="form-control border-start-0"
                               name="search"
                               placeholder="Kampanya ara..."
                               value="{{ request('search') }}">
                    </div>
                </div>

                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Tüm Durumlar</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Taslak</option>
                        <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>Zamanlanmış</option>
                        <option value="sending" {{ request('status') === 'sending' ? 'selected' : '' }}>Gönderiliyor</option>
                        <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Gönderildi</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Başarısız</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="">Tüm Tipler</option>
                        <option value="sms" {{ request('type') === 'sms' ? 'selected' : '' }}>SMS</option>
                        <option value="email" {{ request('type') === 'email' ? 'selected' : '' }}>E-posta</option>
                        <option value="whatsapp" {{ request('type') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
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

<!-- Tablo -->
<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">Kampanya</th>
                        <th>Tip</th>
                        <th>Hedef Kitle</th>
                        <th>Alıcı</th>
                        <th>Tarih</th>
                        <th>Durum</th>
                        <th class="pe-4 text-end">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($campaigns as $campaign)
                    <tr>
                        <td class="ps-4">
                            <a href="{{ route('campaigns.show', $campaign) }}" class="text-decoration-none text-dark">
                                <strong>{{ $campaign->name }}</strong>
                            </a>
                            @if($campaign->subject)
                            <br>
                            <small class="text-muted">{{ Str::limit($campaign->subject, 50) }}</small>
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
                            <i class="bi bi-{{ $type['icon'] }} text-{{ $type['color'] }} me-1"></i>
                            <small>{{ $type['label'] }}</small>
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
                            <span class="badge bg-secondary">{{ number_format($campaign->total_recipients) }}</span>
                            @if($campaign->sent_count > 0)
                                <br>
                                <small class="text-success">{{ number_format($campaign->sent_count) }} gönderildi</small>
                            @endif
                        </td>
                        <td>
                            @if($campaign->scheduled_at)
                                <strong>{{ $campaign->scheduled_at->format('d.m.Y') }}</strong>
                                <br>
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
                            <span class="badge bg-{{ $status['color'] }}">
                                {{ $status['label'] }}
                            </span>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('campaigns.show', $campaign) }}"
                                   class="btn btn-outline-info"
                                   title="Detay">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(in_array($campaign->status, ['draft', 'scheduled']))
                                <form method="POST" action="{{ route('campaigns.send', $campaign) }}" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="btn btn-outline-success"
                                            onclick="return confirm('Kampanyayı göndermek istediğinizden emin misiniz?')"
                                            title="Gönder">
                                        <i class="bi bi-send"></i>
                                    </button>
                                </form>
                                <button type="button"
                                        class="btn btn-outline-danger"
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
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-megaphone text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mb-3 mt-2">Henüz kampanya bulunmuyor.</p>
                            <a href="{{ route('campaigns.create') }}" class="btn btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>İlk Kampanyayı Oluştur
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
@if($campaigns->hasPages())
<div class="mt-3">
    {{ $campaigns->links() }}
</div>
@endif

<!-- Delete Form -->
<form id="deleteForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function deleteCampaign(campaignId) {
    if (confirm('Bu kampanyayı silmek istediğinizden emin misiniz?')) {
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
            }, 500);
        }
    });
});
</script>
@endpush
