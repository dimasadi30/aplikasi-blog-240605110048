<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\ActivityLog;

class PenulisController extends Controller
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
        $penulis = User::orderBy('nama_depan', 'asc')->paginate(10);
        return view('penulis.index', compact('penulis'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('penulis.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'nama_depan' => 'required|string|max:100',
            'nama_belakang' => 'required|string|max:100',
            'user_name' => 'required|string|max:50|unique:users,user_name',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:64',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/',
                'not_in:password,123456,admin,letmein,welcome,qwerty',
            ],
            'role' => 'required|in:admin,penulis,tamu',
            'status' => 'required|in:active,suspended,pending',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter spesial.',
            'password.not_in' => 'Password tidak boleh menggunakan kata umum.',
        ]);

        $namaFoto = 'default.png';
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            
            // Generate UUID filename
            $namaFoto = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('foto', $namaFoto, 'public');
        }

        try {
            User::create([
                'name' => $request->nama_depan . ' ' . $request->nama_belakang,
                'nama_depan' => $request->nama_depan,
                'nama_belakang' => $request->nama_belakang,
                'user_name' => $request->user_name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
                'foto' => $namaFoto,
                'status' => $request->status ?? 'active',
            ]);

            return redirect()->route('penulis.index')
                ->with('sukses', 'Penulis berhasil ditambahkan.');
        } catch (\Exception $e) {
            // Delete uploaded file if user creation fails
            if ($namaFoto !== 'default.png') {
                Storage::disk('public')->delete('foto/' . $namaFoto);
            }
            
            return back()
                ->withInput()
                ->with('gagal', 'Gagal menambahkan penulis: ' . $e->getMessage());
        }
    }

    public function edit(string $id)
    {
        $this->authorizeAdmin();
        $penulis = User::findOrFail($id);
        return view('penulis.edit', compact('penulis'));
    }

    public function update(Request $request, string $id)
    {
        $this->authorizeAdmin();
        $penulis = User::findOrFail($id);

        $request->validate([
            'nama_depan' => 'required|string|max:100',
            'nama_belakang' => 'required|string|max:100',
            'user_name' => 'required|string|max:50|unique:users,user_name,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|max:64',
            'role' => 'required|in:admin,penulis,tamu',
            'status' => 'required|in:active,suspended,pending',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name' => $request->nama_depan . ' ' . $request->nama_belakang,
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'user_name' => $request->user_name,
            'email' => $request->email,
            'role' => $request->role,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $oldFoto = $penulis->foto;

        if ($request->hasFile('foto')) {
            if ($penulis->foto !== 'default.png') {
                Storage::disk('public')->delete('foto/' . $penulis->foto);
            }
            $file = $request->file('foto');
            
            // Generate UUID filename
            $namaFoto = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('foto', $namaFoto, 'public');
            $data['foto'] = $namaFoto;
        }

        try {
            $penulis->update($data);

            return redirect()->route('penulis.index')
                ->with('sukses', 'Data penulis berhasil diperbarui.');
        } catch (\Exception $e) {
            // Restore old photo if update fails
            if ($request->hasFile('foto') && isset($data['foto'])) {
                Storage::disk('public')->delete('foto/' . $data['foto']);
                if ($oldFoto) {
                    $data['foto'] = $oldFoto;
                }
            }
            
            return back()
                ->withInput()
                ->with('gagal', 'Gagal memperbarui penulis: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $this->authorizeAdmin();
        $penulis = User::findOrFail($id);

        try {
            $penulis->delete();

            return redirect()->route('penulis.index')
                ->with('sukses', 'Data penulis berhasil dihapus.');
        } catch (\Exception $e) {
            Log::error('User deletion failed: ' . $e->getMessage());
            return redirect()->route('penulis.index')
                ->with('gagal', 'Penulis tidak dapat dihapus karena masih memiliki artikel.');
        }
    }

    public function suspend(string $id)
    {
        $this->authorizeAdmin();
        $penulis = User::findOrFail($id);
        $penulis->update(['status' => 'suspended']);
        return redirect()->route('penulis.index')
            ->with('sukses', 'User berhasil di-suspend.');
    }

    public function activate(string $id)
    {
        $this->authorizeAdmin();
        $penulis = User::findOrFail($id);
        $penulis->update(['status' => 'active']);
        return redirect()->route('penulis.index')
            ->with('sukses', 'User berhasil di-aktifkan.');
    }

    public function resetPassword(string $id)
    {
        $this->authorizeAdmin();
        $penulis = User::findOrFail($id);
        
        // Generate random password
        $newPassword = Str::random(16);
        $penulis->update(['password' => bcrypt($newPassword)]);
        return redirect()->route('penulis.index')
            ->with('sukses', 'Password berhasil di-reset. Password baru: ' . $newPassword);
    }
}
