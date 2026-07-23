<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\Kelas;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        // 1. Calculate Bento Stats
        $total_santri = Santri::count();
        $aktif_count = Santri::where('status', 'aktif')->count();
        $ikhwan_count = Santri::where('jenis_kelamin', 'L')->count();
        $akhwat_count = Santri::where('jenis_kelamin', 'P')->count();

        // 2. Fetch Classes for dropdown filters/forms
        $classes = Kelas::all();

        // 3. Query students with search & filters
        $query = Santri::with('kelas');

        if ($request->filled('id_kelas')) {
            $query->where('id_kelas', $request->input('id_kelas'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Load all students for real-time JS filtering
        $students = $query->orderBy('nama', 'asc')->get();

        return view('admin.santri.index', compact(
            'students',
            'classes',
            'total_santri',
            'aktif_count',
            'ikhwan_count',
            'akhwat_count'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'nama_wali' => 'required|string|max:255',
            'no_hp_wali' => 'required|string|max:20',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'status' => 'required|in:aktif,mutasi,lulus,non-aktif',
        ]);

        Santri::create($validated);

        return redirect()->back()->with('success', 'Data santri berhasil ditambahkan!');
    }

    public function update(Request $request, Santri $santri)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tgl_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'nama_wali' => 'required|string|max:255',
            'no_hp_wali' => 'required|string|max:20',
            'id_kelas' => 'required|exists:kelas,id_kelas',
            'status' => 'required|in:aktif,mutasi,lulus,non-aktif',
        ]);

        $santri->update($validated);

        return redirect()->back()->with('success', 'Data santri berhasil diperbarui!');
    }

    public function destroy(Santri $santri)
    {
        $santri->delete();

        return redirect()->back()->with('success', 'Data santri berhasil dihapus!');
    }
}
