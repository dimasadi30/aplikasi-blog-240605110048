<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Artikel;
use App\Models\KategoriArtikel;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Get all categories with article count
        $categories = KategoriArtikel::withCount('artikel')
            ->orderBy('nama_kategori', 'asc')
            ->get();

        // Filter by category if selected
        $categoryId = $request->query('kategori');
        
        $query = Artikel::with(['penulis', 'kategori'])
            ->where('status', 'publish')
            ->orderBy('created_at', 'desc');

        if ($categoryId) {
            $query->where('id_kategori', $categoryId);
        }

        // Get 5 latest articles for homepage
        $articles = $query->limit(5)->get();

        return view('public.home', compact('articles', 'categories', 'categoryId'));
    }

    public function search(Request $request)
    {
        $searchTerm = $request->query('q');
        
        $categories = KategoriArtikel::withCount('artikel')
            ->orderBy('nama_kategori', 'asc')
            ->get();

        $query = Artikel::with(['penulis', 'kategori'])
            ->where('status', 'publish')
            ->orderBy('created_at', 'desc');

        if ($searchTerm) {
            $query->where(function($q) use ($searchTerm) {
                $q->where('judul', 'like', '%' . $searchTerm . '%')
                  ->orWhere('isi', 'like', '%' . $searchTerm . '%');
            });
        }

        $articles = $query->paginate(10);

        return view('public.search', compact('articles', 'categories', 'searchTerm'));
    }
}
