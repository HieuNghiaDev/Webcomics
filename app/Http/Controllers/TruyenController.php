<?php

namespace App\Http\Controllers;

use App\Models\Truyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TruyenController extends Controller
{
    public function show($id)
    {
        // Lấy thông tin truyện 
        $truyen = Truyen::with(['theLoai', 'chapters.anh'])
            ->leftJoin('thong_ke_truyen', 'truyen.id', '=', 'thong_ke_truyen.id_truyen')
            ->select('truyen.*', 'thong_ke_truyen.luot_xem')
            ->where('truyen.id', $id)
            ->firstOrFail();
            
        // Tăng lượt xem khi người dùng xem chi tiết truyện
        $this->tangLuotXem($id);

        // Lấy danh sách các chapter
        $chapters = $truyen->chapters()->orderBy('id', 'desc')->get();

        // Lấy các truyện cùng thể loại
        $relatedStories = Truyen::whereHas('theLoai', function ($query) use ($truyen) {
                return $query->whereIn('the_loai.id', $truyen->theLoai->pluck('id'));
            })
            ->leftJoin('thong_ke_truyen', 'truyen.id', '=', 'thong_ke_truyen.id_truyen')
            ->select('truyen.*', 'thong_ke_truyen.luot_xem')
            ->where('truyen.id', '!=', $truyen->id)
            ->take(5)
            ->get();

        return view('truyen', compact('truyen', 'chapters', 'relatedStories'));
    }
    
    /**
     * Tăng lượt xem cho truyện
     */
    private function tangLuotXem($idTruyen)
    {
        // Kiểm tra xem đã có luoc xem trong bảng thong_ke_truyen chưa
        $thongKe = DB::table('thong_ke_truyen')->where('id_truyen', $idTruyen)->first();
        
        if ($thongKe) {
            // Nếu đã có, tăng lượt xem lên 1
            DB::table('thong_ke_truyen')
                ->where('id_truyen', $idTruyen)
                ->increment('luot_xem');
        } else {
            // Nếu chưa có, tạo mới với lượt xem = 1
            DB::table('thong_ke_truyen')->insert([
                'id_truyen' => $idTruyen,
                'luot_xem' => 1
            ]);
        }
    }

    /**
     * Tìm kiếm truyện theo từ khóa
     */
    public function search(Request $request)
    {
        $request->validate([
            'keyword' => 'required|min:2|max:100',
        ]);
        
        $keyword = $request->input('keyword');
        
        // Tìm kiếm truyện theo tên
        $ketQuaTimKiem = Truyen::with('theLoai')
            ->leftJoin('thong_ke_truyen', 'truyen.id', '=', 'thong_ke_truyen.id_truyen')
            ->where('ten_truyen', 'LIKE', "%{$keyword}%")
            ->orWhere('mo_ta', 'LIKE', "%{$keyword}%")
            ->select('truyen.*', 'thong_ke_truyen.luot_xem')
            ->paginate(12);
        
        return view('timkiem', compact('ketQuaTimKiem', 'keyword'));
    }

    /**
     * Hiển thị tất cả truyện
     */
    public function index()
    {
        $allTruyen = Truyen::with('theLoai')
            ->leftJoin('thong_ke_truyen', 'truyen.id', '=', 'thong_ke_truyen.id_truyen')
            ->select('truyen.*', 'thong_ke_truyen.luot_xem')
            ->orderBy('ngay_update', 'desc')
            ->paginate(18);
        
        return view('alltruyen', compact('allTruyen'));
    }
}