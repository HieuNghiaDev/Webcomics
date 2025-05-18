<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YeuThich extends Model
{
    use HasFactory;

    protected $table = 'yeu_thich';
    
    protected $fillable = [
        'user_id',
        'truyen_id'
    ];

    // Relationship với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relationship với Truyen
    public function truyen()
    {
        return $this->belongsTo(Truyen::class, 'truyen_id');
    }
}