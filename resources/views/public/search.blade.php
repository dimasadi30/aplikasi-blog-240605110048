@extends('layouts.public')

@section('title', isset($searchTerm) && $searchTerm ? 'Pencarian: "' . $searchTerm . '" - Blog Kami' : 'Cari Artikel - Blog Kami')
@section('meta-description', 'Cari artikel di Blog Kami')
@section('og-title', 'Cari Artikel - Blog Kami')
@section('og-description', 'Temukan artikel yang Anda cari di Blog Kami')

@section('content')
<!-- Search Hero -->
<section class="search-hero" aria-label="Pencarian Artikel">
    <div class="container">
        <h1><i class="bi bi-search me-2"></i>Cari Artikel</h1>
        <p>Temukan artikel terbaik sesuai dengan minat Anda</p>
        <div class="search-input-wrapper">
            <form action="{{ route('search.index') }}" method="GET" role="search">
                <i class="bi bi-search search-input-icon"></i>
                <input type="text"
                       name="q"
                       class="search-input-big"
                       placeholder="Ketik kata kunci pencarian..."
                       value="{{ $searchTerm ?? '' }}"
                       autocomplete="off"
                       id="searchInput"
                       aria-label="Kata kunci pencarian">
                <button type="submit" class="search-input-btn" id="searchBtn">
                    Cari
                </button>
            </form>
        </div>
        @if(isset($searchTerm) && $searchTerm)
        <div style="margin-top:14px;font-size:13.5px;color:rgba(255,255,255,0.7);">
            Menampilkan hasil untuk: <strong style="color:white;">"{{ $searchTerm }}"</strong>
            — {{ $articles->count() }} artikel ditemukan
        </div>
        @endif
    </div>
</section>

<!-- Search Results -->
<div class="container" style="padding-top: 40px; padding-bottom: 64px;">
    <div class="row g-4">

        <!-- Results -->
        <div class="col-lg-8">
            @if(isset($searchTerm) && $searchTerm)
            <!-- Result Header -->
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:24px;flex-wrap:wrap;gap:8px;">
                <div>
                    <h2 style="font-size:16px;font-weight:700;color:var(--text-primary);margin:0;">
                        Hasil Pencarian
                    </h2>
                    <p style="font-size:13px;color:var(--text-muted);margin-top:2px;">
                        {{ $articles->count() }} artikel cocok dengan "<em>{{ $searchTerm }}</em>"
                    </p>
                </div>
                <a href="{{ route('search.index') }}"
                   style="display:flex;align-items:center;gap:6px;font-size:13px;color:var(--text-muted);text-decoration:none;border:1px solid var(--border);padding:7px 14px;border-radius:8px;transition:all 0.2s ease;"
                   onmouseover="this.style.borderColor='var(--primary)';this.style.color='var(--primary)';"
                   onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-muted)';">
                    <i class="bi bi-x-circle"></i> Hapus Filter
                </a>
            </div>

            @if($articles->count() > 0)
            <div class="row g-4">
                @foreach($articles as $article)
                <div class="col-md-6 animate-fade-up" style="animation-delay: {{ $loop->index * 0.05 }}s;">
                    <div class="article-card" id="search-result-{{ $article->id }}">
                        <div class="article-card-img-wrap">
                            @if($article->gambar)
                                <img class="article-card-img"
                                     src="{{ asset('storage/' . $article->gambar) }}"
                                     alt="{{ $article->judul }}"
                                     loading="lazy">
                            @else
                                <div class="article-card-img" style="background:linear-gradient(135deg,#EFF6FF,#DBEAFE);display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-image" style="font-size:32px;color:#93C5FD;"></i>
                                </div>
                            @endif
                            <span class="article-card-category">{{ $article->kategori->nama_kategori }}</span>
                        </div>
                        <div class="article-card-body">
                            <div class="article-card-meta">
                                <span><i class="bi bi-person"></i> {{ $article->penulis->nama_depan }}</span>
                                <span><i class="bi bi-calendar3"></i> {{ \Carbon\Carbon::parse($article->created_at)->format('d M Y') }}</span>
                            </div>
                            <a href="{{ route('article.show', $article->slug) }}" class="article-card-title">
                                {{ $article->judul }}
                            </a>
                            <p class="article-card-excerpt">
                                {{ strip_tags(substr($article->isi, 0, 130)) }}...
                            </p>
                            <a href="{{ route('article.show', $article->slug) }}" class="btn-read-more">
                                Baca Selengkapnya <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if(method_exists($articles, 'hasPages') && $articles->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $articles->links() }}
            </div>
            @endif

            @else
            <!-- No Results -->
            <div class="empty-state-public">
                <i class="bi bi-search"></i>
                <h3>Tidak ada artikel ditemukan</h3>
                <p>Tidak ada artikel yang cocok dengan kata kunci "<strong>{{ $searchTerm }}</strong>".<br>Coba kata kunci yang berbeda.</p>
                <div style="display:flex;gap:12px;justify-content:center;flex-wrap:wrap;margin-top:20px;">
                    <a href="{{ route('home') }}"
                       style="display:inline-flex;align-items:center;gap:6px;background:var(--primary);color:white;padding:10px 22px;border-radius:10px;text-decoration:none;font-size:14px;font-weight:600;">
                        <i class="bi bi-house"></i> Ke Beranda
                    </a>
                    <a href="{{ route('search.index') }}"
                       style="display:inline-flex;align-items:center;gap:6px;background:white;color:var(--text-primary);border:1px solid var(--border);padding:10px 22px;border-radius:10px;text-decoration:none;font-size:14px;font-weight:600;">
                        <i class="bi bi-search"></i> Cari Lagi
                    </a>
                </div>
            </div>
            @endif

            @else
            <!-- Default State (no query) -->
            <div style="background:white;border:1px solid var(--border);border-radius:16px;padding:48px 32px;text-align:center;">
                <div style="width:72px;height:72px;background:rgba(37,99,235,0.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px;font-size:28px;color:var(--primary);">
                    <i class="bi bi-search"></i>
                </div>
                <h2 style="font-size:17px;font-weight:700;color:var(--text-primary);margin-bottom:8px;">Mulai Pencarian</h2>
                <p style="font-size:14px;color:var(--text-muted);max-width:360px;margin:0 auto 24px;line-height:1.6;">
                    Ketik kata kunci di kolom pencarian di atas untuk menemukan artikel yang Anda inginkan.
                </p>
                <div style="display:flex;gap:8px;flex-wrap:wrap;justify-content:center;">
                    @foreach($categories as $cat)
                    <a href="{{ route('category.show', $cat->id) }}"
                       style="display:inline-flex;align-items:center;gap:5px;background:rgba(37,99,235,0.08);color:var(--primary);padding:6px 14px;border-radius:99px;text-decoration:none;font-size:13px;font-weight:500;border:1px solid rgba(37,99,235,0.15);transition:all 0.2s ease;"
                       onmouseover="this.style.background='var(--primary)';this.style.color='white';"
                       onmouseout="this.style.background='rgba(37,99,235,0.08)';this.style.color='var(--primary)';">
                        <i class="bi bi-folder"></i>{{ $cat->nama_kategori }}
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="sidebar-widget">
                <p class="widget-title"><i class="bi bi-folder2-open me-2"></i>Jelajahi Kategori</p>
                <a href="{{ route('home') }}" class="category-item">
                    <span style="display:flex;align-items:center;gap:8px;">
                        <i class="bi bi-grid-3x3-gap" style="font-size:14px;"></i> Semua Artikel
                    </span>
                    <span class="category-count">{{ \App\Models\Artikel::where('status', 'publish')->count() }}</span>
                </a>
                @foreach($categories as $category)
                <a href="{{ route('category.show', $category->id) }}" class="category-item">
                    <span style="display:flex;align-items:center;gap:8px;">
                        <i class="bi bi-folder" style="font-size:14px;"></i>
                        {{ $category->nama_kategori }}
                    </span>
                    <span class="category-count">{{ $category->artikel_count }}</span>
                </a>
                @endforeach
            </div>

            <!-- Tips Widget -->
            <div class="sidebar-widget" style="margin-top:20px;">
                <p class="widget-title"><i class="bi bi-lightbulb me-2"></i>Tips Pencarian</p>
                <div style="display:flex;flex-direction:column;gap:10px;">
                    <div style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:var(--text-secondary);">
                        <i class="bi bi-dot" style="font-size:20px;color:var(--primary);flex-shrink:0;"></i>
                        Gunakan kata kunci yang spesifik
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:var(--text-secondary);">
                        <i class="bi bi-dot" style="font-size:20px;color:var(--primary);flex-shrink:0;"></i>
                        Coba kata kunci yang berbeda jika tidak ditemukan
                    </div>
                    <div style="display:flex;align-items:flex-start;gap:8px;font-size:13px;color:var(--text-secondary);">
                        <i class="bi bi-dot" style="font-size:20px;color:var(--primary);flex-shrink:0;"></i>
                        Pilih kategori untuk menyaring hasil
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
<script>
    // Focus input on load
    document.getElementById('searchInput').focus();
</script>
@endsection
