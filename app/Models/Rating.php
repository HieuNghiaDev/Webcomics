<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['user_id', 'truyen_id', 'rating'];

    /**
     * Lấy người dùng đã đánh giá
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Lấy truyện được đánh giá
     */
    public function truyen()
    {
        return $this->belongsTo(Truyen::class, 'truyen_id');
    }
}