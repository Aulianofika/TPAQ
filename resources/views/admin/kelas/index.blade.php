@extends('layouts.admin')

@section('title', 'Admin - Data Kelas')

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

    /* Table Styles */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
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

    .data-table td {
        padding: 20px 24px;
        border-bottom: 1px solid rgba(191, 201, 196, 0.1);
        vertical-align: middle;
    }

    /* Table Content Fonts */
    .text-main {
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

    /* Actions */
    .actions-cell {
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .action-btn {
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

    .action-btn:hover {
        background: #004B3C;
        color: #FFFFFF;
    }

    .action-btn.btn-delete {
        background: #F6F3EC;
        color: #BA1A1A;
    }

    .action-btn.btn-delete:hover {
        background: #BA1A1A;
        color: #FFFFFF;
    }
    
    .badge-year {
        background: #fed65b;
        color: #735c00;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 12px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
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

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 6px;
        margin-bottom: 16px;
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

    @media (max-width: 768px) {
        .content-canvas {
            padding: 16px;
            gap: 24px;
        }
        
        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }
        
        .header-title {
            font-size: 28px;
            line-height: 32px;
        }
        
        .primary-btn {
            width: 100%;
            justify-content: center;
        }

        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            width: 100%;
        }

        .data-table th, .data-table td {
            padding: 16px;
            white-space: nowrap;
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
    @if(session('error'))
        <div style="background-color: #FEE2E2; border: 1px solid #EF4444; color: #991B1B; padding: 16px 24px; border-radius: 16px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            <span class="material-symbols-outlined" style="font-size: 20px;">error</span>
            {{ session('error') }}
        </div>
    @endif

    <!-- Page Header Section -->
    <div class="page-header">
        <div>
            <div class="breadcrumb">
                <span>Admin</span>
                <span class="material-symbols-outlined" style="font-size: 14px;">chevron_right</span>
                <span class="breadcrumb-active">Data Kelas</span>
            </div>
            <h2 class="header-title">Data Kelas</h2>
            <p class="header-subtitle">Kelola daftar kelas dan tahun ajaran di TPA Baitur Ridwan.</p>
        </div>
        <button class="primary-btn" onclick="openAddModal()">
            <span class="material-symbols-outlined" style="font-size: 20px;">add</span>
            Tambah Kelas
        </button>
    </div>

    <!-- Table Section -->
    <div class="table-section">
        <div class="table-header-bar">
            <div class="table-title">
                <div class="title-indicator"></div>
                <span>Daftar Kelas</span>
            </div>
        </div>

        <div class="table-responsive">
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="padding-left: 32px;">No</th>
                        <th>Nama Kelas</th>
                        <th>Wali Kelas / Pengajar</th>
                        <th style="text-align: center; padding-right: 32px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $k)
                    <tr>
                        <td style="padding-left: 32px;">
                            <p class="text-data-muted">{{ $loop->iteration }}</p>
                        </td>
                        <td>
                            <p class="text-main">{{ $k->nama_kelas }}</p>
                        </td>
                        <td>
                            <p class="text-data">{{ $k->pengajar->nama ?? 'Tidak Ada' }}</p>
                        </td>
                        <td style="padding-right: 32px;">
                            <div class="actions-cell">
                                <button class="action-btn" onclick="openEditModal({{ $k->id_kelas }}, '{{ addslashes($k->nama_kelas) }}', '{{ $k->id_pengajar }}')" title="Edit Kelas">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                                </button>
                                <button type="button" class="action-btn btn-delete" onclick="openDeleteModal('{{ route('admin.kelas.destroy', $k->id_kelas) }}')" title="Hapus Kelas">
                                    <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 48px; color: #A8A29E;">
                            <span class="material-symbols-outlined" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;">class</span>
                            <p style="font-family: 'Plus Jakarta Sans', sans-serif; margin: 0;">Belum ada data kelas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Tambah Kelas -->
<div class="modal-overlay" id="createModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Tambah Kelas Baru</h3>
            <button class="modal-close" onclick="closeModal('createModal')">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form action="{{ route('admin.kelas.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Kelas</label>
                <input type="text" name="nama_kelas" class="form-control" placeholder="Contoh: Kelas Abu Bakar" required>
            </div>
            <div class="form-group">
                <label class="form-label">Wali Kelas / Pengajar</label>
                <select name="id_pengajar" class="form-control" required>
                    <option value="">-- Pilih Pengajar --</option>
                    @foreach($pengajars as $p)
                        <option value="{{ $p->id_pengajar }}">{{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>

            
            <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="closeModal('createModal')">Batal</button>
                <button type="submit" class="save-btn">Simpan Kelas</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Kelas -->
<div class="modal-overlay" id="editModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Edit Kelas</h3>
            <button class="modal-close" onclick="closeModal('editModal')">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Nama Kelas</label>
                <input type="text" id="edit_nama_kelas" name="nama_kelas" class="form-control" required>
            </div>
            <div class="form-group">
                <label class="form-label">Wali Kelas / Pengajar</label>
                <select id="edit_id_pengajar" name="id_pengajar" class="form-control" required>
                    @foreach($pengajars as $p)
                        <option value="{{ $p->id_pengajar }}">{{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>

            
            <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="save-btn">Update Kelas</button>
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
        
        <h3 style="font-family: 'Epilogue', sans-serif; font-weight: 700; font-size: 20px; color: #003227; margin: 0 0 16px 0;">Hapus Data Kelas</h3>
        
        <p style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; color: #64748B; margin: 0 0 32px 0; line-height: 1.6;">
            Apakah Anda yakin ingin menghapus data kelas ini? Tindakan ini bersifat permanen dan tidak dapat dibatalkan.
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

@push('scripts')
<script>
    function openAddModal() {
        document.getElementById('createModal').style.display = 'flex';
    }

    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function openEditModal(id, nama, id_pengajar) {
        document.getElementById('edit_nama_kelas').value = nama;
        document.getElementById('edit_id_pengajar').value = id_pengajar;
        document.getElementById('editForm').action = `/admin/kelas/${id}`;
        document.getElementById('editModal').style.display = 'flex';
    }

    function openDeleteModal(actionUrl) {
        document.getElementById('deleteForm').action = actionUrl;
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

    // Tutup modal jika klik di luar
    window.onclick = function(event) {
        if (event.target.classList.contains('modal-overlay')) {
            event.target.style.display = 'none';
        }
        if (event.target.id === 'deleteModal') {
            closeDeleteModal();
        }
    }
</script>
@endpush
@endsection
