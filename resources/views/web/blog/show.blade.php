@extends('web.layouts.app')

@section('title', $blog->meta_title ?: $blog->title)
@section('meta_description', $blog->meta_description ?: $blog->getExcerptOrContent(160))
@section('meta_keywords', $blog->meta_keywords)

@section('content')

<!-- Professional Article Container -->
<article class="blog-article-professional">

    <!-- Breadcrumb & Meta -->
    <section class="article-header-section py-4 py-md-5">
        <div class="container-narrow">
            <div class="row">
                <div class="col-md-8">
                     <!-- Breadcrumb -->
                    <nav class="article-breadcrumb">
                        <a href="{{ route('home') }}" class="breadcrumb-link">Anasayfa</a>
                        <i class="bi bi-chevron-right"></i>
                        <a href="{{ route('blog.index') }}" class="breadcrumb-link">Blog</a>
                        <i class="bi bi-chevron-right"></i>
                        <span class="breadcrumb-current">Makale</span>
                    </nav>

                    <!-- Category Badge -->
                    @if($blog->tags && count($blog->tags) > 0)
                    <div class="article-category-badge">
                        <i class="bi bi-folder"></i>
                        {{ $blog->tags[0] }}
                    </div>
                    @endif

                    <!-- Title -->
                    <h1 class="article-title">{{ $blog->title }}</h1>

                    <!-- Excerpt -->
                    @if($blog->excerpt)
                    <p class="article-lead">{{ $blog->excerpt }}</p>
                    @endif

                    <!-- Meta Info -->
                    <div class="article-meta-bar">
                        <div class="meta-item">
                            <i class="bi bi-calendar-event"></i>
                            <span>{{ $blog->published_at->format('d F Y') }}</span>
                        </div>
                        @if($blog->tags && count($blog->tags) > 1)
                        <div class="meta-divider">•</div>
                        <div class="meta-item">
                            <i class="bi bi-tags"></i>
                            <span>{{ count($blog->tags) }} etiket</span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <!-- Featured Image -->
                    @if($blog->featured_image)
                    <section class="article-featured-image">
                        <div class="container-wide">
                            <div class="featured-image-wrapper">
                                <img
                                    src="{{ $blog->getImageUrl() }}"
                                    alt="{{ $blog->image_alt ?: $blog->title }}"
                                    class="featured-image"
                                >
                            </div>
                        </div>
                    </section>
                    @endif
                </div>
            </div>

        </div>
    </section>



    <!-- Article Content & Sidebar -->
    <section class="article-content-section py-4">
        <div class="container-narrow">
            <div class="article-layout">

                <!-- Main Content -->
                <div class="article-main-content">
                    <!-- Content -->
                    <div class="article-body">
                        {!! $blog->content !!}
                    </div>

                    <!-- Tags -->
                    @if($blog->tags && count($blog->tags) > 0)
                    <div class="article-tags-section">
                        <h4 class="tags-title">Etiketler</h4>
                        <div class="tags-list">
                            @foreach($blog->tags as $tag)
                            <a href="{{ route('blog.index', ['tag' => $tag]) }}" class="tag-item">
                                {{ $tag }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Share -->
                    <div class="article-share-section">
                        <h4 class="share-title">Paylaş</h4>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($blog->getUrl()) }}"
                               target="_blank"
                               rel="noopener"
                               class="share-button facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode($blog->getUrl()) }}&text={{ urlencode($blog->title) }}"
                               target="_blank"
                               rel="noopener"
                               class="share-button twitter">
                                <i class="bi bi-twitter-x"></i>
                            </a>
                            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($blog->getUrl()) }}&title={{ urlencode($blog->title) }}"
                               target="_blank"
                               rel="noopener"
                               class="share-button linkedin">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($blog->title . ' - ' . $blog->getUrl()) }}"
                               target="_blank"
                               rel="noopener"
                               class="share-button whatsapp">
                                <i class="bi bi-whatsapp"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Back Button -->
                    <div class="article-navigation">
                        <a href="{{ route('blog.index') }}" class="back-button">
                            <i class="bi bi-arrow-left"></i>
                            Tüm Makalelere Dön
                        </a>
                    </div>
                </div>

                <!-- Sidebar -->
                <aside class="article-sidebar">
                    <!-- TOC -->
                    <div class="sidebar-card toc-card">
                        <h4 class="sidebar-card-title">İçindekiler</h4>
                        <div id="table-of-contents" class="toc-content">
                            <!-- JS ile doldurulacak -->
                        </div>
                    </div>

                    <!-- CTA Card -->
                    <div class="sidebar-card cta-card">
                        <div class="cta-card-icon">
                            <i class="bi bi-rocket-takeoff"></i>
                        </div>
                        <h4 class="cta-card-title">Ücretsiz Demo</h4>
                        <p class="cta-card-text">
                            Sigorta yönetim sistemimizi 14 gün ücretsiz deneyin.
                        </p>
                        <a href="{{ route('demo.form') }}" class="cta-card-button">
                            Hemen Başla
                            <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </aside>

            </div>
        </div>
    </section>

</article>

<!-- Related Articles -->
@if($latestBlogs->count() > 0)
<section class="related-articles-section">
    <div class="container-narrow">
        <h2 class="related-section-title">Benzer Makaleler</h2>

        <div class="related-articles-grid">
            @foreach($latestBlogs as $relatedBlog)
            <article class="related-article-card">
                @if($relatedBlog->featured_image)
                <a href="{{ $relatedBlog->getUrl() }}" class="related-card-image">
                    <img src="{{ $relatedBlog->getImageUrl() }}" alt="{{ $relatedBlog->title }}">
                </a>
                @endif

                <div class="related-card-content">
                    <div class="related-card-meta">
                        {{ $relatedBlog->published_at->format('d.m.Y') }}
                    </div>

                    <h3 class="related-card-title">
                        <a href="{{ $relatedBlog->getUrl() }}">{{ $relatedBlog->title }}</a>
                    </h3>

                    <p class="related-card-excerpt">
                        {{ $relatedBlog->getExcerptOrContent(100) }}
                    </p>

                    <a href="{{ $relatedBlog->getUrl() }}" class="related-card-link">
                        Devamını Oku <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@push('styles')
<style>
/* ========================================
   PROFESSIONAL BLOG ARTICLE - CORPORATE
======================================== */

/* Containers */
.container-narrow {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

.container-wide {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Article Header */
.article-header-section {
    background: white;
}

.article-breadcrumb {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 24px;
    font-size: 14px;
}

.breadcrumb-link {
    color: #6b7280;
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-link:hover {
    color: #3b82f6;
}

.article-breadcrumb i {
    color: #d1d5db;
    font-size: 12px;
}

.breadcrumb-current {
    color: #9ca3af;
}

.article-category-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    background: #eff6ff;
    color: #3b82f6;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    margin-bottom: 24px;
}

.article-title {
    font-size: 42px;
    font-weight: 700;
    line-height: 1.2;
    color: #111827;
    margin-bottom: 20px;
    letter-spacing: -0.5px;
}

.article-lead {
    font-size: 20px;
    line-height: 1.7;
    color: #4b5563;
    margin-bottom: 32px;
}

.article-meta-bar {
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
    padding-bottom: 40px;
    border-bottom: 1px solid #e5e7eb;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #6b7280;
    font-size: 14px;
}

.meta-item i {
    color: #9ca3af;
}

.meta-divider {
    color: #d1d5db;
}

/* Featured Image */
.article-featured-image {
    background: white;
}

.featured-image-wrapper {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
}

.featured-image {
    width: 100%;
    height: auto;
    display: block;
}

/* Article Content Section */
.article-content-section {
    background: #f9fafb;
}

.article-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 60px;
}

/* Main Content */
.article-main-content {
    background: white;
    border-radius: 16px;
    padding: 48px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}

/* Article Body */
.article-body {
    font-size: 18px;
    line-height: 1.8;
    color: #374151;
}

.article-body h2,
.article-body h3,
.article-body h4 {
    font-weight: 700;
    color: #111827;
    margin-top: 2.5em;
    margin-bottom: 1em;
    line-height: 1.3;
}

.article-body h2 { font-size: 30px; }
.article-body h3 { font-size: 24px; }
.article-body h4 { font-size: 20px; }

.article-body p {
    margin-bottom: 1.5em;
}

.article-body a {
    color: #3b82f6;
    text-decoration: none;
    border-bottom: 1px solid rgba(59, 130, 246, 0.3);
    transition: border-color 0.3s ease;
}

.article-body a:hover {
    border-bottom-color: #3b82f6;
}

.article-body img {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    margin: 2.5em 0;
}

.article-body ul,
.article-body ol {
    margin-bottom: 1.5em;
    padding-left: 1.5em;
}

.article-body li {
    margin-bottom: 0.75em;
}

.article-body blockquote {
    border-left: 3px solid #3b82f6;
    padding: 1.5em;
    margin: 2em 0;
    background: #f9fafb;
    border-radius: 8px;
    color: #4b5563;
}

.article-body code {
    background: #f3f4f6;
    padding: 3px 8px;
    border-radius: 4px;
    font-family: 'Monaco', 'Courier New', monospace;
    font-size: 0.9em;
    color: #dc2626;
}

.article-body pre {
    background: #1f2937;
    color: #f3f4f6;
    padding: 1.5em;
    border-radius: 12px;
    overflow-x: auto;
    margin: 2em 0;
}

.article-body pre code {
    background: none;
    padding: 0;
    color: inherit;
}

/* Tags Section */
.article-tags-section {
    margin-top: 48px;
    padding-top: 32px;
    border-top: 1px solid #e5e7eb;
}

.tags-title {
    font-size: 16px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 16px;
}

.tags-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.tag-item {
    padding: 8px 16px;
    background: #f3f4f6;
    color: #4b5563;
    border-radius: 6px;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.3s ease;
}

.tag-item:hover {
    background: #3b82f6;
    color: white;
}

/* Share Section */
.article-share-section {
    margin-top: 32px;
    padding-top: 32px;
    border-top: 1px solid #e5e7eb;
}

.share-title {
    font-size: 16px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 16px;
}

.share-buttons {
    display: flex;
    gap: 12px;
}

.share-button {
    width: 44px;
    height: 44px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    color: white;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 18px;
}

.share-button:hover {
    transform: translateY(-2px);
}

.share-button.facebook { background: #1877f2; }
.share-button.twitter { background: #000000; }
.share-button.linkedin { background: #0077b5; }
.share-button.whatsapp { background: #25d366; }

/* Navigation */
.article-navigation {
    margin-top: 48px;
}

.back-button {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    padding: 12px 24px;
    background: #f9fafb;
    color: #4b5563;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 1px solid #e5e7eb;
}

.back-button:hover {
    background: #3b82f6;
    color: white;
    border-color: #3b82f6;
}

/* Sidebar */
.article-sidebar {
    position: relative;
}

.sidebar-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
    border: 1px solid #e5e7eb;
    position: sticky;
    top: 100px;
}

.sidebar-card-title {
    font-size: 16px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 16px;
}

/* TOC */
.toc-content a {
    display: block;
    padding: 10px 0;
    color: #6b7280;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s ease;
    border-left: 2px solid transparent;
    padding-left: 12px;
}

.toc-content a:hover,
.toc-content a.active {
    color: #3b82f6;
    border-left-color: #3b82f6;
    padding-left: 16px;
}

/* CTA Card */
.cta-card {
    background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
    color: white;
    border: none;
    text-align: center;
}

.cta-card-icon {
    width: 60px;
    height: 60px;
    background: rgba(255,255,255,0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 28px;
}

.cta-card-title {
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 12px;
    color: white;
}

.cta-card-text {
    font-size: 14px;
    line-height: 1.6;
    opacity: 0.95;
    margin-bottom: 20px;
}

.cta-card-button {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: white;
    color: #3b82f6;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 700;
    transition: all 0.3s ease;
}

.cta-card-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0,0,0,0.2);
}

/* Related Articles */
.related-articles-section {
    padding: 80px 20px;
    background: white;
}

.related-section-title {
    font-size: 28px;
    font-weight: 700;
    color: #111827;
    margin-bottom: 40px;
    text-align: center;
}

.related-articles-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
    gap: 32px;
}

.related-article-card {
    background: white;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.related-article-card:hover {
    border-color: #3b82f6;
    box-shadow: 0 8px 24px rgba(0,0,0,0.08);
    transform: translateY(-4px);
}

.related-card-image {
    display: block;
    overflow: hidden;
    aspect-ratio: 16/9;
}

.related-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.related-article-card:hover .related-card-image img {
    transform: scale(1.05);
}

.related-card-content {
    padding: 24px;
}

.related-card-meta {
    color: #6b7280;
    font-size: 13px;
    margin-bottom: 12px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.related-card-title {
    font-size: 18px;
    font-weight: 700;
    line-height: 1.4;
    margin-bottom: 12px;
}

.related-card-title a {
    color: #111827;
    text-decoration: none;
    transition: color 0.3s ease;
}

.related-card-title a:hover {
    color: #3b82f6;
}

.related-card-excerpt {
    font-size: 15px;
    line-height: 1.7;
    color: #6b7280;
    margin-bottom: 16px;
}

.related-card-link {
    color: #3b82f6;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: gap 0.3s ease;
}

.related-card-link:hover {
    gap: 10px;
}

/* Responsive */
@media (max-width: 1024px) {
    .article-layout {
        grid-template-columns: 1fr;
    }

    .article-sidebar {
        display: none;
    }
}

@media (max-width: 768px) {
    .article-title {
        font-size: 32px;
    }

    .article-lead {
        font-size: 17px;
    }

    .article-main-content {
        padding: 32px 24px;
    }

    .article-body {
        font-size: 16px;
    }

    .share-buttons {
        justify-content: space-between;
    }

    .related-articles-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Professional TOC Generator
document.addEventListener('DOMContentLoaded', function() {
    const content = document.querySelector('.article-body');
    const toc = document.getElementById('table-of-contents');

    if (content && toc) {
        const headings = content.querySelectorAll('h2, h3');

        if (headings.length > 0) {
            headings.forEach((heading, index) => {
                const id = 'section-' + index;
                heading.id = id;

                const link = document.createElement('a');
                link.href = '#' + id;
                link.textContent = heading.textContent;

                if (heading.tagName === 'H3') {
                    link.style.paddingLeft = '24px';
                    link.style.fontSize = '13px';
                }

                toc.appendChild(link);

                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    heading.scrollIntoView({ behavior: 'smooth', block: 'start' });

                    toc.querySelectorAll('a').forEach(a => a.classList.remove('active'));
                    link.classList.add('active');
                });
            });
        } else {
            toc.closest('.sidebar-card').style.display = 'none';
        }
    }
});
</script>
@endpush
