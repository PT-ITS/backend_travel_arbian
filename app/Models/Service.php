<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_ganti_service',
        'keterangan',
        'bengkel',
        'harga',
        'nota',
        'fk_id_mobil',
        'fk_id_pj',
    ];
}
