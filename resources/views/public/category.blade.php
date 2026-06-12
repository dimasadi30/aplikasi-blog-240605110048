@extends('layouts.public')

@section('title', $category->nama_kategori . ' - Blog Kami')
@section('meta-description', 'Artikel kategori ' . $category->nama_kategori . ' di Blog Kami')
@section('og-title', $category->nama_kategori)
@section('og-description', 'Artikel kategori ' . $category->nama_kategori)

@section('content')
<!-- Category Hero -->
<section style="background: linear-gradient(135deg, #0F172A 0%, #1E293B 60%, #1E3A8A 100%); padding: 52px 0; position: relative; overflow: hidden;">
    <div style="position:absolute;width:400px;height:400px;background:radial-gradient(circle,rgba(37,99,235,0.25),transparent 65%);top:-150px;right:-80px;"></div>
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb-modern" style="margin-bottom: 20px;" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" style="color:rgba(255,255,255,0.6);"><i class="bi bi-house"></i> Beranda</a>
            <i class="bi bi-chevron-right sep" style="color:rgba(255,255,255,0.3);"></i>
            <span style="color:rgba(255,255,255,0.5);">Kategori</span>
            <i class="bi bi-chevron-right sep" style="color:rgba(255,255,255,0.3);"></i>
            <span style="color:white;">{{ $category->nama_kategori }}</span>
        </nav>

        <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
            <div style="width:56px;height:56px;background:linear-gradient(135deg,var(--primary),var(--accent));border-radius:14px;display:flex;align-items:center;justify-content:center;font-size:24px;color:white;flex-shrink:0;box-shadow:0 4px 16px rgba(37,99,235,0.4);">
                <i class="bi bi-folder-fill"></i>
            </div>
            <div>
                <div style="font-size:12px;color:rgba(255,255,255,0.5);font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:4px;">Kategori</div>
                <h1 style="font-family:'Poppins',sans-serif;font-size:clamp(1.5rem,4vw,2rem);font-weight:800;color:white;margin:0;letter-spacing:-0.02em;">
                    {{ $category->nama_kategori }}
                </h1>
                @if(isset($category->keterangan) && $category->keterangan)
                <p style="color:rgba(255,255,255,0.65);font-size:14px;margin-top:6px;">{{ $category->keterangan }}</p>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="container" style="padding-top: 40px; padding-bottom: 64px;">
    <div class="row g-4">

        <!-- Articles -->
        <div class="col-lg-8">
            @if($articles->count() > 0)
                <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:8px;">
                    <h2 style="font-size:14px;font-weight:600;color:var(--text-muted);margin:0;text-transform:uppercase;letter-spacing:0.06em;">
                        {{ method_exists($articles, 'total') ? $articles->total() : $articles->count() }} Artikel ditemukan
                    </h2>
                    <a href="{{ route('home') }}" style="font-size:13px;color:var(--primary);text-decoration:none;font-weight:600;display:flex;align-items:center;gap:4px;">
                        <i class="bi bi-arrow-left"></i> Semua Kategori
                    </a>
                </div>

                <div class="row g-4">
                    @foreach($articles as $article)
                    <div class="col-md-6 animate-fade-up" style="animation-delay: {{ $loop->index * 0.05 }}s;">
                        <div class="article-card" id="article-{{ $article->id }}">
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
            <div class="empty-state-public">
                <i class="bi bi-folder-x"></i>
                <h3>Belum ada artikel</h3>
                <p>Belum ada artikel pada kategori <strong>{{ $category->nama_kategori }}</strong>.</p>
                <a href="{{ route('home') }}" style="display:inline-flex;align-items:center;gap:6px;margin-top:16px;background:var(--primary);color:white;padding:10px 22px;border-radius:10px;text-decoration:none;font-size:14px;font-weight:600;">
                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                </a>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="sidebar-widget">
                <p class="widget-title"><i class="bi bi-folder2-open me-2"></i>Semua Kategori</p>
                <a href="{{ route('home') }}" class="category-item">
                    <span style="display:flex;align-items:center;gap:8px;">
                        <i class="bi bi-grid-3x3-gap" style="font-size:14px;"></i> Semua Artikel
                    </span>
                    <span class="category-count">{{ \App\Models\Artikel::where('status', 'publish')->count() }}</span>
                </a>
                @foreach($categories as $cat)
                <a href="{{ route('category.show', $cat->id) }}"
                   class="category-item {{ $cat->id == $category->id ? 'active' : '' }}">
                    <span style="display:flex;align-items:center;gap:8px;">
                        <i class="bi bi-folder" style="font-size:14px;"></i>
                        {{ $cat->nama_kategori }}
                    </span>
                    <span class="category-count">{{ $cat->artikel_count }}</span>
                </a>
                @endforeach
            </div>
        </div>

    </div>
</div>
@endsection
