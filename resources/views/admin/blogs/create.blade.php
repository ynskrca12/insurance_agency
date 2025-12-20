@extends('admin.layouts.app')

@section('title', 'Yeni Blog Ekle')
@section('page-title', 'Yeni Blog Ekle')

@section('content')

<!-- Page Header -->
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">Yeni Blog Ekle</h1>
            <p class="page-subtitle">Yeni bir blog yazısı oluşturun</p>
        </div>
        <a href="{{ route('admin.blogs.index') }}" class="btn-primary" style="background: #64748b;">
            <i class="bi bi-arrow-left"></i>
            Geri Dön
        </a>
    </div>
</div>

<!-- Form -->
<form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">
    @csrf

    <div style="display: grid; grid-template-columns: 1fr 350px; gap: 24px;">

        <!-- Main Content -->
        <div>
            <!-- Başlık & İçerik -->
            <div class="data-card" style="margin-bottom: 24px;">
                <div class="data-card-header">
                    <h3 class="data-card-title">Temel Bilgiler</h3>
                </div>
                <div class="data-card-body">
                    <!-- Başlık -->
                    <div class="form-group">
                        <label for="title" class="form-label">
                            Başlık <span style="color: var(--admin-danger);">*</span>
                        </label>
                        <input
                            type="text"
                            id="title"
                            name="title"
                            class="form-input @error('title') is-invalid @enderror"
                            value="{{ old('title') }}"
                            placeholder="Blog yazısı başlığı"
                            required
                        >
                        @error('title')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="form-group">
                        <label for="slug" class="form-label">
                            URL (Slug)
                            <small style="font-weight: 400; color: #94a3b8;">- Boş bırakılırsa otomatik oluşturulur</small>
                        </label>
                        <input
                            type="text"
                            id="slug"
                            name="slug"
                            class="form-input @error('slug') is-invalid @enderror"
                            value="{{ old('slug') }}"
                            placeholder="ornek-blog-yazisi"
                        >
                        @error('slug')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Özet -->
                    <div class="form-group">
                        <label for="excerpt" class="form-label">Özet</label>
                        <textarea
                            id="excerpt"
                            name="excerpt"
                            class="form-input @error('excerpt') is-invalid @enderror"
                            rows="3"
                            placeholder="Blog yazısının kısa özeti (liste sayfasında gösterilir)"
                        >{{ old('excerpt') }}</textarea>
                        @error('excerpt')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                    </div>

<!-- İçerik -->
<div class="form-group">
    <label for="content" class="form-label">
        İçerik <span style="color: var(--admin-danger);">*</span>
    </label>

    <!-- Quill Editor Container -->
    <div id="content-editor" style="background: #ffffff;"></div>

    <!-- Hidden Textarea - Backend için -->
    <textarea
        id="content-hidden"
        name="content"
        style="display: none;"
        required
    >{{ old('content') }}</textarea>

    @error('content')
        <span class="form-error">{{ $message }}</span>
    @enderror
</div>
                </div>
            </div>

            <!-- SEO -->
            <div class="data-card">
                <div class="data-card-header">
                    <h3 class="data-card-title">SEO Ayarları</h3>
                </div>
                <div class="data-card-body">
                    <!-- Meta Title -->
                    <div class="form-group">
                        <label for="meta_title" class="form-label">Meta Başlık</label>
                        <input
                            type="text"
                            id="meta_title"
                            name="meta_title"
                            class="form-input"
                            value="{{ old('meta_title') }}"
                            placeholder="SEO için meta başlık (boş bırakılırsa başlık kullanılır)"
                        >
                    </div>

                    <!-- Meta Description -->
                    <div class="form-group">
                        <label for="meta_description" class="form-label">Meta Açıklama</label>
                        <textarea
                            id="meta_description"
                            name="meta_description"
                            class="form-input"
                            rows="3"
                            placeholder="SEO için meta açıklama"
                        >{{ old('meta_description') }}</textarea>
                    </div>

                    <!-- Meta Keywords -->
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="meta_keywords" class="form-label">Meta Anahtar Kelimeler</label>
                        <input
                            type="text"
                            id="meta_keywords"
                            name="meta_keywords"
                            class="form-input"
                            value="{{ old('meta_keywords') }}"
                            placeholder="sigorta, kasko, trafik sigortası"
                        >
                        <small style="color: #94a3b8; font-size: 12px; display: block; margin-top: 6px;">
                            Virgülle ayırarak yazın
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <!-- Yayınla -->
            <div class="data-card" style="margin-bottom: 24px;">
                <div class="data-card-header">
                    <h3 class="data-card-title">Yayınla</h3>
                </div>
                <div class="data-card-body">
                    <!-- Yayın Tarihi -->
                    <div class="form-group">
                        <label for="published_at" class="form-label">Yayın Tarihi</label>
                        <input
                            type="datetime-local"
                            id="published_at"
                            name="published_at"
                            class="form-input"
                            value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}"
                        >
                        <small style="color: #94a3b8; font-size: 12px; display: block; margin-top: 6px;">
                            Boş bırakılırsa şimdi yayınlanır
                        </small>
                    </div>

                    <!-- Öne Çıkan -->
                    <div class="form-group">
                        <label style="display: flex; align-items: center; gap: 12px; cursor: pointer;">
                            <input
                                type="checkbox"
                                name="is_featured"
                                value="1"
                                {{ old('is_featured') ? 'checked' : '' }}
                                style="width: 20px; height: 20px; cursor: pointer;"
                            >
                            <span style="font-weight: 600; color: var(--admin-dark);">
                                <i class="bi bi-star-fill" style="color: var(--admin-warning);"></i>
                                Öne Çıkan Yazı
                            </span>
                        </label>
                    </div>

                    <!-- Sıralama -->
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="order" class="form-label">Sıralama</label>
                        <input
                            type="number"
                            id="order"
                            name="order"
                            class="form-input"
                            value="{{ old('order', 0) }}"
                            min="0"
                        >
                        <small style="color: #94a3b8; font-size: 12px; display: block; margin-top: 6px;">
                            Düşük sayı önce görünür
                        </small>
                    </div>
                </div>
            </div>

            <!-- Görsel -->
            <div class="data-card" style="margin-bottom: 24px;">
                <div class="data-card-header">
                    <h3 class="data-card-title">Öne Çıkan Görsel</h3>
                </div>
                <div class="data-card-body">
                    <div class="form-group">
                        <input
                            type="file"
                            id="featured_image"
                            name="featured_image"
                            class="form-input @error('featured_image') is-invalid @enderror"
                            accept="image/*"
                        >
                        @error('featured_image')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                        <small style="color: #94a3b8; font-size: 12px; display: block; margin-top: 6px;">
                            Önerilen: 1200x630px, Max: 2MB
                        </small>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="image_alt" class="form-label">Görsel Alt Metni</label>
                        <input
                            type="text"
                            id="image_alt"
                            name="image_alt"
                            class="form-input"
                            value="{{ old('image_alt') }}"
                            placeholder="Görsel açıklaması (SEO için)"
                        >
                    </div>
                </div>
            </div>

            <!-- Etiketler -->
            <div class="data-card">
                <div class="data-card-header">
                    <h3 class="data-card-title">Etiketler</h3>
                </div>
                <div class="data-card-body">
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="tags" class="form-label">Etiketler</label>
                        <input
                            type="text"
                            id="tags"
                            name="tags"
                            class="form-input"
                            value="{{ old('tags') }}"
                            placeholder="sigorta, kasko, trafik"
                        >
                        <small style="color: #94a3b8; font-size: 12px; display: block; margin-top: 6px;">
                            Virgülle ayırarak yazın
                        </small>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-primary" style="width: 100%; margin-top: 24px; padding: 14px;">
                <i class="bi bi-check-circle"></i>
                Blog Yazısını Kaydet
            </button>
        </div>

    </div>
</form>

@endsection

@push('styles')
<style>
.form-group {
    margin-bottom: 20px;
}

.form-label {
    display: block;
    font-size: 14px;
    font-weight: 600;
    color: var(--admin-dark);
    margin-bottom: 8px;
}

.form-input {
    width: 100%;
    padding: 10px 16px;
    border: 2px solid var(--admin-border);
    border-radius: 10px;
    font-size: 14px;
    font-family: inherit;
    color: var(--admin-dark);
    background: #ffffff;
    transition: all 0.3s ease;
}

.form-input:focus {
    outline: none;
    border-color: var(--admin-primary);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

.form-input.is-invalid {
    border-color: var(--admin-danger);
}

.form-error {
    display: block;
    color: var(--admin-danger);
    font-size: 13px;
    margin-top: 6px;
}

textarea.form-input {
    resize: vertical;
    min-height: 100px;
}
</style>
<style>
/* Quill Editor Styling */
.ql-container {
    font-family: 'Inter', sans-serif;
    font-size: 15px;
    line-height: 1.7;
}

.ql-editor {
    min-height: 400px;
    max-height: 600px;
    overflow-y: auto;
}

.ql-editor.ql-blank::before {
    color: #94a3b8;
    font-style: normal;
}

.ql-toolbar.ql-snow {
    border: 2px solid var(--admin-border);
    border-bottom: none;
    border-radius: 10px 10px 0 0;
    background: #f8fafc;
}

.ql-container.ql-snow {
    border: 2px solid var(--admin-border);
    border-radius: 0 0 10px 10px;
    background: #ffffff;
    transition: border-color 0.3s ease;
}

.ql-toolbar.ql-snow .ql-picker-label:hover,
.ql-toolbar.ql-snow .ql-picker-label.ql-active,
.ql-toolbar.ql-snow .ql-picker-item:hover,
.ql-toolbar.ql-snow .ql-picker-item.ql-selected {
    color: var(--admin-primary);
}

.ql-toolbar.ql-snow button:hover,
.ql-toolbar.ql-snow button:focus,
.ql-toolbar.ql-snow button.ql-active {
    color: var(--admin-primary);
}

.ql-snow .ql-stroke {
    stroke: #64748b;
}

.ql-snow .ql-fill {
    fill: #64748b;
}

.ql-toolbar.ql-snow button:hover .ql-stroke,
.ql-toolbar.ql-snow button:focus .ql-stroke,
.ql-toolbar.ql-snow button.ql-active .ql-stroke {
    stroke: var(--admin-primary);
}

.ql-toolbar.ql-snow button:hover .ql-fill,
.ql-toolbar.ql-snow button:focus .ql-fill,
.ql-toolbar.ql-snow button.ql-active .ql-fill {
    fill: var(--admin-primary);
}
</style>
@endpush

@push('scripts')
<!-- Quill Editor -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
// Quill Editor Initialize
const quill = new Quill('#content-editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'align': [] }],
            ['blockquote', 'code-block'],
            ['link', 'image'],
            ['clean']
        ]
    },
    placeholder: 'Blog içeriğini buraya yazın...'
});

// ÖNEMLI: Her değişiklikte textarea'yı güncelle (REAL-TIME)
quill.on('text-change', function(delta, oldDelta, source) {
    const textarea = document.getElementById('content-hidden');
    textarea.value = quill.root.innerHTML;

    // Debug için (konsolda görmek isterseniz)
    console.log('Content updated:', quill.root.innerHTML.substring(0, 50) + '...');
});

// Form submit kontrolü
document.querySelector('form').addEventListener('submit', function(e) {
    const textarea = document.getElementById('content-hidden');
    const textContent = quill.getText().trim();

    // Son kez sync yap
    textarea.value = quill.root.innerHTML;

    // Boş mu kontrol et
    if (textContent.length === 0) {
        e.preventDefault();
        alert('İçerik alanı zorunludur. Lütfen blog içeriğini yazın.');
        quill.focus();
        document.querySelector('.ql-container').style.border = '2px solid var(--admin-danger)';

        setTimeout(() => {
            document.querySelector('.ql-container').style.border = '2px solid var(--admin-border)';
        }, 3000);

        return false;
    }

    console.log('Form submitting with content length:', textarea.value.length);
});
</script>


@endpush
