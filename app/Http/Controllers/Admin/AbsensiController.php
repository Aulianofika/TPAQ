<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Santri;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $classes = Kelas::all();
        
        $selected_class_id = $request->input('id_kelas', 'semua');
        $selected_date = $request->input('tanggal', today()->toDateString());

        $students = collect();
        $existing_attendance = collect();
        $present_count = 0;
        $izin_count = 0;
        $sakit_count = 0;
        $alfa_count = 0;
        $total_students = 0;

        if ($selected_class_id === 'semua') {
            $students = Santri::with('kelas')->where('status', 'aktif')->get();
        } elseif ($selected_class_id) {
            $students = Santri::with('kelas')->where('id_kelas', $selected_class_id)->where('status', 'aktif')->get();
        }

        $total_students = $students->count();

        if ($total_students > 0) {
            $existing_attendance = Absensi::whereIn('id_santri', $students->pluck('id_santri'))
                ->where('tanggal', $selected_date)
                ->get()
                ->keyBy('id_santri');
                
            $present_count = $existing_attendance->where('status', 'hadir')->count();
            $izin_count = $existing_attendance->where('status', 'izin')->count();
            $sakit_count = $existing_attendance->where('status', 'sakit')->count();
            $alfa_count = $existing_attendance->where('status', 'alfa')->count();
        }

        return view('admin.absensi', compact(
            'classes', 
            'selected_class_id', 
            'selected_date', 
            'students', 
            'existing_attendance', 
            'present_count', 
            'izin_count',
            'sakit_count',
            'alfa_count',
            'total_students'
        ));
    }

    public function rekap(Request $request)
    {
        $classes = Kelas::all();
        $selected_class_id = $request->input('id_kelas', 'semua');
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $students = collect();
        if ($selected_class_id === 'semua') {
            $students = Santri::where('status', 'aktif')->with(['kelas', 'absensis' => function($query) use ($bulan, $tahun) {
                $query->whereMonth('tanggal', $bulan)
                      ->whereYear('tanggal', $tahun);
            }])->get();
        } elseif ($selected_class_id) {
            // filter absensi berdasarkan tahun/bulan
            $students = Santri::where('id_kelas', $selected_class_id)->where('status', 'aktif')->with(['kelas', 'absensis' => function($query) use ($bulan, $tahun) {
                $query->whereMonth('tanggal', $bulan)
                      ->whereYear('tanggal', $tahun);
            }])->get();
        }

        return view('admin.absensi_rekap', compact(
            'classes', 
            'selected_class_id', 
            'bulan', 
            'tahun', 
            'students'
        ));
    }

    public function cetakPdf(Request $request)
    {
        $classes = Kelas::all();
        $selected_class_id = $request->input('id_kelas', 'semua');
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $kelas = $selected_class_id === 'semua' ? null : Kelas::find($selected_class_id);
        $students = collect();
        if ($selected_class_id === 'semua') {
            $students = Santri::where('status', 'aktif')->with(['kelas', 'absensis' => function($query) use ($bulan, $tahun) {
                $query->whereMonth('tanggal', $bulan)
                      ->whereYear('tanggal', $tahun);
            }])->get();
        } elseif ($selected_class_id) {
            $students = Santri::where('id_kelas', $selected_class_id)->where('status', 'aktif')->with(['kelas', 'absensis' => function($query) use ($bulan, $tahun) {
                $query->whereMonth('tanggal', $bulan)
                      ->whereYear('tanggal', $tahun);
            }])->get();
        }

        $user = \Illuminate\Support\Facades\Auth::user();
        $nama_guru = $user ? ($user->pengajar ? $user->pengajar->nama : $user->name) : '( .................................... )';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.absensi_pdf', compact('students', 'kelas', 'bulan', 'tahun', 'nama_guru'));
        $kelasName = $kelas ? $kelas->nama_kelas : 'Semua_Kelas';
        return $pdf->download('Rekap_Absensi_'.$kelasName.'_'.$bulan.'-'.$tahun.'.pdf');
    }

    public function previewPdf(Request $request)
    {
        $classes = Kelas::all();
        $selected_class_id = $request->input('id_kelas', 'semua');
        $bulan = $request->input('bulan', date('m'));
        $tahun = $request->input('tahun', date('Y'));

        $kelas = $selected_class_id === 'semua' ? null : Kelas::find($selected_class_id);
        $students = collect();
        if ($selected_class_id === 'semua') {
            $students = Santri::where('status', 'aktif')->with(['kelas', 'absensis' => function($query) use ($bulan, $tahun) {
                if ($bulan !== 'semua') {
                    $query->whereMonth('tanggal', $bulan);
                }
                $query->whereYear('tanggal', $tahun);
            }])->get();
        } elseif ($selected_class_id) {
            $students = Santri::where('id_kelas', $selected_class_id)->where('status', 'aktif')->with(['kelas', 'absensis' => function($query) use ($bulan, $tahun) {
                if ($bulan !== 'semua') {
                    $query->whereMonth('tanggal', $bulan);
                }
                $query->whereYear('tanggal', $tahun);
            }])->get();
        }

        $user = \Illuminate\Support\Facades\Auth::user();
        $nama_guru = $user ? ($user->pengajar ? $user->pengajar->nama : $user->name) : '( .................................... )';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.absensi_pdf', compact('students', 'kelas', 'bulan', 'tahun', 'nama_guru'));
        return $pdf->stream('Preview_Rekap_Absensi.pdf');
    }

    public function store(Request $request)
    {
        $messages = [
            'tanggal.required' => 'Tanggal absensi wajib dipilih.'
        ];

        $request->validate([
            'tanggal' => 'required|date',
            'attendance' => 'nullable|array',
            'attendance.*' => 'required|in:hadir,izin,sakit,alfa',
        ], $messages);

        $date = $request->input('tanggal');
        $attendanceData = $request->input('attendance', []);

        if (empty($attendanceData)) {
            return redirect()->back()->with('error', 'Tidak ada data absensi yang dipilih.');
        }

        // Validate that attendance cannot be submitted for future dates
        if ($date > today()->toDateString()) {
            return redirect()->back()->with('error', 'Gagal! Absensi tidak bisa diinput untuk hari besok atau yang akan datang.');
        }

        // Check if attendance already exists for any of these students on the selected date
        $sudah_absen = Absensi::whereIn('id_santri', array_keys($attendanceData))
            ->where('tanggal', $date)
            ->exists();

        if ($sudah_absen) {
            return redirect()->back()->with('error', 'Gagal! Absensi untuk santri pada tanggal ini sudah pernah diambil.');
        }

        foreach ($attendanceData as $id_santri => $status) {
            Absensi::create([
                'id_santri' => $id_santri,
                'tanggal' => $date,
                'status' => $status,
            ]);
        }

        return redirect()->back()->with('success', 'Absensi berhasil disimpan!');
    }
}
