<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;


class Blog extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'image_alt',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'tags',
        'published_at',
        'is_featured',
        'order',
    ];

    protected $casts = [
        'tags' => 'array',
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
    ];

    /**
     * Boot method - Slug otomatik oluştur
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($blog) {
            // Slug otomatik oluştur
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);

                // Slug unique olmalı
                $count = static::where('slug', 'LIKE', "{$blog->slug}%")->count();
                if ($count > 0) {
                    $blog->slug = "{$blog->slug}-" . ($count + 1);
                }
            }

            // Yayın tarihi yoksa şimdi ata
            if (empty($blog->published_at)) {
                $blog->published_at = now();
            }
        });

        static::updating(function ($blog) {
            // Slug değiştiriliyorsa unique kontrolü
            if ($blog->isDirty('slug')) {
                $count = static::where('slug', 'LIKE', "{$blog->slug}%")
                    ->where('id', '!=', $blog->id)
                    ->count();
                if ($count > 0) {
                    $blog->slug = "{$blog->slug}-" . ($count + 1);
                }
            }
        });
    }

    /**
     * Scopes
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')
                     ->where('published_at', '<=', now())
                     ->orderBy('published_at', 'desc');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('title', 'LIKE', "%{$search}%")
              ->orWhere('content', 'LIKE', "%{$search}%")
              ->orWhere('excerpt', 'LIKE', "%{$search}%");
        });
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('published_at', 'desc');
    }

    /**
     * Helper Methods
     */
    public function isPublished(): bool
    {
        return $this->published_at && $this->published_at->isPast();
    }

    public function getExcerptOrContent($limit = 200)
    {
        if ($this->excerpt) {
            return $this->excerpt;
        }

        return Str::limit(strip_tags($this->content), $limit);
    }

    public function getImageUrl()
    {
        if ($this->featured_image) {
            return asset('blog_images/' . $this->featured_image);
        }

        return asset('images/blog-placeholder.jpg');
    }

    public function getFormattedDate()
    {
        return $this->published_at ? $this->published_at->format('d F Y') : '-';
    }

    /**
     * URL Helper
     */
    public function getUrl()
    {
        return route('blog.show', $this->slug);
    }

    /**
     * Admin URL
     */
    public function getAdminUrl()
    {
        return route('admin.blogs.edit', $this->id);
    }
}
