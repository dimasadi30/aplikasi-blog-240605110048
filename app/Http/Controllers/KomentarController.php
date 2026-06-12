<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Models\Komentar;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KomentarController extends Controller
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

        $komentar = Komentar::with(['artikel', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('komentar.index', compact('komentar'));
    }

    public function store(Request $request, string $artikelId)
    {
        $rules = [
            'isi_komentar' => 'required|string|max:1000',
        ];

        // Ensure guests must submit valid name and email
        if (!Auth::check()) {
            $rules['nama_tamu'] = 'required|string|max:100';
            $rules['email_tamu'] = 'required|email|max:100';
        }

        $request->validate($rules);

        $artikel = Artikel::findOrFail($artikelId);

        $data = [
            'artikel_id' => $artikel->id,
            'isi_komentar' => $request->isi_komentar,
            'status' => 'pending',
        ];

        // If user is authenticated, use user_id
        if (Auth::check()) {
            $data['user_id'] = Auth::id();
        } else {
            // For guests, store name and email
            $data['nama_tamu'] = $request->nama_tamu;
            $data['email_tamu'] = $request->email_tamu;
        }

        try {
            Komentar::create($data);

            return back()->with('sukses', 'Komentar Anda telah dikirim dan menunggu moderasi.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('gagal', 'Gagal mengirim komentar: ' . $e->getMessage());
        }
    }

    public function approve(string $id)
    {
        $this->authorizeAdmin();
        $komentar = Komentar::findOrFail($id);
        
        try {
            $komentar->update(['status' => 'approved']);
            
            return redirect()->route('komentar.index')->with('sukses', 'Komentar berhasil di-approve.');
        } catch (\Exception $e) {
            return back()
                ->with('gagal', 'Gagal approve komentar: ' . $e->getMessage());
        }
    }

    public function reject(string $id)
    {
        $this->authorizeAdmin();
        $komentar = Komentar::findOrFail($id);
        
        try {
            $komentar->update(['status' => 'rejected']);
            
            return redirect()->route('komentar.index')->with('sukses', 'Komentar berhasil di-reject.');
        } catch (\Exception $e) {
            return back()
                ->with('gagal', 'Gagal reject komentar: ' . $e->getMessage());
        }
    }

    public function markAsSpam(string $id)
    {
        $this->authorizeAdmin();
        $komentar = Komentar::findOrFail($id);
        
        try {
            $komentar->update(['status' => 'spam']);
            
            return redirect()->route('komentar.index')->with('sukses', 'Komentar ditandai sebagai spam.');
        } catch (\Exception $e) {
            return back()
                ->with('gagal', 'Gagal menandai komentar sebagai spam: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $this->authorizeAdmin();

        $komentar = Komentar::findOrFail($id);
        
        try {
            $komentar->delete();

            return redirect()->route('komentar.index')->with('sukses', 'Komentar berhasil dihapus.');
        } catch (\Exception $e) {
            return back()
                ->with('gagal', 'Gagal menghapus komentar: ' . $e->getMessage());
        }
    }
}
