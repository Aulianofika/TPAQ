@extends('layouts.admin')

@section('title', 'Rekap Absensi Bulanan - TPA Baitur Ridwan')

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
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .btn-submit:hover {
        background: #065F46;
        transform: translateY(-1px);
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

    .profile-name {
        font-weight: 700;
        margin: 0;
        color: #003227;
        font-size: 15px;
    }

    /* Badges */
    .badge-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        font-weight: 700;
        font-size: 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .count-hadir { background: #ECFDF5; color: #059669; }
    .count-izin { background: #EFF6FF; color: #3B82F6; }
    .count-sakit { background: #FEF3C7; color: #D97706; }
    .count-alfa { background: #FEF2F2; color: #DC2626; }

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
                <span>Input Absensi</span>
                <span class="material-symbols-outlined" style="font-size: 16px;">chevron_right</span>
                <span class="breadcrumb-active">Rekap Absensi</span>
            </div>
            <h1 class="header-title">Rekap Absensi Bulanan</h1>
            <p class="header-subtitle">Merekapitulasi total kehadiran santri dalam satu bulan tertentu.</p>
        </div>
        <a href="{{ route('admin.absensi') }}" class="back-btn" style="background: #003227; color: white; border: none;">
            <span class="material-symbols-outlined" style="color: white;">add</span>
            Ambil Absensi
        </a>
    </div>

    <!-- Table Section -->
    <div class="table-section">
        <div class="table-header-bar">
            <div class="table-title">
                <div class="title-indicator"></div>
                <span>Data Kehadiran</span>
            </div>

            <form action="{{ route('admin.absensi.rekap') }}" method="GET" class="search-filter-form" id="filterForm">
                <div class="search-input-wrapper">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input type="text" id="searchInput" placeholder="Cari nama santri..." autocomplete="off" class="input-search">
                </div>
                
                <select name="id_kelas" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                    <option value="semua" {{ $selected_class_id == 'semua' ? 'selected' : '' }}>Semua Tingkat</option>
                    @foreach($classes as $kelas)
                        <option value="{{ $kelas->id_kelas }}" {{ $selected_class_id == $kelas->id_kelas ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <select name="bulan" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                    @php
                        $months = [
                            '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', 
                            '04' => 'April', '05' => 'Mei', '06' => 'Juni', 
                            '07' => 'Juli', '08' => 'Agustus', '09' => 'September', 
                            '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                        ];
                    @endphp
                    @foreach($months as $num => $name)
                        <option value="{{ $num }}" {{ $bulan == $num ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>

                <select name="tahun" class="filter-select" onchange="document.getElementById('filterForm').submit()">
                    @for($y = date('Y'); $y >= date('Y') - 3; $y--)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>

                <a href="{{ route('admin.absensi.pdf', request()->all()) }}" target="_blank" class="btn-submit">
                    <span class="material-symbols-outlined" style="font-size: 18px;">print</span>
                    Cetak PDF
                </a>
            </form>
        </div>

        <div style="overflow-x: auto; width: 100%;">
            <table class="riwayat-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th>Identitas Santri</th>
                        <th style="text-align: center;" title="Hadir">Hadir</th>
                        <th style="text-align: center;" title="Izin">Izin</th>
                        <th style="text-align: center;" title="Sakit">Sakit</th>
                        <th style="text-align: center;" title="Alfa / Tanpa Keterangan">Alfa</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $index => $student)
                        @php
                            $hadir = $student->absensis->where('status', 'hadir')->count();
                            $izin = $student->absensis->where('status', 'izin')->count();
                            $sakit = $student->absensis->where('status', 'sakit')->count();
                            $alfa = $student->absensis->where('status', 'alfa')->count();

                            $bulanName = $months[str_pad($bulan, 2, '0', STR_PAD_LEFT)] ?? '';
                            $noHp = $student->no_hp_wali ?? '';
                            if (strpos($noHp, '0') === 0) {
                                $noHp = '62' . substr($noHp, 1);
                            }
                            $noHpWa = preg_replace('/[^0-9]/', '', $noHp);

                            // Compile dynamic warm note based on attendance data
                            if ($alfa > 0) {
                                $absensiNote = "Mohon dibantu dipantau Pak/Bu, agar jika ananda berhalangan hadir dapat mengirimkan kabar izin kepada kami pengajar TPA.";
                            } elseif ($hadir == 0 && $izin == 0 && $sakit == 0) {
                                $absensiNote = "Bulan ini ananda belum sempat hadir di kelas. Mari kita semangati bersama agar ananda bisa aktif kembali belajar.";
                            } else {
                                $absensiNote = "Alhamdulillah, terima kasih banyak atas keaktifan ananda hadir di kelas bulan ini. Semoga terus dipertahankan semangat belajarnya.";
                            }

                            $waText = "Assalamu'alaikum Warahmatullahi Wabarakatuh,\n\n"
                                . "Bapak/Ibu Wali dari Ananda *" . $student->nama . "*.\n\n"
                                . "Alhamdulillah, berikut kami sampaikan laporan rekapitulasi kehadiran Ananda *" . $student->nama . "* selama bulan " . $bulanName . " " . $tahun . " di TPA Baitur Ridwan:\n\n"
                                . "- *Hadir*: " . $hadir . " hari\n"
                                . "- *Izin*: " . $izin . " hari\n"
                                . "- *Sakit*: " . $sakit . " hari\n"
                                . "- *Alfa (Tanpa Keterangan)*: " . $alfa . " hari\n\n"
                                . $absensiNote . "\n\n"
                                . "Terima kasih atas perhatian dan dukungan Bapak/Ibu sekalian. Semoga ananda terus istiqomah dalam belajar.\n\n"
                                . "Wassalamu'alaikum Warahmatullahi Wabarakatuh.";
                                
                            $avatarIndex = $student->id_santri % 4;
                            $initials = strtoupper(substr($student->nama, 0, 1));
                        @endphp
                        <tr>
                            <td style="text-align: center; color: #78716C; font-weight: 600;">{{ $index + 1 }}</td>
                            <td>
                                <div class="profile-group">
                                    <div class="profile-initial avatar-bg-{{ $avatarIndex }}">
                                        {{ $initials }}
                                    </div>
                                    <span class="profile-name">{{ $student->nama }}</span>
                                </div>
                            </td>
                            <td style="text-align: center;"><span class="badge-count count-hadir">{{ $hadir }}</span></td>
                            <td style="text-align: center;"><span class="badge-count count-izin">{{ $izin }}</span></td>
                            <td style="text-align: center;"><span class="badge-count count-sakit">{{ $sakit }}</span></td>
                            <td style="text-align: center;"><span class="badge-count count-alfa">{{ $alfa }}</span></td>
                            <td style="text-align: center;">
                                @if(!empty($noHpWa))
                                    <a href="https://wa.me/{{ $noHpWa }}?text={{ urlencode($waText) }}" 
                                       target="_blank" 
                                       style="display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; background: #ECFDF5; color: #059669; border-radius: 8px; text-decoration: none;"
                                       title="Kirim Laporan WA">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.888-.788-1.487-1.761-1.663-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.052 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                    </a>
                                @else
                                    <span style="color: #A8A29E; font-size: 12px; font-style: italic;">-</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="empty-state">
                                    <span class="material-symbols-outlined empty-icon">assignment</span>
                                    <p style="margin: 0; font-weight: 600; font-size: 16px;">Belum ada data rekap absensi</p>
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
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.riwayat-table tbody tr');
        
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
