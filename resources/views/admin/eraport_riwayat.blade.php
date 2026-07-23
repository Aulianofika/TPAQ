@extends('layouts.admin')

@section('title', 'Rekap E-Rapor')

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

    .student-info {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .student-name {
        font-weight: 700;
        margin: 0;
        color: #003227;
    }

    .student-date {
        font-size: 12px;
        color: #78716C;
        margin: 0;
    }

    .badge-cawu {
        background: #ECFDF5;
        border: 1px solid rgba(0, 50, 39, 0.2);
        color: #003227;
        display: inline-flex;
        padding: 4px 12px;
        border-radius: 9999px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .pagination-wrapper {
        padding: 24px 32px;
        border-top: 1px solid rgba(191, 201, 196, 0.1);
    }
</style>
@endpush

@section('content')
<div class="page-container">
    <div class="header-section">
        <div>
            <h2 class="page-title">Rekap E-Rapor</h2>
            <p class="page-subtitle">Daftar lengkap rekap e-rapor santri dari waktu ke waktu.</p>
        </div>
        <a href="{{ route('admin.eraport') }}" class="back-btn">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali ke E-Rapor
        </a>
    </div>

    <div class="table-section">
        <div class="table-header-bar">
            <div style="display: flex; align-items: center; gap: 8px;">
                <div style="width: 8px; height: 24px; background: #735C00; border-radius: 9999px;"></div>
                <span style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 700; font-size: 18px; color: #003227;">Data E-Rapor Santri</span>
            </div>

            <div style="display: flex; gap: 12px; align-items: center; flex-wrap: wrap; justify-content: flex-end;">
                <form action="{{ route('admin.eraport.riwayat') }}" method="GET" style="display: flex; gap: 12px; align-items: center;" id="filterForm">
                    <div style="position: relative; display: flex; align-items: center;">
                        <span class="material-symbols-outlined" style="position: absolute; left: 16px; color: #A8A29E; font-size: 20px;">search</span>
                        <input type="text" id="searchInput" placeholder="Cari santri..." style="background: #F6F3EC; border: none; border-radius: 48px; padding: 12px 24px 12px 48px; font-family: 'Plus Jakarta Sans', sans-serif; outline: none; font-size: 14px; width: 220px;" autocomplete="off">
                    </div>
                </form>
            </div>
        </div>

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
                    <tr>
                        <td>
                            <div class="student-profile">
                                @php
                                    $avatarUrl = 'https://ui-avatars.com/api/?name=' . urlencode($raport->santri->nama ?? 'Unknown') . '&background=003227&color=fff';
                                    $avatarStyle = 'style="background-image: url(\'' . $avatarUrl . '\');"';
                                @endphp
                                <div class="student-avatar" {!! $avatarStyle !!}></div>
                                <div class="student-info">
                                    <p class="student-name">{{ $raport->santri->nama ?? 'Unknown' }}</p>
                                    <p class="student-date">Kelompok: {{ $raport->kelompok }}</p>
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
                                $namaSantri = $santri ? $santri->nama : 'Unknown';
                                $noHp = $santri ? $santri->no_hp_wali : '';
                                if (strpos($noHp, '0') === 0) {
                                    $noHp = '62' . substr($noHp, 1);
                                }
                                
                                $pdfUrl = route('admin.eraport.pdf', $raport->id_eraport);
                                $pesan = "Assalamu'alaikum Warahmatullahi Wabarakatuh.\n\nYth. Orang Tua/Wali Santri dari ananda {$namaSantri},\n\nBerikut kami sampaikan bahwa E-Rapor untuk Caturwulan {$raport->caturwulan} Tahun Pelajaran {$raport->tahun_pelajaran} telah diterbitkan dengan rata-rata nilai {$raport->rata_rata}.\n\nBapak/Ibu dapat mengunduh dokumen E-Rapor melalui tautan berikut:\n{$pdfUrl}\n\nCatatan Guru:\n" . ($raport->catatan_guru ?? '-') . "\n\nTerima kasih atas perhatian dan kerja samanya.\n\nTPA Baitur Ridwan";
                                
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
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 48px;">Belum ada riwayat E-Rapor</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if(method_exists($eraports, 'hasPages') && $eraports->hasPages())
            <div class="pagination-wrapper">
                {{ $eraports->links() }}
            </div>
        @endif
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
