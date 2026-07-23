<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pengajar;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('pengajar')->get();
        $pengajars = Pengajar::all();
        
        return view('admin.kelas.index', compact('kelas', 'pengajars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'id_pengajar' => 'required|exists:pengajars,id_pengajar',
            'tahun_ajaran' => 'nullable|string|max:50',
        ]);

        Kelas::create($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Data Kelas berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'id_pengajar' => 'required|exists:pengajars,id_pengajar',
            'tahun_ajaran' => 'nullable|string|max:50',
        ]);

        $kelas = Kelas::findOrFail($id);
        $kelas->update($request->all());

        return redirect()->route('admin.kelas.index')->with('success', 'Data Kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kelas = Kelas::findOrFail($id);
        
        // Optional: Check if there are students in this class before deleting
        if ($kelas->santris()->count() > 0) {
            return redirect()->route('admin.kelas.index')->with('error', 'Gagal menghapus! Masih ada santri di kelas ini.');
        }

        $kelas->delete();

        return redirect()->route('admin.kelas.index')->with('success', 'Data Kelas berhasil dihapus.');
    }
}
