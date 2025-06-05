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
        // Lấy tất cả thể loại
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

        $truyenHot = Truyen::with('theLoai')
            ->join('thong_ke_truyen', 'truyen.id', '=', 'thong_ke_truyen.id_truyen')
            ->orderBy('thong_ke_truyen.luot_xem', 'desc')
            ->select('truyen.*', 'thong_ke_truyen.luot_xem')
            ->take(3)
            ->get();

        
        return view('index', compact('bannerTruyen', 'truyenDeXuat', 'theLoai', 'truyenMoi', 'truyenHot'));
    }

     public function BXHshow(Request $request)
    {
        // Lấy danh sách truyện xếp theo lượt xem cao nhất
        $truyenTopView = Truyen::with(['theLoai'])
            ->leftJoin('thong_ke_truyen', 'truyen.id', '=', 'thong_ke_truyen.id_truyen')
            ->orderBy('thong_ke_truyen.luot_xem', 'desc')
            ->select('truyen.*', 'thong_ke_truyen.luot_xem')
            ->paginate(15)
            ->withQueryString();
        
        return view('BXH', compact('truyenTopView'));
    }

    public function truyenHot()
    {
        $truyenHot = Truyen::with(['theLoai'])
            ->leftJoin('thong_ke_truyen', 'truyen.id', '=', 'thong_ke_truyen.id_truyen')
            ->orderBy('thong_ke_truyen.luot_xem', 'desc')
            ->select('truyen.*', 'thong_ke_truyen.luot_xem')
            ->paginate(24);
        
        return view('truyenHot', compact('truyenHot'));
    }

    public function moiCapNhat()
    {
        $truyenMoi = Truyen::with(['theLoai'])
            ->orderBy('ngay_update', 'desc')
            ->paginate(24);
        
        return view('moiCapNhat', compact('truyenMoi'));
    }

    public function daHoanThanh()
    {
        $truyenHoanThanh = Truyen::with(['theLoai'])
            ->where('tinh_trang', 1)
            ->orderBy('ngay_update', 'desc')
            ->paginate(24);
        
        return view('truyenDaHT', compact('truyenHoanThanh'));
    }
}