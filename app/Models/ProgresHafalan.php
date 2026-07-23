<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgresHafalan extends Model
{
    protected $primaryKey = 'id_progres';

    protected $fillable = [
        'id_santri',
        'caturwulan',
        'tahun_pelajaran',
        'capaian',
        'persentase',
        'status',
        'keterangan',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'id_santri');
    }
}
