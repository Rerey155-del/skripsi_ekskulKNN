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

    @if (auth()->user()->role === 'siswa')
    <main class="main-content" style="padding: 2rem; margin: 0 auto; width: min(1100px, 100%);">
        <header>
            <div>
                <h1 id="pageTitle">Data Uji Siswa</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem;">Masukkan nilai siswa untuk mendapatkan rekomendasi ekstrakurikuler.</p>
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

            @if ($prediction)
                <div class="result-panel glass-card active" id="resultPanel" style="margin-top: 1.5rem;">
                    <div class="result-label">Rekomendasi Ekstrakurikuler:</div>
                    <div class="result-value">{{ $prediction->hasil_rekomendasi }}</div>
                </div>
            @else
                <div class="result-panel glass-card" id="resultPanel" style="margin-top: 1.5rem;">
                    <div class="result-label">Rekomendasi Ekstrakurikuler:</div>
                    <div class="result-value">Belum ada hasil</div>
                    <div style="color: var(--text-muted); margin-top: 0.75rem;">Data belum diproses oleh admin atau belum tersimpan di sistem.</div>
                </div>
            @endif
        </div>
    </main>
    @else
    <aside class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-cube"></i> EkskulKNN
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
            <div>
                <h1 id="pageTitle">Dashboard</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem;">Laravel + MySQL untuk rekomendasi ekstrakurikuler dengan KNN</p>
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
            <div class="glass-card" style="text-align: center; padding: 4rem 2rem;">
                <h2 style="font-size: 2rem; margin-bottom: 1rem;">Sistem Rekomendasi Ekstrakurikuler</h2>
                <p style="color: var(--text-muted); max-width: 720px; margin: 0 auto; line-height: 1.6;">
                    Rumusan masalah difokuskan pada pembuatan sistem berbasis Laravel, penggunaan data siswa dari database MySQL, dan penerapan K-Nearest Neighbor memakai nilai akademik.
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

        @if (auth()->user()->role === 'admin')
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
        @endif

        @if (auth()->user()->role === 'siswa')
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
                                        <td>{{ number_format($neighbor['jarak'], 2) }}</td>
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
                                d(x,y) = sqrt((MTKx - MTKy)^2 + (IPAx - IPAy)^2 + (IPSx - IPSy)^2 + (BINDOx - BINDOy)^2 + (PJOKx - PJOKy)^2 + (SBPx - SBPy)^2)
                            </div>

                            <div class="equation-box">
                                <div class="equation-title">Rincian Hitung</div>
                                <div class="equation-line">X = (MTK uji, IPA uji, IPS uji, BINDO uji, PJOK uji, SBP uji)</div>
                                <div class="equation-line">Y = (MTK latih, IPA latih, IPS latih, BINDO latih, PJOK latih, SBP latih)</div>
                                <div class="equation-line">d1 = (MTKx - MTKy)^2</div>
                                <div class="equation-line">d2 = (IPAx - IPAy)^2</div>
                                <div class="equation-line">d3 = (IPSx - IPSy)^2</div>
                                <div class="equation-line">d4 = (BINDOx - BINDOy)^2</div>
                                <div class="equation-line">d5 = (PJOKx - PJOKy)^2</div>
                                <div class="equation-line">d6 = (SBPx - SBPy)^2</div>
                                <div class="equation-line equation-total">d(x,y) = sqrt(d1 + d2 + d3 + d4 + d5 + d6)</div>
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
                                                <td>{{ number_format($neighbor['jarak'], 2) }}</td>
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
                <h2 class="card-title"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat Prediksi dari MySQL</h2>

                <div class="table-container">
                    <table class="neighbors-table">
                        <thead>
                            <tr>
                                <th>Waktu</th>
                                <th>Nama</th>
                                <th>Nilai Input</th>
                                <th>K</th>
                                <th>Hasil</th>
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
                                </tr>
                            @empty
                                <tr><td colspan="5">Belum ada riwayat prediksi.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </main>
    @endif

    <script src="{{ asset('js/knn_script.js') }}"></script>
</body>
</html>
