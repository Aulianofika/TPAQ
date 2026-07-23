<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    protected $primaryKey = 'id_santri';

    protected $table = 'santris';

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'tgl_lahir',
        'alamat',
        'nama_wali',
        'no_hp_wali',
        'id_kelas',
        'status',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'id_santri');
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class, 'id_santri');
    }
}
