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
        'id_user',
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'id_santri');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
