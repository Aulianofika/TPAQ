<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index()
    {
        $pengumuman = Pengumuman::latest('tanggal')->get();
        return view('admin.pengumuman', compact('pengumuman'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:penting,kegiatan,informasi',
            'isi' => 'required|string',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'judul.required' => 'Judul pengumuman wajib diisi.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'kategori.in' => 'Kategori yang dipilih tidak valid.',
            'isi.required' => 'Isi pengumuman wajib diisi.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus berupa jpeg, png, jpg, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal adalah 2MB (2048 KB).',
        ]);

        if ($request->hasFile('gambar')) {
            $path = $request->file('gambar')->store('pengumuman', 'public');
            $validated['gambar'] = $path;
        }

        Pengumuman::create($validated);

        return redirect()->back()->with('success', 'Pengumuman berhasil ditambahkan!');
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:penting,kegiatan,informasi',
            'isi' => 'required|string',
            'tanggal' => 'required|date',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'judul.required' => 'Judul pengumuman wajib diisi.',
            'judul.max' => 'Judul maksimal 255 karakter.',
            'kategori.required' => 'Kategori wajib dipilih.',
            'kategori.in' => 'Kategori yang dipilih tidak valid.',
            'isi.required' => 'Isi pengumuman wajib diisi.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'gambar.image' => 'File yang diunggah harus berupa gambar.',
            'gambar.mimes' => 'Format gambar harus berupa jpeg, png, jpg, atau webp.',
            'gambar.max' => 'Ukuran gambar maksimal adalah 2MB (2048 KB).',
        ]);

        $pengumuman = Pengumuman::findOrFail($id);

        if ($request->hasFile('gambar')) {
            if ($pengumuman->gambar) {
                Storage::disk('public')->delete($pengumuman->gambar);
            }
            $path = $request->file('gambar')->store('pengumuman', 'public');
            $validated['gambar'] = $path;
        }

        $pengumuman->update($validated);

        return redirect()->back()->with('success', 'Pengumuman berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);

        if ($pengumuman->gambar) {
            Storage::disk('public')->delete($pengumuman->gambar);
        }

        $pengumuman->delete();

        return redirect()->back()->with('success', 'Pengumuman berhasil dihapus!');
    }
}
