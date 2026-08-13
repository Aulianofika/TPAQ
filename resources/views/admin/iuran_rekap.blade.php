@extends('layouts.admin')

@section('title', 'Rekap Iuran Santri - TPA Baitur Ridwan')

@push('styles')
<style>
    /* Content Layout */
    .content-canvas {
        display: flex;
        flex-direction: column;
        gap: 32px;
        width: 100%;
        padding: 32px;
        box-sizing: border-box;
    }

    /* Page Header Section */
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        width: 100%;
        flex-wrap: wrap;
        gap: 16px;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Manrope', sans-serif;
        font-size: 14px;
        color: #78716C;
        margin-bottom: 8px;
    }

    .breadcrumb-active {
        color: #003227;
        font-weight: 600;
    }

    .header-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: 36px;
        line-height: 40px;
        color: #003227;
        margin: 0 0 8px 0;
        letter-spacing: -0.9px;
    }

    .header-subtitle {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 16px;
        color: #404945;
        margin: 0;
    }

    /* Cards Grid */
    .iuran-cards-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 20px;
    }

    @media (min-width: 768px) {
        .iuran-cards-grid {
            grid-template-columns: repeat(4, 1fr);
        }
    }

    .iuran-card {
        border-radius: 24px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 16px;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    
    .iuran-card:hover {
        transform: translateY(-4px);
    }

    .iuran-icon-box {
        width: 42px;
        height: 42px;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .iuran-card-title {
        font-family: 'Manrope', sans-serif;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin: 0 0 4px 0;
    }
    
    .iuran-card-amount {
        font-family: 'Epilogue', sans-serif;
        font-size: 24px;
        font-weight: 800;
        letter-spacing: -0.02em;
        margin: 0;
        line-height: 1.2;
    }

    /* Card Themes */
    .card-terkumpul { background-color: #004b3c; color: #FFFFFF; }
    .card-terkumpul .iuran-icon-box { background-color: #facc15; color: #713f12; }
    .card-terkumpul .iuran-card-title { color: rgba(209, 250, 229, 0.7); }

    .card-pelunasan { background-color: #FFFFFF; border: 1px solid rgba(191, 201, 196, 0.2); }
    .card-pelunasan .iuran-icon-box { background-color: #022c22; color: #d1fae5; }
    .card-pelunasan .iuran-card-title { color: #78716C; }
    .card-pelunasan .iuran-card-amount { color: #003227; }

    .card-full { background-color: #ECFDF5; border: 1px solid #A7F3D0; }
    .card-full .iuran-icon-box { background-color: #059669; color: #FFFFFF; }
    .card-full .iuran-card-title { color: #047857; }
    .card-full .iuran-card-amount { color: #064E3B; }

    .card-tunggakan { background-color: #FFFBEB; border: 1px solid #FDE68A; }
    .card-tunggakan .iuran-icon-box { background-color: #D97706; color: #FFFFFF; }
    .card-tunggakan .iuran-card-title { color: #B45309; }
    .card-tunggakan .iuran-card-amount { color: #78350F; }

    /* Table Section */
    .table-section {
        background: #FFFFFF;
        box-shadow: 0px 25px 50px -12px rgba(6, 78, 59, 0.05);
        border-radius: 36px;
        overflow: hidden;
        width: 100%;
        box-sizing: border-box;
    }

    .table-header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px 32px;
        border-bottom: 1px solid rgba(191, 201, 196, 0.1);
        flex-wrap: wrap;
        gap: 16px;
    }

    .table-title {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 18px;
        color: #003227;
    }

    .title-indicator {
        width: 8px;
        height: 24px;
        background: #735C00;
        border-radius: 9999px;
    }

    .search-filter-form {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .search-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-icon {
        position: absolute;
        left: 14px;
        color: #57534E;
        font-size: 18px;
    }

    .input-search {
        background: #F6F3EC;
        border: 1px solid #BFC9C4;
        border-radius: 9999px;
        padding: 8px 16px 8px 38px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        color: #57534E;
        outline: none;
        width: 180px;
        transition: all 0.3s ease;
    }

    .input-search:focus {
        border-color: #003227;
        width: 220px;
    }

    .filter-select {
        background: #FFFFFF;
        border: 1px solid #BFC9C4;
        border-radius: 9999px;
        padding: 8px 16px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        color: #57534E;
        outline: none;
        cursor: pointer;
    }

    .btn-pdf {
        background: #004B3C;
        color: #FFFFFF;
        padding: 8px 16px;
        border-radius: 9999px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
    }

    .btn-pdf:hover { background: #065F46; }

    .btn-pdf-outline {
        background: transparent;
        color: #004B3C;
        border: 1px solid #004B3C;
        padding: 8px 16px;
        border-radius: 9999px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all 0.2s;
    }

    .btn-pdf-outline:hover { background: #F0FDF4; }

    /* Matrix Table Styles */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        width: 100%;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        background: #F6F3EC;
        padding: 12px 14px;
        text-align: center;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 11px;
        color: #78716C;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    .data-table td {
        padding: 14px;
        border-bottom: 1px solid rgba(191, 201, 196, 0.1);
        vertical-align: middle;
        text-align: center;
    }

    .month-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 26px;
        height: 26px;
        border-radius: 50%;
        font-size: 12px;
    }

    .month-lunas { background: #D1FAE5; color: #047857; }
    .month-belum { background: #F3F4F6; color: #9CA3AF; }

    /* Profile Info Group */
    .profile-group {
        display: flex;
        align-items: center;
        gap: 10px;
        text-align: left;
    }

    .profile-initial {
        width: 32px;
        height: 32px;
        border-radius: 9999px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 12px;
        flex-shrink: 0;
    }

    .avatar-bg-0 { background: #B0EFDA; color: #003227; }
    .avatar-bg-1 { background: #FFE088; color: #241A00; }
    .avatar-bg-2 { background: #E9E2D3; color: #1E1B13; }
    .avatar-bg-3 { background: #95D3BF; color: #002019; }

    .text-main {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 14px;
        color: #064E3B;
        margin: 0;
    }

    .text-sub {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 11px;
        color: #78716C;
        margin: 0;
    }

    .badge {
        display: inline-flex;
        padding: 4px 10px;
        border-radius: 9999px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 10px;
        text-transform: uppercase;
    }

    .badge-lunas { background: #D1FAE5; color: #047857; }
    .badge-menunggak { background: #FEE2E2; color: #B91C1C; }

    .btn-detail {
        background: #F6F3EC;
        color: #004B3C;
        border: none;
        padding: 6px 12px;
        border-radius: 9999px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 11px;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s;
    }

    .btn-detail:hover {
        background: #004B3C;
        color: #FFFFFF;
    }

    /* Modal Styling */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 50, 39, 0.5);
        backdrop-filter: blur(4px);
        z-index: 100;
        display: none;
        justify-content: center;
        align-items: center;
    }

    .modal-container {
        background: #FFFFFF;
        width: 100%;
        max-width: 640px;
        border-radius: 36px;
        padding: 32px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .modal-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: 22px;
        color: #003227;
        margin: 0;
    }

    .modal-close {
        background: transparent;
        border: none;
        color: #9CA3AF;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
    }
</style>
@endpush

@section('content')
<div class="content-canvas">

    <!-- Page Header Section -->
    <div class="page-header">
        <div>
            <div class="breadcrumb">
                <span>Admin</span>
                <span class="material-symbols-outlined" style="font-size: 14px;">chevron_right</span>
                <span>Laporan & Rekap</span>
                <span class="material-symbols-outlined" style="font-size: 14px;">chevron_right</span>
                <span class="breadcrumb-active">Rekap Iuran</span>
            </div>
            <h1 class="header-title">Rekap Iuran Santri</h1>
            <p class="header-subtitle">Laporan dan rekapitulasi pelunasan SPP 12 bulan (Januari - Desember) per santri tahun <span style="font-weight: 700; color: #003227;">{{ $tahun }}</span>.</p>
        </div>
    </div>

    <!-- Stats Overview Grid -->
    <div class="iuran-cards-grid">
        <!-- Card 1: Total Terkumpul -->
        <div class="iuran-card card-terkumpul">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <p class="iuran-card-title">Total Terkumpul</p>
                <div class="iuran-icon-box">
                    <span class="material-symbols-outlined" style="font-size: 20px;">account_balance_wallet</span>
                </div>
            </div>
            <h2 class="iuran-card-amount">Rp {{ number_format($total_terkumpul_tahun, 0, ',', '.') }}</h2>
            <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; color: rgba(255,255,255,0.7);">Dari target Rp {{ number_format($target_setahun, 0, ',', '.') }}</span>
        </div>

        <!-- Card 2: Kepatuhan Pembayaran -->
        <div class="iuran-card card-pelunasan">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <p class="iuran-card-title">Kepatuhan SPP</p>
                <div class="iuran-icon-box">
                    <span class="material-symbols-outlined" style="font-size: 20px;">percent</span>
                </div>
            </div>
            <h2 class="iuran-card-amount">{{ $persentase_pelunasan }}%</h2>
            <div style="width: 100%; background: #F3F4F6; height: 6px; border-radius: 999px; overflow: hidden; margin-top: 4px;">
                <div style="width: {{ $persentase_pelunasan }}%; background: #004B3C; height: 100%; border-radius: 999px;"></div>
            </div>
        </div>

        <!-- Card 3: Santri Lunas Full 12 Bulan -->
        <div class="iuran-card card-full">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <p class="iuran-card-title">Lunas Full (12 Bulan)</p>
                <div class="iuran-icon-box">
                    <span class="material-symbols-outlined" style="font-size: 20px;">verified</span>
                </div>
            </div>
            <h2 class="iuran-card-amount">{{ $lunas_full_count }} Santri</h2>
            <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; color: #047857;">Dari total {{ $total_santri }} santri aktif</span>
        </div>

        <!-- Card 4: Santri Ada Tunggakan -->
        <div class="iuran-card card-tunggakan">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <p class="iuran-card-title">Ada Tunggakan</p>
                <div class="iuran-icon-box">
                    <span class="material-symbols-outlined" style="font-size: 20px;">warning</span>
                </div>
            </div>
            <h2 class="iuran-card-amount">{{ $total_santri - $lunas_full_count }} Santri</h2>
            <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; color: #B45309;">Belum lunas 12 bulan full</span>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-section">
        <div class="table-header-bar">
            <div class="table-title">
                <div class="title-indicator"></div>
                <span>Matriks Rekapitulasi Per Santri</span>
            </div>

            <div class="search-filter-form">
                <!-- Search -->
                <div class="search-input-wrapper">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input type="text" id="searchInput" placeholder="Cari nama santri..." autocomplete="off" class="input-search" value="{{ $search }}">
                </div>

                <!-- Filter Form -->
                <form method="GET" action="{{ route('admin.iuran.rekap') }}" id="filterForm" style="display: flex; gap: 8px; align-items: center;">
                    <select name="id_kelas" class="filter-select" onchange="this.form.submit()">
                        <option value="semua" {{ $id_kelas == 'semua' ? 'selected' : '' }}>Semua Kelas</option>
                        @foreach($classes as $kls)
                            <option value="{{ $kls->id_kelas }}" {{ $id_kelas == $kls->id_kelas ? 'selected' : '' }}>{{ $kls->nama_kelas }}</option>
                        @endforeach
                    </select>

                    <select name="tahun" class="filter-select" onchange="this.form.submit()">
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                </form>

                <!-- PDF Export Buttons -->
                <a href="{{ route('admin.iuran.rekap.preview', ['id_kelas' => $id_kelas, 'tahun' => $tahun]) }}" target="_blank" class="btn-pdf-outline" title="Pratinjau Cetak PDF">
                    <span class="material-symbols-outlined" style="font-size: 16px;">visibility</span> Preview
                </a>
                <a href="{{ route('admin.iuran.rekap.pdf', ['id_kelas' => $id_kelas, 'tahun' => $tahun]) }}" class="btn-pdf" title="Unduh File PDF">
                    <span class="material-symbols-outlined" style="font-size: 16px;">picture_as_pdf</span> Cetak PDF
                </a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table iuran-matrix-table">
                <thead>
                    <tr>
                        <th style="text-align: left; padding-left: 24px; min-width: 180px;">Nama Santri</th>
                        @foreach($all_months as $m)
                            <th title="{{ $m }}">{{ substr($m, 0, 3) }}</th>
                        @endforeach
                        <th style="min-width: 70px;">Lunas</th>
                        <th style="text-align: right; min-width: 110px;">Total Bayar</th>
                        <th>Status</th>
                        <th style="text-align: center; padding-right: 24px;">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($santris as $santri)
                        @php
                            $nameParts = explode(' ', $santri->nama);
                            $initial = count($nameParts) > 1 
                                ? strtoupper($nameParts[0][0] . $nameParts[1][0]) 
                                : strtoupper($nameParts[0][0]);
                            $bgClass = 'avatar-bg-' . ($santri->id_santri % 4);
                            $isFullLunas = $santri->lunas_count >= 12;
                        @endphp
                        <tr>
                            <td style="text-align: left; padding-left: 24px;">
                                <div class="profile-group">
                                    <div class="profile-initial {{ $bgClass }}">{{ $initial }}</div>
                                    <div>
                                        <p class="text-main student-name">{{ $santri->nama }}</p>
                                        <p class="text-sub">{{ $santri->kelas->nama_kelas ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- 12 Months Matrix -->
                            @foreach($all_months as $m)
                                @php
                                    $monthData = $santri->monthly_map[$m];
                                    $isL = $monthData['status'] === 'lunas';
                                @endphp
                                <td>
                                    @if($isL)
                                        <span class="month-badge month-lunas" title="{{ $m }}: Lunas (Rp {{ number_format($monthData['jumlah'], 0, ',', '.') }})">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">check</span>
                                        </span>
                                    @else
                                        <span class="month-badge month-belum" title="{{ $m }}: Belum Bayar">
                                            <span style="font-size: 10px; font-weight: 700;">-</span>
                                        </span>
                                    @endif
                                </td>
                            @endforeach

                            <td>
                                <strong style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; color: {{ $isFullLunas ? '#047857' : '#D97706' }};">
                                    {{ $santri->lunas_count }}/12
                                </strong>
                            </td>

                            <td style="text-align: right; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 13px; color: #003227;">
                                Rp {{ number_format($santri->total_paid, 0, ',', '.') }}
                            </td>

                            <td>
                                @if($isFullLunas)
                                    <span class="badge badge-lunas">LUNAS FULL</span>
                                @else
                                    <span class="badge badge-menunggak">{{ $santri->tunggakan_count }} BLN TUNGGAK</span>
                                @endif
                            </td>

                            <td style="padding-right: 24px;">
                                @php
                                    $jsonMap = htmlspecialchars(json_encode($santri->monthly_map), ENT_QUOTES, 'UTF-8');
                                    $namaClean = htmlspecialchars(addslashes($santri->nama));
                                    $kelasClean = htmlspecialchars(addslashes($santri->kelas->nama_kelas ?? '-'));
                                @endphp
                                <button type="button" class="btn-detail" onclick="openDetailSantriModal('{{ $namaClean }}', '{{ $kelasClean }}', {{ $santri->lunas_count }}, {{ $santri->total_paid }}, '{{ $jsonMap }}')">
                                    <span class="material-symbols-outlined" style="font-size: 14px;">visibility</span> Detail
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="17" style="text-align: center; padding: 48px; color: #A8A29E;">
                                <span class="material-symbols-outlined" style="font-size: 48px; margin-bottom: 12px; opacity: 0.5;">request_quote</span>
                                <p style="font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; font-weight: 700;">Belum ada data iuran</p>
                                <p style="font-family: 'Plus Jakarta Sans', sans-serif; margin: 4px 0 0 0; font-size: 13px;">Tidak ada data santri ditemukan untuk kelas/tahun ini.</p>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noSearchResult" style="display: none;">
                        <td colspan="17" style="text-align: center; padding: 48px; color: #A8A29E;">
                            <span class="material-symbols-outlined" style="font-size: 48px; margin-bottom: 12px; opacity: 0.5;">search_off</span>
                            <p style="font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; font-weight: 700;">Data tidak ditemukan</p>
                            <p style="font-family: 'Plus Jakarta Sans', sans-serif; margin: 4px 0 0 0; font-size: 13px;">Tidak ada santri yang cocok dengan kata kunci Anda.</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Detail Rekap Per Santri -->
<div class="modal-overlay" id="detailSantriModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Riwayat Iuran 12 Bulan</h3>
            <button type="button" class="modal-close" onclick="closeModal('detailSantriModal')">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div style="display: flex; flex-direction: column; gap: 16px;">
            <div style="background: #F6F3EC; padding: 16px; border-radius: 20px; display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h4 id="md_nama_santri" style="margin: 0 0 4px 0; font-family: 'Epilogue', sans-serif; font-size: 18px; color: #003227;">-</h4>
                    <p id="md_kelas_santri" style="margin: 0; font-size: 13px; color: #57534E;">-</p>
                </div>
                <div style="text-align: right;">
                    <h4 id="md_total_paid" style="margin: 0 0 4px 0; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 18px; font-weight: 800; color: #003227;">-</h4>
                    <span id="md_lunas_badge" class="badge badge-lunas">0/12 Bulan</span>
                </div>
            </div>

            <div style="max-height: 340px; overflow-y: auto; border: 1px solid #E5E7EB; border-radius: 16px;">
                <table style="width: 100%; border-collapse: collapse; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px;">
                    <thead>
                        <tr style="background: #F9FAFB; border-bottom: 1px solid #E5E7EB; text-align: left; color: #6B7280;">
                            <th style="padding: 10px 14px;">Bulan</th>
                            <th style="padding: 10px 14px;">Status</th>
                            <th style="padding: 10px 14px;">Tgl Bayar</th>
                            <th style="padding: 10px 14px;">Pencatat</th>
                            <th style="padding: 10px 14px; text-align: center;">Bukti</th>
                        </tr>
                    </thead>
                    <tbody id="md_table_body">
                        <!-- Filled by JS -->
                    </tbody>
                </table>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 8px;">
                <button type="button" class="btn-pdf" onclick="closeModal('detailSantriModal')">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function openDetailSantriModal(nama, kelas, lunasCount, totalPaid, monthlyMapJson) {
        document.getElementById('md_nama_santri').textContent = nama;
        document.getElementById('md_kelas_santri').textContent = 'Kelas: ' + kelas;
        document.getElementById('md_total_paid').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(totalPaid);
        document.getElementById('md_lunas_badge').textContent = lunasCount + '/12 Bulan Lunas';
        
        let mapData = {};
        try {
            mapData = JSON.parse(monthlyMapJson);
        } catch(e) {
            console.error(e);
        }

        const tbody = document.getElementById('md_table_body');
        tbody.innerHTML = '';

        for (const [bulan, data] of Object.entries(mapData)) {
            const tr = document.createElement('tr');
            tr.style.borderBottom = '1px solid #F3F4F6';

            const isLunas = data.status === 'lunas';
            const statusBadge = isLunas 
                ? `<span class="badge badge-lunas">Lunas</span>` 
                : `<span class="badge badge-menunggak">Belum</span>`;

            let buktiBtn = '<span style="color: #9CA3AF;">-</span>';
            if (data.bukti) {
                buktiBtn = `<a href="${data.bukti}" target="_blank" style="color: #047857; text-decoration: none; font-weight: 700; display: inline-flex; align-items: center; gap: 2px;">
                    <span class="material-symbols-outlined" style="font-size: 16px;">verified</span> File
                </a>`;
            }

            tr.innerHTML = `
                <td style="padding: 10px 14px; font-weight: 700; color: #1F2937;">${bulan}</td>
                <td style="padding: 10px 14px;">${statusBadge}</td>
                <td style="padding: 10px 14px; color: #4B5563;">${data.tanggal || '-'}</td>
                <td style="padding: 10px 14px; color: #4B5563; font-size: 12px;">${data.pencatat || '-'}</td>
                <td style="padding: 10px 14px; text-align: center;">${buktiBtn}</td>
            `;

            tbody.appendChild(tr);
        }

        openModal('detailSantriModal');
    }

    // Real-time search filter
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.iuran-matrix-table tbody tr:not(#noSearchResult):not(.empty-row)');
        let visibleCount = 0;
        
        rows.forEach(row => {
            let nameElement = row.querySelector('.student-name');
            if (nameElement) {
                let name = nameElement.textContent || nameElement.innerText;
                if (name.toLowerCase().indexOf(filter) > -1) {
                    row.style.display = "";
                    visibleCount++;
                } else {
                    row.style.display = "none";
                }
            }
        });

        let noSearchResult = document.getElementById('noSearchResult');
        if (noSearchResult && rows.length > 0) {
            noSearchResult.style.display = (visibleCount === 0 && filter !== '') ? "" : "none";
        }
    });

    window.onclick = function(event) {
        if (event.target.classList.contains('modal-overlay')) {
            event.target.style.display = 'none';
        }
    }
</script>
@endpush
@endsection
