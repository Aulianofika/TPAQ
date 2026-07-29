<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GaleriController extends Controller
{
    public function index()
    {
        $galeris = Galeri::latest()->get();
        return view('admin.galeri', compact('galeris'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:pembelajaran,kegiatan,wisuda,prestasi',
            'deskripsi' => 'nullable|string',
            'foto' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('galeri', 'public');
            $validated['foto'] = $path;
        }

        Galeri::create($validated);

        return redirect()->back()->with('success', 'Foto berhasil ditambahkan ke Galeri!');
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|in:pembelajaran,kegiatan,wisuda,prestasi',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $galeri = Galeri::findOrFail($id);

        if ($request->hasFile('foto')) {
            if ($galeri->foto) {
                Storage::disk('public')->delete($galeri->foto);
            }
            $path = $request->file('foto')->store('galeri', 'public');
            $validated['foto'] = $path;
        }

        $galeri->update($validated);

        return redirect()->back()->with('success', 'Data galeri berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $galeri = Galeri::findOrFail($id);

        if ($galeri->foto) {
            Storage::disk('public')->delete($galeri->foto);
        }

        $galeri->delete();

        return redirect()->back()->with('success', 'Foto berhasil dihapus dari Galeri!');
    }
}
