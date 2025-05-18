<?php

namespace App\Http\Controllers;

use App\Models\Truyen;
use Illuminate\Http\Request;

class TruyenController extends Controller
{
    public function show($id)
    {
        $truyen = Truyen::with(['theLoai', 'chapters.anh'])->findOrFail($id);

        // Truyền danh sách chương (giả sử model Chapter đã được thiết lập)
        $chapters = $truyen->chapters()->orderBy('id', 'desc')->get();

        // Lấy các truyện cùng thể loại
        $relatedStories = Truyen::whereHas('theLoai', function ($query) use ($truyen) {
            return $query->whereIn('the_loai.id', $truyen->theLoai->pluck('id'));
        })->where('truyen.id', '!=', $truyen->id)->take(5)->get();
        return view('truyen', compact('truyen', 'chapters', 'relatedStories'));
    }
    
}