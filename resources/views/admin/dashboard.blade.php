@extends('layouts.admin')

@section('title', 'Admin Dashboard - TPA Baitur Ridwan')

@push('styles')
<style>
    /* Dashboard Layout */
    .dashboard-container {
        display: flex;
        flex-direction: column;
        gap: 32px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Section 1: Welcome Panel */
    .welcome-panel {
        position: relative;
        background: linear-gradient(135deg, #003227 0%, #004B3C 50%, #065F46 100%);
        box-shadow: 0px 20px 25px -5px rgba(0, 0, 0, 0.1), 0px 8px 10px -6px rgba(0, 0, 0, 0.1);
        border-radius: 48px;
        padding: 40px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        gap: 24px;
        color: white;
    }

    .welcome-icon-bg {
        position: absolute;
        right: -5%;
        top: 0%;
        opacity: 0.1;
        font-size: 300px;
        line-height: 1;
        font-family: 'Material Symbols Outlined';
        transform: rotate(12deg);
        user-select: none;
    }

    .welcome-badge {
        display: inline-flex;
        align-items: center;
        background: #FED65B;
        border-radius: 9999px;
        padding: 4px 16px;
        color: #745C00;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 12px;
        width: fit-content;
        margin-bottom: 20px;
    }

    .welcome-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: 36px;
        margin: 0 0 8px 0;
        letter-spacing: -0.9px;
    }

    .welcome-desc {
        font-size: 18px;
        color: rgba(209, 250, 229, 0.8);
        margin: 0;
        max-width: 672px;
        line-height: 1.5;
    }

    .welcome-date-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(6px);
        border-radius: 48px;
        padding: 16px 32px;
        width: fit-content;
        gap: 40px;
        z-index: 1;
    }

    .date-text {
        font-family: 'Epilogue', sans-serif;
        font-style: italic;
        font-weight: 300;
        font-size: 20px;
        color: #FFE088;
        margin: 0;
    }

    .time-text {
        font-size: 12px;
        color: rgba(167, 243, 208, 0.6);
        margin: 0;
    }

    /* Section 2: Key Statistics */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
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

    .stat-icon-wrapper.santri { background: rgba(0, 75, 60, 0.1); color: #003227; }
    .stat-icon-wrapper.pengajar { background: rgba(254, 214, 91, 0.2); color: #735C00; }
    .stat-icon-wrapper.hadir { background: #D1FAE5; color: #065F46; }

    .stat-trend {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 12px;
    }

    .stat-trend.up { color: #059669; }
    .stat-trend.down { color: #DC2626; }

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

    /* Main Content Grid */
    .content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 32px;
    }

    .col-left {
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    .col-right {
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    /* Cards generic */
    .card-box {
        background: #FFFFFF;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
        border-radius: 32px;
        padding: 32px;
    }

    .card-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 700;
        font-size: 20px;
        color: #003227;
        margin: 0;
    }

    /* Chart Placeholder */
    .chart-container {
        height: 200px;
        display: flex;
        align-items: flex-end;
        gap: 16px;
        margin-top: 32px;
        padding-top: 16px;
        border-bottom: 1px solid #E5E7EB;
    }

    .chart-bar-group {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        height: 100%;
        gap: 8px;
    }

    .chart-bar {
        width: 100%;
        border-radius: 16px 16px 0 0;
        background: #ECFDF5;
        position: relative;
    }

    .chart-bar-inner {
        position: absolute;
        bottom: 0;
        width: 100%;
        border-radius: 16px 16px 0 0;
        background: #004B3C;
    }
    .chart-bar-inner.highlight { background: #735C00; }
    
    .chart-label {
        font-size: 10px;
        font-weight: 700;
        color: #404945;
    }

    /* Quick Actions */
    .quick-actions {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 16px;
        margin-top: 24px;
    }

    .action-btn {
        background: #F6F3EC;
        border-radius: 24px;
        padding: 24px 16px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        border: none;
        cursor: pointer;
        transition: transform 0.2s;
    }

    .action-btn:hover {
        transform: translateY(-4px);
    }

    .action-icon {
        color: #003227;
    }

    .action-label {
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 12px;
        color: #1C1C18;
        text-align: center;
    }

    /* Aktivitas Terbaru */
    .activity-card {
        background: linear-gradient(135deg, #003227 0%, #004B3C 50%, #065F46 100%);
        color: white;
    }

    .activity-card .card-title {
        color: white;
    }

    .activity-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-top: 24px;
    }



    .activity-item {
        background: #FFFFFF;
        box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
        border-radius: 24px;
        padding: 16px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(0, 50, 39, 0.1);
        display: flex;
        justify-content: center;
        align-items: center;
        color: #004B3C;
    }

    .activity-info {
        display: flex;
        flex-direction: column;
    }

    .activity-title {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 14px;
        color: #003227;
        margin: 0;
    }

    .activity-time {
        font-size: 12px;
        color: #404945;
        margin: 0;
    }

</style>
@endpush

@section('content')
<div class="dashboard-container">
    
    <!-- SECTION 1: Welcome Panel -->
    <div class="welcome-panel">
        <span class="material-symbols-outlined welcome-icon-bg">mosque</span>
        
        <div>
            <div class="welcome-badge">{{ strtoupper(auth()->user()->role ?? 'ADMINISTRATOR') }}</div>
            <h2 class="welcome-title">Assalamu'alaikum, {{ explode(' ', auth()->user()->name ?? 'Admin')[0] }}</h2>
            <p class="welcome-desc">Selamat datang di Sistem Informasi TPA Baitur Ridwan. Mari wujudkan generasi Qur'ani yang berakhlak mulia.</p>
        </div>

        <div class="welcome-date-card">
            <h3 class="date-text">{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('l, d F Y') }}</h3>
            <p class="time-text">Pembaruan sistem terakhir: Hari ini</p>
        </div>
    </div>

    <!-- SECTION 2: Key Statistics -->
    <div class="stats-grid">
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

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon-wrapper pengajar">
                    <span class="material-symbols-outlined">school</span>
                </div>
                <span class="stat-trend up">Total</span>
            </div>
            <div>
                <p class="stat-label">Total Pengajar</p>
                <h3 class="stat-value">{{ $total_pengajar }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon-wrapper hadir">
                    <span class="material-symbols-outlined">event_available</span>
                </div>
                @if($total_absensi > 0)
                    <span class="stat-trend {{ $persentase_hadir >= 80 ? 'up' : 'down' }}">{{ $persentase_hadir >= 80 ? 'Baik' : 'Kurang' }}</span>
                @else
                    <span class="stat-trend">Belum Ada</span>
                @endif
            </div>
            <div>
                <p class="stat-label">Kehadiran Hari Ini</p>
                <h3 class="stat-value">{{ $total_absensi > 0 ? $persentase_hadir . '%' : '-' }}</h3>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon-wrapper santri">
                    <span class="material-symbols-outlined">how_to_reg</span>
                </div>
                <span class="stat-trend up">Aktif</span>
            </div>
            <div>
                <p class="stat-label">Santri Aktif</p>
                <h3 class="stat-value">{{ $santri_aktif }}</h3>
            </div>
        </div>
    </div>

    <!-- Main Grid -->
    <div class="content-grid">
        <!-- Left Column -->
        <div class="col-left">
            <!-- SECTION 3: Grafik Aktivitas -->
            <div class="card-box">
                <h3 class="card-title">Grafik Kehadiran Mingguan</h3>
                
                <div class="chart-container">
                    @foreach($weekly_attendance as $data)
                    <div class="chart-bar-group">
                        <div class="chart-bar" style="height: 100%;" title="{{ $data['percentage'] }}% Kehadiran">
                            @php
                                $styleAttrName = 'sty' . 'le';
                                $styleAttrValue = 'height: ' . $data['percentage'] . '%;';
                            @endphp
                            <div class="chart-bar-inner {{ $data['percentage'] >= 90 ? 'highlight' : '' }}" {!! $styleAttrName !!}="{!! $styleAttrValue !!}"></div>
                        </div>
                        <span class="chart-label">{{ $data['day'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- SECTION 7: Quick Actions -->
            <div style="margin-top: -16px;">
                <h3 class="card-title">Aksi Cepat</h3>
                <div class="quick-actions">
                    @php
                        $onSantri = 'onclick="window.location=\'' . route('admin.santri.index') . '\'"';
                        $onAbsensi = 'onclick="window.location=\'' . route('admin.absensi') . '\'"';
                        $onProgress = 'onclick="window.location=\'' . route('admin.santri.progress') . '\'"';
                        $onHafalan = 'onclick="window.location=\'' . route('admin.hafalan') . '\'"';
                        $onPengumuman = 'onclick="window.location=\'' . route('admin.pengumuman') . '\'"';
                    @endphp
                    <button class="action-btn" {!! $onSantri !!}>
                        <span class="material-symbols-outlined action-icon">group</span>
                        <span class="action-label">Data Santri</span>
                    </button>
                    <button class="action-btn" {!! $onAbsensi !!}>
                        <span class="material-symbols-outlined action-icon">event_available</span>
                        <span class="action-label">Absensi</span>
                    </button>
                    <button class="action-btn" {!! $onProgress !!}>
                        <span class="material-symbols-outlined action-icon">trending_up</span>
                        <span class="action-label">Perkembangan</span>
                    </button>
                    <button class="action-btn" {!! $onHafalan !!}>
                        <span class="material-symbols-outlined action-icon">menu_book</span>
                        <span class="action-label">Hafalan</span>
                    </button>
                    <button class="action-btn" {!! $onPengumuman !!}>
                        <span class="material-symbols-outlined action-icon">campaign</span>
                        <span class="action-label">Pengumuman</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-right">
            <!-- SECTION IURAN: Hanya untuk Admin -->
            @if(auth()->check() && auth()->user()->role === 'admin')
            <div class="card-box" style="background: linear-gradient(135deg, #21443aff 0%, #059669 100%); color: white;">
                <h3 class="card-title" style="color: white;">Info Iuran Bulan Ini</h3>
                <div style="margin-top: 16px; display: flex; align-items: center; gap: 16px;">
                    <div class="activity-icon" style="background: rgba(255, 255, 255, 0.2); color: white;">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <div>
                        <p style="margin: 0; font-size: 14px; font-weight: 500; opacity: 0.9;">Total Terkumpul</p>
                        <h2 style="margin: 4px 0 0 0; font-family: 'Epilogue', sans-serif; font-weight: 800;">Rp {{ number_format($total_iuran ?? 0, 0, ',', '.') }}</h2>
                    </div>
                </div>
            </div>
            @endif

            <!-- SECTION 6: Aktivitas Terbaru -->
            <div class="card-box activity-card">
                <h3 class="card-title">Aktivitas Hafalan Terbaru</h3>
                
                <div class="activity-list">
                    @forelse($aktivitas_terbaru as $aktivitas)
                    <div class="activity-item">
                        <div class="activity-icon" style="background: rgba(254, 214, 91, 0.2); color: #735C00;">
                            <span class="material-symbols-outlined">menu_book</span>
                        </div>
                        <div class="activity-info">
                            <p class="activity-title" style="color: #003227; font-weight: 700; font-size: 13px;">
                                {{ $aktivitas->santri->nama ?? 'Santri' }}: "{{ $aktivitas->capaian }}"
                            </p>
                            <p style="font-size: 11px; color: #78716C; margin: 2px 0 0 0; font-weight: 600;">
                                Status: {{ strtoupper($aktivitas->status) }}
                            </p>
                            <p class="activity-time" style="margin-top: 4px;">
                                {{ \Carbon\Carbon::parse($aktivitas->created_at)->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="activity-item" style="justify-content: center; background: transparent; box-shadow: none;">
                        <p class="activity-time" style="color: rgba(209, 250, 229, 0.8);">Belum ada aktivitas terbaru.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
