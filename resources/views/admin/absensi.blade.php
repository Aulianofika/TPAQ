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
        max-width: 1280px;
    }

    /* Page Header Section */
    .page-header {
        position: relative;
        width: 100%;
        height: 244px;
        display: flex;
        justify-content: space-between;
    }

    /* Header Background */
    .header-bg {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        right: 328px; /* Leave space for the yellow card */
        background: #003227;
        border-radius: 48px;
        padding: 48px 48px 32px 48px;
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        overflow: hidden;
    }

    .header-pattern {
        position: absolute;
        right: 0;
        top: 0;
        width: 256px;
        height: 256px;
        opacity: 0.1;
        background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0);
        background-size: 20px 20px;
    }

    .header-content {
        position: relative;
        z-index: 2;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: 'Manrope', sans-serif;
        font-size: 12px;
        color: #7CBAA6;
        margin-bottom: 8px;
    }

    .breadcrumb-active {
        color: #FFFFFF;
    }

    .header-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: 36px;
        line-height: 40px;
        color: #FFFFFF;
        margin: 0 0 8px 0;
        letter-spacing: -0.9px;
    }

    .header-subtitle {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 16px;
        color: #7CBAA6;
        margin: 0;
    }

    /* Summary Bento Card (Yellow) */
    .summary-card {
        position: absolute;
        right: 0;
        top: 0;
        height: 238px;
        width: 300px;
        background: #FED65B;
        border-radius: 48px;
        padding: 32px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0px 10px 15px -3px rgba(254, 214, 91, 0.2);
    }

    .summary-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .summary-label {
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 12px;
        color: #745C00;
        text-transform: uppercase;
        letter-spacing: 0.6px;
    }

    .summary-icon {
        width: 34px;
        height: 34px;
        background: rgba(255, 255, 255, 0.4);
        border-radius: 32px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #735C00;
    }

    .summary-value-group {
        display: flex;
        align-items: baseline;
        gap: 8px;
    }

    .summary-value {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: 48px;
        color: #241A00;
        margin: 0;
    }

    .summary-unit {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 500;
        font-size: 16px;
        color: #574500;
    }

    .summary-bar {
        width: 100%;
        height: 8px;
        background: rgba(36, 26, 0, 0.1);
        border-radius: 9999px;
        overflow: hidden;
        margin-top: 16px;
    }

    .summary-progress {
        height: 100%;
        background: #241A00;
        border-radius: 9999px;
    }

    /* Main Table Container */
    .table-section {
        background: #FFFFFF;
        border-radius: 48px;
        overflow: hidden;
        border: 1px solid #F5F5F4;
    }

    /* Control Bar */
    .control-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px 32px;
        border-bottom: 1px solid #F5F5F4;
        background: #FFFFFF;
    }

    .filters {
        display: flex;
        gap: 16px;
    }

    .filter-wrapper {
        position: relative;
        background: #F6F3EC;
        border-radius: 48px;
        padding: 0 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .filter-input {
        border: none;
        background: transparent;
        height: 48px;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 14px;
        color: #003227;
        cursor: pointer;
        outline: none;
        padding-right: 12px;
    }

    .filter-input option {
        font-weight: normal;
        color: #003227;
        background: #F6F3EC;
    }

    .primary-btn {
        display: flex;
        align-items: center;
        padding: 12px 24px;
        background: #003227;
        border-radius: 9999px;
        border: none;
        color: #FFFFFF;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 14px;
        gap: 8px;
        cursor: pointer;
        box-shadow: 0px 4px 6px -4px rgba(0, 50, 39, 0.2);
        transition: all 0.3s ease;
    }

    .primary-btn:hover {
        background: #065F46;
        transform: translateY(-1px);
    }

    /* Table Styles */
    .attendance-table {
        width: 100%;
        border-collapse: collapse;
    }

    .attendance-table th {
        background: rgba(246, 243, 236, 0.5);
        padding: 16px 32px;
        text-align: left;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 12px;
        color: #404945;
        text-transform: uppercase;
        letter-spacing: 1.2px;
    }

    .attendance-table th:last-child {
        text-align: right;
    }

    .attendance-table td {
        padding: 24px 32px;
        border-bottom: 1px solid #F5F5F4;
        vertical-align: middle;
    }

    /* Student Profile in Table */
    .student-profile {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .student-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background-color: #E5E7EB;
        background-size: cover;
        background-position: center;
    }

    .student-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .student-name {
        font-family: 'Epilogue', sans-serif;
        font-weight: 700;
        font-size: 16px;
        color: #064E3B;
        margin: 0;
    }



    /* Class Badge */
    .class-badge {
        display: inline-flex;
        padding: 6px 12px;
        background: #B0EFDA;
        color: #0A5041;
        border-radius: 9999px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 500;
        font-size: 12px;
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
        background: #FED65B;
        color: #745C00;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
    }

    .status-btn.active-alpa {
        background: #BA1A1A;
        color: #FFFFFF;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
    }

    .status-btn:hover:not([class*="active-"]) {
        background: rgba(0, 0, 0, 0.05);
    }

    /* Action Cell */
    .action-cell {
        text-align: right;
    }

    .action-btn {
        background: transparent;
        border: none;
        color: #A8A29E;
        cursor: pointer;
        padding: 4px;
    }

    .action-btn:hover {
        color: #404945;
    }

    /* Pagination */
    .pagination {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px 32px;
        background: #F6F3EC;
    }

    .pagination-text {
        font-family: 'Manrope', sans-serif;
        font-size: 14px;
        color: #78716C;
    }

    .pagination-controls {
        display: flex;
        gap: 8px;
    }

    .page-btn {
        width: 40px;
        height: 40px;
        border-radius: 48px;
        background: #FFFFFF;
        border: none;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 14px;
        color: #57534E;
        cursor: pointer;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
    }

    .page-btn.active {
        background: #003227;
        color: #FFFFFF;
    }

    .page-btn:hover:not(.active) {
        background: #F3F4F6;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        width: 100%;
        margin-bottom: 24px;
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
        border-radius: 20px;
        padding: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: 1px solid rgba(0, 0, 0, 0.04);
        box-shadow: 0px 10px 15px -3px rgba(0, 0, 0, 0.02), 0px 4px 6px -2px rgba(0, 0, 0, 0.02);
        transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0px 20px 25px -5px rgba(0, 50, 39, 0.06), 0px 10px 10px -5px rgba(0, 50, 39, 0.03);
    }

    /* Left border accents for cards */
    .stat-card.card-hadir { border-left: 4px solid #10B981; }
    .stat-card.card-izin { border-left: 4px solid #3B82F6; }
    .stat-card.card-sakit { border-left: 4px solid #F59E0B; }
    .stat-card.card-alpa { border-left: 4px solid #EF4444; }

    .stat-icon-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 46px;
        height: 46px;
        border-radius: 14px;
        transition: transform 0.2s ease;
    }

    .stat-card:hover .stat-icon-wrapper {
        transform: scale(1.08);
    }

    .stat-icon-wrapper.hadir { background: #ECFDF5; color: #10B981; }
    .stat-icon-wrapper.izin { background: #EFF6FF; color: #3B82F6; }
    .stat-icon-wrapper.sakit { background: #FFFBEB; color: #F59E0B; }
    .stat-icon-wrapper.alpa { background: #FEF2F2; color: #EF4444; }

    .stat-label-group {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
    }

    .status-dot.hadir { background-color: #10B981; }
    .status-dot.izin { background-color: #3B82F6; }
    .status-dot.sakit { background-color: #F59E0B; }
    .status-dot.alpa { background-color: #EF4444; }

    .stat-label {
        font-family: 'Manrope', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: #78716C;
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .stat-value {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: 32px;
        color: #003227;
        margin: 6px 0 0 0;
        line-height: 1.1;
    }
</style>
@endpush

@section('content')
<div class="content-canvas">

    @if(session('success'))
        <div style="background-color: #D1FAE5; border: 1px solid #10B981; color: #065F46; padding: 16px 24px; border-radius: 16px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
            <span class="material-symbols-outlined" style="font-size: 20px;">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background-color: #FEE2E2; border: 1px solid #EF4444; color: #991B1B; padding: 16px 24px; border-radius: 16px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; margin-bottom: 24px; display: flex; align-items: center; gap: 8px;">
            <span class="material-symbols-outlined" style="font-size: 20px;">error</span>
            {{ session('error') }}
        </div>
    @endif
    
    <!-- Page Header Section -->
    <div class="page-header" style="margin-bottom: 16px;">
        <div class="header-bg" style="flex: 1; width: 100%;">
            <div class="header-pattern"></div>
            <div class="header-content">
                <div class="breadcrumb">
                    <span>Admin</span>
                    <span class="material-symbols-outlined" style="font-size: 14px;">chevron_right</span>
                    <span class="breadcrumb-active">Absensi Santri</span>
                </div>
                <h2 class="header-title">Absensi Santri</h2>
                <p class="header-subtitle">Kelola dan pantau kehadiran harian santri secara realtime.</p>
            </div>
        </div>
    </div>

    <!-- Metrics Grid - Dashboard Style -->
    <div class="stats-grid">
        <!-- Hadir -->
        <div class="stat-card card-hadir">
            <div>
                <div class="stat-label-group">
                    <span class="status-dot hadir"></span>
                    <p class="stat-label">Hadir</p>
                </div>
                <h3 class="stat-value">{{ $present_count }}</h3>
            </div>
            <div class="stat-icon-wrapper hadir">
                <span class="material-symbols-outlined" style="font-size: 22px;">how_to_reg</span>
            </div>
        </div>

        <!-- Izin -->
        <div class="stat-card card-izin">
            <div>
                <div class="stat-label-group">
                    <span class="status-dot izin"></span>
                    <p class="stat-label">Izin</p>
                </div>
                <h3 class="stat-value">{{ $izin_count }}</h3>
            </div>
            <div class="stat-icon-wrapper izin">
                <span class="material-symbols-outlined" style="font-size: 22px;">mail</span>
            </div>
        </div>

        <!-- Sakit -->
        <div class="stat-card card-sakit">
            <div>
                <div class="stat-label-group">
                    <span class="status-dot sakit"></span>
                    <p class="stat-label">Sakit</p>
                </div>
                <h3 class="stat-value">{{ $sakit_count }}</h3>
            </div>
            <div class="stat-icon-wrapper sakit">
                <span class="material-symbols-outlined" style="font-size: 22px;">local_hospital</span>
            </div>
        </div>

        <!-- Alpa -->
        <div class="stat-card card-alpa">
            <div>
                <div class="stat-label-group">
                    <span class="status-dot alpa"></span>
                    <p class="stat-label">Alpa</p>
                </div>
                <h3 class="stat-value">{{ $alfa_count }}</h3>
            </div>
            <div class="stat-icon-wrapper alpa">
                <span class="material-symbols-outlined" style="font-size: 22px;">person_off</span>
            </div>
        </div>
    </div>

    <!-- Main Controls & List -->
    <div class="table-section">
        <div class="control-bar">
            <!-- Filter Form -->
            <form id="filterForm" method="GET" action="{{ route('admin.absensi') }}" class="filters">
                <div class="filter-wrapper">
                    <span class="material-symbols-outlined" style="color: #003227; font-size: 18px;">search</span>
                    <input type="text" id="searchInput" placeholder="Cari nama santri..." class="filter-input" style="width: 160px;" autocomplete="off">
                </div>
                <div class="filter-wrapper">
                    <span class="material-symbols-outlined" style="color: #003227; font-size: 18px;">calendar_today</span>
                    <input type="date" name="tanggal" value="{{ $selected_date }}" max="{{ date('Y-m-d') }}" class="filter-input" onchange="document.getElementById('filterForm').submit()">
                </div>
                <div class="filter-wrapper">
                    <span class="material-symbols-outlined" style="color: #003227; font-size: 18px;">filter_list</span>
                    <select name="id_kelas" class="filter-input" onchange="document.getElementById('filterForm').submit()">
                        <option value="semua" @selected($selected_class_id == 'semua')>Semua Tingkat</option>
                        @foreach(collect($classes) as $kls)
                            <option value="{{ $kls->id_kelas }}" 
                            @selected($selected_class_id == $kls->id_kelas)>
                                {{ $kls->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
            
            <!-- Submit button for the actual attendance updates -->
            <button type="button" class="primary-btn" onclick="document.getElementById('attendanceForm').submit()">
                <span class="material-symbols-outlined">save</span>
                Simpan
            </button>
        </div>

        <form id="attendanceForm" method="POST" action="{{ route('admin.absensi.store') }}">
            @csrf
            <input type="hidden" name="tanggal" value="{{ $selected_date }}">

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
                        @endphp
                        <tr>
                            <td>
                                <div class="student-profile">
                                    <div class="student-avatar" style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode($student->nama) }}&background=003227&color=fff');"></div>
                                    <div class="student-info">
                                        <p class="student-name">{{ $student->nama }}</p>

                                    </div>
                                </div>
                            </td>
                            <td><span class="class-badge">{{ $student->kelas->nama_kelas ?? '-' }}</span></td>
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
                                    <button type="button" class="status-btn {{ $status == 'sakit' ? 'active-izin' : '' }}" {!! $onSakit !!}>Sakit</button>
                                    <button type="button" class="status-btn {{ $status == 'alfa' ? 'active-alpa' : '' }}" {!! $onAlfa !!}>Alpa</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: #78716C; padding: 48px; font-family: 'Plus Jakarta Sans', sans-serif;">
                                Tidak ada data santri untuk kelas ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </form>

        <!-- Pagination -->
        <div class="pagination">
            <span class="pagination-text">Menampilkan 1-{{ $total_students }} dari {{ $total_students }} Santri</span>
            <div class="pagination-controls">
                <button class="page-btn"><span class="material-symbols-outlined" style="font-size: 16px;">chevron_left</span></button>
                <button class="page-btn active">1</button>
                <button class="page-btn"><span class="material-symbols-outlined" style="font-size: 16px;">chevron_right</span></button>
            </div>
        </div>
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
            btn.classList.remove('active-hadir', 'active-izin', 'active-alpa');
        });
        
        // Add specific active class
        if (status === 'hadir') {
            buttonEl.classList.add('active-hadir');
        } else if (status === 'izin' || status === 'sakit') {
            buttonEl.classList.add('active-izin');
        } else if (status === 'alfa') {
            buttonEl.classList.add('active-alpa');
        }
    }

    // Real-time search filter
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.attendance-table tbody tr');
        
        rows.forEach(row => {
            let nameElement = row.querySelector('.student-name');
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
