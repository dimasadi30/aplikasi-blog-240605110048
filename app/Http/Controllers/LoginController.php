<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    public function index()
    {
        return view('login.index');
    }

    public function proses(Request $request)
    {
        $request->validate([
            'user_name' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = [
            'user_name' => $request->user_name,
            'password' => $request->password,
        ];

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'gagal' => 'Username atau password salah.',
            ]);
        }

        // SECURITY FIX: Check user status (active/inactive/banned)
        $user = Auth::user();
        if ($user->status !== 'active') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return back()->withErrors([
                'gagal' => 'Akun Anda telah dinonaktifkan. Hubungi administrator.',
            ]);
        }

        $request->session()->regenerate();
        $request->session()->put(
            'waktu_login',
            now()
                ->timezone('Asia/Jakarta')
                ->locale('id')
                ->isoFormat('dddd, D MMMM Y | HH:mm')
        );

        return redirect()->route('dashboard');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}