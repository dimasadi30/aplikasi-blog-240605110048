<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\KategoriArtikel;

class KategoriArtikelController extends Controller
{
    private function authorizeAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403);
        }
    }

    public function index()
    {
        $this->authorizeAdmin();
        $kategori = KategoriArtikel::withCount('artikel')
            ->orderBy('nama_kategori', 'asc')
            ->paginate(10);
        return view('kategori.index', compact('kategori'));
    }
    public function create()
    {
        $this->authorizeAdmin();
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();
        $request->validate([
            'nama_kategori' =>
                'required|string|max:100|unique:kategori_artikel,nama_kategori',
            'keterangan' => 'nullable|string',
        ]);
        
        try {
            KategoriArtikel::create([
                'nama_kategori' => $request->nama_kategori,
                'keterangan' => $request->keterangan,
            ]);
            
            return redirect()->route('kategori.index')
                ->with('sukses', 'Kategori berhasil ditambahkan.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('gagal', 'Gagal menambahkan kategori: ' . $e->getMessage());
        }
    }
    public function edit(string $id)
    {
        $this->authorizeAdmin();
        $kategori = KategoriArtikel::findOrFail($id);
        return view('kategori.edit', compact('kategori'));
    }

    public function update(Request $request, string $id)
    {
        $this->authorizeAdmin();
        $kategori = KategoriArtikel::findOrFail($id);
        $request->validate([
            'nama_kategori' =>
                'required|string|max:100|unique:kategori_artikel,nama_kategori,' . $id,
            'keterangan' => 'nullable|string',
        ]);
        
        try {
            $kategori->update([
                'nama_kategori' => $request->nama_kategori,
                'keterangan' => $request->keterangan,
            ]);
            
            return redirect()->route('kategori.index')
                ->with('sukses', 'Kategori berhasil diperbarui.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('gagal', 'Gagal memperbarui kategori: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $this->authorizeAdmin();
        $kategori = KategoriArtikel::findOrFail($id);
        try {
            $kategori->delete();
            return redirect()->route('kategori.index')
                ->with('sukses', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('kategori.index')
                ->with('gagal', 'Kategori tidak dapat dihapus karena masih memiliki artikel.');
        }
    }

    public function merge(Request $request)
    {
        $this->authorizeAdmin();
        $request->validate([
            'source_kategori_id' => 'required|exists:kategori_artikel,id',
            'target_kategori_id' => 'required|exists:kategori_artikel,id|different:source_kategori_id',
        ]);

        $sourceKategori = KategoriArtikel::findOrFail($request->source_kategori_id);
        $targetKategori = KategoriArtikel::findOrFail($request->target_kategori_id);

        // Move all articles from source to target
        \App\Models\Artikel::where('id_kategori', $sourceKategori->id)
            ->update(['id_kategori' => $targetKategori->id]);

        // Delete source category
        $sourceKategori->delete();

        return redirect()->route('kategori.index')
            ->with('sukses', 'Kategori berhasil digabungkan.');
    }
}