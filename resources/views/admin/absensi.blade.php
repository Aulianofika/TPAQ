@extends('layouts.admin')

@section('title', 'Admin - Absensi Santri')
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

    .stat-icon-wrapper.hadir { background: #ECFDF5; color: #10B981; }
    .stat-icon-wrapper.izin { background: #EFF6FF; color: #3B82F6; }
    .stat-icon-wrapper.sakit { background: #FFFBEB; color: #F59E0B; }
    .stat-icon-wrapper.alpa { background: #FEF2F2; color: #EF4444; }

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
        width: 180px;
        transition: all 0.3s ease;
    }

    .input-search:focus {
        border-color: #003227;
        background: #FFFFFF;
        width: 240px;
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
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-submit:hover {
        background: #065F46;
        transform: translateY(-1px);
    }

    /* Table Styles */
    .attendance-table {
        width: 100%;
        border-collapse: collapse;
    }

    .attendance-table th {
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

    .attendance-table td {
        padding: 20px 24px;
        border-bottom: 1px solid rgba(191, 201, 196, 0.1);
        vertical-align: middle;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        color: #1C1C18;
    }

    .attendance-table tr:last-child td {
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

    /* Status Controls */
    .status-group {
        display: inline-flex;
        background: #F1EEE7;
        border-radius: 16px;
        padding: 4px;
        gap: 4px;
    }

    .status-btn {
        padding: 8px 16px;
        border-radius: 48px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 12px;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        color: #78716C;
        background: transparent;
    }

    .status-btn.active-hadir {
        background: #003227;
        color: #FFFFFF;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
    }

    .status-btn.active-izin {
        background: #F59E0B; /* Match Sakit/Izin theme */
        color: #FFFFFF;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
    }
    
    .status-btn.active-sakit {
        background: #D97706; /* slightly different from Izin if needed, or same */
        color: #FFFFFF;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
    }

    .status-btn.active-alpa {
        background: #DC2626; /* Match Alfa theme */
        color: #FFFFFF;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
    }

    .status-btn:hover:not([class*="active-"]) {
        background: rgba(0, 0, 0, 0.05);
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
    
    /* Notification */
    .alert {
        padding: 16px 24px; 
        border-radius: 16px; 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        font-weight: 600; 
        margin-bottom: 24px; 
        display: inline-flex; 
        width: fit-content;
        align-items: center; 
        gap: 8px;
    }
    
    .alert-success {
        background-color: #D1FAE5; 
        border: 1px solid #10B981; 
        color: #065F46; 
    }
    
    .alert-error {
        background-color: #FEE2E2; 
        border: 1px solid #EF4444; 
        color: #991B1B; 
    }
</style>
@endpush

@section('content')
<div class="content-canvas">

    @if(session('success'))
        <div class="alert alert-success">
            <span class="material-symbols-outlined" style="font-size: 20px;">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <span class="material-symbols-outlined" style="font-size: 20px;">error</span>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error">
            <span class="material-symbols-outlined" style="font-size: 20px;">error</span>
            {{ $errors->first() }}
        </div>
    @endif
    
    <!-- Header -->
    <div class="page-header">
        <div>
            <div class="breadcrumb">
                <span>Dashboard</span>
                <span class="material-symbols-outlined" style="font-size: 16px;">chevron_right</span>
                <span class="breadcrumb-active">Input Absensi</span>
            </div>
            <h1 class="header-title">Input Absensi</h1>
            <p class="header-subtitle">Kelola dan pantau kehadiran harian santri secara realtime</p>
        </div>
    </div>

    <!-- Stats Grid (Bento) -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Hadir</span>
                <div class="stat-icon-wrapper hadir">
                    <span class="material-symbols-outlined">how_to_reg</span>
                </div>
            </div>
            <p class="stat-value">{{ $present_count }}</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Izin</span>
                <div class="stat-icon-wrapper izin">
                    <span class="material-symbols-outlined">mail</span>
                </div>
            </div>
            <p class="stat-value">{{ $izin_count }}</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Sakit</span>
                <div class="stat-icon-wrapper sakit">
                    <span class="material-symbols-outlined">local_hospital</span>
                </div>
            </div>
            <p class="stat-value">{{ $sakit_count }}</p>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <span class="stat-label">Alpa</span>
                <div class="stat-icon-wrapper alpa">
                    <span class="material-symbols-outlined">person_off</span>
                </div>
            </div>
            <p class="stat-value">{{ $alfa_count }}</p>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-section">
        <div class="table-header-bar">
            <div class="table-title">
                <div class="title-indicator"></div>
                <span>Daftar Santri</span>
            </div>

            <!-- Filter Form -->
            <form id="filterForm" method="GET" action="{{ route('admin.absensi') }}" class="search-filter-form">
                <div class="search-input-wrapper">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input type="text" id="searchInput" placeholder="Cari nama santri..." autocomplete="off" class="input-search">
                </div>

                <input type="date" name="tanggal" value="{{ $selected_date }}" max="{{ date('Y-m-d') }}" class="filter-select" onchange="document.getElementById('filterForm').submit()">

                <select name="id_kelas" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="semua" @selected($selected_class_id == 'semua')>Semua Tingkat</option>
                    @foreach(collect($classes) as $kls)
                        <option value="{{ $kls->id_kelas }}" @selected($selected_class_id == $kls->id_kelas)>
                            {{ $kls->nama_kelas }}
                        </option>
                    @endforeach
                </select>
                
                <button type="button" class="btn-submit" onclick="document.getElementById('attendanceForm').submit()">
                    <span class="material-symbols-outlined" style="font-size: 18px;">save</span>
                    Simpan
                </button>
            </form>
        </div>

        <form id="attendanceForm" method="POST" action="{{ route('admin.absensi.store') }}">
            @csrf
            <input type="hidden" name="tanggal" value="{{ $selected_date }}">

            <div style="overflow-x: auto; width: 100%;">
                <table class="attendance-table">
                    <thead>
                        <tr>
                            <th>Santri</th>
                            <th>Kelas</th>
                            <th style="text-align: center;">Status Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $student)
                            @php
                                $status = $existing_attendance->has($student->id_santri) ? $existing_attendance[$student->id_santri]->status : 'hadir';
                                $avatarIndex = $student->id_santri % 4;
                                $initials = strtoupper(substr($student->nama, 0, 1));
                            @endphp
                            <tr>
                                <td>
                                    <div class="profile-group">
                                        <div class="profile-initial avatar-bg-{{ $avatarIndex }}">
                                            {{ $initials }}
                                        </div>
                                        <div>
                                            <p class="profile-name">{{ $student->nama }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span style="font-weight: 600; color: #003227;">{{ $student->kelas->nama_kelas ?? 'Tanpa Kelas' }}</span>
                                </td>
                                <td style="text-align: center;">
                                    <!-- Hidden input storing the status value -->
                                    <input type="hidden" name="attendance[{{ $student->id_santri }}]" id="status-{{ $student->id_santri }}" value="{{ $status }}">

                                    @php
                                        $onHadir = 'onclick="selectStatus(' . $student->id_santri . ', \'hadir\', this)"';
                                        $onIzin = 'onclick="selectStatus(' . $student->id_santri . ', \'izin\', this)"';
                                        $onSakit = 'onclick="selectStatus(' . $student->id_santri . ', \'sakit\', this)"';
                                        $onAlfa = 'onclick="selectStatus(' . $student->id_santri . ', \'alfa\', this)"';
                                    @endphp
                                    <div class="status-group" data-student-id="{{ $student->id_santri }}">
                                        <button type="button" class="status-btn {{ $status == 'hadir' ? 'active-hadir' : '' }}" {!! $onHadir !!}>Hadir</button>
                                        <button type="button" class="status-btn {{ $status == 'izin' ? 'active-izin' : '' }}" {!! $onIzin !!}>Izin</button>
                                        <button type="button" class="status-btn {{ $status == 'sakit' ? 'active-sakit' : '' }}" {!! $onSakit !!}>Sakit</button>
                                        <button type="button" class="status-btn {{ $status == 'alfa' ? 'active-alpa' : '' }}" {!! $onAlfa !!}>Alpa</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="empty-row">
                                <td colspan="3">
                                    <div class="empty-state">
                                        <span class="material-symbols-outlined empty-icon">group</span>
                                        <p style="margin: 0; font-weight: 600; font-size: 16px;">Tidak ada data santri ditemukan</p>
                                        <p style="margin: 4px 0 0 0; font-size: 14px;">Silakan sesuaikan filter pencarian atau kelas Anda.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        <tr id="noSearchResult" style="display: none;">
                            <td colspan="3">
                                <div class="empty-state">
                                    <span class="material-symbols-outlined empty-icon">search_off</span>
                                    <p style="margin: 0; font-weight: 600; font-size: 16px;">Data Santri tidak ditemukan</p>
                                    <p style="margin: 4px 0 0 0; font-size: 14px;">Tidak ada santri yang cocok dengan kata kunci pencarian Anda.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function selectStatus(studentId, status, buttonEl) {
        // Update input hidden
        document.getElementById('status-' + studentId).value = status;
        
        // Clear active states on all buttons in this row
        const group = buttonEl.closest('.status-group');
        const buttons = group.querySelectorAll('.status-btn');
        buttons.forEach(btn => {
            btn.classList.remove('active-hadir', 'active-izin', 'active-sakit', 'active-alpa');
        });
        
        // Add specific active class
        if (status === 'hadir') {
            buttonEl.classList.add('active-hadir');
        } else if (status === 'izin') {
            buttonEl.classList.add('active-izin');
        } else if (status === 'sakit') {
            buttonEl.classList.add('active-sakit');
        } else if (status === 'alfa') {
            buttonEl.classList.add('active-alpa');
        }
    }

    // Real-time search filter
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.attendance-table tbody tr:not(#noSearchResult):not(.empty-row)');
        let visibleCount = 0;
        
        rows.forEach(row => {
            let nameElement = row.querySelector('.profile-name');
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
</script>
@endpush
