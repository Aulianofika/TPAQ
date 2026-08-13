<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    protected $primaryKey = 'id_pengurus';

    protected $table = 'pengurus';

    protected $fillable = [
        'nama',
        'jenis_kelamin',
        'is_kepala',
        'no_hp',
        'alamat',
        'foto',
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
