@extends('layouts.admin')

@section('title', 'Rekap E-Rapor - TPA Baitur Ridwan')

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

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: #FFFFFF;
        border: 1px solid rgba(191, 201, 196, 0.2);
        border-radius: 9999px;
        color: #003227;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
        transition: all 0.2s;
    }

    .back-btn:hover {
        background: #F6F3EC;
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

    .riwayat-table {
        width: 100%;
        border-collapse: collapse;
    }

    .riwayat-table th {
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

    .riwayat-table td {
        padding: 20px 24px;
        border-bottom: 1px solid rgba(191, 201, 196, 0.1);
        vertical-align: middle;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        color: #1C1C18;
    }

    .riwayat-table tr:last-child td {
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

    .student-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .student-name {
        font-weight: 700;
        margin: 0;
        color: #003227;
        font-size: 15px;
    }

    .student-date {
        font-size: 12px;
        color: #78716C;
        margin: 0;
    }

    .badge-cawu {
        background: #ECFDF5;
        border: 1px solid rgba(5, 150, 105, 0.2);
        color: #059669;
        display: inline-flex;
        padding: 4px 12px;
        border-radius: 9999px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
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

    .pagination-wrapper {
        padding: 24px 32px;
        border-top: 1px solid rgba(191, 201, 196, 0.1);
    }
</style>
@endpush

@section('content')
<div class="content-canvas">
    @if(session('success'))
        <div style="background-color: #D1FAE5; border: 1px solid #10B981; color: #065F46; padding: 16px 24px; border-radius: 16px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; display: inline-flex; width: fit-content; align-items: center; gap: 8px;">
            <span class="material-symbols-outlined" style="font-size: 20px;">check_circle</span>
            {{ session('success') }}
        </div>
    @endif
    <!-- Header -->
    <div class="page-header">
        <div>
            <div class="breadcrumb">
                <span>Dashboard</span>
                <span class="material-symbols-outlined" style="font-size: 16px;">chevron_right</span>
                <span>E-Rapor</span>
                <span class="material-symbols-outlined" style="font-size: 16px;">chevron_right</span>
                <span class="breadcrumb-active">Riwayat</span>
            </div>
            <h1 class="header-title">Rekap E-Rapor</h1>
            <p class="header-subtitle">Daftar lengkap rekap e-rapor santri dari waktu ke waktu.</p>
        </div>
        <a href="{{ route('admin.eraport') }}" class="back-btn" style="background: #003227; color: white; border: none;">
            <span class="material-symbols-outlined" style="color: white;">add</span>
            Ambil Rapor baru
        </a>
        
    </div>

    <!-- Table Section -->
    <div class="table-section">
        <div class="table-header-bar">
            <div class="table-title">
                <div class="title-indicator"></div>
                <span>Data E-Rapor Santri</span>
            </div>

            <form action="{{ route('admin.eraport.riwayat') }}" method="GET" class="search-filter-form" id="filterForm">
                <div style="position: relative; display: flex; align-items: center;">
                    <select name="id_kelas" onchange="this.form.submit()" class="select-class-filter" style="background: #F6F3EC; border: 1px solid #BFC9C4; border-radius: 9999px; padding: 10px 36px 10px 16px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; color: #003227; font-weight: 600; outline: none; cursor: pointer; appearance: none; -webkit-appearance: none;">
                        <option value="semua" {{ $selected_class_id == 'semua' ? 'selected' : '' }}>Semua Kelas</option>
                        @foreach($classes as $kelas)
                            <option value="{{ $kelas->id_kelas }}" {{ $selected_class_id == $kelas->id_kelas ? 'selected' : '' }}>
                                Kelas {{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                    <span class="material-symbols-outlined" style="position: absolute; right: 12px; pointer-events: none; color: #57534E; font-size: 20px;">expand_more</span>
                </div>

                <div class="search-input-wrapper">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input type="text" id="searchInput" placeholder="Cari nama santri..." autocomplete="off" class="input-search">
                </div>
            </form>
        </div>

        <div style="overflow-x: auto; width: 100%;">
            <table class="riwayat-table">
                <thead>
                    <tr>
                        <th>Identitas Santri</th>
                        <th>Periode</th>
                        <th style="text-align: center;">Rata-Rata</th>
                        <th>Tanggal Cetak</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($eraports as $raport)
                        @php
                            $namaSantri = $raport->santri->nama ?? 'Unknown';
                            $avatarIndex = ($raport->id_santri ?? 0) % 4;
                            $initials = strtoupper(substr($namaSantri, 0, 1));
                        @endphp
                        <tr>
                            <td>
                                <div class="profile-group">
                                    <div class="profile-initial avatar-bg-{{ $avatarIndex }}">
                                        {{ $initials }}
                                    </div>
                                    <div class="student-info">
                                        <p class="student-name">{{ $namaSantri }}</p>
                                        <p class="student-date">Kelas: {{ $raport->kelompok }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-cawu">Caturwulan {{ $raport->caturwulan }}</span>
                                <div style="font-size: 12px; margin-top: 4px; color: #707975;">TA: {{ $raport->tahun_pelajaran }}</div>
                            </td>
                            <td style="text-align: center;">
                                <span style="font-weight: 700; color: #003227;">{{ $raport->rata_rata }}</span>
                            </td>
                            <td>
                                <span style="font-weight: 500; color: #404945;">{{ \Carbon\Carbon::parse($raport->created_at)->translatedFormat('d M Y, H:i') }}</span>
                            </td>
                            <td style="text-align: center;">
                                @php
                                    $santri = $raport->santri;
                                    $noHp = $santri ? $santri->no_hp_wali : '';
                                    if (strpos($noHp, '0') === 0) {
                                        $noHp = '62' . substr($noHp, 1);
                                    }
                                    
                                    $pesan = "Assalamu'alaikum Warahmatullahi Wabarakatuh.\n\nYth. Orang Tua/Wali Santri dari ananda {$namaSantri},\n\nBerikut kami sampaikan bahwa E-Rapor untuk Caturwulan {$raport->caturwulan} Tahun Pelajaran {$raport->tahun_pelajaran} telah diterbitkan dengan rata-rata nilai {$raport->rata_rata}.\n\nCatatan Guru:\n" . ($raport->catatan_guru ?? '-') . "\n\nTerima kasih atas perhatian dan kerja samanya.\n\nTPA Baitur Ridwan";
                                    
                                    $waText = urlencode($pesan);
                                @endphp
                                
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    @if(!empty($noHp))
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $noHp) }}?text={{ $waText }}" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #D1FAE5; color: #065F46; border-radius: 12px; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#A7F3D0'" onmouseout="this.style.background='#D1FAE5'" title="Kirim WA">
                                            <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.487-1.761-1.663-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.052 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                        </a>
                                    @endif
                                    
                                    <a href="{{ route('admin.eraport.preview', $raport->id_eraport) }}" target="_blank" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #FEF3C7; color: #D97706; border-radius: 12px; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#FDE68A'" onmouseout="this.style.background='#FEF3C7'" title="Preview PDF">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">visibility</span>
                                    </a>
                                    
                                    <a href="{{ route('admin.eraport.pdf', $raport->id_eraport) }}" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #E0E7FF; color: #4338CA; border-radius: 12px; text-decoration: none; transition: background 0.2s;" onmouseover="this.style.background='#C7D2FE'" onmouseout="this.style.background='#E0E7FF'" title="Cetak/Unduh PDF">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">download</span>
                                    </a>
                                    <button type="button" onclick="openDeleteModal(`{{ route('admin.eraport.delete', $raport->id_eraport) }}`)" style="display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 36px; background: #FEE2E2; color: #DC2626; border: none; border-radius: 12px; cursor: pointer; transition: background 0.2s;" onmouseover="this.style.background='#FECACA'" onmouseout="this.style.background='#FEE2E2'" title="Hapus">
                                        <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="5">
                                <div class="empty-state">
                                    <span class="material-symbols-outlined empty-icon">folder_off</span>
                                    <p style="margin: 0; font-weight: 600; font-size: 16px;">Belum ada riwayat E-Rapor</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    <tr id="noSearchResult" style="display: none;">
                        <td colspan="5">
                            <div class="empty-state">
                                <span class="material-symbols-outlined empty-icon" style="font-size: 48px; margin-bottom: 16px; color: #BFC9C4;">search_off</span>
                                <p style="margin: 0; font-weight: 600; font-size: 16px; color: #003227;">Data Santri tidak ditemukan</p>
                                <p style="margin: 4px 0 0 0; font-size: 14px; color: #78716C;">Tidak ada riwayat e-rapor santri yang cocok dengan kata kunci pencarian Anda.</p>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        @if(method_exists($eraports, 'hasPages') && $eraports->hasPages())
            <div class="pagination-wrapper">
                {{ $eraports->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal Hapus -->
<div id="deleteModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: white; border-radius: 24px; padding: 32px; width: 90%; max-width: 400px; position: relative; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
        <button type="button" onclick="closeDeleteModal()" style="position: absolute; right: 24px; top: 24px; background: none; border: none; cursor: pointer; color: #64748B; padding: 4px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: background 0.2s;" onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='none'">
            <span class="material-symbols-outlined" style="font-size: 20px;">close</span>
        </button>
        
        <h3 style="font-family: 'Epilogue', sans-serif; font-weight: 700; font-size: 20px; color: #003227; margin: 0 0 16px 0;">Hapus Riwayat E-Rapor</h3>
        
        <p style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; color: #64748B; margin: 0 0 32px 0; line-height: 1.6;">
            Apakah Anda yakin ingin menghapus riwayat e-rapor ini? Tindakan ini bersifat permanen dan tidak dapat dibatalkan.
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

@endsection

@push('scripts')
<script>
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
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.riwayat-table tbody tr:not(#noSearchResult):not(.empty-row)');
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
</script>
@endpush
