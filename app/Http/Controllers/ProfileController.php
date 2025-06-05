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
        
        $rules = [
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
            ],
        ];
        
        if ($request->filled('password')) {
            $rules['password_confirmation'] = 'required|password_confirmation';
            $rules['password'] = 'required|string|min:8|confirmed';
            $rules['password_confirmation'] = 'required';
        }
        
        $validated = $request->validate($rules);
        
        // Cập nhật thông tin cơ bản
        $updateData = [
            'email' => $validated['email'],
        ];
        
        // Cập nhật mật khẩu nếu được cung cấp
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }
        
        // Thực hiện cập nhật
        $user->update($updateData);
        
        return redirect()->route('profile')
            ->with('success', 'Thông tin hồ sơ đã được cập nhật thành công!');
    }

    /**
     * Cập nhật mật khẩu người dùng
     */
    // public function updatePassword(Request $request)
    // {
    //     $validated = $request->validate([
    //         'password_confirmation' => 'required|current_password',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);
        
    //     // Cập nhật mật khẩu
    //     Auth::user()->update([
    //         'password' => Hash::make($validated['password']),
    //     ]);
        
    //     return redirect()->route('profile.password.form')
    //         ->with('success', 'Mật khẩu đã được cập nhật thành công!');
    // }

    public function updateAvatar(Request $request)
    {
        $validated = $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        $user = Auth::user();
        
        if ($user->avatar && file_exists(public_path('assets/img/avatars/' . $user->avatar))) {
            unlink(public_path('assets/img/avatars/' . $user->avatar));
        }
        
        if (!file_exists(public_path('assets/img/avatars'))) {
            mkdir(public_path('assets/img/avatars'), 0777, true);
        }
        
        $avatarFile = $request->file('avatar');
        $extension = $avatarFile->getClientOriginalExtension();
        $fileName = 'avatar_' . time() . '_' . uniqid() . '.' . $extension;
        
        $avatarFile->move(public_path('assets/img/avatars'), $fileName);
        
        $user->update([
            'avatar' => $fileName
        ]);
        
        return redirect()->route('profile.edit')
            ->with('success', 'Avatar đã được cập nhật thành công!');
    }
}