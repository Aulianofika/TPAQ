@extends('layouts.layout')

@section('title', 'Pengumuman — TPA Al-Quran')
@section('meta_description', 'Informasi, berita terbaru, dan pengumuman kegiatan TPA.')

@push('styles')
<style>
    /* GLOBAL & HERO SECTION */
    .pengumuman-page {
        background: #FCF9F2;
        padding-bottom: 96px;
        overflow-x: hidden;
    }

    .pengumuman-hero {
        position: relative;
        width: 100%;
        padding: 128px 24px 96px;
        display: flex;
        flex-direction: column;
        align-items: center;
        background: #004B3C;
        overflow: hidden;
        min-height: 376px;
    }

    .hero-bg-pattern {
        position: absolute;
        inset: 0;
        background-image: url('https://images.unsplash.com/photo-1542816417-0983c9c9ad53?q=80&w=1200');
        background-size: cover;
        background-position: center;
        opacity: 0.1;
        z-index: 0;
    }

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

    .hero-container {
        position: relative;
        z-index: 2;
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        max-width: 1280px;
        gap: 24px;
        width: 100%;
    }

    .hero-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 900;
        font-size: clamp(40px, 6vw, 72px);
        line-height: 1;
        letter-spacing: -1.8px;
        color: #FFFFFF;
    }

    .hero-desc {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 400;
        font-size: clamp(16px, 2vw, 20px);
        line-height: 1.4;
        color: #7CBAA6;
        max-width: 672px;
    }

    /* ===========================
       MAIN CONTENT (GRID)
    =========================== */
    .pengumuman-main {
        max-width: 1280px;
        margin: 48px auto 96px;
        padding: 0 32px;
        position: relative;
        z-index: 3;
    }

    .pengumuman-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 40px;
    }

    /* Announcement Card */
    .pengumuman-card {
        background: #FFFFFF;
        border: 1px solid rgba(191, 201, 196, 0.2);
        box-shadow: 0px 10px 15px -3px rgba(0, 0, 0, 0.05), 0px 4px 6px -4px rgba(0, 0, 0, 0.05);
        border-radius: 32px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
        position: relative;
    }

    .pengumuman-card:hover {
        transform: translateY(-8px);
        box-shadow: 0px 20px 25px -5px rgba(0, 50, 39, 0.1), 0px 8px 10px -6px rgba(0, 50, 39, 0.1);
        border-color: rgba(124, 186, 166, 0.4);
    }

    .card-image {
        width: 100%;
        height: 220px;
        object-fit: cover;
        background: #E5E7EB;
    }

    .card-body {
        padding: 32px;
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .card-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 16px;
    }

    .card-badge {
        background: #FED65B;
        color: #745C00;
        padding: 6px 12px;
        border-radius: 9999px;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .card-date {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 500;
        font-size: 14px;
        color: #6B7280;
    }

    .card-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 700;
        font-size: 22px;
        line-height: 1.3;
        color: #003227;
        margin-bottom: 12px;
    }

    .card-text {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 400;
        font-size: 16px;
        line-height: 1.6;
        color: #404945;
        margin-bottom: 24px;
        flex-grow: 1;
    }

    .card-link {
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 15px;
        color: #004B3C;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: color 0.2s ease;
    }

    .card-link:hover {
        color: #00735C;
    }

    .card-link svg {
        transition: transform 0.2s ease;
    }

    .card-link:hover svg {
        transform: translateX(4px);
    }

    /* Important Announcement Card styling */
    .pengumuman-card.important {
        border: 2px solid #FED65B;
        background: linear-gradient(180deg, #FFFFFF 0%, #FFFDF7 100%);
    }

    /* Pagination */
    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 64px;
        gap: 8px;
    }

    .page-btn {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #FFFFFF;
        border: 1px solid rgba(191, 201, 196, 0.4);
        color: #003227;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 600;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .page-btn.active {
        background: #004B3C;
        color: #FFFFFF;
        border-color: #004B3C;
        box-shadow: 0px 4px 6px -1px rgba(0, 50, 39, 0.2);
    }

    .page-btn:hover:not(.active) {
        background: #F6F3EC;
        border-color: #7CBAA6;
    }

    @media (max-width: 768px) {
        .pengumuman-hero {
            padding: 100px 20px 60px;
        }
        
        .pengumuman-main {
            padding: 0 20px;
        }

        .pengumuman-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@section('content')
<div class="pengumuman-page">
    
    {{-- ======================== HERO SECTION ======================== --}}
    <section class="pengumuman-hero">
        <div class="hero-bg-pattern"></div>
        <div class="hero-container reveal">
            <h1 class="hero-title">Pengumuman</h1>
            <p class="hero-desc">Informasi, jadwal penting, dan berita terbaru seputar kegiatan belajar mengajar di TPA.</p>
        </div>
        <div class="hero-wave">
            <svg viewBox="0 0 1440 120" fill="none" preserveAspectRatio="none">
                <path d="M0,60 C480,120 960,0 1440,60 L1440,120 L0,120 Z" fill="#FCF9F2" />
            </svg>
        </div>
    </section>

    {{-- ======================== MAIN CONTENT ======================== --}}
    <section class="pengumuman-main">
        <div class="pengumuman-grid reveal">
            @forelse($pengumuman as $p)
                <div class="pengumuman-card {{ $p->kategori == 'penting' ? 'important' : '' }}">
                    @if($p->gambar)
                        <img src="{{ Storage::url($p->gambar) }}" alt="{{ $p->judul }}" class="card-image">
                    @else
                        <div class="card-image" style="display:flex; align-items:center; justify-content:center; background:#EBE8E1;">
                            <span class="material-symbols-outlined" style="font-size: 48px; color: #BFc9c4;">campaign</span>
                        </div>
                    @endif
                    
                    <div class="card-body">
                        <div class="card-meta">
                            @php
                                $badgeStyle = '';
                                if($p->kategori == 'penting') $badgeStyle = 'style="background: #FED65B; color: #745C00;"';
                                elseif($p->kategori == 'kegiatan') $badgeStyle = 'style="background: #B0EFDA; color: #003227;"';
                                else $badgeStyle = 'style="background: #E5E7EB; color: #404945;"';
                            @endphp
                            <span class="card-badge" {!! $badgeStyle !!}>{{ ucfirst($p->kategori) }}</span>
                            <span class="card-date">{{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}</span>
                        </div>
                        <h3 class="card-title">{{ $p->judul }}</h3>
                        <p class="card-text">{{ Str::limit($p->isi, 150) }}</p>
                        <a href="{{ route('pengumuman.show', $p->id_pengumuman) }}" class="card-link">
                            Baca Selengkapnya
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 64px 20px;">
                    <h3 style="color:#003227; font-family:'Epilogue', sans-serif; margin-bottom: 8px;">Belum Ada Pengumuman</h3>
                    <p style="color:#404945; font-family:'Plus Jakarta Sans', sans-serif;">Papan informasi saat ini masih kosong.</p>
                </div>
            @endforelse
        </div>
    </section>

</div>
@endsection
