<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TujuanPerjalanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'fk_id_perjalanan',
        'fk_id_tujuan',
    ];
}
