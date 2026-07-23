<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $primaryKey = 'id_kelas';

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
        'id_pengajar',
        'tahun_ajaran',
    ];

    public function pengajar()
    {
        return $this->belongsTo(Pengajar::class, 'id_pengajar');
    }

    public function santris()
    {
        return $this->hasMany(Santri::class, 'id_kelas');
    }
}
