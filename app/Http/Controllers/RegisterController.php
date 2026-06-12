<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index');
    }

    public function store(Request $request)
    {
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
                'confirmed',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/',
                'not_in:password,123456,admin,letmein,welcome,qwerty',
            ],
            'role' => 'required|in:penulis,tamu',
        ], [
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.regex' => 'Password harus mengandung huruf besar, huruf kecil, angka, dan karakter spesial.',
            'password.not_in' => 'Password tidak boleh menggunakan kata umum.',
        ]);

        $user = User::create([
            'name' => $request->nama_depan . ' ' . $request->nama_belakang,
            'nama_depan' => $request->nama_depan,
            'nama_belakang' => $request->nama_belakang,
            'user_name' => $request->user_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'foto' => 'default.png',
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
