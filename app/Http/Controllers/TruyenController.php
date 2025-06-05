<?php

namespace App\Http\Controllers;

use App\Models\Truyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TruyenController extends Controller
{
    public function show($id)
    {
        $truyen = Truyen::with(['theLoai', 'chapters.anh'])
            ->leftJoin('thong_ke_truyen', 'truyen.id', '=', 'thong_ke_truyen.id_truyen')
            ->select('truyen.*', 'thong_ke_truyen.luot_xem')
            ->where('truyen.id', $id)
            ->firstOrFail();
            
        $this->tangLuotXem($id);

        $chapters = $truyen->chapters()->orderBy('id', 'desc')->get();

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
    
    private function tangLuotXem($idTruyen)
    {
        $thongKe = DB::table('thong_ke_truyen')->where('id_truyen', $idTruyen)->first();
        
        if ($thongKe) {
            DB::table('thong_ke_truyen')
                ->where('id_truyen', $idTruyen)
                ->increment('luot_xem');
        } else {
            DB::table('thong_ke_truyen')->insert([
                'id_truyen' => $idTruyen,
                'luot_xem' => 1
            ]);
        }
    }

    public function search(Request $request)
    {
        $request->validate([
            'keyword' => 'required|min:1|max:100',
        ]);
        
        $keyword = $request->input('keyword');
        
        $ketQuaTimKiem = Truyen::with('theLoai')
            ->leftJoin('thong_ke_truyen', 'truyen.id', '=', 'thong_ke_truyen.id_truyen')
            ->where('ten_truyen', 'LIKE', "%{$keyword}%")
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