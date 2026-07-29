<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Laporan Rekomendasi Ekstrakurikuler - MTsN 2 Pesisir Selatan' }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 1.5cm 1.5cm 2cm 1.5cm;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: "Times New Roman", Times, serif;
        }

        body {
            background-color: #f3f4f6;
            color: #111827;
            font-size: 12pt;
            line-height: 1.4;
            padding: 20px;
        }

        .paper {
            background: #ffffff;
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 20mm 20mm 20mm 20mm;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            position: relative;
        }

        /* Kop Surat Official */
        .kop-surat {
            display: flex;
            align-items: center;
            border-bottom: 3px double #000;
            padding-bottom: 8px;
            margin-bottom: 20px;
            position: relative;
        }

        .kop-logo {
            width: 85px;
            height: auto;
            position: absolute;
            left: 5px;
            top: 50%;
            transform: translateY(-50%);
        }

        .kop-header {
            width: 100%;
            text-align: center;
            padding-left: 80px;
            padding-right: 15px;
        }

        .kop-header h4 {
            font-size: 12pt;
            font-weight: normal;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .kop-header h3 {
            font-size: 13pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .kop-header h2 {
            font-size: 14pt;
            font-weight: bold;
            text-transform: uppercase;
            margin: 2px 0;
            color: #000;
        }

        .kop-header p {
            font-size: 9.5pt;
            font-style: normal;
            color: #222;
        }

        /* Title Laporan */
        .laporan-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .laporan-title h3 {
            font-size: 13pt;
            text-transform: uppercase;
            text-decoration: underline;
            font-weight: bold;
            margin-bottom: 4px;
        }

        .laporan-title p {
            font-size: 11pt;
            font-weight: normal;
        }

        /* Metadata info */
        .meta-table {
            width: 100%;
            margin-bottom: 15px;
            font-size: 11pt;
            border-collapse: collapse;
        }

        .meta-table td {
            padding: 4px 6px;
            vertical-align: top;
        }

        /* Table Data */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 25px;
            font-size: 11pt;
        }

        .data-table th, 
        .data-table td {
            border: 1px solid #000;
            padding: 7px 8px;
            text-align: left;
        }

        .data-table th {
            background-color: #e5e7eb;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10pt;
        }

        .text-center { text-align: center !important; }
        .text-right { text-align: right !important; }
        .font-bold { font-weight: bold; }

        /* Detail Student Card */
        .detail-box {
            border: 1px solid #000;
            padding: 15px;
            margin-bottom: 20px;
            background-color: #fafafa;
        }

        .detail-row {
            display: flex;
            margin-bottom: 8px;
            font-size: 11pt;
        }

        .detail-label {
            width: 180px;
            font-weight: bold;
        }

        .detail-colon {
            width: 15px;
        }

        .detail-value {
            flex: 1;
        }

        /* Signature Section */
        .ttd-container {
            margin-top: 40px;
            width: 100%;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }

        .ttd-box {
            width: 45%;
            text-align: center;
            font-size: 11pt;
        }

        .ttd-space {
            height: 75px;
        }

        .ttd-name {
            font-weight: bold;
            text-decoration: underline;
        }

        /* Actions Bar (No Print) */
        .actions-bar {
            width: 210mm;
            margin: 0 auto 15px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 9px 18px;
            background-color: #2563eb;
            color: #ffffff;
            text-decoration: none;
            border: none;
            border-radius: 6px;
            font-family: Arial, sans-serif;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: background-color 0.2s;
        }

        .btn:hover {
            background-color: #1d4ed8;
        }

        .btn-secondary {
            background-color: #4b5563;
        }

        .btn-secondary:hover {
            background-color: #374151;
        }

        @media print {
            body {
                background-color: #ffffff;
                padding: 0;
            }

            .paper {
                box-shadow: none;
                width: 100%;
                padding: 0;
                margin: 0;
            }

            .actions-bar {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="actions-bar">
        <a href="{{ route('knn.index') }}" class="btn btn-secondary">
            &larr; Kembali ke Dashboard
        </a>
        <button onclick="window.print()" class="btn">
            🖨️ Cetak / Simpan PDF
        </button>
    </div>

    <div class="paper">
        <!-- KOP SURAT OFFICIAL -->
        <div class="kop-surat">
            <img src="{{ asset('assets/MTSN 2 Pesisir Selatan.png') }}" alt="Logo MTsN 2 Pesisir Selatan" class="kop-logo">
            <div class="kop-header">
                <h4>KEMENTERIAN AGAMA REPUBLIK INDONESIA</h4>
                <h3>KANTOR KEMENTERIAN AGAMA KABUPATEN PESISIR SELATAN</h3>
                <h2>MADRASAH TSANAWIYAH NEGERI 2 PESISIR SELATAN</h2>
                <p>Jl. Raya Pasar Baru - Bayang, Kab. Pesisir Selatan, Sumatera Barat</p>
                <p>Email: mtsn2pesisirselatan@kemenag.go.id | Akreditasi A | Kode Pos: 25652</p>
            </div>
        </div>

        @if(isset($isDetail) && $isDetail && isset($history))
            <!-- HASIL REKOMENDASI INDIVIDUAL SISWA -->
            <div class="laporan-title">
                <h3>LEMBAR HASIL REKOMENDASI EKSTRAKURIKULER SISWA</h3>
                <p>Metode K-Nearest Neighbor (KNN)</p>
            </div>

            <div class="detail-box">
                <div class="detail-row">
                    <div class="detail-label">Nama Siswa</div>
                    <div class="detail-colon">:</div>
                    <div class="detail-value font-bold">{{ $history->nama_siswa ?: 'Siswa (Tanpa Nama)' }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Waktu Pengujian</div>
                    <div class="detail-colon">:</div>
                    <div class="detail-value">{{ $history->created_at->format('d F Y - H:i') }} WIB</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Parameter K</div>
                    <div class="detail-colon">:</div>
                    <div class="detail-value">K = {{ $history->k_value }}</div>
                </div>
                <div class="detail-row">
                    <div class="detail-label">Hasil Rekomendasi</div>
                    <div class="detail-colon">:</div>
                    <div class="detail-value font-bold" style="font-size: 13pt; color: #166534;">
                        {{ $history->hasil_rekomendasi }}
                    </div>
                </div>
            </div>

            <h4 style="margin-bottom: 8px; font-size: 11pt;">Nilai Mata Pelajaran Siswa:</h4>
            <table class="data-table" style="margin-bottom: 20px;">
                <thead>
                    <tr>
                        <th class="text-center">Matematika</th>
                        <th class="text-center">IPA</th>
                        <th class="text-center">IPS</th>
                        <th class="text-center">B. Indonesia</th>
                        <th class="text-center">PJOK</th>
                        <th class="text-center">Seni Budaya</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">{{ $history->nilai_matematika }}</td>
                        <td class="text-center">{{ $history->nilai_ipa }}</td>
                        <td class="text-center">{{ $history->nilai_ips }}</td>
                        <td class="text-center">{{ $history->nilai_bahasa_indonesia }}</td>
                        <td class="text-center">{{ $history->nilai_pjok }}</td>
                        <td class="text-center">{{ $history->nilai_seni_budaya }}</td>
                    </tr>
                </tbody>
            </table>

            @if(!empty($history->tetangga_terdekat) && is_array($history->tetangga_terdekat))
                <h4 style="margin-bottom: 8px; font-size: 11pt;">Detail K-Tetangga Terdekat (Perhitungan Jarak Euclidean):</h4>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 30px;">No</th>
                            <th>Nama Siswa Latih</th>
                            <th class="text-center">Rank</th>
                            @if(auth()->user()?->role === 'admin')
                                <th class="text-center">Ekstrakurikuler</th>
                            @endif
                            <th class="text-center">Jarak (Euclidean)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history->tetangga_terdekat as $idx => $neighbor)
                            <tr>
                                <td class="text-center">{{ $idx + 1 }}</td>
                                <td>{{ $neighbor['nama_siswa'] ?? '-' }}</td>
                                <td class="text-center">{{ $neighbor['rank'] ?? '-' }}</td>
                                @if(auth()->user()?->role === 'admin')
                                    <td class="text-center font-bold">{{ $neighbor['ekstrakurikuler'] ?? '-' }}</td>
                                @endif
                                <td class="text-center">{{ number_format($neighbor['jarak'] ?? 0, 4) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        @else
            <!-- REKAPITULASI LAPORAN REKOMENDASI (SEMUA SISWA) -->
            <div class="laporan-title">
                <h3>LAPORAN REKAPITULASI REKOMENDASI EKSTRAKURIKULER SISWA</h3>
                <p>Sistem Pakar / Penentuan Ekstrakurikuler Berbasis K-Nearest Neighbor (KNN)</p>
            </div>

            <table class="meta-table">
                <tr>
                    <td style="width: 130px; font-weight: bold;">Tanggal Cetak</td>
                    <td style="width: 10px;">:</td>
                    <td>{{ date('d F Y') }}</td>
                    <td style="width: 130px; font-weight: bold; text-align: right;">Total Data</td>
                    <td style="width: 10px;">:</td>
                    <td style="width: 60px;">{{ count($histories) }} Data</td>
                </tr>
            </table>

            <table class="data-table">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 35px;">No</th>
                        <th class="text-center" style="width: 110px;">Tanggal / Waktu</th>
                        <th>Nama Siswa</th>
                        <th class="text-center">Nilai Mapel (MTK, IPA, IPS, BINDO, PJOK, SENI)</th>
                        <th class="text-center" style="width: 45px;">K</th>
                        <th class="text-center" style="width: 110px;">Hasil Rekomendasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($histories as $index => $row)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-center">{{ $row->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $row->nama_siswa ?: 'Siswa (Tanpa Nama)' }}</td>
                            <td class="text-center" style="font-size: 10pt;">
                                {{ $row->nilai_matematika }}, {{ $row->nilai_ipa }}, {{ $row->nilai_ips }}, {{ $row->nilai_bahasa_indonesia }}, {{ $row->nilai_pjok }}, {{ $row->nilai_seni_budaya }}
                            </td>
                            <td class="text-center">{{ $row->k_value }}</td>
                            <td class="text-center font-bold" style="color: #15803d;">
                                {{ $row->hasil_rekomendasi }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data riwayat rekomendasi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endif

        <!-- TANDA TANGAN / PENGESAHAN SURAT -->
        <div class="ttd-container">
            <div class="ttd-box">
                <p>Mengetahui,</p>
                <p><strong>Kepala MTsN 2 Pesisir Selatan</strong></p>
                <div class="ttd-space"></div>
                <p class="ttd-name">NIP. ........................................</p>
            </div>
            <div class="ttd-box">
                <p>Pesisir Selatan, {{ date('d F Y') }}</p>
                <p><strong>Pembina / Admin Ekstrakurikuler</strong></p>
                <div class="ttd-space"></div>
                <p class="ttd-name">NIP. ........................................</p>
            </div>
        </div>
    </div>

</body>
</html>
