@extends('layouts.admin')

@section('title', 'Admin - Data Santri')

@push('styles')
<style>
    /* Content Layout */
    .content-canvas {
        display: flex;
        flex-direction: column;
        gap: 32px;
        width: 100%;
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

    .primary-btn {
        display: flex;
        align-items: center;
        padding: 16px 32px;
        background: #003227;
        border-radius: 9999px;
        border: none;
        color: #FFFFFF;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 16px;
        gap: 8px;
        cursor: pointer;
        box-shadow: 0px 10px 15px -3px rgba(6, 78, 59, 0.2);
        transition: all 0.3s ease;
    }

    .primary-btn:hover {
        background: #065F46;
        transform: translateY(-2px);
    }

    /* Content Canvas */
    .content-canvas {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        padding: 32px;
        gap: 40px;
        width: 100%;
    }

    /* Stats Grid */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
        width: 100%;
        margin-bottom: 10px;
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

    .stat-icon-wrapper.santri { background: #10B981; color: #FFFFFF; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); }
    .stat-icon-wrapper.aktif { background: #F59E0B; color: #FFFFFF; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); }
    .stat-icon-wrapper.ikhwan { background: #3B82F6; color: #FFFFFF; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3); }
    .stat-icon-wrapper.akhwat { background: #EC4899; color: #FFFFFF; box-shadow: 0 4px 12px rgba(236, 72, 153, 0.3); }

    .stat-trend {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 12px;
        color: #059669;
    }

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
    }

    .table-header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 32px;
        border-bottom: 1px solid rgba(191, 201, 196, 0.1);
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
        padding: 8px 16px 8px 40px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        color: #57534E;
        outline: none;
        width: 200px;
        transition: all 0.3s ease;
    }

    .input-search:focus {
        border-color: #003227;
        width: 250px;
    }

    .filter-select {
        background: #FFFFFF;
        border: 1px solid #BFC9C4;
        border-radius: 9999px;
        padding: 8px 16px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        color: #57534E;
        outline: none;
        cursor: pointer;
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
        font-weight: 600;
        font-size: 12px;
        color: #78716C;
        text-transform: uppercase;
        letter-spacing: 1.2px;
    }

    .santri-table td {
        padding: 20px 24px;
        border-bottom: 1px solid rgba(191, 201, 196, 0.1);
        vertical-align: middle;
    }

    /* Student Profile Group */
    .profile-group {
        display: flex;
        align-items: center;
        gap: 12px;
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
    }

    /* Dynamic Avatar Colors based on Figma */
    .avatar-bg-0 { background: #B0EFDA; color: #003227; }
    .avatar-bg-1 { background: #FFE088; color: #241A00; }
    .avatar-bg-2 { background: #E9E2D3; color: #1E1B13; }
    .avatar-bg-3 { background: #95D3BF; color: #002019; }

    .profile-name {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 16px;
        color: #064E3B;
        margin: 0;
    }

    .text-data {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        color: #1C1C18;
        margin: 0;
    }

    .text-data-muted {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        color: #78716C;
        margin: 0;
    }

    /* Badges */
    .badge {
        display: inline-flex;
        padding: 4px 12px;
        border-radius: 9999px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: -0.25px;
    }

    .badge-aktif {
        background: #D1FAE5;
        color: #047857;
    }

    .badge-mutasi {
        background: #FEF3C7;
        color: #B45309;
    }

    .badge-lulus {
        background: #DBEAFE;
        color: #1D4ED8;
    }

    .badge-non-aktif {
        background: #E5E7EB;
        color: #4B5563;
    }

    /* Actions */
    .actions-cell {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .action-btn {
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

    .action-btn:hover {
        background: #F3F4F6;
        color: #1F2937;
    }

    .action-btn.btn-delete:hover {
        background: #FEE2E2;
        color: #EF4444;
    }

    /* Pagination */
    .pagination-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 24px 32px;
        border-top: 1px solid rgba(191, 201, 196, 0.1);
    }

    /* Custom Modal styles */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 50, 39, 0.5);
        backdrop-filter: blur(4px);
        z-index: 100;
        display: none;
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.2s ease-out forwards;
    }

    .modal-container {
        background: #FFFFFF;
        width: 100%;
        max-width: 560px;
        border-radius: 40px;
        padding: 40px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        position: relative;
        animation: slideUp 0.3s ease-out forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideUp {
        from { transform: translateY(30px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 24px;
    }

    .modal-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: 24px;
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
        padding: 4px;
        border-radius: 50%;
        transition: background 0.2s;
    }

    .modal-close:hover {
        background: #F3F4F6;
        color: #1F2937;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 16px;
    }

    .form-group-full {
        grid-column: span 2;
    }

    .form-label {
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 13px;
        color: #003227;
    }

    .form-control {
        background: #F9FAFB;
        border: 1px solid #E5E7EB;
        border-radius: 12px;
        padding: 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        color: #1F2937;
        outline: none;
        transition: border-color 0.2s;
    }

    .form-control:focus {
        border-color: #003227;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 24px;
    }

    .cancel-btn {
        background: transparent;
        border: 1px solid #D1D5DB;
        color: #4B5563;
        padding: 12px 24px;
        border-radius: 9999px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .cancel-btn:hover {
        background: #F9FAFB;
    }

    .save-btn {
        background: #003227;
        border: none;
        color: #FFFFFF;
        padding: 12px 24px;
        border-radius: 9999px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        box-shadow: 0px 4px 6px -4px rgba(0, 50, 39, 0.2);
        transition: background 0.2s;
    }

    .save-btn:hover {
        background: #065F46;
    }

    /* ===========================
       RESPONSIVE DESIGN
    =========================== */
    @media (max-width: 1024px) {
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }
        .search-filter-form {
            flex-wrap: wrap;
        }
    }

    @media (max-width: 768px) {
        .content-canvas {
            padding: 16px;
            gap: 24px;
        }
        
        .header-title {
            font-size: 28px;
            line-height: 32px;
        }
        
        .primary-btn {
            width: 100%;
            justify-content: center;
        }

        .table-header-bar {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
            padding: 24px 16px;
        }

        .search-filter-form {
            flex-direction: column;
            width: 100%;
            align-items: stretch;
            gap: 8px;
        }

        .search-input-wrapper {
            width: 100%;
        }

        .input-search {
            width: 100%;
            box-sizing: border-box;
        }

        .input-search:focus {
            width: 100%;
        }

        .filter-select {
            width: 100%;
            box-sizing: border-box;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            width: 100%;
        }

        .santri-table th, .santri-table td {
            padding: 16px;
            white-space: nowrap;
        }

        .pagination-bar {
            flex-direction: column;
            gap: 16px;
            text-align: center;
            padding: 16px;
        }

        .form-grid {
            grid-template-columns: 1fr;
        }

        .form-group-full {
            grid-column: span 1;
        }

        .modal-container {
            padding: 24px;
            margin: 16px;
            max-height: 90vh;
            overflow-y: auto;
        }
    }
</style>
@endpush

@section('content')
<div class="content-canvas">

    @if(session('success'))
        <div style="background-color: #D1FAE5; border: 1px solid #10B981; color: #065F46; padding: 16px 24px; border-radius: 16px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            <span class="material-symbols-outlined" style="font-size: 20px;">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    <!-- Page Header Section -->
    <div class="page-header">
        <div>
            <div class="breadcrumb">
                <span>Admin</span>
                <span class="material-symbols-outlined" style="font-size: 14px;">chevron_right</span>
                <span class="breadcrumb-active">Data Santri</span>
            </div>
            <h2 class="header-title">Data Santri</h2>
            <p class="header-subtitle">Kelola informasi santri, pendaftaran kelas, wali murid, dan status keaktifan.</p>
        </div>
        <button class="primary-btn" onclick="openAddModal()">
            <span class="material-symbols-outlined" style="font-size: 20px;">person_add</span>
            Tambah Santri
        </button>
    </div>

    <!-- Stats Overview - Dashboard Style -->
    <div class="stats-grid">
        <!-- TOTAL SANTRI -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon-wrapper santri">
                    <span class="material-symbols-outlined">group</span>
                </div>
                <span class="stat-trend up">Total</span>
            </div>
            <div>
                <p class="stat-label">Total Santri</p>
                <h3 class="stat-value">{{ $total_santri }}</h3>
            </div>
        </div>

        <!-- SANTRI AKTIF -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon-wrapper aktif">
                    <span class="material-symbols-outlined">how_to_reg</span>
                </div>
                <span class="stat-trend up">Aktif</span>
            </div>
            <div>
                <p class="stat-label">Santri Aktif</p>
                <h3 class="stat-value">{{ $aktif_count }}</h3>
            </div>
        </div>

        <!-- IKHWAN (L) -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon-wrapper ikhwan">
                    <span class="material-symbols-outlined">male</span>
                </div>
                <span class="stat-trend up">Total</span>
            </div>
            <div>
                <p class="stat-label">Ikhwan (L)</p>
                <h3 class="stat-value">{{ $ikhwan_count }}</h3>
            </div>
        </div>

        <!-- AKHWAT (P) -->
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon-wrapper akhwat">
                    <span class="material-symbols-outlined">female</span>
                </div>
                <span class="stat-trend up">Total</span>
            </div>
            <div>
                <p class="stat-label">Akhwat (P)</p>
                <h3 class="stat-value">{{ $akhwat_count }}</h3>
            </div>
        </div>
    </div>
    <!-- Table Section -->
    <div class="table-section">
        <div class="table-header-bar">
            <div class="table-title">
                <div class="title-indicator"></div>
                <span>Daftar Santri</span>
            </div>
            <!-- Search & Filters -->
            <form method="GET" action="{{ route('admin.santri.index') }}" class="search-filter-form" id="filterForm">
                <div class="search-input-wrapper">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input type="text" id="searchInput" placeholder="Cari santri..." autocomplete="off" class="input-search">
                </div>
                <select name="id_kelas" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id_kelas }}" {{ request('id_kelas') == $class->id_kelas ? 'selected' : '' }}>{{ $class->nama_kelas }}</option>
                    @endforeach
                </select>
                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="mutasi" {{ request('status') == 'mutasi' ? 'selected' : '' }}>Mutasi</option>
                    <option value="lulus" {{ request('status') == 'lulus' ? 'selected' : '' }}>Lulus</option>
                    <option value="non-aktif" {{ request('status') == 'non-aktif' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </form>
        </div>

        <div class="table-responsive">
            <table class="santri-table iuran-table" id="santriTable">
            <thead>
                <tr>
                    <th style="padding-left: 32px;">Nama Santri</th>
                    <th>Kelas</th>
                    <th>Wali</th>
                    <th>No. HP Wali</th>
                    <th>Status</th>
                    <th style="text-align: center; padding-right: 32px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    @php
                        $nameParts = explode(' ', $student->nama);
                        $initial = count($nameParts) > 1 
                            ? strtoupper($nameParts[0][0] . $nameParts[1][0]) 
                            : strtoupper($nameParts[0][0]);
                    @endphp
                    <tr>
                        <td style="padding-left: 32px;">
                            <div class="profile-group">
                                <div class="profile-initial avatar-bg-{{ $loop->index % 4 }}">
                                    {{ $initial }}
                                </div>
                                <p class="profile-name student-name">{{ $student->nama }}</p>
                            </div>
                        </td>
                        <td><p class="text-data">{{ $student->kelas->nama_kelas ?? '-' }}</p></td>
                        <td><p class="text-data">{{ $student->nama_wali }}</p></td>
                        <td><p class="text-data-muted">{{ $student->no_hp_wali }}</p></td>
                        <td>
                            <span class="badge badge-{{ $student->status }}">
                                {{ $student->status }}
                            </span>
                        </td>
                        <td class="actions-cell" style="padding-right: 32px;">
                            @php
                                $studentJson = htmlspecialchars(json_encode($student), ENT_QUOTES, 'UTF-8');
                                $onEdit = 'onclick="openEditModal(' . $studentJson . ')"';
                                $onDelete = 'onclick="openDeleteModal(' . $student->id_santri . ')"';
                            @endphp
                            <button type="button" class="action-btn" {!! $onEdit !!}>
                                <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                            </button>
                            <button type="button" class="action-btn btn-delete" {!! $onDelete !!}>
                                <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #78716C; padding: 48px; font-family: 'Plus Jakarta Sans', sans-serif;">
                            Tidak ada data santri ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        <!-- Pagination -->
        <div class="pagination-bar">
            <span class="text-data-muted">
                Menampilkan {{ $students->count() }} Santri
            </span>
        </div>
    </div>
</div>

<!-- ================================= ADD MODAL ================================= -->
<div class="modal-overlay" id="addModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Tambah Santri Baru</h3>
            <button class="modal-close" onclick="closeAddModal()">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" action="{{ route('admin.santri.store') }}" class="form-grid">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control" required>
                    <option value="L">Laki-Laki (Ikhwan)</option>
                    <option value="P">Perempuan (Akhwat)</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Kelas</label>
                <select name="id_kelas" class="form-control" required>
                    @foreach($classes as $class)
                        <option value="{{ $class->id_kelas }}">{{ $class->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Status Keaktifan</label>
                <select name="status" class="form-control" required>
                    <option value="aktif">Aktif</option>
                    <option value="mutasi">Mutasi</option>
                    <option value="lulus">Lulus</option>
                    <option value="non-aktif">Non-Aktif</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Nama Wali Murid</label>
                <input type="text" name="nama_wali" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">No. HP Wali Murid</label>
                <input type="text" name="no_hp_wali" class="form-control" placeholder="Contoh: 0812xxxx" required>
            </div>
            <div class="form-group form-group-full">
                <label class="form-label">Alamat Lengkap</label>
                <textarea name="alamat" rows="2" class="form-control"></textarea>
            </div>
            <div class="form-actions form-group-full">
                <button type="button" class="cancel-btn" onclick="closeAddModal()">Batal</button>
                <button type="submit" class="save-btn">Tambah Santri</button>
            </div>
        </form>
    </div>
</div>

<!-- ================================= EDIT MODAL ================================= -->
<div class="modal-overlay" id="editModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Ubah Data Santri</h3>
            <button class="modal-close" onclick="closeEditModal()">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" id="editForm" class="form-grid">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="nama" id="edit_nama" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Jenis Kelamin</label>
                <select name="jenis_kelamin" id="edit_jenis_kelamin" class="form-control" required>
                    <option value="L">Laki-Laki (Ikhwan)</option>
                    <option value="P">Perempuan (Akhwat)</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="tgl_lahir" id="edit_tgl_lahir" class="form-control">
            </div>
            <div class="form-group">
                <label class="form-label">Kelas</label>
                <select name="id_kelas" id="edit_id_kelas" class="form-control" required>
                    @foreach($classes as $class)
                        <option value="{{ $class->id_kelas }}">{{ $class->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Status Keaktifan</label>
                <select name="status" id="edit_status" class="form-control" required>
                    <option value="aktif">Aktif</option>
                    <option value="mutasi">Mutasi</option>
                    <option value="lulus">Lulus</option>
                    <option value="non-aktif">Non-Aktif</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Nama Wali Murid</label>
                <input type="text" name="nama_wali" id="edit_nama_wali" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">No. HP Wali Murid</label>
                <input type="text" name="no_hp_wali" id="edit_no_hp_wali" class="form-control" required>
            </div>
            <div class="form-group form-group-full">
                <label class="form-label">Alamat Lengkap</label>
                <textarea name="alamat" id="edit_alamat" rows="2" class="form-control"></textarea>
            </div>
            <div class="form-actions form-group-full">
                <button type="button" class="cancel-btn" onclick="closeEditModal()">Batal</button>
                <button type="submit" class="save-btn">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- ================================= DELETE CONFIRMATION MODAL ================================= -->
<div class="modal-overlay" id="deleteModal">
    <div class="modal-container" style="max-width: 440px;">
        <div class="modal-header">
            <h3 class="modal-title">Hapus Data Santri</h3>
            <button class="modal-close" onclick="closeDeleteModal()">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div style="margin-bottom: 24px;">
            <p style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 15px; color: #4B5563; line-height: 1.5; margin: 0;">
                Apakah Anda yakin ingin menghapus data santri ini? Tindakan ini bersifat permanen dan tidak dapat dibatalkan.
            </p>
        </div>
        <form method="POST" id="deleteForm">
            @csrf
            @method('DELETE')
            <div class="form-actions" style="margin-top: 0;">
                <button type="button" class="cancel-btn" onclick="closeDeleteModal()">Batal</button>
                <button type="submit" class="save-btn" style="background: #DC2626;">Hapus Data</button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // ADD MODAL FUNCTIONS
    function openAddModal() {
        document.getElementById('addModal').style.display = 'flex';
    }

    function closeAddModal() {
        document.getElementById('addModal').style.display = 'none';
    }

    // EDIT MODAL FUNCTIONS
    function openEditModal(student) {
        document.getElementById('editForm').action = '/admin/santri/' + student.id_santri;
        document.getElementById('edit_nama').value = student.nama || '';
        document.getElementById('edit_jenis_kelamin').value = student.jenis_kelamin || 'L';
        document.getElementById('edit_tgl_lahir').value = student.tgl_lahir || '';
        document.getElementById('edit_id_kelas').value = student.id_kelas || '';
        document.getElementById('edit_status').value = student.status || 'aktif';
        document.getElementById('edit_nama_wali').value = student.nama_wali || '';
        document.getElementById('edit_no_hp_wali').value = student.no_hp_wali || '';
        document.getElementById('edit_alamat').value = student.alamat || '';
        
        document.getElementById('editModal').style.display = 'flex';
    }

    function closeEditModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    // DELETE MODAL FUNCTIONS
    function openDeleteModal(studentId) {
        document.getElementById('deleteForm').action = '/admin/santri/' + studentId;
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    // Close Modals when clicking outside
    window.onclick = function(event) {
        const addModal = document.getElementById('addModal');
        const editModal = document.getElementById('editModal');
        const deleteModal = document.getElementById('deleteModal');

        if (event.target == addModal) {
            closeAddModal();
        }
        if (event.target == editModal) {
            closeEditModal();
        }
        if (event.target == deleteModal) {
            closeDeleteModal();
        }
    }

    // Real-time search filter for santri
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.santri-table tbody tr');
        
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
