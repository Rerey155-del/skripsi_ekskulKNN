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
        <div class="logo">
            <i class="fa-solid fa-cube"></i> EkskulKNN
        </div>
        <ul class="nav-links">
            <li class="nav-item active" data-target="dashboard"><i class="fa-solid fa-chart-line"></i> Dashboard</li>
            <li class="nav-item" data-target="data-training"><i class="fa-solid fa-database"></i> Data Training</li>
            <li class="nav-item" data-target="prediksi"><i class="fa-solid fa-users"></i> Prediksi Siswa</li>
            <li class="nav-item" data-target="riwayat"><i class="fa-solid fa-clock-rotate-left"></i> Riwayat</li>
            <li class="nav-item" onclick="window.location.href='{{ route('knn.flowchart') }}'"><i class="fa-solid fa-diagram-project"></i> Flowchart</li>
        </ul>
    </aside>

    <main class="main-content">
        <header>
            <div>
                <h1 id="pageTitle">Dashboard</h1>
                <p style="color: var(--text-muted); margin-top: 0.25rem;">Laravel + MySQL untuk rekomendasi ekstrakurikuler dengan KNN</p>
            </div>
            <div class="user-profile">
                <span style="color: var(--text-muted);">Admin/Guru</span>
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
                    Rumusan masalah difokuskan pada pembuatan sistem berbasis Laravel, penggunaan data siswa dari database MySQL, dan penerapan K-Nearest Neighbor memakai nilai akademik serta ekstrakurikuler.
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
                            Nama, IPA, PJOK, SBP/Seni Budaya, RANK, Ekskul
                        </div>
                    </div>
                    <button type="submit" class="btn-primary"><i class="fa-solid fa-file-import"></i> Import dan Simpan Data Training</button>
                </form>

                <div class="table-container">
                    <table class="neighbors-table">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>IPA</th>
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
                                    <td>{{ $sample->nilai_ipa }}</td>
                                    <td>{{ $sample->nilai_pjok }}</td>
                                    <td>{{ $sample->nilai_seni_budaya }}</td>
                                    <td>{{ $sample->rank }}</td>
                                    <td>{{ $sample->ekstrakurikuler }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6">Belum ada data training.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div id="view-prediksi" class="view-section dashboard-grid" style="grid-template-columns: 1fr;">
            <div class="glass-card" style="max-width: 900px; margin: 0 auto; width: 100%;">
                <h2 class="card-title"><i class="fa-solid fa-user-plus"></i> Prediksi Rekomendasi Siswa</h2>

                <form method="POST" action="{{ route('knn.predict') }}">
                    @csrf
                    <div class="input-grid three">
                        <div class="input-field"><label>Nama Siswa</label><input name="nama_siswa" value="{{ old('nama_siswa') }}" placeholder="Opsional"></div>
                        <div class="input-field"><label>Ekstrakurikuler</label>
                            <select name="ekstrakurikuler" required>
                                @foreach ($ekskulOptions as $option)
                                    <option value="{{ $option }}" @selected(old('ekstrakurikuler') === $option)>{{ $option }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-field"><label>Matematika</label><input type="number" name="nilai_matematika" value="{{ old('nilai_matematika') }}" min="0" max="100" required></div>
                        <div class="input-field"><label>IPA</label><input type="number" name="nilai_ipa" value="{{ old('nilai_ipa') }}" min="0" max="100" required></div>
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
                                <th>Ekstrakurikuler</th>
                                <th>K</th>
                                <th>Hasil</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($histories as $history)
                                <tr>
                                    <td>{{ $history->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $history->nama_siswa ?: '-' }}</td>
                                    <td>{{ $history->nilai_matematika }}, {{ $history->nilai_ipa }}, {{ $history->nilai_pjok }}, {{ $history->nilai_seni_budaya }}</td>
                                    <td>{{ $history->minat }}</td>
                                    <td>K={{ $history->k_value }}</td>
                                    <td style="font-weight: 600; color: var(--success);">{{ $history->hasil_rekomendasi }}</td>
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
