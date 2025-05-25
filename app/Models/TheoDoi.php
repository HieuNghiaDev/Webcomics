<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheoDoi extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'theodoi';
    protected $fillable = [
        'user_id',
        'truyen_id'
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với Truyen
    public function truyen()
    {
        return $this->belongsTo(Truyen::class, 'truyen_id');
    }
}