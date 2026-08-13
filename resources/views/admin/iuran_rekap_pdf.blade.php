<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Iuran Santri {{ $tahun }}</title>
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }
        body {
            font-family: 'Liberation Serif', 'Times New Roman', serif;
            color: #000000;
            line-height: 1.3;
            font-size: 10px;
            margin: 0;
            padding: 28px 32px;
            background-color: #FFFFFF;
        }

        .header-table {
            width: 100%;
            border-bottom: 2px solid #003227;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .header-title {
            font-family: Arial, sans-serif;
            font-weight: 900;
            font-size: 16px;
            letter-spacing: 1px;
            color: #003227;
            margin: 0 0 2px 0;
            text-transform: uppercase;
        }
        .header-subtitle {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #404945;
            margin: 0;
        }

        .report-title {
            text-align: center;
            font-family: Arial, sans-serif;
            font-weight: 700;
            font-size: 13px;
            letter-spacing: 1px;
            color: #003227;
            margin: 8px 0 12px 0;
            text-transform: uppercase;
        }

        .info-table {
            width: 100%;
            margin-bottom: 10px;
            font-size: 10px;
        }
        .info-table td {
            padding: 2px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 9px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000000;
            padding: 4px 5px;
            vertical-align: middle;
        }
        .data-table th {
            font-weight: 700;
            background-color: #f0f0f0;
            text-align: center;
        }
        .data-table td.lunas {
            text-align: center;
            background-color: #D1FAE5;
            color: #065F46;
            font-weight: 700;
        }
        .data-table td.belum {
            text-align: center;
            color: #9CA3AF;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: 700; }

        .signature-table {
            width: 100%;
            margin-top: 28px;
            text-align: center;
            font-size: 10px;
        }
        .sig-space { height: 48px; }
    </style>
</head>
<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td width="55px" style="vertical-align: middle;">
                <img src="{{ public_path('images/logo.jpg') }}" alt="Logo" style="width: 50px; height: 50px; border-radius: 50%;">
            </td>
            <td style="vertical-align: middle; padding-left: 10px;">
                <h1 class="header-title">TPA BAITUR RIDWAN</h1>
                <p class="header-subtitle">Laporan Rekapitulasi Iuran / SPP Santri</p>
            </td>
        </tr>
    </table>

    <div class="report-title">REKAP IURAN (SPP) SANTRI TAHUN {{ $tahun }}</div>

    <!-- Info Section -->
    <table class="info-table">
        <tr>
            <td width="10%"><strong>Kelas</strong></td>
            <td width="2%">:</td>
            <td width="45%">{{ $kelas ? $kelas->nama_kelas : 'Semua Kelas' }}</td>
            <td width="43%" style="text-align: right;">
                <strong>Tahun Ajaran</strong>&nbsp;:&nbsp;{{ $tahun }} / {{ (int)$tahun + 1 }}
                &nbsp;&nbsp;&nbsp;
                <strong>Dicetak</strong>&nbsp;:&nbsp;{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </td>
        </tr>
    </table>

    <!-- Matrix Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="18%" style="text-align: left;">Nama Santri</th>
                <th width="5%">Kelas</th>
                @foreach($all_months as $m)
                    <th width="4%" title="{{ $m }}">{{ substr($m, 0, 3) }}</th>
                @endforeach
                <th width="5%">Lunas</th>
                <th width="8%">Total Bayar</th>
            </tr>
        </thead>
        <tbody>
            @if(count($santris) > 0)
                @foreach($santris as $index => $santri)
                    @php
                        $isFullLunas = $santri->lunas_count >= 12;
                    @endphp
                    <tr style="{{ $isFullLunas ? '' : '' }}">
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td style="font-weight: 600;">{{ $santri->nama }}</td>
                        <td class="text-center">{{ $santri->kelas->nama_kelas ?? '-' }}</td>
                        @foreach($all_months as $m)
                            @if($santri->monthly_map[$m] === 'LUNAS')
                                <td class="lunas">✓</td>
                            @else
                                <td class="belum">-</td>
                            @endif
                        @endforeach
                        <td class="text-center text-bold" style="color: {{ $isFullLunas ? '#065F46' : '#B45309' }};">
                            {{ $santri->lunas_count }}/12
                        </td>
                        <td class="text-right text-bold">
                            Rp {{ number_format($santri->total_paid, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
                <!-- Total Row -->
                <tr style="background-color: #F6F3EC; font-weight: 700;">
                    <td colspan="3" class="text-center">TOTAL KESELURUHAN</td>
                    @foreach($all_months as $m)
                        @php
                            $lunasCount = $santris->filter(fn($s) => $s->monthly_map[$m] === 'LUNAS')->count();
                        @endphp
                        <td class="text-center">{{ $lunasCount }}</td>
                    @endforeach
                    <td class="text-center">{{ $santris->sum('lunas_count') }}/{{ count($santris) * 12 }}</td>
                    <td class="text-right">Rp {{ number_format($santris->sum('total_paid'), 0, ',', '.') }}</td>
                </tr>
            @else
                <tr>
                    <td colspan="17" class="text-center">Tidak ada data santri untuk kelas/tahun ini.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Legend -->
    <p style="font-size: 9px; color: #4B5563; margin: 0 0 6px 0;">
        Keterangan: <strong>✓ (Lunas)</strong> = pembayaran iuran bulan tersebut sudah dikonfirmasi diterima Bendahara. &nbsp; 
        <strong>- (Belum)</strong> = belum ada catatan pembayaran.
    </p>

    <!-- Signature -->
    <table class="signature-table">
        <tr>
            <td width="60%"></td>
            <td width="40%">
                <p style="margin: 0 0 8px 0;">Batipuh, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p style="margin: 0;">Bendahara / Pengurus TPA</p>
                <div class="sig-space"></div>
                <p style="margin: 0; font-weight: bold; text-decoration: underline;">{{ $nama_pengurus }}</p>
            </td>
        </tr>
    </table>

</body>
</html>
