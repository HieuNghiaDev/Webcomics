<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Truyen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{ 
    
    public function store(Request $request, $truyenId)
    {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
        ]);
        
        $truyen = Truyen::findOrFail($truyenId);
        
        // Kiểm tra xem người dùng đã đánh giá truyện này chưa
        $isRating = Rating::where('user_id', Auth::id())
            ->where('truyen_id', $truyenId)
            ->first();
        
        if ($isRating) {
            $isRating->rating = $request->rating;
            $isRating->save();
            $message = 'Cập nhật đánh giá thành công!';
        } else {
            Rating::create([
                'user_id' => Auth::id(),
                'truyen_id' => $truyenId,
                'rating' => $request->rating,
            ]);
            $message = 'Đánh giá thành công!';
        }
        
        $truyen->updateRating();
        
        return redirect()->back()->with('success', $message);
    }
}