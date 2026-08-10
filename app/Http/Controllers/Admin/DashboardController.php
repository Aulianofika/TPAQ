<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $total_santri = \App\Models\Santri::count();
        $santri_aktif = \App\Models\Santri::where('status', 'Aktif')->count();
        
        if ($santri_aktif == 0 && $total_santri > 0) {
            $santri_aktif = \App\Models\Santri::where('status', 'aktif')->count();
            if ($santri_aktif == 0) $santri_aktif = $total_santri;
        }

        $total_pengajar = \App\Models\Pengajar::count();
        $total_pengurus = \App\Models\Pengurus::count();
        
        $total_absensi = \App\Models\Absensi::whereDate('tanggal', now()->toDateString())->count();
        $hadir = \App\Models\Absensi::whereDate('tanggal', now()->toDateString())->whereIn('status', ['hadir', 'Hadir'])->count();
        $persentase_hadir = $total_absensi > 0 ? round(($hadir / $total_absensi) * 100) : 100;
        
        $aktivitas_terbaru = \App\Models\RiwayatHafalan::with('santri')->latest()->take(4)->get();
        
        // 1. Calculate Real Weekly Attendance (Last 6 active dates)
        $dates = \App\Models\Absensi::select('tanggal')
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->take(4)
            ->pluck('tanggal')
            ->reverse();

        $day_names = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $weekly_attendance = [];
        if ($dates->count() > 0) {
            foreach ($dates as $date) {
                $total_day_absensi = \App\Models\Absensi::whereDate('tanggal', $date)->count();
                $day_hadir = \App\Models\Absensi::whereDate('tanggal', $date)->whereIn('status', ['hadir', 'Hadir'])->count();
                $percent = $total_day_absensi > 0 ? round(($day_hadir / $total_day_absensi) * 100) : 0;
                
                $day_en = date('l', strtotime($date));
                $day_id = $day_names[$day_en] ?? $day_en;
                
                $weekly_attendance[] = [
                    'day' => $day_id,
                    'percentage' => $percent
                ];
            }
        } else {
            // Fallback dummy data if no attendance is logged yet
            $weekly_attendance = [
                ['day' => 'Senin', 'percentage' => 85],
                ['day' => 'Selasa', 'percentage' => 90],
                ['day' => 'Rabu', 'percentage' => 88],
                ['day' => 'Kamis', 'percentage' => 92],
                ['day' => 'Jumat', 'percentage' => 80],
                ['day' => 'Sabtu', 'percentage' => 85],
            ];
        }

        $total_iuran = 0;
        if (Auth::check() && Auth::user()->role === 'admin') {            // Mengambil data asli total pembayaran iuran bulan ini yang berstatus Lunas
            $total_iuran = \App\Models\Pembayaran::where('status', 'Lunas')
                ->whereMonth('tanggal_bayar', now()->month)
                ->whereYear('tanggal_bayar', now()->year)
                ->sum('jumlah');
        }

        return view('admin.dashboard', compact(
            'total_santri', 
            'santri_aktif', 
            'total_pengajar', 
            'persentase_hadir',
            'total_absensi',
            'aktivitas_terbaru',
            'weekly_attendance',
            'total_iuran'
        ));
    }
}
