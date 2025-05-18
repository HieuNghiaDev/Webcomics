<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    use HasFactory;

    protected $table = 'the_loai';

    protected $fillable = [
        'ten_the_loai',
    ];

    // Quan hệ với bảng Truyen qua bảng trung gian TruyenTheLoai
    public function truyen()
    {
        return $this->belongsToMany(Truyen::class, 'truyen_the_loai', 'id_the_loai', 'id_truyen');
    }
}