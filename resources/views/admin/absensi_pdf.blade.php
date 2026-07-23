<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rekap Absensi Bulanan</title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Liberation Serif', 'Times New Roman', serif;
            color: #000000;
            line-height: 1.3;
            font-size: 14px;
            margin: 0;
            padding: 40px 50px;
            background-color: #FFFFFF;
        }

        .header-table {
            width: 100%;
            border-bottom: 2px solid #003227;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .header-logo {
            width: 60px;
            height: 60px;
            background-color: #003227;
            border-radius: 50%;
            text-align: center;
            line-height: 60px;
            color: #FED65B;
            font-size: 10px;
            font-weight: bold;
        }
        .header-title {
            font-family: 'Epilogue', Arial, sans-serif;
            font-weight: 900;
            font-size: 20px;
            letter-spacing: 1px;
            color: #003227;
            margin: 0 0 2px 0;
            text-transform: uppercase;
        }
        .header-subtitle {
            font-family: 'Manrope', Arial, sans-serif;
            font-size: 12px;
            color: #404945;
            margin: 0;
        }

        .report-title {
            text-align: center;
            font-family: 'Epilogue', Arial, sans-serif;
            font-weight: 700;
            font-size: 18px;
            letter-spacing: 1px;
            color: #003227;
            margin: 10px 0 20px 0;
            text-transform: uppercase;
        }

        .info-table {
            width: 100%;
            margin-bottom: 16px;
            font-size: 14px;
        }
        .info-table td {
            padding: 4px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000000;
            padding: 6px 8px;
        }
        .data-table th {
            font-weight: 700;
            background-color: #fcfcfc;
            text-align: center;
        }
        .text-center { text-align: center; }
        
        .signature-table {
            width: 100%;
            margin-top: 40px;
            text-align: center;
            font-size: 14px;
        }
        .sig-space {
            height: 60px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <table class="header-table">
        <tr>
            <td width="70px" style="vertical-align: top;">
                <img src="{{ public_path('images/logo.jpg') }}" alt="Logo" style="width: 55px; height: 55px; border-radius: 50%;">
            </td>
            <td style="vertical-align: top; padding-top: 4px;">
                <h1 class="header-title">TPA BAITUR RIDWAN</h1>
                <p class="header-subtitle">Laporan Rekapitulasi Absensi Santri</p>
            </td>
        </tr>
    </table>

    <div class="report-title">REKAP ABSENSI BULANAN</div>

    <!-- Info Section -->
    <table class="info-table">
        <tr>
            <td width="15%"><strong>Kelas / Kelompok</strong></td>
            <td width="2%">:</td>
            <td width="33%">{{ $kelas->nama_kelas ?? 'Semua Kelas' }}</td>
            
            <td width="15%"><strong>Bulan</strong></td>
            <td width="2%">:</td>
            @php
                $monthNames = [
                    '01' => 'Januari', '02' => 'Februari', '03' => 'Maret', 
                    '04' => 'April', '05' => 'Mei', '06' => 'Juni', 
                    '07' => 'Juli', '08' => 'Agustus', '09' => 'September', 
                    '10' => 'Oktober', '11' => 'November', '12' => 'Desember'
                ];
            @endphp
            <td width="33%">{{ $monthNames[(string)$bulan] ?? $bulan }} {{ $tahun }}</td>
        </tr>
    </table>

    <!-- Data Table -->
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="55%" style="text-align: left;">Nama Santri</th>
                <th width="10%">Hadir</th>
                <th width="10%">Izin</th>
                <th width="10%">Sakit</th>
                <th width="10%">Alfa</th>
            </tr>
        </thead>
        <tbody>
            @if(count($students) > 0)
                @foreach($students as $index => $student)
                    @php
                        $hadir = $student->absensis->where('status', 'hadir')->count();
                        $izin = $student->absensis->where('status', 'izin')->count();
                        $sakit = $student->absensis->where('status', 'sakit')->count();
                        $alfa = $student->absensis->where('status', 'alfa')->count();
                    @endphp
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $student->nama }}</td>
                        <td class="text-center">{{ $hadir }}</td>
                        <td class="text-center">{{ $izin }}</td>
                        <td class="text-center">{{ $sakit }}</td>
                        <td class="text-center">{{ $alfa }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data santri untuk kelas ini.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <!-- Signature -->
    <table class="signature-table">
        <tr>
            <td width="60%"></td>
            <td width="40%">
                <p style="margin: 0 0 10px 0;">Batipuh, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                <p style="margin: 0;">Pengurus / Wali Kelas</p>
                <div class="sig-space"></div>
                <p style="margin: 0; font-weight: bold; text-decoration: underline;">{{ $nama_guru }}</p>
            </td>
        </tr>
    </table>

</body>
</html>
