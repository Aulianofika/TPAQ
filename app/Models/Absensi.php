<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $primaryKey = 'id_absensi';

    protected $table = 'absensis';

    protected $fillable = [
        'id_santri',
        'tanggal',
        'status',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'id_santri');
    }
}
