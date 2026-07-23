@extends('layouts.layout')

@section('title', 'Program TPA Taman Pendidikan Al-Quran')
@section('meta_description', 'Program pendidikan unggulan TPA Al-Iman. Cahaya ilmu di setiap langkah.')

@push('styles')
<style>
    /* ===========================
       HERO SECTION (Responsive & Beautiful)
    =========================== */
    .program-hero {
        position: relative;
        width: 100%;
        min-height: 767px;
        background: #004B3C;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        padding: 120px 24px 180px;
    }



    .hero-container {
        position: relative;
        width: 100%;
        max-width: 1280px;
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        gap: 64px;
        z-index: 1;
    }

    .hero-content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        max-width: 584px;
        gap: 24px;
        z-index: 2;
    }

    .hero-badge {
        display: flex;
        flex-direction: row;
        align-items: center;
        padding: 4px 20px;
        background: #FED65B;
        border-radius: 9999px;
        box-shadow: 0 4px 12px rgba(254, 214, 91, 0.2);
    }

    .hero-badge span {
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 14px;
        letter-spacing: 0.7px;
        color: #745C00;
        text-transform: uppercase;
    }

    .hero-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 900;
        font-size: clamp(40px, 5vw, 72px);
        line-height: 1.05;
        letter-spacing: -1.8px;
        color: #ECFDF5;
        margin: 0;
    }

    .hero-desc {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 500;
        font-size: clamp(16px, 2vw, 20px);
        line-height: 1.5;
        color: #7CBAA6;
        margin: 0;
    }

    .hero-visual {
        position: relative;
        width: 100%;
        max-width: 480px; /* Diperkecil dari 613px */
        aspect-ratio: 1 / 1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .hero-image-card {
        width: 95%;
        height: 95%;
        background: #03342A;
        border: 8px solid #004B3C;
        box-shadow: 0px 25px 50px -12px rgba(0, 0, 0, 0.4);
        border-radius: 32px;
        position: relative;
        overflow: hidden;
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hero-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .hero-visual:hover .hero-image-card {
        transform: translateY(-8px);
    }

    .hero-floating-badge-outer {
        position: absolute;
        width: 140px; 
        height: 140px;
        left: 0px;
        bottom: 0px;
        background: #735C00;
        border: 4px solid #004B3C;
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        box-shadow: 0px 20px 30px -5px rgba(0, 0, 0, 0.3);
        animation: floatBadge 4s ease-in-out infinite;
        z-index: 3;
    }

    .floating-badge-number {
        font-family: 'Epilogue', sans-serif;
        font-weight: 900;
        font-size: 28px;
        line-height: 1.1;
        color: #FFFFFF;
    }

    .floating-badge-text {
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 10px;
        line-height: 1.3;
        letter-spacing: 1px;
        color: rgba(255, 255, 255, 0.9);
        text-transform: uppercase;
        text-align: center;
    }

    @keyframes floatBadge {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-15px); }
    }

    .hero-wave {
        position: absolute;
        bottom: -1px; /* overlap slightly to avoid lines */
        left: 0;
        width: 100%;
        line-height: 0;
        z-index: 2;
    }

    .hero-wave svg {
        width: 100%;
        height: 120px;
        display: block;
    }

    /* ===========================
       PROGRAMS (Circle Grid)
    =========================== */
    .programs-section {
        width: 100%;
        background: var(--cream);
        padding: 96px 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
    }

    .programs-container {
        width: 100%;
        max-width: 1216px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 80px;
    }

    .programs-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
        text-align: center;
        max-width: 700px;
    }

    .programs-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 900;
        font-size: 48px;
        line-height: 1.1;
        letter-spacing: -1.2px;
        color: var(--green-deep);
    }

    .programs-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 64px 40px;
        width: 100%;
    }

    /* Place the last two items on the left and right (leaving center empty) */
    .program-card:nth-child(4) {
        grid-column: 1;
        justify-self: center;
        margin-right: 0;
    }
    .program-card:nth-child(5) {
        grid-column: 3;
        justify-self: center;
        margin-left: 0;
    }

    .program-card {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
        max-width: 360px;
        margin: 0 auto;
    }

    .program-icon-wrapper {
        position: relative;
        width: 192px;
        height: 192px;
        background: #F1EEE7;
        box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.05);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 32px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }

    .program-card:hover .program-icon-wrapper {
        transform: translateY(-12px) scale(1.05);
        box-shadow: 0px 20px 30px -10px rgba(0, 50, 39, 0.25);
    }

    .program-icon-inner {
        position: absolute;
        width: 176px;
        height: 176px;
        border-radius: 50%;
        background: linear-gradient(135deg, #065F46 0%, #003227 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gold-light);
        transition: all 0.4s ease;
    }

    .program-card:hover .program-icon-inner {
        background: linear-gradient(135deg, #077B59 0%, #004B3C 100%);
    }

    .program-icon-inner svg {
        width: 52px;
        height: 52px;
        transition: transform 0.4s ease;
    }

    .program-card:hover .program-icon-inner svg {
        transform: scale(1.1);
    }

    .program-card-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: 26px;
        line-height: 1.3;
        letter-spacing: -0.6px;
        color: var(--green-deep);
        text-align: center;
        margin-bottom: 16px;
    }

    .program-card-desc {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 500;
        font-size: 16px;
        line-height: 1.6;
        color: var(--text-mid);
        text-align: center;
        padding: 0 16px;
    }

    /* ===========================
       MAP SECTION
    =========================== */
    .map-section {
        max-width: 1280px;
        margin: 0 auto 96px;
        padding: 0 32px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 40px;
    }

    .map-header {
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
    }

    .map-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 700;
        font-size: 36px;
        color: #003227;
    }

    .map-divider {
        width: 96px;
        height: 4px;
        background: #735C00;
        border-radius: 9999px;
    }

    .map-container {
        width: 100%;
        height: 428px;
        border: 8px solid #F1EEE7;
        border-radius: 48px 48px 8px 8px;
        box-shadow: 0px 25px 50px -12px rgba(0, 0, 0, 0.25);
        position: relative;
        overflow: hidden;
        background-color: #E5E7EB;
        background-image: url('https://images.unsplash.com/photo-1524661135-423995f22d0b?q=80&w=1200'); /* Placeholder Map image */
        background-size: cover;
        background-position: center;
    }
    
    .map-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 50, 39, 0.1);
        pointer-events: none;
    }

    .map-marker {
        position: absolute;
        top: 40%;
        left: 45%;
        width: 68px;
        height: 62px;
        background: #003227;
        border-radius: 9999px;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0px 25px 50px -12px rgba(0, 0, 0, 0.25);
        cursor: pointer;
        z-index: 2;
    }
    
    .map-marker::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        background: #735C00;
        opacity: 0.2;
        border-radius: 50%;
        filter: blur(8px);
        z-index: -1;
    }

    .map-marker svg {
        color: #FFE088;
        width: 30px;
        height: 30px;
    }

    .floating-map-card {
        position: absolute;
        right: 40px;
        bottom: 40px;
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(6px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 48px;
        padding: 24px;
        width: 320px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        box-shadow: 0px 20px 25px -5px rgba(0, 0, 0, 0.1);
        z-index: 2;
    }

    .floating-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 700;
        font-size: 16px;
        color: #003227;
    }

    .floating-desc {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 400;
        font-size: 14px;
        color: #404945;
        line-height: 1.4;
    }

    .floating-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 14px;
        color: #735C00;
        text-decoration: none;
        margin-top: 8px;
    }

    /* ===========================
       RESPONSIVE DESIGN
    =========================== */
    @media (max-width: 1024px) {
        .hero-container {
            flex-direction: column;
            text-align: center;
            gap: 64px;
            padding-top: 40px;
        }
        
        .hero-content {
            align-items: center;
        }

        .programs-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .program-card:nth-child(4),
        .program-card:nth-child(5) {
            grid-column: auto;
            justify-self: center;
            margin: 0 auto;
        }
    }

    @media (max-width: 768px) {
        .hero-title { 
            font-size: 48px; 
            line-height: 1.1;
        }
        
        .hero-desc {
            font-size: 18px;
        }

        .programs-grid {
            grid-template-columns: 1fr;
            gap: 48px;
        }

        .programs-title {
            font-size: 36px;
        }

        .floating-map-card {
            right: 20px;
            bottom: 20px;
            left: 20px;
            width: auto;
            border-radius: 32px;
        }
        
        .map-marker {
            left: 50%;
            transform: translateX(-50%);
        }
        
    }
</style>
@endpush

@section('content')

    {{-- ======================== HERO SECTION ======================== --}}
    <section class="program-hero">
        <div class="hero-container">
            <div class="hero-content reveal-left">
                <div class="hero-badge">
                    <span>Islamic Learning</span>
                </div>
                <h1 class="hero-title">Cahaya Ilmu<br>Di Setiap<br>Langkah</h1>
                <p class="hero-desc">Membekali generasi muda dengan pemahaman Al-Qur'an dan nilai-nilai keislaman yang kokoh sebagai pondasi masa depan.</p>
            </div>
            
            <div class="hero-visual reveal-right">
                <div class="hero-image-card">
                    <!-- Ganti src di bawah ini dengan lokasi gambar Anda sendiri. Contoh: asset('images/foto-gedung.jpg') -->
                    <img src="storage\galeri\rWO6eJk5HDh1POpcVa8Cdi3dWjiAYj7PXfcXkgxv.jpg" alt="Gedung TPA Baitur Ridwan" class="hero-img">
                    <div class="hero-image-gradient"></div>
                </div>
                <div class="hero-floating-badge-outer">
                    <span class="floating-badge-number">5+</span>
                    <span class="floating-badge-text">Program<br>Unggulan</span>
                </div>
            </div>
        </div>

        {{-- Wave Separator --}}
        <div class="hero-wave">
            <svg viewBox="0 0 1280 106.66" fill="none" preserveAspectRatio="none">
                <path d="M0 106.66C0 106.66 244 19 640 19C1036 19 1280 106.66 1280 106.66V106.66H0V106.66Z" fill="#FCF9F2"/>
            </svg>
        </div>
    </section>

    {{-- ======================== LEARNING PROGRAMS ======================== --}}
    <section class="programs-section" id="program-list">
        <div class="programs-container">
            <div class="programs-header reveal">
                <h2 class="programs-title">Program Pendidikan Unggulan </h2>
                <div class="map-divider"></div>
                </div>

            <div class="programs-grid">
                {{-- Program 1 --}}
                <div class="program-card reveal delay-100">
                    <div class="program-icon-wrapper">
                        <div class="program-icon-inner">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/></svg>
                        </div>
                    </div>
                    <h3 class="program-card-title">Pra-Tahsin</h3>
                    <p class="program-card-desc">Pengenalan huruf Hijaiyah dasar dengan metode Iqro yang interaktif untuk santri usia dini (4-6 tahun).</p>
                </div>

                {{-- Program 2 --}}
                <div class="program-card reveal delay-200">
                    <div class="program-icon-wrapper">
                        <div class="program-icon-inner">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1z"/></svg>
                        </div>
                    </div>
                    <h3 class="program-card-title">Tahsin Al-Qur'an</h3>
                    <p class="program-card-desc">Pembinaan membaca Al-Qur'an dengan tajwid yang benar, makharijul huruf tepat, dan tartil yang indah.</p>
                </div>

                {{-- Program 3 --}}
                <div class="program-card reveal delay-300">
                    <div class="program-icon-wrapper">
                        <div class="program-icon-inner">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zm4.24 16L12 15.45 7.77 18l1.12-4.81-3.73-3.23 4.92-.42L12 5l1.92 4.53 4.92.42-3.73 3.23L16.23 18z"/></svg>
                        </div>
                    </div>
                    <h3 class="program-card-title">Tahfidz Anak</h3>
                    <p class="program-card-desc">Program menghafal juz 30 (Juz 'Amma) beserta doa-doa harian pendek dengan metode muraja'ah menyenangkan.</p>
                </div>

                {{-- Program 4 --}}
                <div class="program-card reveal delay-100">
                    <div class="program-icon-wrapper">
                        <div class="program-icon-inner">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M21 3H3v18h18V3zM5 19V5h14v14H5zm11-9V8H8v2h8zm0 4v-2H8v2h8z"/></svg>
                        </div>
                    </div>
                    <h3 class="program-card-title">Fikih Ibadah Praktis</h3>
                    <p class="program-card-desc">Praktek wudhu, shalat, dan tata cara ibadah sehari-hari untuk membentuk kemandirian ibadah anak.</p>
                </div>

                {{-- Program 5 --}}
                <div class="program-card reveal delay-200">
                    <div class="program-icon-wrapper">
                        <div class="program-icon-inner">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                        </div>
                    </div>
                    <h3 class="program-card-title">Kajian Adab & Akhlak</h3>
                    <p class="program-card-desc">Bercerita (storytelling) kisah Nabi dan sahabat untuk meneladani akhlak mulia dalam kehidupan sosial.</p>
                </div>
            </div>
        </div>
    </section>


     {{-- ======================== MAP SECTION ======================== --}}
    <section class="map-section reveal">
        <div class="map-header">
            <h2 class="map-title">Lokasi TPA</h2>
            <div class="map-divider"></div>
        </div>

        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.682316673239!2d100.4616166!3d-0.47308330000000004!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2fd52f00130cb071%3A0x64ffaf1ee1a23d2!2sTPA%20Baitur%20Ridwan!5e0!3m2!1sen!2sid!4v1783901480347!5m2!1sen!2sid" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>
        </div>
    </section>

@endsection