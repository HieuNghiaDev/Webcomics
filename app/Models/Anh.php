<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anh extends Model
{
    use HasFactory;
    
    protected $table = 'chapter_anh';
    
    protected $fillable = [
        'chapter_id',
        'anh_url',
        'so_trang'
    ];
    
    // Relationship với chapter
    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }
}