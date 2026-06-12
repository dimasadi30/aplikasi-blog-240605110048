@extends('layouts.app')
@section('title', 'Tambah Kategori')

@section('content')
<div class="page-header">
    <div class="page-header-left">
        <h1>Tambah Kategori</h1>
        <p>Buat kategori baru untuk mengorganisir artikel</p>
    </div>
    <a href="{{ route('kategori.index') }}" class="btn-secondary-custom">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row g-4 justify-content-center">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title"><i class="bi bi-folder-plus me-2" style="color:var(--warning);"></i>Data Kategori Baru</h2>
            </div>
            <div class="card-body-pad">
                <form action="{{ route('kategori.store') }}" method="POST" id="kategoriForm">
                    @csrf

                    <div class="form-group">
                        <label for="nama_kategori" class="form-label-custom">
                            Nama Kategori <span style="color:var(--danger);">*</span>
                        </label>
                        <input type="text"
                               class="form-control-custom @error('nama_kategori') is-invalid @enderror"
                               id="nama_kategori"
                               name="nama_kategori"
                               value="{{ old('nama_kategori') }}"
                               placeholder="Masukkan nama kategori"
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
                                  placeholder="Deskripsi singkat kategori ini...">{{ old('keterangan') }}</textarea>
                        @error('keterangan')
                        <div class="invalid-feedback-custom"><i class="bi bi-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:24px;padding-top:20px;border-top:1px solid var(--border);">
                        <a href="{{ route('kategori.index') }}" class="btn-secondary-custom">Batal</a>
                        <button type="submit" class="btn-primary-custom" id="submitBtn">
                            <i class="bi bi-check-circle"></i> Simpan Kategori
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('kategoriForm').addEventListener('submit', function() {
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan...';
    btn.disabled = true;
});
</script>
@endsection