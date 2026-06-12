@extends('layouts.public')

@section('title', 'Blog Kami - Artikel Terbaru')
@section('meta-description', 'Blog Kami - Temukan artikel terbaru seputar teknologi, pemrograman, dan pengembangan web')
@section('og-title', 'Blog Kami')
@section('og-description', 'Blog Kami - Artikel terbaru seputar teknologi dan pemrograman')

@section('styles')
<style>
    .section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 12px;
    }
    .section-title {
        font-family: 'Poppins', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .section-title-dot {
        width: 8px;
        height: 8px;
        background: var(--primary);
        border-radius: 50%;
        flex-shrink: 0;
    }
    .section-count {
        font-size: 13px;
        color: var(--text-muted);
        font-weight: 400;
        font-family: 'Inter', sans-serif;
    }
</style>
@endsection

@section('content')
<!-- ===== HERO SECTION ===== -->
<section class="hero" aria-label="Hero Beranda">
    <div class="container">
        <div class="hero-content">
            <div class="hero-badge">
                <i class="bi bi-stars"></i> Platform Blog Modern
            </div>
            <h1>
                Temukan <span class="text-accent">Artikel</span><br>
                Terbaik Untuk Anda
            </h1>
            <p>Baca, pelajari, dan bagikan pengetahuan. Ribuan artikel berkualitas dari para penulis terbaik menunggu Anda.</p>
            <div class="hero-actions">
                <a href="#articles" class="btn-hero-primary">
                    <i class="bi bi-compass"></i> Jelajahi Sekarang
                </a>
                @guest
                <a href="{{ route('register') }}" class="btn-hero-secondary">
                    <i class="bi bi-pencil-square"></i> Mulai Menulis
                </a>
                @endguest
            </div>
        </div>
    </div>
</section>

<!-- ===== MAIN CONTENT ===== -->
<div class="container" id="articles" style="padding-top: 48px; padding-bottom: 64px;">
    <div class="row g-4">

        <!-- ===== ARTICLES COL ===== -->
        <div class="col-lg-8">

            @if($articles->count() > 0)
                <!-- Featured (first article) -->
                @php $featuredArticle = $articles->first(); @endphp
                @if(!$categoryId)
                <div class="mb-4">
                    <div class="article-card-featured" style="text-decoration:none;" id="featured-article">
                        <div class="img-wrap">
                            @if($featuredArticle->gambar)
                                <img src="{{ asset('storage/' . $featuredArticle->gambar) }}"
                                     alt="{{ $featuredArticle->judul }}"
                                     loading="lazy"
                                     style="width:100%;height:100%;object-fit:cover;">
                            @else
                                <div style="width:100%;height:100%;background:linear-gradient(135deg,#1E3A8A,#2563EB);display:flex;align-items:center;justify-content:center;">
                                    <i class="bi bi-image" style="font-size:48px;color:rgba(255,255,255,0.3);"></i>
                                </div>
                            @endif
                            <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.7) 0%,transparent 60%);"></div>
                            <span style="position:absolute;top:16px;left:16px;background:var(--primary);color:white;padding:4px 12px;border-radius:99px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;">
                                ⭐ Unggulan
                            </span>
                            <div style="position:absolute;bottom:0;left:0;right:0;padding:24px;">
                                <span style="display:inline-block;background:rgba(255,255,255,0.15);color:white;padding:3px 10px;border-radius:99px;font-size:11px;font-weight:600;text-transform:uppercase;margin-bottom:8px;">
                                    {{ $featuredArticle->kategori->nama_kategori }}
                                </span>
                                <a href="{{ route('article.show', $featuredArticle->slug) }}"
                                   style="display:block;font-family:'Poppins',sans-serif;font-size:1.25rem;font-weight:700;color:white;text-decoration:none;line-height:1.3;margin-bottom:8px;">
                                    {{ $featuredArticle->judul }}
                                </a>
                                <div style="display:flex;align-items:center;gap:12px;font-size:12px;color:rgba(255,255,255,0.7);">
                                    <span><i class="bi bi-person"></i> {{ $featuredArticle->penulis->nama_depan . ' ' . $featuredArticle->penulis->nama_belakang }}</span>
                                    <span><i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($featuredArticle->created_at)->format('d M Y') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Section Header -->
                <div class="section-header">
                    <h2 class="section-title">
                        <span class="section-title-dot"></span>
                        {{ $categoryId ? 'Artikel Kategori' : 'Artikel Terbaru' }}
                        <span class="section-count">({{ method_exists($articles, 'total') ? $articles->total() : $articles->count() }} artikel)</span>
                    </h2>
                    @if($categoryId)
                    <a href="{{ route('home') }}" style="font-size:13px;color:var(--primary);text-decoration:none;font-weight:600;display:flex;align-items:center;gap:4px;">
                        <i class="bi bi-arrow-left"></i> Semua Artikel
                    </a>
                    @endif
                </div>

                <!-- Articles Grid -->
                <div class="row g-4">
                    @foreach($articles as $article)
                        @if(!$categoryId && $loop->first) @continue @endif
                        <div class="col-md-6 animate-fade-up" style="animation-delay: {{ $loop->index * 0.05 }}s;">
                            <div class="article-card" id="article-card-{{ $article->id }}">
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
                                        <span>
                                            <i class="bi bi-person"></i>
                                            {{ $article->penulis->nama_depan }}
                                        </span>
                                        <span>
                                            <i class="bi bi-calendar3"></i>
                                            {{ \Carbon\Carbon::parse($article->created_at)->format('d M Y') }}
                                        </span>
                                    </div>
                                    <a href="{{ route('article.show', $article->slug) }}" class="article-card-title">
                                        {{ $article->judul }}
                                    </a>
                                    <p class="article-card-excerpt">
                                        {{ strip_tags(substr($article->isi, 0, 140)) }}...
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
                <!-- Empty State -->
                <div class="empty-state-public">
                    <i class="bi bi-file-earmark-text"></i>
                    <h3>Belum ada artikel</h3>
                    <p>Silakan kembali lagi nanti untuk artikel terbaru.</p>
                    @if(Auth::check() && (Auth::user()->isPenulis() || Auth::user()->isAdmin()))
                    <a href="{{ route('artikel.create') }}" style="display:inline-flex;align-items:center;gap:6px;margin-top:16px;background:var(--primary);color:white;padding:10px 24px;border-radius:10px;text-decoration:none;font-size:14px;font-weight:600;">
                        <i class="bi bi-plus-circle"></i> Tulis Artikel Pertama
                    </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- ===== SIDEBAR ===== -->
        <div class="col-lg-4">
            <!-- Kategori Widget -->
            <div class="sidebar-widget" id="kategori-widget">
                <p class="widget-title"><i class="bi bi-folder2-open me-2"></i>Kategori Artikel</p>
                <div>
                    <a href="{{ route('home') }}"
                       class="category-item {{ !$categoryId ? 'active' : '' }}">
                        <span style="display:flex;align-items:center;gap:8px;">
                            <i class="bi bi-grid-3x3-gap" style="font-size:14px;"></i>
                            Semua Artikel
                        </span>
                        <span class="category-count">{{ \App\Models\Artikel::where('status', 'publish')->count() }}</span>
                    </a>
                    @foreach($categories as $category)
                    <a href="{{ route('home', ['kategori' => $category->id]) }}"
                       class="category-item {{ $categoryId == $category->id ? 'active' : '' }}">
                        <span style="display:flex;align-items:center;gap:8px;">
                            <i class="bi bi-folder" style="font-size:14px;"></i>
                            {{ $category->nama_kategori }}
                        </span>
                        <span class="category-count">{{ $category->artikel_count }}</span>
                    </a>
                    @endforeach
                </div>
            </div>

            <!-- Quick Search Widget -->
            <div class="sidebar-widget" style="margin-top: 20px;">
                <p class="widget-title"><i class="bi bi-search me-2"></i>Cari Artikel</p>
                <form action="{{ route('search.index') }}" method="GET">
                    <div style="position:relative;">
                        <input type="text" name="q"
                               placeholder="Kata kunci pencarian..."
                               style="width:100%;padding:10px 40px 10px 14px;border:1.5px solid var(--border);border-radius:10px;font-size:14px;outline:none;font-family:'Inter',sans-serif;transition:all 0.2s ease;"
                               onfocus="this.style.borderColor='var(--primary)';this.style.boxShadow='0 0 0 3px rgba(37,99,235,0.1)';"
                               onblur="this.style.borderColor='var(--border)';this.style.boxShadow='none';">
                        <button type="submit" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:var(--primary);border:none;color:white;width:28px;height:28px;border-radius:6px;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:13px;">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- CTA Widget -->
            @guest
            <div class="sidebar-widget" style="margin-top: 20px; background: linear-gradient(135deg, #EFF6FF, #DBEAFE); border-color: rgba(37,99,235,0.2);">
                <div style="text-align:center;">
                    <div style="width:52px;height:52px;background:var(--primary);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;font-size:22px;color:white;">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div style="font-size:14px;font-weight:700;color:var(--text-primary);margin-bottom:6px;">Ingin Menulis?</div>
                    <div style="font-size:12.5px;color:var(--text-secondary);margin-bottom:16px;line-height:1.6;">Bergabunglah sebagai penulis dan bagikan pengetahuan Anda!</div>
                    <a href="{{ route('register') }}"
                       style="display:block;background:var(--primary);color:white;padding:10px;border-radius:10px;text-decoration:none;font-size:13px;font-weight:600;text-align:center;transition:all 0.2s ease;"
                       onmouseover="this.style.background='#1D4ED8';" onmouseout="this.style.background='var(--primary)';">
                        Daftar Gratis
                    </a>
                    <a href="{{ route('login') }}" style="display:block;margin-top:8px;font-size:12.5px;color:var(--primary);text-decoration:none;font-weight:500;">
                        Sudah punya akun? Masuk →
                    </a>
                </div>
            </div>
            @endguest
        </div>

    </div>
</div>
@endsection
