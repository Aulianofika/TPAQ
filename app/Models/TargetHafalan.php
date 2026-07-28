<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetHafalan extends Model
{
    protected $primaryKey = 'id_target';

    protected $fillable = [
        'id_kelas',
        'caturwulan',
        'target',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas');
    }
}
