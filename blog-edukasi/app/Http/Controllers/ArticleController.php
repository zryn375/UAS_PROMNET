<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function __construct()
    {
    // Hanya auth untuk create, store, edit, update, destroy
        $this->middleware('auth')->only(['create', 'store', 'edit', 'update', 'destroy', 'dashboard']);
    }

    // Tampilkan semua artikel (public)
    public function index()
    {
        $articles = Article::whereNotNull('published_at')
                          ->orderBy('published_at', 'desc')
                          ->paginate(6);
        
        $categories = Article::select('category')
                           ->distinct()
                           ->pluck('category');
        
        return view('articles.index', compact('articles', 'categories'));
    }

    // Tampilkan form buat artikel baru
    public function create()
    {
        return view('articles.create');
    }

    // Simpan artikel baru
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required',
            'summary' => 'required|max:500',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Inisialisasi data artikel
        $articleData = [
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . time(),
            'content' => $request->content,
            'summary' => $request->summary,
            'category' => $request->category,
            'reading_time' => $this->calculateReadingTime($request->content),
            'user_id' => Auth::id(),
            'published_at' => $request->publish_now ? now() : null,
        ];

        // Handle file upload - DI SINI KODE UPLOAD FILE
        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('covers', 'public');
            $articleData['cover_image'] = $path;
        }

        // Buat artikel
        $article = Article::create($articleData);

        return redirect()->route('articles.show', $article->slug)
                         ->with('success', 'Artikel berhasil dibuat!');
    }

    // Tampilkan detail artikel
    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        
        // Increment view count
        $article->incrementViewCount();
        
        $relatedArticles = Article::where('category', $article->category)
                                 ->where('id', '!=', $article->id)
                                 ->whereNotNull('published_at')
                                 ->limit(3)
                                 ->get();
        
        return view('articles.show', compact('article', 'relatedArticles'));
    }

    // Tampilkan form edit
    public function edit($id)
    {
        $article = Article::findOrFail($id);
        
        // Authorization
        if (Auth::id() != $article->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        return view('articles.edit', compact('article'));
    }

    // Update artikel
    public function update(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        
        // Authorization
        if (Auth::id() != $article->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'category' => 'required',
            'summary' => 'required|max:500',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update data artikel
        $article->title = $request->title;
        $article->content = $request->content;
        $article->summary = $request->summary;
        $article->category = $request->category;
        $article->reading_time = $this->calculateReadingTime($request->content);
        
        // Update published_at jika diperlukan
        if ($request->publish_now && !$article->published_at) {
            $article->published_at = now();
        }

        // Handle file upload - UPDATE FILE JIKA ADA
        if ($request->hasFile('cover_image')) {
            // Hapus file lama jika ada
            if ($article->cover_image) {
                Storage::disk('public')->delete($article->cover_image);
            }
            
            // Simpan file baru
            $path = $request->file('cover_image')->store('covers', 'public');
            $article->cover_image = $path;
        }

        // Simpan perubahan
        $article->save();

        return redirect()->route('articles.show', $article->slug)
                         ->with('success', 'Artikel berhasil diperbarui!');
    }

    // Hapus artikel
    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        
        // Authorization
        if (Auth::id() != $article->user_id && !Auth::user()->isAdmin()) {
            abort(403);
        }
        
        // Hapus file cover jika ada
        if ($article->cover_image) {
            Storage::disk('public')->delete($article->cover_image);
        }
        
        $article->delete();
        
        return redirect()->route('dashboard')
                         ->with('success', 'Artikel berhasil dihapus!');
    }

    // Dashboard artikel untuk admin/author
    public function dashboard()
    {
        $user = Auth::user();
        
        if ($user->isAdmin()) {
            $articles = Article::orderBy('created_at', 'desc')->paginate(10);
        } else {
            $articles = Article::where('user_id', $user->id)
                              ->orderBy('created_at', 'desc')
                              ->paginate(10);
        }
        
        return view('articles.dashboard', compact('articles'));
    }

    // Fungsi bantuan: hitung waktu baca
    private function calculateReadingTime($content)
    {
        $wordCount = str_word_count(strip_tags($content));
        $minutes = ceil($wordCount / 200); // Asumsi 200 kata per menit
        
        if ($minutes < 1) {
            return '1 menit';
        }
        
        return $minutes . ' menit';
    }
}