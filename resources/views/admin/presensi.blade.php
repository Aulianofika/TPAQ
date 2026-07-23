@extends('layouts.admin')

@section('title', 'Admin - Presensi Santri')

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
        width: 85%;
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

    .filter-btn {
        display: flex;
        align-items: center;
        padding: 12px 20px;
        background: #F6F3EC;
        border-radius: 48px;
        border: none;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 14px;
        color: #003227;
        gap: 8px;
        cursor: pointer;
    }

    .filter-btn .material-symbols-outlined {
        font-size: 18px;
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
</style>
@endpush

@section('content')
<div class="content-canvas">
    
    <!-- Page Header Section -->
    <div class="page-header">
        <div class="header-bg">
            <div class="header-pattern"></div>
            <div class="header-content">
                <div class="breadcrumb">
                    <span>Admin</span>
                    <span class="material-symbols-outlined" style="font-size: 14px;">chevron_right</span>
                    <span class="breadcrumb-active">Presensi Santri</span>
                </div>
                <h2 class="header-title">Presensi Santri</h2>
                <p class="header-subtitle">Kelola dan pantau kehadiran harian santri secara realtime.</p>
            </div>
        </div>

        <!-- Summary Bento Box -->
        <div class="summary-card">
            <div class="summary-top">
                <span class="summary-label">Hadir Hari Ini</span>
                <div class="summary-icon">
                    <span class="material-symbols-outlined" style="font-size: 18px;">how_to_reg</span>
                </div>
            </div>
            
            <div class="summary-bottom">
                <div class="summary-value-group">
                    <h3 class="summary-value">48</h3>
                    <span class="summary-unit">Santri</span>
                </div>
                <div class="summary-bar">
                    <div class="summary-progress"></div>
                </div>
                <p style="margin: 12px 0 0 0; font-family: 'Plus Jakarta Sans'; font-size: 12px; color: #574500;">
                    85% dari total 56 santri terdaftar
                </p>
            </div>
        </div>
    </div>

    <!-- Main Controls & List -->
    <div class="table-section">
        <div class="control-bar">
            <div class="filters">
                <button class="filter-btn">
                    <span class="material-symbols-outlined">calendar_today</span>
                    Hari Ini, {{ now()->format('d M Y') }}
                </button>
                <button class="filter-btn">
                    <span class="material-symbols-outlined">filter_list</span>
                    Semua Kelas
                </button>
            </div>
            <button class="primary-btn">
                <span class="material-symbols-outlined">save</span>
                Simpan Kehadiran
            </button>
        </div>

        <table class="attendance-table">
            <thead>
                <tr>
                    <th>Santri</th>
                    <th>Kelas</th>
                    <th style="text-align: center;">Status Kehadiran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Student 1 (Hadir) -->
                <tr>
                    <td>
                        <div class="student-profile">
                            <div class="student-avatar" style="background-image: url('https://ui-avatars.com/api/?name=Ahmad+Faisal&background=003227&color=fff');"></div>
                            <div class="student-info">
                                <p class="student-name">Ahmad Faisal</p>
                            </div>
                        </div>
                    </td>
                    <td><span class="class-badge">Tahfidz A</span></td>
                    <td style="text-align: center;">
                        <div class="status-group">
                            <button class="status-btn active-hadir">Hadir</button>
                            <button class="status-btn">Izin</button>
                            <button class="status-btn">Sakit</button>
                            <button class="status-btn">Alpa</button>
                        </div>
                    </td>
                    <td class="action-cell">
                        <button class="action-btn">
                            <span class="material-symbols-outlined">more_horiz</span>
                        </button>
                    </td>
                </tr>

                <!-- Student 2 (Izin) -->
                <tr>
                    <td>
                        <div class="student-profile">
                            <div class="student-avatar" style="background-image: url('https://ui-avatars.com/api/?name=Siti+Aisyah&background=003227&color=fff');"></div>
                            <div class="student-info">
                                <p class="student-name">Siti Aisyah</p>
                            
                            </div>
                        </div>
                    </td>
                    <td><span class="class-badge">Tahsin B</span></td>
                    <td style="text-align: center;">
                        <div class="status-group">
                            <button class="status-btn">Hadir</button>
                            <button class="status-btn active-izin">Izin</button>
                            <button class="status-btn">Sakit</button>
                            <button class="status-btn">Alpa</button>
                        </div>
                    </td>
                    <td class="action-cell">
                        <button class="action-btn">
                            <span class="material-symbols-outlined">more_horiz</span>
                        </button>
                    </td>
                </tr>

                <!-- Student 3 (Alpa) -->
                <tr>
                    <td>
                        <div class="student-profile">
                            <div class="student-avatar" style="background-image: url('https://ui-avatars.com/api/?name=Muhammad+Rizky&background=003227&color=fff');"></div>
                            <div class="student-info">
                                <p class="student-name">Muhammad Rizky</p>
                                
                            </div>
                        </div>
                    </td>
                    <td><span class="class-badge">Reguler C</span></td>
                    <td style="text-align: center;">
                        <div class="status-group">
                            <button class="status-btn">Hadir</button>
                            <button class="status-btn">Izin</button>
                            <button class="status-btn">Sakit</button>
                            <button class="status-btn active-alpa">Alpa</button>
                        </div>
                    </td>
                    <td class="action-cell">
                        <button class="action-btn">
                            <span class="material-symbols-outlined">more_horiz</span>
                        </button>
                    </td>
                </tr>

                <!-- Student 4 (Hadir) -->
                <tr>
                    <td>
                        <div class="student-profile">
                            <div class="student-avatar" style="background-image: url('https://ui-avatars.com/api/?name=Fatimah+Zahra&background=003227&color=fff');"></div>
                            <div class="student-info">
                                <p class="student-name">Fatimah Zahra</p>
                                
                            </div>
                        </div>
                    </td>
                    <td><span class="class-badge">Tahfidz A</span></td>
                    <td style="text-align: center;">
                        <div class="status-group">
                            <button class="status-btn active-hadir">Hadir</button>
                            <button class="status-btn">Izin</button>
                            <button class="status-btn">Sakit</button>
                            <button class="status-btn">Alpa</button>
                        </div>
                    </td>
                    <td class="action-cell">
                        <button class="action-btn">
                            <span class="material-symbols-outlined">more_horiz</span>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="pagination">
            <span class="pagination-text">Menampilkan 1-4 dari 56 Santri</span>
            <div class="pagination-controls">
                <button class="page-btn"><span class="material-symbols-outlined" style="font-size: 16px;">chevron_left</span></button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn"><span class="material-symbols-outlined" style="font-size: 16px;">chevron_right</span></button>
            </div>
        </div>
    </div>
</div>
@endsection
