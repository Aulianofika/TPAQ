@extends('layouts.admin')

@section('title', 'Rekap Absensi')

@push('styles')
<style>
    .page-container {
        padding: 40px;
        background: #FCF9F2;
        min-height: 100vh;
    }

    .header-section {
        margin-bottom: 40px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: 36px;
        color: #003227;
        margin: 0;
        letter-spacing: -0.9px;
    }

    .page-subtitle {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 400;
        font-size: 16px;
        color: #404945;
        margin: 8px 0 0 0;
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

    /* Table Section Bento Style */
    .table-section {
        background: #FFFFFF;
        box-shadow: 0px 25px 50px -12px rgba(6, 78, 59, 0.05);
        border-radius: 48px 48px 8px 8px;
        overflow: hidden;
        border: 1px solid rgba(191, 201, 196, 0.1);
    }

    .table-header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 32px;
        border-bottom: 1px solid rgba(191, 201, 196, 0.1);
        background: #FFFFFF;
        flex-wrap: wrap;
        gap: 16px;
    }

    .riwayat-table {
        width: 100%;
        border-collapse: collapse;
    }

    .riwayat-table th {
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

    .riwayat-table td {
        padding: 24px 32px;
        border-bottom: 1px solid rgba(191, 201, 196, 0.1);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        color: #1C1C18;
    }

    .riwayat-table tr:last-child td {
        border-bottom: none;
    }

    .student-profile {
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .student-avatar {
        width: 48px;
        height: 48px;
        border-radius: 16px;
        background-size: cover;
        background-position: center;
    }

    .student-name {
        font-weight: 700;
        margin: 0;
        color: #003227;
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

    .filter-select {
        padding: 12px 16px;
        border: none;
        border-radius: 48px;
        background: #F6F3EC;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        color: #003227;
        outline: none;
        cursor: pointer;
    }
</style>
@endpush

@section('content')
<div class="page-container">
    <div class="header-section">
        <div>
            <h2 class="page-title">Rekap Absensi Bulanan</h2>
            <p class="page-subtitle">Merekapitulasi total kehadiran santri dalam satu bulan tertentu.</p>
        </div>
        <a href="{{ route('admin.absensi') }}" class="back-btn">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali ke Absensi
        </a>
    </div>

    <div class="table-section">
        <div class="table-header-bar">
            <div style="display: flex; align-items: center; gap: 8px;">
                <div style="width: 8px; height: 24px; background: #735C00; border-radius: 9999px;"></div>
                <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 18px; color: #003227;">Data Kehadiran</span>
            </div>

            <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap; justify-content: flex-end;">
                <form action="{{ route('admin.absensi.rekap') }}" method="GET" style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap;" id="filterForm">
                    <div style="position: relative; display: flex; align-items: center;">
                        <span class="material-symbols-outlined" style="position: absolute; left: 16px; color: #A8A29E; font-size: 20px;">search</span>
                        <input type="text" id="searchInput" placeholder="Cari santri..." style="background: #F6F3EC; border: none; border-radius: 48px; padding: 12px 24px 12px 48px; font-family: 'Plus Jakarta Sans', sans-serif; outline: none; font-size: 14px; width: 180px;" autocomplete="off">
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
                </form>

                <a href="{{ route('admin.absensi.pdf', request()->all()) }}" target="_blank" style="display: inline-flex; align-items: center; gap: 8px; padding: 12px 24px; background: #003227; color: white; border-radius: 48px; text-decoration: none; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 14px; border: none; cursor: pointer; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                    <span class="material-symbols-outlined" style="font-size: 18px;">print</span>
                    Cetak PDF
                </a>
            </div>
        </div>

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
                    @endphp
                    <tr>
                        <td style="text-align: center; color: #78716C; font-weight: 600;">{{ $index + 1 }}</td>
                        <td>
                            <div class="student-profile">
                                <div class="student-avatar" style="background-image: url('https://ui-avatars.com/api/?name={{ urlencode($student->nama) }}&background=003227&color=fff');"></div>
                                <span class="student-name">{{ $student->nama }}</span>
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
                        <td colspan="7" style="text-align: center; padding: 48px;">Belum ada data rekap absensi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.riwayat-table tbody tr');
        
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
