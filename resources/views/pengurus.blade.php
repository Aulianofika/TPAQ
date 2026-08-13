@extends('layouts.layout')

@section('title', 'Pengelola TPA — Taman Pendidikan Al-Quran')
@section('meta_description', 'Mengenal tim pengelola, asatidzah, dan staf administrasi TPA Baitur Ridwan.')

@push('styles')
<style>
    /* ===========================
       GLOBAL & HERO SECTION
    =========================== */
    .pengurus-page {
        background: #FCF9F2;
        padding-bottom: 96px;
        overflow-x: hidden;
    }

    .pengurus-hero {
        position: relative;
        width: 100%;
        padding: 128px 24px 96px;
        display: flex;
        flex-direction: column;
        align-items: center;
        background: #004B3C;
        text-align: center;
        overflow: hidden;
    }

    .hero-container {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        max-width: 800px;
        gap: 16px;
        width: 100%;
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 18px;
        background: rgba(254, 214, 91, 0.15);
        border: 1px solid rgba(254, 214, 91, 0.4);
        border-radius: 9999px;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 13px;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #FED65B;
    }

    .hero-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 900;
        font-size: clamp(36px, 5vw, 60px);
        line-height: 1.1;
        letter-spacing: -1.2px;
        color: #FFFFFF;
        margin: 0;
    }

    .hero-desc {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 400;
        font-size: clamp(15px, 1.8vw, 18px);
        line-height: 1.6;
        color: #7CBAA6;
        margin: 0;
    }

    /* Wave Separator */
    .hero-wave {
        position: absolute;
        bottom: -1px;
        left: 0;
        width: 100%;
        line-height: 0;
        z-index: 1;
    }

    .hero-wave svg {
        display: block;
        width: 100%;
        height: 80px;
    }

    /* ===========================
       MAIN CONTENT CONTAINER
    =========================== */
    .pengurus-main {
        max-width: 1200px;
        margin: 0 auto;
        padding: 48px 24px 0;
        display: flex;
        flex-direction: column;
        gap: 64px;
    }

    /* SECTION HEADERS */
    .section-group {
        display: flex;
        flex-direction: column;
        gap: 32px;
    }

    .group-header {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        gap: 8px;
    }

    .group-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: 28px;
        color: #003227;
        margin: 0;
    }

    .group-divider {
        width: 64px;
        height: 3px;
        background: #735C00;
        border-radius: 9999px;
    }

    /* CARD GRID */
    .team-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
        width: 100%;
    }

    /* TEAM CARD */
    .team-card {
        background: #FFFFFF;
        border: 1px solid rgba(0, 50, 39, 0.08);
        border-radius: 20px;
        padding: 32px 24px;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .team-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0, 50, 39, 0.08);
    }

    .avatar-wrapper {
        width: 104px;
        height: 104px;
        border-radius: 50%;
        padding: 4px;
        background: linear-gradient(135deg, #004B3C 0%, #735C00 100%);
        margin-bottom: 20px;
        flex-shrink: 0;
    }

    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #FFFFFF;
        background-color: #E5E7EB;
    }

    .avatar-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 2px solid #FFFFFF;
        background: #004B3C;
        color: #FED65B;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Epilogue', sans-serif;
        font-weight: 700;
        font-size: 32px;
    }

    .member-name {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: 20px;
        line-height: 1.3;
        color: #003227;
        margin: 0 0 8px 0;
    }

    .role-badge {
        display: inline-block;
        padding: 4px 14px;
        border-radius: 9999px;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 12px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        margin-bottom: 8px;
    }

    .role-badge.kepala {
        background: #FED65B;
        color: #745C00;
    }

    .role-badge.pengurus {
        background: #004B3C;
        color: #FFFFFF;
    }

    .role-badge.ustadz {
        background: #E6F4F1;
        color: #004B3C;
    }

    .role-badge.ustadzah {
        background: #FFF8E7;
        color: #735C00;
    }

    .member-quote {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-style: italic;
        font-size: 14px;
        line-height: 1.5;
        color: #55605C;
        margin-top: 4px;
    }

    /* FEATURED KEPALA TPA CARD */
    .kepala-card {
        background: #FFFFFF;
        border: 1px solid rgba(0, 50, 39, 0.1);
        border-left: 6px solid #FED65B;
        border-radius: 24px;
        padding: 36px 40px;
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 32px;
        box-shadow: 0 10px 30px rgba(0, 50, 39, 0.05);
        margin-bottom: 32px;
        width: 100%;
    }

    .kepala-avatar-wrapper {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        padding: 4px;
        background: linear-gradient(135deg, #735C00 0%, #004B3C 100%);
        flex-shrink: 0;
    }

    .kepala-avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid #FFFFFF;
    }

    .kepala-avatar-placeholder {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 3px solid #FFFFFF;
        background: #004B3C;
        color: #FED65B;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .kepala-info {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
        flex: 1;
    }

    .kepala-name {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: 26px;
        line-height: 1.2;
        color: #003227;
        margin: 0;
    }

    .kepala-quote-box {
        position: relative;
        background: #FCF9F2;
        border-radius: 16px;
        padding: 16px 20px;
        margin-top: 6px;
        width: 100%;
        border: 1px solid rgba(115, 92, 0, 0.12);
        display: flex;
        align-items: flex-start;
        gap: 12px;
    }

    .quote-mark-icon {
        color: #735C00;
        flex-shrink: 0;
        margin-top: 2px;
    }

    .kepala-quote-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-style: italic;
        font-size: 15px;
        line-height: 1.6;
        color: #374151;
        margin: 0;
    }

    /* EMPTY STATE */
    .empty-state {
        text-align: center;
        padding: 40px;
        color: #6B7280;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* HADITH BANNER */
    .quote-banner {
        background: #004B3C;
        border-radius: 24px;
        padding: 48px 32px;
        text-align: center;
        color: #FFFFFF;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 16px;
        position: relative;
        overflow: hidden;
    }

    .quote-banner-text {
        font-family: 'Epilogue', sans-serif;
        font-style: italic;
        font-weight: 400;
        font-size: clamp(20px, 3vw, 28px);
        line-height: 1.4;
        color: #ECFDF5;
        max-width: 760px;
        margin: 0;
    }

    .quote-banner-author {
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 13px;
        letter-spacing: 2px;
        color: #FED65B;
        text-transform: uppercase;
    }

    @media (max-width: 768px) {
        .pengurus-hero {
            padding: 100px 20px 60px;
        }

        .pengurus-main {
            padding: 32px 16px 0;
            gap: 48px;
        }

        .team-grid {
            grid-template-columns: 1fr;
        }

        .quote-banner {
            padding: 36px 20px;
        }

        .kepala-card {
            flex-direction: column;
            text-align: center;
            padding: 32px 20px;
            align-items: center;
        }

        .kepala-info {
            align-items: center;
        }

        .kepala-name {
            font-size: 22px;
        }
    }
</style>
@endpush

@section('content')
<div class="pengurus-page">
    {{-- ======================== HERO SECTION ======================== --}}
    <section class="pengurus-hero">
        <div class="hero-container reveal">
            <div class="hero-badge">Tim Pengelola & Pengajar</div>
            <h1 class="hero-title">Pengelola TPA Baitur Ridwan</h1>
            <p class="hero-desc">Mengenal para ustaz, ustazah, dan pengurus yang berdedikasi membimbing santri dengan penuh keikhlasan.</p>
        </div>
        <div class="hero-wave">
            <svg viewBox="0 0 1440 120" fill="none" preserveAspectRatio="none">
                <path d="M0,60 C480,120 960,0 1440,60 L1440,120 L0,120 Z" fill="#FCF9F2" />
            </svg>
        </div>
    </section>

    {{-- ======================== MAIN CONTENT ======================== --}}
    <div class="pengurus-main">

        {{-- SECTION 1: PENGURUS TPA --}}
        @if($pengurusList->count() > 0)
        @php
            $kepala = $pengurusList->firstWhere('is_kepala', 1);
            $otherPengurus = $pengurusList->reject(fn($p) => $p->is_kepala == 1);
        @endphp
        <div class="section-group">
            <div class="group-header reveal">
                <h2 class="group-title">Pengurus & Manajemen</h2>
                <div class="group-divider"></div>
            </div>

            @if($kepala)
            {{-- FEATURED KEPALA TPA CARD --}}
            <div class="kepala-card reveal">
                <div class="kepala-avatar-wrapper">
                    @if($kepala->foto)
                        <img src="{{ Storage::url($kepala->foto) }}" alt="{{ $kepala->nama }}" class="kepala-avatar-img">
                    @else
                        <div class="kepala-avatar-placeholder">
                            <svg width="56" height="56" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="kepala-info">
                    <span class="role-badge kepala">Kepala TPA</span>
                    <h3 class="kepala-name">{{ $kepala->nama }}</h3>
                    <div class="kepala-quote-box">
                        <svg class="quote-mark-icon" width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6 17h3l2-4V7H5v6h3zm8 0h3l2-4V7h-6v6h3z"/>
                        </svg>
                        <p class="kepala-quote-text">"Kami membantu menanamkan benih, namun Ayah dan Bundalah yang menyiramnya di rumah"</p>
                    </div>
                </div>
            </div>
            @endif

            @if($otherPengurus->count() > 0)
            <div class="team-grid">
                @foreach($otherPengurus as $pengurus)
                <div class="team-card reveal">
                    <div class="avatar-wrapper">
                        @if($pengurus->foto)
                            <img src="{{ Storage::url($pengurus->foto) }}" alt="{{ $pengurus->nama }}" class="avatar-img">
                        @else
                            <div class="avatar-placeholder">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <h3 class="member-name">{{ $pengurus->nama }}</h3>
                    <span class="role-badge pengurus">Pengurus TPA</span>
                </div>
                @endforeach
            </div>
            @endif
        </div>
        @endif

        {{-- SECTION 2: PENGAJAR / ASATIDZAH --}}
        @if($pengajars->count() > 0)
        <div class="section-group">
            <div class="group-header reveal">
                <h2 class="group-title">Asatidzah Pengajar</h2>
                <div class="group-divider"></div>
            </div>

            <div class="team-grid">
                @foreach($pengajars as $pengajar)
                @php
                    $isMale = $pengajar->jenis_kelamin == 'L';
                    $roleClass = $isMale ? 'ustadz' : 'ustadzah';
                    $roleLabel = $isMale ? 'Ustadz Pengajar' : 'Ustadzah Pengajar';
                @endphp
                <div class="team-card reveal">
                    <div class="avatar-wrapper">
                        @if($pengajar->foto)
                            <img src="{{ Storage::url($pengajar->foto) }}" alt="{{ $pengajar->nama }}" class="avatar-img">
                        @else
                            <div class="avatar-placeholder">
                                <svg width="48" height="48" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <h3 class="member-name">{{ $pengajar->nama }}</h3>
                    <span class="role-badge {{ $roleClass }}">{{ $roleLabel }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($pengurusList->isEmpty() && $pengajars->isEmpty())
            <div class="empty-state">
                <p>Belum ada data pengurus atau pengajar yang ditambahkan.</p>
            </div>
        @endif

        {{-- HADITH QUOTE BANNER --}}
        <div class="quote-banner reveal">
            <p class="quote-banner-text">"Sebaik-baik kalian adalah yang belajar Al-Qur'an dan mengajarkannya."</p>
            <span class="quote-banner-author">HR. BUKHARI</span>
        </div>

    </div>
</div>
@endsection