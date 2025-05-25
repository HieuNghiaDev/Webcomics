<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TheLoai;
use App\Models\Truyen;

class TheLoaiController extends Controller
{
    public function show($id)
    {
        // Kiểm tra xem thể loại có tồn tại không
        $currentTheLoai = TheLoai::findOrFail($id);
        
        // Lấy danh sách truyện thuộc thể loại trên
        $truyens = Truyen::whereHas('theLoai', function($query) use ($id) {
            $query->where('the_loai.id', $id);
        })
        ->leftJoin('thong_ke_truyen', 'truyen.id', '=', 'thong_ke_truyen.id_truyen')
        ->select('truyen.*', 'thong_ke_truyen.luot_xem')
        ->with('theLoai')
        ->orderBy('truyen.ngay_update', 'desc')
        ->paginate(12);
        
        return view('theloai', compact('currentTheLoai', 'truyens'));
    }
}