<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Kelas;
use App\Models\Absensi;
use App\Models\ProgresHafalan;
use App\Models\RiwayatHafalan;
use App\Models\TargetHafalan;
use App\Models\Eraport;

class SantriProgressController extends Controller
{
    public function index(Request $request)
    {
        $classes = Kelas::all();
        $id_kelas = $request->input('id_kelas');
        $search = $request->input('search');

        $query = Santri::with(['kelas'])->where('status', 'aktif');

        if ($request->filled('id_kelas')) {
            $query->where('id_kelas', $id_kelas);
        }

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $students = $query->orderBy('nama', 'asc')->get();

        // Calculate Stats
        $total_santri = Santri::where('status', 'aktif')->count();
        
        $total_hadir = Absensi::where('status', 'hadir')->count();
        $total_absensi = Absensi::count();
        $avg_attendance = $total_absensi > 0 ? round(($total_hadir / $total_absensi) * 100) : 100;

        $total_hafalan_progress = ProgresHafalan::count();
        $total_eraports = Eraport::count();

        // For each student, get attendance rate and latest progress
        foreach ($students as $student) {
            $s_hadir = Absensi::where('id_santri', $student->id_santri)->where('status', 'hadir')->count();
            $s_total = Absensi::where('id_santri', $student->id_santri)->count();
            $student->attendance_percentage = $s_total > 0 ? round(($s_hadir / $s_total) * 100) : 100;

            $latest_progres = ProgresHafalan::where('id_santri', $student->id_santri)
                ->orderBy('tahun_pelajaran', 'desc')
                ->orderBy('caturwulan', 'desc')
                ->first();

            $student->latest_capaian = $latest_progres ? $latest_progres->capaian : '-';
            $student->latest_status = $latest_progres ? $latest_progres->status : null;
        }

        return view('admin.santri_progress.index', compact(
            'students', 'classes', 'id_kelas', 'search', 
            'total_santri', 'avg_attendance', 'total_hafalan_progress', 'total_eraports'
        ));
    }

    public function show($id, Request $request)
    {
        $student = Santri::with(['kelas'])->findOrFail($id);

        // 1. Absensi Stats
        $sakit = Absensi::where('id_santri', $id)->where('status', 'sakit')->count();
        $izin = Absensi::where('id_santri', $id)->where('status', 'izin')->count();
        $alfa = Absensi::where('id_santri', $id)->where('status', 'alfa')->count();
        $hadir = Absensi::where('id_santri', $id)->where('status', 'hadir')->count();
        $total_absensi = Absensi::where('id_santri', $id)->count();
        
        $attendance_percentage = $total_absensi > 0 ? round(($hadir / $total_absensi) * 100) : 100;

        // Recent Absensi
        $absensi_logs = Absensi::where('id_santri', $id)
            ->orderBy('tanggal', 'desc')
            ->take(15)
            ->get();

        // 2. Hafalan Progress
        $progres_hafalans = ProgresHafalan::where('id_santri', $id)
            ->orderBy('tahun_pelajaran', 'desc')
            ->orderBy('caturwulan', 'desc')
            ->get();

        $riwayat_hafalans = RiwayatHafalan::where('id_santri', $id)
            ->orderBy('created_at', 'desc')
            ->take(15)
            ->get();

        // Target Hafalan for comparison
        $targets = TargetHafalan::where('id_kelas', $student->id_kelas)
            ->orderBy('tahun_pelajaran', 'desc')
            ->orderBy('caturwulan', 'desc')
            ->get();

        // 3. Eraport History
        $eraports = Eraport::where('id_santri', $id)
            ->orderBy('tahun_pelajaran', 'desc')
            ->orderBy('caturwulan', 'desc')
            ->get();

        return view('admin.santri_progress.detail', compact(
            'student', 'sakit', 'izin', 'alfa', 'hadir', 'total_absensi', 'attendance_percentage', 'absensi_logs',
            'progres_hafalans', 'riwayat_hafalans', 'targets', 'eraports'
        ));
    }
}
