<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

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

        // Tag filtresi
        if ($request->filled('tag')) {
            $tag = $request->tag;
            $query->whereJsonContains('tags', $tag);
        }

        // Sıralama ve sayfalama
        $blogs = $query->orderBy('published_at', 'desc')
                       ->paginate(12);

        return view('web.blog.index', compact('blogs'));
    }

    /**
     * Blog detay
     */
    public function show($slug)
    {
        // Blog'u bul
        $blog = Blog::where('slug', $slug)
            // ->published()
            ->firstOrFail();

        // İlgili yazılar (aynı etiketlere sahip veya son yazılar)
        $latestBlogs = Blog::query()
            ->where('id', '!=', $blog->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('web.blog.show', compact('blog', 'latestBlogs'));
    }
}
