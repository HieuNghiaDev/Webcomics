<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Truyen;
use App\Models\TheLoai;

class AdminController extends Controller
{
    public function trangChu()
    {
        $totalUsers = User::count();
        $totalTruyen = Truyen::count();
        $newTruyen = Truyen::where('ngay_dang', '>=', now()->subDays(7))->count();
        
        return view('layouts.admin', compact('totalUsers', 'totalTruyen', 'newTruyen'));
    }

    public function quanLyNguoiDung(Request $request)
    {
        $query = User::query();
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        
        $users = $query->paginate(10);
        
        return view('admin.quanLyNguoiDung', compact('users'));
    }

    public function themNguoiDung()
    {
        return view('admin.themNguoiDung');
    }

    public function luuNguoiDung(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => md5($validated['password']),
            'avatar' => null,
        ]);
        
        return redirect()->route('nguoiDung')->with('success', 'Tạo tài khoản thành công!');
    }

    public function suaNguoiDung($id)
    {
        $user = User::findOrFail($id);
        return view('admin.suaNguoiDung', compact('user'));
    }

    public function capNhatNguoiDung(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:users,name,'.$id,
            'email' => 'required|string|email|max:255|unique:users,email,'.$id,
            'role' => 'required|in:0,1,2',
            'password' => 'nullable|string|min:6',
        ]);
        
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->role = $validated['role'];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($request->password);
        }
        
        $user->save();
        
        return redirect()->route('nguoiDung')->with('success', 'Cập nhật tài khoản thành công!');
    }

    public function xoaNguoiDung($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Bạn không thể xóa tài khoản của chính mình!');
        }
        
        $user->delete();
        
        return redirect()->route('nguoiDung')->with('success', 'Đã xóa tài khoản!');
    }

    public function quanLyTruyen(Request $request)
    {
        $query = Truyen::with('theLoai');
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('ten_truyen', 'like', "%{$search}%");
        }

        if ($request->has('the_loai') && $request->the_loai != '') {
            $query->whereHas('theLoai', function($q) use ($request) {
                $q->where('id', $request->the_loai);
            });
        }
   
        $truyen = $query->paginate(10);
        $theLoai = TheLoai::all();
        
        return view('admin.quanLyTruyen', compact('truyen', 'theLoai'));
    }

    public function themTruyen()
    {
        $theLoai = TheLoai::all();
        return view('admin.themTruyen', compact('theLoai'));
    }

    public function luuTruyen(Request $request)
    {
        $validated = $request->validate([
            'ten_truyen' => 'required|string|max:255',
            'mo_ta' => 'required|string',
            'tac_gia' => 'required|string|max:255',
            'anh_bia' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'the_loai' => 'required|array',
            'the_loai.*' => 'exists:the_loai,id',
            'tinh_trang' => 'required|in:0,1',
        ]);
        
        // Lưu ảnh bìa
        $anhBiaName = time() . '.' . $request->anh_bia->extension();
        $request->anh_bia->move(public_path('assets/img/cover_img'), $anhBiaName);
        
        // Tạo truyện mới
        $truyen = Truyen::create([
            'ten_truyen' => $validated['ten_truyen'],
            'mo_ta' => $validated['mo_ta'],
            'tac_gia' => $validated['tac_gia'],
            'anh_bia' => $anhBiaName,
            'tinh_trang' => $validated['tinh_trang'],
            'ngay_update' => now(),
        ]);
        
        // Liên kết với thể loại
        $truyen->theLoai()->attach($validated['the_loai']);
        
        return redirect()->route('truyen')->with('success', 'Tạo truyện mới thành công!');
    }

    public function suaTruyen($id)
    {
        $truyen = Truyen::with('theLoai')->findOrFail($id);
        $theLoai = TheLoai::all();
        
        return view('admin.suaTruyen', compact('truyen', 'theLoai'));
    }

    public function capNhatTruyen(Request $request, $id)
    {
        $truyen = Truyen::findOrFail($id);
        
        $validated = $request->validate([
            'ten_truyen' => 'required|string|max:255',
            'mo_ta' => 'required|string',
            'tac_gia' => 'required|string|max:255',
            'anh_bia' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'the_loai' => 'required|array',
            'the_loai.*' => 'exists:the_loai,id',
            'tinh_trang' => 'required|in:0,1',
        ]);
        
        // Cập nhật ảnh bìa nếu có
        if ($request->hasFile('anh_bia')) {
            // Xóa ảnh cũ
            if (file_exists(public_path('assets/img/cover_img/' . $truyen->anh_bia))) {
                unlink(public_path('assets/img/cover_img/' . $truyen->anh_bia));
            }
            
            // Lưu ảnh mới
            $anhBiaName = time() . '.' . $request->anh_bia->extension();
            $request->anh_bia->move(public_path('assets/img/cover_img'), $anhBiaName);
            $truyen->anh_bia = $anhBiaName;
        }
        
        // Cập nhật thông tin
        $truyen->ten_truyen = $validated['ten_truyen'];
        $truyen->mo_ta = $validated['mo_ta'];
        $truyen->tac_gia = $validated['tac_gia'];
        $truyen->tinh_trang = $validated['tinh_trang'];
        $truyen->ngay_update = now();
        $truyen->save();
        
        // Cập nhật thể loại
        $truyen->theLoai()->sync($validated['the_loai']);
        
        return redirect()->route('truyen')->with('success', 'Cập nhật truyện thành công!');
    }

    public function xoaTruyen($id)
    {
        $truyen = Truyen::findOrFail($id);
        
        // Xóa ảnh
        if (file_exists(public_path('assets/img/cover_img/' . $truyen->anh_bia))) {
            unlink(public_path('assets/img/cover_img/' . $truyen->anh_bia));
        }
        
        // Xóa liên kết với thể loại
        $truyen->theLoai()->detach();
        
        // Xóa truyện
        $truyen->delete();
        
        return redirect()->route('truyen')->with('success', 'Đã xóa truyện!');
    }
}