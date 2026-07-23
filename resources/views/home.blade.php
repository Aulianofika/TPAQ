@extends('layouts.layout')

@section('title', 'TPA Al-Quran — Taman Pendidikan Al-Quran')
@section('meta_description', 'Taman Pendidikan Al-Quran — Tempat belajar membaca Al-Quran, adab, dan ilmu agama Islam dengan penuh kasih dan keikhlasan.')

@push('styles')
    <style>
        /* ===========================
           HERO SECTION
        =========================== */
        .hero {
            position: relative;
            width: 100%;
            min-height: 100vh;
            background: var(--green-deep);
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            isolation: isolate;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1585036156171-384164a8c675?w=1400&q=80');
            background-size: cover;
            background-position: center;
            opacity: 0.25;
            z-index: 0;
        }

        .hero-gradient {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0, 50, 39, 0.6) 0%, rgba(0, 50, 39, 0.8) 50%, #003227 100%);
            z-index: 1;
        }

        .hero-pattern {
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23FED65B' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 1;
            opacity: 0.6;
        }

        .hero-wave {
            position: absolute;
            left: 0;
            right: 0;
            bottom: -1px;
            z-index: 2;
            line-height: 0;
        }

        .hero-wave svg {
            width: 100%;
            height: 80px;
            /* Lebar lengkungan lebih rendah / proporsional */
            display: block;
        }

        .hero-content {
            position: relative;
            z-index: 3;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            max-width: 932px;
            padding: 0 24px;
            padding-top: 64px; /* Geser sedikit, tidak terlalu ekstrem */
        }

        .hero-bismillah {
            font-family: 'Scheherazade New', 'FreeSerif', serif;
            font-weight: 400;
            font-size: clamp(40px, 5vw, 64px);
            line-height: 1.2;
            color: #FBBF24;
            margin-bottom: 24px;
            opacity: 0.9;
            animation: fadeInDown 0.8s ease forwards;
        }

        .hero-title {
            font-family: 'Epilogue', sans-serif;
            font-weight: 900;
            font-size: clamp(48px, 6.5vw, 84px);
            line-height: 1;
            letter-spacing: -3.5px;
            color: var(--white);
            margin-bottom: 24px;
            animation: fadeInUp 0.8s ease 0.1s both;
        }

        .hero-subtitle {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 300;
            font-size: clamp(16px, 2.2vw, 20px);
            line-height: 1.5;
            color: var(--green-teal);
            margin-bottom: 40px;
            max-width: 672px;
            animation: fadeInUp 0.8s ease 0.2s both;
        }

        .hero-buttons {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            gap: 24px;
            animation: fadeInUp 0.8s ease 0.3s both;
        }

        .btn-primary {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 18px 40px;
            background: #FED65B;
            border-radius: 9999px;
            font-family: 'Manrope', sans-serif;
            font-weight: 700;
            font-size: 18px;
            color: #745C00;
            text-decoration: none;
            position: relative;
            box-shadow: 0px 20px 25px -5px rgba(0, 50, 39, 0.4), 0px 8px 10px -6px rgba(0, 50, 39, 0.4);
            transition: all 0.25s ease;
            isolation: isolate;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0px 25px 30px -5px rgba(0, 50, 39, 0.5), 0px 12px 14px -6px rgba(0, 50, 39, 0.4);
            background: #FFE088;
        }

        .btn-secondary {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 16px 40px;
            border: 2px solid #B0EFDA;
            border-radius: 9999px;
            font-family: 'Manrope', sans-serif;
            font-weight: 700;
            font-size: 18px;
            color: #B0EFDA;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .btn-secondary:hover {
            background: rgba(176, 239, 218, 0.1);
            transform: translateY(-2px);
        }

        .scroll-indicator {
            position: absolute;
            bottom: 24px; /* Pindahkan lebih ke bawah (di atas area gelombang) */
            left: 50%;
            transform: translateX(-50%);
            z-index: 3;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            animation: fadeIn 1s ease 1s both;
        }

        .scroll-indicator span {
            font-family: 'Manrope', sans-serif;
            font-size: 12px;
            font-weight: 500;
            color: rgba(124, 186, 166, 0.6);
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .scroll-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--green-mint);
            animation: scrollBounce 1.5s ease infinite;
        }

        /* ===========================
           QURAN INSPIRATION SECTION
        =========================== */
        .quran-section {
            width: 100%;
            background: var(--cream);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 96px 24px 64px;
            overflow: hidden;
        }

        .quran-section::before {
            content: '';
            position: absolute;
            left: 8.5%;
            right: 8.5%;
            top: 0;
            bottom: 21%;
            background: rgba(254, 214, 91, 0.05);
        }

        .quran-card-wrapper {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: center;
            width: 100%;
            max-width: 896px;
        }

        .quran-card-border {
            display: flex;
            padding: 4px;
            background: linear-gradient(135deg, #FED65B 0%, #735C00 100%);
            border-radius: 9999px;
        }

        .quran-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 80px;
            gap: 16px;
            background: var(--cream);
            box-shadow: 0px 25px 50px -12px rgba(0, 0, 0, 0.25);
            border-radius: 9999px;
            position: relative;
            overflow: hidden;
        }

        .quran-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(255, 224, 136, 0.1);
            pointer-events: none;
        }

        .quran-arabic {
            font-family: 'Scheherazade New', 'FreeSerif', 'Times New Roman', serif;
            font-weight: 400;
            font-size: 60px;
            line-height: 1;
            color: var(--green-deep);
            text-align: center;
            direction: rtl;
        }

        .quran-surah {
            font-family: 'Epilogue', sans-serif;
            font-weight: 700;
            font-size: 24px;
            line-height: 32px;
            color: var(--text-dark);
            text-align: center;
            padding-top: 16px;
        }

        .quran-translation {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-style: italic;
            font-weight: 300;
            font-size: 18px;
            line-height: 29px;
            color: #404945;
            text-align: center;
            max-width: 548px;
        }

        /* ===========================
           PRAYER SCHEDULE SECTION
        =========================== */
        .prayer-section {
            width: 100%;
            background: var(--cream-alt);
            padding: 64px 0 96px;
        }

        .prayer-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            flex-direction: column;
            gap: 64px;
        }

        .section-header {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .section-title {
            font-family: 'Epilogue', sans-serif;
            font-weight: 900;
            font-size: 48px;
            line-height: 48px;
            color: var(--green-deep);
            margin-bottom: 16px;
        }

        .section-underline {
            width: 96px;
            height: 6px;
            background: var(--gold-dark);
            border-radius: 9999px;
        }

        .prayer-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 16px;
            width: 100%;
        }

        .prayer-card {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 24px;
            gap: 12px;
            background: var(--white);
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.03);
            border-radius: 24px;    
            border: 1px solid rgba(0, 50, 39, 0.05);
            transition: all 0.3s ease;
        }

        .prayer-card:hover {
            transform: translateY(-4px);
            box-shadow: 0px 12px 24px rgba(0, 50, 39, 0.08);
            border-color: rgba(0, 50, 39, 0.1);
        }

        .prayer-card.active-prayer {
            background: var(--green-deep);
            border-color: var(--green-deep);
            transform: scale(1.05);
            box-shadow: 0px 16px 32px rgba(0, 50, 39, 0.2);
        }

        .prayer-card.active-prayer .prayer-name,
        .prayer-card.active-prayer .prayer-time {
            color: var(--white);
        }

        .prayer-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold-dark);
            margin-bottom: 4px;
        }

        .prayer-card.active-prayer .prayer-icon {
            color: var(--gold-light) !important;
        }

        .prayer-name {
            font-family: 'Manrope', sans-serif;
            font-weight: 700;
            font-size: 14px;
            line-height: 20px;
            color: var(--text-dark);
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .prayer-time {
            font-family: 'Epilogue', sans-serif;
            font-weight: 800;
            font-size: 28px;
            line-height: 32px;
            color: var(--green-deep);
            text-align: center;
        }

        .prayer-note {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            color: var(--text-mid);
            text-align: center;
            padding: 16px;
            background: rgba(0, 50, 39, 0.04);
            border-radius: 12px;
        }

        /* ===========================
           ISLAMIC REMINDER SECTION
        =========================== */
        .reminder-section {
            width: 100%;
            background: var(--green-deep);
            padding: 96px 0;
            position: relative;
            isolation: isolate;
            overflow: hidden;
        }

        .reminder-container {
            position: relative;
            z-index: 1;
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            flex-direction: column;
            gap: 64px;
        }

        .reminder-header {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: flex-end;
        }

        .reminder-title-group {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .reminder-label {
            font-family: 'Manrope', sans-serif;
            font-weight: 700;
            font-size: 16px;
            line-height: 24px;
            letter-spacing: 1.6px;
            text-transform: uppercase;
            color: #FFE088;
        }

        .reminder-title {
            font-family: 'Epilogue', sans-serif;
            font-weight: 900;
            font-size: 48px;
            line-height: 48px;
            color: var(--white);
        }

        .reminder-nav {
            display: flex;
            gap: 16px;
        }

        .reminder-nav-btn {
            width: 48px;
            height: 48px;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s ease;
            border: 1px solid rgba(176, 239, 218, 0.3);
            background: transparent;
            color: #B0EFDA;
        }

        .reminder-nav-btn:hover {
            background: rgba(176, 239, 218, 0.1);
        }

        .reminder-nav-btn:active {
            background: #FED65B;
            border-color: #FFE088;
            color: #745C00;
            transform: scale(0.95);
        }

        .reminder-cards {
            display: flex;
            flex-direction: row;
            gap: 32px;
            overflow-x: auto;
            scroll-behavior: smooth;
            scrollbar-width: none;
            -ms-overflow-style: none;
            padding-top: 16px;
            padding-bottom: 32px;
            padding-left: 8px;
            padding-right: 8px;
            margin-left: -8px;
            margin-right: -8px;
        }

        .reminder-cards::-webkit-scrollbar {
            display: none;
        }

        .reminder-card {
            flex: 0 0 calc(33.333% - 21.33px);
            position: relative;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            border-radius: 24px;
            padding: 32px;
            min-height: 280px;
            transition: all 0.3s ease;
            overflow: hidden;
            cursor: pointer;
        }

        .reminder-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-4px);
        }

        /* Active State (Yellow) */
        .reminder-card.active {
            background: #FED65B;
            border-color: #FFE088;
            transform: translateY(-8px);
            box-shadow: 0 25px 50px -12px rgba(254, 214, 91, 0.25);
        }

        .reminder-card.active .reminder-card-title,
        .reminder-card.active .reminder-card-text,
        .reminder-card.active .reminder-card-source {
            color: var(--green-deep);
        }

        .reminder-card.active .reminder-card-arabic {
            color: #004B3C;
        }

        .reminder-card.active .reminder-card-icon {
            color: var(--green-deep);
        }

        .reminder-card-icon {
            color: #FFE088;
            margin-bottom: 40px;
        }

        .reminder-card-title {
            font-family: 'Epilogue', sans-serif;
            font-weight: 700;
            font-size: 20px;
            line-height: 28px;
            color: var(--white);
            margin-bottom: 16px;
        }

        .reminder-card-arabic {
            font-family: 'Scheherazade New', 'FreeSerif', serif;
            font-size: 24px;
            line-height: 1.6;
            color: #E9C349;
            margin-bottom: 12px;
            direction: rtl;
        }

        .reminder-card-text {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 400;
            font-size: 16px;
            line-height: 26px;
            color: rgba(255, 255, 255, 0.85);
        }

        .reminder-card-source {
            font-family: 'Manrope', sans-serif;
            font-weight: 400;
            font-size: 14px;
            line-height: 20px;
            color: rgba(255, 255, 255, 0.5);
            margin-top: 16px;
        }

        /* ===========================
           TIMELINE SECTION
        =========================== */
        .timeline-section {
            width: 100%;
            background: var(--cream);
            padding: 96px 128px;
        }

        .timeline-container {
            max-width: 1024px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            flex-direction: column;
            gap: 80px;
        }

        .timeline-header {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 12px;
        }

        .timeline-title {
            font-family: 'Epilogue', sans-serif;
            font-weight: 900;
            font-size: 48px;
            line-height: 48px;
            color: var(--green-deep);
            text-align: center;
        }

        .timeline-subtitle {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            color: var(--text-mid);
            text-align: center;
        }

        .timeline-track {
            position: relative;
            display: flex;
            flex-direction: column;
            gap: 64px;
        }

        .timeline-line {
            position: absolute;
            width: 4px;
            left: calc(50% - 2px);
            top: 0;
            bottom: 0;
            background: #B0EFDA;
            z-index: 0;
        }

        .timeline-item {
            position: relative;
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 32px;
            z-index: 1;
        }

        .timeline-item.left .timeline-content-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            text-align: right;
        }

        .timeline-item.left .timeline-content-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }

        .timeline-item.right .timeline-content-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            text-align: right;
        }

        .timeline-item.right .timeline-content-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
        }

        .timeline-node {
            position: relative;
            width: 32px;
            height: 32px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .timeline-dot {
            width: 32px;
            height: 32px;
            background: #FED65B;
            border: 4px solid var(--cream);
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .timeline-dot svg {
            width: 10px;
            height: 10px;
            color: #745C00;
        }

        .timeline-time-badge {
            display: inline-block;
            padding: 5.5px 16px;
            background: #004B3C;
            border-radius: 9999px;
            white-space: nowrap;
        }

        .timeline-time-text {
            font-family: 'Manrope', sans-serif;
            font-weight: 700;
            font-size: 14px;
            line-height: 20px;
            color: #7CBAA6;
        }

        .timeline-act-title {
            font-family: 'Epilogue', sans-serif;
            font-weight: 700;
            font-size: 24px;
            line-height: 32px;
            color: var(--green-deep);
        }

        .timeline-act-desc {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            color: var(--text-mid);
        }

        /* ===========================
           PENGUMUMAN TERBARU SECTION
        =========================== */
        .pengumuman-section {
            width: 100%;
            background: var(--cream-alt);
            padding: 96px 0;
        }

        .pengumuman-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            flex-direction: column;
            gap: 48px;
        }
        
        .pengumuman-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .pengumuman-card {
            background: var(--white);
            border-radius: 24px;
            padding: 32px;
            box-shadow: 0px 4px 12px rgba(0, 50, 39, 0.05);
            display: flex;
            flex-direction: column;
            gap: 16px;
            transition: transform 0.3s ease;
        }

        .pengumuman-card:hover {
            transform: translateY(-4px);
            box-shadow: 0px 12px 24px rgba(0, 50, 39, 0.1);
        }

        .pengumuman-date {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            color: var(--green-deep);
            font-weight: 600;
        }

        .pengumuman-card-title {
            font-family: 'Epilogue', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--green-deep);
            line-height: 1.4;
        }

        .pengumuman-card-excerpt {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 15px;
            color: var(--text-mid);
            line-height: 1.6;
            flex-grow: 1;
        }
        
        .pengumuman-link {
            font-family: 'Manrope', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: var(--gold-dark);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ===========================
           GALERI TERBARU SECTION
        =========================== */
        .galeri-section {
            width: 100%;
            background: var(--white);
            padding: 96px 0;
        }

        .galeri-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            flex-direction: column;
            gap: 48px;
        }

        .galeri-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .galeri-item {
            position: relative;
            border-radius: 24px;
            overflow: hidden;
            aspect-ratio: 4/3;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        .galeri-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .galeri-item:hover .galeri-img {
            transform: scale(1.05);
        }

        .galeri-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 50, 39, 0.8) 0%, transparent 100%);
            display: flex;
            align-items: flex-end;
            padding: 24px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .galeri-item:hover .galeri-overlay {
            opacity: 1;
        }

        .galeri-title {
            color: var(--white);
            font-family: 'Epilogue', sans-serif;
            font-weight: 700;
            font-size: 18px;
        }

        /* ===========================
           STATS SECTION
        =========================== */
        .stats-section {
            width: 100%;
            background: var(--cream-alt);
            padding: 80px 0;
        }

        .stats-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .stat-card {
            background: var(--white);
            border-radius: 24px;
            padding: 40px 32px;
            text-align: center;
            box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.06);
            transition: transform 0.25s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
        }

        .stat-number {
            font-family: 'Epilogue', sans-serif;
            font-weight: 900;
            font-size: 48px;
            color: var(--green-deep);
            line-height: 1;
            margin-bottom: 8px;
        }

        .stat-number span {
            color: var(--gold-dark);
        }

        .stat-label {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 16px;
            color: var(--text-mid);
        }

       /* responsive home */
        @media (max-width: 1024px) {
            .hero-title {
                font-size: clamp(40px, 5vw, 60px);
            }
            .prayer-grid {
                grid-template-columns: repeat(3, 1fr);
            }
            .pengumuman-grid, .galeri-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .timeline-section, .prayer-section, .reminder-section, .pengumuman-section, .galeri-section, .stats-section {
                padding: 64px 0;
            }
            .timeline-container {
                padding: 0 24px;
            }
            .reminder-card {
                flex: 0 0 calc(50% - 16px);
            }
        }

        @media (max-width: 768px) {
            .hero-container {
                padding: 64px 24px;
            }
            .hero-title {
                font-size: 40px;
                letter-spacing: -1.5px;
            }
            .hero-bismillah {
                font-size: 36px;
            }
            .hero-subtitle {
                font-size: 16px;
                margin-bottom: 24px;
            }
            .hero-buttons {
                flex-direction: column;
                width: 100%;
            }
            .btn-primary, .btn-secondary {
                width: 100%;
                text-align: center;
            }
            .prayer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .quran-card {
                padding: 40px 24px;
                border-radius: 32px;
            }
            .quran-card-border {
                border-radius: 32px;
            }
            .quran-arabic {
                font-size: 36px;
            }
            .quran-surah {
                font-size: 20px;
            }
            .quran-translation {
                font-size: 14px;
                line-height: 24px;
            }
            .section-title, .reminder-title, .timeline-title {
                font-size: 32px;
                line-height: 40px;
            }
            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }
            .pengumuman-grid, .galeri-grid {
                grid-template-columns: 1fr;
            }
            .reminder-header {
                flex-direction: column;
                gap: 24px;
                align-items: flex-start;
            }
            .reminder-card {
                flex: 0 0 calc(85% - 16px);
            }
            
            /* TIMELINE MOBILE FIX */
            .timeline-line {
                left: 14px;
            }
            .timeline-item {
                flex-direction: row !important;
                gap: 16px;
            }
            .timeline-item.left .timeline-content-left,
            .timeline-item.right .timeline-content-left {
                display: none;
            }
            .timeline-item.left .timeline-content-right,
            .timeline-item.right .timeline-content-right {
                flex: 1;
                display: flex;
                flex-direction: column;
                align-items: flex-start;
                text-align: left;
            }
            .timeline-time-badge {
                margin-bottom: 8px;
            }
        }

        @media (max-width: 480px) {
            .prayer-grid {
                grid-template-columns: 1fr;
            }
            .stats-grid {
                grid-template-columns: 1fr;
            }
            .hero-title {
                font-size: 32px;
            }
            .hero-bismillah {
                font-size: 32px;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ======================== HERO ======================== --}}
    <section class="hero" id="beranda">
        <div class="hero-bg"></div>
        <div class="hero-gradient"></div>
        <div class="hero-pattern"></div>

        <div class="hero-content">
            {{-- Bismillah --}}
            <div class="hero-bismillah">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</div>

            {{-- Heading --}}
            <h1 class="hero-title">Belajar Al-Quran</h1>

            {{-- Subtitle --}}
            <p class="hero-subtitle">
                Tempat belajar membaca, memahami, dan mencintai Al-Quran dengan penuh kasih dan keikhlasan.
            </p>

            {{-- Buttons --}}
            <div class="hero-buttons">
                <a href="{{ route('program') }}" class="btn-primary">Lihat Program</a>
                <a href="#jadwal" class="btn-secondary">Lihat Jadwal</a>
            </div>
        </div>
        
        {{-- Wave --}}
        <div class="hero-wave">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path
                    d="M0,64L80,69.3C160,75,320,85,480,80C640,75,800,53,960,42.7C1120,32,1280,32,1360,32L1440,32L1440,120L1360,120C1280,120,1120,120,960,120C800,120,640,120,480,120C320,120,160,120,80,120L0,120Z"
                    fill="#FCF9F2" />
            </svg>
        </div>
    </section>

    {{-- ======================== QURAN INSPIRATION ======================== --}}
    <section class="quran-section" id="inspirasi">
        <div class="quran-card-wrapper reveal">
            <div class="quran-card-border">
                <div class="quran-card">
                    <div class="quran-arabic">اقْرَأْ بِاسْمِ رَبِّكَ الَّذِي خَلَقَ</div>
                    <div class="quran-surah">QS. Al-Alaq: 1</div>
                    <div class="quran-translation">"Bacalah dengan (menyebut) nama Tuhanmu yang menciptakan."</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================== PRAYER SCHEDULE ======================== --}}
    <section class="prayer-section" id="jadwal">
        <div class="prayer-container">
            <div class="section-header reveal">
                <h2 class="section-title">Jadwal Shalat</h2>
                <div class="section-underline"></div>
            </div>

            <div class="prayer-grid">
                {{-- Subuh --}}
                <div class="prayer-card reveal delay-100">
                    <div class="prayer-icon">
                        <span class="material-symbols-outlined" style="font-size: 40px;">wb_twilight</span>
                    </div>
                    <div class="prayer-name">Subuh</div>
                    <div class="prayer-time" id="time-subuh">04:21</div>
                </div>

                {{-- Dzuhur --}}
                <div class="prayer-card reveal delay-200">
                    <div class="prayer-icon">
                        <span class="material-symbols-outlined" style="font-size: 40px;">light_mode</span>
                    </div>
                    <div class="prayer-name">Dzuhur</div>
                    <div class="prayer-time" id="time-dzuhur">11:54</div>
                </div>

                {{-- Ashar --}}
                <div class="prayer-card reveal delay-200">
                    <div class="prayer-icon">
                        <span class="material-symbols-outlined" style="font-size: 40px;">sunny</span>
                    </div>
                    <div class="prayer-name">Ashar</div>
                    <div class="prayer-time" id="time-ashar">15:19</div>
                </div>

                {{-- Maghrib --}}
                <div class="prayer-card reveal delay-300">
                    <div class="prayer-icon">
                        <span class="material-symbols-outlined" style="font-size: 40px;">nights_stay</span>
                    </div>
                    <div class="prayer-name">Maghrib</div>
                    <div class="prayer-time" id="time-maghrib">17:52</div>
                </div>

                {{-- Isya --}}
                <div class="prayer-card reveal delay-400">
                    <div class="prayer-icon">
                        <span class="material-symbols-outlined" style="font-size: 40px;">bedtime</span>
                    </div>
                    <div class="prayer-name">Isya</div>
                    <div class="prayer-time" id="time-isya">19:05</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================== ISLAMIC REMINDER ======================== --}}
    <section class="reminder-section" id="pengumuman">
        <div class="reminder-container">
            <div class="reminder-header">
                <div class="reminder-title-group reveal">
                    <div class="reminder-label">Pengingat Islami</div>
                    <h2 class="reminder-title">Hikmah Harian</h2>
                </div>
                <div class="reminder-nav reveal">
                    <button class="reminder-nav-btn prev" aria-label="Previous" onclick="prevCard()">
                        <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 1L1 6L6 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button class="reminder-nav-btn next" aria-label="Next" onclick="nextCard()">
                        <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 1L7 6L2 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
            </div>

            <div class="reminder-cards" id="reminder-cards">
                {{-- Card 1 --}}
                <div class="reminder-card reveal delay-100" onclick="toggleActiveCard(this)">
                    <div class="reminder-card-icon">
                        <span class="material-symbols-outlined" style="font-size: 32px;">mosque</span>
                    </div>
                    <h3 class="reminder-card-title">Doa Masuk Masjid</h3>
                    <div class="reminder-card-arabic">اللَّهُمَّ افْتَحْ لِي أَبْوَابَ رَحْمَتِكَ</div>
                    <p class="reminder-card-text">
                        "Ya Allah, bukakanlah untukku pintu-pintu rahmat-Mu."
                    </p>
                </div>

                {{-- Card 2 --}}
                <div class="reminder-card reveal delay-200" onclick="toggleActiveCard(this)">
                    <div class="reminder-card-icon">
                        <span class="material-symbols-outlined" style="font-size: 32px;">menu_book</span>
                    </div>
                    <h3 class="reminder-card-title">Adab Menuntut Ilmu</h3>
                    <p class="reminder-card-text">
                        Barangsiapa menempuh suatu jalan untuk mencari ilmu, maka Allah akan memudahkan baginya jalan menuju
                        surga.
                    </p>
                    <div class="reminder-card-source">HR. Muslim no. 2699</div>
                </div>

                {{-- Card 3 --}}
                <div class="reminder-card reveal delay-300" onclick="toggleActiveCard(this)">
                    <div class="reminder-card-icon">
                        <span class="material-symbols-outlined" style="font-size: 32px;">volunteer_activism</span>
                    </div>
                    <h3 class="reminder-card-title">Berbakti pada Orang Tua</h3>
                    <p class="reminder-card-text">
                        Ridha Allah terdapat pada ridha orang tua, dan murka Allah terdapat pada murka orang tua.
                    </p>
                    <div class="reminder-card-source">HR. Tirmidzi no. 1899</div>
                </div>

                {{-- Card 4 --}}
                <div class="reminder-card reveal delay-400" onclick="toggleActiveCard(this)">
                    <div class="reminder-card-icon">
                        <span class="material-symbols-outlined" style="font-size: 32px;">hourglass_empty</span>
                    </div>
                    <h3 class="reminder-card-title">Keutamaan Sabar</h3>
                    <p class="reminder-card-text">
                        "Sesungguhnya hanya orang-orang yang bersabarlah yang dicukupkan pahala mereka tanpa batas."
                    </p>
                    <div class="reminder-card-source">QS. Az-Zumar: 10</div>
                </div>

                {{-- Card 5 --}}
                <div class="reminder-card reveal delay-500" onclick="toggleActiveCard(this)">
                    <div class="reminder-card-icon">
                        <span class="material-symbols-outlined" style="font-size: 32px;">chat</span>
                    </div>
                    <h3 class="reminder-card-title">Menjaga Lisan</h3>
                    <p class="reminder-card-text">
                        Barangsiapa yang beriman kepada Allah dan hari akhir, hendaklah ia berkata baik atau diam.
                    </p>
                    <div class="reminder-card-source">HR. Bukhari &amp; Muslim</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================== TIMELINE ======================== --}}
    <section class="timeline-section" id="kegiatan">
        <div class="timeline-container">
            <div class="timeline-header">
                <h2 class="timeline-title reveal">Jadwal Kegiatan TPA</h2>
                <p class="timeline-subtitle reveal">Rangkaian kegiatan harian santri TPA Al-Iman yang penuh berkah.</p>
            </div>

            <div class="timeline-track">
                <div class="timeline-line"></div>

                {{-- Item 1 --}}
                <div class="timeline-item left reveal">
                    <div class="timeline-content-left">
                        <div class="timeline-act-title">Pembukaan &amp; Doa</div>
                        <div class="timeline-act-desc">Santri berkumpul, membaca doa bersama dan tadarus Al-Quran.</div>
                    </div>
                    <div class="timeline-node">
                        <div class="timeline-dot">
                            <svg width="8" height="10" viewBox="0 0 8 10" fill="none">
                                <path d="M4 1L4 9M1 4L4 1L7 4" stroke="#745C00" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                    <div class="timeline-content-right">
                        <div class="timeline-time-badge">
                            <span class="timeline-time-text">15:30 – 16:00</span>
                        </div>
                    </div>
                </div>

                {{-- Item 2 --}}
                <div class="timeline-item right reveal">
                    <div class="timeline-content-left">
                        <div class="timeline-time-badge">
                            <span class="timeline-time-text">16:00 – 16:45</span>
                        </div>
                    </div>
                    <div class="timeline-node">
                        <div class="timeline-dot">
                            <svg width="12" height="6" viewBox="0 0 12 6" fill="none">
                                <rect x="0" y="2" width="12" height="2" rx="1" fill="#745C00" />
                            </svg>
                        </div>
                    </div>
                    <div class="timeline-content-right">
                        <div class="timeline-act-title">Materi Adab &amp; Fiqh</div>
                        <div class="timeline-act-desc">Pembelajaran akhlak dan dasar-dasar ibadah sehari-hari.</div>
                    </div>
                </div>

                {{-- Item 3 --}}
                <div class="timeline-item left reveal">
                    <div class="timeline-content-left">
                        <div class="timeline-act-title">Belajar Membaca Quran</div>
                        <div class="timeline-act-desc">Pengajaran iqra, tajwid dan hafalan surat pilihan.</div>
                    </div>
                    <div class="timeline-node">
                        <div class="timeline-dot">
                            <svg width="11" height="10" viewBox="0 0 11 10" fill="none">
                                <path d="M1 5L4 8L10 2" stroke="#745C00" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                    <div class="timeline-content-right">
                        <div class="timeline-time-badge">
                            <span class="timeline-time-text">16:45 – 17:30</span>
                        </div>
                    </div>
                </div>

                {{-- Item 4 --}}
                <div class="timeline-item right reveal">
                    <div class="timeline-content-left">
                        <div class="timeline-time-badge">
                            <span class="timeline-time-text">17:30 – Selesai</span>
                        </div>
                    </div>
                    <div class="timeline-node">
                        <div class="timeline-dot">
                            <svg width="8" height="9" viewBox="0 0 8 9" fill="none">
                                <circle cx="4" cy="4.5" r="3" fill="#745C00" />
                            </svg>
                        </div>
                    </div>
                    <div class="timeline-content-right">
                        <div class="timeline-act-title">Shalat Jamaah &amp; Pulang</div>
                        <div class="timeline-act-desc">Shalat Maghrib berjamaah dan penutupan kegiatan.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================== PENGUMUMAN TERBARU ======================== --}}
    <section class="pengumuman-section" id="berita">
        <div class="pengumuman-container">
            <div class="section-header reveal">
                <h2 class="section-title">Pengumuman Terbaru</h2>
                <div class="section-underline"></div>
            </div>

            <div class="pengumuman-grid">
                @foreach ($pengumuman_terbaru as $item)
                    <div class="pengumuman-card reveal">
                        <div class="pengumuman-date">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}</div>
                        <h3 class="pengumuman-card-title">{{ $item->judul }}</h3>
                        <p class="pengumuman-card-excerpt">{{ Str::limit(strip_tags($item->isi), 100) }}</p>
                        <a href="{{ route('pengumuman.show', $item->id_pengumuman) }}" class="pengumuman-link">
                            Baca Selengkapnya
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none">
                                <path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>
                @endforeach
            </div>
            
            <div style="text-align: center; margin-top: 16px;" class="reveal">
                <a href="{{ route('pengumuman.index') }}" class="btn-secondary" style="display: inline-flex; border-color: var(--green-deep); color: var(--green-deep);">Lihat Semua Pengumuman</a>
            </div>
        </div>
    </section>

    {{-- ======================== GALERI TERBARU ======================== --}}
    <section class="galeri-section" id="album">
        <div class="galeri-container">
            <div class="section-header reveal">
                <h2 class="section-title">Galeri Kegiatan</h2>
                <div class="section-underline"></div>
            </div>

            <div class="galeri-grid">
                @foreach ($galeri_terbaru as $foto)
                    <div class="galeri-item reveal">
                        <img src="{{ Storage::url($foto->foto) }}" alt="{{ $foto->judul }}" class="galeri-img">
                        <div class="galeri-overlay">
                            <div class="galeri-title">{{ $foto->judul }}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div style="text-align: center; margin-top: 16px;" class="reveal">
                <a href="/galeri" class="btn-secondary" style="display: inline-flex; border-color: var(--green-deep); color: var(--green-deep);">Lihat Semua Foto</a>
            </div>
        </div>
    </section>

    {{-- ======================== STATS ======================== --}}
    <section class="stats-section">
        <div class="stats-container">
            <div class="stats-grid">
                <div class="stat-card reveal delay-100">
                    <div class="stat-number">120<span>+</span></div>
                    <div class="stat-label">Santri Aktif</div>
                </div>
                <div class="stat-card reveal delay-200">
                    <div class="stat-number">12<span>+</span></div>
                    <div class="stat-label">Ustadz &amp; Ustadzah</div>
                </div>
                <div class="stat-card reveal delay-300">
                    <div class="stat-number">8<span>+</span></div>
                    <div class="stat-label">Tahun Berdiri</div>
                </div>
                <div class="stat-card reveal delay-400">
                    <div class="stat-number">45<span>+</span></div>
                    <div class="stat-label">Hafizh Quran</div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        // Prayer times
        async function updatePrayerTimes() {
            // Default times in case API fails
            const defaultTimes = {
                subuh: '04:21',
                dzuhur: '11:54',
                ashar: '15:19',
                maghrib: '17:52',
                isya: '19:05'
            };
            
            let times = defaultTimes;
            
            try {
                // Fetch today's prayer times for Padang, Sumatera Barat (0314)
                const date = new Date();
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                
                const response = await fetch(`https://api.myquran.com/v2/sholat/jadwal/0314/${year}/${month}/${day}`);
                const result = await response.json();
                
                if (result && result.status && result.data && result.data.jadwal) {
                    const jadwal = result.data.jadwal;
                    times = {
                        subuh: jadwal.subuh,
                        dzuhur: jadwal.dzuhur,
                        ashar: jadwal.ashar,
                        maghrib: jadwal.maghrib,
                        isya: jadwal.isya
                    };
                }
            } catch (error) {
                console.error('Failed to fetch prayer times, using default.', error);
            }

            // Update DOM with times
            Object.entries(times).forEach(([key, val]) => {
                const el = document.getElementById('time-' + key);
                if (el) el.textContent = val;
            });
            
            // Highlight current/next prayer
            highlightCurrentPrayer(times);
        }
        
        function highlightCurrentPrayer(times) {
            const now = new Date();
            const currentTime = now.getHours() * 60 + now.getMinutes();
            
            const prayerMinutes = Object.entries(times).map(([key, val]) => {
                const [h, m] = val.split(':').map(Number);
                return { key, minutes: h * 60 + m };
            });
            
            // Default to Isya if we are past Isya
            let currentPrayer = 'isya';
            
            // Find the closest past prayer
            for (let i = prayerMinutes.length - 1; i >= 0; i--) {
                if (currentTime >= prayerMinutes[i].minutes) {
                    currentPrayer = prayerMinutes[i].key;
                    break;
                }
            }
            
            // Remove active-prayer from all
            document.querySelectorAll('.prayer-card').forEach(card => {
                card.classList.remove('active-prayer');
            });
            
            // Add active-prayer to current
            const currentEl = document.getElementById('time-' + currentPrayer);
            if (currentEl) {
                currentEl.closest('.prayer-card').classList.add('active-prayer');
            }
        }
        
        updatePrayerTimes();


        const reminderContainer = document.getElementById('reminder-cards');

        function prevCard() {
            if (reminderContainer) {
                // Geser ke kiri sebesar lebar satu kartu + gap
                const cardWidth = reminderContainer.querySelector('.reminder-card').offsetWidth;
                reminderContainer.scrollBy({ left: -(cardWidth + 32), behavior: 'smooth' });
            }
        }

        function nextCard() {
            if (reminderContainer) {
                // Geser ke kanan sebesar lebar satu kartu + gap
                const cardWidth = reminderContainer.querySelector('.reminder-card').offsetWidth;
                reminderContainer.scrollBy({ left: cardWidth + 32, behavior: 'smooth' });
            }
        }

        function toggleActiveCard(element) {
            // Hapus kelas aktif dari semua kartu
            document.querySelectorAll('.reminder-card').forEach(c => {
                if (c !== element) {
                    c.classList.remove('active');
                }
            });

            // Toggle (aktif/nonaktif) pada kartu yang diklik
            element.classList.toggle('active');

            // Opsional: Gulirkan agar kartu berada di tengah jika diaktifkan
            if (element.classList.contains('active')) {
                element.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
            }
        }
    </script>
@endpush