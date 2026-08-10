<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Pembayaran;

class IuranController extends Controller
{
    public function index(Request $request)
    {
        // Parameter filter (default bulan ini)
        $bulan_array = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $current_month_index = (int)date('n') - 1;
        $default_bulan = $bulan_array[$current_month_index];
        $default_tahun = date('Y');

        $bulan = $request->input('bulan', $default_bulan);
        $tahun = $request->input('tahun', $default_tahun);
        $status = $request->input('status', 'semua');
        $id_kelas = $request->input('id_kelas', 'semua');

        // Query Dasar Santri Aktif
        $santri_query = Santri::where('status', 'aktif');
        if ($id_kelas !== 'semua') {
            $santri_query->where('id_kelas', $id_kelas);
        }
        $total_santri = (clone $santri_query)->count();

        // Metrik Ringkasan Keuangan
        // 1. Total Terkumpul (Bulan Ini)
        $terkumpul_query = Pembayaran::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('status', 'lunas');
        if ($id_kelas !== 'semua') {
            $terkumpul_query->whereHas('santri', function($q) use ($id_kelas) {
                $q->where('id_kelas', $id_kelas)->where('status', 'aktif');
            });
        }
        $total_terkumpul = $terkumpul_query->sum('jumlah');

        // 2. Santri Lunas
        $lunas_query = Pembayaran::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('status', 'lunas');
        if ($id_kelas !== 'semua') {
            $lunas_query->whereHas('santri', function($q) use ($id_kelas) {
                $q->where('id_kelas', $id_kelas)->where('status', 'aktif');
            });
        }
        $lunas_count = $lunas_query->count();

        // 3. Tunggakan (Untuk bulan yang dipilih)
        $santri_tunggakan_count = max(0, $total_santri - $lunas_count);
        $tunggakan_amount = 0;
        
        // Ambil Data Santri beserta relasi Pembayaran untuk bulan ini
        $query = Santri::with(['pembayarans' => function($q) use ($bulan, $tahun) {
            $q->where('bulan', $bulan)->where('tahun', $tahun);
        }, 'kelas'])
        ->where('santris.status', 'aktif')
        ->select('santris.*')
        ->leftJoin('pembayarans', function($join) use ($bulan, $tahun) {
            $join->on('santris.id_santri', '=', 'pembayarans.id_santri')
                 ->where('pembayarans.bulan', '=', $bulan)
                 ->where('pembayarans.tahun', '=', $tahun);
        })
        ->orderByRaw('COALESCE(pembayarans.updated_at, pembayarans.created_at) DESC')
        ->orderBy('santris.nama', 'asc');

        if ($id_kelas !== 'semua') {
            $query->where('santris.id_kelas', $id_kelas);
        }

        if ($status == 'lunas') {
            $query->whereHas('pembayarans', function($q) use ($bulan, $tahun) {
                $q->where('bulan', $bulan)->where('tahun', $tahun)->where('status', 'lunas');
            });
        } elseif ($status == 'tunggakan') {
            // Yang punya record 'belum' ATAU tidak punya record sama sekali di bulan tersebut
            $query->where(function($q) use ($bulan, $tahun) {
                $q->whereHas('pembayarans', function($subq) use ($bulan, $tahun) {
                    $subq->where('bulan', $bulan)->where('tahun', $tahun)->where('status', 'belum');
                })->orWhereDoesntHave('pembayarans', function($subq) use ($bulan, $tahun) {
                    $subq->where('bulan', $bulan)->where('tahun', $tahun);
                });
            });
        }

        $santris = $query->get();
        
        // Simpan daftar bulan statis
        $all_months = $bulan_array;

        // Ambil daftar tahun dari tabel pembayaran, ditambah tahun ini agar selalu ada
        $years_in_db = Pembayaran::select('tahun')->distinct()->pluck('tahun')->toArray();
        $years = array_unique(array_merge([date('Y')], $years_in_db));
        rsort($years);

        $all_santris = Santri::where('status', 'aktif')->orderBy('nama', 'asc')->get();
        $classes = \App\Models\Kelas::all();

        return view('admin.iuran', compact(
            'bulan', 'tahun', 'status', 'id_kelas',
            'total_terkumpul', 'lunas_count', 'total_santri', 
            'tunggakan_amount', 'santri_tunggakan_count',
            'santris', 'all_months', 'years', 'all_santris', 'classes'
        ));
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_santri' => 'required|exists:santris,id_santri',
            'bulan' => 'required|string|in:Januari,Februari,Maret,April,Mei,Juni,Juli,Agustus,September,Oktober,November,Desember',
            'tahun' => 'required|integer|min:2020|max:2099',
            'jumlah' => 'required|integer|min:0',
            'status' => 'required|in:lunas,belum',
            'tanggal_bayar' => 'nullable|date',
        ]);

        Pembayaran::create($validated);

        return redirect()->back()->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'jumlah' => 'required|integer',
            'status' => 'required|in:lunas,belum',
            'tanggal_bayar' => 'nullable|date',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update($request->only(['jumlah', 'status', 'tanggal_bayar']));

        return redirect()->back()->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return redirect()->back()->with('success', 'Data pembayaran berhasil dihapus.');
    }
}
