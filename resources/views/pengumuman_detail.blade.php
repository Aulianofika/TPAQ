@extends('layouts.layout')

@section('title', $pengumuman->judul . ' — TPA Al-Quran')
@section('meta_description', Str::limit(strip_tags($pengumuman->isi), 150))

@push('styles')
<style>
    .pengumuman-detail-page {
        background: #FCF9F2;
        padding-bottom: 96px;
        overflow-x: hidden;
    }

    .detail-hero {
        position: relative;
        width: 100%;
        padding: 128px 24px 64px;
        display: flex;
        flex-direction: column;
        align-items: center;
        background: #004B3C;
        overflow: hidden;
        min-height: 250px;
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

    .detail-container {
        max-width: 800px;
        margin: -40px auto 0;
        padding: 0 24px;
        position: relative;
        z-index: 10;
    }

    .detail-card {
        background: #FFFFFF;
        border-radius: 24px;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .detail-image {
        width: 100%;
        max-height: 400px;
        object-fit: cover;
        display: block;
    }
    
    .detail-image-placeholder {
        width: 100%;
        height: 200px;
        background: #EBE8E1;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .detail-content {
        padding: 48px;
    }

    .detail-meta {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        flex-wrap: wrap;
    }

    .detail-badge {
        padding: 6px 14px;
        border-radius: 9999px;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 13px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .detail-date {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 500;
        font-size: 15px;
        color: #6B7280;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .detail-title {
        font-family: 'Epilogue', sans-serif;
        font-weight: 800;
        font-size: clamp(28px, 4vw, 40px);
        line-height: 1.2;
        color: #003227;
        margin-bottom: 32px;
    }

    .detail-body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-weight: 400;
        font-size: 18px;
        line-height: 1.8;
        color: #374151;
    }

    .detail-body p {
        margin-bottom: 20px;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-family: 'Manrope', sans-serif;
        font-weight: 700;
        font-size: 16px;
        color: #004B3C;
        text-decoration: none;
        margin-top: 48px;
        padding: 12px 24px;
        background: rgba(124, 186, 166, 0.1);
        border-radius: 12px;
        transition: all 0.2s ease;
    }

    .back-link:hover {
        background: rgba(124, 186, 166, 0.2);
        color: #00735C;
    }

    @media (max-width: 768px) {
        .detail-content {
            padding: 32px 24px;
        }
    }
</style>
@endpush

@section('content')
<div class="pengumuman-detail-page">
    
    <section class="detail-hero">
        <div class="hero-bg-pattern"></div>
    </section>

    <main class="detail-container">
        <div class="detail-card">
            @if($pengumuman->gambar)
                <img src="{{ Storage::url($pengumuman->gambar) }}" alt="{{ $pengumuman->judul }}" class="detail-image" onclick="viewImage('{{ Storage::url($pengumuman->gambar) }}', '{{ addslashes($pengumuman->judul) }}')" style="cursor: pointer; transition: transform 0.2s;" onmouseover="this.style.transform='scale(1.02)'" onmouseout="this.style.transform='scale(1)'">
            @else
                <div class="detail-image-placeholder">
                    <span class="material-symbols-outlined" style="font-size: 64px; color: #BFc9c4;">campaign</span>
                </div>
            @endif

            <div class="detail-content">
                <div class="detail-meta">
                    @php
                        $badgeStyle = '';
                        if($pengumuman->kategori == 'penting') $badgeStyle = 'style="background: #FED65B; color: #745C00;"';
                        elseif($pengumuman->kategori == 'kegiatan') $badgeStyle = 'style="background: #B0EFDA; color: #003227;"';
                        else $badgeStyle = 'style="background: #E5E7EB; color: #404945;"';
                    @endphp
                    <span class="detail-badge" {!! $badgeStyle !!}>{{ ucfirst($pengumuman->kategori) }}</span>
                    <span class="detail-date">
                        <span class="material-symbols-outlined" style="font-size: 20px;">calendar_month</span>
                        {{ \Carbon\Carbon::parse($pengumuman->tanggal)->format('d M Y') }}
                    </span>
                </div>
                
                <h1 class="detail-title">{{ $pengumuman->judul }}</h1>
                
                <div class="detail-body">
                    {!! nl2br(e($pengumuman->isi)) !!}
                </div>

                <a href="{{ route('pengumuman.index') }}" class="back-link">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Kembali ke Pengumuman
                </a>
            </div>
        </div>
    </main>

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
</script>
<style>
.swal-image-viewer {
    max-height: 80vh;
    object-fit: contain;
    border-radius: 8px;
}
</style>
@endpush
