<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Truyen extends Model
{
    use HasFactory;

    protected $table = 'truyen';

    const CREATED_AT = 'ngay_dang';
    const UPDATED_AT = 'ngay_update';

    protected $fillable = [
        'ten_truyen',
        'mo_ta',
        'anh_bia',
        'tac_gia',
        'tinh_trang',
        'ngay_update',
        'ngay_dang',
    ];

    

    // Quan hệ với bảng ThongKeTruyen (thống kê lượt xem)
    public function thongKe()
    {
        return $this->hasOne(ThongKeTruyen::class, 'id_truyen');
    }

    // Quan hệ với bảng TheLoai qua bảng trung gian TruyenTheLoai
    public function theLoai()
    {
        return $this->belongsToMany(TheLoai::class, 'truyen_the_loai', 'id_truyen', 'id_the_loai');
    }

    // Quan hệ với bảng Chapter (các chương của truyện)
    public function chapters()
    {
        return $this->hasMany(Chapter::class, 'id_truyen', 'id');
    }

    // Quan hệ với bảng TruyenTheoDoi (theo dõi truyện)
    public function nguoiTheoDoi()
    {
        return $this->belongsToMany(User::class, 'truyen_theo_doi', 'truyen_id', 'user_id')
                    ->withTimestamps();
    }
    
}