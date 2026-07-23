@extends('layouts.admin')

@section('title', 'Admin - Laporan Perkembangan Santri')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .eraport-canvas {
            background: #FCF9F2;
            min-height: 100vh;
            padding: 40px 40px 100px 40px;
            /* Added margin bottom to give space */
            position: relative;
            overflow: hidden;
        }

        .main-container {
            position: relative;
            z-index: 1;
            max-width: 1000px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            gap: 40px;
            /* Increased gap for better spacing */
        }

        /* Hero Section */
        .hero-card {
            background: #004B3C;
            border-radius: 48px;
            padding: 40px;
            display: flex;
            align-items: center;
            gap: 32px;
            box-shadow: 0px 20px 25px -5px rgba(0, 0, 0, 0.1), 0px 8px 10px -6px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .hero-bg-icon {
            position: absolute;
            right: 40px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 160px;
            color: rgba(255, 255, 255, 0.05);
            pointer-events: none;
        }

        .hero-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 8px;
            z-index: 1;
        }

        .hero-label {
            font-family: 'Epilogue', sans-serif;
            font-weight: 700;
            font-size: 14px;
            letter-spacing: 1.4px;
            text-transform: uppercase;
            color: #735C00;
        }

        .hero-title {
            font-family: 'Epilogue', sans-serif;
            font-weight: 900;
            font-size: 30px;
            line-height: 38px;
            color: #FFFFFF;
            margin: 0;
        }

        .hero-subtitle {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 400;
            font-size: 16px;
            color: #7CBAA6;
            margin: 0;
        }

        .hero-icon-box {
            width: 160px;
            height: 160px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(6px);
            border-radius: 48px;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1;
        }

        .hero-icon-box .material-symbols-outlined {
            font-size: 64px;
            color: #FFE088;
            opacity: 0.8;
        }

        /* Section Styles */
        .section-card {
            background: #FFFFFF;
            /* Changed to white for better contrast */
            border: 1px solid rgba(0, 50, 39, 0.05);
            border-radius: 48px 48px 16px 16px;
            padding: 32px 32px 40px;
            display: flex;
            flex-direction: column;
            gap: 32px;
            box-shadow: 0px 4px 20px -10px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 24px;
        }

        .section-card:hover {
            transform: translateY(-2px);
            box-shadow: 0px 10px 25px -10px rgba(0, 0, 0, 0.08);
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 16px;
            border-bottom: 1px solid rgba(191, 201, 196, 0.15);
        }

        .section-icon {
            width: 32px;
            height: 32px;
            background: #EBE8E1;
            border-radius: 8px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #003227;
        }

        .section-icon .material-symbols-outlined {
            font-size: 18px;
        }

        .section-title {
            font-family: 'Epilogue', sans-serif;
            font-weight: 700;
            font-size: 18px;
            color: #003227;
            margin: 0;
        }

        /* Form Inputs */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 16px;
        }

        .form-label {
            font-family: 'Manrope', sans-serif;
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            color: #404945;
        }

        .custom-input {
            background: #F9F9F9;
            border-radius: 16px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            padding: 14px 20px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 16px;
            color: #1C1C18;
            width: 100%;
            box-sizing: border-box;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.02);
            outline: none;
            transition: all 0.3s ease;
        }

        .custom-input:focus {
            background: #FFFFFF;
            border-color: #004B3C;
            box-shadow: 0px 0px 0px 4px rgba(0, 75, 60, 0.1);
        }

        .custom-input::placeholder {
            color: #6B7280;
        }

        .custom-input::-webkit-calendar-picker-indicator {
            display: none !important;
        }

        /* Bento Grid */
        .bento-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        .bento-card-dark {
            background: #004B3C;
            border-radius: 24px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 24px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 24px;
        }

        .bento-card-dark:hover {
            transform: translateY(-4px);
            box-shadow: 0px 12px 24px -8px rgba(0, 75, 60, 0.4);
        }

        .bento-card-light {
            background: #F6F3EC;
            border: 1px solid rgba(0, 50, 39, 0.05);
            border-radius: 24px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 24px;
        }

        .bento-card-light:hover {
            transform: translateY(-4px);
            box-shadow: 0px 12px 24px -8px rgba(0, 0, 0, 0.06);
        }

        .bento-card-yellow {
            background: #FED65B;
            border-radius: 24px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 24px;
        }

        .bento-card-yellow:hover {
            transform: translateY(-4px);
            box-shadow: 0px 12px 24px -8px rgba(116, 92, 0, 0.3);
        }

        .bento-title-dark {
            font-family: 'Epilogue', sans-serif;
            font-weight: 700;
            font-size: 16px;
            color: #FFFFFF;
            padding-bottom: 12px;
            border-bottom: 1px solid rgba(124, 186, 166, 0.3);
            margin: 0;
        }

        .bento-title-light {
            font-family: 'Epilogue', sans-serif;
            font-weight: 700;
            font-size: 14px;
            color: #404945;
            margin: 0;
        }

        .bento-title-yellow {
            font-family: 'Epilogue', sans-serif;
            font-weight: 700;
            font-size: 14px;
            color: #745C00;
            margin: 0;
        }

        /* Nilai Inputs */
        .nilai-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .nilai-label-dark {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            color: #7CBAA6;
            flex: 1;
        }

        .nilai-label-light {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            color: #404945;
            flex: 1;
        }

        .nilai-label-yellow {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            color: #745C00;
            flex: 1;
        }

        .nilai-input-dark {
            background: #003227;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 10px 16px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 14px;
            color: #FFFFFF;
            width: 100px;
            text-align: center;
            outline: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .nilai-input-dark:focus,
        .nilai-input-dark:hover {
            background: #004B3C;
            border-color: rgba(255, 255, 255, 0.3);
        }

        .nilai-input-light {
            background: #FFFFFF;
            border-radius: 12px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            padding: 10px 16px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 14px;
            color: #1C1C18;
            width: 100px;
            text-align: center;
            outline: none;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .nilai-input-light:focus,
        .nilai-input-light:hover {
            border-color: #004B3C;
            box-shadow: 0px 2px 8px rgba(0, 0, 0, 0.05);
        }

        .nilai-input-yellow {
            background: rgba(255, 255, 255, 0.5);
            border-radius: 12px;
            border: 1px solid transparent;
            padding: 10px 16px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
            font-size: 16px;
            color: #1C1C18;
            width: 100px;
            text-align: center;
            outline: none;
            transition: all 0.3s ease;
        }

        .nilai-input-yellow:focus,
        .nilai-input-yellow:hover {
            background: rgba(255, 255, 255, 0.8);
            border-color: #745C00;
        }


        .grade-badge {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 36px;
            height: 36px;
            border-radius: 12px;
            font-family: 'Epilogue', sans-serif;
            font-weight: 700;
            font-size: 16px;
        }

        .grade-dark {
            background: rgba(255, 255, 255, 0.1);
            color: #FFFFFF;
        }

        .grade-light {
            background: rgba(0, 75, 60, 0.05);
            color: #004B3C;
        }

        /* Action Bar */
        .action-bar {
            display: flex;
            justify-content: flex-end;
            gap: 16px;
            margin-top: 24px;
        }

        .btn-outline {
            background: transparent;
            border: 2px solid #003227;
            color: #003227;
            padding: 14px 32px;
            border-radius: 48px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-outline:hover {
            background: rgba(0, 50, 39, 0.05);
        }

        .btn-primary {
            background: #003227;
            border: none;
            color: #FFFFFF;
            padding: 14px 32px;
            border-radius: 48px;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0px 10px 15px -3px rgba(0, 50, 39, 0.2);
            transition: all 0.2s;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
        }

        /* Utilities */
        .bento-grid-2-1 {
            grid-template-columns: 2fr 1fr;
        }

        .responsive-flex {
            display: flex;
            gap: 24px;
            width: 100%;
        }

        .cawu-container {
            display: flex;
            background: #F1EEE7;
            border-radius: 48px;
            padding: 6px;
            gap: 8px;
            width: fit-content;
        }

        /* Responsive Design for Tablet / Small Desktop */
        @media (max-width: 1024px) {
            .eraport-canvas {
                padding: 32px 24px 80px 24px;
            }

            .bento-grid,
            .bento-grid-2-1 {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .responsive-flex {
                flex-direction: column;
                gap: 16px;
            }
        }

        /* Responsive Design for Mobile */
        @media (max-width: 768px) {
            .eraport-canvas {
                padding: 24px 16px 80px 16px;
            }

            .hero-card {
                flex-direction: column-reverse;
                text-align: center;
                padding: 24px;
                border-radius: 32px;
            }

            .hero-icon-box {
                width: 100px;
                height: 100px;
            }

            .hero-icon-box .material-symbols-outlined {
                font-size: 40px;
            }

            .hero-bg-icon {
                display: none;
            }

            .section-card {
                padding: 24px 16px;
                border-radius: 24px 24px 12px 12px;
            }

            .bento-grid,
            .bento-grid-2-1 {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .responsive-flex {
                flex-direction: column;
                gap: 16px;
            }

            .cawu-container {
                flex-wrap: wrap;
                border-radius: 24px;
                width: 100%;
                justify-content: center;
            }

            .cawu-label {
                font-size: 12px !important;
                padding: 8px 16px !important;
            }

            .nilai-input-dark,
            .nilai-input-light,
            .nilai-input-yellow {
                width: 60px !important;
            }

            .grade-badge {
                width: 30px;
                height: 30px;
                font-size: 14px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="eraport-canvas">
        <div class="main-container">

            <!-- Hero Decoration -->
            <div class="hero-card">
                <span class="material-symbols-outlined hero-bg-icon">school</span>
                <div class="hero-content">
                    <span class="hero-label">E-Rapor</span>
                    <h2 class="hero-title">Laporan Perkembangan Santri</h2>
                    <p class="hero-subtitle">Isi dan cetak evaluasi lengkap pencapaian belajar santri per caturwulan.</p>
                </div>
                <div class="hero-icon-box">
                    <span class="material-symbols-outlined">menu_book</span>
                </div>
            </div>

            <form action="{{ route('admin.eraport.store') }}" method="POST">
                @csrf

                @if(session('success'))
                    <div class="alert alert-success"
                        style="background: #D1FAE5; border: 1px solid #A7F3D0; padding: 24px; border-radius: 24px; margin-bottom: 24px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 16px; box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.1);">
                        <div style="display: flex; align-items: center; gap: 16px;">
                            <div style="min-width: 48px; width: 48px; height: 48px; border-radius: 16px; background: #34D399; color: #FFFFFF; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px -1px rgba(52, 211, 153, 0.3);">
                                <span class="material-symbols-outlined">check_circle</span>
                            </div>
                            <div>
                                <h4 style="margin: 0; font-family: 'Epilogue', sans-serif; font-weight: 700; font-size: 16px; color: #065F46;">Berhasil!</h4>
                                <p style="margin: 4px 0 0 0; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; color: #065F46; opacity: 0.9;">{{ session('success') }}</p>
                            </div>
                        </div>
                        @if(session('last_id_eraport'))
                            <a href="{{ route('admin.eraport.pdf', session('last_id_eraport')) }}"
                                style="display: inline-flex; align-items: center; gap: 8px; background: #004B3C; color: #FFFFFF; padding: 12px 24px; border-radius: 9999px; text-decoration: none; font-family: 'Epilogue', sans-serif; font-weight: 700; font-size: 14px; transition: all 0.3s ease; box-shadow: 0 10px 15px -3px rgba(0, 75, 60, 0.2);">
                                <span class="material-symbols-outlined" style="font-size: 20px;">print</span> Cetak PDF Sekarang
                            </a>
                        @endif
                    </div>
                @endif

                <!-- Section 1: Identitas & Cawu -->
                <div class="section-card">
                    <div class="section-header">
                        <div class="section-icon"><span class="material-symbols-outlined">badge</span></div>
                        <h3 class="section-title">Identitas Santri & Caturwulan</h3>
                    </div>

                    <div class="form-group" style="margin-bottom: 24px;">
                        <label class="form-label" style="margin-bottom: 12px; display: block;">PILIH CATURWULAN</label>
                        <div class="cawu-container">
                            <label style="cursor: pointer;">
                                <input type="radio" name="caturwulan" value="1" class="cawu-radio" style="display: none;"
                                    checked>
                                <div class="cawu-label"
                                    style="padding: 10px 24px; border-radius: 32px; font-family: 'Epilogue'; font-weight: 700; font-size: 14px; transition: all 0.3s;">
                                    Caturwulan I (Juli - Okt)</div>
                            </label>
                            <label style="cursor: pointer;">
                                <input type="radio" name="caturwulan" value="2" class="cawu-radio" style="display: none;">
                                <div class="cawu-label"
                                    style="padding: 10px 24px; border-radius: 32px; font-family: 'Epilogue'; font-weight: 700; font-size: 14px; transition: all 0.3s;">
                                    Caturwulan II (Nov - Feb)</div>
                            </label>
                            <label style="cursor: pointer;">
                                <input type="radio" name="caturwulan" value="3" class="cawu-radio" style="display: none;">
                                <div class="cawu-label"
                                    style="padding: 10px 24px; border-radius: 32px; font-family: 'Epilogue'; font-weight: 700; font-size: 14px; transition: all 0.3s;">
                                    Caturwulan III (Mar - Jun)</div>
                            </label>
                        </div>
                    </div>

                    <div id="status_kenaikan_container" class="form-group"
                        style="margin-bottom: 24px; display: none; background: #E6F0EE; padding: 20px; border-radius: 24px; border: 1px solid rgba(0, 50, 39, 0.1);">
                        <label class="form-label" style="color: #003227; margin-bottom: 8px; display: block;">STATUS
                            KENAIKAN / KELULUSAN</label>
                        <select name="status_kenaikan" class="custom-input"
                            style="background: #FFFFFF; border-color: rgba(0, 50, 39, 0.2); font-weight: 600; color: #003227;">
                            <option value="">-- Pilih Status Kenaikan --</option>
                            <option value="Naik">Pindah Jilid / Kelas</option>
                            <option value="Tetap">Tinggal di Jilid / Kelas</option>
                            <option value="Lulus">Tamat / Lulus</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">NAMA LENGKAP SANTRI</label>
                        <select name="id_santri" id="santri_name_input" class="custom-input" required
                            style="width:100%; background:#F8FAFC; border:1px solid #CBD5E1; border-radius:12px; padding:12px 16px;">
                            <option value="">-- Pilih Santri --</option>
                            @foreach($santris as $santri)
                                <option value="{{ $santri->id_santri }}">{{ $santri->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="bento-grid">
                        <div class="form-group">
                            <label class="form-label">KELOMPOK</label>
                            <input type="text" name="kelompok" id="kelompok_input" class="custom-input"
                                placeholder="Otomatis terisi..." readonly required style="background: rgba(0,0,0,0.02);">
                        </div>
                        <div class="form-group">
                            <label class="form-label">TAHUN PELAJARAN</label>
                            <select name="tahun_pelajaran" class="custom-input" required style="background: #FFFFFF; border-color: rgba(0, 50, 39, 0.2); font-weight: 600; color: #003227;">
                                @php
                                    $currentMonth = (int)date('n');
                                    $currentYear = (int)date('Y');
                                    $taStart = ($currentMonth >= 7) ? $currentYear : $currentYear - 1;
                                    if ($taStart < 2026) $taStart = 2026;
                                    $defaultTA = $taStart . '/' . ($taStart + 1);
                                    
                                    $startYearList = 2026;
                                    for($i = 0; $i < 4; $i++) {
                                        $y = $startYearList + $i;
                                        $tp = $y . '/' . ($y + 1);
                                        $selected = ($defaultTA == $tp) ? 'selected' : '';
                                        echo '<option value="'.$tp.'" '.$selected.'>'.$tp.'</option>';
                                    }
                                @endphp
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Nilai Mata Pelajaran -->
                <div class="section-card">
                    <div class="section-header" style="margin-bottom: 8px;">
                        <div class="section-icon"><span class="material-symbols-outlined">auto_stories</span></div>
                        <h3 class="section-title">Nilai Mata Pelajaran</h3>
                    </div>
                    <p style="font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; color: #404945; margin-top: 0; margin-bottom: 24px; display: flex; align-items: center; gap: 8px; padding: 12px 16px; background: #FFF9E6; border-radius: 12px; border-left: 4px solid #FBBF24;">
                        <span class="material-symbols-outlined" style="color: #D97706; font-size: 20px;">info</span>
                        Silakan isi semua kolom nilai di bawah dengan skala <strong>0 - 100</strong>. Anda diwajibkan mengisi seluruh nilai agar laporan dapat disimpan.
                    </p>

                    <div class="bento-grid">
                        <!-- Al-Qur'an Card (Dark) -->
                        <div class="bento-card-dark" style="grid-row: span 2;">
                            <h4 class="bento-title-dark">Al-Qur'an</h4>

                            <div class="nilai-row">
                                <span class="nilai-label-dark">TAJWID</span>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <input type="number" name="nilai_tajwid" class="nilai-input-dark hitung-nilai" min="0"
                                        max="100" style="width: 70px; padding: 10px 8px;" placeholder="Nilai" required>
                                    <span class="grade-badge grade-dark" id="grade_nilai_tajwid">-</span>
                                </div>
                            </div>
                            <div class="nilai-row">
                                <span class="nilai-label-dark">FASHAHAH</span>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <input type="number" name="nilai_fashahah" class="nilai-input-dark hitung-nilai" min="0"
                                        max="100" style="width: 70px; padding: 10px 8px;" placeholder="Nilai" required>
                                    <span class="grade-badge grade-dark" id="grade_nilai_fashahah">-</span>
                                </div>
                            </div>
                            <div class="nilai-row">
                                <span class="nilai-label-dark">IRAMA / LAGU</span>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <input type="number" name="nilai_irama" class="nilai-input-dark hitung-nilai" min="0"
                                        max="100" style="width: 70px; padding: 10px 8px;" placeholder="Nilai" required>
                                    <span class="grade-badge grade-dark" id="grade_nilai_irama">-</span>
                                </div>
                            </div>
                            <div class="nilai-row">
                                <span class="nilai-label-dark">ADAB</span>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <input type="number" name="nilai_adab" class="nilai-input-dark hitung-nilai" min="0"
                                        max="100" style="width: 70px; padding: 10px 8px;" placeholder="Nilai" required>
                                    <span class="grade-badge grade-dark" id="grade_nilai_adab">-</span>
                                </div>
                            </div>
                        </div>

                        <!-- Praktek Ibadah Card -->
                        <div class="bento-card-light">
                            <div class="nilai-row">
                                <span class="nilai-label-light">PRAKTEK IBADAH</span>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <input type="number" name="nilai_ibadah" class="nilai-input-light hitung-nilai" min="0"
                                        max="100" style="width: 70px; padding: 10px 8px;" placeholder="Nilai" required>
                                    <span class="grade-badge grade-light" id="grade_nilai_ibadah">-</span>
                                </div>
                            </div>
                            <div class="nilai-row">
                                <span class="nilai-label-light">HAFALAN DOA HARIAN</span>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <input type="number" name="nilai_doa" class="nilai-input-light hitung-nilai" min="0"
                                        max="100" style="width: 70px; padding: 10px 8px;" placeholder="Nilai" required>
                                    <span class="grade-badge grade-light" id="grade_nilai_doa">-</span>
                                </div>
                            </div>
                            <div class="nilai-row">
                                <span class="nilai-label-light">HAFALAN SURAT PENDEK</span>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <input type="number" name="nilai_surat" class="nilai-input-light hitung-nilai" min="0"
                                        max="100" style="width: 70px; padding: 10px 8px;" placeholder="Nilai" required>
                                    <span class="grade-badge grade-light" id="grade_nilai_surat">-</span>
                                </div>
                            </div>
                        </div>

                        <!-- Sejarah & Dakwah Card -->
                        <div class="bento-card-light">
                            <div class="nilai-row">
                                <span class="nilai-label-light">SEJARAH ISLAM</span>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <input type="number" name="nilai_sejarah" class="nilai-input-light hitung-nilai" min="0"
                                        max="100" style="width: 70px; padding: 10px 8px;" placeholder="Nilai" required>
                                    <span class="grade-badge grade-light" id="grade_nilai_sejarah">-</span>
                                </div>
                            </div>
                            <div class="nilai-row">
                                <span class="nilai-label-light">DAKWAH / PIDATO</span>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <input type="number" name="nilai_dakwah" class="nilai-input-light hitung-nilai" min="0"
                                        max="100" style="width: 70px; padding: 10px 8px;" placeholder="Nilai" required>
                                    <span class="grade-badge grade-light" id="grade_nilai_dakwah">-</span>
                                </div>
                            </div>
                            <div class="nilai-row">
                                <span class="nilai-label-light">AKHLAK & KHAT</span>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <input type="number" name="nilai_akhlak" class="nilai-input-light hitung-nilai" min="0"
                                        max="100" style="width: 70px; padding: 10px 8px;" placeholder="Nilai" required>
                                    <span class="grade-badge grade-light" id="grade_nilai_akhlak">-</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Section 3: Ekstra, Rekap, Kepribadian -->
                <div class="bento-grid bento-grid-2-1">

                    <div class="section-card" style="margin-bottom: 0;">
                        <div class="section-header">
                            <div class="section-icon"><span class="material-symbols-outlined">extension</span></div>
                            <h3 class="section-title">Ekstra & Kepribadian</h3>
                        </div>

                        <div class="bento-grid">
                            <!-- Ekstrakurikuler -->
                            <div class="bento-card-light">
                                <h4 class="bento-title-light">Ekstrakurikuler</h4>
                                <div class="nilai-row">
                                    <span class="nilai-label-light">DIDIKAN SUBUH</span>
                                    <select name="ekstra_subuh" class="nilai-input-light">
                                        <option value="A">A</option>
                                        <option value="B" selected>B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                                <div class="nilai-row">
                                    <span class="nilai-label-light">QASIDAH/REBANA</span>
                                    <select name="ekstra_rebana" class="nilai-input-light">
                                        <option value="A">A</option>
                                        <option value="B" selected>B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                                <div class="nilai-row">
                                    <span class="nilai-label-light">OLAHRAGA</span>
                                    <select name="ekstra_olahraga" class="nilai-input-light">
                                        <option value="A">A</option>
                                        <option value="B" selected>B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Kepribadian -->
                            <div class="bento-card-light">
                                <h4 class="bento-title-light">Kepribadian</h4>
                                <div class="nilai-row">
                                    <span class="nilai-label-light">DISIPLIN</span>
                                    <select name="sikap_disiplin" class="nilai-input-light">
                                        <option value="A">A</option>
                                        <option value="B" selected>B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>
                                <div class="nilai-row">
                                    <span class="nilai-label-light">KEBERSIHAN</span>
                                    <select name="sikap_kebersihan" class="nilai-input-light">
                                        <option value="A">A</option>
                                        <option value="B" selected>B</option>
                                        <option value="C">C</option>
                                        <option value="D">D</option>
                                    </select>
                                </div>

                                <h4 class="bento-title-light" style="margin-top: 8px;">Ketidakhadiran</h4>
                                <div class="nilai-row">
                                    <span class="nilai-label-light">SAKIT</span>
                                    <input type="number" name="absen_sakit" class="nilai-input-light" style="width: 60px;"
                                        placeholder="0" min="0">
                                </div>
                                <div class="nilai-row">
                                    <span class="nilai-label-light">IZIN</span>
                                    <input type="number" name="absen_izin" class="nilai-input-light" style="width: 60px;"
                                        placeholder="0" min="0">
                                </div>
                                <div class="nilai-row">
                                    <span class="nilai-label-light">ALPA</span>
                                    <input type="number" name="absen_alpa" class="nilai-input-light" style="width: 60px;"
                                        placeholder="0" min="0">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Rekap Nilai Section (Yellow) -->
                    <div class="section-card" style="background: #FED65B; border-color: transparent; margin-bottom: 0;">
                        <div class="section-header" style="border-bottom-color: rgba(116, 92, 0, 0.15);">
                            <div class="section-icon" style="background: transparent; color: #745C00;"><span
                                    class="material-symbols-outlined">analytics</span></div>
                            <h3 class="section-title" style="color: #745C00;">Rekap Nilai</h3>
                        </div>

                        <div class="bento-card-yellow" style="background: transparent; padding: 0; box-shadow: none;">
                            <div class="nilai-row">
                                <span class="nilai-label-yellow">JUMLAH NILAI</span>
                                <input type="text" name="jumlah_nilai" class="nilai-input-yellow" value="845" readonly>
                            </div>
                            <div class="nilai-row">
                                <span class="nilai-label-yellow">NILAI RATA-RATA</span>
                                <input type="text" name="rata_rata" class="nilai-input-yellow" value="84.5" readonly>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Section: Catatan Guru -->
                <div class="section-card" style="margin-top: 24px;">
                    <div class="section-header">
                        <div class="section-icon"><span class="material-symbols-outlined">edit_note</span></div>
                        <h3 class="section-title">Catatan Guru / Wali Kelas</h3>
                    </div>
                    <div class="form-group" style="margin-top: 16px;">
                        <textarea name="catatan_guru" class="custom-input" rows="4"
                            placeholder="Tuliskan catatan perkembangan, motivasi, atau pesan untuk santri..."
                            style="resize: vertical; padding: 16px; border-radius: 16px;"></textarea>
                    </div>
                </div>

                <!-- Section 4: Pengesahan & Pelaporan -->
                <div class="section-card"
                    style="background: #F6F3EC; border-radius: 48px 48px 8px 8px; padding: 32px; gap: 24px; display: flex; flex-direction: column; margin-top: 24px;">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <span class="material-symbols-outlined" style="color: #003227; font-size: 20px;">draw</span>
                        <h4
                            style="font-family: 'Epilogue', sans-serif; font-weight: 700; font-size: 16px; color: #003227; margin: 0;">
                            Pengesahan & Pelaporan</h4>
                    </div>

                    <div class="responsive-flex">
                        <!-- KEPALA TPA -->
                        <div style="display: flex; flex-direction: column; gap: 4px; flex: 1;">
                            <label
                                style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; font-size: 10px; text-transform: uppercase; color: #404945;">KEPALA
                                TPA</label>
                            <input type="text" name="kepala_tpa" value="H. Ahmad Syukron, S.Pd.I"
                                style="background: #FFFFFF; border-radius: 32px; border: none; padding: 12px 16px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; color: #1C1C18; outline: none; width: 100%; box-sizing: border-box;"
                                required>
                        </div>

                        <!-- USTADZ / USTADZAH -->
                        <div style="display: flex; flex-direction: column; gap: 4px; flex: 1;">
                            <label
                                style="font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 600; font-size: 10px; text-transform: uppercase; color: #404945;">USTADZ
                                / USTADZAH</label>
                            <input type="text" name="nama_pengajar" value="{{ auth()->user()->pengajar ? auth()->user()->pengajar->nama : auth()->user()->name }}"
                                style="background: rgba(0,0,0,0.02); border-radius: 32px; border: none; padding: 12px 16px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 16px; color: #1C1C18; outline: none; width: 100%; box-sizing: border-box;"
                                readonly required>
                        </div>
                    </div>

                    <input type="hidden" name="tanggal_pelaporan" value="{{ date('Y-m-d') }}">

                    <div
                        style="border-top: 1px solid rgba(191, 201, 196, 0.3); padding-top: 24px; display: flex; flex-direction: column; align-items: center; gap: 24px; width: 100%; margin-top: 8px;">
                        <p
                            style="font-family: 'Manrope', sans-serif; font-size: 14px; color: #404945; text-align: center; margin: 0;">
                            Pastikan semua nilai dan data sudah benar sebelum menyimpan laporan.</p>

                        <button type="submit"
                            style="display: flex; align-items: center; justify-content: center; gap: 12px; background: #003227; border-radius: 9999px; padding: 20px 48px; border: none; cursor: pointer; color: #FFFFFF; font-family: 'Epilogue', sans-serif; font-weight: 800; font-size: 18px; box-shadow: 0px 25px 50px -12px rgba(0, 50, 39, 0.4); width: 100%; max-width: 403px; transition: all 0.3s ease;">
                            <span class="material-symbols-outlined">save</span>
                            Simpan E-Rapor
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        @php
            $santriMap = [];
            foreach($santris as $santri) {
                $santriMap[$santri->id_santri] = $santri->kelas->nama_kelas ?? '';
            }
        @endphp
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Initialize Tom Select untuk Searchable Dropdown Santri
                new TomSelect("#santri_name_input", {
                    create: false,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    },
                    placeholder: "-- Ketik atau Pilih Nama Santri --"
                });
                const inputs = document.querySelectorAll('.hitung-nilai');
                const jumlahInput = document.querySelector('input[name="jumlah_nilai"]');
                const rataInput = document.querySelector('input[name="rata_rata"]');

                function getGrade(score) {
                    if (score >= 90) return 'A';
                    if (score >= 80) return 'B';
                    if (score >= 70) return 'C';
                    if (score >= 60) return 'D';
                    return 'E';
                }

                function calculateTotals() {
                    let total = 0;
                    let count = 0;

                    inputs.forEach(input => {
                        let val = parseFloat(input.value);
                        if (!isNaN(val)) {
                            total += val;
                            count++;
                        }

                        // Update badge
                        const badge = document.getElementById('grade_' + input.name);
                        if (badge) {
                            badge.textContent = !isNaN(val) ? getGrade(val) : '-';
                        }
                    });

                    if (count > 0) {
                        jumlahInput.value = total;
                        rataInput.value = (total / count).toFixed(1);
                    } else {
                        jumlahInput.value = '';
                        rataInput.value = '';
                    }
                }

                inputs.forEach(input => {
                    input.addEventListener('input', calculateTotals);
                });

                calculateTotals();



                // Auto-fill kelompok/kelas
                const santriData = JSON.parse('{!! addslashes(json_encode($santriMap)) !!}');

            const santriInput = document.getElementById('santri_name_input');
            const kelompokInput = document.getElementById('kelompok_input');

            santriInput.addEventListener('input', function () {
                const nama = this.value;
                if (santriData[nama]) {
                    kelompokInput.value = santriData[nama];
                } else {
                    kelompokInput.value = '';
                }

                // --- AUTO FILL ABSENSI ---
                function fetchAbsensi() {
                    const id_santri = document.getElementById('santri_name_input').value;
                    const caturwulan = document.querySelector('input[name="caturwulan"]:checked').value;
                    const tahun_pelajaran = document.querySelector('select[name="tahun_pelajaran"]').value;

                    if (id_santri && caturwulan && tahun_pelajaran) {
                        fetch(`{{ route('admin.eraport.get_absensi') }}?id_santri=${id_santri}&caturwulan=${caturwulan}&tahun_pelajaran=${tahun_pelajaran}`)
                            .then(response => response.json())
                            .then(data => {
                                document.querySelector('input[name="absen_sakit"]').value = data.sakit;
                                document.querySelector('input[name="absen_izin"]').value = data.izin;
                                document.querySelector('input[name="absen_alpa"]').value = data.alfa;
                            })
                            .catch(error => console.error('Error fetching absensi:', error));
                    }
                }

                // Listen for changes
                document.getElementById('santri_name_input').addEventListener('change', fetchAbsensi);
                document.querySelector('select[name="tahun_pelajaran"]').addEventListener('change', fetchAbsensi);
                cawuRadios.forEach(radio => {
                    radio.addEventListener('change', fetchAbsensi);
                });
                
            });

            // Caturwulan Radio Button Logic
            const cawuRadios = document.querySelectorAll('.cawu-radio');
            const cawuLabels = document.querySelectorAll('.cawu-label');
            const statusKenaikanContainer = document.getElementById('status_kenaikan_container');

            function updateCawuStyle() {
                cawuRadios.forEach((radio, index) => {
                    if (radio.checked) {
                        cawuLabels[index].style.background = '#FFFFFF';
                        cawuLabels[index].style.color = '#735C00';
                        cawuLabels[index].style.border = '2px solid rgba(115, 92, 0, 0.2)';
                        cawuLabels[index].style.boxShadow = '0 2px 4px rgba(0,0,0,0.05)';

                        if (radio.value === '3') {
                            statusKenaikanContainer.style.display = 'block';
                        } else {
                            statusKenaikanContainer.style.display = 'none';
                            document.querySelector('select[name="status_kenaikan"]').value = '';
                        }
                    } else {
                        cawuLabels[index].style.background = 'transparent';
                        cawuLabels[index].style.color = '#6B7280';
                        cawuLabels[index].style.border = '2px solid transparent';
                        cawuLabels[index].style.boxShadow = 'none';
                    }
                });
            }

            cawuRadios.forEach(radio => {
                radio.addEventListener('change', updateCawuStyle);
            });

            // Initialize style on load
            updateCawuStyle();
            });
        </script>
    @endpush

@endsection