@extends('layouts.admin')

@section('title', 'Detail Perkembangan Santri - TPA Baitur Ridwan')

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

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 12px 24px;
        background: #FFFFFF;
        border: 1px solid rgba(191, 201, 196, 0.3);
        border-radius: 9999px;
        color: #003227;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 14px;
        text-decoration: none;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
        transition: all 0.2s;
    }

    .btn-back:hover {
        background: #F6F3EC;
    }

    /* Layout Columns */
    .detail-grid {
        display: grid;
        grid-template-columns: 320px 1fr;
        gap: 32px;
        width: 100%;
    }

    @media (max-width: 992px) {
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Profil Card */
    .profile-card {
        background: #FFFFFF;
        box-shadow: 0px 1px 3px rgba(0,0,0,0.05);
        border-radius: 32px;
        padding: 32px;
        display: flex;
        flex-direction: column;
        align-items: center;
        border: 1px solid rgba(191, 201, 196, 0.1);
        height: fit-content;
    }

    .profile-avatar-large {
        width: 96px;
        height: 96px;
        border-radius: 24px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 36px;
        margin-bottom: 24px;
        box-shadow: 0px 10px 15px -3px rgba(0, 0, 0, 0.05);
    }

    .profile-name-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: 20px;
        color: #003227;
        text-align: center;
        margin: 0 0 6px 0;
    }

    .profile-class-badge {
        background: #004B3C;
        color: #FFE088;
        padding: 6px 16px;
        border-radius: 9999px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 12px;
        margin-bottom: 24px;
    }

    .info-list {
        width: 100%;
        display: flex;
        flex-direction: column;
        gap: 16px;
        border-top: 1px solid rgba(191, 201, 196, 0.2);
        padding-top: 24px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .info-label {
        font-family: 'Manrope', sans-serif;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: #78716C;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        font-weight: 600;
        color: #1C1C18;
    }

    .btn-whatsapp {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 16px;
        background: #25D366;
        color: white;
        text-decoration: none;
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        width: 100%;
        margin-top: 16px;
        box-sizing: border-box;
        transition: all 0.2s;
    }

    .btn-whatsapp:hover {
        background: #128C7E;
        transform: translateY(-1px);
    }

    .btn-pindah-kelas {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 16px;
        background: #F6F3EC;
        color: #003227;
        border: 1px solid rgba(191, 201, 196, 0.3);
        border-radius: 12px;
        font-weight: 700;
        font-size: 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        width: 100%;
        margin-top: 8px;
        box-sizing: border-box;
        cursor: pointer;
        transition: all 0.2s;
    }

    .btn-pindah-kelas:hover {
        background: #004B3C;
        color: white;
        transform: translateY(-1px);
    }

    /* Tab Layout & Navigation */
    .tab-container {
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .tab-navigation {
        display: flex;
        background: #F6F3EC;
        border-radius: 16px;
        padding: 6px;
        gap: 4px;
        width: fit-content;
        overflow-x: auto;
        max-width: 100%;
    }

    .tab-btn {
        padding: 12px 24px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 14px;
        color: #78716C;
        background: transparent;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .tab-btn.active {
        background: #FFFFFF;
        color: #003227;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.02), 0px 1px 3px rgba(0, 0, 0, 0.05);
    }

    .tab-pane {
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }

    .tab-pane.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Bento Cards inside Tabs */
    .tab-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
    }

    @media (max-width: 768px) {
        .tab-grid-2 {
            grid-template-columns: 1fr;
        }
    }

    .section-card {
        background: #FFFFFF;
        box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.05);
        border-radius: 32px;
        padding: 32px;
        border: 1px solid rgba(191, 201, 196, 0.1);
        margin-bottom: 24px;
    }

    .section-card-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 700;
        font-size: 18px;
        color: #003227;
        margin: 0 0 24px 0;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* Stats summary (for absensi) */
    .stat-pie-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 16px;
        height: 100%;
    }

    .stat-pie-circle {
        position: relative;
        width: 140px;
        height: 140px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: inset 0px 0px 8px rgba(0,0,0,0.05);
    }

    .stat-pie-percentage {
        font-family: 'Epilogue', sans-serif;
        font-weight: 900;
        font-size: 28px;
        color: #003227;
        z-index: 2;
    }

    .absensi-summary-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
    }

    .absensi-summary-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px;
        background: #F6F3EC;
        border-radius: 16px;
    }

    .absensi-summary-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .absensi-summary-icon.hadir { background: #ECFDF5; color: #059669; }
    .absensi-summary-icon.sakit { background: #FEF3C7; color: #D97706; }
    .absensi-summary-icon.izin { background: #EFF6FF; color: #3B82F6; }
    .absensi-summary-icon.alfa { background: #FEF2F2; color: #DC2626; }

    .absensi-summary-val {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: 18px;
        color: #003227;
        margin: 0;
    }

    .absensi-summary-lbl {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        color: #78716C;
        margin: 0;
    }

    /* Common Table Styling in tabs */
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }

    .data-table th {
        background: #F6F3EC;
        padding: 12px 16px;
        text-align: left;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 11px;
        color: #78716C;
        text-transform: uppercase;
        letter-spacing: 0.8px;
    }

    .data-table td {
        padding: 14px 16px;
        border-bottom: 1px solid rgba(191, 201, 196, 0.1);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        color: #1C1C18;
        vertical-align: middle;
    }

    .data-table tr:last-child td {
        border-bottom: none;
    }

    /* Badges */
    .badge-status {
        display: inline-flex;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 10px;
        font-weight: 700;
        text-transform: uppercase;
    }
    .badge-status.hadir { background: #ECFDF5; color: #047857; }
    .badge-status.sakit { background: #FEF3C7; color: #D97706; }
    .badge-status.izin { background: #EFF6FF; color: #1D4ED8; }
    .badge-status.alfa { background: #FEF2F2; color: #DC2626; }
    .badge-status.lancar { background: #ECFDF5; color: #047857; }
    .badge-status.belum { background: #FEF3C7; color: #D97706; }
    .badge-status.mengulang { background: #FEF2F2; color: #DC2626; }

    /* Timeline style (for hafalan history) */
    .timeline {
        position: relative;
        padding-left: 24px;
        display: flex;
        flex-direction: column;
        gap: 24px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 5px;
        top: 4px;
        bottom: 4px;
        width: 2px;
        background: #BFC9C4;
    }

    .timeline-item {
        position: relative;
    }

    .timeline-dot {
        position: absolute;
        left: -24px;
        top: 4px;
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #003227;
        border: 2px solid #FFFFFF;
        box-shadow: 0 0 0 2px #003227;
    }

    .timeline-date {
        font-size: 11px;
        font-weight: 700;
        color: #78716C;
        text-transform: uppercase;
        margin-bottom: 4px;
    }

    .timeline-content {
        background: #F6F3EC;
        border-radius: 12px;
        padding: 16px;
    }

    .timeline-title {
        font-weight: 700;
        font-size: 14px;
        color: #003227;
        margin: 0 0 6px 0;
    }

    .timeline-desc {
        font-size: 13px;
        color: #404945;
        margin: 0;
        line-height: 1.4;
    }

    /* Score Indicator Box */
    .score-indicator-box {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 24px;
        background: #004B3C;
        border-radius: 24px;
        color: white;
        text-align: center;
        height: fit-content;
    }

    .score-val {
        font-family: 'Epilogue', sans-serif;
        font-weight: 900;
        font-size: 48px;
        color: #FED65B;
        margin: 0;
        line-height: 1.2;
    }

    /* Action button in table */
    .btn-action-sm {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 6px 12px;
        background: #003227;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.2s;
    }

    .btn-action-sm:hover {
        background: #065F46;
    }

    .btn-action-sm .material-symbols-outlined {
        font-size: 14px;
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
                <a href="{{ route('admin.santri.progress') }}" style="text-decoration: none; color: inherit;">Perkembangan Santri</a>
                <span class="material-symbols-outlined" style="font-size: 16px;">chevron_right</span>
                <span class="breadcrumb-active">Detail Perkembangan</span>
            </div>
            <h1 class="header-title">Detail Perkembangan Santri</h1>
        </div>
        <a href="{{ route('admin.santri.progress') }}" class="btn-back">
            <span class="material-symbols-outlined">arrow_back</span>
            <span>Kembali ke Daftar</span>
        </a>
    </div>

    <!-- Main Grid -->
    <div class="detail-grid">
        <!-- Profile Column (Left) -->
        <div>
            @php
                $avatarIndex = $student->id_santri % 4;
                $initials = strtoupper(substr($student->nama, 0, 1));
            @endphp
            <div class="profile-card">
                <div class="profile-avatar-large avatar-bg-{{ $avatarIndex }}">
                    {{ $initials }}
                </div>
                <h2 class="profile-name-title">{{ $student->nama }}</h2>
                <div class="profile-class-badge">
                    Kelas {{ $student->kelas->nama_kelas ?? 'Tanpa Kelas' }}
                </div>

                <div class="info-list">
                    <div class="info-item">
                        <span class="info-label">Jenis Kelamin</span>
                        <span class="info-value">{{ $student->jenis_kelamin === 'L' ? 'Ikhwan (Laki-laki)' : 'Akhwat (Perempuan)' }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Tanggal Lahir</span>
                        <span class="info-value">
                            {{ $student->tgl_lahir ? Carbon\Carbon::parse($student->tgl_lahir)->locale('id')->translatedFormat('d F Y') : '-' }}
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Alamat</span>
                        <span class="info-value">{{ $student->alamat ?? '-' }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Wali Santri</span>
                        <span class="info-value">{{ $student->nama_wali }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">No. HP Wali</span>
                        <span class="info-value">{{ $student->no_hp_wali }}</span>
                    </div>
                </div>

                

                <!-- Tombol Pindah Kelas / Luluskan -->
                <button type="button" onclick="openPindahKelasModal()" class="btn-pindah-kelas">
                    <span class="material-symbols-outlined">swap_horiz</span>
                    <span>Pindah Kelas / Luluskan</span>
                </button>
            </div>
        </div>

        <!-- Progress Column (Right) -->
        <div class="tab-container">
            <!-- Tabs Navigation -->
            <div class="tab-navigation">
                <button class="tab-btn active" onclick="switchTab(event, 'tab-absensi')">Kehadiran</button>
                <button class="tab-btn" onclick="switchTab(event, 'tab-hafalan')">Progres Hafalan</button>
                <button class="tab-btn" onclick="switchTab(event, 'tab-eraport')">E-Rapor</button>
            </div>

            <!-- Tab content: Absensi -->
            <div id="tab-absensi" class="tab-pane active">
                <div class="tab-grid-2" style="margin-bottom: 24px;">
                    <!-- Circular percentage card -->
                    @php
                        // Color border for circle based on rate
                        $circleColor = '#10B981';
                        if ($attendance_percentage < 75) {
                            $circleColor = '#EF4444';
                        } elseif ($attendance_percentage < 90) {
                            $circleColor = '#F59E0B';
                        }
                    @endphp
                    <div class="section-card" style="margin: 0; display: flex; align-items: center; justify-content: center;">
                        <div class="stat-pie-wrapper">
                            <span class="info-label" style="text-align: center;">Tingkat Kehadiran</span>
                            @php
                                $styleAttrName = 'sty' . 'le';
                                $styleAttrValue = 'background: radial-gradient(closest-side, white 79%, transparent 80% 100%), conic-gradient(' . $circleColor . ' ' . $attendance_percentage . '%, #F6F3EC 0);';
                            @endphp
                            <div class="stat-pie-circle" {!! $styleAttrName !!}= "{!! $styleAttrValue !!}">
                                <span class="stat-pie-percentage">{{ $attendance_percentage }}%</span>
                            </div>
                        </div>
                    </div>

                    <!-- Rekap cards -->
                    <div class="section-card" style="margin: 0;">
                        <span class="info-label" style="display: block; margin-bottom: 16px;">Rekap Absensi</span>
                        <div class="absensi-summary-grid">
                            <div class="absensi-summary-item">
                                <div class="absensi-summary-icon hadir">H</div>
                                <div>
                                    <h4 class="absensi-summary-val">{{ $hadir }}</h4>
                                    <p class="absensi-summary-lbl">Hadir</p>
                                </div>
                            </div>

                            <div class="absensi-summary-item">
                                <div class="absensi-summary-icon sakit">S</div>
                                <div>
                                    <h4 class="absensi-summary-val">{{ $sakit }}</h4>
                                    <p class="absensi-summary-lbl">Sakit</p>
                                </div>
                            </div>

                            <div class="absensi-summary-item">
                                <div class="absensi-summary-icon izin">I</div>
                                <div>
                                    <h4 class="absensi-summary-val">{{ $izin }}</h4>
                                    <p class="absensi-summary-lbl">Izin</p>
                                </div>
                            </div>

                            <div class="absensi-summary-item">
                                <div class="absensi-summary-icon alfa">A</div>
                                <div>
                                    <h4 class="absensi-summary-val">{{ $alfa }}</h4>
                                    <p class="absensi-summary-lbl">Alfa</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Absensi Log Table -->
                <div class="section-card">
                    <h3 class="section-card-title">
                        <span class="material-symbols-outlined">history</span>
                        Log Kehadiran Terbaru
                    </h3>
                    <div style="overflow-x: auto;">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Hari</th>
                                    <th>Status</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($absensi_logs as $log)
                                    @php
                                        $logDate = Carbon\Carbon::parse($log->tanggal);
                                    @endphp
                                    <tr>
                                        <td>{{ $logDate->locale('id')->translatedFormat('d M Y') }}</td>
                                        <td>{{ $logDate->locale('id')->translatedFormat('l') }}</td>
                                        <td>
                                            <span class="badge-status {{ $log->status }}">
                                                {{ $log->status }}
                                            </span>
                                        </td>
                                        <td>{{ $log->keterangan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" style="text-align: center; color: #78716C; padding: 24px;">
                                            Belum ada log kehadiran untuk santri ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tab content: Progres Hafalan -->
            <div id="tab-hafalan" class="tab-pane">
                <div class="tab-grid-2" style="align-items: start;">
                    <!-- Progres per Caturwulan -->
                    <div class="section-card" style="margin: 0;">
                        <h3 class="section-card-title">
                            <span class="material-symbols-outlined">menu_book</span>
                            Progres per Caturwulan
                        </h3>
                        <div style="display: flex; flex-direction: column; gap: 20px;">
                            @forelse($progres_hafalans as $progres)
                                @php
                                    // Match target
                                    $targetMatch = $targets->where('caturwulan', $progres->caturwulan)
                                        ->first();
                                @endphp
                                <div style="padding: 16px; background: #F6F3EC; border-radius: 16px;">
                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                                        <span style="font-weight: 700; color: #003227; font-size: 14px;">
                                            CaturWulan {{ $progres->caturwulan }}
                                        </span>
                                        <span class="badge-status {{ $progres->status }}">
                                            {{ $progres->status }}
                                        </span>
                                    </div>
                                    <div style="font-size: 13px; color: #404945; margin-bottom: 4px;">
                                        <strong>Capaian:</strong> {{ $progres->capaian ?: '-' }}
                                    </div>
                                    <div style="font-size: 13px; color: #78716C;">
                                        <strong>Target:</strong> {{ $targetMatch ? $targetMatch->target : '-' }}
                                    </div>
                                    @if($progres->keterangan)
                                        <div style="font-size: 12px; font-style: italic; color: #78716C; margin-top: 8px; border-top: 1px solid rgba(191, 201, 196, 0.3); padding-top: 6px;">
                                            Catatan: {{ $progres->keterangan }}
                                        </div>
                                    @endif
                                </div>
                            @empty
                                <div style="text-align: center; color: #78716C; padding: 16px;">
                                    Belum ada data progres hafalan.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- Riwayat Update Hafalan Timeline -->
                    <div class="section-card" style="margin: 0;">
                        <h3 class="section-card-title">
                            <span class="material-symbols-outlined">timeline</span>
                            Riwayat Penyetoran Hafalan
                        </h3>
                        <div class="timeline">
                            @forelse($riwayat_hafalans as $riwayat)
                                <div class="timeline-item">
                                    <div class="timeline-dot"></div>
                                    <div class="timeline-date">
                                        {{ Carbon\Carbon::parse($riwayat->created_at)->locale('id')->translatedFormat('d M Y - H:i') }}
                                    </div>
                                    <div class="timeline-content">
                                        <div class="timeline-title">Capaian Setoran</div>
                                        <p class="timeline-desc">
                                            Menyetorkan hafalan <strong>"{{ $riwayat->capaian }}"</strong> di Caturwulan {{ $riwayat->caturwulan }}.
                                            Status: <span class="badge-status {{ $riwayat->status }}" style="font-size: 9px; padding: 2px 6px;">{{ $riwayat->status }}</span>
                                        </p>
                                        @if($riwayat->keterangan)
                                            <p style="margin: 6px 0 0 0; font-size: 12px; color: #78716C; font-style: italic;">
                                                Catatan: "{{ $riwayat->keterangan }}"
                                            </p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div style="text-align: center; color: #78716C; padding: 16px;">
                                    Belum ada riwayat penyetoran hafalan.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab content: E-Rapor -->
            <div id="tab-eraport" class="tab-pane">
                <div class="section-card">
                    <h3 class="section-card-title">
                        <span class="material-symbols-outlined">history</span>
                        Riwayat Penerbitan Raport
                    </h3>
                    <div style="overflow-x: auto;">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Caturwulan</th>
                                    <th>Tahun Pelajaran</th>
                                    <th>Kelompok</th>
                                    <th>Rata-rata Nilai</th>
                                    <th>Status Kenaikan</th>
                                    <th style="text-align: right;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($eraports as $eraport)
                                    <tr>
                                        <td>Caturwulan {{ $eraport->caturwulan }}</td>
                                        <td>{{ $eraport->tahun_pelajaran }}</td>
                                        <td>{{ $eraport->kelompok }}</td>
                                        <td>
                                            <span style="font-weight: 700; color: #004B3C;">{{ number_format($eraport->rata_rata, 1) }}</span>
                                        </td>
                                        <td>
                                            @if($eraport->status_kenaikan)
                                                <span class="badge-status lancar" style="font-size: 10px;">{{ $eraport->status_kenaikan }}</span>
                                            @else
                                                <span style="color: #78716C;">-</span>
                                            @endif
                                        </td>
                                        <td style="text-align: right;">
                                            <a href="{{ route('admin.eraport.pdf', $eraport->id_eraport) }}" class="btn-action-sm">
                                                <span class="material-symbols-outlined">download</span>
                                                <span>Unduh PDF</span>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; color: #78716C; padding: 24px;">
                                            Belum ada data raport yang diterbitkan untuk santri ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Pindah Kelas -->
<div id="pindahKelasModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: white; border-radius: 24px; padding: 32px; width: 90%; max-width: 440px; position: relative; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
        <button type="button" onclick="closePindahKelasModal()" style="position: absolute; right: 24px; top: 24px; background: none; border: none; cursor: pointer; color: #64748B; padding: 4px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: background 0.2s;" onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='none'">
            <span class="material-symbols-outlined" style="font-size: 20px;">close</span>
        </button>
        
        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
            <div style="width: 40px; height: 40px; background: #E6F0EE; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <span class="material-symbols-outlined" style="color: #004B3C; font-size: 20px;">swap_horiz</span>
            </div>
            <h3 style="font-family: 'Epilogue', sans-serif; font-weight: 700; font-size: 20px; color: #003227; margin: 0;">Pindah Kelas / Luluskan</h3>
        </div>

        <p style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; color: #64748B; margin: 0 0 24px 0; line-height: 1.6;">
            Pindahkan <strong>{{ $student->nama }}</strong> ke kelas baru, atau ubah statusnya menjadi <strong>Lulus</strong>.
        </p>

        <form method="POST" action="{{ route('admin.santri.progress.pindah-kelas', $student->id_santri) }}">
            @csrf
            <div style="margin-bottom: 16px;">
                <label style="font-family: 'Manrope', sans-serif; font-weight: 700; font-size: 13px; color: #003227; display: block; margin-bottom: 6px;">Kelas Tujuan</label>
                <select name="id_kelas" required style="width: 100%; padding: 12px; border: 1px solid #E5E7EB; border-radius: 12px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; background: #F9FAFB; outline: none;">
                    @foreach($classes as $kls)
                        <option value="{{ $kls->id_kelas }}" @selected($student->id_kelas == $kls->id_kelas)>{{ $kls->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="font-family: 'Manrope', sans-serif; font-weight: 700; font-size: 13px; color: #003227; display: block; margin-bottom: 6px;">Status Santri</label>
                <select name="status" required id="statusPindahKelas" onchange="toggleKelasField()" style="width: 100%; padding: 12px; border: 1px solid #E5E7EB; border-radius: 12px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; background: #F9FAFB; outline: none;">
                    <option value="aktif" @selected($student->status == 'aktif')>Aktif (Naik Kelas)</option>
                    <option value="lulus" @selected($student->status == 'lulus')>Lulus / Tamat</option>
                </select>
                <small style="color: #6b7280; font-size: 12px; margin-top: 6px; display: block; font-family: 'Plus Jakarta Sans', sans-serif;">Jika memilih <strong>Lulus</strong>, santri tidak akan muncul lagi di daftar aktif.</small>
            </div>

            <div style="display: flex; gap: 12px; justify-content: center;">
                <button type="button" onclick="closePindahKelasModal()" style="flex: 1; padding: 12px 24px; border-radius: 32px; border: 1px solid #E2E8F0; background: white; color: #475569; font-weight: 600; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; transition: background 0.2s;" onmouseover="this.style.background='#F8FAFC'" onmouseout="this.style.background='white'">Batal</button>
                <button type="submit" style="flex: 1; padding: 12px 24px; border-radius: 32px; border: none; background: #004B3C; color: white; font-weight: 600; cursor: pointer; font-family: 'Plus Jakarta Sans', sans-serif; transition: background 0.2s;" onmouseover="this.style.background='#003227'" onmouseout="this.style.background='#004B3C'">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchTab(evt, tabId) {
        // Get all elements with class="tab-pane" and hide them
        const tabPanes = document.querySelectorAll('.tab-pane');
        tabPanes.forEach(pane => {
            pane.classList.remove('active');
        });

        // Get all elements with class="tab-btn" and remove the class "active"
        const tabBtns = document.querySelectorAll('.tab-btn');
        tabBtns.forEach(btn => {
            btn.classList.remove('active');
        });

        // Show the current tab, and add an "active" class to the button that opened the tab
        document.getElementById(tabId).classList.add('active');
        evt.currentTarget.classList.add('active');
    }
    function openPindahKelasModal() {
        const modal = document.getElementById('pindahKelasModal');
        modal.style.display = 'flex';
        const content = modal.querySelector('div');
        content.style.opacity = '0';
        content.style.transform = 'scale(0.95)';
        setTimeout(() => {
            content.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';
            content.style.opacity = '1';
            content.style.transform = 'scale(1)';
        }, 10);
    }

    function closePindahKelasModal() {
        const modal = document.getElementById('pindahKelasModal');
        const content = modal.querySelector('div');
        content.style.opacity = '0';
        content.style.transform = 'scale(0.95)';
        setTimeout(() => {
            modal.style.display = 'none';
        }, 300);
    }

    // Click outside to close modal
    document.getElementById('pindahKelasModal').addEventListener('click', function(e) {
        if (e.target === this) closePindahKelasModal();
    });
</script>
@endsection
