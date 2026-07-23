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

        // Metrik Ringkasan Keuangan
        // 1. Total Terkumpul (Bulan Ini)
        $total_terkumpul = Pembayaran::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('status', 'lunas')
            ->sum('jumlah');

        // 2. Santri Lunas
        $lunas_count = Pembayaran::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('status', 'lunas')
            ->count();
            
        $total_santri = Santri::where('status', 'aktif')->count();

        // 3. Tunggakan (Dihitung akumulasi dari Januari 2026 sampai bulan yang dipilih)
        $startYear = 2026;
        $startMonth = 1; // Januari
        
        $selectedMonthIndex = array_search($bulan, $bulan_array) + 1;
        $selectedYear = (int)$tahun;
        
        $total_months = (($selectedYear - $startYear) * 12) + ($selectedMonthIndex - $startMonth) + 1;
        if ($total_months < 0) {
            $total_months = 0;
        }

        // Ambil semua pembayaran lunas
        $all_lunas_payments = Pembayaran::where('status', 'lunas')->get();
        $lunas_accumulated = 0;
        $tunggakan_amount = 0; // Tidak lagi dipakai secara tunggal karena kita akumulasi
        
        foreach ($all_lunas_payments as $payment) {
            $pMonth = array_search($payment->bulan, $bulan_array) + 1;
            $pYear = (int)$payment->tahun;
            
            if ($pYear >= 2026 && ($pYear < $selectedYear || ($pYear == $selectedYear && $pMonth <= $selectedMonthIndex))) {
                $lunas_accumulated++;
            }
        }

        // Jumlah "bulan santri" yang menunggak
        $santri_tunggakan_count = max(0, ($total_santri * $total_months) - $lunas_accumulated);
        
        // (Opsional) Jika sistem men-generate record 'belum' lunas secara otomatis tiap bulan, 
        // kita bisa query dari tabel Pembayaran. Namun jika tidak, $total_santri - $lunas_count adalah cara teraman.
        
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
            'bulan', 'tahun', 'status',
            'total_terkumpul', 'lunas_count', 'total_santri', 
            'tunggakan_amount', 'santri_tunggakan_count',
            'santris', 'all_months', 'years', 'all_santris', 'classes'
        ));
    }



    public function store(Request $request)
    {
        $request->validate([
            'id_santri' => 'required|exists:santris,id_santri',
            'bulan' => 'required|string',
            'tahun' => 'required|integer',
            'jumlah' => 'required|integer',
            'status' => 'required|in:lunas,belum',
            'tanggal_bayar' => 'nullable|date',
        ]);

        Pembayaran::create($request->all());

        return redirect()->back()->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function update(Request $request, $id)
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

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return redirect()->back()->with('success', 'Data pembayaran berhasil dihapus.');
    }
}
