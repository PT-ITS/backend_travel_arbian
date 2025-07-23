<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis',
        'merk',
        'kapasitas',
        'nopol',
        'foto',
        'fk_id_driver',
    ];
}
