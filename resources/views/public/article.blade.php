@extends('layouts.public')

@section('title', $article->judul . ' - Blog Kami')
@section('meta-description', strip_tags(substr($article->isi, 0, 160)))
@section('og-title', $article->judul)
@section('og-description', strip_tags(substr($article->isi, 0, 160)))
@section('og-url', route('article.show', $article->slug))
@section('og-image', $article->gambar ? asset('storage/' . $article->gambar) : asset('images/default-og.jpg'))

@section('content')
<div style="padding: 32px 0 64px;">
    <div class="container">

        <!-- Breadcrumb -->
        <nav class="breadcrumb-modern" aria-label="Breadcrumb">
            <a href="{{ route('home') }}"><i class="bi bi-house"></i> Beranda</a>
            <i class="bi bi-chevron-right sep"></i>
            <a href="{{ route('category.show', $article->id_kategori) }}">{{ $article->kategori->nama_kategori }}</a>
            <i class="bi bi-chevron-right sep"></i>
            <span class="current">{{ Str::limit($article->judul, 40) }}</span>
        </nav>

        <div class="row g-4">

            <!-- ===== MAIN ARTICLE ===== -->
            <div class="col-lg-8">
                <article itemscope itemtype="https://schema.org/Article">

                    <!-- Category Badge -->
                    <a href="{{ route('category.show', $article->id_kategori) }}" class="article-hero-category" aria-label="Kategori: {{ $article->kategori->nama_kategori }}">
                        {{ $article->kategori->nama_kategori }}
                    </a>

                    <!-- Title -->
                    <h1 class="article-hero-title" itemprop="headline">{{ $article->judul }}</h1>

                    <!-- Meta Row -->
                    <div class="article-meta-row">
                        <div class="article-author-pill">
                            <div class="author-avatar" aria-hidden="true">
                                {{ strtoupper(substr($article->penulis->nama_depan, 0, 1)) }}
                            </div>
                            <div>
                                <div class="author-name" itemprop="author">{{ $article->penulis->nama_depan . ' ' . $article->penulis->nama_belakang }}</div>
                                <div class="author-date" itemprop="datePublished" content="{{ $article->created_at->toISOString() }}">
                                    {{ \Carbon\Carbon::parse($article->created_at)->format('d F Y, H:i') }} WIB
                                </div>
                            </div>
                        </div>
                        <span class="article-meta-sep">|</span>
                        <div class="article-meta-item">
                            <i class="bi bi-clock"></i>
                            <span>{{ max(1, ceil(str_word_count(strip_tags($article->isi)) / 200)) }} menit baca</span>
                        </div>
                        <div class="article-meta-item">
                            <i class="bi bi-chat-dots"></i>
                            <span>{{ $article->komentar->where('status', 'approved')->count() }} komentar</span>
                        </div>
                    </div>

                    <!-- Hero Image -->
                    @if($article->gambar)
                        <img class="article-hero-img"
                             src="{{ asset('storage/' . $article->gambar) }}"
                             alt="{{ $article->judul }}"
                             loading="lazy"
                             itemprop="image">
                    @else
                        <div style="width:100%;height:360px;background:linear-gradient(135deg,#1E3A8A,#2563EB);border-radius:20px;display:flex;align-items:center;justify-content:center;margin-bottom:28px;">
                            <i class="bi bi-image" style="font-size:64px;color:rgba(255,255,255,0.25);"></i>
                        </div>
                    @endif

                    <!-- Article Content -->
                    <div class="article-content" itemprop="articleBody">
                        {!! $article->isi !!}
                    </div>

                    <!-- Share & Back -->
                    <div style="margin-top:32px;padding-top:24px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;">
                        <a href="{{ route('home') }}" class="btn-read-more" style="font-size:14px;">
                            <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                        </a>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span style="font-size:12.5px;color:var(--text-muted);font-weight:500;">Bagikan:</span>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->judul) }}&url={{ urlencode(url()->current()) }}"
                               target="_blank" rel="noopener"
                               style="width:34px;height:34px;background:#1DA1F2;border-radius:8px;display:flex;align-items:center;justify-content:center;color:white;text-decoration:none;font-size:14px;"
                               aria-label="Share ke Twitter">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                               target="_blank" rel="noopener"
                               style="width:34px;height:34px;background:#1877F2;border-radius:8px;display:flex;align-items:center;justify-content:center;color:white;text-decoration:none;font-size:14px;"
                               aria-label="Share ke Facebook">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <button onclick="copyUrl()"
                                    style="width:34px;height:34px;background:var(--border);border:none;border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--text-secondary);cursor:pointer;font-size:14px;"
                                    id="copyBtn"
                                    aria-label="Salin tautan">
                                <i class="bi bi-link-45deg"></i>
                            </button>
                        </div>
                    </div>

                    <!-- ===== COMMENT SECTION ===== -->
                    <div class="comment-wrapper" role="region" aria-label="Komentar">
                        <h2 class="comment-section-title">
                            <i class="bi bi-chat-square-dots"></i>
                            Komentar
                            <span style="font-size:14px;font-weight:400;color:var(--text-muted);">({{ $article->komentar->where('status', 'approved')->count() }})</span>
                        </h2>

                        <!-- Comment Form -->
                        <div class="comment-form-box">
                            <p class="comment-form-title">Tinggalkan Komentar</p>
                            <form action="{{ route('komentar.store', $article->id) }}" method="POST">
                                @csrf
                                @if(!auth()->check())
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="nama_tamu" class="form-label-c">Nama <span style="color:var(--danger);">*</span></label>
                                        <input type="text"
                                               class="form-control-c @error('nama_tamu') is-invalid @enderror"
                                               id="nama_tamu"
                                               name="nama_tamu"
                                               value="{{ old('nama_tamu') }}"
                                               placeholder="Nama Anda"
                                               required>
                                        @error('nama_tamu')
                                        <div style="font-size:12px;color:var(--danger);margin-top:4px;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email_tamu" class="form-label-c">Email <span style="color:var(--danger);">*</span></label>
                                        <input type="email"
                                               class="form-control-c @error('email_tamu') is-invalid @enderror"
                                               id="email_tamu"
                                               name="email_tamu"
                                               value="{{ old('email_tamu') }}"
                                               placeholder="email@anda.com"
                                               required>
                                        @error('email_tamu')
                                        <div style="font-size:12px;color:var(--danger);margin-top:4px;">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                @endif
                                <div style="margin-bottom:12px;">
                                    <label for="isi_komentar" class="form-label-c">Komentar <span style="color:var(--danger);">*</span></label>
                                    <textarea class="form-control-c @error('isi_komentar') is-invalid @enderror"
                                              id="isi_komentar"
                                              name="isi_komentar"
                                              rows="4"
                                              placeholder="Tulis komentar Anda di sini..."
                                              required>{{ old('isi_komentar') }}</textarea>
                                    @error('isi_komentar')
                                    <div style="font-size:12px;color:var(--danger);margin-top:4px;">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit"
                                        style="display:inline-flex;align-items:center;gap:6px;background:var(--primary);color:white;border:none;padding:10px 22px;border-radius:10px;font-size:14px;font-weight:600;cursor:pointer;transition:all 0.2s ease;font-family:'Inter',sans-serif;"
                                        onmouseover="this.style.background='#1D4ED8';"
                                        onmouseout="this.style.background='var(--primary)';">
                                    <i class="bi bi-send"></i> Kirim Komentar
                                </button>
                            </form>
                        </div>

                        <!-- Comments List -->
                        @php $approvedComments = $article->komentar->where('status', 'approved'); @endphp
                        @if($approvedComments->count() > 0)
                            @foreach($approvedComments as $komentar)
                            <div class="comment-item">
                                <div class="comment-avatar" aria-hidden="true">
                                    {{ strtoupper(substr($komentar->user ? $komentar->user->nama_depan : $komentar->nama_tamu, 0, 1)) }}
                                </div>
                                <div class="comment-content-box">
                                    <div class="comment-author-row">
                                        <span class="comment-author-name">
                                            @if($komentar->user)
                                                {{ $komentar->user->nama_depan . ' ' . $komentar->user->nama_belakang }}
                                                <span style="font-size:10px;font-weight:600;background:rgba(37,99,235,0.1);color:var(--primary);padding:1px 6px;border-radius:99px;margin-left:4px;">Member</span>
                                            @else
                                                {{ $komentar->nama_tamu }}
                                            @endif
                                        </span>
                                        <span class="comment-date">{{ \Carbon\Carbon::parse($komentar->created_at)->format('d M Y, H:i') }} WIB</span>
                                    </div>
                                    <p class="comment-text">{{ $komentar->isi_komentar }}</p>
                                </div>
                            </div>
                            @endforeach
                        @else
                        <div style="text-align:center;padding:40px 20px;color:var(--text-muted);">
                            <i class="bi bi-chat-dots" style="font-size:40px;display:block;margin-bottom:12px;"></i>
                            <p style="font-size:14px;font-weight:600;color:var(--text-secondary);margin-bottom:4px;">Belum ada komentar</p>
                            <p style="font-size:13px;">Jadilah yang pertama berkomentar!</p>
                        </div>
                        @endif
                    </div>

                </article>
            </div>

            <!-- ===== SIDEBAR ===== -->
            <div class="col-lg-4">

                <!-- Related Articles -->
                @if($relatedArticles->count() > 0)
                <div class="sidebar-widget">
                    <p class="widget-title"><i class="bi bi-link-45deg me-2"></i>Artikel Terkait</p>
                    @foreach($relatedArticles as $related)
                    <div class="related-item">
                        @if($related->gambar)
                            <img class="related-item-img"
                                 src="{{ asset('storage/' . $related->gambar) }}"
                                 alt="{{ $related->judul }}"
                                 loading="lazy">
                        @else
                            <div class="related-item-img" style="background:linear-gradient(135deg,#EFF6FF,#DBEAFE);display:flex;align-items:center;justify-content:center;">
                                <i class="bi bi-image" style="font-size:18px;color:#93C5FD;"></i>
                            </div>
                        @endif
                        <div>
                            <a href="{{ route('article.show', $related->slug) }}" class="related-item-title">
                                {{ Str::limit($related->judul, 55) }}
                            </a>
                            <p class="related-item-date">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ \Carbon\Carbon::parse($related->created_at)->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <!-- Categories -->
                <div class="sidebar-widget" style="{{ $relatedArticles->count() ? 'margin-top: 20px;' : '' }}">
                    <p class="widget-title"><i class="bi bi-folder2-open me-2"></i>Kategori</p>
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

                <!-- Author Card -->
                <div class="sidebar-widget" style="margin-top:20px;background:linear-gradient(135deg,#F8FAFC,#EFF6FF);border-color:rgba(37,99,235,0.15);">
                    <p class="widget-title"><i class="bi bi-person-circle me-2"></i>Tentang Penulis</p>
                    <div style="display:flex;gap:12px;align-items:flex-start;">
                        <div style="width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--accent));display:flex;align-items:center;justify-content:center;color:white;font-size:18px;font-weight:700;flex-shrink:0;">
                            {{ strtoupper(substr($article->penulis->nama_depan, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-size:14px;font-weight:700;color:var(--text-primary);">{{ $article->penulis->nama_depan . ' ' . $article->penulis->nama_belakang }}</div>
                            <div style="font-size:11px;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;color:var(--primary);margin-top:2px;">Penulis</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function copyUrl() {
        navigator.clipboard.writeText(window.location.href).then(function() {
            const btn = document.getElementById('copyBtn');
            btn.innerHTML = '<i class="bi bi-check-lg"></i>';
            btn.style.background = 'var(--success)';
            btn.style.color = 'white';
            setTimeout(function() {
                btn.innerHTML = '<i class="bi bi-link-45deg"></i>';
                btn.style.background = 'var(--border)';
                btn.style.color = 'var(--text-secondary)';
            }, 2000);
        });
    }
</script>
@endsection
