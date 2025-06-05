<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    
    public $timestamps = false;
    
    protected $fillable = [
        'user_id',
        'id_chap',
        'id_truyen',
        'noi_dung',
        'parent_id',
        'ngay_dang',
        'ngay_update'
    ];
    
    // Đặt ngày mặc định khi tạo mới
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($comment) {
            $comment->ngay_dang = $comment->ngay_dang ?? now();
            $comment->ngay_update = $comment->ngay_update ?? now();
        });
    }
    
    // Quan hệ với chapter
    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'id_chap');
    }
    
    // Quan hệ với truyen
    public function truyen()
    {
        return $this->belongsTo(Truyen::class, 'id_truyen');
    }
    
    // Quan hệ với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    // Lấy các phản hồi cho comment này
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id', 'id')
                    ->orderBy('ngay_dang', 'asc');
    }
    
    // Lấy comment cha
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id', 'id');
    }
}