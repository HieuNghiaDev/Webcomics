<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Hiển thị hồ sơ người dùng
     */
    public function show()
    {
        $user = Auth::user();
        return view('toi', compact('user'));
    }

    /**
     * Hiển thị form chỉnh sửa hồ sơ
     */
    public function edit()
    {
        $user = Auth::user();
        return view('edit', compact('user'));
    }

    /**
     * Hiển thị form đổi mật khẩu
     */
    public function showPasswordForm()
    {
        $user = Auth::user();
        return view('changePassword', compact('user'));
    }

    /**
     * Cập nhật thông tin cơ bản của người dùng
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Validate đầu vào
        $validated = $request->validate([
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
            'bio' => 'nullable|string|max:500',
            'phone' => 'nullable|string|max:15',
        ]);
        
        // Cập nhật thông tin
        $user->update($validated);
        
        return redirect()->route('profile')
            ->with('success', 'Thông tin hồ sơ đã được cập nhật thành công!');
    }

    /**
     * Cập nhật mật khẩu người dùng
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        // Cập nhật mật khẩu
        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return redirect()->route('profile.password.form')
            ->with('success', 'Mật khẩu đã được cập nhật thành công!');
    }

    /**
     * Cập nhật avatar người dùng
     */
    public function updateAvatar(Request $request)
    {
        $validated = $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $user = Auth::user();
        
        // Xóa avatar cũ nếu có
        if ($user->avatar && !str_contains($user->avatar, 'default')) {
            Storage::disk('public')->delete($user->avatar);
        }
        
        // Lưu avatar mới
        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        
        // Cập nhật đường dẫn avatar trong DB
        $user->update([
            'avatar' => $avatarPath
        ]);
        
        return redirect()->route('profile.edit')
            ->with('success', 'Avatar đã được cập nhật thành công!');
    }
}