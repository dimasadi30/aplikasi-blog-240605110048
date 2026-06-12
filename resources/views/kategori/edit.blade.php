@extends('layouts.app')
@section('title', 'Edit Kategori')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Edit Kategori</h1>
        <p>Memperbarui kategori: <strong>{{ $kategori->nama_kategori }}</strong></p>
    </div>
    <a href="{{ route('kategori.index') }}" class="btn-secondary-custom">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="bi bi-folder-symlink me-2" style="color:var(--warning);"></i>Edit Data Kategori</h2>
            </div>
            <div class="card-body-pad">
                <form action="{{ route('kategori.update', $kategori->id) }}" method="POST" id="editKategoriForm">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="nama_kategori" class="form-label-custom">
                            Nama Kategori <span style="color:var(--danger);">*</span>
                        </label>
                        <input type="text"
                               class="form-control-custom @error('nama_kategori') is-invalid @enderror"
                               id="nama_kategori"
                               name="nama_kategori"
                               value="{{ old('nama_kategori', $kategori->nama_kategori) }}"
                               placeholder="Nama kategori"
                               autofocus
                               required>
                        @error('nama_kategori')
                        <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label for="keterangan" class="form-label-custom">
                            Keterangan <span style="font-weight:400;color:var(--text-muted);">(opsional)</span>
                        </label>
                        <textarea class="form-control-custom @error('keterangan') is-invalid @enderror"
                                  id="keterangan"
                                  name="keterangan"
                                  rows="4"
                                  placeholder="Deskripsi singkat...">{{ old('keterangan', $kategori->keterangan) }}</textarea>
                        @error('keterangan')
                        <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;padding-top:20px;border-top:1px solid var(--border);">
                        <a href="{{ route('kategori.index') }}" class="btn-secondary-custom">Batal</a>
                        <button type="submit" class="btn-primary-custom" id="submitBtn">
                            <i class="bi bi-check-circle"></i> Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('editKategoriForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
    btn.disabled = true;
});
</script>
@endsection