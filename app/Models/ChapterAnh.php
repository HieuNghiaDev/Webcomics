<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChapterAnh extends Model
{
    use HasFactory;

    protected $table = 'chapter_anh'; // Tên bảng trong database
    protected $fillable = ['chapter_id', 'anh_url', 'so_trang'];

    /**
     * Mối quan hệ n-1 với bảng `chapter`.
     */
    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id', 'id');
    }
}