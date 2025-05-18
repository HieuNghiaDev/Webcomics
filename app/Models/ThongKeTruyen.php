<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThongKeTruyen extends Model
{
    use HasFactory;

    protected $table = 'thong_ke_truyen';

     public $timestamps = false;

    protected $fillable = [
        'id_truyen',
        'luot_xem',
        'luot_thich',
    ];

    // Quan hệ với bảng Truyen
    public function truyen()
    {
        return $this->belongsTo(Truyen::class, 'id_truyen');
    }
}