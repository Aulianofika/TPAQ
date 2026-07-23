<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;

class EraportController extends Controller
{
    public function index()
    {
        $santris = Santri::with('kelas')->where('status', 'aktif')->orderBy('nama', 'asc')->get();
        $kepalaTPA = \App\Models\Pengurus::where('is_kepala', 1)->first();
        return view('admin.eraport', compact('santris', 'kepalaTPA'));
    }

    public function getAbsensi(Request $request)
    {
        $id_santri = $request->id_santri;
        $caturwulan = $request->caturwulan;
        $tahun_pelajaran = $request->tahun_pelajaran;

        if (!$id_santri || !$caturwulan || !$tahun_pelajaran) {
            return response()->json(['sakit' => 0, 'izin' => 0, 'alfa' => 0]);
        }

        $years = explode('/', $tahun_pelajaran);
        if (count($years) != 2) {
            return response()->json(['sakit' => 0, 'izin' => 0, 'alfa' => 0]);
        }

        $startYear = (int)$years[0];
        $endYear = (int)$years[1];

        if ($caturwulan == '1') {
            $startDate = $startYear . '-07-01';
            $endDate = $startYear . '-10-31';
        } elseif ($caturwulan == '2') {
            $startDate = $startYear . '-11-01';
            $endDate = date('Y-m-t', strtotime($endYear . '-02-01'));
        } else {
            $startDate = $endYear . '-03-01';
            $endDate = $endYear . '-06-30';
        }

        $sakit = \App\Models\Absensi::where('id_santri', $id_santri)
                    ->whereBetween('tanggal', [$startDate, $endDate])
                    ->where('status', 'sakit')->count();

        $izin = \App\Models\Absensi::where('id_santri', $id_santri)
                    ->whereBetween('tanggal', [$startDate, $endDate])
                    ->where('status', 'izin')->count();

        $alfa = \App\Models\Absensi::where('id_santri', $id_santri)
                    ->whereBetween('tanggal', [$startDate, $endDate])
                    ->where('status', 'alfa')->count();

        return response()->json([
            'sakit' => $sakit,
            'izin' => $izin,
            'alfa' => $alfa
        ]);
    }

    public function riwayat()
    {
        $eraports = \App\Models\Eraport::with('santri')->latest()->get();
        return view('admin.eraport_riwayat', compact('eraports'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_santri' => 'required|exists:santris,id_santri',
            'kelompok' => 'required|string',
            'tahun_pelajaran' => 'required|string',
        ]);

        $data = $request->all();
        $data['absen_sakit'] = $data['absen_sakit'] ?: 0;
        $data['absen_izin'] = $data['absen_izin'] ?: 0;
        $data['absen_alpa'] = $data['absen_alpa'] ?: 0;

        $eraport = \App\Models\Eraport::create($data);

        return redirect()->back()->with('success', 'E-Raport berhasil disimpan!')->with('last_id_eraport', $eraport->id_eraport);
    }

    public function cetakPdf($id)
    {
        $eraport = \App\Models\Eraport::with('santri')->findOrFail($id);
        
        $user = \Illuminate\Support\Facades\Auth::user();
        $nama_guru = $user ? ($user->pengajar ? $user->pengajar->nama : $user->name) : '( .................................... )';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.eraport_pdf', compact('eraport', 'nama_guru'));
        $namaSantri = $eraport->santri ? $eraport->santri->nama : 'Unknown';
        return $pdf->download('E-Raport_'.$namaSantri.'.pdf');
    }
    public function previewPdf($id)
    {
        $eraport = \App\Models\Eraport::with('santri')->findOrFail($id);
        
        $user = \Illuminate\Support\Facades\Auth::user();
        $nama_guru = $user ? ($user->pengajar ? $user->pengajar->nama : $user->name) : '( .................................... )';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.eraport_pdf', compact('eraport', 'nama_guru'));
        return $pdf->stream('Preview_E-Raport.pdf');
    }

    public function destroy($id)
    {
        $eraport = \App\Models\Eraport::findOrFail($id);
        $eraport->delete();
        return redirect()->back()->with('success', 'Riwayat E-Rapor berhasil dihapus!');
    }
}
