@extends('layouts.admin')

@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator $pengurus */
@endphp

@push('styles')
    <style>
        /* Page Header Section */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            width: 100%;
            margin-bottom: 32px;
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
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            width: 100%;
            margin-bottom: 10px;
        }

        @media (max-width: 1024px) {
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

        .stat-icon-wrapper.pengurus { background: #F59E0B; color: #FFFFFF; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); }
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

        /* Tabs Filter */
        .tabs-filter {
            display: flex;
            padding: 24px 32px 0;
            gap: 32px;
            border-bottom: 1px solid #F1EEE7;
        }

        .tab-btn {
            padding: 0 8px 16px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            color: #404945;
            border: none;
            background: none;
            border-bottom: 4px solid transparent;
            cursor: pointer;
            text-decoration: none;
        }

        .tab-btn.active {
            font-weight: 700;
            color: #003227;
            border-bottom: 4px solid #003227;
        }

        /* Table */
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th {
            background: #F6F3EC;
            padding: 24px 32px;
            text-align: left;
            font-family: 'Manrope', sans-serif;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: #404945;
        }

        .data-table td {
            padding: 24px 32px;
            border-bottom: 1px solid #F1EEE7;
        }

        .profile-cell {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 14px;
            overflow: hidden;
        }

        /* Dynamic Avatar Colors */
        .avatar-bg-0 {
            background: #B0EFDA;
            color: #003227;
        }

        .avatar-bg-1 {
            background: #FFE088;
            color: #241A00;
        }

        .avatar-bg-2 {
            background: #E9E2D3;
            color: #1E1B13;
        }

        .avatar-bg-3 {
            background: #95D3BF;
            color: #002019;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
        }

        .profile-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 16px;
            font-weight: 700;
            color: #003227;
        }

        .profile-gender {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 12px;
            color: #404945;
        }

        .role-badge {
            display: inline-flex;
            padding: 4px 12px;
            border-radius: 9999px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .role-pengurus {
            background: #ECFDF5;
            border: 1px solid rgba(0, 50, 39, 0.2);
            color: #003227;
        }

        .role-guru {
            background: #FED65B;
            color: #745C00;
        }

        .text-normal {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            color: #404945;
        }

        /* Action Buttons */
        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background: #F6F3EC;
            color: #004B3C;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-icon-danger {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            border: none;
            background: #F6F3EC;
            color: #BA1A1A;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-icon:hover {
            background: #004B3C;
            color: #FFFFFF;
        }

        .btn-icon-danger:hover {
            background: #BA1A1A;
        color: #FFFFFF;
        }

        /* Header Button */
        .btn-primary {
            background: #004B3C;
            color: #FFFFFF;
            border: none;
            padding: 12px 24px;
            border-radius: 99px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-primary:hover {
            background: #003227;
            transform: translateY(-2px);
        }

        /* Pagination */
        .pagination-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 32px;
            background: #F6F3EC;
        }

        .pagination-info {
            font-family: 'Manrope', sans-serif;
            font-size: 12px;
            color: #404945;
        }

        .pagination-controls {
            display: flex;
            gap: 8px;
        }

        .page-btn {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 1px solid transparent;
            background: transparent;
            color: #707975;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 12px;
            cursor: pointer;
            text-decoration: none;
        }

        .page-btn:hover:not(:disabled) {
            background: rgba(0, 50, 39, 0.05);
        }

        .page-btn.active {
            background: #003227;
            color: #FFFFFF;
        }

        .page-btn.outline {
            border-color: #BFC9C4;
        }

        /* Modals */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .modal-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .modal-container {
            background: #FFFFFF;
            border-radius: 32px;
            padding: 32px;
            width: 100%;
            max-width: 500px;
            max-height: 90vh;
            overflow-y: auto;
            transform: translateY(20px);
            transition: all 0.3s ease;
        }

        .modal-overlay.active .modal-container {
            transform: translateY(0);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .modal-title {
            font-family: 'Epilogue', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: #003227;
            margin: 0;
        }

        .close-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: #707975;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: #404945;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #EBE8E1;
            border-radius: 12px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            color: #003227;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-input:focus {
            border-color: #004B3C;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 32px;
        }

        .btn-secondary {
            background: #F6F3EC;
            color: #404945;
            border: none;
            padding: 12px 24px;
            border-radius: 99px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-danger {
            background: #BA1A1A;
            color: #FFFFFF;
            border: none;
            padding: 12px 24px;
            border-radius: 99px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
        }

        /* Ornamental Signature Box */
        .signature-box {
            background: #004B3C;
            border-radius: 48px;
            padding: 40px;
            margin-top: 40px;
            position: relative;
            overflow: hidden;
        }

        .signature-title {
            font-family: 'Epilogue', sans-serif;
            font-weight: 700;
            font-size: 24px;
            color: #95D3BF;
            margin-bottom: 16px;
        }

        .signature-desc {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.8);
            max-width: 672px;
        }

        .signature-svg {
            position: absolute;
            right: 0;
            top: 0;
            opacity: 0.1;
            height: 100%;
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
                    <span class="breadcrumb-active">Data Pengurus</span>
                </div>
                <h2 class="header-title">Data Pengurus</h2>
                <p class="header-subtitle">Kelola informasi pengurus, administrasi, dan staf tata usaha TPA.</p>
            </div>
            <button class="btn-primary"
                style="padding: 16px 32px; font-size: 16px; border-radius: 9999px; box-shadow: 0px 10px 15px -3px rgba(6, 78, 59, 0.2);"
                onclick="openModal('createModal')">
                <span class="material-symbols-outlined" style="font-size: 20px;">person_add</span>
                Tambah Anggota
            </button>
        </div>

        @if(session('success'))
            <div
                style="background: #ECFDF5; border: 1px solid #10B981; color: #047857; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600;">
                {{ session('success') }}

            </div>
        @endif
        @if($errors->any())
            <div
                style="background: #FEF2F2; border: 1px solid #EF4444; color: #B91C1C; padding: 16px; border-radius: 12px; margin-bottom: 24px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600;">
                Terjadi kesalahan saat menyimpan data:
                <ul style="margin-top: 8px; margin-bottom: 0; padding-left: 20px; font-weight: 400; font-size: 14px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Table Section -->
        <div class="table-section">
            <div class="table-header-bar">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 8px; height: 24px; background: #735C00; border-radius: 9999px;"></div>
                    <span
                        style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 18px; color: #003227;">Daftar
                        Data Pengurus</span>
                </div>
            </div>

            <!-- Table -->
            <table class="data-table">
                <thead>
                    <tr>
                        <th>NAMA</th>
                        <th>JABATAN</th>
                        <th>NO HP</th>
                        <th>AKUN</th>
                        <th style="text-align: right;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengurus as $p)
                    <tr>
                        <td>
                            <span
                                style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 600; color: #003227;">{{ $p->nama }}</span>
                        </td>
                        <td>
                            @if($p->is_kepala)
                                <span class="role-badge"
                                    style="background:#735C00; color:#FFFFFF; margin-bottom: 4px; display: block; width: fit-content;">KEPALA
                                    TPA</span>
                            @endif
                            @if(!$p->is_kepala)
                                <span class="role-badge role-pengurus">PENGURUS TPA</span>
                            @endif
                        </td>
                        <td>
                            <span
                                style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 600; color: #003227;">
                                {{ $p->no_hp }}

                            </span>
                        </td>
                        <td>
                            @if($p->id_user)
                                <span
                                    style="display:inline-flex; align-items:center; gap:4px; padding:4px 12px; background:#ECFDF5; color:#047857; border-radius:9999px; font-family:'Plus Jakarta Sans',sans-serif; font-size:12px; font-weight:600;">
                                    Akun Aktif
                                </span>
                            @else
                                <span
                                    style="display:inline-flex; align-items:center; gap:4px; padding:4px 12px; background:#FEF2F2; color:#B91C1C; border-radius:9999px; font-family:'Plus Jakarta Sans',sans-serif; font-size:12px; font-weight:600;">
                                    Belum Ada Akun
                                </span>
                            @endif
                        </td>
                        <td style="text-align: right;">
                            <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                @php
        /** @var \App\Models\Pengurus $p */
        $roleStr = 'admin';
        $emailStr = $p->user ? addslashes($p->user->email) : '';
        $namaStr = addslashes($p->nama);
        $alamatStr = addslashes($p->alamat);
        $quoteStr = addslashes($p->quote);
        $isKepalaStr = $p->is_kepala ? 'true' : 'false';

        $onclickAkun = 'onclick="openAkunModal(' . $p->id_pengurus . ', \'' . $namaStr . '\', \'' . $roleStr . '\')"';
        $onclickReset = 'onclick="openAkunModal(' . $p->id_pengurus . ', \'' . $namaStr . '\', \'' . $roleStr . '\', \'' . $emailStr . '\')"';
        $onclickEdit = 'onclick="openEditModal(' . $p->id_pengurus . ', \'' . $namaStr . '\', \'' . $p->jenis_kelamin . '\', \'' . $p->no_hp . '\', \'' . $alamatStr . '\', ' . $isKepalaStr . ', \'' . $quoteStr . '\')"';
        $onclickDelete = 'onclick="openDeleteModal(' . $p->id_pengurus . ')"';
                                @endphp
                                @if(!$p->id_user)
                                    <button type="button" class="btn-primary"
                                        style="padding: 6px 12px; font-size: 12px; gap: 4px;" {!! $onclickAkun !!}>
                                        <span class="material-symbols-outlined" style="font-size: 14px;">person_add</span> Buat
                                        Akun
                                    </button>
                                @else
                                    <button type="button" class="btn-secondary"
                                        style="padding: 6px 12px; font-size: 12px; gap: 4px;" {!! $onclickReset !!}>
                                        <span class="material-symbols-outlined" style="font-size: 14px;">lock_reset</span> Reset
                                        Password
                                    </button>
                                @endif
                                <button type="button" class="btn-icon" {!! $onclickEdit !!} title="Edit Data">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                                </button>
                                <button type="button" class="btn-icon btn-icon-danger" {!! $onclickDelete !!}
                                    title="Hapus Data">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 40px; color: #707975;">
                            Belum ada data pengurus/pengajar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="pagination-container">
                <div class="pagination-info">Menampilkan {{ $pengurus->firstItem() ?? 0 }}-{{ $pengurus->lastItem() ?? 0 }}
                    dari {{ $pengurus->total() }} data</div>
                <div class="pagination-controls">
                    <!-- Previous Page Link -->
                    @if($pengurus->onFirstPage())
                        <button class="page-btn outline" disabled style="opacity: 0.5; cursor: not-allowed;"><span
                                class="material-symbols-outlined" style="font-size:18px">chevron_left</span></button>
                    @else
                        <a href="{{ $pengurus->appends(request()->query())->previousPageUrl() }}" class="page-btn outline"><span
                                class="material-symbols-outlined" style="font-size:18px">chevron_left</span></a>
                    @endif

                    <!-- Pagination Elements -->
                    @php
                        $start = max($pengurus->currentPage() - 2, 1);
                        $end = min($pengurus->currentPage() + 2, $pengurus->lastPage());
                    @endphp

                    @if($start > 1)
                        <a href="{{ $pengurus->url(1) }}" class="page-btn">1</a>
                        @if($start > 2)
                            <button class="page-btn" disabled>...</button>
                        @endif
                    @endif

                    @for($page = $start; $page <= $end; $page++)
                        @if($page == $pengurus->currentPage())
                            <button class="page-btn active">{{ $page }}</button>
                        @else
                            <a href="{{ $pengurus->url($page) }}" class="page-btn">{{ $page }}</a>
                        @endif
                    @endfor

                    @if($end < $pengurus->lastPage())
                        @if($end < $pengurus->lastPage() - 1)
                            <button class="page-btn" disabled>...</button>
                        @endif
                        <a href="{{ $pengurus->url($pengurus->lastPage()) }}" class="page-btn">{{ $pengurus->lastPage() }}</a>
                    @endif

                    <!-- Next Page Link -->
                    @if($pengurus->hasMorePages())
                        <a href="{{ $pengurus->appends(request()->query())->nextPageUrl() }}" class="page-btn outline"><span
                                class="material-symbols-outlined" style="font-size:18px">chevron_right</span></a>
                    @else
                        <button class="page-btn outline" disabled style="opacity: 0.5; cursor: not-allowed;"><span
                                class="material-symbols-outlined" style="font-size:18px">chevron_right</span></button>
                    @endif
                </div>
            </div>
        </div>



        <!-- Modal Tambah -->
        <div class="modal-overlay" id="createModal">
            <div class="modal-container">
                <div class="modal-header">
                    <h3 class="modal-title">Tambah Anggota</h3>
                    <button class="close-btn" onclick="closeModal('createModal')"><span
                            class="material-symbols-outlined">close</span></button>
                </div>
                <form action="{{ route('admin.pengurus.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-input" required placeholder="Cth: Ahmad Syukur">
                    </div>
                    <div style="display:flex; gap:16px;">
                        <div class="form-group" style="flex:1;">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-input" required>
                                <option value="" disabled selected>-- Pilih Jenis Kelamin --</option>
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                            @error('jenis_kelamin')
                                <div style="color: #BA1A1A; font-size: 12px; margin-top: 4px;">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="no_hp" class="form-input" placeholder="Cth: 08123456789" >
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" class="form-input" rows="3" placeholder="Masukkan alamat..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Foto Profil (Opsional)</label>
                        <input type="file" name="foto" class="form-input" accept="image/*">
                    </div>
                    <div class="form-group" style="display:flex; align-items:center; gap:8px;">
                        <input type="checkbox" name="is_kepala" value="1" id="createKepala"
                            style="width:16px; height:16px;">
                        <label for="createKepala"
                            style="font-family:'Plus Jakarta Sans'; font-size:14px; color:#404945; cursor:pointer;">Jadikan
                            sebagai Kepala TPA</label>
                    </div>



                    <div class="form-group">
                        <label class="form-label">Kutipan / Pesan Kepala TPA (Opsional)</label>
                        <textarea name="quote" class="form-input" rows="2"
                            placeholder="Cth: Misi utama kami adalah menanamkan kecintaan..."></textarea>
                    </div>
                    <div class="modal-actions">
                        <button type="button" class="btn-secondary" onclick="closeModal('createModal')">Batal</button>
                        <button type="submit" class="btn-primary" style="background:#003227">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit -->
        <div class="modal-overlay" id="editModal">
            <div class="modal-container">
                <div class="modal-header">
                    <h3 class="modal-title">Edit Anggota</h3>
                    <button class="close-btn" onclick="closeModal('editModal')"><span
                            class="material-symbols-outlined">close</span></button>
                </div>
                <form id="editForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" id="editNama" class="form-input" required>
                    </div>
                    <div style="display:flex; gap:16px;">
                        <div class="form-group" style="flex:1;">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" id="editJK" class="form-input" required>
                                <option value="" disabled>-- Pilih Jenis Kelamin --</option>
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" name="no_hp" id="editHp" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" id="editAlamat" class="form-input" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ganti Foto Profil (Opsional)</label>
                        <input type="file" name="foto" class="form-input" accept="image/*">
                    </div>
                    <div class="form-group" style="display:flex; align-items:center; gap:8px;">
                        <input type="checkbox" name="is_kepala" value="1" id="editKepala" style="width:16px; height:16px;">
                        <label for="editKepala"
                            style="font-family:'Plus Jakarta Sans'; font-size:14px; color:#404945; cursor:pointer;">Jadikan
                            sebagai Kepala TPA</label>
                    </div>



                    <div class="form-group">
                        <label class="form-label">Kutipan / Pesan Kepala TPA (Opsional)</label>
                        <textarea name="quote" id="editQuote" class="form-input" rows="2"></textarea>
                    </div>
                    <div class="modal-actions">
                        <button type="button" class="btn-secondary" onclick="closeModal('editModal')">Batal</button>
                        <button type="submit" class="btn-primary" style="background:#003227">Update Data</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Hapus -->
        <div id="deleteModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
            <div style="background: white; border-radius: 24px; padding: 32px; width: 90%; max-width: 400px; position: relative; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
                <button type="button" onclick="closeDeleteModal()" style="position: absolute; right: 24px; top: 24px; background: none; border: none; cursor: pointer; color: #64748B; padding: 4px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: background 0.2s;" onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='none'">
                    <span class="material-symbols-outlined" style="font-size: 20px;">close</span>
                </button>
                
                <h3 style="font-family: 'Epilogue', sans-serif; font-weight: 700; font-size: 20px; color: #003227; margin: 0 0 16px 0;">Hapus Data Pengurus</h3>
                
                <p style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; color: #64748B; margin: 0 0 32px 0; line-height: 1.6;">
                    Apakah Anda yakin ingin menghapus data pengurus ini? Tindakan ini bersifat permanen dan tidak dapat dibatalkan.
                </p>
                
                <div style="display: flex; gap: 12px; justify-content: center;">
                    <button type="button" onclick="closeDeleteModal()" style="flex: 1; padding: 12px 24px; border-radius: 32px; border: 1px solid #E2E8F0; background: white; color: #475569; font-weight: 600; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; transition: background 0.2s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='white'">Batal</button>
                    <form id="deleteForm" method="POST" style="margin: 0; flex: 1; display: flex;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="width: 100%; padding: 12px 24px; border-radius: 32px; border: none; background: #DC2626; color: white; font-weight: 600; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; transition: background 0.2s;" onmouseover="this.style.background='#B91C1C'" onmouseout="this.style.background='#DC2626'">Hapus Data</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Buat/Reset Akun -->
        <div class="modal-overlay" id="akunModal">
            <div class="modal-container" style="max-width: 400px;">
                <div class="modal-header">
                    <h3 class="modal-title" id="akunModalTitle">Buat Akun Login</h3>
                    <button class="close-btn" onclick="closeModal('akunModal')"><span
                            class="material-symbols-outlined">close</span></button>
                </div>
                <form id="akunForm" action="" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="form-label">Nama</label>
                        <input type="text" id="akunNama" class="form-input" readonly
                            style="background: #F6F3EC; color: #707975;">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" id="akunEmail" class="form-input" required
                            placeholder="contoh: guru@tpa.com">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Password</label>
                        <div style="position: relative; display: flex; align-items: center;">
                            <input type="password" name="password" id="akunPassword" class="form-input"
                                placeholder="Minimal 8 karakter" style="padding-right: 48px;">
                            <button type="button" onclick="togglePassword('akunPassword', 'akunToggleIcon')"
                                style="position: absolute; right: 16px; background: none; border: none; color: #9CA3AF; cursor: pointer; display: flex; align-items: center; padding: 0;">
                                <span class="material-symbols-outlined" id="akunToggleIcon"
                                    style="font-size: 20px;">visibility</span>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Konfirmasi Password</label>
                        <div style="position: relative; display: flex; align-items: center;">
                            <input type="password" name="password_confirmation" id="akunPasswordConfirm" class="form-input"
                                placeholder="Minimal 8 karakter" style="padding-right: 48px;">
                            <button type="button" onclick="togglePassword('akunPasswordConfirm', 'akunConfirmToggleIcon')"
                                style="position: absolute; right: 16px; background: none; border: none; color: #9CA3AF; cursor: pointer; display: flex; align-items: center; padding: 0;">
                                <span class="material-symbols-outlined" id="akunConfirmToggleIcon"
                                    style="font-size: 20px;">visibility</span>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <div style="display: flex; gap: 16px; margin-top: 8px;">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="radio" name="role" value="guru" id="roleGuru">
                                <span
                                    style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; color: #404945;">Guru</span>
                            </label>
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                                <input type="radio" name="role" value="admin" id="roleAdmin">
                                <span
                                    style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; color: #404945;">Admin</span>
                            </label>
                        </div>
                    </div>
                    <div class="modal-actions">
                        <button type="button" class="btn-secondary" onclick="closeModal('akunModal')">Batal</button>
                        <button type="submit" class="btn-primary" style="background:#003227">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        function openModal(id) {
            document.getElementById(id).classList.add('active');
        }

        function closeModal(id) {
            document.getElementById(id).classList.remove('active');
        }

        function openEditModal(id, nama, jk, hp, alamat, is_kepala, quote) {
            const form = document.getElementById('editForm');
            form.action = `{{ url('/admin/pengurus') }}/${id}`;

            document.getElementById('editNama').value = nama;
            document.getElementById('editJK').value = jk;
            document.getElementById('editHp').value = hp !== 'null' ? hp : '';
            document.getElementById('editAlamat').value = alamat !== 'null' ? alamat : '';
            document.getElementById('editKepala').checked = is_kepala;
            document.getElementById('editQuote').value = quote !== 'null' ? quote : '';

            openModal('editModal');
        }

        function openAkunModal(id, nama, role, email = '') {
            const form = document.getElementById('akunForm');
            form.action = `{{ url('/admin/pengurus') }}/${id}/akun`;

            document.getElementById('akunNama').value = nama;
            document.getElementById('akunEmail').value = email;

            if (role === 'admin') {
                document.getElementById('roleAdmin').checked = true;
            } else {
                document.getElementById('roleGuru').checked = true;
            }

            document.getElementById('akunPassword').value = '';
            document.getElementById('akunPasswordConfirm').value = '';

            const isReset = email !== '';
            document.getElementById('akunModalTitle').textContent = isReset ? 'Reset Password / Edit Akun' : 'Buat Akun Login';
            document.getElementById('akunPassword').required = !isReset;
            document.getElementById('akunPasswordConfirm').required = !isReset;

            openModal('akunModal');
        }

        function openDeleteModal(id) {
            const form = document.getElementById('deleteForm');
            form.action = `{{ url('/admin/pengurus') }}/${id}`;
            const modal = document.getElementById('deleteModal');
            modal.style.display = 'flex';
            // Animasi pop in
            const modalContent = modal.querySelector('div');
            modalContent.style.opacity = '0';
            modalContent.style.transform = 'scale(0.95)';
            setTimeout(() => {
                modalContent.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
                modalContent.style.opacity = '1';
                modalContent.style.transform = 'scale(1)';
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteModal');
            const modalContent = modal.querySelector('div');
            modalContent.style.opacity = '0';
            modalContent.style.transform = 'scale(0.95)';
            setTimeout(() => {
                modal.style.display = 'none';
            }, 300);
        }

        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const toggleIcon = document.getElementById(iconId);
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                toggleIcon.textContent = 'visibility';
            }
        }
    </script>
@endpush