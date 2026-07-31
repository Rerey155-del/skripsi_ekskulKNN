<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Rekomendasi Ekskul (KNN)</title>
    <link rel="stylesheet" href="{{ asset('css/knn_style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    @php
        $prediction = session('prediction_id') ? $histories->firstWhere('id', session('prediction_id')) : null;
    @endphp

    <aside class="sidebar">
        <div class="logo" style="display: flex; align-items: center; gap: 0.75rem;">
            <img src="{{ asset('assets/MTSN 2 Pesisir Selatan.png') }}" alt="Logo MTsN 2 Pesisir Selatan" style="height: 38px; width: auto; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
            <span style="font-size: 1.1rem; line-height: 1.2;">MTsN 2 Pesisir Selatan</span>
        </div>
        <ul class="nav-links">
            <li class="nav-item active" data-target="dashboard"><i class="fa-solid fa-chart-line"></i> Dashboard</li>
            <li class="nav-item" data-target="data-training"><i class="fa-solid fa-database"></i> Data Training</li>
            <li class="nav-item" data-target="prediksi"><i class="fa-solid fa-users"></i> Data Uji</li>
            <li class="nav-item" data-target="riwayat"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat</li>
        </ul>
    </aside>

    <main class="main-content">
        <header>
            <div style="display: flex; align-items: center; gap: 1rem;">
                <img src="{{ asset('assets/MTSN 2 Pesisir Selatan.png') }}" alt="Logo MTsN 2 Pesisir Selatan" style="height: 48px; width: auto; object-fit: contain; filter: drop-shadow(0 2px 4px rgba(0,0,0,0.2));">
                <div>
                    <h1 id="pageTitle">Dashboard Admin</h1>
                    <p style="color: var(--text-muted); margin-top: 0.25rem;">MTsN 2 Pesisir Selatan - Sistem Rekomendasi Ekstrakurikuler dengan KNN</p>
                </div>
            </div>
            <div class="user-profile">
                <span style="color: var(--text-muted); text-align:right;">
                    {{ auth()->user()->name }}<br>
                    <small>{{ ucfirst(auth()->user()->role) }}</small>
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="modal-close" style="width:auto; padding:0 0.85rem;">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </button>
                </form>
                <div class="avatar"></div>
            </div>
        </header>

        @if (session('success'))
            <div class="alert success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div id="view-dashboard" class="view-section active dashboard-grid" style="grid-template-columns: 1fr;">
            <div class="glass-card" style="text-align: center; padding: 3.5rem 2rem;">
                <img src="{{ asset('assets/MTSN 2 Pesisir Selatan.png') }}" alt="Logo MTsN 2 Pesisir Selatan" style="max-height: 110px; width: auto; object-fit: contain; margin-bottom: 1.5rem; filter: drop-shadow(0 4px 10px rgba(0,0,0,0.3));">
                <h2 style="font-size: 1.8rem; margin-bottom: 0.5rem;">MTsN 2 Pesisir Selatan</h2>
                <p style="color: var(--accent); font-weight: 600; font-size: 1.1rem; margin-bottom: 1rem;">Sistem Rekomendasi Ekstrakurikuler (K-Nearest Neighbor)</p>
                <p style="color: var(--text-muted); max-width: 720px; margin: 0 auto; line-height: 1.6;">
                    Selamat datang di Panel Sistem Rekomendasi Ekstrakurikuler MTsN 2 Pesisir Selatan. Sistem ini menggunakan algoritma K-Nearest Neighbor untuk menentukan ekstrakurikuler yang sesuai berdasarkan nilai akademik siswa.
                </p>

                <div class="stats-row">
                    <div class="stat-box">
                        <h3 id="dashTotalData">{{ $totalTraining }}</h3>
                        <p>Total Data Latih MySQL</p>
                    </div>
                    <div class="stat-box">
                        <h3 id="dashKValue">{{ $defaultK }}</h3>
                        <p>Parameter K Aktif</p>
                    </div>
                    <div class="stat-box">
                        <h3>{{ $totalHistories }}</h3>
                        <p>Riwayat Prediksi</p>
                    </div>
                </div>
            </div>
        </div>

        <div id="view-data-training" class="view-section dashboard-grid" style="grid-template-columns: 1fr;">
            <div class="glass-card" style="max-width: 1000px; margin: 0 auto; width: 100%;">
                <h2 class="card-title"><i class="fa-solid fa-file-import"></i> Import Data Training ke MySQL</h2>

                <form method="POST" action="{{ route('knn.training.import') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="import-panel">
                        <label class="upload-zone" for="trainingFile">
                            <div class="upload-icon pulse-icon"><i class="fa-solid fa-cloud-arrow-up"></i></div>
                            <h3>Pilih File Data Training</h3>
                            <p>Format .xlsx atau .csv</p>
                            <span id="selectedFileName">Belum ada file dipilih</span>
                        </label>
                        <input type="file" id="trainingFile" name="training_file" accept=".xlsx,.csv" required>
                        <div class="template-columns">
                            Nama, MTK, IPA, IPS, BINDO/Bahasa Indonesia, PJOK, SBP/Seni Budaya, RANK, Ekskul
                        </div>
                    </div>
                    <button type="submit" class="btn-primary"><i class="fa-solid fa-file-import"></i> Import dan Simpan Data Training</button>
                </form>

                <div class="table-container">
                    <table class="neighbors-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>MTK</th>
                                <th>IPA</th>
                                <th>IPS</th>
                                <th>B. Indonesia</th>
                                <th>PJOK</th>
                                <th>Seni Budaya</th>
                                <th>Rank</th>
                                <th>Ekstrakurikuler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($trainingSamples as $sample)
                                <tr>
                                    <td>{{ $sample->nama_siswa }}</td>
                                    <td>{{ $sample->nilai_matematika }}</td>
                                    <td>{{ $sample->nilai_ipa }}</td>
                                    <td>{{ $sample->nilai_ips }}</td>
                                    <td>{{ $sample->nilai_bahasa_indonesia }}</td>
                                    <td>{{ $sample->nilai_pjok }}</td>
                                    <td>{{ $sample->nilai_seni_budaya }}</td>
                                    <td>{{ $sample->rank }}</td>
                                    <td>{{ $sample->ekstrakurikuler }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="9">Belum ada data training.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="view-prediksi" class="view-section dashboard-grid" style="grid-template-columns: 1fr;">
            <div class="glass-card" style="max-width: 900px; margin: 0 auto; width: 100%;">
                <h2 class="card-title"><i class="fa-solid fa-user-plus"></i> Data Uji Siswa</h2>

                <form method="POST" action="{{ route('knn.predict') }}">
                    @csrf
                    <div class="input-grid three">
                        <div class="input-field"><label>Nama Siswa</label><input name="nama_siswa" value="{{ old('nama_siswa') }}" placeholder="Opsional"></div>
                        <div class="input-field"><label>Matematika</label><input type="number" name="nilai_matematika" value="{{ old('nilai_matematika') }}" min="0" max="100" required></div>
                        <div class="input-field"><label>IPA</label><input type="number" name="nilai_ipa" value="{{ old('nilai_ipa') }}" min="0" max="100" required></div>
                        <div class="input-field"><label>IPS</label><input type="number" name="nilai_ips" value="{{ old('nilai_ips') }}" min="0" max="100" required></div>
                        <div class="input-field"><label>Bahasa Indonesia</label><input type="number" name="nilai_bahasa_indonesia" value="{{ old('nilai_bahasa_indonesia') }}" min="0" max="100" required></div>
                        <div class="input-field"><label>PJOK</label><input type="number" name="nilai_pjok" value="{{ old('nilai_pjok') }}" min="0" max="100" required></div>
                        <div class="input-field"><label>Seni Budaya</label><input type="number" name="nilai_seni_budaya" value="{{ old('nilai_seni_budaya') }}" min="0" max="100" required></div>
                    </div>

                    <div class="setting-group">
                        <div class="setting-header">
                            <span class="setting-label">Parameter K</span>
                            <span class="setting-value" id="kValue">{{ old('k_value', $defaultK) }}</span>
                        </div>
                        <input type="range" id="kSlider" name="k_value" min="1" max="15" value="{{ old('k_value', $defaultK) }}" step="2">
                    </div>

                    <button type="submit" class="btn-primary"><i class="fa-solid fa-wand-magic-sparkles"></i> Dapatkan Rekomendasi Ekskul</button>
                </form>

                <div class="result-panel glass-card {{ $prediction ? 'active' : '' }}" id="resultPanel">
                    <div class="result-label">Rekomendasi Ekstrakurikuler:</div>
                    <div class="result-value">{{ $prediction?->hasil_rekomendasi ?? '-' }}</div>
                    @if ($prediction)
                        <div style="margin-top: 0.75rem; text-align: center;">
                            <a href="{{ route('knn.laporan.cetak-detail', $prediction->id) }}" target="_blank" class="btn-primary" style="display:inline-flex; align-items:center; gap:0.5rem; text-decoration:none; padding:0.5rem 1rem; font-size:0.85rem;">
                                <i class="fa-solid fa-file-pdf"></i> Cetak Lembar Rekomendasi (PDF)
                            </a>
                        </div>
                    @endif

                    <h3 style="margin-top: 1.5rem; font-size: 1rem; color: #fff; text-align: left;"><i class="fa-solid fa-users"></i> K-Tetangga Terdekat</h3>
                    <div class="table-container">
                        <table class="neighbors-table">
                            <thead>
                                <tr>
                                    <th>Nama Siswa</th>
                                    <th>Rank</th>
                                    <th>Jarak Euclidean</th>
                                    <th>Ekskul</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse (($prediction?->tetangga_terdekat ?? []) as $neighbor)
                                    <tr>
                                        <td>{{ $neighbor['nama_siswa'] }}</td>
                                        <td>{{ $neighbor['rank'] }}</td>
                                        <td>{{ number_format($neighbor['jarak'], 4) }}</td>
                                        <td>{{ $neighbor['ekstrakurikuler'] }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4">Hasil tetangga terdekat akan muncul setelah prediksi.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                @if ($prediction)
                    @php
                        $inputValues = [
                            'Matematika' => $prediction->nilai_matematika,
                            'IPA' => $prediction->nilai_ipa,
                            'IPS' => $prediction->nilai_ips,
                            'Bahasa Indonesia' => $prediction->nilai_bahasa_indonesia,
                            'PJOK' => $prediction->nilai_pjok,
                            'Seni Budaya' => $prediction->nilai_seni_budaya,
                        ];
                        $voteCounts = collect($prediction->tetangga_terdekat)
                            ->countBy('ekstrakurikuler')
                            ->sortDesc();
                        $distanceFormula = [
                            'Matematika' => 'nilai_matematika',
                            'IPA' => 'nilai_ipa',
                            'IPS' => 'nilai_ips',
                            'Bahasa Indonesia' => 'nilai_bahasa_indonesia',
                            'PJOK' => 'nilai_pjok',
                            'Seni Budaya' => 'nilai_seni_budaya',
                        ];
                    @endphp
                    <div class="modal-backdrop active" id="calculationModal">
                        <div class="calculation-modal">
                            <div class="modal-header">
                                <div>
                                    <span class="modal-eyebrow">Perhitungan KNN</span>
                                    <h3>Langkah Matematis Rekomendasi</h3>
                                </div>
                                <button type="button" class="modal-close" data-close-modal aria-label="Tutup modal">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>

                            <div class="formula-box">
                                <div class="math-expr">
                                    d(x, y) = <span class="math-sqrt"><span class="radical">&radic;</span><span class="radicand">(MTK<sub>x</sub> - MTK<sub>y</sub>)<sup>2</sup> + (IPA<sub>x</sub> - IPA<sub>y</sub>)<sup>2</sup> + (IPS<sub>x</sub> - IPS<sub>y</sub>)<sup>2</sup> + (BINDO<sub>x</sub> - BINDO<sub>y</sub>)<sup>2</sup> + (PJOK<sub>x</sub> - PJOK<sub>y</sub>)<sup>2</sup> + (SBP<sub>x</sub> - SBP<sub>y</sub>)<sup>2</sup></span></span>
                                </div>
                            </div>

                            <div class="equation-box">
                                <div class="equation-title">Rincian Hitung</div>
                                <div class="equation-line">X = (MTK<sub>uji</sub>, IPA<sub>uji</sub>, IPS<sub>uji</sub>, BINDO<sub>uji</sub>, PJOK<sub>uji</sub>, SBP<sub>uji</sub>)</div>
                                <div class="equation-line">Y = (MTK<sub>latih</sub>, IPA<sub>latih</sub>, IPS<sub>latih</sub>, BINDO<sub>latih</sub>, PJOK<sub>latih</sub>, SBP<sub>latih</sub>)</div>
                                <div class="equation-line">d<sub>1</sub> = (MTK<sub>x</sub> - MTK<sub>y</sub>)<sup>2</sup></div>
                                <div class="equation-line">d<sub>2</sub> = (IPA<sub>x</sub> - IPA<sub>y</sub>)<sup>2</sup></div>
                                <div class="equation-line">d<sub>3</sub> = (IPS<sub>x</sub> - IPS<sub>y</sub>)<sup>2</sup></div>
                                <div class="equation-line">d<sub>4</sub> = (BINDO<sub>x</sub> - BINDO<sub>y</sub>)<sup>2</sup></div>
                                <div class="equation-line">d<sub>5</sub> = (PJOK<sub>x</sub> - PJOK<sub>y</sub>)<sup>2</sup></div>
                                <div class="equation-line">d<sub>6</sub> = (SBP<sub>x</sub> - SBP<sub>y</sub>)<sup>2</sup></div>
                                <div class="equation-line equation-total">
                                    <div class="math-expr" style="font-size: 0.92rem; color: #bfdbfe;">
                                        d(x, y) = <span class="math-sqrt"><span class="radical">&radic;</span><span class="radicand">d<sub>1</sub> + d<sub>2</sub> + d<sub>3</sub> + d<sub>4</sub> + d<sub>5</sub> + d<sub>6</sub></span></span>
                                    </div>
                                </div>
                                <div class="equation-line equation-final">Hasil jarak ini digunakan untuk urutan tetangga terdekat.</div>
                            </div>

                            <div class="math-grid">
                                <section>
                                    <h4>Nilai Input Siswa</h4>
                                    <div class="mini-table">
                                        @foreach ($inputValues as $label => $value)
                                            <div><span>{{ $label }}</span><strong>{{ $value }}</strong></div>
                                        @endforeach
                                    </div>
                                </section>
                                <section>
                                    <h4>Voting Tetangga</h4>
                                    <div class="mini-table">
                                        @foreach ($voteCounts as $ekskul => $count)
                                            <div><span>{{ $ekskul }}</span><strong>{{ $count }} suara</strong></div>
                                        @endforeach
                                    </div>
                                </section>
                            </div>

                            <div class="table-container modal-table">
                                <table class="neighbors-table">
                                    <thead>
                                        <tr>
                                            <th>Siswa Data Latih</th>
                                            <th>Ekskul</th>
                                            <th>Rincian Hitung</th>
                                            <th>Total</th>
                                            <th>Jarak</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($prediction->tetangga_terdekat as $neighbor)
                                            @php
                                                $detailRows = [];
                                                foreach ($distanceFormula as $label => $field) {
                                                    $inputValue = $inputValues[$label];
                                                    $trainValue = $neighbor['nilai'][$label] ?? 0;
                                                    $difference = $inputValue - $trainValue;
                                                    $square = $neighbor['selisih_kuadrat'][$label] ?? ($difference ** 2);
                                                    $detailRows[] = [
                                                        'label' => $label,
                                                        'input' => $inputValue,
                                                        'train' => $trainValue,
                                                        'difference' => $difference,
                                                        'square' => $square,
                                                    ];
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ $neighbor['nama_siswa'] }}</td>
                                                <td>{{ $neighbor['ekstrakurikuler'] }}</td>
                                                <td>
                                                    <div class="calc-block">
                                                        @foreach ($detailRows as $detail)
                                                            <div class="calc-line">
                                                                <div class="calc-title">{{ $detail['label'] }}</div>
                                                                <div class="calc-expression">
                                                                    {{ $detail['input'] }} - {{ $detail['train'] }} = {{ $detail['difference'] }}
                                                                    <span class="calc-suffix">, kuadrat = {{ $detail['square'] }}</span>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </td>
                                                <td>{{ $neighbor['total_selisih_kuadrat'] ?? '-' }}</td>
                                                <td>{{ number_format($neighbor['jarak'], 4) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="modal-result">
                                Hasil rekomendasi: <strong>{{ $prediction->hasil_rekomendasi }}</strong>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div id="view-riwayat" class="view-section dashboard-grid" style="grid-template-columns: 1fr;">
            <div class="glass-card" style="max-width: 1000px; margin: 0 auto; width: 100%;">
                <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem; margin-bottom: 1.5rem;">
                    <h2 class="card-title" style="margin-bottom: 0;"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Prediksi dari MySQL</h2>
                    <a href="{{ route('knn.laporan.cetak') }}" target="_blank" class="btn-primary" style="display:inline-flex; align-items:center; gap:0.5rem; text-decoration:none; padding:0.65rem 1.25rem; font-size:0.9rem;">
                        <i class="fa-solid fa-file-pdf"></i> Cetak Laporan Rekapitulasi (PDF)
                    </a>
                </div>

                <div class="table-container">
                    <table class="neighbors-table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Nama</th>
                                <th>Nilai Input</th>
                                <th>K</th>
                                <th>Hasil</th>
                                <th style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($histories as $history)
                                <tr>
                                    <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $history->nama_siswa ?: '-' }}</td>
                                    <td>{{ $history->nilai_matematika }}, {{ $history->nilai_ipa }}, {{ $history->nilai_ips }}, {{ $history->nilai_bahasa_indonesia }}, {{ $history->nilai_pjok }}, {{ $history->nilai_seni_budaya }}</td>
                                    <td>K={{ $history->k_value }}</td>
                                    <td style="font-weight: 600; color: var(--success);">{{ $history->hasil_rekomendasi }}</td>
                                    <td style="text-align: center;">
                                        <a href="{{ route('knn.laporan.cetak-detail', $history->id) }}" target="_blank" class="modal-close" style="width:auto; padding:0.35rem 0.75rem; font-size:0.8rem; text-decoration:none; display:inline-flex; align-items:center; gap:0.3rem;" title="Cetak Surat Rekomendasi Siswa">
                                            <i class="fa-solid fa-print"></i> Cetak
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6">Belum ada riwayat prediksi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('js/knn_script.js') }}"></script>
</body>
</html>
