@extends('layouts.app')
@section('title', 'Edit Artikel')

@section('styles')
<style>
    .upload-area {
        border: 2px dashed var(--border);
        border-radius: var(--radius-lg);
        padding: 24px 20px;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        background: var(--background);
        position: relative;
    }
    .upload-area:hover { border-color: var(--primary); background: var(--primary-light); }
    .upload-area input[type="file"] {
        position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .upload-icon { font-size: 28px; color: var(--text-muted); margin-bottom: 6px; }
    .char-counter { font-size: 11.5px; color: var(--text-muted); text-align: right; margin-top: 4px; }
    .char-counter.warn { color: var(--warning); }
    .char-counter.over { color: var(--danger); }
</style>
@endsection

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-header-left">
        <h1>Edit Artikel</h1>
        <p>Perbarui konten artikel: <strong>{{ Str::limit($artikel->judul, 50) }}</strong></p>
    </div>
    <div style="display:flex;gap:8px;">
        <a href="{{ route('article.show', $artikel->slug) }}" class="btn-secondary-custom" target="_blank" rel="noopener" id="btn-preview-article">
            <i class="bi bi-eye"></i> Lihat
        </a>
        <a href="{{ route('artikel.index') }}" class="btn-secondary-custom" id="btn-back-from-edit">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<form action="{{ route('artikel.update', $artikel->id) }}" method="POST" enctype="multipart/form-data" id="editForm">
    @csrf
    @method('PUT')
    <div class="row g-4">

        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title"><i class="bi bi-pencil-square me-2" style="color:var(--primary);"></i>Edit Konten</h2>
                    <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:var(--text-muted);">
                        <i class="bi bi-clock"></i>
                        Dibuat: {{ \Carbon\Carbon::parse($artikel->created_at)->format('d M Y') }}
                    </div>
                </div>
                <div class="card-body-pad">

                    <!-- Judul -->
                    <div class="form-group">
                        <label for="judul" class="form-label-custom">
                            Judul Artikel <span style="color:var(--danger);">*</span>
                        </label>
                        <input type="text"
                               class="form-control-custom @error('judul') is-invalid @enderror"
                               id="judul"
                               name="judul"
                               value="{{ old('judul', $artikel->judul) }}"
                               placeholder="Masukkan judul artikel"
                               maxlength="200"
                               oninput="updateCharCounter('judul','judulCounter',200)"
                               required>
                        @error('judul')
                        <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                        <div class="char-counter" id="judulCounter">{{ strlen($artikel->judul) }} / 200</div>
                    </div>

                    <!-- Kategori -->
                    <div class="form-group">
                        <label for="id_kategori" class="form-label-custom">
                            Kategori <span style="color:var(--danger);">*</span>
                        </label>
                        <select class="form-control-custom @error('id_kategori') is-invalid @enderror"
                                id="id_kategori"
                                name="id_kategori"
                                required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $item)
                                <option value="{{ $item->id }}"
                                        {{ old('id_kategori', $artikel->id_kategori) == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                        <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Isi -->
                    <div class="form-group">
                        <label for="isi" class="form-label-custom">
                            Isi Artikel <span style="color:var(--danger);">*</span>
                        </label>
                        <textarea class="form-control-custom @error('isi') is-invalid @enderror"
                                  id="isi"
                                  name="isi"
                                  rows="14"
                                  placeholder="Tulis isi artikel..."
                                  style="resize: vertical; min-height: 280px;">{{ old('isi', $artikel->isi) }}</textarea>
                        @error('isi')
                        <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">

            <!-- Gambar Saat Ini -->
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="card-title"><i class="bi bi-image me-2" style="color:var(--primary);"></i>Gambar Artikel</h2>
                </div>
                <div class="card-body-pad">
                    <!-- Current Image -->
                    @if($artikel->gambar)
                    <div style="margin-bottom: 12px;">
                        <div style="font-size:12px;color:var(--text-muted);margin-bottom:6px;font-weight:500;">Gambar saat ini:</div>
                        <div id="currentImageWrap" style="border-radius:var(--radius-md);overflow:hidden;border:1px solid var(--border);">
                            <img id="currentImage"
                                 src="{{ asset('storage/' . $artikel->gambar) }}"
                                 alt="Gambar Artikel"
                                 style="width:100%;max-height:180px;object-fit:cover;display:block;">
                        </div>
                    </div>
                    @endif

                    <!-- Upload Baru -->
                    <div style="font-size:12px;color:var(--text-muted);margin-bottom:6px;font-weight:500;">
                        {{ $artikel->gambar ? 'Ganti gambar (opsional):' : 'Upload gambar:' }}
                    </div>
                    <div class="upload-area" id="uploadArea">
                        <input type="file"
                               id="gambar"
                               name="gambar"
                               accept="image/jpg,image/jpeg,image/png"
                               onchange="previewNewImage(event)">
                        <div class="upload-icon"><i class="bi bi-cloud-upload"></i></div>
                        <div style="font-size:13px;font-weight:600;color:var(--text-primary);margin-bottom:3px;">Klik untuk upload</div>
                        <div style="font-size:11.5px;color:var(--text-muted);">JPG, PNG · Max 2MB</div>
                    </div>
                    @error('gambar')
                    <div class="invalid-feedback-custom mt-2"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Submit -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title"><i class="bi bi-save me-2" style="color:var(--primary);"></i>Simpan Perubahan</h2>
                </div>
                <div class="card-body-pad">
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        <button type="submit"
                                id="submitBtn"
                                class="btn-primary-custom"
                                style="justify-content:center;">
                            <i class="bi bi-check-circle"></i>
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('artikel.index') }}"
                           class="btn-secondary-custom"
                           style="justify-content:center;text-align:center;">
                            <i class="bi bi-x-circle"></i>
                            Batal
                        </a>
                    </div>
                    <div style="margin-top:14px;padding-top:14px;border-top:1px solid var(--border);">
                        <div style="display:flex;align-items:center;gap:6px;font-size:12px;color:var(--text-muted);">
                            <i class="bi bi-clock-history"></i>
                            Terakhir diperbarui: {{ \Carbon\Carbon::parse($artikel->updated_at)->format('d M Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    function previewNewImage(event) {
        const file = event.target.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = function(e) {
            const currentImg = document.getElementById('currentImage');
            if (currentImg) {
                currentImg.src = e.target.result;
            } else {
                const wrap = document.getElementById('currentImageWrap');
                if (wrap) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.style.cssText = 'width:100%;max-height:180px;object-fit:cover;display:block;';
                    wrap.appendChild(img);
                }
            }
            document.getElementById('uploadArea').style.borderColor = 'var(--success)';
        };
        reader.readAsDataURL(file);
    }

    function updateCharCounter(inputId, counterId, max) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);
        const len = input.value.length;
        counter.textContent = len + ' / ' + max;
        counter.className = 'char-counter';
        if (len > max * 0.9) counter.classList.add('warn');
        if (len >= max)     counter.classList.add('over');
    }

    document.getElementById('editForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
        btn.style.opacity = '0.7';
        btn.disabled = true;
    });
</script>
@endsection