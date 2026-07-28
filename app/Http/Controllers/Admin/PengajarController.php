<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengajar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengajarController extends Controller
{
    public function index(Request $request)
    {
        // Stats
        $total_pengajar = Pengajar::count();
        $ustadz_count = Pengajar::where('jenis_kelamin', 'L')->count();
        $ustadzah_count = Pengajar::where('jenis_kelamin', 'P')->count();

        // Query
        $query = Pengajar::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('alamat', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->input('jenis_kelamin'));
        }

        $pengajars = $query->orderBy('nama', 'asc')->paginate(10)->withQueryString();

        return view('admin.pengajar.index', compact(
            'pengajars',
            'total_pengajar',
            'ustadz_count',
            'ustadzah_count'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);
        
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('pengajars', 'public');
            $validated['foto'] = $path;
        }

        $pengajar = Pengajar::create($validated);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $pengajar = Pengajar::findOrFail($id);

        if ($request->hasFile('foto')) {
            if ($pengajar->foto) {
                Storage::disk('public')->delete($pengajar->foto);
            }
            $path = $request->file('foto')->store('pengajars', 'public');
            $validated['foto'] = $path;
        }

        $pengajar->update($validated);

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $pengajar = Pengajar::findOrFail($id);

        if ($pengajar->foto) {
            Storage::disk('public')->delete($pengajar->foto);
        }

        // Jika memiliki user account, hapus juga (opsional, tergantung policy)
        // Di sini kita hapus juga akun loginnya
        if ($pengajar->id_user) {
            $pengajar->user()->delete();
        }

        $pengajar->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function createAccount(Request $request, $id)
    {
        $pengajar = Pengajar::findOrFail($id);

        $rules = [
            'email' => 'required|email|unique:users,email' . ($pengajar->id_user ? ',' . $pengajar->id_user : ''),
            'role' => 'required|in:admin,guru',
        ];

        if (!$pengajar->id_user || $request->filled('password')) {
            $rules['password'] = 'required|min:8|confirmed';
        }

        $request->validate($rules);

        if ($pengajar->id_user && $pengajar->user) {
            $user = $pengajar->user;
            $user->email = $request->email;
            $user->role = $request->role;
            if ($request->filled('password')) {
                $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            }
            $user->save();
        } else {
            $user = \App\Models\User::create([
                'name' => $pengajar->nama,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'role' => $request->role,
            ]);
        }

        if ($request->role === 'admin') {
            \App\Models\Pengurus::create([
                'nama' => $pengajar->nama,
                'jenis_kelamin' => $pengajar->jenis_kelamin,
                'no_hp' => $pengajar->no_hp,
                'alamat' => $pengajar->alamat,
                'foto' => $pengajar->foto,
                'id_user' => $user->id,
                'is_kepala' => false,
            ]);
            $pengajar->delete();
            $message = 'Akun dipindahkan ke Halaman Pengurus karena role diatur sebagai Admin!';
        } else {
            $pengajar->update(['id_user' => $user->id]);
            $message = 'Akun berhasil disimpan!';
        }

        return redirect()->back()->with('success', $message);
    }
}
