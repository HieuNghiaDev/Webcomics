<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Truyen;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\ThongKeTruyen;
use Illuminate\Support\Facades\Auth;

class ChapterController extends Controller
{
    public function firstChapter($truyenId)
    {
        $truyen = Truyen::with('chapters')->findOrFail($truyenId);
        
        $chapter = $truyen->chapters()->orderBy('so_chap', 'asc')->first();
        
        if (!$chapter) {
            return redirect()->back()->with('error', 'Truyện này chưa có chapter nào!');
        }
        
        return $this->show($truyenId, $chapter->id);
    }
    
    // Hiển thị chi tiết chapter
    public function show($truyenId, $chapterId)
    {
        $truyen = Truyen::with('theLoai')->findOrFail($truyenId);
        $chapter = Chapter::with('anh')->findOrFail($chapterId);
        
        $chiTiet = ThongKeTruyen::firstOrCreate(
            ['id_truyen' => $truyenId],
            ['luot_xem' => 0]
        );
        $chiTiet->increment('luot_xem');
        
        // Lấy chapter trước và sau
        $prevChapter = Chapter::where('id_truyen', $truyenId)
                            ->where('so_chap', '<', $chapter->so_chap)
                            ->orderBy('so_chap', 'desc')
                            ->first();
                            
        $nextChapter = Chapter::where('id_truyen', $truyenId)
                            ->where('so_chap', '>', $chapter->so_chap)
                            ->orderBy('so_chap', 'asc')
                            ->first();
        
        // Lấy danh sách bình luận gốc (parent_id = 0)
        $comments = Comment::with(['user', 'replies.user'])
                        ->where('id_chap', $chapterId)
                        ->where('parent_id', 0) 
                        ->orderBy('ngay_dang', 'desc')
                        ->paginate(7);
        
        return view('chapter', compact('truyen', 'chapter', 'prevChapter', 'nextChapter', 'comments'));
    }
    
    // Xử lý thêm bình luận
    public function storeComment(Request $request, $chapterId)
    {
        $request->validate([
            'noi_dung' => 'required|min:2',
            'parent_id' => 'nullable'
        ]);
        
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần đăng nhập để bình luận!');
        }
        
        $chapter = Chapter::findOrFail($chapterId);
        $truyenId = $chapter->id_truyen;
        
        Comment::create([
            'user_id' => Auth::id(),
            'id_chap' => $chapterId,
            'id_truyen' => $truyenId,
            'noi_dung' => $request->noi_dung,
            'parent_id' => $request->parent_id ?? 0
        ]);
        
        return redirect()->back()->with('success', 'Đã thêm bình luận thành công!');
    }
}