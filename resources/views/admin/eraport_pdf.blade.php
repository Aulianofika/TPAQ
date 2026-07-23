<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>E-Rapor Santri - {{ $eraport->santri->nama ?? 'Unknown' }}</title>
    <style>
        /* Base Page Setup */
        @page {
            margin: 0;
        }
        body {
            font-family: 'Liberation Serif', 'Times New Roman', serif;
            color: #000000;
            line-height: 1.5;
            font-size: 14px;
            margin: 0;
            padding: 40px 50px;
            background-color: #FFFFFF;
        }

        /* Typography Utilities */
        .font-sans-bold {
            font-family: 'Epilogue', Arial, sans-serif;
            font-weight: 700;
        }
        .font-sans {
            font-family: 'Manrope', 'Plus Jakarta Sans', Arial, sans-serif;
        }
        
        /* Header Section */
        .header-table {
            width: 100%;
            border-bottom: 2px solid #003227;
            padding-bottom: 12px;
            margin-bottom: 24px;
        }
        .header-logo {
            width: 80px;
            height: 80px;
            background-color: #003227;
            border-radius: 50%;
            text-align: center;
            line-height: 80px;
            color: #FED65B;
            font-size: 12px;
            font-weight: bold;
        }
        .header-title {
            font-family: 'Epilogue', Arial, sans-serif;
            font-weight: 900;
            font-size: 24px;
            letter-spacing: 1.2px;
            color: #003227;
            margin: 0 0 4px 0;
            text-transform: uppercase;
        }
        .header-subtitle {
            font-family: 'Manrope', Arial, sans-serif;
            font-size: 14px;
            color: #404945;
            margin: 0;
        }
        .header-year {
            font-family: 'Manrope', Arial, sans-serif;
            font-weight: 700;
            font-size: 12px;
            color: #735C00;
            margin-top: 4px;
        }
        .raport-title {
            text-align: center;
            font-family: 'Epilogue', Arial, sans-serif;
            font-weight: 700;
            font-size: 20px;
            letter-spacing: 2px;
            color: #003227;
            margin: 16px 0 24px 0;
            text-transform: uppercase;
        }

        /* Identity Section */
        .identity-table {
            width: 100%;
            margin-bottom: 16px;
            font-size: 16px;
        }
        .identity-table td {
            padding: 4px 0;
        }

        /* Table Styles */
        .nilai-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
            font-size: 16px;
        }
        .nilai-table th {
            border: 1px solid #000000;
            padding: 6px 8px;
            font-weight: 700;
            text-align: center;
            background-color: #f9f9f9;
        }
        .nilai-table td {
            border: 1px solid #000000;
            padding: 6px 8px;
        }
        .col-no { width: 5%; text-align: center; }
        .col-mapel { width: 45%; }
        .col-angka { width: 20%; text-align: center; font-weight: bold; }
        .col-huruf { width: 30%; text-align: center; }

        .group-row {
            font-weight: 700;
            background-color: #fcfcfc;
        }
        .sub-row td.col-mapel {
            padding-left: 24px;
        }

        /* Layout Helpers */
        .layout-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        .layout-table td {
            vertical-align: top;
        }

        /* Small tables (Absen, Sikap, Rekap) */
        .small-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        .small-table th, .small-table td {
            border: 1px solid #000000;
            padding: 6px 8px;
        }

        /* Notes & Status Box */
        .catatan-box {
            border: 1px solid #000000;
            padding: 12px;
            min-height: 40px;
            margin-bottom: 16px;
        }
        .status-box {
            border: 2px solid #003227;
            padding: 12px;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
            color: #003227;
            margin-bottom: 16px;
            background-color: rgba(0, 50, 39, 0.05);
        }

        /* Signatures */
        .signature-table {
            width: 100%;
            margin-top: 32px;
            text-align: center;
        }
        .sig-space {
            height: 70px;
        }
        
        .section-heading {
            font-family: 'Epilogue', Arial, sans-serif;
            font-weight: 700;
            font-size: 14px;
            color: #003227;
            margin-bottom: 8px;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

    @php
        function convertToLetter($score) {
            if (!is_numeric($score)) return '-';
            if ($score >= 90) return 'A';
            if ($score >= 80) return 'B';
            if ($score >= 70) return 'C';
            if ($score >= 60) return 'D';
            return 'E';
        }
        
        $romanCawu = ['1' => 'I', '2' => 'II', '3' => 'III'];
        $cawuStr = isset($romanCawu[$eraport->caturwulan]) ? $romanCawu[$eraport->caturwulan] : 'I';
    @endphp

    <!-- 1. Header -->
    <table class="header-table">
        <tr>
            <td width="100px" style="vertical-align: top;">
                <img src="{{ public_path('images/logo.jpg') }}" alt="Logo" style="width: 75px; height: 75px; border-radius: 50%;">
            </td>
            <td style="vertical-align: top; padding-top: 8px;">
                <h1 class="header-title">TPA BAITUR RIDWAN</h1>
                <p class="header-subtitle">Laporan Hasil Belajar Santri (E-Rapor)</p>
                <div class="header-year">TAHUN PELAJARAN: {{ $eraport->tahun_pelajaran }}</div>
            </td>
        </tr>
    </table>

    <div class="raport-title">LAPORAN HASIL EVALUASI SANTRI</div>

    <!-- 2. Identity -->
    <table class="identity-table">
        <tr>
            <td>Nama Santri : <b>{{ $eraport->santri->nama ?? 'Unknown' }}</b></td>
            <td align="right">Periode : Catur Wulan {{ $cawuStr }}</td>
        </tr>
        <tr>
            <td>Kelompok : {{ $eraport->kelompok }}</td>
            <td align="right"></td>
        </tr>
    </table>

    <!-- 3. Nilai Mata Pelajaran Table -->
    <table class="nilai-table">
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-mapel">Mata Pelajaran</th>
                <th class="col-angka">Angka (0-100)</th>
                <th class="col-huruf">Huruf Mutu</th>
            </tr>
        </thead>
        <tbody>
            <!-- Al-Qur'an -->
            <tr class="group-row">
                <td class="col-no">1</td>
                <td colspan="3">Al-Qur'an</td>
            </tr>
            <tr class="sub-row">
                <td class="col-no"></td>
                <td class="col-mapel">a. Tajwid</td>
                <td class="col-angka">{{ rtrim(rtrim($eraport->nilai_tajwid, '0'), '.') }}</td>
                <td class="col-huruf">{{ convertToLetter($eraport->nilai_tajwid) }}</td>
            </tr>
            <tr class="sub-row">
                <td class="col-no"></td>
                <td class="col-mapel">b. Fashahah</td>
                <td class="col-angka">{{ rtrim(rtrim($eraport->nilai_fashahah, '0'), '.') }}</td>
                <td class="col-huruf">{{ convertToLetter($eraport->nilai_fashahah) }}</td>
            </tr>
            <tr class="sub-row">
                <td class="col-no"></td>
                <td class="col-mapel">c. Irama / Lagu</td>
                <td class="col-angka">{{ rtrim(rtrim($eraport->nilai_irama, '0'), '.') }}</td>
                <td class="col-huruf">{{ convertToLetter($eraport->nilai_irama) }}</td>
            </tr>
            <tr class="sub-row">
                <td class="col-no"></td>
                <td class="col-mapel">d. Adab Membaca Al-Qur'an</td>
                <td class="col-angka">{{ rtrim(rtrim($eraport->nilai_adab, '0'), '.') }}</td>
                <td class="col-huruf">{{ convertToLetter($eraport->nilai_adab) }}</td>
            </tr>

            <!-- Hafalan & Praktek Ibadah -->
            <tr class="group-row">
                <td class="col-no">2</td>
                <td colspan="3">Hafalan & Praktek Ibadah</td>
            </tr>
            <tr class="sub-row">
                <td class="col-no"></td>
                <td class="col-mapel">a. Praktek Ibadah</td>
                <td class="col-angka">{{ rtrim(rtrim($eraport->nilai_ibadah, '0'), '.') }}</td>
                <td class="col-huruf">{{ convertToLetter($eraport->nilai_ibadah) }}</td>
            </tr>
            <tr class="sub-row">
                <td class="col-no"></td>
                <td class="col-mapel">b. Hafalan Doa Harian</td>
                <td class="col-angka">{{ rtrim(rtrim($eraport->nilai_doa, '0'), '.') }}</td>
                <td class="col-huruf">{{ convertToLetter($eraport->nilai_doa) }}</td>
            </tr>
            <tr class="sub-row">
                <td class="col-no"></td>
                <td class="col-mapel">c. Hafalan Surat Pendek</td>
                <td class="col-angka">{{ rtrim(rtrim($eraport->nilai_surat, '0'), '.') }}</td>
                <td class="col-huruf">{{ convertToLetter($eraport->nilai_surat) }}</td>
            </tr>

            <!-- Sejarah & Akhlak -->
            <tr class="group-row">
                <td class="col-no">3</td>
                <td colspan="3">Sejarah & Akhlak</td>
            </tr>
            <tr class="sub-row">
                <td class="col-no"></td>
                <td class="col-mapel">a. Sejarah Kebudayaan Islam</td>
                <td class="col-angka">{{ rtrim(rtrim($eraport->nilai_sejarah, '0'), '.') }}</td>
                <td class="col-huruf">{{ convertToLetter($eraport->nilai_sejarah) }}</td>
            </tr>
            <tr class="sub-row">
                <td class="col-no"></td>
                <td class="col-mapel">b. Praktek Dakwah / Pidato</td>
                <td class="col-angka">{{ rtrim(rtrim($eraport->nilai_dakwah, '0'), '.') }}</td>
                <td class="col-huruf">{{ convertToLetter($eraport->nilai_dakwah) }}</td>
            </tr>
            <tr class="sub-row">
                <td class="col-no"></td>
                <td class="col-mapel">c. Akhlak & Khat</td>
                <td class="col-angka">{{ rtrim(rtrim($eraport->nilai_akhlak, '0'), '.') }}</td>
                <td class="col-huruf">{{ convertToLetter($eraport->nilai_akhlak) }}</td>
            </tr>

            <!-- Ekstrakurikuler -->
            <tr class="group-row">
                <td class="col-no">4</td>
                <td colspan="3">Ekstrakurikuler</td>
            </tr>
            <tr class="sub-row">
                <td class="col-no"></td>
                <td class="col-mapel">a. Didikan Subuh</td>
                <td class="col-angka">{{ $eraport->ekstra_subuh ? rtrim(rtrim($eraport->ekstra_subuh, '0'), '.') : '' }}</td>
                <td class="col-huruf">{{ convertToLetter($eraport->ekstra_subuh) }}</td>
            </tr>
            <tr class="sub-row">
                <td class="col-no"></td>
                <td class="col-mapel">b. Qasidah Rebana</td>
                <td class="col-angka">{{ $eraport->ekstra_rebana ? rtrim(rtrim($eraport->ekstra_rebana, '0'), '.') : '' }}</td>
                <td class="col-huruf">{{ convertToLetter($eraport->ekstra_rebana) }}</td>
            </tr>
            <tr class="sub-row">
                <td class="col-no"></td>
                <td class="col-mapel">c. Olahraga</td>
                <td class="col-angka">{{ $eraport->ekstra_olahraga ? rtrim(rtrim($eraport->ekstra_olahraga, '0'), '.') : '' }}</td>
                <td class="col-huruf">{{ convertToLetter($eraport->ekstra_olahraga) }}</td>
            </tr>
        </tbody>
    </table>

    <!-- 4. Footer Info Layout (Split into two columns) -->
    <table class="layout-table">
        <tr>
            <td width="48%" style="padding-right: 16px;">
                <!-- Kepribadian -->
                <div class="section-heading">KEPRIBADIAN / SIKAP</div>
                <table class="small-table">
                    <tr>
                        <td width="70%">Kedisiplinan</td>
                        <td width="30%" style="text-align: center; font-weight: bold;">{{ $eraport->sikap_disiplin ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td>Kebersihan</td>
                        <td style="text-align: center; font-weight: bold;">{{ $eraport->sikap_kebersihan ?? '-' }}</td>
                    </tr>
                </table>

                <!-- Rekap Nilai -->
                <div class="section-heading">REKAP NILAI</div>
                <table class="small-table" style="background-color: #fffaeb;">
                    <tr>
                        <td width="70%">Jumlah Nilai</td>
                        <td width="30%" style="text-align: center; font-weight: bold; color: #735C00;">{{ $eraport->jumlah_nilai }}</td>
                    </tr>
                    <tr>
                        <td>Nilai Rata-rata</td>
                        <td style="text-align: center; font-weight: bold; color: #735C00;">{{ $eraport->rata_rata }}</td>
                    </tr>
                </table>
            </td>
            
            <td width="48%" style="padding-left: 16px;">
                <!-- Ketidakhadiran -->
                <div class="section-heading">KETIDAKHADIRAN</div>
                <table class="small-table">
                    <tr>
                        <td width="70%">Sakit</td>
                        <td width="30%" style="text-align: center;">{{ $eraport->absen_sakit }} Hari</td>
                    </tr>
                    <tr>
                        <td>Izin</td>
                        <td style="text-align: center;">{{ $eraport->absen_izin }} Hari</td>
                    </tr>
                    <tr>
                        <td>Alpa</td>
                        <td style="text-align: center;">{{ $eraport->absen_alpa }} Hari</td>
                    </tr>
                </table>

                <!-- Keterangan Huruf Mutu -->
                <div style="font-size: 11px; padding: 10px; border: 1px dashed #aaa; background-color: #f9f9f9;">
                    <b>Keterangan Huruf Mutu:</b><br>
                    A : 90 - 100 (Sangat Baik)<br>
                    B : 80 - 89 (Baik)<br>
                    C : 70 - 79 (Cukup)<br>
                    D : 60 - 69 (Kurang)<br>
                    E : < 60 (Sangat Kurang)
                </div>
            </td>
        </tr>
    </table>

    <!-- 5. Catatan & Status -->
    <div class="section-heading">CATATAN GURU / WALI KELAS</div>
    <div class="catatan-box">
        {{ $eraport->catatan_guru ?? 'Tidak ada catatan khusus pada caturwulan ini.' }}
    </div>

    @if($eraport->caturwulan == 3 && $eraport->status_kenaikan)
    <div class="section-heading">STATUS KENAIKAN / KELULUSAN</div>
    <div class="status-box">
        {{ $eraport->status_kenaikan }}
    </div>
    @endif

    <!-- 6. Signatures -->
    <table class="signature-table" style="margin-top: 20px;">
        <tr>
            <td width="33%"></td>
            <td width="34%"></td>
            <td width="33%" style="padding-bottom: 15px;">
                Batipuh, {{ \Carbon\Carbon::parse($eraport->tanggal_pelaporan ?? now())->translatedFormat('d F Y') }}
            </td>
        </tr>
        <tr>
            <td width="33%" style="vertical-align: top;">
                <p style="margin: 0;">Mengetahui,<br>Orang Tua / Wali</p>
                <div class="sig-space"></div>
                <p style="font-weight: bold; margin: 0;">( .................................... )</p>
            </td>
            <td width="34%" style="vertical-align: top;">
                <p style="margin: 0;">Kepala TPA<br>Baitur Ridwan</p>
                <div class="sig-space"></div>
                <p style="font-weight: bold; text-decoration: underline; margin: 0;">{{ $eraport->kepala_tpa ?? 'H. Ahmad Syukron, S.Pd.I' }}</p>
            </td>
            <td width="33%" style="vertical-align: top;">
                <p style="margin: 0;">Wali Kelas / Ustaz(ah)<br>&nbsp;</p>
                <div class="sig-space"></div>
                <p style="font-weight: bold; text-decoration: underline; margin: 0;">{{ $nama_guru }}</p>
            </td>
        </tr>
    </table>

</body>
</html>
