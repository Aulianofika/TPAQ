<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TPA Al-Quran — Taman Pendidikan Al-Quran</title>
    <meta name="description" content="Taman Pendidikan Al-Quran — Tempat belajar membaca Al-Quran, adab, dan ilmu agama Islam dengan penuh kasih dan keikhlasan.">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@300;400;700;900&family=Manrope:wght@400;500;700&family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;1,300&display=swap" rel="stylesheet">

    <style>
        /* ===========================
           CSS RESET & BASE
        =========================== */
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --green-deep:    #003227;
            --green-mid:     #004B3C;
            --green-footer:  #064E3B;
            --green-dark:    #065F46;
            --green-teal:    #7CBAA6;
            --green-mint:    #B0EFDA;
            --cream:         #FCF9F2;
            --cream-alt:     #F6F3EC;
            --gold:          #FED65B;
            --gold-light:    #FFE088;
            --gold-dark:     #735C00;
            --gold-darker:   #745C00;
            --amber:         #FBBF24;
            --text-dark:     #1C1C18;
            --text-mid:      #404945;
            --white:         #FFFFFF;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--cream);
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* ===========================
           NAVBAR
        =========================== */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 40px;
            background: rgba(0, 50, 39, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(176, 239, 218, 0.1);
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-family: 'Epilogue', serif;
            font-weight: 900;
            font-size: 20px;
            color: var(--amber);
            text-decoration: none;
            letter-spacing: -0.5px;
        }

        .navbar-links {
            display: flex;
            align-items: center;
            gap: 32px;
            list-style: none;
        }

        .navbar-links a {
            font-family: 'Manrope', sans-serif;
            font-weight: 500;
            font-size: 15px;
            color: rgba(209, 250, 229, 0.8);
            text-decoration: none;
            transition: color 0.2s;
        }

        .navbar-links a:hover {
            color: var(--green-mint);
        }

        .navbar-cta {
            font-family: 'Manrope', sans-serif;
            font-weight: 700;
            font-size: 14px;
            padding: 10px 24px;
            background: var(--gold);
            color: var(--gold-darker);
            border-radius: 9999px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .navbar-cta:hover {
            background: var(--gold-light);
            transform: translateY(-1px);
        }

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

        /* Decorative Islamic geometric pattern overlay */
        .hero-pattern {
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23FED65B' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 1;
            opacity: 0.6;
        }

        /* Wave SVG at bottom */
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
            padding-top: 80px;
        }

        .hero-bismillah {
            font-family: 'Scheherazade New', 'FreeSerif', serif;
            font-weight: 400;
            font-size: 72px;
            line-height: 1;
            color: #FBBF24;
            margin-bottom: 24px;
            opacity: 0.9;
            animation: fadeInDown 0.8s ease forwards;
        }

        .hero-title {
            font-family: 'Epilogue', sans-serif;
            font-weight: 900;
            font-size: clamp(56px, 7.5vw, 96px);
            line-height: 1;
            letter-spacing: -4.8px;
            color: var(--white);
            margin-bottom: 24px;
            animation: fadeInUp 0.8s ease 0.1s both;
        }

        .hero-subtitle {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 300;
            font-size: 24px;
            line-height: 32px;
            color: var(--green-teal);
            margin-bottom: 48px;
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

        /* Scroll indicator */
        .scroll-indicator {
            position: absolute;
            bottom: 120px;
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
            min-height: 577px;
            background: var(--cream);
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 96px 24px;
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
            padding: 96px 0;
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
            padding: 32px;
            gap: 8px;
            background: var(--white);
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
            border-radius: 48px 48px 8px 8px;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .prayer-card:hover {
            transform: translateY(-4px);
            box-shadow: 0px 12px 24px rgba(0, 50, 39, 0.12);
        }

        .prayer-icon {
            width: 44px;
            height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold-dark);
        }

        .prayer-icon svg {
            width: 100%;
            height: 100%;
        }

        .prayer-name {
            font-family: 'Manrope', sans-serif;
            font-weight: 700;
            font-size: 16px;
            line-height: 24px;
            color: var(--text-dark);
            text-align: center;
        }

        .prayer-time {
            font-family: 'Epilogue', sans-serif;
            font-weight: 900;
            font-size: 30px;
            line-height: 36px;
            color: var(--green-deep);
            text-align: center;
        }

        /* Prayer note */
        .prayer-note {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            color: var(--text-mid);
            text-align: center;
            padding: 16px;
            background: rgba(0, 50, 39, 0.04);
            border-radius: 12px;
        }

        /* Large calendar widget */
        .prayer-calendar {
            display: flex;
            flex-direction: column;
            gap: 32px;
        }

        .calendar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .calendar-date {
            font-family: 'Epilogue', sans-serif;
            font-weight: 700;
            font-size: 20px;
            color: var(--green-deep);
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

        .reminder-section::before {
            content: '';
            position: absolute;
            left: 8.5%;
            right: 8.5%;
            top: 0;
            bottom: 21%;
            background: rgba(254, 214, 91, 0.05);
            z-index: 0;
        }

        /* Arabesque pattern overlay */
        .reminder-section::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23FED65B' fill-opacity='0.03'%3E%3Cpath d='M50 50c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10s-10-4.477-10-10 4.477-10 10-10zM10 10c0-5.523 4.477-10 10-10s10 4.477 10 10-4.477 10-10 10c0 5.523-4.477 10-10 10S0 25.523 0 20s4.477-10 10-10zm10 8c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8zm40 40c4.418 0 8-3.582 8-8s-3.582-8-8-8-8 3.582-8 8 3.582 8 8 8z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
            z-index: 0;
            opacity: 0.5;
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
            transition: all 0.2s;
            border: none;
        }

        .reminder-nav-btn.prev {
            border: 1px solid rgba(176, 239, 218, 0.3);
            background: transparent;
            color: #B0EFDA;
        }

        .reminder-nav-btn.prev:hover {
            background: rgba(176, 239, 218, 0.1);
        }

        .reminder-nav-btn.next {
            background: #FED65B;
            color: #745C00;
        }

        .reminder-nav-btn.next:hover {
            background: #FFE088;
            transform: scale(1.05);
        }

        .reminder-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 32px;
        }

        .reminder-card {
            position: relative;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
            border-radius: 48px 48px 8px 8px;
            padding: 48px 41px;
            min-height: 338px;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .reminder-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-4px);
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

        /* Left-aligned items (odd: 1, 3) — content on left, bubble left, info on right */
        .timeline-item.left .timeline-content-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .timeline-item.left .timeline-content-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        /* Right-aligned items (even: 2, 4) — info on left, bubble right, content on right */
        .timeline-item.right .timeline-content-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .timeline-item.right .timeline-content-right {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
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
            position: absolute;
            padding: 5.5px 16px;
            background: #004B3C;
            border-radius: 9999px;
            white-space: nowrap;
        }

        .timeline-item.left .timeline-time-badge {
            left: calc(100% + 16px);
            top: 50%;
            transform: translateY(-50%);
        }

        .timeline-item.right .timeline-time-badge {
            right: calc(100% + 16px);
            top: 50%;
            transform: translateY(-50%);
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

        /* ===========================
           FOOTER
        =========================== */
        .footer {
            width: 100%;
            background: #064E3B;
            position: relative;
            isolation: isolate;
            overflow: hidden;
        }

        .footer-inner {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 96px 32px 48px;
            gap: 0;
        }

        .footer-brand {
            font-family: 'Epilogue', sans-serif;
            font-weight: 900;
            font-size: 20px;
            line-height: 28px;
            color: #FBBF24;
            margin-bottom: 32px;
            text-align: center;
        }

        .footer-nav {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: flex-start;
            gap: 32px;
            margin-bottom: 48px;
            flex-wrap: wrap;
        }

        .footer-nav a {
            font-family: 'Manrope', sans-serif;
            font-weight: 500;
            font-size: 16px;
            line-height: 24px;
            color: rgba(209, 250, 229, 0.7);
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-nav a:hover {
            color: var(--green-mint);
        }

        .footer-copy {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 400;
            font-size: 16px;
            line-height: 24px;
            color: #ECFDF5;
            opacity: 0.8;
            text-align: center;
            margin-bottom: 16px;
        }

        .footer-social {
            display: flex;
            flex-direction: row;
            gap: 16px;
            padding-top: 16px;
        }

        .footer-social-link {
            width: 40px;
            height: 40px;
            background: #065F46;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.2s;
            color: #FBBF24;
        }

        .footer-social-link:hover {
            background: var(--green-dark);
            transform: translateY(-2px);
            color: #FFE088;
        }

        /* ===========================
           ANIMATIONS
        =========================== */
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to   { opacity: 1; }
        }

        @keyframes scrollBounce {
            0%, 100% { transform: translateY(0); opacity: 1; }
            50%       { transform: translateY(6px); opacity: 0.5; }
        }

        /* Intersection observer classes */
        .reveal {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }

        .reveal-left {
            opacity: 0;
            transform: translateX(-30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .reveal-left.visible {
            opacity: 1;
            transform: translateX(0);
        }

        .reveal-right {
            opacity: 0;
            transform: translateX(30px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .reveal-right.visible {
            opacity: 1;
            transform: translateX(0);
        }

        /* Delay utilities */
        .delay-100 { transition-delay: 0.1s; }
        .delay-200 { transition-delay: 0.2s; }
        .delay-300 { transition-delay: 0.3s; }
        .delay-400 { transition-delay: 0.4s; }

        /* ===========================
           RESPONSIVE
        =========================== */
        @media (max-width: 1024px) {
            .prayer-grid { grid-template-columns: repeat(3, 1fr); }
            .reminder-cards { grid-template-columns: 1fr; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .timeline-section { padding: 96px 24px; }
        }

        @media (max-width: 768px) {
            .navbar { padding: 16px 24px; }
            .navbar-links { display: none; }
            .hero-title { font-size: 48px; letter-spacing: -2px; }
            .hero-bismillah { font-size: 48px; }
            .hero-subtitle { font-size: 18px; }
            .hero-buttons { flex-direction: column; }
            .prayer-grid { grid-template-columns: repeat(2, 1fr); }
            .quran-card { padding: 40px 24px; border-radius: 32px; }
            .quran-card-border { border-radius: 32px; }
            .quran-arabic { font-size: 40px; }
            .section-title { font-size: 36px; }
            .reminder-title { font-size: 36px; }
            .timeline-title { font-size: 36px; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
            .reminder-header { flex-direction: column; gap: 24px; align-items: flex-start; }

            /* Simplify timeline on mobile */
            .timeline-item { flex-direction: column; align-items: flex-start; }
            .timeline-line { left: 15px; }
            .timeline-node { margin-left: 0; }
            .timeline-item.left .timeline-content-left,
            .timeline-item.right .timeline-content-left { display: none; }
            .timeline-item.left .timeline-content-right,
            .timeline-item.right .timeline-content-right { flex: 1; align-items: flex-start; margin-left: 48px; }
            .timeline-time-badge { position: static; transform: none; margin-bottom: 8px; }
            .timeline-item.left .timeline-time-badge,
            .timeline-item.right .timeline-time-badge { right: auto; left: auto; }
        }

        @media (max-width: 480px) {
            .prayer-grid { grid-template-columns: 1fr 1fr; }
            .stats-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- ======================== NAVBAR ======================== -->
    <nav class="navbar" id="navbar">
        <a href="#" class="navbar-brand">TPA Al-Iman</a>
        <ul class="navbar-links">
            <li><a href="#beranda">Beranda</a></li>
            <li><a href="#jadwal">Jadwal</a></li>
            <li><a href="#pengumuman">Pengumuman</a></li>
            <li><a href="#galeri">Galeri</a></li>
            <li><a href="#kontak">Kontak</a></li>
        </ul>
        <a href="#daftar" class="navbar-cta">Daftar Sekarang</a>
    </nav>

    <!-- ======================== HERO ======================== -->
    <section class="hero" id="beranda">
        <div class="hero-bg"></div>
        <div class="hero-gradient"></div>
        <div class="hero-pattern"></div>

        <div class="hero-content">
            <!-- Bismillah -->
            <div class="hero-bismillah">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</div>

            <!-- Heading -->
            <h1 class="hero-title">Belajar Al-Quran</h1>

            <!-- Subtitle -->
            <p class="hero-subtitle">
                Tempat belajar membaca, memahami, dan mencintai Al-Quran dengan penuh kasih dan keikhlasan.
            </p>

            <!-- Buttons -->
            <div class="hero-buttons">
                <a href="#daftar" class="btn-primary">Daftar Sekarang</a>
                <a href="#jadwal" class="btn-secondary">Lihat Jadwal</a>
            </div>
        </div>

        <!-- Scroll indicator -->
        <div class="scroll-indicator">
            <span>Scroll</span>
            <div class="scroll-dot"></div>
        </div>

        <!-- Wave -->
        <div class="hero-wave">
            <svg viewBox="0 0 1280 284" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                <path d="M0 284 L0 142 Q320 0 640 142 Q960 284 1280 142 L1280 284 Z" fill="#FCF9F2"/>
            </svg>
        </div>
    </section>

    <!-- ======================== QURAN INSPIRATION ======================== -->
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

    <!-- ======================== PRAYER SCHEDULE ======================== -->
    <section class="prayer-section" id="jadwal">
        <div class="prayer-container">
            <div class="section-header reveal">
                <h2 class="section-title">Jadwal Shalat</h2>
                <div class="section-underline"></div>
            </div>

            <div class="prayer-grid">
                <!-- Subuh -->
                <div class="prayer-card reveal delay-100">
                    <div class="prayer-icon">
                        <!-- Moon/Fajr icon -->
                        <svg viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16.5 4C10.977 4 6.5 8.477 6.5 14C6.5 19.523 10.977 24 16.5 24C18.656 24 20.652 23.313 22.281 22.148C20.445 22.695 18.371 22.168 17.086 20.672C15.215 18.485 15.485 15.211 17.672 13.336C19.316 11.899 21.629 11.575 23.598 12.389C22.672 7.672 19.992 4 16.5 4Z" fill="#735C00"/>
                            <path d="M16.5 6C11.53 6 7.5 10.03 7.5 15C7.5 19.97 11.53 24 16.5 24" stroke="#735C00" stroke-width="1.5"/>
                            <circle cx="26" cy="8" r="3" fill="#FED65B"/>
                        </svg>
                    </div>
                    <div class="prayer-name">Subuh</div>
                    <div class="prayer-time" id="time-subuh">04:21</div>
                </div>

                <!-- Dzuhur -->
                <div class="prayer-card reveal delay-200">
                    <div class="prayer-icon">
                        <!-- Sun icon -->
                        <svg viewBox="0 0 33 33" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="16.5" cy="16.5" r="7" fill="#735C00"/>
                            <line x1="16.5" y1="2" x2="16.5" y2="6" stroke="#735C00" stroke-width="2" stroke-linecap="round"/>
                            <line x1="16.5" y1="27" x2="16.5" y2="31" stroke="#735C00" stroke-width="2" stroke-linecap="round"/>
                            <line x1="2" y1="16.5" x2="6" y2="16.5" stroke="#735C00" stroke-width="2" stroke-linecap="round"/>
                            <line x1="27" y1="16.5" x2="31" y2="16.5" stroke="#735C00" stroke-width="2" stroke-linecap="round"/>
                            <line x1="6.4" y1="6.4" x2="9.2" y2="9.2" stroke="#735C00" stroke-width="2" stroke-linecap="round"/>
                            <line x1="23.8" y1="23.8" x2="26.6" y2="26.6" stroke="#735C00" stroke-width="2" stroke-linecap="round"/>
                            <line x1="26.6" y1="6.4" x2="23.8" y2="9.2" stroke="#735C00" stroke-width="2" stroke-linecap="round"/>
                            <line x1="9.2" y1="23.8" x2="6.4" y2="26.6" stroke="#735C00" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="prayer-name">Dzuhur</div>
                    <div class="prayer-time" id="time-dzuhur">11:54</div>
                </div>

                <!-- Ashar -->
                <div class="prayer-card reveal delay-200">
                    <div class="prayer-icon">
                        <!-- Afternoon sun icon -->
                        <svg viewBox="0 0 33 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="16.5" cy="14" r="7" fill="#735C00"/>
                            <path d="M16.5 2V6M16.5 22V26M2 14H6M27 14H31" stroke="#735C00" stroke-width="2" stroke-linecap="round"/>
                            <path d="M7 5L9.8 7.8M23.2 20.2L26 23M26 5L23.2 7.8M9.8 20.2L7 23" stroke="#735C00" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="prayer-name">Ashar</div>
                    <div class="prayer-time" id="time-ashar">15:19</div>
                </div>

                <!-- Maghrib -->
                <div class="prayer-card reveal delay-300">
                    <div class="prayer-icon">
                        <!-- Sunset icon -->
                        <svg viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 20C5 13.925 9.925 9 16 9C22.075 9 27 13.925 27 20" stroke="#735C00" stroke-width="2" stroke-linecap="round"/>
                            <line x1="16" y1="2" x2="16" y2="5" stroke="#735C00" stroke-width="2" stroke-linecap="round"/>
                            <line x1="2" y1="20" x2="30" y2="20" stroke="#735C00" stroke-width="2" stroke-linecap="round"/>
                            <line x1="5" y1="9" x2="7.5" y2="11.5" stroke="#735C00" stroke-width="2" stroke-linecap="round"/>
                            <line x1="27" y1="9" x2="24.5" y2="11.5" stroke="#735C00" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <div class="prayer-name">Maghrib</div>
                    <div class="prayer-time" id="time-maghrib">17:52</div>
                </div>

                <!-- Isya -->
                <div class="prayer-card reveal delay-400">
                    <div class="prayer-icon">
                        <!-- Night/star icon -->
                        <svg viewBox="0 0 32 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M16 3C10.477 3 6 7.477 6 13C6 18.523 10.477 23 16 23C18.156 23 20.152 22.313 21.781 21.148C19.945 21.695 17.871 21.168 16.586 19.672C14.715 17.485 14.985 14.211 17.172 12.336C18.816 10.899 21.129 10.575 23.098 11.389C22.172 6.672 19.492 3 16 3Z" fill="#735C00"/>
                            <circle cx="27" cy="6" r="2" fill="#FED65B"/>
                            <circle cx="23" cy="2" r="1.5" fill="#FED65B"/>
                        </svg>
                    </div>
                    <div class="prayer-name">Isya</div>
                    <div class="prayer-time" id="time-isya">19:05</div>
                </div>
            </div>

            <!-- Info note -->
            <p class="prayer-note reveal">
                ⏰ Waktu shalat berdasarkan lokasi setempat — diperbarui setiap hari. Hadir tepat waktu adalah bentuk ketaatan.
            </p>
        </div>
    </section>

    <!-- ======================== ISLAMIC REMINDER ======================== -->
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
                            <path d="M6 1L1 6L6 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <button class="reminder-nav-btn next" aria-label="Next" onclick="nextCard()">
                        <svg width="8" height="12" viewBox="0 0 8 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 1L7 6L2 11" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="reminder-cards" id="reminder-cards">
                <!-- Card 1 -->
                <div class="reminder-card reveal delay-100">
                    <div class="reminder-card-icon">
                        <!-- Mosque icon -->
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 28V18C4 14.686 6.686 12 10 12H22C25.314 12 28 14.686 28 18V28" stroke="#FFE088" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M2 28H30" stroke="#FFE088" stroke-width="1.5" stroke-linecap="round"/>
                            <path d="M13 28V22C13 20.895 13.895 20 15 20H17C18.105 20 19 20.895 19 22V28" stroke="#FFE088" stroke-width="1.5"/>
                            <path d="M16 4C14.343 4 13 5.343 13 7C13 8.657 14.343 10 16 10C17.657 10 19 8.657 19 7C19 5.343 17.657 4 16 4Z" fill="#FFE088"/>
                            <path d="M16 10V12" stroke="#FFE088" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h3 class="reminder-card-title">Doa Masuk Masjid</h3>
                    <div class="reminder-card-arabic">اللَّهُمَّ افْتَحْ لِي أَبْوَابَ رَحْمَتِكَ</div>
                    <p class="reminder-card-text">
                        "Ya Allah, bukakanlah untukku pintu-pintu rahmat-Mu."
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="reminder-card reveal delay-200">
                    <div class="reminder-card-icon">
                        <!-- Book/Quran icon -->
                        <svg width="33" height="24" viewBox="0 0 33 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 3C2 3 7 1 16.5 1C26 1 31 3 31 3V23C31 23 26 21 16.5 21C7 21 2 23 2 23V3Z" stroke="#FFE088" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M16.5 1V21" stroke="#FFE088" stroke-width="1.5"/>
                            <path d="M7 7C9.5 6.5 12 6.333 14.5 6.5" stroke="#FFE088" stroke-width="1.2" stroke-linecap="round"/>
                            <path d="M7 11C9.5 10.5 12 10.333 14.5 10.5" stroke="#FFE088" stroke-width="1.2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <h3 class="reminder-card-title">Adab Menuntut Ilmu</h3>
                    <p class="reminder-card-text">
                        Barangsiapa menempuh suatu jalan untuk mencari ilmu, maka Allah akan memudahkan baginya jalan menuju surga.
                    </p>
                    <div class="reminder-card-source">HR. Muslim no. 2699</div>
                </div>

                <!-- Card 3 -->
                <div class="reminder-card reveal delay-300">
                    <div class="reminder-card-icon">
                        <!-- Heart/family icon -->
                        <svg width="29" height="32" viewBox="0 0 29 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.5 28C14.5 28 3 21 3 12C3 7.582 6.582 4 11 4C12.874 4 14.592 4.674 15.94 5.793C13.97 7.246 12.667 9.473 12.667 12C12.667 16.023 15.977 19.333 20 19.333C21.358 19.333 22.626 18.952 23.704 18.293C22.352 24.023 14.5 28 14.5 28Z" fill="#FFE088"/>
                            <path d="M20 4C17.239 4 15 6.239 15 9C15 11.761 17.239 14 20 14C22.761 14 25 11.761 25 9C25 6.239 22.761 4 20 4Z" fill="#FFE088" opacity="0.7"/>
                        </svg>
                    </div>
                    <h3 class="reminder-card-title">Berbakti pada Orang Tua</h3>
                    <p class="reminder-card-text">
                        Ridha Allah terdapat pada ridha orang tua, dan murka Allah terdapat pada murka orang tua.
                    </p>
                    <div class="reminder-card-source">HR. Tirmidzi no. 1899</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ======================== TIMELINE ======================== -->
    <section class="timeline-section" id="kegiatan">
        <div class="timeline-container">
            <div class="timeline-header">
                <h2 class="timeline-title reveal">Jadwal Kegiatan TPA</h2>
                <p class="timeline-subtitle reveal">Rangkaian kegiatan harian santri TPA Al-Iman yang penuh berkah.</p>
            </div>

            <div class="timeline-track">
                <div class="timeline-line"></div>

                <!-- Item 1 — left side: time, right side: content -->
                <div class="timeline-item left reveal">
                    <div class="timeline-content-left">
                        <div style="position:relative; width:100%;">
                            <div class="timeline-time-badge">
                                <span class="timeline-time-text">15:30 – 16:00</span>
                            </div>
                        </div>
                        <div style="text-align:right; margin-top: 40px;">
                            <div class="timeline-act-title">Pembukaan & Doa</div>
                            <div class="timeline-act-desc">Santri berkumpul, membaca doa bersama dan tadarus Al-Quran.</div>
                        </div>
                    </div>
                    <div class="timeline-node">
                        <div class="timeline-dot">
                            <svg width="8" height="10" viewBox="0 0 8 10" fill="none"><path d="M4 1L4 9M1 4L4 1L7 4" stroke="#745C00" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                    <div class="timeline-content-right" style="visibility:hidden; pointer-events:none;">
                        <div class="timeline-act-title">·</div>
                    </div>
                </div>

                <!-- Item 2 — right side: time, left side: content -->
                <div class="timeline-item right reveal">
                    <div class="timeline-content-left" style="visibility:hidden; pointer-events:none;">
                        <div class="timeline-act-title">·</div>
                    </div>
                    <div class="timeline-node">
                        <div class="timeline-dot">
                            <svg width="12" height="6" viewBox="0 0 12 6" fill="none"><rect x="0" y="2" width="12" height="2" rx="1" fill="#745C00"/></svg>
                        </div>
                    </div>
                    <div class="timeline-content-right">
                        <div style="position:relative; width:100%;">
                            <div class="timeline-time-badge" style="left:0; right:auto; top:auto; transform:none; margin-bottom:12px;">
                                <span class="timeline-time-text">16:00 – 16:45</span>
                            </div>
                        </div>
                        <div style="margin-top:12px;">
                            <div class="timeline-act-title">Materi Adab & Fiqh</div>
                            <div class="timeline-act-desc">Pembelajaran akhlak dan dasar-dasar ibadah sehari-hari.</div>
                        </div>
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="timeline-item left reveal">
                    <div class="timeline-content-left">
                        <div style="position:relative; width:100%;">
                            <div class="timeline-time-badge">
                                <span class="timeline-time-text">16:45 – 17:30</span>
                            </div>
                        </div>
                        <div style="text-align:right; margin-top: 40px;">
                            <div class="timeline-act-title">Belajar Membaca Quran</div>
                            <div class="timeline-act-desc">Pengajaran iqra, tajwid dan hafalan surat pilihan.</div>
                        </div>
                    </div>
                    <div class="timeline-node">
                        <div class="timeline-dot">
                            <svg width="11" height="10" viewBox="0 0 11 10" fill="none"><path d="M1 5L4 8L10 2" stroke="#745C00" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                    <div class="timeline-content-right" style="visibility:hidden; pointer-events:none;">
                        <div class="timeline-act-title">·</div>
                    </div>
                </div>

                <!-- Item 4 -->
                <div class="timeline-item right reveal">
                    <div class="timeline-content-left" style="visibility:hidden; pointer-events:none;">
                        <div class="timeline-act-title">·</div>
                    </div>
                    <div class="timeline-node">
                        <div class="timeline-dot">
                            <svg width="8" height="9" viewBox="0 0 8 9" fill="none"><circle cx="4" cy="4.5" r="3" fill="#745C00"/></svg>
                        </div>
                    </div>
                    <div class="timeline-content-right">
                        <div style="position:relative; width:100%;">
                            <div class="timeline-time-badge" style="left:0; right:auto; top:auto; transform:none; margin-bottom:12px;">
                                <span class="timeline-time-text">17:30 – Selesai</span>
                            </div>
                        </div>
                        <div style="margin-top:12px;">
                            <div class="timeline-act-title">Shalat Jamaah & Pulang</div>
                            <div class="timeline-act-desc">Shalat Maghrib berjamaah dan penutupan kegiatan.</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ======================== STATS ======================== -->
    <section class="stats-section">
        <div class="stats-container">
            <div class="stats-grid">
                <div class="stat-card reveal delay-100">
                    <div class="stat-number">120<span>+</span></div>
                    <div class="stat-label">Santri Aktif</div>
                </div>
                <div class="stat-card reveal delay-200">
                    <div class="stat-number">12<span>+</span></div>
                    <div class="stat-label">Ustadz & Ustadzah</div>
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

    <!-- ======================== FOOTER ======================== -->
    <footer class="footer" id="kontak">
        <div class="footer-inner">
            <div class="footer-brand">TPA Al-Iman</div>

            <nav class="footer-nav">
                <a href="#beranda">Beranda</a>
                <a href="#jadwal">Jadwal</a>
                <a href="#kegiatan">Kegiatan</a>
                <a href="#pengumuman">Pengumuman</a>
                <a href="#galeri">Galeri</a>
                <a href="#kontak">Kontak</a>
            </nav>

            <p class="footer-copy">Jl. Masjid Al-Iman No. 12, Bandung · Telp: (022) 1234-5678</p>

            <div class="footer-social">
                <!-- WhatsApp -->
                <a href="#" class="footer-social-link" aria-label="WhatsApp">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </a>
                <!-- Instagram -->
                <a href="#" class="footer-social-link" aria-label="Instagram">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/>
                    </svg>
                </a>
                <!-- YouTube -->
                <a href="#" class="footer-social-link" aria-label="YouTube">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M23.495 6.205a3.007 3.007 0 00-2.088-2.088c-1.87-.501-9.396-.501-9.396-.501s-7.507-.01-9.396.501A3.007 3.007 0 00.527 6.205a31.247 31.247 0 00-.522 5.805 31.247 31.247 0 00.522 5.783 3.007 3.007 0 002.088 2.088c1.868.502 9.396.502 9.396.502s7.506 0 9.396-.502a3.007 3.007 0 002.088-2.088 31.247 31.247 0 00.5-5.783 31.247 31.247 0 00-.5-5.805zM9.609 15.601V8.408l6.264 3.602z"/>
                    </svg>
                </a>
            </div>
        </div>
    </footer>

    <script>
        // ========================
        // Scroll reveal
        // ========================
        const revealObserver = new IntersectionObserver((entries) => {
            entries.forEach(el => {
                if (el.isIntersecting) {
                    el.target.classList.add('visible');
                }
            });
        }, { threshold: 0.15 });

        document.querySelectorAll('.reveal, .reveal-left, .reveal-right').forEach(el => {
            revealObserver.observe(el);
        });

        // ========================
        // Navbar shrink on scroll
        // ========================
        const navbar = document.getElementById('navbar');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 80) {
                navbar.style.padding = '12px 40px';
                navbar.style.background = 'rgba(0, 50, 39, 0.97)';
            } else {
                navbar.style.padding = '20px 40px';
                navbar.style.background = 'rgba(0, 50, 39, 0.85)';
            }
        });

        // ========================
        // Prayer times (live)
        // ========================
        function updatePrayerTimes() {
            // Static demo times — in production, call an API (e.g., aladhan.com)
            const times = {
                subuh:   '04:21',
                dzuhur:  '11:54',
                ashar:   '15:19',
                maghrib: '17:52',
                isya:    '19:05'
            };
            Object.entries(times).forEach(([key, val]) => {
                const el = document.getElementById('time-' + key);
                if (el) el.textContent = val;
            });
        }
        updatePrayerTimes();

        // ========================
        // Reminder card carousel (simple)
        // ========================
        let currentSlide = 0;
        const cards = document.querySelectorAll('.reminder-card');

        function prevCard() {
            // On desktop all 3 show; on mobile could paginate
            // Simple highlight effect
            currentSlide = (currentSlide - 1 + cards.length) % cards.length;
            highlightCard(currentSlide);
        }

        function nextCard() {
            currentSlide = (currentSlide + 1) % cards.length;
            highlightCard(currentSlide);
        }

        function highlightCard(idx) {
            cards.forEach((c, i) => {
                c.style.opacity = i === idx ? '1' : '0.6';
                c.style.transform = i === idx ? 'translateY(-8px) scale(1.02)' : '';
            });
        }

        // ========================
        // Smooth scroll for anchor links
        // ========================
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offset = 80;
                    const top = target.getBoundingClientRect().top + window.scrollY - offset;
                    window.scrollTo({ top, behavior: 'smooth' });
                }
            });
        });
    </script>
</body>
</html>
