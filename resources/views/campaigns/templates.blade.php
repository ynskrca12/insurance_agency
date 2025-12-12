@extends('layouts.app')

@section('title', 'Mesaj Şablonları')

@section('content')
<!-- Header -->
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">
            <i class="bi bi-file-earmark-text me-2"></i>Mesaj Şablonları
        </h1>
        <p class="text-muted mb-0">Toplam: {{ $templates->total() }} şablon</p>
    </div>
    <div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTemplateModal">
            <i class="bi bi-plus-circle me-2"></i>Yeni Şablon
        </button>
        <a href="{{ route('campaigns.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kampanyalara Dön
        </a>
    </div>
</div>

<!-- Şablon Kartları -->
<div class="row g-3">
    @forelse($templates as $template)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <h5 class="card-title mb-0">{{ $template->name }}</h5>
                    @php
                        $typeConfig = [
                            'sms' => ['color' => 'primary', 'label' => 'SMS'],
                            'email' => ['color' => 'info', 'label' => 'Email'],
                            'whatsapp' => ['color' => 'success', 'label' => 'WhatsApp'],
                        ];
                        $type = $typeConfig[$template->type] ?? ['color' => 'secondary', 'label' => $template->type];
                    @endphp
                    <span class="badge bg-{{ $type['color'] }}">{{ $type['label'] }}</span>
                </div>

                @if($template->subject)
                <p class="text-muted small mb-2">
                    <strong>Konu:</strong> {{ $template->subject }}
                </p>
                @endif

                <div class="bg-light p-2 rounded mb-3" style="max-height: 100px; overflow: hidden;">
                    <small>{{ Str::limit($template->content, 150) }}</small>
                </div>

                @if($template->variables)
                <div class="mb-3">
                    <small class="text-muted">Değişkenler:</small>
                    <div>
                        @foreach($template->variables as $variable)
                        <span class="badge bg-secondary me-1">{{ $variable }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="bi bi-person me-1"></i>{{ $template->createdBy->name }}
                    </small>
                    <div>
                        <span class="badge {{ $template->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $template->is_active ? 'Aktif' : 'Pasif' }}
                        </span>
                    </div>
                </div>
            </div>
            <div class="card-footer bg-white border-top">
                <div class="d-grid gap-2">
                    <button type="button"
                            class="btn btn-sm btn-outline-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#viewTemplateModal"
                            onclick="viewTemplate({{ json_encode($template) }})">
                        <i class="bi bi-eye me-1"></i>Görüntüle
                    </button>
                    <form method="POST" action="{{ route('campaigns.destroyTemplate', $template) }}" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="btn btn-sm btn-outline-danger w-100"
                                onclick="return confirm('Bu şablonu silmek istediğinizden emin misiniz?')">
                            <i class="bi bi-trash me-1"></i>Sil
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-file-earmark-text text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mb-3 mt-2">Henüz şablon bulunmuyor.</p>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTemplateModal">
                    <i class="bi bi-plus-circle me-2"></i>İlk Şablonu Oluştur
                </button>
            </div>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($templates->hasPages())
<div class="mt-3">
    {{ $templates->links() }}
</div>
@endif

<!-- Create Template Modal -->
<div class="modal fade" id="createTemplateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Yeni Şablon Oluştur
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('campaigns.storeTemplate') }}">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Şablon Adı <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Tip <span class="text-danger">*</span></label>
                            <select class="form-select" name="type" id="templateType" required>
                                <option value="sms">SMS</option>
                                <option value="email">E-posta</option>
                                <option value="whatsapp">WhatsApp</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3" id="emailSubjectField" style="display: none;">
                        <label class="form-label">Konu</label>
                        <input type="text" class="form-control" name="subject">
                    </div>

                    <div class="mt-3">
                        <label class="form-label">İçerik <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="content" rows="6" required></textarea>
                        <small class="text-muted">
                            Kullanılabilir değişkenler: {NAME}, {PHONE}, {EMAIL}, {POLICY_NUMBER}
                        </small>
                    </div>

                    <div class="form-check mt-3">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" checked id="isActive">
                        <label class="form-check-label" for="isActive">
                            Aktif
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">İptal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle me-2"></i>Oluştur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Template Modal -->
<div class="modal fade" id="viewTemplateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewTemplateTitle"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="viewTemplateSubject" class="mb-3" style="display: none;">
                    <strong>Konu:</strong> <span id="templateSubject"></span>
                </div>
                <div class="bg-light p-3 rounded">
                    <pre id="viewTemplateContent" class="mb-0" style="white-space: pre-wrap;"></pre>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Tip değiştiğinde konu alanını göster/gizle
    $('#templateType').on('change', function() {
        if ($(this).val() === 'email') {
            $('#emailSubjectField').show();
        } else {
            $('#emailSubjectField').hide();
        }
    });
});

function viewTemplate(template) {
    $('#viewTemplateTitle').text(template.name);
    $('#templateSubject').text(template.subject);
    $('#viewTemplateContent').text(template.content);

    if (template.subject) {
        $('#viewTemplateSubject').show();
    } else {
        $('#viewTemplateSubject').hide();
    }
}
</script>
@endpush
