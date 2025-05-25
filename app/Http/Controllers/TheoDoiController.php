<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TheoDoi;
use App\Models\Truyen;
use Illuminate\Support\Facades\Auth;

class TheoDoiController extends Controller
{
    public function toggleTheoDoi($truyenId)
    {
        $userId = Auth::id();
        
        // Kiểm tra xem đã theo dõi chưa
        $theoDoi = TheoDoi::where('user_id', $userId)
            ->where('truyen_id', $truyenId)
            ->first();
            
        if ($theoDoi) {
            // Nếu đã theo dõi, hủy theo dõi
            $theoDoi->delete();
            return redirect()->back()->with('success', 'Đã hủy theo dõi truyện này');
        } else {
            // Nếu chưa theo dõi, thêm vào danh sách theo dõi
            TheoDoi::create([
                'user_id' => $userId,
                'truyen_id' => $truyenId
            ]);
            return redirect()->back()->with('success', 'Đã theo dõi truyện này thành công');
        }
    }
    
    // Phương thức hiển thị danh sách theo dõi đã sửa
    public function index(Request $request)
    {
        $userId = Auth::id();
        
        // Lấy danh sách ID truyện đang theo dõi
        $truyenIds = TheoDoi::where('user_id', $userId)
            ->pluck('truyen_id');
            
        // Lấy thông tin đầy đủ của các truyện
        $query = Truyen::whereIn('truyen.id', $truyenIds)  // FIXED: Thêm 'truyen.' trước 'id'
            ->leftJoin('thong_ke_truyen', 'truyen.id', '=', 'thong_ke_truyen.id_truyen')
            ->select('truyen.*', 'thong_ke_truyen.luot_xem')
            ->with('theLoai');
        
        // Phân trang
        $truyenTheoDoi = $query->paginate(18);
        
        return view('theodoi', compact('truyenTheoDoi'));
    }
}