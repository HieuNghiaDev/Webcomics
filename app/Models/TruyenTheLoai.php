<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TruyenTheLoai extends Model
{
    use HasFactory;

    protected $table = 'truyen_the_loai';
    protected $fillable = ['id_truyen', 'id_the_loai'];
}