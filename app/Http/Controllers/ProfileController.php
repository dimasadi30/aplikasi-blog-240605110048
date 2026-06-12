<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_depan' => 'required|string|max:100',
            'nama_belakang' => 'required|string|max:100',
            'user_name' => 'required|string|max:50|unique:users,user_name,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'name' => $request->nama_depan . ' ' . $request->nama_belakang,
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'user_name' => $request->user_name,
            'email' => $request->email,
        ];

        $oldFoto = $user->foto;

        if ($request->hasFile('foto')) {
            if ($user->foto !== 'default.png') {
                Storage::disk('public')->delete('foto/' . $user->foto);
            }
            $file = $request->file('foto');
            
            // Generate UUID filename
            $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('foto', $fileName, 'public');
            $data['foto'] = $fileName;
        }

        try {
            $user->update($data);

            return back()->with('sukses', 'Profil berhasil diperbarui.');
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
                ->with('gagal', 'Gagal memperbarui profil: ' . $e->getMessage());
        }
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required|string',
            'password' => [
                'required',
                'string',
                'min:12',
                'max:64',
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{12,}$/',
                'not_in:password,123456,admin,letmein,welcome,qwerty',
            ],
        ], [
            'password.min' => 'Password minimal harus 12 karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter spesial.',
            'password.not_in' => 'Password tidak boleh menggunakan kata umum.',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak cocok.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('sukses', 'Password berhasil diperbarui.');
    }
}
