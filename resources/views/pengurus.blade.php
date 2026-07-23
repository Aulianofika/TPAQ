@extends('layouts.layout')

@section('title', 'Pengurus TPA — Taman Pendidikan Al-Quran')
@section('meta_description', 'Mengenal tim pengelola, asatidzah, dan staf administrasi TPA Al-Iman.')

@push('styles')
<style>
    /* ===========================
       GLOBAL & HERO SECTION
    =========================== */
    .pengurus-page {
        background: #FFFFFF;
        padding-bottom: 96px;
        overflow-x: hidden;
    }

    .pengurus-hero {
        position: relative;
        width: 100%;
        padding: 128px 24px 80px;
        display: flex;
        flex-direction: column;
        align-items: center;
        background: #FFFFFF;
        overflow: hidden;
    }

    .hero-pattern {
        position: absolute;
        left: 0;
        right: 0;
        top: 0;
        height: 100%;
        background: transparent;
        pointer-events: none;
        z-index: 0;
    }

    .hero-container {
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        max-width: 1216px;
        gap: 16px;
        width: 100%;
    }

    .hero-subtitle {
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 14px;
        line-height: 20px;
        letter-spacing: 1.4px;
        text-transform: uppercase;
        color: #735C00;
    }

    .hero-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: clamp(40px, 6vw, 72px);
        line-height: 1.1;
        letter-spacing: -1.8px;
        color: var(--green-deep);
        max-width: 900px;
    }

    .hero-desc {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 400;
        font-size: clamp(16px, 2vw, 18px);
        line-height: 1.56;
        color: #404945;
        max-width: 672px;
        margin-top: 8px;
    }

    /* ===========================
       MANAGEMENT CONTENT
    =========================== */
    .management-content {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 96px;
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 32px;
        width: 100%;
    }

    /* KEPALA TPA SECTION */
    .kepala-tpa-section {
        position: relative;
        width: 100%;
        max-width: 1024px; /* Reduced from 1216px */
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: space-between;
        background: #FFFFFF;
        box-shadow: 0px 48px 48px rgba(0, 50, 39, 0.06);
        border: 1px solid rgba(191, 201, 196, 0.15);
        border-left: 8px solid #735C00;
        border-radius: 40px; /* Slightly reduced */
        padding: 48px; /* Reduced from 64px */
        gap: 32px; /* Reduced from 40px */
        margin: 30px auto 0; /* Center the smaller card and shift down */
    }

    .kepala-content {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        max-width: 554px;
        gap: 16px;
        z-index: 2;
    }

    .kepala-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 16px;
        background: var(--green-deep);
        border-radius: 9999px;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 12px;
        letter-spacing: 1.2px;
        text-transform: uppercase;
        color: var(--white);
    }

    .kepala-name {
        font-family: 'Epilogue', sans-serif;
        font-weight: 700;
        font-size: clamp(28px, 3.5vw, 40px);
        line-height: 1.1;
        color: var(--green-deep);
        margin-top: 8px;
    }

    .kepala-role {
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: clamp(16px, 2vw, 20px);
        color: #735C00;
    }

    .kepala-quote {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 400;
        font-style: italic;
        font-size: clamp(14px, 1.5vw, 16px);
        line-height: 1.62;
        color: #404945;
        margin-top: 8px;
    }

    .kepala-visual {
        position: relative;
        width: 100%;
        max-width: 360px; /* Reduced from 478px */
        aspect-ratio: 1;
        flex-shrink: 0;
    }

    .kepala-visual-glow {
        position: absolute;
        inset: -12px;
        background: #FED65B;
        opacity: 0.2;
        filter: blur(20px);
        border-radius: 50%;
        z-index: 0;
    }

    .kepala-image-wrapper {
        position: relative;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.002);
        border: 8px solid #E5E2DB;
        box-shadow: 0px 0px 0px 2px rgba(115, 92, 0, 0.2), 0px 20px 25px -5px rgba(0, 0, 0, 0.1), 0px 8px 10px -6px rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        z-index: 1;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .kepala-image {
        width: 100%;
        height: 100%;
        background-color: #D1D5DB; /* Placeholder */
        object-fit: cover;
        border-radius: 50%;
    }

    /* ASATIDZAH / STAFF SECTION (Bento Layering) */
    .staff-section {
        width: 100%;
        max-width: 1216px;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 32px;
    }

    .staff-card {
        position: relative;
        background: #FFFFFF;
        border: 1px solid rgba(191, 201, 196, 0.15);
        box-shadow: 0px 48px 48px rgba(0, 50, 39, 0.06);
        border-radius: 48px;
        padding: 40px 32px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        overflow: hidden;
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.4s ease;
    }

    .staff-card:hover {
        transform: translateY(-12px);
        box-shadow: 0px 48px 48px rgba(0, 50, 39, 0.15);
    }

    .staff-card-icon {
        position: absolute;
        right: 32px;
        top: 32px;
        color: #1C1C18;
        opacity: 0.05;
        width: 100px;
        height: 100px;
        z-index: 0;
        transition: transform 0.5s ease;
    }

    .staff-card:hover .staff-card-icon {
        transform: scale(1.1) rotate(5deg);
    }

    .staff-image-outer {
        position: relative;
        width: 160px;
        height: 160px;
        background: linear-gradient(45deg, #735C00 0%, #004B3C 100%);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 32px;
        z-index: 1;
    }

    .staff-image-inner {
        width: 152px;
        height: 152px;
        border: 4px solid #FFFFFF;
        border-radius: 50%;
        background-color: #E5E7EB; /* Placeholder */
        background-size: cover;
        background-position: center;
        overflow: hidden;
    }

    .staff-image-inner.admin { background-image: url('https://images.unsplash.com/photo-1544723795-3fb6469f5b39?q=80&w=400'); }
    .staff-image-inner.ustadz { background-image: url('https://images.unsplash.com/photo-1594951460592-b43e743da003?q=80&w=400'); }
    .staff-image-inner.ustadzah { background-image: url('https://images.unsplash.com/photo-1589156229687-496a31ad1d1f?q=80&w=400'); }

    .staff-name {
        font-family: 'Epilogue', sans-serif;
        font-weight: 700;
        font-size: 24px;
        line-height: 1.33;
        color: var(--green-deep);
        margin-bottom: 4px;
        z-index: 1;
    }

    .staff-role {
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 14px;
        line-height: 1.43;
        letter-spacing: -0.7px;
        text-transform: uppercase;
        color: #735C00;
        margin-bottom: 24px;
        z-index: 1;
    }

    .staff-desc {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 400;
        font-size: 14px;
        line-height: 1.62;
        color: #404945;
        z-index: 1;
    }

    /* DECORATIVE QUOTE SECTION */
    .quote-section {
        width: 100%;
        max-width: 1216px;
        position: relative;
        background: var(--green-deep);
        border-radius: 48px;
        padding: 80px 40px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 24px;
        overflow: hidden;
    }

    .quote-pattern {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 50, 39, 0.05);
        pointer-events: none;
        z-index: 0;
    }

    .quote-text {
        font-family: 'Epilogue', sans-serif;
        font-style: italic;
        font-weight: 400;
        font-size: clamp(24px, 4vw, 36px);
        line-height: 1.2;
        color: #ECFDF5;
        max-width: 896px;
        z-index: 1;
    }

    .quote-divider {
        width: 96px;
        height: 4px;
        background: #735C00;
        border-radius: 9999px;
        z-index: 1;
    }

    .quote-author {
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 14px;
        line-height: 1.43;
        letter-spacing: 4.2px;
        text-transform: uppercase;
        color: rgba(167, 243, 208, 0.7);
        z-index: 1;
    }

    /* ===========================
       RESPONSIVE DESIGN
    =========================== */
    @media (max-width: 1024px) {
        .kepala-tpa-section {
            flex-direction: column;
            text-align: center;
            padding: 48px 32px;
            border-left: none;
            border-top: 8px solid #735C00;
        }

        .kepala-content {
            align-items: center;
        }

        .kepala-quote {
            text-align: center;
        }

        .kepala-visual {
            max-width: 350px;
        }

        .staff-section {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .pengurus-hero {
            padding: 100px 20px 60px;
        }
        
        .management-content {
            padding: 0 20px;
            gap: 64px;
        }
        
        .kepala-tpa-section {
            padding: 40px 24px;
        }
        
        .staff-section {
            grid-template-columns: 1fr;
        }
        
        .quote-section {
            padding: 64px 24px;
            border-radius: 32px;
        }
    }
</style>
@endpush

@section('content')
<div class="pengurus-page">
    {{-- ======================== HERO SECTION ======================== --}}
    <section class="pengurus-hero">
        <div class="hero-pattern"></div>
        <div class="hero-container reveal">
            <div class="hero-subtitle">MANAJEMEN & PENDIDIK TPA</div>
            <h1 class="hero-title">Anggota Pengurus & Pengajar </h1>
            <p class="hero-desc">Dedikasi dan keikhlasan dalam mendidik generasi penerus yang berakhlak mulia dan mencintai Al-Qur'an.</p>
        </div>
    </section>

    {{-- ======================== MANAGEMENT CONTENT ======================== --}}
    <section class="management-content">
        {{-- All Pengurus & Pengajar --}}
        <div class="staff-section">
            {{-- Semua Pengurus (termasuk Kepala) --}}
            @foreach($pengurusList as $index => $pengurus)
            @php
                $staffRole = $pengurus->is_kepala ? 'KEPALA TPA' : 'PENGURUS TPA';
                $delayAttr = 'style="animation-delay: ' . ($index * 100) . 'ms"';
            @endphp
            <div class="staff-card reveal" {!! $delayAttr !!}>
                <svg class="staff-card-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z"/>
                </svg>
                <div class="staff-image-outer">
                    @if($pengurus->foto)
                        <img src="{{ Storage::url($pengurus->foto) }}" alt="{{ $pengurus->nama }}" class="staff-image-inner">
                    @else
                        <div class="staff-image-inner" style="display: flex; align-items: center; justify-content: center; background-color: #E2E8F0; color: #94A3B8;">
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                    @endif
                </div>
                <h3 class="staff-name">{{ $pengurus->nama }}</h3>
                <div class="staff-role">{{ $staffRole }}</div>
                <p class="staff-desc">Bertanggung jawab atas administrasi santri, pendaftaran, dan informasi jadwal kegiatan operasional TPA.</p>
            </div>
            @endforeach

            {{-- Pengajar --}}
            @foreach($pengajars as $index => $pengajar)
            @php
                $delayAttr = 'style="animation-delay: ' . (($index + $pengurusList->count()) * 100) . 'ms"';
            @endphp
            <div class="staff-card reveal" {!! $delayAttr !!}>
                @if($pengajar->jenis_kelamin == 'L')
                <svg class="staff-card-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                </svg>
                @else
                <svg class="staff-card-icon" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                </svg>
                @endif
                
                <div class="staff-image-outer">
                    @if($pengajar->foto)
                        <img src="{{ Storage::url($pengajar->foto) }}" alt="{{ $pengajar->nama }}" class="staff-image-inner">
                    @else
                        <div class="staff-image-inner" style="display: flex; align-items: center; justify-content: center; background-color: #E2E8F0; color: #94A3B8;">
                            @if($pengajar->jenis_kelamin == 'L')
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 3L1 9l4 2.18v6L12 21l7-3.82v-6l2-1.09V17h2V9L12 3zm6.82 6L12 12.72 5.18 9 12 5.28 18.82 9zM17 15.99l-5 2.73-5-2.73v-3.72L12 15l5-2.73v3.72z"/>
                            </svg>
                            @else
                            <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            @endif
                        </div>
                    @endif
                </div>
                <h3 class="staff-name">{{ $pengajar->nama }}</h3>
                <div class="staff-role">{{ $pengajar->jenis_kelamin == 'L' ? 'USTADZ PENGAJAR' : 'USTADZAH PENGAJAR' }}</div>
                <p class="staff-desc">
                    {{ $pengajar->jenis_kelamin == 'L' ? 'Membimbing santri putra dalam tahsin, tahfidz, dan adab dengan pendekatan yang inspiratif dan menyenangkan.' : 'Membimbing santri putri dengan penuh kelembutan, menanamkan nilai-nilai Qur\'ani dalam keseharian.' }}
                </p>
            </div>
            @endforeach

            @if($pengurusList->isEmpty() && $pengajars->isEmpty())
                <div>Belum ada data asatidzah/pengurus.</div>
            @endif
        </div>

        {{-- Section 3: Decorative Quote --}}
        <div class="quote-section reveal">
            <div class="quote-pattern"></div>
            <h2 class="quote-text">"Sebaik-baik kalian adalah yang belajar Al-Qur'an dan mengajarkannya."</h2>
            <div class="quote-divider"></div>
            <div class="quote-author">HR. BUKHARI</div>
        </div>

    </section>
</div>
@endsection