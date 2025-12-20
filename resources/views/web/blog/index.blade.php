@extends('web.layouts.app')

@section('title', 'Blog - Sigorta Haberleri ve İpuçları')
@section('meta_description', 'Sigorta, finans ve risk yönetimi hakkında güncel haberler, ipuçları ve uzman görüşleri.')

@section('content')

<!-- Professional Header -->
<section class="blog-header">
    <div class="container">
        <div class="blog-header-content">
            <h1 class="blog-header-title">Bilgi Merkezi</h1>
            <p class="blog-header-subtitle">
                Sigorta sektöründen güncel haberler, uzman analizleri ve pratik bilgiler
            </p>
        </div>
    </div>
</section>

<!-- Search & Filter Bar -->
<section class="blog-toolbar">
    <div class="container">
        <div class="toolbar-wrapper">
            <!-- Search -->
            <form action="{{ route('blog.index') }}" method="GET" class="toolbar-search">
                <div class="search-input-wrapper">
                    <i class="bi bi-search search-icon"></i>
                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Konu, başlık veya etiket ara..."
                        value="{{ request('search') }}"
                    >
                    @if(request('search'))
                    <a href="{{ route('blog.index') }}" class="search-clear">
                        <i class="bi bi-x-lg"></i>
                    </a>
                    @endif
                </div>
                <button type="submit" class="search-submit">Ara</button>
            </form>

            <!-- Category Filter -->
            <div class="toolbar-filters">
                @php
                    $categories = ['Tümü', 'Kasko', 'Trafik Sigortası', 'Sağlık Sigortası', 'DASK', 'Konut Sigortası'];
                @endphp
                @foreach($categories as $index => $category)
                    @if($index === 0)
                        <a href="{{ route('blog.index') }}"
                           class="filter-item {{ !request('tag') ? 'active' : '' }}">
                            {{ $category }}
                        </a>
                    @else
                        <a href="{{ route('blog.index', ['tag' => $category]) }}"
                           class="filter-item {{ request('tag') == $category ? 'active' : '' }}">
                            {{ $category }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Blog Content -->
<section class="blog-content-section">
    <div class="container">

        @if($blogs->count() > 0)

        <!-- Results Info -->
        <div class="results-info">
            <p class="results-text">
                @if(request('search'))
                    <strong>{{ $blogs->total() }}</strong> sonuç bulundu: "{{ request('search') }}"
                @elseif(request('tag'))
                    <strong>{{ $blogs->total() }}</strong> yazı - {{ request('tag') }} kategorisi
                @else
                    <strong>{{ $blogs->total() }}</strong> yazı bulundu
                @endif
            </p>
        </div>

        <!-- Blog Grid -->
        <div class="blog-grid-professional">
            @foreach($blogs as $blog)
            <article class="blog-card-pro">
                <a href="{{ $blog->getUrl() }}" class="card-image-wrapper">
                    @if($blog->featured_image)
                    <img src="{{ $blog->getImageUrl() }}" alt="{{ $blog->image_alt ?: $blog->title }}" class="card-image">
                    @else
                    <div class="card-image-placeholder">
                        <i class="bi bi-file-text"></i>
                    </div>
                    @endif

                    @if($blog->is_featured)
                    <span class="card-featured-badge">
                        <i class="bi bi-star-fill"></i>
                    </span>
                    @endif
                </a>

                <div class="card-content-wrapper">
                    <div class="card-meta-row">
                        <span class="card-date">{{ $blog->published_at->format('d M Y') }}</span>
                        @if($blog->tags && count($blog->tags) > 0)
                        <span class="card-category">{{ $blog->tags[0] }}</span>
                        @endif
                    </div>

                    <h2 class="card-title">
                        <a href="{{ $blog->getUrl() }}">{{ $blog->title }}</a>
                    </h2>

                    <p class="card-excerpt">{{ $blog->getExcerptOrContent(140) }}</p>

                    <div class="card-footer-row">
                        <a href="{{ $blog->getUrl() }}" class="card-read-more">
                            Devamını Oku
                            <i class="bi bi-arrow-right"></i>
                        </a>

                        @if($blog->tags && count($blog->tags) > 1)
                        <div class="card-tags-count">
                            <i class="bi bi-tags"></i>
                            {{ count($blog->tags) - 1 }}+
                        </div>
                        @endif
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($blogs->hasPages())
        <div class="blog-pagination-wrapper">
            {{ $blogs->links() }}
        </div>
        @endif

        @else

        <!-- Empty State -->
        <div class="blog-empty-professional">
            <div class="empty-icon-wrapper">
                <i class="bi bi-search"></i>
            </div>
            <h3 class="empty-title">
                @if(request('search'))
                    Sonuç bulunamadı
                @else
                    Henüz içerik bulunmuyor
                @endif
            </h3>
            <p class="empty-description">
                @if(request('search'))
                    "{{ request('search') }}" araması için sonuç bulunamadı. Lütfen farklı anahtar kelimeler deneyin.
                @else
                    Yakında yeni içerikler yayınlayacağız. Takipte kalın!
                @endif
            </p>
            @if(request()->hasAny(['search', 'tag']))
            <a href="{{ route('blog.index') }}" class="empty-action-btn">
                <i class="bi bi-arrow-counterclockwise"></i>
                Tüm İçeriği Görüntüle
            </a>
            @endif
        </div>

        @endif

    </div>
</section>

@endsection

@push('styles')
<style>
/* ========================================
   PROFESSIONAL BLOG INDEX - CORPORATE STYLE
======================================== */

/* Professional Header */
.blog-header {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    padding: 80px 20px;
    position: relative;
    overflow: hidden;
}

.blog-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="rgba(255,255,255,0.05)" stroke-width="1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.3;
}

.blog-header-content {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
    position: relative;
    z-index: 1;
}

.blog-header-title {
    font-size: 42px;
    font-weight: 700;
    color: white;
    margin-bottom: 16px;
    letter-spacing: -0.5px;
}

.blog-header-subtitle {
    font-size: 18px;
    color: rgba(255,255,255,0.9);
    font-weight: 400;
    line-height: 1.6;
}

/* Toolbar */
.blog-toolbar {
    background: white;
    border-bottom: 1px solid #e5e7eb;
    padding: 24px 20px;
    position: sticky;
    top: 70px;
    z-index: 100;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

.toolbar-wrapper {
    max-width: 1200px;
    margin: 0 auto;
}

/* Search */
.toolbar-search {
    display: flex;
    gap: 12px;
    margin-bottom: 20px;
}

.search-input-wrapper {
    flex: 1;
    position: relative;
}

.search-icon {
    position: absolute;
    left: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #9ca3af;
    font-size: 18px;
}

.search-input {
    width: 100%;
    padding: 14px 20px 14px 52px;
    border: 2px solid #e5e7eb;
    border-radius: 8px;
    font-size: 15px;
    transition: all 0.3s ease;
    background: #f9fafb;
}

.search-input:focus {
    outline: none;
    border-color: #3b82f6;
    background: white;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.search-clear {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    color: #6b7280;
    text-decoration: none;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all 0.3s ease;
}

.search-clear:hover {
    background: #f3f4f6;
    color: #1f2937;
}

.search-submit {
    padding: 14px 32px;
    background: #3b82f6;
    color: white;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    font-size: 15px;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.search-submit:hover {
    background: #2563eb;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

/* Filters */
.toolbar-filters {
    display: flex;
    gap: 8px;
    flex-wrap: wrap;
}

.filter-item {
    padding: 10px 20px;
    background: #f9fafb;
    color: #4b5563;
    border-radius: 8px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.filter-item:hover {
    background: #f3f4f6;
    color: #1f2937;
}

.filter-item.active {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

/* Content Section */
.blog-content-section {
    padding: 60px 20px 100px;
    background: #f9fafb;
    min-height: 600px;
}

/* Results Info */
.results-info {
    margin-bottom: 32px;
    padding-bottom: 20px;
    border-bottom: 1px solid #e5e7eb;
}

.results-text {
    color: #6b7280;
    font-size: 15px;
}

.results-text strong {
    color: #1f2937;
    font-weight: 600;
}

/* Professional Blog Grid */
.blog-grid-professional {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(360px, 1fr));
    gap: 32px;
    max-width: 1200px;
    margin: 0 auto;
}

/* Professional Card */
.blog-card-pro {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
    display: flex;
    flex-direction: column;
}

.blog-card-pro:hover {
    border-color: #3b82f6;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    transform: translateY(-4px);
}

.card-image-wrapper {
    position: relative;
    display: block;
    overflow: hidden;
    background: #f3f4f6;
    aspect-ratio: 16/9;
}

.card-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.blog-card-pro:hover .card-image {
    transform: scale(1.05);
}

.card-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-size: 48px;
}

.card-featured-badge {
    position: absolute;
    top: 16px;
    right: 16px;
    width: 40px;
    height: 40px;
    background: rgba(251, 191, 36, 0.95);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    backdrop-filter: blur(8px);
}

.card-content-wrapper {
    padding: 24px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.card-meta-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}

.card-date {
    color: #6b7280;
    font-size: 13px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.card-category {
    padding: 4px 12px;
    background: #eff6ff;
    color: #3b82f6;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
}

.card-title {
    font-size: 20px;
    font-weight: 700;
    line-height: 1.4;
    margin-bottom: 12px;
    color: #1f2937;
}

.card-title a {
    color: inherit;
    text-decoration: none;
    transition: color 0.3s ease;
}

.card-title a:hover {
    color: #3b82f6;
}

.card-excerpt {
    font-size: 15px;
    line-height: 1.7;
    color: #6b7280;
    margin-bottom: auto;
    padding-bottom: 20px;
}

.card-footer-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-top: 20px;
    border-top: 1px solid #f3f4f6;
}

.card-read-more {
    color: #3b82f6;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 6px;
    transition: gap 0.3s ease;
}

.card-read-more:hover {
    gap: 10px;
}

.card-tags-count {
    color: #9ca3af;
    font-size: 13px;
    display: flex;
    align-items: center;
    gap: 4px;
}

/* Pagination */
.blog-pagination-wrapper {
    margin-top: 60px;
    display: flex;
    justify-content: center;
}

/* Professional Empty State */
.blog-empty-professional {
    text-align: center;
    padding: 100px 20px;
    max-width: 500px;
    margin: 0 auto;
}

.empty-icon-wrapper {
    width: 100px;
    height: 100px;
    background: #f3f4f6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 32px;
}

.empty-icon-wrapper i {
    font-size: 48px;
    color: #9ca3af;
}

.empty-title {
    font-size: 24px;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 12px;
}

.empty-description {
    font-size: 16px;
    line-height: 1.7;
    color: #6b7280;
    margin-bottom: 32px;
}

.empty-action-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: #3b82f6;
    color: white;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.empty-action-btn:hover {
    background: #2563eb;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
}

/* Responsive */
@media (max-width: 1024px) {
    .blog-grid-professional {
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    }
}

@media (max-width: 768px) {
    .blog-header {
        padding: 60px 20px;
    }

    .blog-header-title {
        font-size: 32px;
    }

    .blog-header-subtitle {
        font-size: 16px;
    }

    .blog-toolbar {
        top: 60px;
    }

    .toolbar-search {
        flex-direction: column;
    }

    .search-submit {
        width: 100%;
    }

    .toolbar-filters {
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 8px;
        -webkit-overflow-scrolling: touch;
    }

    .filter-item {
        white-space: nowrap;
    }

    .blog-grid-professional {
        grid-template-columns: 1fr;
        gap: 24px;
    }
}
</style>
@endpush
