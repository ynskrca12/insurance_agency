@extends('layouts.app')

@section('title', 'Mesaj Şablonları')

@push('styles')
<style>
    .page-header {
        background: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 12px;
        padding: 1.5rem;
        margin-bottom: 2rem;
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

    .template-card {
        border: 1px solid #dcdcdc;
        border-radius: 12px;
        background: #ffffff;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .template-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        border-color: #b0b0b0;
    }

    .template-card .card-body {
        padding: 1.5rem;
        flex: 1;
    }

    .template-card .card-footer {
        background: #fafafa;
        border-top: 1px solid #e8e8e8;
        padding: 1rem 1.5rem;
    }

    .template-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #212529;
        margin-bottom: 0;
    }

    .type-badge {
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.8125rem;
    }

    .subject-info {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        margin-bottom: 1rem;
    }

    .subject-label {
        font-size: 0.75rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .subject-text {
        color: #212529;
        font-weight: 500;
        margin: 0;
    }

    .content-preview {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        max-height: 120px;
        overflow: hidden;
        position: relative;
    }

    .content-preview::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 30px;
        background: linear-gradient(transparent, #f8f9fa);
    }

    .content-preview small {
        color: #495057;
        font-size: 0.8125rem;
        line-height: 1.6;
    }

    .variables-box {
        margin-bottom: 1rem;
    }

    .variables-label {
        font-size: 0.75rem;
        color: #6c757d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .variable-badge {
        background: #e8f4fd;
        color: #0066cc;
        border: 1px solid #b3d9ff;
        padding: 0.25rem 0.625rem;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 500;
        margin-right: 0.375rem;
        margin-bottom: 0.375rem;
        display: inline-block;
    }

    .template-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 1rem;
        border-top: 1px solid #f0f0f0;
    }

    .creator-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6c757d;
        font-size: 0.8125rem;
    }

    .status-badge {
        padding: 0.375rem 0.75rem;
        font-weight: 500;
        border-radius: 6px;
        font-size: 0.8125rem;
    }

    .card-actions {
        display: grid;
        gap: 0.5rem;
    }

    .btn-icon-text {
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 1px solid #dcdcdc;
        background: #ffffff;
    }

    .btn-icon-text:hover {
        transform: translateY(-1px);
        border-color: #999;
    }

    .btn-icon-text.btn-view:hover {
        background: #0dcaf0;
        border-color: #0dcaf0;
        color: #ffffff;
    }

    .btn-icon-text.btn-delete:hover {
        background: #dc3545;
        border-color: #dc3545;
        color: #ffffff;
    }

    .empty-state {
        padding: 5rem 2rem;
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

    .modal-modern .modal-content {
        border: none;
        border-radius: 12px;
        overflow: hidden;
    }

    .modal-modern .modal-header {
        border: none;
        padding: 1.25rem 1.5rem;
    }

    .modal-modern .modal-body {
        padding: 1.5rem;
    }

    .modal-modern .modal-footer {
        background: #fafafa;
        border-top: 1px solid #e9ecef;
        padding: 1rem 1.5rem;
    }

    .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 0.5rem;
        font-size: 0.9375rem;
    }

    .form-label .text-danger {
        font-weight: 600;
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

    textarea.form-control {
        resize: vertical;
    }

    .helper-text {
        font-size: 0.8125rem;
        color: #6c757d;
        margin-top: 0.375rem;
    }

    .variables-info {
        background: #e8f4fd;
        border: 1px solid #b3d9ff;
        border-radius: 8px;
        padding: 0.75rem 1rem;
        margin-top: 0.5rem;
        font-size: 0.8125rem;
        color: #0066cc;
    }

    .form-check-input {
        width: 1.25rem;
        height: 1.25rem;
        cursor: pointer;
        border: 2px solid #dcdcdc;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .form-check-label {
        cursor: pointer;
        font-weight: 500;
        color: #495057;
        padding-left: 0.5rem;
    }

    .content-display {
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 10px;
        padding: 1.5rem;
    }

    .content-display pre {
        margin: 0;
        white-space: pre-wrap;
        word-wrap: break-word;
        font-family: inherit;
        font-size: 0.9375rem;
        line-height: 1.7;
        color: #212529;
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

    .template-card {
        animation: fadeInUp 0.4s ease forwards;
    }

    @media (max-width: 768px) {
        .template-card .card-body {
            padding: 1.25rem;
        }

        .template-card .card-footer {
            padding: 1rem 1.25rem;
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
                    <i class="bi bi-file-earmark-text me-2"></i>Mesaj Şablonları
                </h1>
                <p class="text-muted mb-0 small">Toplam {{ $templates->total() }} şablon kaydı bulundu</p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-primary action-btn" data-bs-toggle="modal" data-bs-target="#createTemplateModal">
                    <i class="bi bi-plus-circle me-2"></i>Yeni Şablon
                </button>
                <a href="{{ route('campaigns.index') }}" class="btn btn-light action-btn">
                    <i class="bi bi-arrow-left me-2"></i>Kampanyalara Dön
                </a>
            </div>
        </div>
    </div>

    <!-- Şablon Kartları -->
    <div class="row g-4">
        @forelse($templates as $template)
        <div class="col-lg-4 col-md-6">
            <div class="template-card card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h5 class="template-title">{{ $template->name }}</h5>
                        @php
                            $typeConfig = [
                                'sms' => ['color' => 'primary', 'label' => 'SMS'],
                                'email' => ['color' => 'info', 'label' => 'E-posta'],
                                'whatsapp' => ['color' => 'success', 'label' => 'WhatsApp'],
                            ];
                            $type = $typeConfig[$template->type] ?? ['color' => 'secondary', 'label' => $template->type];
                        @endphp
                        <span class="badge type-badge bg-{{ $type['color'] }}">{{ $type['label'] }}</span>
                    </div>

                    @if($template->subject)
                    <div class="subject-info">
                        <div class="subject-label">Konu</div>
                        <p class="subject-text">{{ $template->subject }}</p>
                    </div>
                    @endif

                    <div class="content-preview">
                        <small>{{ Str::limit($template->content, 180) }}</small>
                    </div>

                    @if($template->variables)
                    <div class="variables-box">
                        <div class="variables-label">Değişkenler</div>
                        <div>
                            @foreach($template->variables as $variable)
                            <span class="variable-badge">{{ $variable }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <div class="template-meta">
                        <div class="creator-info">
                            <i class="bi bi-person"></i>
                            <span>{{ $template->createdBy->name }}</span>
                        </div>
                        <span class="badge status-badge {{ $template->is_active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $template->is_active ? 'Aktif' : 'Pasif' }}
                        </span>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="card-actions">
                        <button type="button"
                                class="btn btn-icon-text btn-view"
                                data-bs-toggle="modal"
                                data-bs-target="#viewTemplateModal"
                                onclick="viewTemplate({{ json_encode($template) }})">
                            <i class="bi bi-eye me-2"></i>Görüntüle
                        </button>
                        <form method="POST" action="{{ route('campaigns.destroyTemplate', $template) }}" onsubmit="return confirmDelete(event)">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-icon-text btn-delete w-100">
                                <i class="bi bi-trash me-2"></i>Sil
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card template-card">
                <div class="card-body">
                    <div class="empty-state">
                        <i class="bi bi-file-earmark-text"></i>
                        <h5>Şablon Bulunamadı</h5>
                        <p>Henüz hiç mesaj şablonu oluşturulmamış.</p>
                        <button type="button" class="btn btn-primary action-btn" data-bs-toggle="modal" data-bs-target="#createTemplateModal">
                            <i class="bi bi-plus-circle me-2"></i>İlk Şablonu Oluştur
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($templates->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $templates->links() }}
    </div>
    @endif
</div>

<!-- Create Template Modal -->
<div class="modal fade modal-modern" id="createTemplateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-plus-circle me-2"></i>Yeni Şablon Oluştur
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('campaigns.storeTemplate') }}" id="createTemplateForm">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">
                                Şablon Adı <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control"
                                   name="name"
                                   required
                                   placeholder="Örn: Yenileme Hatırlatması">
                            <small class="helper-text">Şablonunuzu tanımlayıcı bir isim verin</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">
                                Mesaj Tipi <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" name="type" id="templateType" required>
                                <option value="sms">📱 SMS</option>
                                <option value="email">📧 E-posta</option>
                                <option value="whatsapp">💬 WhatsApp</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3" id="emailSubjectField" style="display: none;">
                        <label class="form-label">
                            E-posta Konusu <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               class="form-control"
                               name="subject"
                               placeholder="E-posta konu başlığı">
                    </div>

                    <div class="mt-3">
                        <label class="form-label">
                            Mesaj İçeriği <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control"
                                  name="content"
                                  rows="8"
                                  required
                                  placeholder="Mesaj içeriğini buraya yazın..."></textarea>
                        <div class="variables-info">
                            <strong>Kullanabileceğiniz Değişkenler:</strong> {NAME}, {PHONE}, {EMAIL}, {POLICY_NUMBER}
                        </div>
                    </div>

                    <div class="form-check mt-3">
                        <input class="form-check-input"
                               type="checkbox"
                               name="is_active"
                               value="1"
                               checked
                               id="isActive">
                        <label class="form-check-label" for="isActive">
                            Şablonu aktif olarak kaydet
                        </label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light action-btn" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-2"></i>İptal
                    </button>
                    <button type="submit" class="btn btn-primary action-btn">
                        <i class="bi bi-check-circle me-2"></i>Oluştur
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Template Modal -->
<div class="modal fade modal-modern" id="viewTemplateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="viewTemplateTitle"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="viewTemplateSubject" class="subject-info" style="display: none;">
                    <div class="subject-label">E-posta Konusu</div>
                    <p class="subject-text" id="templateSubject"></p>
                </div>
                <div class="content-display">
                    <pre id="viewTemplateContent"></pre>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light action-btn" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Kapat
                </button>
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
            $('#emailSubjectField').slideDown(300);
            $('#emailSubjectField input').attr('required', true);
        } else {
            $('#emailSubjectField').slideUp(300);
            $('#emailSubjectField input').attr('required', false);
        }
    });

    // Form submit animasyonu
    $('#createTemplateForm').on('submit', function() {
        const submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true)
                 .html('<span class="spinner-border spinner-border-sm me-2"></span>Oluşturuluyor...');
    });

    // Modal açıldığında ilk alana focus
    $('#createTemplateModal').on('shown.bs.modal', function() {
        $(this).find('input[name="name"]').focus();
    });
});

function viewTemplate(template) {
    $('#viewTemplateTitle').html('<i class="bi bi-file-earmark-text me-2"></i>' + template.name);
    $('#templateSubject').text(template.subject);
    $('#viewTemplateContent').text(template.content);

    if (template.subject) {
        $('#viewTemplateSubject').show();
    } else {
        $('#viewTemplateSubject').hide();
    }
}

function confirmDelete(event) {
    event.preventDefault();

    if (confirm('⚠️ Bu şablonu silmek istediğinizden emin misiniz?\n\nBu işlem geri alınamaz!')) {
        // Loading overlay
        $('body').append(`
            <div class="position-fixed top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center"
                 style="background: rgba(0,0,0,0.5); z-index: 9999;">
                <div class="spinner-border text-light" style="width: 3rem; height: 3rem;"></div>
            </div>
        `);

        event.target.submit();
    }

    return false;
}
</script>
@endpush
