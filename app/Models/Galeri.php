<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $primaryKey = 'id_galeri';

    use HasFactory;

    protected $fillable = [
        'judul',
        'kategori',
        'foto',
        'deskripsi',
    ];
}
