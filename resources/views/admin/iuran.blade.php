@extends('layouts.admin')

@section('title', 'Admin - Data Iuran')

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

    /* Original Iuran Cards */
    .iuran-cards-grid {
        display: grid;
        grid-template-columns: repeat(1, 1fr);
        gap: 24px;
        margin-bottom: 40px;
    }

    @media (min-width: 768px) {
        .iuran-cards-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    .iuran-card {
        border-radius: 24px;
        padding: 24px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        gap: 24px;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .iuran-card:hover {
        transform: translateY(-4px);
    }

    .iuran-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s;
    }

    .iuran-card:hover .iuran-icon-box {
        transform: scale(1.05);
    }
    
    .iuran-card-title {
        font-family: 'Manrope', sans-serif;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        margin: 0 0 4px 0;
    }
    
    .iuran-card-amount {
        font-family: 'Epilogue', sans-serif;
        font-size: 30px;
        font-weight: 800;
        letter-spacing: -0.025em;
        margin: 0;
        line-height: 1.2;
    }

    /* Card 1: Total Terkumpul */
    .card-terkumpul {
        background-color: #004b3c;
        color: #FFFFFF;
    }
    .card-terkumpul .iuran-icon-box {
        background-color: #facc15;
        color: #713f12;
    }
    .card-terkumpul .iuran-card-title {
        color: rgba(209, 250, 229, 0.7);
    }
    .card-terkumpul .card-glow {
        position: absolute;
        right: -48px;
        top: -48px;
        width: 160px;
        height: 160px;
        background-color: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        filter: blur(24px);
        transition: background-color 0.2s;
    }
    .card-terkumpul:hover .card-glow {
        background-color: rgba(255, 255, 255, 0.1);
    }

    /* Card 2: Santri Lunas */
    .card-lunas {
        background-color: #FFFFFF;
        border: 1px solid rgba(191, 201, 196, 0.1);
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }
    .card-lunas .iuran-icon-box {
        background-color: #022c22;
        color: #d1fae5;
    }
    .card-lunas:hover .iuran-icon-box {
        transform: scale(1.05) rotate(3deg);
    }
    .card-lunas .iuran-card-title {
        color: #a8a29e;
    }
    .card-lunas .iuran-card-amount {
        color: #022c22;
    }
    .card-lunas .lunas-max {
        color: #a8a29e;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 16px;
    }
    .lunas-progress-bg {
        width: 100%;
        height: 8px;
        background-color: #fafaf9;
        border-radius: 9999px;
        overflow: hidden;
        margin-top: 12px;
    }
    .lunas-progress-fill {
        height: 100%;
        background-color: #022c22;
        border-radius: 9999px;
    }

    /* Card 3: Tunggakan */
    .card-tunggakan {
        background-color: #fed65b;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    }
    .card-tunggakan .iuran-icon-box {
        background-color: rgba(113, 63, 18, 0.1);
        color: #713f12;
    }
    .card-tunggakan .iuran-card-title {
        color: rgba(113, 63, 18, 0.6);
    }
    .card-tunggakan .iuran-card-amount {
        color: #422006;
    }
    .card-tunggakan .tunggakan-sub {
        color: rgba(113, 63, 18, 0.7);
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 14px;
        font-weight: 700;
        margin: 4px 0 0 0;
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

    .avatar-bg-0 { background: #B0EFDA; color: #003227; }
    .avatar-bg-1 { background: #FFE088; color: #241A00; }
    .avatar-bg-2 { background: #E9E2D3; color: #1E1B13; }
    .avatar-bg-3 { background: #95D3BF; color: #002019; }

    .text-main {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 16px;
        color: #064E3B;
        margin: 0;
    }
    
    .text-amount {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 800;
        font-size: 16px;
        color: #003227;
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

    .badge-lunas { background: #D1FAE5; color: #047857; }
    .badge-menunggak { background: #FEE2E2; color: #B91C1C; }
    .badge-belum { background: #F3F4F6; color: #4B5563; }

    /* Actions */
    .actions-cell {
        display: flex;
        justify-content: flex-end;
        align-items: center;
        gap: 8px;
    }
    
    .action-btn-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12px;
        font-weight: 700;
        color: #065F46;
        background: transparent;
        border: none;
        cursor: pointer;
        text-decoration: underline;
    }
    
    .action-btn-text:hover {
        color: #003227;
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
    
    .btn-add-mini {
        background: #F6F3EC;
        color: #003227;
        padding: 6px 12px;
        border-radius: 999px;
        border: none;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 12px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 4px;
        transition: all 0.2s;
    }
    
    .btn-add-mini:hover {
        background: #E9E2D3;
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
    
    .modal-container.danger-modal {
        max-width: 400px;
        text-align: center;
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

    .form-control[readonly] {
        background: #F3F4F6;
        color: #6B7280;
        cursor: not-allowed;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 24px;
    }
    
    .form-actions.center {
        justify-content: center;
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
    
    .danger-btn {
        background: #DC2626;
        border: none;
        color: #FFFFFF;
        padding: 12px 24px;
        border-radius: 9999px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        box-shadow: 0px 4px 6px -4px rgba(220, 38, 38, 0.2);
        transition: background 0.2s;
    }
    
    .danger-btn:hover {
        background: #B91C1C;
    }

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

        .data-table th, .data-table td {
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
@php
    $percentage = $total_santri > 0 ? round(($lunas_count / $total_santri) * 100) : 0;
    $default_iuran = 15000;
    
    // Deadline logic for WA reminder
    $bulan_array_flip = ['Januari'=>1, 'Februari'=>2, 'Maret'=>3, 'April'=>4, 'Mei'=>5, 'Juni'=>6, 'Juli'=>7, 'Agustus'=>8, 'September'=>9, 'Oktober'=>10, 'November'=>11, 'Desember'=>12];
    $bulan_num = $bulan_array_flip[(string) $bulan] ?? 1;
    $deadlineDate = \Carbon\Carbon::create($tahun, $bulan_num, 7)->endOfDay();
    $isPastDeadline = now()->isAfter($deadlineDate);
@endphp

<div class="content-canvas">

    @if(session('success'))
        <div style="background-color: #D1FAE5; border: 1px solid #10B981; color: #065F46; padding: 16px 24px; border-radius: 16px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; display: flex; align-items: center; gap: 8px;">
            <span class="material-symbols-outlined" style="font-size: 20px;">check_circle</span>
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div style="background-color: #FEE2E2; border: 1px solid #EF4444; color: #991B1B; padding: 16px 24px; border-radius: 16px; font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600;">
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
                <span class="breadcrumb-active">Iuran Santri</span>
            </div>
            <h2 class="header-title">Iuran Santri</h2>
            <p class="header-subtitle">Kelola pembayaran SPP dan pantau tunggakan bulan <span style="font-weight: 700; color: #003227;">{{ $bulan }} {{ $tahun }}</span>.</p>
        </div>
    </div>

    <!-- Stats Overview - Original Style -->
    <div class="iuran-cards-grid">
        <!-- TOTAL TERKUMPUL -->
        <div class="iuran-card card-terkumpul">
            <div class="card-glow"></div>
            <div style="position: relative; z-index: 10; display: flex; flex-direction: column; height: 100%; justify-content: space-between; gap: 24px;">
                <div class="iuran-icon-box">
                    <span class="material-symbols-outlined">account_balance_wallet</span>
                </div>
                <div>
                    <p class="iuran-card-title">Total Terkumpul</p>
                    <h2 class="iuran-card-amount">Rp {{ number_format($total_terkumpul, 0, ',', '.') }}</h2>
                </div>
            </div>
        </div>

        <!-- SANTRI LUNAS -->
        <div class="iuran-card card-lunas">
            <div class="iuran-icon-box">
                <span class="material-symbols-outlined">verified_user</span>
            </div>
            <div>
                <p class="iuran-card-title">Santri Lunas</p>
                <div style="display: flex; align-items: baseline; gap: 8px; margin-bottom: 12px;">
                    <h2 class="iuran-card-amount">{{ $lunas_count }}</h2>
                    <span class="lunas-max">/ {{ $total_santri }}</span>
                </div>
                @php 
                    $progressStyle = 'style="width: ' . $percentage . '%;"';
                @endphp
                <div class="lunas-progress-bg">
                    <div class="lunas-progress-fill" {!! $progressStyle !!}></div>
                </div>
            </div>
        </div>

        <!-- TOTAL TUNGGAKAN -->
        <div class="iuran-card card-tunggakan">
            <div class="iuran-icon-box">
                <span class="material-symbols-outlined">warning</span>
            </div>
            <div>
                <p class="iuran-card-title">Total Tunggakan</p>
                <h2 class="iuran-card-amount">Rp {{ number_format($tunggakan_amount + ($santri_tunggakan_count * $default_iuran) - $tunggakan_amount, 0, ',', '.') }}</h2>
                <p class="tunggakan-sub">{{ $santri_tunggakan_count }} Santri</p>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="table-section">
        <div class="table-header-bar">
            <div class="table-title">
                <div class="title-indicator"></div>
                <span>Daftar Pembayaran</span>
            </div>
            <!-- Search & Filters -->
            <form method="GET" action="{{ route('admin.iuran') }}" class="search-filter-form" id="filterForm">
                <div class="search-input-wrapper">
                    <span class="material-symbols-outlined search-icon">search</span>
                    <input type="text" id="searchInput" placeholder="Cari nama santri..." autocomplete="off" class="input-search">
                </div>
                <select name="bulan" class="filter-select" onchange="this.form.submit()">
                    @foreach($all_months as $m)
                        <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
                <select name="tahun" class="filter-select" onchange="this.form.submit()">
                    @foreach($years as $y)
                        <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
                <select name="status" class="filter-select" onchange="this.form.submit()">
                    <option value="semua" {{ $status == 'semua' ? 'selected' : '' }}>Semua Status</option>
                    <option value="lunas" {{ $status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="tunggakan" {{ $status == 'tunggakan' ? 'selected' : '' }}>Tunggakan</option>
                </select>
            </form>
        </div>

        <div class="table-responsive">
            <table class="data-table iuran-table">
                <thead>
                    <tr>
                        <th style="padding-left: 32px;">Nama Santri</th>
                        <th style="text-align: center;">Tanggal Dibayar</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th style="text-align: right; padding-right: 32px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($santris as $santri)
                        @php
                            $pembayaran = $santri->pembayarans->first();
                            if ($pembayaran && $pembayaran->status == 'lunas') {
                                $isLunas = true;
                                $statusBadge = 'LUNAS';
                            } else {
                                $isLunas = false;
                                $statusBadge = $isPastDeadline ? 'MENUNGGAK' : 'BELUM BAYAR';
                            }
                            $nominal = $pembayaran ? $pembayaran->jumlah : $default_iuran;
                            
                            $nameParts = explode(' ', $santri->nama);
                            $initial = count($nameParts) > 1 
                                ? strtoupper($nameParts[0][0] . $nameParts[1][0]) 
                                : strtoupper($nameParts[0][0]);
                                
                            $bgClass = 'avatar-bg-' . ($santri->id_santri % 4);

                            if ($statusBadge == 'MENUNGGAK') {
                                $waPesan = "Assalamu'alaikum Warahmatullahi Wabarakatuh.\n\nYth. Bapak/Ibu Wali Santri dari ananda {$santri->nama},\n\nKami menginformasikan bahwa saat ini sudah melewati batas waktu pembayaran (tanggal 7) untuk Iuran SPP TPA Baitur Ridwan bulan {$bulan} {$tahun}, namun status pembayaran ananda masih *MENUNGGAK*.\n\nMohon kerjasamanya untuk dapat segera melakukan pelunasan sebesar Rp " . number_format($nominal, 0, ',', '.') . ".\nAbaikan pesan ini jika sudah membayar.\n\nTerima kasih.\n\nWassalamu'alaikum Warahmatullahi Wabarakatuh.";
                                $waText = urlencode($waPesan);
                            }
                        @endphp
                        <tr>
                            <td style="padding-left: 32px;">
                                <div class="profile-group">
                                    <div class="profile-initial {{ $bgClass }}">
                                        {{ $initial }}
                                    </div>
                                    <p class="text-main student-name">{{ $santri->nama }}</p>
                                </div>
                            </td>
                            <td style="text-align: center;">
                                @if($pembayaran && $pembayaran->tanggal_bayar)
                                    <span class="text-data-muted bg-stone-50 px-2 py-1" style="border-radius: 6px; font-size: 12px; font-weight: 600;">
                                        {{ \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d M Y') }}
                                    </span>
                                @else
                                    <span class="text-data-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <p class="text-amount">Rp {{ number_format($nominal, 0, ',', '.') }}</p>
                            </td>
                            <td>
                                @if($isLunas)
                                    <span class="badge badge-lunas">Lunas</span>
                                @elseif($statusBadge == 'MENUNGGAK')
                                    <span class="badge badge-menunggak">Menunggak</span>
                                @else
                                    <span class="badge badge-belum">Belum Bayar</span>
                                @endif
                            </td>
                            <td style="padding-right: 32px;">
                                <div class="actions-cell">
                                    @if($statusBadge == 'MENUNGGAK')
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $santri->no_hp_wali ?? '') }}?text={{ $waText ?? '' }}" target="_blank" class="action-btn-text" style="margin-right: 12px;">Ingatkan WA</a>
                                    @elseif($statusBadge == 'BELUM BAYAR')
                                        <span class="text-data-muted" style="font-size: 10px; font-style: italic; margin-right: 12px;" title="Baru bisa diingatkan setelah tgl 7">Belum Jatuh Tempo</span>
                                    @endif
                                    
                                    @if($pembayaran)
                                        @php
                                            $tglStr = $pembayaran->tanggal_bayar ? $pembayaran->tanggal_bayar->format('Y-m-d') : '';
                                            $onclickEdit = 'onclick="openEditModal(' . $pembayaran->id_pembayaran . ', ' . $pembayaran->jumlah . ', \'' . $pembayaran->status . '\', \'' . $tglStr . '\')"';
                                            $onclickDelete = 'onclick="openDeleteModal(' . $pembayaran->id_pembayaran . ')"';
                                        @endphp
                                        <button type="button" class="action-btn" {!! $onclickEdit !!} title="Edit">
                                            <span class="material-symbols-outlined" style="font-size: 18px;">edit</span>
                                        </button>
                                        <button type="button" class="action-btn btn-delete" {!! $onclickDelete !!} title="Hapus">
                                            <span class="material-symbols-outlined" style="font-size: 18px;">delete</span>
                                        </button>
                                    @else
                                        @php
                                            $namaS = htmlspecialchars(addslashes($santri->nama));
                                            $onclickCreate = 'onclick="openCreateModalForSantri(' . $santri->id_santri . ', \'' . $namaS . '\')"';
                                        @endphp
                                        <button type="button" class="btn-add-mini" {!! $onclickCreate !!} title="Catat Iuran">
                                            <span class="material-symbols-outlined" style="font-size: 14px;">add</span> Catat
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 48px; color: #A8A29E;">
                                <span class="material-symbols-outlined" style="font-size: 48px; margin-bottom: 16px; opacity: 0.5;">payments</span>
                                <p style="font-family: 'Plus Jakarta Sans', sans-serif; margin: 0; font-weight: 700;">Belum ada data</p>
                                <p style="font-family: 'Plus Jakarta Sans', sans-serif; margin: 4px 0 0 0; font-size: 14px;">Tidak ada data santri ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="pagination-bar">
            <span class="text-data-muted">Menampilkan {{ $santris->count() }} data</span>
        </div>
    </div>
</div>

<!-- Modal Catat Pembayaran -->
<div class="modal-overlay" id="createModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Catat Pembayaran</h3>
            <button type="button" class="modal-close" onclick="closeModal('createModal')">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form action="{{ route('admin.iuran.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label">Nama Santri</label>
                <input type="hidden" name="id_santri" id="create_id_santri" required>
                <input type="text" id="create_nama_santri" class="form-control" readonly>
            </div>
            
            <input type="hidden" name="bulan" value="{{ $bulan }}">
            <input type="hidden" name="tahun" value="{{ $tahun }}">
            
            <div class="form-group">
                <label class="form-label">Nominal (Rp)</label>
                <input type="number" name="jumlah" class="form-control" value="{{ $default_iuran }}" required>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Tanggal Bayar</label>
                    <input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="lunas">Lunas</option>
                        <option value="belum">Tunggakan</option>
                    </select>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="closeModal('createModal')">Batal</button>
                <button type="submit" class="save-btn">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Edit Pembayaran -->
<div class="modal-overlay" id="editModal">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Edit Pembayaran</h3>
            <button type="button" class="modal-close" onclick="closeModal('editModal')">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="editForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label class="form-label">Nominal (Rp)</label>
                <input type="number" name="jumlah" id="editJumlah" class="form-control" required>
            </div>
            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Tanggal Bayar</label>
                    <input type="date" name="tanggal_bayar" id="editTanggal" class="form-control">
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <select name="status" id="editStatus" class="form-control" required>
                        <option value="lunas">Lunas</option>
                        <option value="belum">Tunggakan</option>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <button type="button" class="cancel-btn" onclick="closeModal('editModal')">Batal</button>
                <button type="submit" class="save-btn">Update Data</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Hapus Pembayaran -->
<div id="deleteModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center; backdrop-filter: blur(4px);">
    <div style="background: white; border-radius: 24px; padding: 32px; width: 90%; max-width: 400px; position: relative; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);">
        <button type="button" onclick="closeDeleteModal()" style="position: absolute; right: 24px; top: 24px; background: none; border: none; cursor: pointer; color: #64748B; padding: 4px; display: flex; align-items: center; justify-content: center; border-radius: 50%; transition: background 0.2s;" onmouseover="this.style.background='#F1F5F9'" onmouseout="this.style.background='none'">
            <span class="material-symbols-outlined" style="font-size: 20px;">close</span>
        </button>
        
        <h3 style="font-family: 'Epilogue', sans-serif; font-weight: 700; font-size: 20px; color: #003227; margin: 0 0 16px 0;">Hapus Data Pembayaran</h3>
        
        <p style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; color: #64748B; margin: 0 0 32px 0; line-height: 1.6;">
            Apakah Anda yakin ingin menghapus data pembayaran ini? Tindakan ini bersifat permanen dan tidak dapat dibatalkan.
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
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }
    
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }

    function openCreateModalForSantri(santriId, santriName) {
        document.getElementById('create_id_santri').value = santriId;
        document.getElementById('create_nama_santri').value = santriName;
        openModal('createModal');
    }

    function openEditModal(id, jumlah, status, tanggal) {
        const form = document.getElementById('editForm');
        form.action = `{{ url('/admin/iuran') }}/${id}`;
        
        document.getElementById('editJumlah').value = jumlah;
        document.getElementById('editStatus').value = status;
        document.getElementById('editTanggal').value = tanggal;
        
        openModal('editModal');
    }

    function openDeleteModal(id) {
        const form = document.getElementById('deleteForm');
        form.action = `{{ url('/admin/iuran') }}/${id}`;
        
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

    // Real-time search filter
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('.iuran-table tbody tr');
        
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
@endsection
