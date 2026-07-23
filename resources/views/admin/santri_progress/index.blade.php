@extends('layouts.admin')

@section('title', 'Perkembangan Santri - TPA Baitur Ridwan')

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

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        width: 100%;
    }

    @media (max-width: 1200px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .stat-card {
        background: #FFFFFF;
        border-bottom: 4px solid rgba(6, 78, 59, 0.1);
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
        border-radius: 32px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        transition: transform 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.05);
    }

    .stat-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .stat-icon-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 48px;
        height: 48px;
        border-radius: 16px;
    }

    .stat-icon-wrapper.santri { background: #E6F4F1; color: #004B3C; }
    .stat-icon-wrapper.attendance { background: #FEF3C7; color: #D97706; }
    .stat-icon-wrapper.hafalan { background: #ECFDF5; color: #059669; }
    .stat-icon-wrapper.raport { background: #EFF6FF; color: #3B82F6; }

    .stat-label {
        font-family: 'Manrope', sans-serif;
        font-size: 14px;
        color: #404945;
        margin: 0;
    }

    .stat-value {
        font-family: 'Epilogue', sans-serif;
        font-weight: 900;
        font-size: 30px;
        color: #003227;
        margin: 0;
    }

    /* Table Section */
    .table-section {
        background: #FFFFFF;
        box-shadow: 0px 25px 50px -12px rgba(6, 78, 59, 0.05);
        border-radius: 48px 48px 8px 8px;
        overflow: hidden;
        width: 100%;
        box-sizing: border-box;
        border: 1px solid rgba(191, 201, 196, 0.1);
    }

    .table-header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 32px;
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
        left: 16px;
        color: #57534E;
        font-size: 18px;
    }

    .input-search {
        background: #F6F3EC;
        border: 1px solid #BFC9C4;
        border-radius: 9999px;
        padding: 10px 16px 10px 40px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        color: #57534E;
        outline: none;
        width: 220px;
        transition: all 0.3s ease;
    }

    .input-search:focus {
        border-color: #003227;
        background: #FFFFFF;
        width: 280px;
    }

    .filter-select {
        background: #FFFFFF;
        border: 1px solid #BFC9C4;
        border-radius: 9999px;
        padding: 10px 20px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        color: #57534E;
        outline: none;
        cursor: pointer;
        transition: all 0.2s;
    }

    .filter-select:focus {
        border-color: #003227;
    }

    .btn-submit {
        background: #003227;
        color: white;
        border-radius: 9999px;
        padding: 10px 24px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        box-shadow: 0px 4px 6px rgba(0, 50, 39, 0.15);
        transition: all 0.2s;
    }

    .btn-submit:hover {
        background: #065F46;
        transform: translateY(-1px);
    }

    .btn-reset {
        background: #F6F3EC;
        color: #003227;
        border-radius: 9999px;
        padding: 10px 20px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        border: 1px solid #BFC9C4;
        text-decoration: none;
        text-align: center;
        transition: all 0.2s;
    }

    .btn-reset:hover {
        background: #E5E2DB;
    }

    /* Table Styles */
    .santri-table {
        width: 100%;
        border-collapse: collapse;
    }

    .santri-table th {
        background: #F6F3EC;
        padding: 16px 24px;
        text-align: left;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 12px;
        color: #78716C;
        text-transform: uppercase;
        letter-spacing: 1.2px;
    }

    .santri-table td {
        padding: 20px 24px;
        border-bottom: 1px solid rgba(191, 201, 196, 0.1);
        vertical-align: middle;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        color: #1C1C18;
    }

    .santri-table tr:last-child td {
        border-bottom: none;
    }

    .profile-group {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .profile-initial {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 14px;
    }

    /* Avatar Colors */
    .avatar-bg-0 { background: #B0EFDA; color: #003227; }
    .avatar-bg-1 { background: #FFE088; color: #241A00; }
    .avatar-bg-2 { background: #E9E2D3; color: #1E1B13; }
    .avatar-bg-3 { background: #BFDBFE; color: #1E3A8A; }

    .profile-name {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 15px;
        color: #003227;
        margin: 0;
    }

    .profile-sub {
        font-size: 12px;
        color: #78716C;
        margin: 2px 0 0 0;
    }

    /* Attendance progress bar */
    .progress-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        width: 140px;
    }

    .progress-bar-bg {
        flex-grow: 1;
        background: #F6F3EC;
        height: 8px;
        border-radius: 9999px;
        overflow: hidden;
    }

    .progress-bar-fill {
        height: 100%;
        border-radius: 9999px;
    }

    .progress-text {
        font-weight: 700;
        font-size: 12px;
        color: #1C1C18;
        width: 32px;
    }

    /* Badges */
    .badge-status {
        display: inline-flex;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .badge-melanjutkan { background: #EFF6FF; color: #1D4ED8; }
    .badge-selesai { background: #ECFDF5; color: #047857; }
    .badge-belum { background: #FEF3C7; color: #D97706; }
    .badge-mengulang { background: #FEF2F2; color: #DC2626; }

    .badge-gender {
        display: inline-flex;
        padding: 4px 10px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-ikhwan { background: #EFF6FF; color: #1D4ED8; }
    .badge-akhwat { background: #FDF2F8; color: #DB2777; }

    /* Action button */
    .btn-detail {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 16px;
        background: #F6F3EC;
        color: #003227;
        font-weight: 700;
        font-size: 13px;
        border-radius: 9999px;
        text-decoration: none;
        transition: all 0.2s;
        border: 1px solid rgba(191, 201, 196, 0.3);
    }

    .btn-detail:hover {
        background: #003227;
        color: white;
        border-color: #003227;
    }

    .btn-detail .material-symbols-outlined {
        font-size: 16px;
    }

    .empty-state {
        padding: 48px;
        text-align: center;
        color: #78716C;
    }

    .empty-icon {
        font-size: 48px;
        color: #BFC9C4;
        margin-bottom: 16px;
    }
</style>
@endpush

@section('content')
<div class="content-canvas">
    <!-- Header -->
    <div class="page-header">
        <div>
            <div class="breadcrumb">
                <span>Dashboard</span>
                <span class="material-symbols-outlined" style="font-size: 16px;">chevron_right</span>
                <span class="breadcrumb-active">Perkembangan Santri</span>
            </div>
            <h1 class="header-title">Perkembangan Santri</h1>
            <p class="header-subtitle">Pantau seluruh progres kehadiran, hafalan, dan e-rapor santri</p>
        </div>
    </div>

    <!-- Stats Grid (Bento) -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Total Santri Aktif</span>
                <div class="stat-icon-wrapper santri">
                    <span class="material-symbols-outlined">group</span>
                </div>
            </div>
            <p class="stat-value">{{ $total_santri }}</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Rata-rata Kehadiran</span>
                <div class="stat-icon-wrapper attendance">
                    <span class="material-symbols-outlined">event_available</span>
                </div>
            </div>
            <p class="stat-value">{{ $avg_attendance }}%</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Progres Hafalan Diinput</span>
                <div class="stat-icon-wrapper hafalan">
                    <span class="material-symbols-outlined">menu_book</span>
                </div>
            </div>
            <p class="stat-value">{{ $total_hafalan_progress }}</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">E-Rapor Diterbitkan</span>
                <div class="stat-icon-wrapper raport">
                    <span class="material-symbols-outlined">school</span>
                </div>
            </div>
            <p class="stat-value">{{ $total_eraports }}</p>
        </div>
    </div>

    <!-- Table Card Box -->
    <div class="table-section">
        <div class="table-header-bar">
            <div class="table-title">
                <div class="title-indicator"></div>
                <span>Daftar Perkembangan Santri</span>
            </div>

            <form method="GET" action="{{ route('admin.santri.progress') }}" class="search-filter-form" id="filterForm">
                <div class="search-input-wrapper">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input type="text" id="searchInput" placeholder="Cari nama santri..." autocomplete="off" class="input-search">
                </div>

                <select name="id_kelas" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $c)
                        <option value="{{ $c->id_kelas }}" {{ $id_kelas == $c->id_kelas ? 'selected' : '' }}>
                            {{ $c->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        <div style="overflow-x: auto; width: 100%;">
            <table class="santri-table">
                <thead>
                    <tr>
                        <th>Santri</th>
                        <th>Kelas</th>
                        <th>Jenis Kelamin</th>
                        <th>Persentase Kehadiran</th>
                        <th>Hafalan Terakhir</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $index => $student)
                        @php
                            $avatarIndex = $student->id_santri % 4;
                            $initials = strtoupper(substr($student->nama, 0, 1));
                            
                            // Determine attendance color
                            $barColor = '#10B981'; // Green
                            if ($student->attendance_percentage < 75) {
                                $barColor = '#EF4444'; // Red
                            } elseif ($student->attendance_percentage < 90) {
                                $barColor = '#F59E0B'; // Amber
                            }
                        @endphp
                        <tr>
                            <td>
                                <div class="profile-group">
                                    <div class="profile-initial avatar-bg-{{ $avatarIndex }}">
                                        {{ $initials }}
                                    </div>
                                    <div>
                                        <p class="profile-name">{{ $student->nama }}</p>
                                        <p class="profile-sub">Wali: {{ $student->nama_wali }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span style="font-weight: 600; color: #003227;">{{ $student->kelas->nama_kelas ?? 'Tanpa Kelas' }}</span>
                            </td>
                            <td>
                                @if($student->jenis_kelamin === 'L')
                                    <span class="badge-gender badge-ikhwan">Ikhwan</span>
                                @else
                                    <span class="badge-gender badge-akhwat">Akhwat</span>
                                @endif
                            </td>
                            <td>
                                <div class="progress-wrapper">
                                    <div class="progress-bar-bg">
                                        <div class="progress-bar-fill" style="width: {{ $student->attendance_percentage }}%; background-color: {{ $barColor }};"></div>
                                    </div>
                                    <span class="progress-text">{{ $student->attendance_percentage }}%</span>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; flex-direction: column; gap: 4px;">
                                    <span style="font-weight: 500; font-size: 13px;">{{ $student->latest_capaian }}</span>
                                    @if($student->latest_status)
                                        <div>
                                            <span class="badge-status badge-{{ $student->latest_status }}">
                                                {{ $student->latest_status }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td style="text-align: right;">
                                <a href="{{ route('admin.santri.progress.show', $student->id_santri) }}" class="btn-detail">
                                    <span class="material-symbols-outlined">trending_up</span>
                                    <span>Lihat Progres</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <span class="material-symbols-outlined empty-icon">group</span>
                                    <p style="margin: 0; font-weight: 600; font-size: 16px;">Tidak ada data santri ditemukan</p>
                                    <p style="margin: 4px 0 0 0; font-size: 14px;">Silakan sesuaikan filter pencarian atau kelas Anda.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Real-time search filter for santri progress
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.santri-table tbody tr');
        
        rows.forEach(row => {
            let nameElement = row.querySelector('.profile-name');
            if (nameElement) {
                let name = nameElement.textContent || nameElement.innerText;
                if (name.toLowerCase().indexOf(filter) > -1) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            }
        });
    });
</script>
@endpush
