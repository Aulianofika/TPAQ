<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_santri',
        'bulan',
        'tahun',
        'jumlah',
        'status',
        'tanggal_bayar'
    ];

    protected $casts = [
        'tanggal_bayar' => 'date'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'id_santri');
    }
}
