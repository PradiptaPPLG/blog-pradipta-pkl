<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Menampilkan daftar artikel di halaman beranda / publik.
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'category', 'tag']);

        // Mengambil artikel published dengan eager loading untuk menghindari N+1 query problem
        $posts = Post::with(['user', 'category', 'tags'])
            ->published()
            ->filter($filters)
            ->latest('published_at')
            ->paginate(6)
            ->withQueryString();

        // Mengambil kategori beserta jumlah artikel published
        $categories = Category::has('publishedPosts')
            ->withCount('publishedPosts')
            ->orderBy('name')
            ->get();

        // Mengambil artikel populer berdasarkan views
        $popularPosts = Post::published()
            ->orderByDesc('views_count')
            ->take(4)
            ->get();

        // Kategori atau Tag aktif jika sedang difilter
        $currentCategory = $request->filled('category') 
            ? Category::where('slug', $request->category)->first() 
            : null;

        $currentTag = $request->filled('tag') 
            ? Tag::where('slug', $request->tag)->first() 
            : null;

        return view('blog.index', compact(
            'posts',
            'categories',
            'popularPosts',
            'currentCategory',
            'currentTag'
        ));
    }

    /**
     * Menampilkan detail satu artikel berdasarkan slug.
     */
    public function show(string $slug): View
    {
        // Ambil artikel published beserta relasi penulis, kategori, tags, dan komentar yang disetujui
        $post = Post::with([
            'user',
            'category',
            'tags',
            'approvedComments' => fn ($q) => $q->latest()->with('user')
        ])
        ->published()
        ->where('slug', $slug)
        ->firstOrFail();

        // Tambah counter pembaca (+1 view) dengan pengecekan aman agar tidak crash di serverless readonly
        try {
            $post->increment('views_count');
        } catch (\Throwable $e) {
            // Abaikan error write di serverless hosting seperti Vercel yang read-only
        }

        // Artikel terkait dalam kategori yang sama
        $relatedPosts = Post::published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }
}
