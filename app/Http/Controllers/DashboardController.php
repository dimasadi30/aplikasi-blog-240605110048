<?php
namespace App\Http\Controllers;
use App\Models\Artikel;
use App\Models\KategoriArtikel;
use App\Models\Komentar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class DashboardController extends Controller
{
    public function index()
    {
        $pengguna = Auth::user();
        $data = [
            'nama_lengkap' => $pengguna->nama_depan . ' ' . $pengguna->nama_belakang,
            'foto' => $pengguna->foto ?? 'default.png',
            'waktu_login' => session('waktu_login', '-'),
            'role' => $pengguna->role,
        ];

        if ($pengguna->isAdmin()) {
            // Statistics
            $data['total_artikel'] = Artikel::count();
            $data['total_kategori'] = KategoriArtikel::count();
            $data['total_user'] = User::count();
            $data['total_komentar'] = Komentar::count();
            $data['total_penulis'] = User::where('role', 'penulis')->count();
            $data['total_tamu'] = User::where('role', 'tamu')->count();
            $data['total_admin'] = User::where('role', 'admin')->count();
            $data['total_tag'] = \App\Models\Tag::count();
            $data['total_view'] = Artikel::sum('view_count');

            // Widgets
            $data['artikel_terbaru'] = Artikel::with('kategori', 'penulis')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            $data['komentar_terbaru'] = Komentar::with('artikel', 'user')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            $data['user_terbaru'] = User::orderBy('created_at', 'desc')
                ->take(5)
                ->get();
            
            $data['artikel_terpopuler'] = Artikel::with('kategori', 'penulis')
                ->orderBy('view_count', 'desc')
                ->take(5)
                ->get();
            
            $data['aktivitas_terbaru'] = \App\Models\ActivityLog::with('user')
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        }

        if ($pengguna->isPenulis()) {
            $data['total_artikel'] = Artikel::where('id_penulis', $pengguna->id)->count();
            $data['total_draft'] = Artikel::where('id_penulis', $pengguna->id)
                ->where('status', 'draft')
                ->count();
            $data['total_publish'] = Artikel::where('id_penulis', $pengguna->id)
                ->where('status', 'publish')
                ->count();
        }

        if ($pengguna->isTamu()) {
            $data['total_artikel'] = Artikel::where('status', 'publish')->count();
            $data['total_kategori'] = KategoriArtikel::count();
            $data['total_penulis'] = User::where('role', 'penulis')->count();
            $data['latest_artikel'] = Artikel::with('kategori', 'penulis')
                ->where('status', 'publish')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();
        }

        return view('dashboard.index', $data);
    }
}