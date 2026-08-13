<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
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
            'bukti_pembayaran' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:2048',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'bukti_pembayaran.file' => 'Bukti pembayaran harus berupa file.',
            'bukti_pembayaran.mimes' => 'Format bukti pembayaran harus jpeg, png, jpg, webp, atau pdf.',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 2MB.',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            $validated['bukti_pembayaran'] = $path;
        }

        $user = Auth::user();
        $roleStr = $user && isset($user->role) ? ' (' . ucfirst($user->role) . ')' : '';
        $validated['dicatat_oleh'] = $user ? $user->name . $roleStr : 'Sistem';

        Pembayaran::create($validated);

        return redirect()->back()->with('success', 'Pembayaran berhasil dicatat.');
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'jumlah' => 'required|integer',
            'status' => 'required|in:lunas,belum',
            'tanggal_bayar' => 'nullable|date',
            'bukti_pembayaran' => 'nullable|file|mimes:jpeg,png,jpg,webp,pdf|max:2048',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'bukti_pembayaran.file' => 'Bukti pembayaran harus berupa file.',
            'bukti_pembayaran.mimes' => 'Format bukti pembayaran harus jpeg, png, jpg, webp, atau pdf.',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 2MB.',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);

        if ($request->hasFile('bukti_pembayaran')) {
            if ($pembayaran->bukti_pembayaran) {
                Storage::disk('public')->delete($pembayaran->bukti_pembayaran);
            }
            $path = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
            $validated['bukti_pembayaran'] = $path;
        }

        $user = Auth::user();
        $roleStr = $user && isset($user->role) ? ' (' . ucfirst($user->role) . ')' : '';
        $validated['dicatat_oleh'] = $user ? $user->name . $roleStr : 'Sistem';

        $pembayaran->update($validated);

        return redirect()->back()->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        if ($pembayaran->bukti_pembayaran) {
            Storage::disk('public')->delete($pembayaran->bukti_pembayaran);
        }
        $pembayaran->delete();

        return redirect()->back()->with('success', 'Data pembayaran berhasil dihapus.');
    }

    public function rekap(Request $request)
    {
        $all_months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tahun = $request->input('tahun', date('Y'));
        $id_kelas = $request->input('id_kelas', 'semua');
        $search = $request->input('search', '');

        // Query santri
        $query = Santri::where('status', 'aktif')->with(['kelas', 'pembayarans' => function($q) use ($tahun) {
            $q->where('tahun', $tahun);
        }]);

        if ($id_kelas !== 'semua') {
            $query->where('id_kelas', $id_kelas);
        }

        if (!empty($search)) {
            $query->where('nama', 'like', '%' . $search . '%');
        }

        $santris = $query->orderBy('nama', 'asc')->get();

        // Process matrix per santri
        foreach ($santris as $santri) {
            $monthly_map = [];
            $lunas_count = 0;
            $total_paid = 0;

            $pembayaransByBulan = $santri->pembayarans->keyBy('bulan');

            foreach ($all_months as $m) {
                $pem = $pembayaransByBulan->get($m);
                if ($pem && $pem->status === 'lunas') {
                    $monthly_map[$m] = [
                        'status' => 'lunas',
                        'jumlah' => $pem->jumlah,
                        'tanggal' => $pem->tanggal_bayar ? $pem->tanggal_bayar->format('d/m/Y') : '-',
                        'bukti' => $pem->bukti_pembayaran ? asset('storage/' . $pem->bukti_pembayaran) : null,
                        'pencatat' => $pem->dicatat_oleh ?? '-',
                        'keterangan' => $pem->keterangan ?? '-',
                    ];
                    $lunas_count++;
                    $total_paid += $pem->jumlah;
                } else {
                    $monthly_map[$m] = [
                        'status' => $pem ? $pem->status : 'belum',
                        'jumlah' => $pem ? $pem->jumlah : 0,
                        'tanggal' => null,
                        'bukti' => null,
                        'pencatat' => null,
                        'keterangan' => null,
                    ];
                }
            }

            $santri->monthly_map = $monthly_map;
            $santri->lunas_count = $lunas_count;
            $santri->total_paid = $total_paid;
            $santri->tunggakan_count = 12 - $lunas_count;
        }

        // Available years
        $years_in_db = Pembayaran::select('tahun')->distinct()->pluck('tahun')->toArray();
        $years = array_unique(array_merge([date('Y')], $years_in_db));
        rsort($years);

        $classes = \App\Models\Kelas::all();

        // Summary Metrics
        $total_santri = $santris->count();
        $total_terkumpul_tahun = Pembayaran::where('tahun', $tahun)->where('status', 'lunas')->sum('jumlah');
        $target_setahun = $total_santri * 12 * 15000;
        $lunas_full_count = $santris->filter(fn($s) => $s->lunas_count >= 12)->count();
        $persentase_pelunasan = $target_setahun > 0 ? round(($total_terkumpul_tahun / $target_setahun) * 100) : 0;

        return view('admin.iuran_rekap', compact(
            'santris', 'all_months', 'tahun', 'id_kelas', 'search',
            'years', 'classes', 'total_santri', 'total_terkumpul_tahun',
            'target_setahun', 'lunas_full_count', 'persentase_pelunasan'
        ));
    }

    public function cetakPdfRekap(Request $request)
    {
        $all_months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tahun = $request->input('tahun', date('Y'));
        $id_kelas = $request->input('id_kelas', 'semua');

        $kelas = $id_kelas === 'semua' ? null : \App\Models\Kelas::find($id_kelas);

        $query = Santri::where('status', 'aktif')->with(['kelas', 'pembayarans' => function($q) use ($tahun) {
            $q->where('tahun', $tahun);
        }]);

        if ($id_kelas !== 'semua') {
            $query->where('id_kelas', $id_kelas);
        }

        $santris = $query->orderBy('nama', 'asc')->get();

        foreach ($santris as $santri) {
            $monthly_map = [];
            $lunas_count = 0;
            $total_paid = 0;
            $pembayaransByBulan = $santri->pembayarans->keyBy('bulan');

            foreach ($all_months as $m) {
                $pem = $pembayaransByBulan->get($m);
                if ($pem && $pem->status === 'lunas') {
                    $monthly_map[$m] = 'LUNAS';
                    $lunas_count++;
                    $total_paid += $pem->jumlah;
                } else {
                    $monthly_map[$m] = '-';
                }
            }

            $santri->monthly_map = $monthly_map;
            $santri->lunas_count = $lunas_count;
            $santri->total_paid = $total_paid;
        }

        $user = Auth::user();
        $nama_pengurus = $user ? $user->name : 'Bendahara TPA';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.iuran_rekap_pdf', compact(
            'santris', 'all_months', 'tahun', 'kelas', 'nama_pengurus'
        ))->setPaper('a4', 'landscape');

        $kelasName = $kelas ? $kelas->nama_kelas : 'Semua_Kelas';
        return $pdf->download('Rekap_Iuran_'.$kelasName.'_'.$tahun.'.pdf');
    }

    public function previewPdfRekap(Request $request)
    {
        $all_months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tahun = $request->input('tahun', date('Y'));
        $id_kelas = $request->input('id_kelas', 'semua');

        $kelas = $id_kelas === 'semua' ? null : \App\Models\Kelas::find($id_kelas);

        $query = Santri::where('status', 'aktif')->with(['kelas', 'pembayarans' => function($q) use ($tahun) {
            $q->where('tahun', $tahun);
        }]);

        if ($id_kelas !== 'semua') {
            $query->where('id_kelas', $id_kelas);
        }

        $santris = $query->orderBy('nama', 'asc')->get();

        foreach ($santris as $santri) {
            $monthly_map = [];
            $lunas_count = 0;
            $total_paid = 0;
            $pembayaransByBulan = $santri->pembayarans->keyBy('bulan');

            foreach ($all_months as $m) {
                $pem = $pembayaransByBulan->get($m);
                if ($pem && $pem->status === 'lunas') {
                    $monthly_map[$m] = 'LUNAS';
                    $lunas_count++;
                    $total_paid += $pem->jumlah;
                } else {
                    $monthly_map[$m] = '-';
                }
            }

            $santri->monthly_map = $monthly_map;
            $santri->lunas_count = $lunas_count;
            $santri->total_paid = $total_paid;
        }

        $user = Auth::user();
        $nama_pengurus = $user ? $user->name : 'Bendahara TPA';

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.iuran_rekap_pdf', compact(
            'santris', 'all_months', 'tahun', 'kelas', 'nama_pengurus'
        ))->setPaper('a4', 'landscape');

        return $pdf->stream('Preview_Rekap_Iuran.pdf');
    }
}
