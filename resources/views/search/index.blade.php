@extends('layouts.app')
@section('title', $query ? 'Cari: ' . $query . ' - Blog' : 'Cari Artikel - Blog')
@section('content')
<style>
    .search-container {
        padding: 1.5rem 0;
    }

    .search-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }

    .search-input-wrapper {
        position: relative;
        display: flex;
    }

    .search-input {
        border-radius: 0.625rem 0 0 0.625rem !important;
        border: 1.5px solid var(--border);
        padding: 0.875rem 1.25rem;
        font-size: 1rem;
        flex: 1;
        transition: all 0.2s ease;
        outline: none;
    }

    .search-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .search-btn {
        border-radius: 0 0.625rem 0.625rem 0 !important;
        padding: 0 1.5rem;
        background-color: var(--primary);
        border: 1.5px solid var(--primary);
        color: white;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .search-btn:hover {
        background-color: var(--primary-hover);
        border-color: var(--primary-hover);
    }

    /* Suggestions */
    .suggestions-dropdown {
        position: absolute;
        width: 100%;
        top: 100%;
        left: 0;
        z-index: 1000;
        display: none;
    }

    .suggestions-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 0.5rem;
        margin-top: 0.375rem;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .suggestion-item {
        padding: 0.625rem 1rem;
        cursor: pointer;
        border-bottom: 1px solid var(--border);
        font-size: 0.875rem;
        color: var(--text-primary);
        transition: background-color 0.15s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .suggestion-item::before {
        content: "\F52A";
        font-family: "bootstrap-icons";
        color: var(--text-muted);
        font-size: 0.75rem;
    }

    .suggestion-item:hover {
        background-color: #EFF6FF;
        color: var(--primary);
    }

    .suggestion-item:last-child {
        border-bottom: none;
    }

    /* Filters */
    .filter-row {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        align-items: center;
        margin-top: 0.875rem;
        padding-top: 0.875rem;
        border-top: 1px solid var(--border);
    }

    .filter-select,
    .filter-input {
        border-radius: 0.5rem;
        border: 1px solid var(--border);
        padding: 0.4rem 0.75rem;
        font-size: 0.8125rem;
        color: var(--text-primary);
        background: var(--card);
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .filter-select:focus,
    .filter-input:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.1);
        outline: none;
    }

    .filter-label {
        font-size: 0.75rem;
        font-weight: 600;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.04em;
        white-space: nowrap;
    }

    .btn-reset {
        background-color: #FEF2F2;
        border: 1px solid #FECACA;
        color: var(--danger);
        padding: 0.375rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.8125rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        margin-left: auto;
    }

    .btn-reset:hover {
        background-color: #FEE2E2;
        color: var(--danger);
    }

    /* Result Info Bar */
    .result-info {
        background-color: #EFF6FF;
        border: 1px solid #BFDBFE;
        border-radius: 0.625rem;
        padding: 0.75rem 1.25rem;
        font-size: 0.875rem;
        color: #1E40AF;
        margin-bottom: 1.25rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Result Cards */
    .result-card {
        background: var(--card);
        border: 1px solid var(--border);
        border-radius: 0.75rem;
        margin-bottom: 1rem;
        overflow: hidden;
        transition: all 0.2s ease;
        display: flex;
        text-decoration: none;
        color: inherit;
    }

    .result-card:hover {
        box-shadow: 0 6px 20px rgba(37, 99, 235, 0.1);
        border-color: rgba(37, 99, 235, 0.3);
        transform: translateY(-1px);
        color: inherit;
        text-decoration: none;
    }

    .result-card-accent {
        width: 4px;
        background: linear-gradient(180deg, var(--primary), #22C55E);
        flex-shrink: 0;
    }

    .result-image {
        width: 130px;
        height: 130px;
        object-fit: cover;
        flex-shrink: 0;
    }

    .result-body {
        padding: 1rem 1.25rem;
        flex: 1;
        min-width: 0;
    }

    .result-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.375rem;
        line-height: 1.4;
        transition: color 0.2s ease;
    }

    .result-card:hover .result-title {
        color: var(--primary);
    }

    .result-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        background-color: rgba(37, 99, 235, 0.08);
        color: var(--primary);
        padding: 0.2rem 0.6rem;
        border-radius: 2rem;
        font-size: 0.7rem;
        font-weight: 600;
        letter-spacing: 0.02em;
    }

    .result-date {
        color: var(--text-secondary);
        font-size: 0.78rem;
    }

    .result-relevance {
        background-color: #F0FDF4;
        color: #16A34A;
        padding: 0.2rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .result-snippet {
        color: var(--text-secondary);
        font-size: 0.8375rem;
        line-height: 1.6;
        margin: 0.5rem 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .result-meta {
        color: var(--text-muted);
        font-size: 0.78rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .result-meta-item {
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 4rem 1rem;
    }

    .empty-state-icon {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: var(--background);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.25rem;
        font-size: 2rem;
        color: var(--text-muted);
    }

    .empty-state h3 {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .empty-state p {
        font-size: 0.875rem;
        color: var(--text-secondary);
        margin: 0;
    }

    mark {
        background-color: #FEF08A;
        color: #713F12;
        padding: 0.05rem 0.15rem;
        border-radius: 0.2rem;
        font-weight: 500;
    }

    /* Pagination */
    .pagination .page-link {
        border-radius: 0.5rem;
        border: 1px solid var(--border);
        color: var(--text-primary);
        padding: 0.4rem 0.75rem;
        font-size: 0.875rem;
        margin: 0 2px;
        transition: all 0.2s ease;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary);
        border-color: var(--primary);
        color: white;
    }

    .pagination .page-link:hover {
        background-color: #EFF6FF;
        border-color: var(--primary);
        color: var(--primary);
    }
</style>

<div class="search-container">
    <div class="row justify-content-center mb-2">
        <div class="col-lg-10">

            {{-- Search Box --}}
            <div class="search-card">
                <form action="{{ route('search.index') }}" method="GET" id="searchForm">
                    <div style="position: relative;">
                        <div class="search-input-wrapper">
                            <input type="text" class="search-input" id="q" name="q"
                                   value="{{ old('q', $query) }}"
                                   placeholder="Cari artikel berdasarkan judul atau isi..."
                                   autocomplete="off">
                            <button type="submit" class="search-btn">
                                <i class="bi bi-search me-1"></i> Cari
                            </button>
                        </div>
                        {{-- Auto-suggestion dropdown --}}
                        <div id="suggestions" class="suggestions-dropdown">
                            <div class="suggestions-card">
                                <div id="suggestionsList"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Filter Row --}}
                    <div class="filter-row">
                        <span class="filter-label"><i class="bi bi-funnel me-1"></i>Filter:</span>

                        <select class="filter-select" id="kategori" name="kategori">
                            <option value="">Semua Kategori</option>
                            @foreach($kategoriList as $kat)
                            <option value="{{ $kat->id }}" {{ $kategori == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                            @endforeach
                        </select>

                        <select class="filter-select" id="penulis" name="penulis">
                            <option value="">Semua Penulis</option>
                            @foreach($penulisList as $p)
                            <option value="{{ $p->id }}" {{ (string)$penulis === (string)$p->id ? 'selected' : '' }}>
                                {{ $p->nama_depan }} {{ $p->nama_belakang }}
                            </option>
                            @endforeach
                        </select>

                        <select class="filter-select" id="sort" name="sort">
                            <option value="relevance" {{ $sort == 'relevance' ? 'selected' : '' }}>Relevansi</option>
                            <option value="newest"    {{ $sort == 'newest'    ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest"    {{ $sort == 'oldest'    ? 'selected' : '' }}>Terlama</option>
                            <option value="popular"   {{ $sort == 'popular'   ? 'selected' : '' }}>Terpopuler</option>
                        </select>

                        <input type="date" class="filter-input" id="date_from" name="date_from"
                               value="{{ $dateFrom }}" title="Dari tanggal">

                        <span style="color: var(--text-muted); font-size: 0.8rem;">s/d</span>

                        <input type="date" class="filter-input" id="date_to" name="date_to"
                               value="{{ $dateTo }}" title="Sampai tanggal">

                        @if($query || $kategori || $penulis || $dateFrom || $dateTo)
                        <a href="{{ route('search.index') }}" class="btn-reset">
                            <i class="bi bi-x-circle"></i> Reset
                        </a>
                        @endif
                    </div>
                </form>
            </div>

            {{-- Result Info --}}
            @if($query || $kategori || $penulis || $dateFrom || $dateTo)
            <div class="result-info">
                <i class="bi bi-info-circle-fill"></i>
                @if($query)
                    Hasil pencarian: <strong>"{{ $query }}"</strong>
                @endif
                @if($kategori)
                    @if($query) &middot; @endif
                    Kategori: <strong>{{ $kategoriList->where('id', $kategori)->first()->nama_kategori ?? '' }}</strong>
                @endif
                @if($penulis)
                    @if($query || $kategori) &middot; @endif
                    Penulis: <strong>{{ optional($penulisList->where('id', $penulis)->first())->nama_depan }} {{ optional($penulisList->where('id', $penulis)->first())->nama_belakang }}</strong>
                @endif
                @if($dateFrom || $dateTo)
                    @if($query || $kategori || $penulis) &middot; @endif
                    Tanggal: <strong>{{ $dateFrom ?? '-' }} s/d {{ $dateTo ?? '-' }}</strong>
                @endif
                &mdash; <strong>{{ $artikel->total() }}</strong> artikel ditemukan
            </div>
            @endif

            {{-- Results --}}
            @if($artikel->count() > 0)

                @foreach($artikel as $item)
                <a href="{{ route('article.show', $item->slug) }}" class="result-card">
                    <div class="result-card-accent"></div>
                    <img src="{{ asset('storage/' . $item->gambar) }}"
                         alt="{{ $item->judul }}"
                         class="result-image"
                         onerror="this.src='https://placehold.co/130x130/e2e8f0/94a3b8?text=No+Image'">
                    <div class="result-body">
                        <div class="result-title">
                            @php
                                $title = e($item->judul);
                                if ($query) {
                                    foreach (explode(' ', trim($query)) as $word) {
                                        if (!empty($word)) {
                                            $title = str_ireplace(e($word), '<mark>' . e($word) . '</mark>', $title);
                                        }
                                    }
                                }
                            @endphp
                            {!! $title !!}
                        </div>

                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                            <span class="result-badge">
                                <i class="bi bi-folder2"></i>
                                {{ $item->kategori->nama_kategori ?? 'Tanpa Kategori' }}
                            </span>
                            <span class="result-date">
                                <i class="bi bi-calendar3"></i>
                                {{ $item->hari_tanggal }}
                            </span>
                            @if(isset($item->relevance_score) && $item->relevance_score > 0)
                            <span class="result-relevance">
                                <i class="bi bi-star-fill"></i> Relevan
                            </span>
                            @endif
                        </div>

                        <p class="result-snippet">
                            @php
                                $snippet = strip_tags($item->isi);
                                $snippet = \Illuminate\Support\Str::limit($snippet, 180);
                                $snippet = e($snippet);
                                if ($query) {
                                    foreach (explode(' ', trim($query)) as $word) {
                                        if (!empty($word)) {
                                            $snippet = str_ireplace(e($word), '<mark>' . e($word) . '</mark>', $snippet);
                                        }
                                    }
                                }
                            @endphp
                            {!! $snippet !!}
                        </p>

                        <div class="result-meta">
                            <span class="result-meta-item">
                                <i class="bi bi-person"></i>
                                {{ $item->penulis->nama_depan ?? '' }} {{ $item->penulis->nama_belakang ?? '' }}
                            </span>
                            @if($item->view_count > 0)
                            <span class="result-meta-item">
                                <i class="bi bi-eye"></i>
                                {{ number_format($item->view_count) }} views
                            </span>
                            @endif
                            <span class="result-meta-item ms-auto" style="color: var(--primary); font-weight: 500; font-size: 0.8rem;">
                                Baca selengkapnya <i class="bi bi-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </a>
                @endforeach

                {{-- Pagination --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $artikel->appends([
                        'q'         => $query,
                        'kategori'  => $kategori,
                        'penulis'   => $penulis,
                        'sort'      => $sort,
                        'date_from' => $dateFrom,
                        'date_to'   => $dateTo,
                    ])->links() }}
                </div>

            @elseif($query || $kategori || $penulis || $dateFrom || $dateTo)
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                    <h3>Tidak ada hasil ditemukan</h3>
                    <p>Coba kata kunci lain atau sesuaikan filter pencarian Anda</p>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-search"></i>
                    </div>
                    <h3>Cari Artikel</h3>
                    <p>Masukkan kata kunci atau gunakan filter untuk memulai pencarian</p>
                </div>
            @endif

        </div>
    </div>
</div>

<script>
    // Auto-suggestion with debounce
    let debounceTimer;
    const searchInput = document.getElementById('q');
    const suggestionsDiv = document.getElementById('suggestions');
    const suggestionsList = document.getElementById('suggestionsList');

    searchInput.addEventListener('input', function () {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        if (query.length < 2) {
            suggestionsDiv.style.display = 'none';
            return;
        }

        debounceTimer = setTimeout(function () {
            fetch('{{ route('search.suggest') }}?q=' + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        suggestionsList.innerHTML = data.map(item =>
                            '<div class="suggestion-item" onclick="selectSuggestion(\'' + item.text.replace(/'/g, "\\'") + '\')">' +
                            item.highlight +
                            '</div>'
                        ).join('');
                        suggestionsDiv.style.display = 'block';
                    } else {
                        suggestionsDiv.style.display = 'none';
                    }
                })
                .catch(() => { suggestionsDiv.style.display = 'none'; });
        }, 300);
    });

    function selectSuggestion(text) {
        searchInput.value = text;
        suggestionsDiv.style.display = 'none';
        document.getElementById('searchForm').submit();
    }

    // Hide suggestions when clicking outside
    document.addEventListener('click', function (e) {
        if (!searchInput.contains(e.target) && !suggestionsDiv.contains(e.target)) {
            suggestionsDiv.style.display = 'none';
        }
    });

    // Auto-submit on filter change
    document.querySelectorAll('#searchForm select, #searchForm input[type="date"]').forEach(function (el) {
        el.addEventListener('change', function () {
            document.getElementById('searchForm').submit();
        });
    });
</script>
@endsection
