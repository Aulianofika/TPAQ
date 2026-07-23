@extends('layouts.admin')

@section('title', 'Progress Hafalan Santri')

@push('styles')
<style>
    /* =====================================================================
       PENGATURAN UMUM & IKON
       ===================================================================== */
    /* Mengatur gaya ikon material agar terisi atau garis luar saja */
    .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
    .fill-icon { font-variation-settings: 'FILL' 1; }

    /* Tombol default agar tidak memiliki background dan border bawaan browser */
    button { background: transparent; border: none; padding: 0; cursor: pointer; font-family: inherit; }

    /* =====================================================================
       LAYOUT UTAMA
       ===================================================================== */
    /* .content-canvas adalah pembungkus utama (wrapper) halaman */
    .content-canvas {
        display: flex;
        flex-direction: column;
        gap: 32px;
        padding: 32px;
        width: 100%;
        min-height: 100vh;
        background: #FCF9F2;
    }

    /* =====================================================================
       NOTIFIKASI (ALERT)
       ===================================================================== */
    .alert-success {
        background-color: #B0EFDA; /* Warna latar hijau pastel */
        color: #002019; /* Teks hijau gelap */
        padding: 16px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }

    /* =====================================================================
       HERO HEADER (Bagian Atas Warna Hijau Gelap)
       ===================================================================== */
    .hero-header {
        position: relative;
        background-color: #003227; /* Hijau utama */
        color: #FFFFFF;
        padding: 40px;
        border-radius: 24px;
        overflow: hidden; /* Agar efek pattern tidak keluar kotak */
    }

    /* Konten hero agar berada di atas pattern */
    .hero-content {
        position: relative;
        z-index: 2;
        max-width: 600px; /* Membatasi lebar teks agar rapi */
    }

    .hero-badge {
        background-color: #735C00;
        color: #FFE088;
        padding: 4px 16px;
        border-radius: 9999px; /* Bentuk pil/kapsul */
        font-family: 'Manrope', sans-serif;
        font-size: 10px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        display: inline-block;
        margin-bottom: 16px;
    }

    .hero-title {
        font-family: 'Epilogue', sans-serif;
        font-size: 28px;
        font-weight: 800;
        line-height: 1.2;
        margin: 0 0 10px 0;
    }

    .hero-subtitle {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 16px;
        color: #95D3BF;
        margin: 0;
        line-height: 1.6;
    }

    /* =====================================================================
       KARTU STATISTIK (STATS GRID)
       ===================================================================== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr); /* 4 kolom sama besar */
        gap: 24px;
        width: 100%;
    }

    @media (max-width: 1024px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .stats-grid { grid-template-columns: 1fr; }
    }

    /* Gaya dasar untuk setiap kartu statistik (menggunakan bentuk lengkung arch) */
    .arch-card {
        background-color: #F6F3EC;
        border-radius: 48px 48px 12px 12px; /* Melengkung di atas, kotak di bawah */
        padding: 32px;
        display: flex;
        flex-direction: column;
        transition: transform 0.2s ease, background-color 0.2s ease;
    }

    .arch-card:hover {
        background-color: #FFFFFF;
        transform: translateY(-4px); /* Efek melayang saat di-hover */
        box-shadow: 0 10px 20px rgba(0,0,0,0.05);
    }

    /* Kartu pertama (Target) memiliki gaya khusus yang lebih mencolok */
    .arch-card.target-card {
        background-color: #004B3C;
        border: 4px solid rgba(115, 92, 0, 0.3); /* Border sekunder */
        position: relative;
        overflow: hidden;
    }
    .arch-card.target-card:hover {
        background-color: #003227;
    }

    .stat-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 24px;
    }
    .stat-header-flex > div:first-child {
        flex: 1;
        padding-right: 16px;
    }

    .stat-label-small {
        font-family: 'Manrope', sans-serif;
        font-size: 12px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: #404945;
        margin: 0 0 4px 0;
    }
    .target-card .stat-label-small { color: #735C00; }

    /* Wadah ikon di dalam kartu (Kotak dengan sudut melengkung) */
    .stat-icon-box {
        padding: 12px;
        border-radius: 12px;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    .stat-icon-box.santri { background: #E5E2DB; color: #003227; }
    .stat-icon-box.selesai { background: #D1FAE5; color: #047857; }
    .stat-icon-box.mengulang { background: #FEE2E2; color: #EF4444; }

    /* Tombol edit target yang kecil di kartu pertama */
    .edit-target-btn {
        background: #003227;
        color: #FFE088;
        padding: 12px;
        border-radius: 12px;
        transition: all 0.2s ease;
    }
    .edit-target-btn:hover {
        background: #735C00;
        color: #FFFFFF;
    }

    .stat-value {
        font-family: 'Epilogue', sans-serif;
        font-size: 36px;
        font-weight: 800;
        color: #003227;
        margin: 0;
        margin-top: auto;
    }
    .target-card .stat-value {
        font-size: 20px;
        color: #FFFFFF;
        line-height: 1.4;
        margin-top: 8px;
        word-break: break-word;
    }

    /* Label tambahan di samping angka ("Santri") */
    .stat-unit {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        font-weight: 500;
        color: #707975;
    }

    /* Progress bar di kartu Target */
    .progress-bar-container {
        width: 100%;
        background: rgba(255,255,255,0.1);
        height: 6px;
        border-radius: 9999px;
        overflow: hidden;
        margin-top: 16px;
    }
    .progress-bar-fill {
        background: #735C00;
        height: 100%;
    }
    .progress-bar-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10px;
        color: #95D3BF;
        font-weight: 600;
        margin-top: 8px;
    }

    /* =====================================================================
       BAGIAN TABEL UTAMA
       ===================================================================== */
    .table-section {
        background: #FFFFFF;
        border-radius: 48px 48px 8px 8px; /* Lengkung besar di atas, kotak di bawah */
        overflow: hidden; /* Kunci: agar th background bisa meluber ke tepi */
        box-shadow: 0px 25px 50px -12px rgba(6, 78, 59, 0.05);
        width: 100%;
        box-sizing: border-box;
    }

    /* Header filter di dalam kartu tabel, punya padding sendiri */
    .table-header-flex {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px 32px; /* Padding hanya di area header */
        border-bottom: 1px solid rgba(191, 201, 196, 0.1);
        flex-wrap: wrap;
        gap: 16px;
    }

    .table-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: #003227;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    /* Garis indikator kecil di samping judul, seperti iuran */
    .table-title::before {
        content: '';
        display: inline-block;
        width: 8px;
        height: 24px;
        background: #735C00;
        border-radius: 9999px;
    }

    /* Gaya dropdown filter */
    .filter-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }
    .filter-select {
        background: #F6F3EC;
        border: none;
        border-radius: 9999px;
        padding: 8px 24px;
        font-family: 'Manrope', sans-serif;
        font-size: 14px;
        font-weight: 600;
        color: #003227;
        cursor: pointer;
        outline: none;
        appearance: auto;
    }

    /* Desain Tabel - mengikuti gaya bersih halaman Iuran */
    .data-table-wrapper {
        overflow-x: auto;
    }
    .data-table {
        width: 100%;
        border-collapse: collapse; /* Baris saling menempel, tanpa jarak */
    }

    .data-table th {
        background: #F6F3EC; /* Header abu lembut */
        padding: 16px 24px;
        text-align: left;
        font-family: 'Manrope', sans-serif;
        font-weight: 600;
        font-size: 12px;
        color: #78716C;
        text-transform: uppercase;
        letter-spacing: 1.2px;
    }
    .data-table th.center { text-align: center; }
    .data-table th.right { text-align: right; }

    /* Baris tabel — bersih tanpa background, cukup garis bawah tipis */
    .data-table tbody tr {
        background: transparent;
        border-bottom: 1px solid rgba(191, 201, 196, 0.15);
        transition: background 0.15s ease;
    }
    .data-table tbody tr:hover {
        background: #FAFAFA;
    }

    .data-table td {
        padding: 16px 24px;
        vertical-align: middle;
        height: 72px; /* Tinggi baris seragam seperti iuran */
    }

    /* Profil santri di tabel — ukuran lebih compact seperti iuran */
    .santri-profile {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .santri-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        font-weight: 800;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-shrink: 0;
    }
    /* Variasi warna avatar agar setiap santri berbeda */
    .avatar-bg-0 { background: #B0EFDA; color: #003227; }
    .avatar-bg-1 { background: #FFE088; color: #241A00; }
    .avatar-bg-2 { background: #E9E2D3; color: #1E1B13; }
    .avatar-bg-3 { background: #95D3BF; color: #002019; }
    .santri-name {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #064E3B;
        margin: 0;
    }
    .santri-class {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        color: #78716C;
        margin: 0;
    }

    .capaian-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 15px;
        font-weight: 700;
        color: #003227;
        margin: 0;
    }
    .capaian-note {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        font-style: italic;
        color: #78716C;
        margin: 4px 0 0 0;
        max-width: 220px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .capaian-empty { color: rgba(64, 73, 69, 0.4); }

    /* Lencana Status — ukuran compact */
    .status-badge {
        display: inline-flex;
        padding: 4px 12px;
        border-radius: 9999px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: -0.25px;
    }
    .status-badge.menghafal { background: #FEF3C7; color: #B45309; }
    .status-badge.mengulang { background: #FEE2E2; color: #B91C1C; }
    .status-badge.belum { background: #F3F4F6; color: #4B5563; }
    .status-badge.selesai { background: #D1FAE5; color: #047857; }

    /* Tombol Aksi — lebih kecil dan simpel seperti iuran */
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 8px;
    }
    .btn-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: transparent;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #A8A29E;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .btn-icon:hover { background: #F3F4F6; color: #1F2937; }
    .btn-edit { }
    .btn-wa { color: #25D366; }
    .btn-wa:hover { background: #F0FDF4; color: #15803D; }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #707975;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
    }

    /* =====================================================================
       MODAL (POP-UP FORM)
       ===================================================================== */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 50, 39, 0.4); /* Latar gelap semi-transparan */
        backdrop-filter: blur(4px); /* Efek blur pada latar belakang */
        z-index: 100;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 16px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s ease; /* Animasi fade in/out */
    }
    .modal-overlay.show {
        opacity: 1;
        pointer-events: auto;
    }

    .modal-content {
        background: #FFFFFF;
        width: 100%;
        max-width: 500px;
        border-radius: 24px;
        padding: 32px;
        box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
        transform: translateY(40px); /* Posisi awal di bawah untuk animasi */
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .modal-overlay.show .modal-content {
        transform: translateY(0); /* Posisi akhir (normal) */
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }
    .modal-title {
        font-family: 'Epilogue', sans-serif;
        font-size: 24px;
        font-weight: 800;
        color: #003227;
        margin: 0;
    }
    .modal-close-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #707975;
        transition: background 0.2s ease;
    }
    .modal-close-btn:hover { background: #F1EEE7; color: #003227; }

    /* Elemen Form di dalam Modal */
    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 16px;
    }
    .form-group.row {
        flex-direction: row;
        gap: 16px;
    }
    .form-label {
        font-family: 'Manrope', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: #003227;
    }
    .form-input {
        background: #F6F3EC;
        border: 1px solid rgba(191, 201, 196, 0.3);
        border-radius: 12px;
        padding: 12px 16px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        color: #003227;
        outline: none;
        transition: border-color 0.2s ease;
        width: 100%;
        box-sizing: border-box;
    }
    .form-input:focus { border-color: #735C00; }
    .form-input[readonly] {
        background: #F1EEE7;
        color: #404945;
        cursor: not-allowed;
    }
    
    .form-flex {
        display: flex;
        gap: 8px;
        align-items: center;
    }

    /* Tombol Aksi Modal */
    .modal-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 24px;
    }
    .btn-cancel {
        border: 1px solid #BFC9C4;
        background: transparent;
        color: #404945;
        padding: 12px 24px;
        border-radius: 9999px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        font-weight: 700;
    }
    .btn-cancel:hover { background: #F6F3EC; }
    .btn-save {
        background: #003227;
        color: #FFFFFF;
        padding: 12px 24px;
        border-radius: 9999px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        font-weight: 700;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .btn-save:hover { background: #004B3C; }

    /* Modal Khusus WhatsApp */
    .wa-header {
        background: #075E54;
        color: #FFFFFF;
        padding: 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin: -32px -32px 24px -32px; /* Menarik header agar menempel ke pinggir modal */
        border-radius: 24px 24px 0 0;
    }
    .wa-title-flex { display: flex; align-items: center; gap: 12px; }
    .wa-title { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 18px; margin: 0;}
    .wa-bubble {
        background: #DCF8C6;
        padding: 16px;
        border-radius: 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        color: #4A4A4A;
        line-height: 1.6;
        position: relative;
        margin-bottom: 24px;
    }
    /* Ekor balon chat WA */
    .wa-bubble::after {
        content: '';
        position: absolute;
        top: 0;
        right: -8px;
        width: 16px;
        height: 16px;
        background: #DCF8C6;
        transform: rotate(45deg);
        z-index: -1;
    }
    .btn-wa-send {
        background: #25D366;
        color: #FFFFFF;
        padding: 12px 32px;
        border-radius: 9999px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        flex: 2;
        justify-content: center;
    }
    .btn-wa-send:hover { filter: brightness(90%); }
</style>
@endpush

@section('content')
<div class="content-canvas">
    
    <!-- Bagian Notifikasi Jika Ada Pesan Sukses -->
    @if(session('success'))
    <div class="alert-success">
        <span class="material-symbols-outlined">check_circle</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Data yang Dihitung untuk Ditampilkan -->
    @php
        $targetText = $target->target ?? 'Belum Diatur';
        $totalSantri = $santris->count();
        $selesai = $progres->filter(fn($p) => $p->persentase >= 100 || $p->status == 'selesai')->count();
        $mengulang = $progres->filter(fn($p) => $p->status == 'mengulang')->count();
        $hasProgressCount = $progres->filter(fn($p) => $p->persentase > 0)->count();
        $targetToday = $totalSantri > 0 ? round(($hasProgressCount / $totalSantri) * 100) : 0;
        $surahList = ["Al-Fatihah", "Al-Baqarah", "Ali 'Imran", "An-Nisa'", "Al-Ma'idah", "Al-An'am", "Al-A'raf", "Al-Anfal", "At-Taubah", "Yunus", "Hud", "Yusuf", "Ar-Ra'd", "Ibrahim", "Al-Hijr", "An-Nahl", "Al-Isra'", "Al-Kahf", "Maryam", "Taha", "Al-Anbiya'", "Al-Hajj", "Al-Mu'minun", "An-Nur", "Al-Furqan", "Asy-Syu'ara'", "An-Naml", "Al-Qasas", "Al-'Ankabut", "Ar-Rum", "Luqman", "As-Sajdah", "Al-Ahzab", "Saba'", "Fatir", "Yasin", "As-Saffat", "Sad", "Az-Zumar", "Ghafir", "Fussilat", "Asy-Syura", "Az-Zukhruf", "Ad-Dukhan", "Al-Jasiyah", "Al-Ahqaf", "Muhammad", "Al-Fath", "Al-Hujurat", "Qaf", "Az-Zariyat", "At-Tur", "An-Najm", "Al-Qamar", "Ar-Rahman", "Al-Waqi'ah", "Al-Hadid", "Al-Mujadilah", "Al-Hasyr", "Al-Mumtahanah", "As-Saff", "Al-Jumu'ah", "Al-Munafiqun", "At-Tagabun", "At-Talaq", "At-Tahrim", "Al-Mulk", "Al-Qalam", "Al-Haqqah", "Al-Ma'arij", "Nuh", "Al-Jinn", "Al-Muzzammil", "Al-Muddassir", "Al-Qiyamah", "Al-Insan", "Al-Mursalat", "An-Naba'", "An-Nazi'at", "'Abasa", "At-Takwir", "Al-Infitar", "Al-Mutaffifin", "Al-Insyiqaq", "Al-Buruj", "At-Tariq", "Al-A'la", "Al-Gasyiyah", "Al-Fajr", "Al-Balad", "Asy-Syams", "Al-Lail", "Ad-Duha", "Asy-Syarh", "At-Tin", "Al-'Alaq", "Al-Qadr", "Al-Bayyinah", "Az-Zalzalah", "Al-'Adiyat", "Al-Qari'ah", "At-Takasur", "Al-'Asr", "Al-Humazah", "Al-Fil", "Quraisy", "Al-Ma'un", "Al-Kausar", "Al-Kafirun", "An-Nasr", "Al-Lahab", "Al-Ikhlas", "Al-Falaq", "An-Nas"];
    @endphp

    <!-- Bagian Hero (Header Atas) -->
    <div class="hero-header">
        <div class="hero-content">
            <span class="hero-badge">Caturwulan {{ $caturwulan }} • TA {{ $tahun_pelajaran }}</span>
            <h3 class="hero-title">Mencetak Generasi Qur'ani yang Berakhlak Mulia.</h3>
            <p class="hero-subtitle">Pantau dan bimbing hafalan santri dengan penuh kesabaran untuk mencapai target kurikulum tahun ajaran ini.</p>
        </div>
    </div>

    <!-- Kotak Ringkasan Statistik -->
    <div class="stats-grid">
        <!-- Target Card (Kotak Hijau Tua) -->
        <div class="arch-card target-card">
            <div style="position: absolute; right: -20px; bottom: -20px; opacity: 0.1;">
                <span class="material-symbols-outlined" style="font-size: 120px;">auto_stories</span>
            </div>
            <div class="stat-header-flex" style="position: relative; z-index: 1;">
                <div>
                    <p class="stat-label-small">Target Kelas</p>
                    <p class="stat-value" title="{{ $targetText }}">{{ $targetText }}</p>
                </div>
                <button class="edit-target-btn" onclick="openTargetModal()">
                    <span class="material-symbols-outlined">edit</span>
                </button>
                </div>
        </div>

        <!-- Santri Card -->
        <div class="arch-card">
            <div class="stat-header-flex">
                <p class="stat-label-small">Total Santri</p>
                <div class="stat-icon-box santri">
                    <span class="material-symbols-outlined fill-icon">group</span>
                </div>
            </div>
            <h3 class="stat-value">{{ $totalSantri }}</h3>
        </div>

        <!-- Selesai Card -->
        <div class="arch-card">
            <div class="stat-header-flex">
                <p class="stat-label-small">Selesai Target</p>
                <div class="stat-icon-box selesai">
                    <span class="material-symbols-outlined fill-icon">check_circle</span>
                </div>
            </div>
            <h3 class="stat-value">{{ $selesai }} <span class="stat-unit">Santri</span></h3>
        </div>

        <!-- Mengulang Card -->
        <div class="arch-card">
            <div class="stat-header-flex">
                <p class="stat-label-small">Perlu Mengulang</p>
                <div class="stat-icon-box mengulang">
                    <span class="material-symbols-outlined fill-icon">refresh</span>
                </div>
            </div>
            <h3 class="stat-value">{{ $mengulang }} <span class="stat-unit">Santri</span></h3>
        </div>
    </div>

    <!-- Bagian Tabel Utama -->
    <div class="table-section">
        <!-- Judul Tabel dan Filter -->
        <form id="filterForm" method="GET" action="{{ route('admin.hafalan') }}">
            <div class="table-header-flex">
                <h3 class="table-title">Hafalan Santri</h3>
                
                <div class="filter-group">
                    <select name="caturwulan" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                        @php
                            $taStart = substr($tahun_pelajaran, 0, 4);
                            $taEnd = substr($tahun_pelajaran, 5, 4);
                        @endphp
                        <option value="1" @selected($caturwulan == '1')>Caturwulan I (Juli - Okt {{ $taStart }})</option>
                        <option value="2" @selected($caturwulan == '2')>Caturwulan II (Nov {{ $taStart }} - Feb {{ $taEnd }})</option>
                        <option value="3" @selected($caturwulan == '3')>Caturwulan III (Mar - Jun {{ $taEnd }})</option>
                    </select>
                    
                    <select name="id_kelas" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                        @foreach($classes as $kls)
                            <option value="{{ $kls->id_kelas }}" @selected($id_kelas == $kls->id_kelas)>{{ $kls->nama_kelas }}</option>
                        @endforeach
                    </select>
                    
                    <select name="tahun_pelajaran" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                        @php
                            $startYear = 2026;
                            for($i = 0; $i < 3; $i++) {
                                $y = $startYear + $i;
                                $tp = $y . '/' . ($y + 1);
                                echo '<option value="'.$tp.'" '.($tahun_pelajaran == $tp ? 'selected' : '').'>TA '.$tp.'</option>';
                            }
                        @endphp
                    </select>
                </div>
            </div>
        </form>

        <!-- Tabel Data Santri -->
        <div class="data-table-wrapper">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Santri</th>
                        <th>Hafalan Terakhir</th>
                        <th>Status</th>
                        <th>Diperbarui</th>
                        <th class="right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($santris as $santri)
                        @php
                            $prog = $progres[$santri->id_santri] ?? null;
                            $capaian = $prog->capaian ?? '-';
                            $status = $prog->status ?? 'belum';
                            $keterangan = $prog->keterangan ?? '';
                            
                            $initials = strtoupper(substr($santri->nama, 0, 2));
                            $klsName = $classes->firstWhere('id_kelas', $id_kelas)->nama_kelas ?? 'Kelas';
                            
                            // Menyiapkan Nomor HP untuk WhatsApp
                            $noHp = $santri->no_hp_wali ?? '';
                            if (strpos($noHp, '0') === 0) $noHp = '62' . substr($noHp, 1);
                            $noHpWa = preg_replace('/[^0-9]/', '', $noHp);
                            
                            // Construct WhatsApp message directly
                            $targetStr = str_replace('s/d', 'sampai', $targetText);
                            
                            // Warm parent-friendly status descriptions
                            $displayStatus = 'Belum mulai setoran untuk target ini';
                            $statusNote = 'Ananda belum memulai setoran untuk target hafalan ini. Yuk kita semangati bersama agar ananda mulai aktif menyetor hafalan barunya.';
                            
                            if ($status === 'melanjutkan') {
                                $displayStatus = 'Sedang menambah hafalan baru';
                                $statusNote = 'Alhamdulillah, ananda sedang bersemangat melanjutkan setoran hafalan barunya. Mohon terus didukung ya Pak/Bu.';
                            } elseif ($status === 'mengulang') {
                                $displayStatus = 'Perlu mengulang agar lebih lancar';
                                $statusNote = 'Saat ini ananda perlu mengulang kembali hafalannya agar lebih lancar dan tidak mudah lupa. Mohon dibantu murajaah di rumah ya Pak/Bu.';
                            } elseif ($status === 'selesai') {
                                $displayStatus = 'Sudah menyelesaikan target! ';
                                $statusNote = 'Masya Allah, barakallah! Ananda telah berhasil menyelesaikan target hafalannya dengan baik. Mari kita apresiasi prestasinya.';
                            }

                            $waMessage = "Assalamu'alaikum Warahmatullahi Wabarakatuh,\n\n"
                                . "Bapak/Ibu Wali dari Ananda *" . $santri->nama . "*.\n\n"
                                . "Alhamdulillah, berikut kami sampaikan kabar perkembangan hafalan terbaru Ananda *" . $santri->nama . "* di TPA Baitur Ridwan:\n\n"
                                . "- *Target belajar semester ini*: " . $targetStr . "\n"
                                . "- *Hafalan terakhir*: " . ($capaian != '-' ? $capaian : '-') . "\n"
                                . "- *Kondisi saat ini*: " . $displayStatus . "\n\n"
                                . $statusNote . "\n";
                            
                            if (!empty($keterangan)) {
                                $waMessage .= "\n*Catatan Guru*:\n" . $keterangan . "\n";
                            }
                            
                            $waMessage .= "\nMohon bantuan Bapak/Ibu untuk terus mendampingi dan menyemangati ananda murajaah di rumah agar hafalannya semakin melekat di hati. Terima kasih atas perhatiannya.\n\n"
                                . "Wassalamu'alaikum Warahmatullahi Wabarakatuh.";
                            
                            $waUrl = "https://wa.me/" . $noHpWa . "?text=" . urlencode($waMessage);
                        @endphp
                        <tr>
                            <!-- Kolom 1: Profil Santri -->
                            <td>
                                <div class="santri-profile">
                                    <div class="santri-avatar avatar-bg-{{ $loop->index % 4 }}">{{ $initials }}</div>
                                    <div>
                                        <p class="santri-name">{{ $santri->nama }}</p>
                                        <p class="santri-class">{{ $klsName }}</p>
                                    </div>
                                </div>
                            </td>
                            <!-- Kolom 2: Capaian & Catatan -->
                            <td>
                                <p class="capaian-text {{ $capaian == '-' ? 'capaian-empty' : '' }}">{{ $capaian }}</p>
                                <p class="capaian-note" title="{{ $keterangan }}">{{ $keterangan ?: 'Tidak ada catatan' }}</p>
                            </td>
                            <!-- Kolom 3: Badge Status -->
                            <td class="center">
                                @if($status == 'melanjutkan')
                                    <span class="status-badge menghafal">Menghafal</span>
                                @elseif($status == 'mengulang')
                                    <span class="status-badge mengulang">Mengulang</span>
                                @elseif($status == 'belum')
                                    <span class="status-badge belum">Belum Mulai</span>
                                @else
                                    <span class="status-badge selesai">Selesai</span>
                                @endif
                            </td>
                            <!-- Kolom 4: Tanggal Update -->
                            <td class="center">
                                @if($prog && $prog->updated_at)
                                    <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 600; color: #78716C; background: #F6F3EC; padding: 4px 12px; border-radius: 6px; white-space: nowrap;">
                                        {{ $prog->updated_at->locale('id')->translatedFormat('d M Y') }}
                                    </span>
                                @else
                                    <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; color: #BFC9C4;">—</span>
                                @endif
                            </td>
                            <!-- Kolom 5: Tombol Edit & WhatsApp -->
                            <td style="padding-right: 24px;">
                                <div class="action-buttons">
                                    @if(empty($target) || empty($target->target))
                                    <button onclick="alert('Silakan atur Target Kelas terlebih dahulu sebelum mengisi progres hafalan santri!')" class="btn-icon btn-edit" title="Atur target kelas terlebih dahulu" style="opacity: 0.5; cursor: not-allowed;">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                                    </button>
                                    @else
                                    <button onclick="openUpdateModal({{ $santri->id_santri }}, '{{ addslashes($santri->nama) }}', '{{ addslashes($capaian) }}', '{{ $status }}', '{{ addslashes($keterangan) }}')" class="btn-icon btn-edit" title="Update Progres">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                                    </button>
                                    @endif
                                    @if($noHpWa)
                                    <a href="{{ $waUrl }}" target="_blank" class="btn-icon btn-wa" title="Kirim Pesan WhatsApp">
                                        <!-- Ikon WhatsApp SVG asli -->
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="18" height="18" fill="currentColor">
                                            <path d="M16 .5C7.44.5.5 7.44.5 16c0 2.72.7 5.32 2.05 7.62L.5 31.5l8.1-2.02A15.46 15.46 0 0 0 16 31.5C24.56 31.5 31.5 24.56 31.5 16S24.56.5 16 .5zm0 28.3a13.3 13.3 0 0 1-6.77-1.85l-.48-.29-4.81 1.2 1.23-4.68-.32-.5A13.3 13.3 0 1 1 16 28.8zm7.3-9.97c-.4-.2-2.36-1.16-2.73-1.3-.37-.13-.64-.2-.9.2s-1.03 1.3-1.27 1.57c-.23.27-.46.3-.86.1a10.9 10.9 0 0 1-3.2-1.98 12 12 0 0 1-2.22-2.75c-.23-.4-.02-.62.18-.82.18-.18.4-.46.6-.7.2-.23.27-.4.4-.66.14-.27.07-.5-.03-.7-.1-.2-.9-2.17-1.23-2.97-.32-.77-.65-.67-.9-.68h-.77c-.27 0-.7.1-1.06.5a4.6 4.6 0 0 0-1.44 3.44c0 2.03 1.47 3.98 1.67 4.26.2.27 2.88 4.4 6.98 6.17 2.46 1.06 3.42 1.15 4.65.97 1-.15 2.35-.96 2.68-1.89.33-.93.33-1.73.23-1.9-.1-.16-.37-.26-.77-.46z"/>
                                        </svg>
                                    </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">Tidak ada data santri aktif di kelas ini.</div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- =====================================================================
     BAGIAN MODAL (POP-UP)
     ===================================================================== -->

<!-- 1. Modal Set Target Kelas -->
<div class="modal-overlay" id="targetModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Target Hafalan Kelas</h3>
            <button class="modal-close-btn" onclick="toggleModal('targetModal')">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form method="POST" action="{{ route('admin.hafalan.target.store') }}" onsubmit="return validateTargetForm()">
            @csrf
            <input type="hidden" name="id_kelas" value="{{ $id_kelas }}">
            <input type="hidden" name="caturwulan" value="{{ $caturwulan }}">
            <input type="hidden" name="tahun_pelajaran" value="{{ $tahun_pelajaran }}">
            
            <div class="form-group">
                <label class="form-label">Deskripsi Target (Dari - Sampai)</label>
                <div class="form-flex">
                    <input type="text" id="target-surah-start" list="surah-list" class="form-input" placeholder="Surah Awal..." oninput="updateTargetText()">
                    <span style="font-weight: 700; color: #707975; font-size: 12px;">s/d</span>
                    <input type="text" id="target-surah-end" list="surah-list" class="form-input" placeholder="Surah Akhir..." oninput="updateTargetText()">
                </div>
                <!-- Input tersembunyi untuk menyimpan format target yang sebenarnya -->
                <input type="hidden" name="target" id="modal-target" value="{{ $target->target ?? '' }}">
            </div>
            
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="toggleModal('targetModal')">Batal</button>
                <button type="submit" class="btn-save">Simpan Target</button>
            </div>
        </form>
    </div>
</div>

<!-- 2. Modal Update Progress Santri -->
<div class="modal-overlay" id="updateModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title">Update Progress</h3>
            <button class="modal-close-btn" onclick="toggleModal('updateModal')">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form method="POST" action="{{ route('admin.hafalan.progress.store') }}" onsubmit="return validateProgressForm()">
            @csrf
            <input type="hidden" name="id_kelas" value="{{ $id_kelas }}">
            <input type="hidden" name="caturwulan" value="{{ $caturwulan }}">
            <input type="hidden" name="tahun_pelajaran" value="{{ $tahun_pelajaran }}">
            
            <div class="form-group">
                <label class="form-label">Nama Santri</label>
                <input id="modal-nama-santri" class="form-input" readonly type="text" value=""/>
            </div>
            
            <input type="hidden" id="modal-capaian" name="progress[0][capaian]">
            
            <div class="form-group row">
                <div style="flex: 1;">
                    <label class="form-label">Nama Surah</label>
                    <input type="text" id="modal-surah" list="surah-list" oninput="updateCapaian()" class="form-input" placeholder="Cari Surah...">
                    <datalist id="surah-list">
                        @foreach($surahList as $surah)
                            <option value="{{ $surah }}">
                        @endforeach
                    </datalist>
                </div>
                <div style="flex: 1;">
                    <label class="form-label">Ayat Terakhir</label>
                    <input type="text" id="modal-ayat" oninput="updateCapaian()" class="form-input" placeholder="Misal: 1-15">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Status Hafalan</label>
                <select id="modal-status" name="progress[0][status]" class="form-input">
                    <option value="belum">Belum Dievaluasi</option>
                    <option value="melanjutkan">Melanjutkan (Menghafal)</option>
                    <option value="mengulang">Perlu Mengulang</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>
            
            <div class="form-group">
                <label class="form-label">Catatan (Opsional)</label>
                <textarea id="modal-keterangan" name="progress[0][keterangan]" class="form-input" style="height: 80px; resize: none;" placeholder="Ketik catatan di sini..."></textarea>
            </div>
            
            <div class="modal-actions">
                <button type="button" class="btn-cancel" onclick="toggleModal('updateModal')">Batal</button>
                <button type="submit" class="btn-save">Simpan Progres</button>
            </div>
        </form>
    </div>
</div>



<!-- =====================================================================
     SCRIPT JAVASCRIPT
     ===================================================================== -->
<script>
    // Validasi form Target Kelas agar tidak kosong
    function validateTargetForm() {
        const start = document.getElementById('target-surah-start').value.trim();
        const end = document.getElementById('target-surah-end').value.trim();
        if (!start || !end) {
            alert('Surah Awal dan Surah Akhir harus diisi untuk menentukan target kelas!');
            return false;
        }
        return true;
    }

    // Validasi form Progres Hafalan agar tidak kosong saat status aktif dipilih
    function validateProgressForm() {
        const status = document.getElementById('modal-status').value;
        const surah = document.getElementById('modal-surah').value.trim();
        const ayat = document.getElementById('modal-ayat').value.trim();
        
        if (status !== 'belum') {
            if (!surah || !ayat) {
                alert('Nama Surah dan Ayat Terakhir harus diisi jika status selain "Belum Dievaluasi"!');
                return false;
            }
        }
        return true;
    }

    // Fungsi untuk membuka dan menutup modal secara generik
    function toggleModal(modalId) {
        const modal = document.getElementById(modalId);
        if (modal.classList.contains('show')) {
            modal.classList.remove('show'); // Menyembunyikan modal
        } else {
            modal.classList.add('show');    // Menampilkan modal
        }
    }

    // Fungsi otomatis menggabungkan Surah Awal dan Akhir menjadi format Target
    function updateTargetText() {
        let start = document.getElementById('target-surah-start').value.trim();
        let end = document.getElementById('target-surah-end').value.trim();
        if (start && end) {
            document.getElementById('modal-target').value = start + ' s/d ' + end;
        } else if (start) {
            document.getElementById('modal-target').value = start;
        } else {
            document.getElementById('modal-target').value = '';
        }
    }

    // Membuka modal target dan memecah nilai teks target yang ada menjadi dua input terpisah
    function openTargetModal() {
        let targetVal = document.getElementById('modal-target').value;
        let parts = targetVal.split(' s/d ');
        if(parts.length === 2) {
            document.getElementById('target-surah-start').value = parts[0];
            document.getElementById('target-surah-end').value = parts[1];
        } else {
            document.getElementById('target-surah-start').value = targetVal;
            document.getElementById('target-surah-end').value = '';
        }
        toggleModal('targetModal');
    }

    // Menggabungkan Surah dan Ayat untuk disimpan sebagai string 'Capaian'
    function updateCapaian() {
        let surah = document.getElementById('modal-surah').value.trim();
        let ayat = document.getElementById('modal-ayat').value.trim();
        let capaian = surah;
        if (surah && ayat) {
            capaian += ' Ayat ' + ayat;
        } else if (!surah && ayat) {
            capaian = 'Ayat ' + ayat;
        }
        document.getElementById('modal-capaian').value = capaian;
    }

    // Membuka Modal Update Progres dan Mengisi Form Otomatis sesuai Santri yang Diklik
    function openUpdateModal(idSantri, namaSantri, capaian, status, keterangan) {
        document.getElementById('modal-nama-santri').value = namaSantri;
        
        let capaianStr = capaian === '-' ? '' : capaian;
        
        // Memastikan input hidden dikirim ke array indeks id_santri yang benar
        document.getElementById('modal-capaian').name = `progress[${idSantri}][capaian]`;
        document.getElementById('modal-capaian').value = capaianStr;
        
        // Memecah kembali string capaian ke input Surah dan input Ayat
        let parts = capaianStr.split(' Ayat ');
        if (parts.length === 2) {
            document.getElementById('modal-surah').value = parts[0];
            document.getElementById('modal-ayat').value = parts[1];
        } else {
            if (capaianStr.startsWith('Ayat ')) {
                document.getElementById('modal-surah').value = '';
                document.getElementById('modal-ayat').value = capaianStr.substring(5);
            } else {
                document.getElementById('modal-surah').value = capaianStr;
                document.getElementById('modal-ayat').value = '';
            }
        }

        document.getElementById('modal-status').name = `progress[${idSantri}][status]`;
        document.getElementById('modal-status').value = status;
        document.getElementById('modal-keterangan').name = `progress[${idSantri}][keterangan]`;
        document.getElementById('modal-keterangan').value = keterangan;
        
        toggleModal('updateModal');
    }


</script>
@endsection
