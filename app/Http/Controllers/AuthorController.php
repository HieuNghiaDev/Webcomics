<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truyen;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthorController extends Controller
{
    
    /**
     * Trang quản lý truyện của author (dashboard)
     */
    public function dashboard()
    {
        $comics = Truyen::where('id_user', Auth::id())->orderBy('ngay_update', 'desc')->paginate(10);
        return view('author.dashboard', compact('comics'));
    }

    /**
     * Xử lý thêm truyện mới
     */
    public function addComic(Request $request)
    {

        if ($request->isMethod('post')) {
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
                'id_user' => Auth::id(),
            ]);

            // Liên kết với thể loại
            $truyen->theLoai()->attach($validated['the_loai']);

            return redirect()->route('author.dashboard')->with('success', 'Thêm truyện thành công!');
        }

        return view('author.addComic');
    }

    /**
     * Xử lý chỉnh sửa truyện
     */
    public function editComic(Request $request, $id)
    {

        $comic = Truyen::findOrFail($id);

        if ($comic->id_user != Auth::id()) {
            return redirect()->route('author.dashboard')->with('error', 'Bạn không có quyền chỉnh sửa truyện này!');
        }

        if ($request->isMethod('post')) {
            $validated = $request->validate([
                'ten_truyen' => 'required|string|max:255',
                'anh_bia' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'anh_banner' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'tac_gia' => 'required|string|max:255',
                'mo_ta' => 'required|string',
                'tinh_trang' => 'required|in:Đang tiến hành,Hoàn thành,Tạm ngưng',
            ]);

            // Cập nhật thông tin truyện
            $comic->ten_truyen = $validated['ten_truyen'];
            $comic->tac_gia = $validated['tac_gia'];
            $comic->mo_ta = $validated['mo_ta'];
            $comic->tinh_trang = $validated['tinh_trang'];
            $comic->ngay_update = now();

            // Xử lý upload ảnh bìa
            if ($request->hasFile('anh_bia')) {
                if ($comic->anh_bia) {
                    Storage::disk('public')->delete($comic->anh_bia);
                }
                $comic->anh_bia = $request->file('anh_bia')->store('comics/covers', 'public');
            }

            // Xử lý upload ảnh banner 
            if ($request->hasFile('anh_banner')) {
                if ($comic->anh_banner) {
                    Storage::disk('public')->delete($comic->anh_banner);
                }
                $comic->anh_banner = $request->file('anh_banner')->store('comics/banners', 'public');
            }

            $comic->save();

            return redirect()->route('author.dashboard')->with('success', 'Cập nhật truyện thành công!');
        }

        return view('author.editComic', compact('comic'));
    }

    public function viewComic($id)
    {

        $comic = Truyen::findOrFail($id);

        if ($comic->id_user != Auth::id()) {
            return redirect()->route('author.dashboard')->with('error', 'Bạn không có quyền xem truyện này!');
        }

        return view('author.viewsComic', compact('comic'));
    }

    public function deleteComic($id)
    {
        $comic = Truyen::findOrFail($id);

        // Kiểm tra quyền sở hữu
        if ($comic->id_user != Auth::id()) {
            return redirect()->route('author.dashboard')->with('error', 'Bạn không có quyền xóa truyện này!');
        }

        // Xóa ảnh bìa và banner
        if ($comic->anh_bia) {
            Storage::disk('public')->delete($comic->anh_bia);
        }
        if ($comic->anh_banner) {
            Storage::disk('public')->delete($comic->anh_banner);
        }

        $comic->delete();

        return redirect()->route('author.dashboard')->with('success', 'Xóa truyện thành công!');
    }
}