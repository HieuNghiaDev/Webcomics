<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function hienThiFormDangNhap()
    {
        return view('login');
    }

    public function dangNhap(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('name', $credentials['name'])->first();

        // Kiểm tra password bằng Hash::check
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            $request->session()->regenerate();

            // Kiểm tra role người dùng
            if ($user->role == 2) {
                return redirect('/admin');
            } else {
                return redirect('/');
            }
        }

        return back()->withErrors([
            'name' => 'Thông tin đăng nhập không chính xác.',
        ])->withInput($request->only('name'));
    }

    public function dangXuat(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}