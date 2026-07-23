<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    protected $primaryKey = 'id_pengumuman';

    use HasFactory;

    protected $fillable = [
        'judul',
        'kategori',
        'isi',
        'gambar',
        'tanggal',
    ];
}
