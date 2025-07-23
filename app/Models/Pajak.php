<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pajak extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_pajak',
        'jenis_pajak',
        'lokasi_samsat',
        'biaya',
        'nota',
        'fk_id_mobil',
        'fk_id_pj',
    ];
}
