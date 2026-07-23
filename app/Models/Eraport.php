<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eraport extends Model
{
    protected $primaryKey = 'id_eraport';

    use HasFactory;

    protected $fillable = [
        'id_santri',
        'kelompok',
        'tahun_pelajaran',
        'nilai_tajwid',
        'nilai_fashahah',
        'nilai_irama',
        'nilai_adab',
        'nilai_ibadah',
        'nilai_doa',
        'nilai_surat',
        'nilai_sejarah',
        'nilai_dakwah',
        'nilai_akhlak',
        'ekstra_subuh',
        'ekstra_rebana',
        'ekstra_olahraga',
        'sikap_disiplin',
        'sikap_kebersihan',
        'absen_sakit',
        'absen_izin',
        'absen_alpa',
        'jumlah_nilai',
        'rata_rata',
        'kepala_tpa',
        'nama_pengajar',
        'tanggal_pelaporan',
        'catatan_guru',
        'caturwulan',
        'status_kenaikan'
    ];

    public function santri()
    {
        return $this->belongsTo(Santri::class, 'id_santri');
    }
}
