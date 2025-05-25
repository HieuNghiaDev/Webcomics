<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truyen;
use App\Models\TheLoai;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Debug để xem có lấy được dữ liệu thể loại không
        $theLoai = TheLoai::all();
        \Log::info('Số thể loại: ' . $theLoai->count());

        // Lấy 3 truyện nổi bật cho banner
        $bannerTruyen = Truyen::orderBy('id', 'desc')->take(3)->get();

        // Lấy truyện đề xuất
        // $truyenDeXuat = Truyen::orderBy('ngay_update', 'desc')->take(6)->get();
        $truyenDeXuat = Truyen::with('theLoai')
            ->leftJoin('thong_ke_truyen', 'truyen.id', '=', 'thong_ke_truyen.id_truyen')
            ->orderBy('thong_ke_truyen.luot_xem', 'desc')
            ->select('truyen.*', 'thong_ke_truyen.luot_xem')
            ->take(6)
            ->get();

        // Debug để xem có lấy được dữ liệu truyện không
        $truyenMoi = Truyen::with('theLoai')
            ->leftJoin('thong_ke_truyen', 'truyen.id', '=', 'thong_ke_truyen.id_truyen')
            ->orderBy('truyen.ngay_update', 'desc')
            ->select('truyen.*', 'thong_ke_truyen.luot_xem') 
            ->take(6)
            ->get();

        //truyen Hot
        // $truyenHot = Truyen::with('theLoai')
        //     ->join('truyen_the_loai', 'truyen.id', '=', 'truyen_the_loai.id_truyen')
        //     ->join('thong_ke_truyen', 'truyen.id', '=', 'thong_ke_truyen.id_truyen')
        //     ->orderBy('thong_ke_truyen.luot_xem', 'desc')
        //     ->take(3)
        //     ->get();

        $truyenHot = Truyen::with('theLoai') // Eager loading thể loại
            ->join('thong_ke_truyen', 'truyen.id', '=', 'thong_ke_truyen.id_truyen')
            ->orderBy('thong_ke_truyen.luot_xem', 'desc')
            ->select('truyen.*', 'thong_ke_truyen.luot_xem')
            ->take(3)
            ->get();

        
        return view('index', compact('bannerTruyen', 'truyenDeXuat', 'theLoai', 'truyenMoi', 'truyenHot'));
    }
}