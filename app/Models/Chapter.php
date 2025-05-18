<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    use HasFactory;
    
    protected $table = 'chapter';
    
    protected $fillable = [
        'id_truyen',
        'ten_chap',
        'so_chap',
        'ngay_dang'
    ];
    
    // Relationship với truyen
    public function truyen()
    {
        return $this->belongsTo(Truyen::class, 'id_truyen');
    }
    
    // Relationship với ảnh
    public function anh()
    {
        return $this->hasMany(Anh::class, 'chapter_id');
    }
    
    // Relationship với comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}