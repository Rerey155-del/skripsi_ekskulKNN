<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flowchart Sistem Rekomendasi Ekskul KNN</title>
    <script type="module">
        import mermaid from 'https://cdn.jsdelivr.net/npm/mermaid@10/dist/mermaid.esm.min.mjs';
        mermaid.initialize({
            startOnLoad: true,
            theme: 'base',
            themeVariables: {
                primaryColor: '#eef2ff',
                primaryBorderColor: '#6366f1',
                primaryTextColor: '#0f172a',
                lineColor: '#475569',
                fontFamily: 'Inter, Arial, sans-serif'
            }
        });
    </script>
    <style>
        body {
            margin: 0;
            min-height: 100vh;
            font-family: Arial, sans-serif;
            background: #f8fafc;
            color: #0f172a;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 32px;
        }

        .wrapper {
            width: min(1200px, 100%);
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
            padding: 24px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            align-items: center;
            margin-bottom: 24px;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 24px;
        }

        p {
            margin: 0;
            color: #64748b;
        }

        a {
            color: #4f46e5;
            font-weight: 700;
            text-decoration: none;
        }

        .mermaid {
            display: flex;
            justify-content: center;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <main class="wrapper">
        <div class="topbar">
            <div>
                <h1>Flowchart Sistem Rekomendasi Ekskul KNN</h1>
                <p>Alur disesuaikan dengan proses aplikasi Laravel dan database MySQL.</p>
            </div>
            <a href="{{ route('knn.index') }}">Kembali ke Aplikasi</a>
        </div>

        <pre class="mermaid">
flowchart TD
    A([Mulai]) --> B[Dashboard Sistem Rekomendasi Ekskul]
    B --> C[/Menu Data Training:<br>Import file dataset siswa/]

    subgraph P["Pengelolaan Dataset MySQL"]
        C --> D[Laravel membaca file .xlsx/.csv<br>dan memetakan header kolom]
        D --> E[Validasi data:<br>nama, nilai, rank, ekskul]
        E --> F{Data valid?}
        F -- Tidak --> G[/Tampilkan pesan validasi/]
        G --> Z([Selesai])
        F -- Ya --> H[Ambil kolom utama:<br>Nama, MTK, IPA, IPS,<br>BINDO, PJOK, SBP,<br>Rank, Ekskul]
        H --> I[Hapus data training lama<br>dan simpan dataset baru]
        I --> J[Perbarui dashboard<br>dan tabel Data Training]
    end

    J --> K[/Atur Parameter K<br>melalui slider/]
    K --> L[/Menu Prediksi Siswa:<br>Input nilai siswa/]

    subgraph V["Validasi Prediksi"]
        L --> M{Data latih tersedia<br>di MySQL?}
        M -- Tidak --> N[/Alert:<br>Isi Data Training terlebih dahulu/]
        N --> Z
        M -- Ya --> O{Input nilai lengkap?}
        O -- Tidak --> Q[/Alert:<br>Lengkapi nilai siswa/]
        Q --> Z
    end

    subgraph KNN["Proses Algoritma KNN"]
        O -- Ya --> R[Ambil seluruh data latih<br>dari tabel MySQL]
        R --> S[Hitung jarak Euclidean<br>berdasarkan MTK, IPA, IPS,<br>BINDO, PJOK, dan SBP]
        S --> T[Urutkan jarak<br>dari terkecil ke terbesar]
        T --> U[Ambil K tetangga terdekat]
        U --> W[Hitung voting mayoritas<br>berdasarkan Ekskul tetangga]
        W --> X{Ada hasil seri?}
        X -- Ya --> Y[Pilih Ekskul dari tetangga<br>dengan Rank terbaik]
        X -- Tidak --> AA[Pilih Ekskul dengan suara terbanyak]
    end

    Y --> AB[/Output rekomendasi Ekskul/]
    AA --> AB
    AB --> AC[Tampilkan tabel K tetangga<br>dan modal perhitungan matematis]
    AC --> AD[Simpan hasil ke tabel<br>knn_prediction_histories]
    AD --> AE([Selesai])

    classDef startEnd fill:#dcfce7,stroke:#16a34a,stroke-width:2px,color:#14532d;
    classDef inputOutput fill:#e0f2fe,stroke:#0284c7,stroke-width:2px,color:#0c4a6e;
    classDef process fill:#eef2ff,stroke:#6366f1,stroke-width:2px,color:#1e1b4b;
    classDef decision fill:#fef3c7,stroke:#d97706,stroke-width:2px,color:#78350f;
    classDef warning fill:#fee2e2,stroke:#dc2626,stroke-width:2px,color:#7f1d1d;
    classDef group fill:#f8fafc,stroke:#94a3b8,stroke-width:1px,color:#0f172a;

    class A,AE,Z startEnd;
    class C,K,L,AB,N,Q,G inputOutput;
    class B,D,E,H,I,J,R,S,T,U,W,Y,AA,AC,AD process;
    class F,M,O,X decision;
    class G,N,Q warning;
    class P,V,KNN group;
        </pre>
    </main>
</body>
</html>
