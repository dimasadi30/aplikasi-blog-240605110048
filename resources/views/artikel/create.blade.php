@extends('layouts.app')
@section('title', 'Tambah Artikel')

@section('styles')
<style>
    .upload-area {
        border: 2px dashed var(--border);
        border-radius: var(--radius-lg);
        padding: 28px 20px;
        text-align: center;
        cursor: pointer;
        transition: var(--transition);
        background: var(--background);
        position: relative;
    }
    .upload-area:hover, .upload-area.drag-over {
        border-color: var(--primary);
        background: var(--primary-light);
    }
    .upload-area input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }
    .upload-icon { font-size: 32px; color: var(--text-muted); margin-bottom: 8px; }
    .upload-title { font-size: 14px; font-weight: 600; color: var(--text-primary); margin-bottom: 4px; }
    .upload-desc  { font-size: 12px; color: var(--text-muted); }
    .image-preview-wrap {
        position: relative;
        display: inline-block;
        border-radius: var(--radius-md);
        overflow: hidden;
        border: 1px solid var(--border);
    }
    .image-preview {
        max-height: 200px;
        max-width: 100%;
        display: block;
    }
    .char-counter { font-size: 11.5px; color: var(--text-muted); text-align: right; margin-top: 4px; }
    .char-counter.warn { color: var(--warning); }
    .char-counter.over { color: var(--danger); }
</style>
@endsection

@section('content')
<!-- Header -->
<div class="page-header">
    <div class="page-header-left">
        <h1>Tambah Artikel</h1>
        <p>Buat artikel baru untuk dipublikasikan di blog</p>
    </div>
    <a href="{{ route('artikel.index') }}" class="btn-secondary-custom" id="btn-back-from-create">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<form action="{{ route('artikel.store') }}" method="POST" enctype="multipart/form-data" id="articleForm">
    @csrf
    <div class="row g-4">

        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title"><i class="bi bi-file-earmark-text me-2" style="color:var(--primary);"></i>Konten Artikel</h2>
                </div>
                <div class="card-body-pad">

                    <!-- Judul -->
                    <div class="form-group">
                        <label for="judul" class="form-label-custom">
                            Judul Artikel <span class="required" style="color:var(--danger);">*</span>
                        </label>
                        <input type="text"
                               class="form-control-custom @error('judul') is-invalid @enderror"
                               id="judul"
                               name="judul"
                               value="{{ old('judul') }}"
                               placeholder="Masukkan judul artikel yang menarik..."
                               maxlength="200"
                               oninput="updateCharCounter('judul', 'judulCounter', 200)"
                               required>
                        @error('judul')
                        <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                        <div class="char-counter" id="judulCounter">0 / 200</div>
                    </div>

                    <!-- Kategori -->
                    <div class="form-group">
                        <label for="id_kategori" class="form-label-custom">
                            Kategori <span class="required" style="color:var(--danger);">*</span>
                        </label>
                        <select class="form-control-custom @error('id_kategori') is-invalid @enderror"
                                id="id_kategori"
                                name="id_kategori"
                                required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $item)
                                <option value="{{ $item->id }}"
                                        {{ old('id_kategori') == $item->id ? 'selected' : '' }}>
                                    {{ $item->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('id_kategori')
                        <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Isi Artikel -->
                    <div class="form-group">
                        <label for="isi" class="form-label-custom">
                            Isi Artikel <span class="required" style="color:var(--danger);">*</span>
                        </label>
                        <textarea class="form-control-custom @error('isi') is-invalid @enderror"
                                  id="isi"
                                  name="isi"
                                  rows="14"
                                  placeholder="Tulis isi artikel Anda di sini..."
                                  style="resize: vertical; min-height: 280px;">{{ old('isi') }}</textarea>
                        @error('isi')
                        <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                        <div style="font-size: 12px; color: var(--text-muted); margin-top: 6px;">
                            <i class="bi bi-info-circle me-1"></i>
                            Anda dapat menggunakan HTML dasar untuk format teks (tag bold, italic, heading, dll)
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Sidebar Options -->
        <div class="col-lg-4">

            <!-- Upload Gambar -->
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="card-title"><i class="bi bi-image me-2" style="color:var(--primary);"></i>Gambar Artikel</h2>
                </div>
                <div class="card-body-pad">
                    <!-- Preview -->
                    <div id="imagePreviewContainer" style="display:none; margin-bottom: 12px; text-align: center;">
                        <div class="image-preview-wrap">
                            <img id="imagePreview" class="image-preview" src="" alt="Preview">
                        </div>
                        <button type="button" onclick="removeImage()" style="display:block;margin:8px auto 0;font-size:12px;color:var(--danger);background:none;border:none;cursor:pointer;">
                            <i class="bi bi-trash"></i> Hapus Gambar
                        </button>
                    </div>

                    <!-- Upload Area -->
                    <div class="upload-area" id="uploadArea">
                        <input type="file"
                               id="gambar"
                               name="gambar"
                               accept="image/jpg,image/jpeg,image/png"
                               onchange="previewImage(event)"
                               aria-label="Upload Gambar Artikel">
                        <div class="upload-icon"><i class="bi bi-cloud-upload"></i></div>
                        <div class="upload-title">Klik atau drag gambar ke sini</div>
                        <div class="upload-desc">JPG, JPEG, PNG · Maks. 2 MB</div>
                    </div>
                    @error('gambar')
                    <div class="invalid-feedback-custom mt-2"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Submit Card -->
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title"><i class="bi bi-send me-2" style="color:var(--primary);"></i>Publikasikan</h2>
                </div>
                <div class="card-body-pad">
                    <div style="display:flex;flex-direction:column;gap:10px;">
                        <button type="submit"
                                class="btn-primary-custom"
                                id="submitBtn"
                                style="justify-content:center;">
                            <i class="bi bi-check-circle"></i>
                            Simpan & Publikasikan
                        </button>
                        <a href="{{ route('artikel.index') }}"
                           class="btn-secondary-custom"
                           style="justify-content:center;text-align:center;">
                            <i class="bi bi-x-circle"></i>
                            Batal
                        </a>
                    </div>
                    <div style="margin-top:14px;padding-top:14px;border-top:1px solid var(--border);font-size:12px;color:var(--text-muted);display:flex;flex-direction:column;gap:5px;">
                        <span><i class="bi bi-info-circle me-1"></i>Artikel akan langsung dipublikasikan</span>
                        <span><i class="bi bi-shield-check me-1"></i>Data Anda aman dan tersimpan</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>
@endsection

@section('scripts')
<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (!file) return;
        const preview   = document.getElementById('imagePreview');
        const container = document.getElementById('imagePreviewContainer');
        const uploadArea = document.getElementById('uploadArea');
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            container.style.display = 'block';
            uploadArea.style.borderStyle = 'solid';
            uploadArea.style.borderColor = 'var(--success)';
        };
        reader.readAsDataURL(file);
    }

    function removeImage() {
        document.getElementById('gambar').value = '';
        document.getElementById('imagePreview').src = '';
        document.getElementById('imagePreviewContainer').style.display = 'none';
        const uploadArea = document.getElementById('uploadArea');
        uploadArea.style.borderStyle = 'dashed';
        uploadArea.style.borderColor = 'var(--border)';
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

    document.getElementById('articleForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
        btn.style.opacity = '0.7';
        btn.disabled = true;
    });

    // Drag and drop
    const uploadArea = document.getElementById('uploadArea');
    uploadArea.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('drag-over');
    });
    uploadArea.addEventListener('dragleave', function() { this.classList.remove('drag-over'); });
    uploadArea.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('drag-over');
        const file = e.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
            const fileInput = document.getElementById('gambar');
            const dt = new DataTransfer();
            dt.items.add(file);
            fileInput.files = dt.files;
            previewImage({ target: { files: [file] } });
        }
    });
</script>
@endsection