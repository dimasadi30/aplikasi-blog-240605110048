<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\KategoriArtikel;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function show($slug)
    {
        // Get article by slug with eager loading
        $article = Artikel::with(['penulis', 'kategori', 'komentar'])
            ->where('slug', $slug)
            ->where('status', 'publish')
            ->firstOrFail();

        // Get 5 related articles from same category (excluding current)
        $relatedArticles = Artikel::with(['penulis', 'kategori'])
            ->where('id_kategori', $article->id_kategori)
            ->where('id', '!=', $article->id)
            ->where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get all categories for sidebar
        $categories = KategoriArtikel::withCount('artikel')
            ->orderBy('nama_kategori', 'asc')
            ->get();

        return view('public.article', compact('article', 'relatedArticles', 'categories'));
    }

    public function category($id)
    {
        $category = KategoriArtikel::findOrFail($id);
        
        $categories = KategoriArtikel::withCount('artikel')
            ->orderBy('nama_kategori', 'asc')
            ->get();

        $articles = Artikel::with(['penulis', 'kategori'])
            ->where('id_kategori', $id)
            ->where('status', 'publish')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('public.category', compact('articles', 'category', 'categories'));
    }
}
