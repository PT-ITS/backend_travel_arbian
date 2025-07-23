<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oli extends Model
{
    use HasFactory;

    protected $fillable = [
        'merk',
        'kilometer_mobil',
        'tanggal_ganti_oli',
        'harga',
        'nota',
        'fk_id_mobil'
    ];
}
