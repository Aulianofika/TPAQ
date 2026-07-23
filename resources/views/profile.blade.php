@extends('layouts.layout')

@section('title', 'Profil TPA — Taman Pendidikan Al-Quran')
@section('meta_description', 'Profil dan identitas TPA Baitur Ridwan. Membangun generasi Qur\'ani yang berakhlak mulia.')

@push('styles')
<style>
    /* ===========================
       HERO / ABOUT SECTION (Asymmetric)
    =========================== */
    .profile-hero {
        position: relative;
        width: 100%;
        min-height: 819px;
        background: var(--cream);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 96px 24px;
        overflow: hidden;
    }

    .hero-container {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        max-width: 1280px;
        width: 100%;
        gap: 64px;
        position: relative;
        z-index: 1;
    }

    .hero-visual {
        position: relative;
        width: 420px;
        height: 520px;
        flex-shrink: 0;
        margin-top: 0;
    }

    /* Decorative glow */
    .hero-glow {
        position: absolute;
        width: 160px;
        height: 160px;
        left: -23px;
        bottom: -27px;
        background: #FED65B;
        opacity: 0.3;
        filter: blur(32px);
        border-radius: 50%;
        z-index: 0;
    }

    .hero-image-card {
        position: absolute;
        inset: 0;
        background-color: var(--green-deep);
        box-shadow: 0px 20px 40px -10px rgba(0, 50, 39, 0.2);
        border-radius: 240px 240px 16px 16px;
        border: 3px solid var(--cream);
        overflow: hidden;
        z-index: 1;
        transition: transform 0.3s ease;
    }
    
    .hero-image-card:hover {
        transform: translateY(-8px);
    }

    .hero-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: absolute;
        inset: 0;
        z-index: 0;
    }

    .hero-image-gradient {
        position: absolute;
        inset: 0;
        background: linear-gradient(0deg, rgba(0, 50, 39, 0.4) 0%, rgba(0, 50, 39, 0) 100%);
    }

    .hero-content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        max-width: 576px;
    }

    .hero-label {
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 16px;
        line-height: 24px;
        letter-spacing: 1.6px;
        text-transform: uppercase;
        color: var(--gold-dark);
        margin-bottom: 16px;
    }

    .hero-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: 56px;
        line-height: 1.1;
        color: var(--green-deep);
        margin-bottom: 24px;
    }

    .hero-desc {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 400;
        font-size: 18px;
        line-height: 29px;
        color: var(--text-mid);
        margin-bottom: 32px;
    }

    .hero-founder {
        display: flex;
        flex-direction: row;
        align-items: center;
        padding: 16px;
        gap: 16px;
        background: #F1EEE7;
        border-radius: 32px;
    }

    .founder-icon {
        width: 44px;
        height: 44px;
        background: var(--green-deep);
        border-radius: 50%;
        display: flex;
        align-items: center;
        color: var(--gold);
        justify-content: center;
    }
        

    .founder-info {
        display: flex;
        flex-direction: column;
    }

    .founder-name {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 700;
        font-size: 16px;
        color: var(--green-deep);
    }

    .founder-role {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 400;
        font-size: 14px;
        color: var(--text-mid);
    }

    /* ===========================
       VISION & MISSION (Curved Panels)
    =========================== */
    .vm-section {
        width: 100%;
        background: var(--cream-alt);
        padding: 96px 0;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .vm-container {
        width: 100%;
        max-width: 1088px;
        padding: 0 24px;
        display: flex;
        flex-direction: column;
        gap: 64px;
    }

    .section-header-center {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
        text-align: center;
    }

    .section-title-center {
        font-family: 'Epilogue', sans-serif;
        font-weight: 700;
        font-size: 36px;
        color: var(--green-deep);
    }

    .section-divider {
        width: 96px;
        height: 4px;
        background: var(--gold-dark);
        border-radius: 9999px;
    }

    .vm-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        align-items: stretch;
    }

    .vision-card {
        background: var(--green-deep);
        box-shadow: 0px 20px 25px -5px rgba(0, 0, 0, 0.1);
        border-radius: 48px 48px 8px 8px;
        padding: 48px;
        display: flex;
        flex-direction: column;
        gap: 24px;
        position: relative;
        overflow: hidden;
    }

    .vision-header {
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 1;
    }

    .vision-icon {
        color: var(--gold-dark);
    }

    .vision-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 700;
        font-size: 30px;
        color: var(--white);
    }

    .vision-content {
        border-left: 4px solid var(--gold-dark);
        padding: 8px 0 8px 24px;
        z-index: 1;
    }

    .vision-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-style: italic;
        font-weight: 500;
        font-size: 20px;
        line-height: 32px;
        color: var(--white);
    }

    .vision-bg-icon {
        position: absolute;
        right: 37px;
        top: 53px;
        color: var(--white);
        opacity: 0.1;
        width: 117px;
        height: 80px;
        z-index: 0;
    }

    .mission-card {
        background: var(--white);
        border: 1px solid rgba(191, 201, 196, 0.1);
        box-shadow: 0px 10px 15px -3px rgba(0, 0, 0, 0.1);
        border-radius: 48px 48px 8px 8px;
        padding: 48px;
        display: flex;
        flex-direction: column;
        gap: 24px;
        position: relative;
        overflow: hidden;
    }

    .mission-header {
        display: flex;
        align-items: center;
        gap: 12px;
        z-index: 1;
    }

    .mission-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 700;
        font-size: 30px;
        color: var(--green-deep);
    }

    .mission-list {
        display: flex;
        flex-direction: column;
        gap: 16px;
        z-index: 1;
    }

    .mission-item {
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .mission-icon {
        margin-top: 4px;
        color: var(--gold-dark);
    }

    .mission-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 400;
        font-size: 16px;
        line-height: 24px;
        color: var(--text-dark);
    }

    .mission-bg-icon {
        position: absolute;
        right: 49px;
        top: 38px;
        color: var(--green-deep);
        opacity: 0.05;
        width: 96px;
        height: 106px;
        z-index: 0;
    }



    /* ===========================
       EDUCATIONAL VALUES (Premium Bento)
    =========================== */
    .bento-section {
        width: 100%;
        background: var(--white); /* Changed to white as requested */
        padding: 96px 0;
        position: relative;
        overflow: hidden;
    }

    .bento-pattern {
        position: absolute;
        inset: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23003227' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
    }

    .bento-container {
        position: relative;
        z-index: 1;
        max-width: 1088px;
        margin: 0 auto;
        padding: 0 24px;
        display: flex;
        flex-direction: column;
        gap: 56px;
    }

    .bento-header-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: 40px;
        color: var(--green-deep);
        text-align: center;
        letter-spacing: -1px;
    }

    .bento-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        grid-auto-rows: minmax(240px, auto);
        gap: 20px;
    }

    .bento-card {
        border-radius: 32px;
        padding: 40px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275), box-shadow 0.4s ease;
        position: relative;
        overflow: hidden;
    }

    .bento-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0px 25px 50px -12px rgba(0, 50, 39, 0.15); /* Softer shadow for white bg */
    }

    .bento-icon-wrapper {
        width: 56px;
        height: 56px;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: auto;
    }

    .bento-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: 26px;
        line-height: 1.2;
    }

    .bento-desc {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 400;
        font-size: 15px;
        line-height: 1.6;
    }

    /* Specific Bento Cards - Premium Theme for White BG */
    .bento-akhlak {
        grid-column: span 2;
        background: var(--green-deep);
    }
    .bento-akhlak .bento-icon-wrapper { background: rgba(254, 214, 91, 0.2); color: var(--gold); }
    .bento-akhlak .bento-title { color: var(--white); }
    .bento-akhlak .bento-desc { color: rgba(255, 255, 255, 0.8); }

    .bento-disiplin {
        grid-column: span 1;
        background: var(--cream-alt);
        border: 1px solid rgba(0, 50, 39, 0.05);
    }
    .bento-disiplin .bento-icon-wrapper { background: rgba(0, 50, 39, 0.08); color: var(--green-deep); }
    .bento-disiplin .bento-title { font-size: 22px; color: var(--green-deep); }
    .bento-disiplin .bento-desc { font-size: 14px; color: var(--text-mid); }

    .bento-tahfidz {
        grid-column: span 1;
        background: var(--gold);
    }
    .bento-tahfidz .bento-icon-wrapper { background: rgba(0, 50, 39, 0.1); color: var(--green-deep); }
    .bento-tahfidz .bento-title { font-size: 22px; color: var(--green-deep); }
    .bento-tahfidz .bento-desc { font-size: 14px; color: rgba(0, 50, 39, 0.8); }

    .bento-kebersihan {
        grid-column: span 1;
        background: var(--cream-alt);
        border: 1px solid rgba(0, 50, 39, 0.05);
    }
    .bento-kebersihan .bento-icon-wrapper { background: rgba(254, 214, 91, 0.3); color: var(--gold-dark); }
    .bento-kebersihan .bento-title { font-size: 22px; color: var(--green-deep); }
    .bento-kebersihan .bento-desc { font-size: 14px; color: var(--text-mid); }

    .bento-mandiri {
        grid-column: span 3;
        background: var(--cream);
        flex-direction: row;
        align-items: center;
        gap: 40px;
        border: 1px solid rgba(0, 50, 39, 0.05);
        padding: 24px;
    }
    
    .bento-mandiri-content {
        display: flex;
        flex-direction: column;
        gap: 16px;
        flex: 1;
        padding-right: 24px;
    }
    .bento-mandiri .bento-title { color: var(--green-deep); }
    .bento-mandiri .bento-desc { color: var(--text-mid); }

    /* ===========================
       RESPONSIVE (Profile)
    =========================== */
    @media (max-width: 1024px) {
        .hero-container { flex-direction: column; text-align: center; }
        .hero-content { align-items: center; }
        .hero-desc { text-align: center; }
        .hero-visual { width: 100%; max-width: 400px; height: 480px; margin-top: 40px; }
        
        .vm-grid { grid-template-columns: 1fr; }
        .bento-grid { grid-template-columns: repeat(2, 1fr); }
        .bento-akhlak, .bento-mandiri { grid-column: span 2; }
        .bento-kebersihan { grid-column: span 2; } /* Fill empty cell */
        .bento-mandiri { flex-direction: column; }
    }

    @media (max-width: 768px) {
        .vision-card, .mission-card { padding: 32px 24px; }
        
        .hero-title { font-size: 40px; }
        .hero-visual { height: 400px; }
        
        .bento-grid { grid-template-columns: 1fr; }
        .bento-akhlak, .bento-disiplin, .bento-tahfidz, .bento-kebersihan, .bento-mandiri { grid-column: span 1; }
    }
</style>
@endpush

@section('content')

    {{-- ======================== HERO / ABOUT ======================== --}}
    <section class="profile-hero">
        <div class="hero-container">
            <div class="hero-content reveal-left">
                <div class="hero-label">TPA BAITUR RIDWAN</div>
                <h1 class="hero-title">Tempat Tumbuhnya Generasi Qur'ani</h1>
                <p class="hero-desc">
                    Berawal dari kepedulian warga kampung terhadap pendidikan agama anak-anak, TPA Baitur Ridwan hadir sebagai tempat belajar mengaji yang hangat dan bersahaja. Di sinilah anak-anak kampung berkumpul setiap sore, belajar membaca Al-Qur'an dengan gembira, sambil dibimbing untuk memiliki akhlak yang baik. Sederhana, namun penuh keberkahan</p>
            </div>
            <div class="hero-visual reveal-right">
                <div class="hero-glow"></div>
                <div class="hero-image-card">
                    <!-- Ganti src di bawah ini dengan lokasi gambar Anda sendiri. Contoh: asset('images/foto-gedung.jpg') -->
                    <img src="https://lh3.googleusercontent.com/gps-cs-s/APNQkAFvVql5dynz6skcshSCxzZ5BJmpqqGATNc63I1rg5Zi5OB39NEF0ZHoqReAsQm7R5ORqpu7YngJP-pybal91JW05Y2bhGoEf7rzetGTG6Jw5kzo2CFitKddaZ6KgciXu2qmUCqKaCd-o5Xv=s680-w680-h510-rw" alt="Gedung TPA Baitur Ridwan" class="hero-img">
                    <div class="hero-image-gradient"></div>
                </div>
            </div>
        </div>
    </section>

    {{-- ======================== VISION & MISSION ======================== --}}
    <section class="vm-section">
        <div class="vm-container">
            <div class="section-header-center reveal">
                <h2 class="section-title-center">Visi & Misi</h2>
                <div class="section-divider"></div>
            </div>

            <div class="vm-grid">
                {{-- Vision --}}
                <div class="vision-card reveal delay-100">
                    <div class="vision-header">
                        <svg class="vision-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L2 12h3v8h6v-6h2v6h6v-8h3L12 2z"/></svg>
                        <h3 class="vision-title">Visi Kami</h3>
                    </div>
                    <div class="vision-content">
                        <p class="vision-text">"Menjadi lembaga pendidikan Al-Qur'an terdepan yang melahirkan generasi Rabbani, cinta Al-Qur'an, dan berakhlakul karimah."</p>
                    </div>
                    </div>

                {{-- Mission --}}
                <div class="mission-card reveal delay-200">
                    <div class="mission-header">
                        <svg class="mission-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm-2 16l-4-4 1.41-1.41L10 14.17l6.59-6.59L18 9l-8 8z"/></svg>
                        <h3 class="mission-title">Misi Kami</h3>
                    </div>
                    <div class="mission-list">
                        <div class="mission-item">
                            <svg class="mission-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>
                            <span class="mission-text">Menyelenggarakan pendidikan Al-Qur'an dengan metode yang mudah, menyenangkan, dan tepat.</span>
                        </div>
                        <div class="mission-item">
                            <svg class="mission-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>
                            <span class="mission-text">Membina akhlak santri sesuai dengan tuntunan sunnah Rasulullah SAW dalam kehidupan sehari-hari.</span>
                        </div>
                        <div class="mission-item">
                            <svg class="mission-icon" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M9 16.2L4.8 12l-1.4 1.4L9 19 21 7l-1.4-1.4L9 16.2z"/></svg>
                            <span class="mission-text">Membangun sinergi dengan orang tua untuk mendukung keberhasilan pendidikan anak di rumah.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>



    {{-- ======================== EDUCATIONAL VALUES (Bento Grid) ======================== --}}
    <section class="bento-section">
        <div class="bento-pattern"></div>
        <div class="bento-container">
            <div class="section-header-center reveal">
                <h2 class="bento-header-title">Nilai Pendidikan Kami</h2>
                <div class="section-divider"></div>
            </div>

            <div class="bento-grid">
                {{-- Akhlak (Span 2) --}}
                <div class="bento-card bento-akhlak reveal delay-100">
                    <div class="bento-icon-wrapper">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </div>
                    <h3 class="bento-title">Akhlakul Karimah</h3>
                    <p class="bento-desc">Menitikberatkan pada kesantunan bertutur kata dan keluhuran budi pekerti dalam setiap interaksi sosial, mencontoh Rasulullah SAW.</p>
                </div>

                {{-- Disiplin (Span 1) --}}
                <div class="bento-card bento-disiplin reveal delay-200">
                    <div class="bento-icon-wrapper">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z"/></svg>
                    </div>
                    <h3 class="bento-title">Disiplin</h3>
                    <p class="bento-desc">Menanamkan ketepatan waktu dan tanggung jawab dalam kewajiban ibadah.</p>
                </div>

                {{-- Tahfidz (Span 1) --}}
                <div class="bento-card bento-tahfidz reveal delay-300">
                    <div class="bento-icon-wrapper">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M21 5c-1.11-.35-2.33-.5-3.5-.5-1.95 0-4.05.4-5.5 1.5-1.45-1.1-3.55-1.5-5.5-1.5S2.45 4.9 1 6v14.65c0 .25.25.5.5.5.1 0 .15-.05.25-.05C3.1 20.45 5.05 20 6.5 20c1.95 0 4.05.4 5.5 1.5 1.35-.85 3.8-1.5 5.5-1.5 1.65 0 3.35.3 4.75 1.05.1.05.15.05.25.05.25 0 .5-.25.5-.5V6c-.6-.45-1.25-.75-2-1z"/></svg>
                    </div>
                    <h3 class="bento-title">Kefasihan</h3>
                    <p class="bento-desc">Fokus pada tajwid dan makharijul huruf yang tepat untuk tilawah yang sempurna.</p>
                </div>

                {{-- Kebersihan (Span 1) --}}
                <div class="bento-card bento-kebersihan reveal delay-100">
                    <div class="bento-icon-wrapper">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/><path d="M12 6c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6z"/></svg>
                    </div>
                    <h3 class="bento-title">Kebersihan</h3>
                    <p class="bento-desc">Menjaga kebersihan diri, tempat belajar, dan lingkungan sekitar.</p>
                </div>

                {{-- Kemandirian (Span 3, Row) --}}
                <div class="bento-card bento-mandiri reveal delay-200">
                    <div class="bento-mandiri-content">
                        <h3 class="bento-title">Kemandirian & Keberanian</h3>
                        <p class="bento-desc">Melatih santri untuk berani tampil di depan umum melalui program muhadharah dan mandiri dalam mengelola tugas harian mereka.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
