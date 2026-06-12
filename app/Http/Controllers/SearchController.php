<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\SearchLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q', '');
        $kategori = $request->input('kategori', '');
        $penulis = $request->input('penulis', '');
        $sort = $request->input('sort', 'relevance');
        $dateFrom = $request->input('date_from', '');
        $dateTo = $request->input('date_to', '');

        // Validate and sanitize input
        $query = $this->sanitizeSearchQuery($query);
        
        // Generate cache key
        $cacheKey = 'search:' . md5($query . $kategori . $penulis . $sort . $dateFrom . $dateTo . $request->page);
        
        // Try to get from cache first
        $artikel = Cache::remember($cacheKey, 300, function () use ($query, $kategori, $penulis, $sort, $dateFrom, $dateTo) {
            $artikelQuery = Artikel::with('kategori', 'penulis')
                ->where('status', 'publish');

            // Apply search with relevance scoring
            if (!empty($query)) {
                $artikelQuery = $artikelQuery->search($query);
            }

            // Apply filters
            if (!empty($kategori)) {
                $artikelQuery->where('id_kategori', $kategori);
            }

            if (!empty($penulis)) {
                $artikelQuery->where('id_penulis', $penulis);
            }

            if (!empty($dateFrom)) {
                $artikelQuery->whereDate('created_at', '>=', $dateFrom);
            }

            if (!empty($dateTo)) {
                $artikelQuery->whereDate('created_at', '<=', $dateTo);
            }

            // Apply sorting
            switch ($sort) {
                case 'newest':
                    $artikelQuery->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $artikelQuery->orderBy('created_at', 'asc');
                    break;
                case 'popular':
                    $artikelQuery->orderBy('view_count', 'desc');
                    break;
                case 'relevance':
                default:
                    if (!empty($query)) {
                        $artikelQuery = $artikelQuery->withRelevance($query);
                    } else {
                        $artikelQuery->orderBy('created_at', 'desc');
                    }
                    break;
            }

            return $artikelQuery->paginate(10);
        });

        // Log search analytics
        if (!empty($query)) {
            $this->logSearch($query, $artikel->total(), $request);
        }

        $kategoriList = \App\Models\KategoriArtikel::orderBy('nama_kategori', 'asc')->get();
        $penulisList = \App\Models\User::where('role', 'penulis')->orderBy('nama_depan', 'asc')->get();

        return view('search.index', compact(
            'artikel',
            'query',
            'kategori',
            'penulis',
            'sort',
            'dateFrom',
            'dateTo',
            'kategoriList',
            'penulisList'
        ));
    }

    public function suggest(Request $request)
    {
        $query = $request->input('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $query = $this->sanitizeSearchQuery($query);
        
        $cacheKey = 'search:suggest:' . md5($query);
        
        $suggestions = Cache::remember($cacheKey, 600, function () use ($query) {
            return Artikel::where('status', 'publish')
                ->where('judul', 'like', '%' . $query . '%')
                ->orderBy('search_count', 'desc')
                ->limit(5)
                ->pluck('judul')
                ->map(function ($title) {
                    return [
                        'text' => $title,
                        'highlight' => $this->highlightMatch($title, $query)
                    ];
                });
        });

        return response()->json($suggestions);
    }

    private function sanitizeSearchQuery($query)
    {
        // Remove special characters and limit length
        $query = preg_replace('/[^a-zA-Z0-9\s\-]/u', '', $query);
        $query = trim($query);
        $query = substr($query, 0, 100); // Limit to 100 characters
        return $query;
    }

    private function logSearch($query, $resultsCount, $request)
    {
        try {
            SearchLog::create([
                'query' => $query,
                'user_id' => auth()->check() ? auth()->id() : null,
                'results_count' => $resultsCount,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } catch (\Exception $e) {
            // Log error but don't break search functionality
            \Log::error('Search log failed: ' . $e->getMessage());
        }
    }

    private function highlightMatch($text, $query)
    {
        $text = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
        $words = explode(' ', trim($query));
        foreach ($words as $word) {
            if (!empty($word)) {
                $escapedWord = htmlspecialchars($word, ENT_QUOTES, 'UTF-8');
                $text = str_ireplace($escapedWord, '<mark>' . $escapedWord . '</mark>', $text);
            }
        }
        return $text;
    }
}
