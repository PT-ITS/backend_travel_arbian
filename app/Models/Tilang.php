<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tilang extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_tilang',
        'jenis_pelanggaran',
        'keterangan',
        'lokasi',
        'fk_id_mobil',
        'fk_id_pj',
    ];
}
