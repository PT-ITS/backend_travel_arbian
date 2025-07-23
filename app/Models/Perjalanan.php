<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perjalanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'waktu_berangkat',
        'waktu_kembali',
        'fk_id_mobil',
        'fk_id_pj',
    ];
}
