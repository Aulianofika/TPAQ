<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Santri;
use App\Models\TargetHafalan;
use App\Models\ProgresHafalan;
use App\Models\RiwayatHafalan;
use Carbon\Carbon;

class HafalanController extends Controller
{
    public function index(Request $request)
    {
        $classes = Kelas::all();
        
        $currentMonth = (int) date('n');
        $currentYear = (int) date('Y');
        
        // Penentuan Tahun Pelajaran (Juli - Juni)
        if ($currentMonth >= 7) {
            $defaultTahun = $currentYear . '/' . ($currentYear + 1);
        } else {
            $defaultTahun = ($currentYear - 1) . '/' . $currentYear;
        }

        // Penentuan Caturwulan
        if ($currentMonth >= 7 && $currentMonth <= 10) {
            $defaultCw = '1';
        } elseif ($currentMonth >= 11 || $currentMonth <= 2) {
            $defaultCw = '2';
        } else {
            $defaultCw = '3';
        }

        $caturwulan = $request->input('caturwulan', $defaultCw);
        $id_kelas = $request->input('id_kelas', $classes->first()->id_kelas ?? null);
        $tahun_pelajaran = $request->input('tahun_pelajaran', $defaultTahun);

        $target = null;
        $santris = collect();
        $progres = collect();

        if ($id_kelas) {
            $target = TargetHafalan::where('id_kelas', $id_kelas)
                ->where('caturwulan', $caturwulan)
                ->where('tahun_pelajaran', $tahun_pelajaran)
                ->first();

            $santris = Santri::where('id_kelas', $id_kelas)
                ->where('status', 'aktif')
                ->orderBy('nama', 'asc')
                ->get();

            $progres = ProgresHafalan::whereIn('id_santri', $santris->pluck('id_santri'))
                ->where('caturwulan', $caturwulan)
                ->where('tahun_pelajaran', $tahun_pelajaran)
                ->get()
                ->keyBy('id_santri');
        }

        return view('admin.hafalan', compact(
            'classes', 'caturwulan', 'id_kelas', 'tahun_pelajaran', 'target', 'santris', 'progres'
        ));
    }

    public function storeTarget(Request $request)
    {
        $request->validate([
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'caturwulan' => 'required|in:1,2,3',
            'tahun_pelajaran' => 'required|string',
            'target' => 'required|string'
        ]);

        TargetHafalan::updateOrCreate(
            [
                'id_kelas' => $request->id_kelas,
                'caturwulan' => $request->caturwulan,
                'tahun_pelajaran' => $request->tahun_pelajaran
            ],
            [
                'target' => $request->target
            ]
        );

        return redirect()->back()->with('success', 'Target hafalan berhasil disimpan!');
    }

    public function storeProgress(Request $request)
    {
        $request->validate([
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'caturwulan' => 'required|in:1,2,3',
            'tahun_pelajaran' => 'required|string',
            'progress' => 'array'
        ]);

        $caturwulan = $request->caturwulan;
        $tahun_pelajaran = $request->tahun_pelajaran;
        $progressData = $request->input('progress', []);

        foreach ($progressData as $id_santri => $data) {
            ProgresHafalan::updateOrCreate(
                [
                    'id_santri' => $id_santri,
                    'caturwulan' => $caturwulan,
                    'tahun_pelajaran' => $tahun_pelajaran
                ],
                [
                    'capaian' => $data['capaian'] ?? '',
                    'status' => $data['status'] ?? 'belum',
                    'keterangan' => $data['keterangan'] ?? ''
                ]
            );

            // Create log in riwayat_hafalans
            if (!empty($data['capaian']) || !empty($data['status'])) {
                RiwayatHafalan::create([
                    'id_santri' => $id_santri,
                    'caturwulan' => $caturwulan,
                    'tahun_pelajaran' => $tahun_pelajaran,
                    'capaian' => $data['capaian'] ?? '',
                    'status' => $data['status'] ?? 'belum',
                    'keterangan' => $data['keterangan'] ?? ''
                ]);
            }
        }

        return redirect()->back()->with('success', 'Progres hafalan santri berhasil diperbarui!');
    }

    public function getRiwayat($id_santri, Request $request)
    {
        $caturwulan = $request->query('caturwulan');
        $tahun_pelajaran = $request->query('tahun_pelajaran');

        $query = RiwayatHafalan::where('id_santri', $id_santri)
            ->orderBy('created_at', 'desc');

        if ($caturwulan) {
            $query->where('caturwulan', $caturwulan);
        }
        if ($tahun_pelajaran) {
            $query->where('tahun_pelajaran', $tahun_pelajaran);
        }

        $riwayat = $query->get();

        return response()->json($riwayat);
    }
}
