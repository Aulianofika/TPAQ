<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengurus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PengurusController extends Controller
{
    public function index(Request $request)
    {
        // Stats
        $total_pengurus = Pengurus::count();
        $ustadz_count = Pengurus::where('jenis_kelamin', 'L')->count();
        $ustadzah_count = Pengurus::where('jenis_kelamin', 'P')->count();

        // Query
        $query = Pengurus::query();

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

        $pengurus = $query->orderBy('nama', 'asc')->paginate(10)->withQueryString();

        return view('admin.pengurus', compact(
            'pengurus',
            'total_pengurus',
            'ustadz_count',
            'ustadzah_count'
        ));
    }

    public function store(Request $request)
    {
        $messages = [
            'nama.required' => 'Nama wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
            'foto.image' => 'File yang diunggah harus berupa gambar.',
            'foto.mimes' => 'Format foto harus berupa jpeg, png, jpg, atau webp.',
            'foto.max' => 'Ukuran foto maksimal adalah 2MB (2048 KB).',
        ];

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'is_kepala' => 'nullable|boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], $messages);
        
        $validated['is_kepala'] = $request->has('is_kepala');

        if ($validated['is_kepala']) {
            Pengurus::query()->update(['is_kepala' => false]);
        }

        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('pengurus', 'public');
            $validated['foto'] = $path;
        }

        $pengurus = Pengurus::create($validated);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function update(Request $request, string $id)
    {
        $messages = [
            'nama.required' => 'Nama wajib diisi.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
            'foto.image' => 'File yang diunggah harus berupa gambar.',
            'foto.mimes' => 'Format foto harus berupa jpeg, png, jpg, atau webp.',
            'foto.max' => 'Ukuran foto maksimal adalah 2MB (2048 KB).',
        ];

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'is_kepala' => 'nullable|boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], $messages);

        $validated['is_kepala'] = $request->has('is_kepala');

        if ($validated['is_kepala']) {
            Pengurus::where('id_pengurus', '!=', $id)->update(['is_kepala' => false]);
        }

        $pengurus = Pengurus::findOrFail($id);

        if ($request->hasFile('foto')) {
            if ($pengurus->foto) {
                Storage::disk('public')->delete($pengurus->foto);
            }
            $path = $request->file('foto')->store('pengurus', 'public');
            $validated['foto'] = $path;
        }

        $pengurus->update($validated);

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $pengurus = Pengurus::findOrFail($id);

        // Mencegah user menghapus akunnya sendiri
        if ($pengurus->id_user && $pengurus->id_user == Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        if ($pengurus->foto) {
            Storage::disk('public')->delete($pengurus->foto);
        }

        $user = $pengurus->user;

        $pengurus->delete();

        // Hapus akun loginnya setelah data pengurus dihapus agar tidak error foreign key
        if ($user) {
            $user->delete();
        }

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }

    public function createAccount(Request $request, string $id)
    {
        $pengurus = Pengurus::findOrFail($id);

        $rules = [
            'email' => 'required|email|unique:users,email' . ($pengurus->id_user ? ',' . $pengurus->id_user : ''),
            'role' => 'required|in:admin,guru',
        ];

        if (!$pengurus->id_user || $request->filled('password')) {
            $rules['password'] = 'required|min:8|confirmed';
        }

        $messages = [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah terdaftar/digunakan.',
            'role.required' => 'Role (peran) wajib dipilih.',
            'role.in' => 'Pilihan role tidak valid.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min' => 'Kata sandi minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ];

        $request->validate($rules, $messages);

        if ($pengurus->id_user && $pengurus->user) {
            $user = $pengurus->user;
            $user->email = $request->email;
            $user->role = $request->role;
            if ($request->filled('password')) {
                $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
            }
            $user->save();
        } else {
            $user = \App\Models\User::create([
                'name' => $pengurus->nama,
                'email' => $request->email,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password),
                'role' => $request->role,
            ]);
        }

        if ($request->role === 'guru') {
            \App\Models\Pengajar::create([
                'nama' => $pengurus->nama,
                'jenis_kelamin' => $pengurus->jenis_kelamin,
                'no_hp' => $pengurus->no_hp,
                'alamat' => $pengurus->alamat,
                'foto' => $pengurus->foto,
                'id_user' => $user->id,
            ]);
            $pengurus->delete();
            $message = 'Akun dipindahkan ke Halaman Guru karena role diatur sebagai Guru!';
        } else {
            $pengurus->update(['id_user' => $user->id]);
            $message = 'Akun berhasil disimpan!';
        }

        return redirect()->back()->with('success', $message);
    }
}
