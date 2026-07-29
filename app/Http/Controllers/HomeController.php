<?php

namespace App\Http\Controllers;



use App\Models\Pengumuman;
use App\Models\Galeri;
use App\Models\Pengajar;

class HomeController extends Controller
{
    public function index()
    {
        $pengumuman_terbaru = Pengumuman::orderBy('tanggal', 'desc')->take(3)->get();
        $galeri_terbaru = Galeri::latest()->take(6)->get();
        return view('home', compact('pengumuman_terbaru', 'galeri_terbaru'));
    }

    public function profil()
    {
        return view('profile');
    }

    public function pengurus()
    {
        $pengajars = Pengajar::orderBy('nama', 'asc')->get();
        $pengurusList = \App\Models\Pengurus::orderBy('nama', 'asc')->get();
        return view('pengurus', compact('pengajars', 'pengurusList'));
    }

    public function galeri()
    {
        $galeris = Galeri::latest()->get();
        return view('galeri', compact('galeris'));
    }

    public function pengumuman()
    {
        $pengumuman = Pengumuman::orderBy('tanggal', 'desc')->get();
        return view('pengumuman', compact('pengumuman'));
    }

    public function pengumumanDetail(string $id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        return view('pengumuman_detail', compact('pengumuman'));
    }
}
