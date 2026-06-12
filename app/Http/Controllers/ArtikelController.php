<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Artikel;
use App\Models\KategoriArtikel;
use App\Models\ActivityLog;
class ArtikelController extends Controller
{
    private function authorizePenulis()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'penulis'], true)) {
            abort(403);
        }
    }

    private function authorizePenulisOnly()
    {
        if (!Auth::check() || Auth::user()->role !== 'penulis') {
            abort(403, 'Hanya Penulis yang dapat membuat artikel');
        }
    }

    public function index()
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['admin', 'penulis'], true)) {
            abort(403, 'Unauthorized access');
        }
        
        // Penulis sees only their own articles
        if (Auth::user()->isPenulis()) {
            $artikel = Artikel::with('penulis', 'kategori')
                ->where('id_penulis', Auth::id())
                ->orderBy('id', 'desc')
                ->paginate(10);
        } else {
            // Admin sees all
            $artikel = Artikel::with('penulis', 'kategori')
                ->orderBy('id', 'desc')
                ->paginate(10);
        }
        
        return view('artikel.index', compact('artikel'));
    }
    public function create()
    {
        $this->authorizePenulis();
        $kategori = KategoriArtikel::orderBy('nama_kategori', 'asc')->get();
        return view('artikel.create', compact('kategori'));
    }
    public function store(Request $request)
    {
        $this->authorizePenulis();
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'id_kategori' => 'required|exists:kategori_artikel,id',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        
        $file = $request->file('gambar');
        
        // Generate UUID filename with safe extension guessing
        $extension = $file->guessExtension() ?: $file->getClientOriginalExtension();
        $namaFile = Str::uuid() . '.' . $extension;
        
        // Organize by date
        $directory = 'gambar/' . date('Y/m/d');
        
        $file->storeAs($directory, $namaFile, 'public');
        
        try {
            Artikel::create([
                'judul' => strip_tags($request->judul),
                'isi' => self::sanitizeHtml($request->isi),
                'id_penulis' => Auth::user()->id,
                'id_kategori' => $request->id_kategori,
                'gambar' => $directory . '/' . $namaFile,
                'slug' => Str::slug($request->judul),
                'status' => 'publish',
                'hari_tanggal' => now()->timezone('Asia/Jakarta')
                    ->locale('id')
                    ->isoFormat('dddd, D MMMM Y | HH:mm'),
            ]);
            
            return redirect()->route('artikel.index')
                ->with('sukses', 'Artikel berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Delete the uploaded file if article creation fails
            Storage::disk('public')->delete($directory . '/' . $namaFile);
            
            return back()
                ->withInput()
                ->with('gagal', 'Gagal menambahkan artikel: ' . $e->getMessage());
        }

    }
    public function edit(string $id)
    {
        $this->authorizePenulis();
        $artikel = Artikel::findOrFail($id);
        
        // Ownership check for penulis
        if (Auth::user()->isPenulis() && $artikel->id_penulis !== Auth::id()) {
            abort(403, 'You can only edit your own articles');
        }
        
        $kategori = KategoriArtikel::orderBy('nama_kategori', 'asc')->get();
        return view('artikel.edit', compact('artikel', 'kategori'));
    }
    public function update(Request $request, string $id)
    {
        $this->authorizePenulis();
        $artikel = Artikel::findOrFail($id);
        
        // Ownership check for penulis
        if (Auth::user()->isPenulis() && $artikel->id_penulis !== Auth::id()) {
            abort(403, 'You can only edit your own articles');
        }
        
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'id_kategori' => 'required|exists:kategori_artikel,id',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        $data = [
            'judul' => strip_tags($request->judul),
            'isi' => self::sanitizeHtml($request->isi),
            'id_kategori' => $request->id_kategori,
            'slug' => Str::slug($request->judul),
            'status' => 'publish',
        ];
        
        $oldGambar = $artikel->gambar;
        
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            
            // Generate UUID filename with safe extension guessing
            $extension = $file->guessExtension() ?: $file->getClientOriginalExtension();
            $namaFile = Str::uuid() . '.' . $extension;
            
            // Organize by date
            $directory = 'gambar/' . date('Y/m/d');
            
            $file->storeAs($directory, $namaFile, 'public');
            $data['gambar'] = $directory . '/' . $namaFile;
        }
        
        try {
            $oldFotoPath = $oldGambar;
            $artikel->update($data);

            // Delete old image only if new one was successfully saved
            if ($request->hasFile('gambar') && $oldFotoPath) {
                Storage::disk('public')->delete($oldFotoPath);
            }
            
            return redirect()->route('artikel.index')
                ->with('sukses', 'Artikel berhasil diperbarui.');
        } catch (\Exception $e) {
            // Restore old image if update fails
            if ($request->hasFile('gambar') && isset($data['gambar'])) {
                Storage::disk('public')->delete($data['gambar']);
                if ($oldGambar) {
                    $data['gambar'] = $oldGambar;
                }
            }
            
            return back()
                ->withInput()
                ->with('gagal', 'Gagal memperbarui artikel: ' . $e->getMessage());
        }
    }
    public function destroy(string $id)
    {
        $this->authorizePenulis();
        $artikel = Artikel::findOrFail($id);
        
        // Ownership check for penulis
        if (Auth::user()->isPenulis() && $artikel->id_penulis !== Auth::id()) {
            abort(403, 'You can only delete your own articles');
        }
        
        try {
            $artikel->delete();
            
            return redirect()->route('artikel.index')
                ->with('sukses', 'Artikel berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('Article deletion failed: ' . $e->getMessage());
            return redirect()->route('artikel.index')
                ->with('gagal', 'Artikel gagal dihapus.');
        }
    }

    /**
     * Sanitizes rich HTML content to prevent XSS.
     */
    public static function sanitizeHtml(?string $html): ?string
    {
        if (empty($html)) {
            return $html;
        }

        // Remove script tags and their content
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);

        // Remove iframe, object, embed, applet, meta, link tags
        $html = preg_replace('/<(iframe|object|embed|applet|meta|link)\b[^>]*>(.*?)<\/\1>/is', '', $html);
        $html = preg_replace('/<(iframe|object|embed|applet|meta|link)\b[^>]*\/?>/is', '', $html);

        // Remove event handlers (onclick, onerror, onload, etc.)
        $html = preg_replace('/on\w+\s*=\s*([\'"][^\'"]*[\'"]|[^\s>]+)/i', '', $html);

        // Remove javascript: pseudo-protocol in href/src
        $html = preg_replace('/href\s*=\s*[\'"]\s*javascript:[^\'"]*[\'"]/i', 'href="#"', $html);
        $html = preg_replace('/src\s*=\s*[\'"]\s*javascript:[^\'"]*[\'"]/i', '', $html);

        return $html;
    }

}