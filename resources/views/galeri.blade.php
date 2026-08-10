@extends('layouts.layout')

@section('title', 'Galeri TPA — Taman Pendidikan Al-Quran')
@section('meta_description', 'Momen berharga dan kegiatan spiritual santri TPA Al-Iman.')

@push('styles')
    <style>
        /* ===========================
               GLOBAL & HERO SECTION
            =========================== */
        .galeri-page {
            background: #FCF9F2;
            padding-bottom: 96px;
            overflow-x: hidden;
        }

        .galeri-hero {
            position: relative;
            width: 100%;
            padding: 128px 24px 96px;
            display: flex;
            flex-direction: column;
            align-items: center;
            background: #004B3C;
            overflow: hidden;
        }

        .hero-bg-pattern {
            position: absolute;
            inset: 0;
            background-image: url('https://images.unsplash.com/photo-1585036156171-384164d8c6b9?q=80&w=1200');
            /* Subtle mosque background */
            background-size: cover;
            background-position: center;
            opacity: 0.05;
            mix-blend-mode: overlay;
            z-index: 0;
        }

        .hero-wave {
            position: absolute;
            bottom: -1px;
            /* Overlap slightly to prevent gaps */
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

        .hero-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 16px;
            background: #FED65B;
            border-radius: 9999px;
            font-family: 'Manrope', sans-serif;
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: #745C00;
        }

        .hero-title {
            font-family: 'Epilogue', sans-serif;
            font-weight: 800;
            font-size: clamp(40px, 6vw, 72px);
            line-height: 1;
            color: #FFFFFF;
            max-width: 800px;
        }

        .hero-desc {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 300;
            font-size: clamp(16px, 2vw, 20px);
            line-height: 1.4;
            color: #7CBAA6;
            max-width: 672px;
        }

        /* ===========================
               GALLERY FILTERS (Categories)
            =========================== */
        .gallery-filters {
            position: relative;
            z-index: 3;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 16px;
            margin-top: 24px;
            /* Below hero wave */
            padding: 0 24px;
            margin-bottom: 64px;
        }

        .filter-btn {
            padding: 12px 32px;
            border-radius: 9999px;
            font-family: 'Manrope', sans-serif;
            font-weight: 700;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-align: center;
        }

        .filter-btn.active {
            background: #003227;
            color: #FFFFFF;
            box-shadow: 0px 10px 15px -3px rgba(0, 50, 39, 0.2), 0px 4px 6px -4px rgba(0, 50, 39, 0.2);
            border: 1px solid #003227;
        }

        .filter-btn:not(.active) {
            background: #FFFFFF;
            color: #404945;
            border: 1px solid rgba(191, 201, 196, 0.3);
        }

        .filter-btn:not(.active):hover {
            background: #F6F3EC;
            transform: translateY(-2px);
        }

        /* ===========================
               MASONRY GALLERY CONTENT
            =========================== */
        .masonry-container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 24px;
            width: 100%;
        }

        .masonry-columns {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 24px;
            width: 100%;
        }

        .gallery-item {
            position: relative;
            background: #F1EEE7;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            cursor: pointer;
            border-radius: 24px;
            min-height: 300px;
        }

        .gallery-item:hover .item-bg {
            transform: scale(1.05);
        }

        .gallery-item:hover .item-overlay {
            opacity: 1;
        }

        .item-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            background-color: #D1D5DB;
            transition: transform 0.6s cubic-bezier(0.2, 0.8, 0.2, 1);
            z-index: 0;
        }

        .item-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(0deg, rgba(0, 50, 39, 0.8) 0%, rgba(0, 50, 39, 0) 50%, rgba(0, 50, 39, 0) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 24px;
            z-index: 1;
            opacity: 0.8;
            /* Visible by default on mobile, hover enhances it */
            transition: opacity 0.3s ease;
        }

        .item-tag {
            font-family: 'Manrope', sans-serif;
            font-weight: 700;
            font-size: 12px;
            color: #FFE088;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .item-title {
            font-family: 'Epilogue', sans-serif;
            font-weight: 700;
            font-size: 18px;
            color: #FFFFFF;
            line-height: 1.4;
        }

        /* ===========================
               DIVIDER & VIDEO HIGHLIGHT
            =========================== */
        .ornament-divider {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 96px 32px;
            gap: 18px;
            opacity: 0.3;
        }

        .ornament-line {
            width: 128px;
            height: 1px;
            background: #003227;
        }

        .ornament-icon {
            width: 33px;
            height: 33px;
            color: #003227;
        }

        .video-section {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 32px;
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 64px;
            margin-bottom: 96px;
        }

       
        .stat-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .stat-value {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 900;
            font-size: 30px;
            color: #735C00;
        }

        .stat-label {
            font-family: 'Manrope', sans-serif;
            font-weight: 700;
            font-size: 12px;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            color: #404945;
        }

        .stat-divider {
            width: 1px;
            height: 48px;
            background: rgba(191, 201, 196, 0.3);
        }

       /* responsive  */
        @media (max-width: 1024px) {
            .masonry-columns {
                flex-direction: column;
            }

            .item-small-square-wrapper {
                display: none;
                /* Hide decorative circle on medium screens for space */
            }
        }

        @media (max-width: 768px) {
            .galeri-hero {
                padding: 100px 20px 60px;
            }

            .masonry-columns {
                flex-direction: column;
                gap: 24px;
            }

            .gallery-item {
                min-height: 300px !important;
                border-radius: 32px !important;
                margin-top: 0 !important;
                margin-bottom: 0 !important;
            }
           
        }
    </style>
@endpush

@section('content')
    <div class="galeri-page">

        {{-- ======================== HERO SECTION ======================== --}}
        <section class="galeri-hero">
            <div class="hero-bg-pattern"></div>
            <div class="hero-container reveal">
                <div class="hero-badge">SPIRITUAL MOMENTS</div>
                <h1 class="hero-title">Galeri Kegiatan</h1>
                <p class="hero-desc">Rekam jejak spiritual, pembelajaran, dan momen kebersamaan santri dalam menuntut ilmu
                    agama.</p>
            </div>
            <div class="hero-wave">
                <svg viewBox="0 0 1440 120" fill="none" preserveAspectRatio="none">
                    <path d="M0,60 C480,120 960,0 1440,60 L1440,120 L0,120 Z" fill="#FCF9F2" />
                </svg>
            </div>
        </section>

        {{-- ======================== GALLERY FILTERS ======================== --}}
        <div class="gallery-filters reveal">
            <div class="filter-btn active" data-filter="semua">Semua</div>
            <div class="filter-btn" data-filter="pembelajaran">Pembelajaran</div>
            <div class="filter-btn" data-filter="kegiatan">Kegiatan Santri</div>
            <div class="filter-btn" data-filter="wisuda">Wisuda</div>
            <div class="filter-btn" data-filter="prestasi">Prestasi</div>
        </div>

        {{-- ======================== Viewer GALLERY ======================== --}}
        <section class="masonry-container">
            @if($galeris->isEmpty())
                <div style="text-align:center; padding: 100px 20px;">
                    <h3 style="color:#003227; font-family:'Epilogue', sans-serif; margin-bottom: 8px;">Galeri Masih Kosong</h3>
                    <p style="color:#404945; font-family:'Plus Jakarta Sans', sans-serif;">Belum ada dokumentasi foto yang diunggah.</p>
                </div>
            @else
                <div class="masonry-columns">
                @foreach($galeris as $item)
                    <div class="gallery-item reveal gallery-box" data-kategori="{{ $item->kategori }}" onclick="viewImage('{{ Storage::url($item->foto) }}', '{{ addslashes($item->judul) }}')" style="cursor: pointer;">
                        <div class="item-bg" style="background-image: url('{{ Storage::url($item->foto) }}'); background-size: cover; background-position: center;"></div>
                        <div class="item-overlay">
                            <div class="item-tag">{{ strtoupper(str_replace('_', ' ', $item->kategori)) }}</div>
                            <div class="item-title">{{ $item->judul }}</div>
                            @if($item->deskripsi)
                            <div style="color:#FFF; font-size:12px; margin-top:4px; opacity:0.9;">{{ Str::limit($item->deskripsi, 60) }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </section>

        {{-- ======================== DIVIDER ======================== --}}
        <div class="ornament-divider reveal">
            <div class="ornament-line"></div>
            <svg class="ornament-icon" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2L9 9H2L8 14L5 22L12 17L19 22L16 14L22 9H15L12 2Z" />
            </svg>
            <div class="ornament-line"></div>
        </div>

       
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function viewImage(url, title) {
        Swal.fire({
            title: title,
            imageUrl: url,
            imageAlt: title,
            showConfirmButton: false,
            showCloseButton: true,
            customClass: {
                image: 'swal-image-viewer'
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const galleryItems = document.querySelectorAll('.gallery-box');

        filterBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active class from all buttons
                filterBtns.forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                btn.classList.add('active');

                const filterValue = btn.getAttribute('data-filter');

                galleryItems.forEach(item => {
                    if (filterValue === 'semua' || item.getAttribute('data-kategori') === filterValue) {
                        item.style.display = 'flex'; // Restore display (using flex because of layout)
                    } else {
                        item.style.display = 'none'; // Hide
                    }
                });
            });
        });
    });
</script>
<style>
.swal-image-viewer {
    max-height: 80vh;
    object-fit: contain;
    border-radius: 8px;
}
</style>
@endpush