@extends('layouts.admin')
@section('title', 'Admin - Galeri')
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
    
    .canvas-card {
        background: #FFFFFF;
        border-radius: 24px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.05);
        padding: 24px;
        margin-bottom: 24px;
        width: 100%;
        box-sizing: border-box;
    }

    .btn-primary {
        background: #004B3C;
        color: #FFFFFF;
        border: none;
        padding: 12px 24px;
        border-radius: 99px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-primary:hover {
        background: #003227;
        transform: translateY(-2px);
    }

    /* Table Styles */
    .custom-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .custom-table th {
        background: #F6F3EC;
        color: #404945;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 12px;
        letter-spacing: 1px;
        text-transform: uppercase;
        padding: 16px 24px;
        text-align: left;
    }
    .custom-table th:first-child {
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
    }
    .custom-table th:last-child {
        border-top-right-radius: 12px;
        border-bottom-right-radius: 12px;
    }
    .custom-table td {
        padding: 20px 24px;
        border-bottom: 1px solid #EBE8E1;
        vertical-align: middle;
    }
    .custom-table tr:last-child td {
        border-bottom: none;
    }

    .foto-cell {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .foto-img {
        width: 100px;
        height: 60px;
        border-radius: 8px;
        background: #F6F3EC;
        object-fit: cover;
    }
    .foto-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 14px;
        color: #003227;
        display: block;
    }

    .role-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 99px;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 11px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .role-pembelajaran { background: #E8F5E9; color: #2E7D32; }
    .role-kegiatan { background: #E3F2FD; color: #1565C0; }
    .role-wisuda { background: #FFF3E0; color: #E65100; }
    .role-prestasi { background: #FCE4EC; color: #C2185B; }

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
    .btn-icon:hover {
        background: #004B3C;
        color: #FFFFFF;
    }
    .btn-icon-danger {
        background: #FFEBEE;
        color: #BA1A1A;
    }
    .btn-icon-danger:hover {
        background: #BA1A1A;
        color: #FFFFFF;
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
</style>
@endpush

@section('content')
<div class="content-canvas">

    @if(session('success'))
        <div style="background-color: #D1FAE5; border: 1px solid #10B981; color: #065F46; padding: 16px 24px; border-radius: 16px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; display: inline-flex; width: fit-content; align-items: center; gap: 8px; margin-bottom: 24px;">
            <span class="material-symbols-outlined" style="font-size: 20px;">check_circle</span>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background-color: #FEE2E2; border: 1px solid #EF4444; color: #991B1B; padding: 16px 24px; border-radius: 16px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; margin-bottom: 24px;">
            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                <span class="material-symbols-outlined" style="font-size: 20px;">error</span>
                Gagal Menyimpan Data
            </div>
            <ul style="margin: 0; padding-left: 24px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Page Header Section -->
    <div class="page-header">
        <div>
            <div class="breadcrumb">
                <span>Admin</span>
                <span class="material-symbols-outlined" style="font-size: 14px;">chevron_right</span>
                <span class="breadcrumb-active">Galeri</span>
            </div>
            <h2 class="header-title">Galeri Kegiatan</h2>
            <p class="header-subtitle">Kelola foto dokumentasi kegiatan belajar mengajar dan acara TPA.</p>
        </div>
        <button class="btn-primary" style="padding: 16px 32px; font-size: 16px; border-radius: 9999px; box-shadow: 0px 10px 15px -3px rgba(6, 78, 59, 0.2);" onclick="openModal('createModal')">
            <span class="material-symbols-outlined" style="font-size: 20px;">add_photo_alternate</span>
            Tambah Foto
        </button>
    </div>


<div class="canvas-card">
    <table class="custom-table">
        <thead>
            <tr>
                <th>FOTO & JUDUL</th>
                <th>KATEGORI</th>
                <th>DESKRIPSI</th>
                <th style="text-align: right;">AKSI</th>
            </tr>
        </thead>
        <tbody>
            @forelse($galeris as $g)
                <tr>
                    <td>
                        <div class="foto-cell">
                            <img src="{{ Storage::url($g->foto) }}" alt="Foto Galeri" class="foto-img">
                            <span class="foto-title">{{ $g->judul }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="role-badge role-{{ $g->kategori }}">
                            {{ strtoupper(str_replace('_', ' ', $g->kategori)) }}
                        </span>
                    </td>
                    <td>
                        <span style="color: #707975; font-size: 14px; font-family: 'Plus Jakarta Sans', sans-serif;">
                            {{ $g->deskripsi ? Str::limit($g->deskripsi, 50) : '-' }}
                        </span>
                    </td>
                    <td style="text-align: right;">
                        <div style="display: flex; gap: 8px; justify-content: flex-end;">
                            @php
                                $judulStr = addslashes($g->judul);
                                $descStr = addslashes($g->deskripsi);
                                
                                $onclickEdit = 'onclick="openEditModal(' . $g->id_galeri . ', \'' . $judulStr . '\', \'' . $g->kategori . '\', \'' . $descStr . '\')"';
                                $onclickDelete = 'onclick="openDeleteModal(' . $g->id_galeri . ')"';
                            @endphp
                            <button type="button" class="btn-icon" {!! $onclickEdit !!} title="Edit Data">
                                <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                            </button>
                            <button type="button" class="btn-icon btn-icon-danger" {!! $onclickDelete !!} title="Hapus Data">
                                <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: #707975;">
                        Belum ada data foto di galeri.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Modal Tambah -->
<div class="modal-overlay" id="createModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Tambah Foto</h3>
            <button class="close-btn" onclick="closeModal('createModal')"><span class="material-symbols-outlined">close</span></button>
        </div>
        <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="form-label">Judul Foto</label>
                <input type="text" name="judul" class="form-input" placeholder="Cth: Wisuda Santri Angkatan ke-5" required>
            </div>
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="kategori" class="form-input" required>
                    <option value="pembelajaran">Pembelajaran</option>
                    <option value="kegiatan">Kegiatan</option>
                    <option value="wisuda">Wisuda</option>
                    <option value="prestasi">Prestasi</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Pilih Foto</label>
                <input type="file" name="foto" class="form-input" accept="image/*" required>
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi Singkat (Opsional)</label>
                <textarea name="deskripsi" class="form-input" rows="3" placeholder="Masukkan deskripsi kegiatan..."></textarea>
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
            <h3 class="modal-title">Edit Foto Galeri</h3>
            <button class="close-btn" onclick="closeModal('editModal')"><span class="material-symbols-outlined">close</span></button>
        </div>
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Judul Foto</label>
                <input type="text" name="judul" id="editJudul" class="form-input" required>
            </div>
            <div class="form-group">
                <label class="form-label">Kategori</label>
                <select name="kategori" id="editKategori" class="form-input" required>
                    <option value="pembelajaran">Pembelajaran</option>
                    <option value="kegiatan">Kegiatan</option>
                    <option value="wisuda">Wisuda</option>
                    <option value="prestasi">Prestasi</option>
                </select>
            </div>
            <div class="form-group">
                <label class="form-label">Ganti Foto (Opsional)</label>
                <input type="file" name="foto" class="form-input" accept="image/*">
            </div>
            <div class="form-group">
                <label class="form-label">Deskripsi Singkat (Opsional)</label>
                <textarea name="deskripsi" id="editDeskripsi" class="form-input" rows="3"></textarea>
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
        
        <h3 style="font-family: 'Epilogue', sans-serif; font-weight: 700; font-size: 20px; color: #003227; margin: 0 0 16px 0;">Hapus Foto Galeri</h3>
        
        <p style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; color: #64748B; margin: 0 0 32px 0; line-height: 1.6;">
            Apakah Anda yakin ingin menghapus foto ini dari galeri? Tindakan ini bersifat permanen dan tidak dapat dibatalkan.
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

    function openEditModal(id, judul, kategori, deskripsi) {
        const form = document.getElementById('editForm');
        form.action = `{{ url('/admin/galeri') }}/${id}`;
        
        document.getElementById('editJudul').value = judul;
        document.getElementById('editKategori').value = kategori;
        document.getElementById('editDeskripsi').value = deskripsi !== 'null' ? deskripsi : '';
        
        openModal('editModal');
    }

    function openDeleteModal(id) {
        const form = document.getElementById('deleteForm');
        form.action = `{{ url('/admin/galeri') }}/${id}`;
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
</script>
@endpush
