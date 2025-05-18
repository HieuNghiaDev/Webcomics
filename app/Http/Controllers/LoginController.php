<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        // Kiểm tra thông tin đăng nhập với mật khẩu MD5
        $user = User::where('name', $credentials['name'])->first();
        
        // Nếu tìm thấy người dùng và mật khẩu MD5 khớp
        if ($user && md5($credentials['password']) === $user->password) {
            // Đăng nhập người dùng
            Auth::login($user);
            
            // TÙYCHỌN: Nâng cấp mật khẩu sang bcrypt cho lần đăng nhập tiếp theo
            // $user->password = Hash::make($credentials['password']);
            // $user->save();
            
            return redirect()->intended('/');
        }
        
        return back()->withErrors([
            'name' => 'Thông tin đăng nhập không chính xác.',
        ])->withInput($request->only('name'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/login');
    }
}