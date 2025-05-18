<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YeuThich;
use App\Models\Truyen;
use Illuminate\Support\Facades\Auth;

class YeuThichController extends Controller
{
    /**
     * Constructor - đảm bảo đã đăng nhập
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);
    }
    
    /**
     * Toggle trạng thái yêu thích của truyện
     */
    public function toggle(Request $request)
    {
        // Kiểm tra đăng nhập
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để sử dụng chức năng này',
                'redirect' => route('login')
            ], 401);
        }

        $request->validate([
            'truyen_id' => 'required|exists:truyen,id'
        ]);

        $userId = Auth::id();
        $truyenId = $request->truyen_id;

        // Kiểm tra xem đã yêu thích chưa
        $yeuThich = YeuThich::where('user_id', $userId)
                            ->where('truyen_id', $truyenId)
                            ->first();

        if ($yeuThich) {
            // Nếu đã yêu thích thì xóa
            $yeuThich->delete();
            return response()->json([
                'success' => true,
                'status' => 'removed',
                'message' => 'Đã xóa khỏi danh sách yêu thích'
            ]);
        } else {
            // Nếu chưa yêu thích thì thêm mới
            YeuThich::create([
                'user_id' => $userId,
                'truyen_id' => $truyenId
            ]);
            return response()->json([
                'success' => true,
                'status' => 'added',
                'message' => 'Đã thêm vào danh sách yêu thích'
            ]);
        }
    }
    
    /**
     * Hiển thị danh sách truyện yêu thích
     */
    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem truyện yêu thích');
        }
        
        $truyenYeuThich = YeuThich::where('user_id', Auth::id())
            ->with('truyen')
            ->latest()
            ->paginate(12);
            
        return view('yeuthich.index', compact('truyenYeuThich'));
    }
}