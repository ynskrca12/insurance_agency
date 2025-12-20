@extends('admin.layouts.app')

@section('title', 'Blog Düzenle')
@section('page-title', 'Blog Düzenle')

@section('content')

<!-- Page Header -->
<div class="page-header">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 class="page-title">Blog Düzenle</h1>
            <p class="page-subtitle">{{ $blog->title }}</p>
        </div>
        <div style="display: flex; gap: 12px;">
            <a href="{{ $blog->getUrl() }}" target="_blank" class="btn-primary" style="background: var(--admin-success);">
                <i class="bi bi-eye"></i>
                Önizle
            </a>
            <a href="{{ route('admin.blogs.index') }}" class="btn-primary" style="background: #64748b;">
                <i class="bi bi-arrow-left"></i>
                Geri Dön
            </a>
        </div>
    </div>
</div>

<!-- Success Message -->
@if(session('success'))
<div class="admin-alert success" style="margin-bottom: 24px;">
    <i class="bi bi-check-circle-fill"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

<!-- Form -->
<form method="POST" action="{{ route('admin.blogs.update', $blog) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

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
                            value="{{ old('title', $blog->title) }}"
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
                            value="{{ old('slug', $blog->slug) }}"
                            placeholder="ornek-blog-yazisi"
                        >
                        @error('slug')
                            <span class="form-error">{{ $message }}</span>
                        @enderror
                        <small style="color: #94a3b8; font-size: 12px; display: block; margin-top: 6px;">
                            <i class="bi bi-link-45deg"></i>
                            Mevcut URL: {{ $blog->getUrl() }}
                        </small>
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
                        >{{ old('excerpt', $blog->excerpt) }}</textarea>
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

                        <!-- Hidden Input -->
                        <input type="hidden" id="content-hidden" name="content" value="{{ old('content', $blog->content) }}">

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
                            value="{{ old('meta_title', $blog->meta_title) }}"
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
                        >{{ old('meta_description', $blog->meta_description) }}</textarea>
                    </div>

                    <!-- Meta Keywords -->
                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="meta_keywords" class="form-label">Meta Anahtar Kelimeler</label>
                        <input
                            type="text"
                            id="meta_keywords"
                            name="meta_keywords"
                            class="form-input"
                            value="{{ old('meta_keywords', $blog->meta_keywords) }}"
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
                    <h3 class="data-card-title">Yayın Bilgileri</h3>
                </div>
                <div class="data-card-body">
                    <!-- Durum Badge -->
                    <div style="margin-bottom: 20px;">
                        @if($blog->isPublished())
                        <div style="display: flex; align-items: center; gap: 8px; padding: 12px; background: rgba(16, 185, 129, 0.1); border-radius: 10px; border: 2px solid var(--admin-success);">
                            <i class="bi bi-check-circle-fill" style="font-size: 20px; color: var(--admin-success);"></i>
                            <div>
                                <div style="font-weight: 600; color: var(--admin-success);">Yayında</div>
                                <div style="font-size: 12px; color: #64748b;">
                                    {{ $blog->published_at->format('d.m.Y H:i') }}
                                </div>
                            </div>
                        </div>
                        @else
                        <div style="display: flex; align-items: center; gap: 8px; padding: 12px; background: rgba(245, 158, 11, 0.1); border-radius: 10px; border: 2px solid var(--admin-warning);">
                            <i class="bi bi-clock-history" style="font-size: 20px; color: var(--admin-warning);"></i>
                            <div>
                                <div style="font-weight: 600; color: var(--admin-warning);">Taslak</div>
                                <div style="font-size: 12px; color: #64748b;">Henüz yayınlanmadı</div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Yayın Tarihi -->
                    <div class="form-group">
                        <label for="published_at" class="form-label">Yayın Tarihi</label>
                        <input
                            type="datetime-local"
                            id="published_at"
                            name="published_at"
                            class="form-input"
                            value="{{ old('published_at', $blog->published_at ? $blog->published_at->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}"
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
                                {{ old('is_featured', $blog->is_featured) ? 'checked' : '' }}
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
                            value="{{ old('order', $blog->order) }}"
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
                    <!-- Mevcut Görsel -->
                    @if($blog->featured_image)
                    <div style="margin-bottom: 16px;">
                        <img
                            src="{{ $blog->getImageUrl() }}"
                            alt="{{ $blog->title }}"
                            style="width: 100%; border-radius: 12px; margin-bottom: 12px;"
                        >
                        <form method="POST" action="{{ route('admin.blogs.delete-image', $blog) }}" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="btn-primary"
                                style="background: var(--admin-danger); width: 100%; padding: 10px;"
                                onclick="return confirm('Görseli silmek istediğinize emin misiniz?')"
                            >
                                <i class="bi bi-trash"></i>
                                Görseli Sil
                            </button>
                        </form>
                    </div>
                    @endif

                    <!-- Yeni Görsel Yükle -->
                    <div class="form-group">
                        <label for="featured_image" class="form-label">
                            {{ $blog->featured_image ? 'Yeni Görsel Yükle' : 'Görsel Yükle' }}
                        </label>
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
                            value="{{ old('image_alt', $blog->image_alt) }}"
                            placeholder="Görsel açıklaması (SEO için)"
                        >
                    </div>
                </div>
            </div>

            <!-- Etiketler -->
            <div class="data-card" style="margin-bottom: 24px;">
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
                            value="{{ old('tags', $blog->tags ? implode(', ', $blog->tags) : '') }}"
                            placeholder="sigorta, kasko, trafik"
                        >
                        <small style="color: #94a3b8; font-size: 12px; display: block; margin-top: 6px;">
                            Virgülle ayırarak yazın
                        </small>
                    </div>
                </div>
            </div>

            <!-- İstatistikler -->
            <div class="data-card" style="margin-bottom: 24px;">
                <div class="data-card-header">
                    <h3 class="data-card-title">İstatistikler</h3>
                </div>
                <div class="data-card-body">
                    <div style="display: grid; gap: 12px;">
                        <div style="display: flex; justify-content: space-between; padding: 12px; background: var(--admin-light); border-radius: 8px;">
                            <span style="color: #64748b;">Oluşturulma</span>
                            <span style="font-weight: 600;">{{ $blog->created_at->format('d.m.Y H:i') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding: 12px; background: var(--admin-light); border-radius: 8px;">
                            <span style="color: #64748b;">Son Güncelleme</span>
                            <span style="font-weight: 600;">{{ $blog->updated_at->format('d.m.Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div style="display: grid; gap: 12px;">
                <button type="submit" class="btn-primary" style="width: 100%; padding: 14px;">
                    <i class="bi bi-check-circle"></i>
                    Değişiklikleri Kaydet
                </button>

                <form method="POST" action="{{ route('admin.blogs.destroy', $blog) }}" onsubmit="return confirm('Bu blog yazısını silmek istediğinize emin misiniz? Bu işlem geri alınamaz!')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-primary" style="width: 100%; padding: 14px; background: var(--admin-danger);">
                        <i class="bi bi-trash"></i>
                        Blog Yazısını Sil
                    </button>
                </form>
            </div>
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
            [{ 'font': [] }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'script': 'sub'}, { 'script': 'super' }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            [{ 'direction': 'rtl' }],
            [{ 'align': [] }],
            ['blockquote', 'code-block'],
            ['link', 'image', 'video'],
            ['clean']
        ]
    },
    placeholder: 'Blog içeriğini buraya yazın...'
});

// Mevcut içeriği Quill'e yükle
const existingContent = {!! json_encode(old('content', $blog->content)) !!};
quill.root.innerHTML = existingContent;

// Form submit olduğunda Quill içeriğini hidden input'a aktar ve kontrol et
document.querySelector('form').addEventListener('submit', function(e) {
    const contentInput = document.querySelector('#content-hidden');
    const quillContent = quill.root.innerHTML;

    // Quill içeriğini hidden input'a aktar
    contentInput.value = quillContent;

    // İçerik boş mu kontrol et
    const textContent = quill.getText().trim();

    if (textContent.length === 0) {
        e.preventDefault();
        alert('İçerik alanı zorunludur. Lütfen blog içeriğini yazın.');

        // Quill editor'a focus
        quill.focus();

        // Quill editor'ı kırmızı border yap
        document.querySelector('.ql-container').style.border = '2px solid var(--admin-danger)';

        setTimeout(() => {
            document.querySelector('.ql-container').style.border = '2px solid var(--admin-border)';
        }, 3000);

        return false;
    }
});

// Quill'e yazı yazılınca border'ı normal yap
quill.on('text-change', function() {
    document.querySelector('.ql-container').style.border = '2px solid var(--admin-border)';
});
</script>

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
