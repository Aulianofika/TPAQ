<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengajar extends Model
{
    protected $primaryKey = 'id_pengajar';

    protected $table = 'pengajars';

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'no_hp',
        'alamat',
        'foto',
        'id_user',
    ];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id_pengajar');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
