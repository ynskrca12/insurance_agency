<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Blog listesi
     */
    public function index(Request $request)
    {
        $query = Blog::query();

        // Arama
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Öne çıkanlar filtresi
        if ($request->filled('featured')) {
            $query->featured();
        }

        // Sıralama
        $blogs = $query->ordered()->paginate(15);

        return view('admin.blogs.index', compact('blogs'));
    }

    /**
     * Blog oluşturma formu
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Blog kaydet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_alt' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'order' => 'nullable|integer',
        ], [
            'title.required' => 'Başlık gereklidir.',
            'content.required' => 'İçerik gereklidir.',
            'featured_image.image' => 'Dosya bir resim olmalıdır.',
            'featured_image.max' => 'Resim boyutu en fazla 2MB olabilir.',
        ]);

        // Slug oluştur
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Tags işle (virgülle ayrılmış string -> array)
        if (isset($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        // Görsel yükle
        if ($request->hasFile('featured_image')) {
            $file = $request->file('featured_image');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $file->move(public_path('blog_images'), $fileName);

            $validated['featured_image'] = 'blog_images/' . $fileName;
        }

        // Yayın tarihi yoksa şimdi ata
        if (empty($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $blog = Blog::create($validated);

        return redirect()->route('admin.blogs.edit', $blog)
            ->with('success', 'Blog yazısı başarıyla oluşturuldu.');
    }

    /**
     * Blog detay
     */
    public function show(Blog $blog)
    {
        return view('blogs.show', compact('blog'));
    }

    /**
     * Blog düzenleme formu
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Blog güncelle
     */
    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug,' . $blog->id,
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'image_alt' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'published_at' => 'nullable|date',
            'is_featured' => 'boolean',
            'order' => 'nullable|integer',
        ], [
            'title.required' => 'Başlık gereklidir.',
            'content.required' => 'İçerik gereklidir.',
            'featured_image.image' => 'Dosya bir resim olmalıdır.',
            'featured_image.max' => 'Resim boyutu en fazla 2MB olabilir.',
        ]);

        // Slug oluştur
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Tags işle
        if (isset($validated['tags'])) {
            $validated['tags'] = array_map('trim', explode(',', $validated['tags']));
        }

        // Görsel yükle
        if ($request->hasFile('featured_image')) {

            // Eski görseli sil
            if (!empty($blog->featured_image)) {
                $oldPath = public_path($blog->featured_image);

                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }

            $file = $request->file('featured_image');

            $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

            $file->move(public_path('blog_images'), $fileName);

            $validated['featured_image'] = 'blog_images/' . $fileName;
        }


        $blog->update($validated);

        return redirect()->route('admin.blogs.edit', $blog)
            ->with('success', 'Blog yazısı başarıyla güncellendi.');
    }

    /**
     * Blog sil
     */
    public function destroy(Blog $blog)
    {
        // Görseli sil
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog yazısı başarıyla silindi.');
    }

    /**
     * Görsel sil
     */
    public function deleteImage(Blog $blog)
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
            $blog->update(['featured_image' => null, 'image_alt' => null]);
        }

        return back()->with('success', 'Görsel başarıyla silindi.');
    }
}
