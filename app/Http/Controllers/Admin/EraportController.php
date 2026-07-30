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

    public function riwayat(Request $request)
    {
        $classes = \App\Models\Kelas::all();
        $selected_class_id = $request->input('id_kelas', 'semua');

        $query = \App\Models\Eraport::with('santri.kelas')->latest();

        if ($selected_class_id && $selected_class_id !== 'semua') {
            $query->whereHas('santri', function ($q) use ($selected_class_id) {
                $q->where('id_kelas', $selected_class_id);
            });
        }

        $eraports = $query->get();

        return view('admin.eraport_riwayat', compact('eraports', 'classes', 'selected_class_id'));
    }

    public function store(Request $request)
    {
        $messages = [
            'id_santri.required' => 'Nama santri wajib dipilih.',
            'id_santri.exists' => 'Santri yang dipilih tidak valid.',
            'tahun_pelajaran.required' => 'Tahun pelajaran wajib diisi.',
            'caturwulan.required' => 'Caturwulan wajib dipilih.',
            'kelompok.required' => 'Kelompok kelas wajib diisi.',
            'nilai_tajwid.required' => 'Nilai Tajwid wajib diisi.',
            'nilai_fashahah.required' => 'Nilai Fashahah wajib diisi.',
            'nilai_irama.required' => 'Nilai Irama/Lagu wajib diisi.',
            'nilai_adab.required' => 'Nilai Adab wajib diisi.',
            'nilai_ibadah.required' => 'Nilai Praktek Ibadah wajib diisi.',
            'nilai_doa.required' => 'Nilai Hafalan Doa Harian wajib diisi.',
            'nilai_surat.required' => 'Nilai Hafalan Surat Pendek wajib diisi.',
            'nilai_sejarah.required' => 'Nilai Sejarah Islam wajib diisi.',
            'nilai_dakwah.required' => 'Nilai Dakwah wajib diisi.',
            'nilai_akhlak.required' => 'Nilai Akhlak wajib diisi.',
            'ekstra_subuh.required' => 'Nilai Ekstra Sholat Subuh wajib diisi.',
            'ekstra_rebana.required' => 'Nilai Ekstra Rebana wajib diisi.',
            'ekstra_olahraga.required' => 'Nilai Ekstra Olahraga wajib diisi.',
            'sikap_disiplin.required' => 'Nilai Sikap Disiplin wajib diisi.',
            'sikap_kebersihan.required' => 'Nilai Sikap Kebersihan wajib diisi.',
        ];

        $validated = $request->validate([
            'id_santri' => 'required|exists:santris,id_santri',
            'caturwulan' => 'required|in:1,2,3',
            'kelompok' => 'required|string|max:255',
            'tahun_pelajaran' => 'required|string|max:20',
            'nilai_tajwid' => 'required|string|max:5',
            'nilai_fashahah' => 'required|string|max:5',
            'nilai_irama' => 'required|string|max:5',
            'nilai_adab' => 'required|string|max:5',
            'nilai_ibadah' => 'required|string|max:5',
            'nilai_doa' => 'required|string|max:5',
            'nilai_surat' => 'required|string|max:5',
            'nilai_sejarah' => 'required|string|max:5',
            'nilai_dakwah' => 'required|string|max:5',
            'nilai_akhlak' => 'required|string|max:5',
            'ekstra_subuh' => 'required|string|max:5',
            'ekstra_rebana' => 'required|string|max:5',
            'ekstra_olahraga' => 'required|string|max:5',
            'sikap_disiplin' => 'required|string|max:5',
            'sikap_kebersihan' => 'required|string|max:5',
            'absen_sakit' => 'nullable|integer|min:0',
            'absen_izin' => 'nullable|integer|min:0',
            'absen_alpa' => 'nullable|integer|min:0',
            'jumlah_nilai' => 'nullable|numeric|min:0',
            'rata_rata' => 'nullable|numeric|min:0',
            'kepala_tpa' => 'nullable|string|max:255',
            'nama_pengajar' => 'nullable|string|max:255',
            'tanggal_pelaporan' => 'nullable|date',
            'catatan_guru' => 'nullable|string',
            'status_kenaikan' => 'nullable|string|max:50',
        ], $messages);

        $validated['absen_sakit'] = $validated['absen_sakit'] ?? 0;
        $validated['absen_izin'] = $validated['absen_izin'] ?? 0;
        $validated['absen_alpa'] = $validated['absen_alpa'] ?? 0;

        $eraport = \App\Models\Eraport::create($validated);

        return redirect()->back()->with('success', 'E-Raport berhasil disimpan!')->with('last_id_eraport', $eraport->id_eraport);
    }

    public function cetakPdf(string $id)
    {
        $eraport = \App\Models\Eraport::with('santri')->findOrFail($id);
        
        $user = \Illuminate\Support\Facades\Auth::user();
        $nama_guru = $user ? ($user->pengajar ? $user->pengajar->nama : $user->name) : '( .................................... )';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.eraport_pdf', compact('eraport', 'nama_guru'));
        $namaSantri = $eraport->santri ? $eraport->santri->nama : 'Unknown';
        return $pdf->download('E-Raport_'.$namaSantri.'.pdf');
    }
    public function previewPdf(string $id)
    {
        $eraport = \App\Models\Eraport::with('santri')->findOrFail($id);
        
        $user = \Illuminate\Support\Facades\Auth::user();
        $nama_guru = $user ? ($user->pengajar ? $user->pengajar->nama : $user->name) : '( .................................... )';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.eraport_pdf', compact('eraport', 'nama_guru'));
        return $pdf->stream('Preview_E-Raport.pdf');
    }

    public function destroy(string $id)
    {
        $eraport = \App\Models\Eraport::findOrFail($id);
        $eraport->delete();
        return redirect()->back()->with('success', 'E-Rapor berhasil dihapus!');
    }
}
