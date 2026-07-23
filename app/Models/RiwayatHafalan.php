<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatHafalan extends Model
{
    protected $table = 'riwayat_hafalans';
    protected $primaryKey = 'id_riwayat';

    protected $fillable = [
        'id_santri',
        'caturwulan',
        'tahun_pelajaran',
        'capaian',
        'status',
        'keterangan',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'id_santri');
    }
}
