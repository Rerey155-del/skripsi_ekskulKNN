# Report Kesesuaian Sistem dengan Judul dan Rumusan Masalah

## Identitas Skripsi

**Judul skripsi:**
Implementasi Algoritma K-Nearest Neighbor (KNN) dalam Merekomendasikan Ekstrakurikuler yang Tepat bagi Siswa MTsN 2 Bayang Berbasis Web

**Platform sistem:**
Laravel berbasis web dengan database MySQL.

## Ringkasan Hasil Pemeriksaan

Secara umum, implementasi sistem saat ini **sudah mengarah sesuai** dengan judul skripsi dan rumusan masalah. Sistem sudah memiliki fitur utama berupa import data training siswa dari file, proses rekomendasi ekstrakurikuler menggunakan algoritma KNN, penyimpanan hasil prediksi, dan penggunaan database MySQL.

Namun, masih ada beberapa catatan metodologis yang sebaiknya diperjelas dalam skripsi, terutama terkait pengujian akurasi agar klaim rekomendasi yang tepat dapat dibuktikan.

## Kesesuaian dengan Judul Skripsi

| Komponen Judul | Status | Bukti Implementasi | Catatan |
|---|---|---|---|
| Implementasi algoritma KNN | Sesuai | Perhitungan jarak Euclidean, pengurutan jarak, pengambilan K tetangga, voting mayoritas, dan tie-break rank ada di `KnnController`. | Sudah mencerminkan proses inti KNN. |
| Rekomendasi ekstrakurikuler | Sesuai | Output sistem berupa `hasil_rekomendasi` pada tabel riwayat prediksi. | Hasil rekomendasi tampil pada halaman prediksi dan tersimpan ke database. |
| Tepat bagi siswa | Cukup sesuai | Input siswa menggunakan nilai akademik, lalu sistem menghasilkan rekomendasi ekstrakurikuler otomatis. | Ketepatan perlu dibuktikan dengan pengujian akurasi atau validasi terhadap data aktual. |
| MTsN 2 Bayang | Belum eksplisit di UI/database | Struktur sistem sudah siap digunakan untuk data siswa MTsN 2 Bayang. | Sebaiknya nama sekolah ditampilkan di dashboard atau metadata sistem agar konteks penelitian terlihat. |
| Berbasis web | Sesuai | Aplikasi berjalan melalui route Laravel, Blade view, form POST, dan halaman flowchart. | Sudah memenuhi karakteristik aplikasi web. |
| Database MySQL | Sesuai | `.env` memakai `DB_CONNECTION=mysql`, migrasi membuat tabel KNN. | Database `skripsi_yu` sudah dibuat saat migrasi. |

## Pemeriksaan Berdasarkan Rumusan Masalah

### 1. Bagaimana membuat dan menerapkan sistem rekomendasi ekstrakurikuler berbasis web di MTsN 2 Bayang dengan menggunakan algoritma K-Nearest Neighbor?

**Status: Sudah sesuai.**

Sistem sudah dibuat menggunakan Laravel dan menyediakan beberapa menu utama:

- Dashboard
- Data Training melalui import file
- Prediksi Siswa
- Riwayat Prediksi
- Flowchart

Proses rekomendasi tidak lagi hanya berjalan di browser, tetapi sudah diproses di backend Laravel. Ini lebih sesuai untuk sistem berbasis web yang menggunakan database MySQL.

**Bukti kode:**

- Route aplikasi: `routes/web.php`
- Controller KNN: `app/Http/Controllers/KnnController.php`
- Tampilan utama: `resources/views/knn.blade.php`
- Flowchart: `resources/views/flowchart.blade.php`

### 2. Bagaimana penggunaan data nilai rapor siswa dalam algoritma K-Nearest Neighbor untuk menghasilkan rekomendasi ekstrakurikuler yang sesuai dengan karakteristik siswa?

**Status: Sebagian besar sesuai.**

Sistem sudah menggunakan data berikut sebagai fitur perhitungan:

- Nilai Matematika
- Nilai IPA
- Nilai IPS
- Nilai Bahasa Indonesia
- Nilai PJOK
- Nilai Seni Budaya

Data training dapat diimport dari file `.xlsx` atau `.csv` dengan format rapor yang memiliki kolom seperti `Nama`, `MTK`, `IPA`, `IPS`, `BINDO` atau `Bahasa Indonesia`, `PJOK`, `SBP`, `RANK`, dan `Ekskul`. Data tersebut disimpan dalam tabel `knn_training_samples` dan digunakan dalam proses prediksi.

**Catatan penting:**

Label `ekstrakurikuler` pada data training digunakan sebagai kelas hasil rekomendasi, bukan lagi sebagai input prediksi. Sistem menghitung kedekatan siswa berdasarkan nilai akademik, kemudian menentukan rekomendasi dari voting mayoritas tetangga terdekat.

Jika ingin lebih kuat secara akademik, opsi perbaikannya:

- Gunakan normalisasi nilai akademik jika skala data pada tiap mata pelajaran berbeda.
- Tambahkan pengujian akurasi untuk membuktikan rekomendasi yang dihasilkan.
- Jelaskan bahwa ekstrakurikuler pada dataset berperan sebagai label kelas KNN.

### 3. Bagaimana penerapan algoritma K-Nearest Neighbor dalam membandingkan karakteristik antar siswa sehingga dapat menghasilkan rekomendasi ekstrakurikuler yang tepat?

**Status: Sudah sesuai secara alur algoritma.**

Penerapan KNN pada sistem saat ini:

1. Mengambil seluruh data latih dari database MySQL.
2. Menghitung jarak Euclidean antara data siswa baru dan data training.
3. Mengurutkan data berdasarkan jarak terkecil.
4. Mengambil sejumlah K tetangga terdekat.
5. Melakukan voting mayoritas berdasarkan ekstrakurikuler.
6. Jika hasil voting seri, sistem memilih berdasarkan rank terbaik.
7. Menyimpan hasil rekomendasi dan tetangga terdekat ke riwayat prediksi.

Alur tersebut sudah cocok dengan konsep KNN untuk klasifikasi rekomendasi ekstrakurikuler.

## Penjelasan Sumber Nilai Data Training dalam Perhitungan KNN

Bagian `nilai data` pada rumus KNN berasal dari **setiap baris siswa pada file Excel yang sudah diimport**, bukan dari satu siswa tertentu dan bukan hanya dari siswa dengan rank tertinggi.

Jika file Excel berisi 32 siswa, maka sistem akan menghitung jarak antara siswa yang sedang diprediksi dengan 32 siswa tersebut satu per satu. Jadi perbandingannya tidak dicampur, melainkan dilakukan baris demi baris.

Contoh nilai input siswa baru:

| Mapel | Nilai Input |
|---|---:|
| MTK | 83 |
| IPA | 81 |
| IPS | 84 |
| Bahasa Indonesia | 80 |
| PJOK | 81 |
| Seni Budaya | 85 |

Contoh beberapa data training dari Excel:

| Siswa Data Training | MTK | IPA | IPS | BINDO | PJOK | SBP | Ekskul |
|---|---:|---:|---:|---:|---:|---:|---|
| Siswa A | 83 | 81 | 84 | 79 | 79 | 83 | Voli |
| Siswa B | 83 | 81 | 83 | 77 | 79 | 84 | Voli |
| Siswa C | 80 | 78 | 82 | 80 | 90 | 75 | Musik |

Sistem menghitung jarak ke setiap siswa data training:

```text
Jarak input ke Siswa A
Jarak input ke Siswa B
Jarak input ke Siswa C
...
Jarak input ke semua siswa pada data training
```

Rumus jarak Euclidean yang digunakan:

```text
jarak = sqrt(
  (MTK input - MTK data)^2 +
  (IPA input - IPA data)^2 +
  (IPS input - IPS data)^2 +
  (BINDO input - BINDO data)^2 +
  (PJOK input - PJOK data)^2 +
  (SBP input - SBP data)^2
)
```

Contoh perhitungan ke Siswa A:

| Mapel | Input | Data Siswa A | Selisih | Selisih Kuadrat |
|---|---:|---:|---:|---:|
| MTK | 83 | 83 | 0 | 0 |
| IPA | 81 | 81 | 0 | 0 |
| IPS | 84 | 84 | 0 | 0 |
| Bahasa Indonesia | 80 | 79 | 1 | 1 |
| PJOK | 81 | 79 | 2 | 4 |
| Seni Budaya | 85 | 83 | 2 | 4 |

Total selisih kuadrat:

```text
0 + 0 + 0 + 1 + 4 + 4 = 9
```

Jarak:

```text
sqrt(9) = 3.00
```

Artinya, Siswa A memiliki jarak `3.00` dari siswa yang sedang diprediksi. Semakin kecil jaraknya, semakin mirip karakter nilai akademiknya.

Setelah semua jarak dihitung, sistem mengurutkan jarak dari yang paling kecil. Jika nilai `K = 9`, maka sistem mengambil 9 siswa paling dekat. Ekskul dari 9 siswa tersebut kemudian dihitung votingnya.

Contoh hasil voting:

| Ekskul | Jumlah Suara |
|---|---:|
| Musik | 4 |
| Voli | 3 |
| Tahfiz | 2 |

Karena suara terbanyak adalah `Musik`, maka rekomendasi akhirnya adalah:

```text
Musik
```

Peran `rank` dalam sistem bukan untuk memilih data training awal. Semua siswa tetap dihitung jaraknya. `Rank` hanya digunakan jika hasil voting seri.

Contoh voting seri:

| Ekskul | Jumlah Suara |
|---|---:|
| Musik | 3 |
| Voli | 3 |

Jika terjadi seri seperti itu, sistem memilih rekomendasi dari tetangga terdekat yang memiliki rank terbaik di antara kandidat yang seri.

## Struktur Database yang Mendukung Rumusan Masalah

### Tabel `knn_training_samples`

Tabel ini menyimpan dataset siswa sebagai data latih.

Kolom penting:

- `nama_siswa`
- `nilai_matematika`
- `nilai_ipa`
- `nilai_ips`
- `nilai_bahasa_indonesia`
- `nilai_pjok`
- `nilai_seni_budaya`
- `rank`
- `ekstrakurikuler`

### Tabel `knn_prediction_histories`

Tabel ini menyimpan hasil rekomendasi yang pernah dilakukan.

Kolom penting:

- `nama_siswa`
- nilai input siswa
- `k_value`
- `hasil_rekomendasi`
- `tetangga_terdekat`

## Kelebihan Implementasi Saat Ini

- Sudah menggunakan Laravel sebagai framework web.
- Sudah menggunakan MySQL sebagai database utama.
- Data training diimport dari file, ditampilkan urut berdasarkan nama siswa, dan import baru otomatis mengganti data lama.
- Prediksi KNN diproses di backend sehingga lebih cocok untuk aplikasi skripsi.
- Riwayat prediksi tersimpan di database.
- Flowchart sudah sesuai dengan alur Laravel dan MySQL.
- Validasi input sudah tersedia pada sisi Laravel.

## Catatan Kekurangan dan Saran Perbaikan

| Catatan | Dampak | Saran |
|---|---|---|
| Nama MTsN 2 Bayang belum terlihat jelas pada UI | Konteks penelitian kurang kuat | Tambahkan nama sekolah di dashboard/header. |
| Belum ada laporan akurasi | Klaim "tepat" belum terbukti kuat | Tambahkan pengujian akurasi dengan data uji. |
| Label ekstrakurikuler dari file import masih berbentuk teks bebas | Potensi typo seperti "Basket" dan "basket" dianggap kelas berbeda | Standarkan penulisan label ekstrakurikuler pada dataset. |
| K belum divalidasi harus ganjil | K genap bisa meningkatkan peluang seri | Batasi K ke bilangan ganjil atau jelaskan tie-break rank. |

## Kesimpulan Kesesuaian

Berdasarkan pemeriksaan kode dan alur sistem, aplikasi ini **sudah sesuai secara fungsional** dengan judul skripsi dan rumusan masalah. Sistem sudah mampu menyimpan data siswa di MySQL, menggunakan data nilai dalam proses KNN, menghasilkan rekomendasi ekstrakurikuler otomatis, serta menyimpan riwayat hasil rekomendasi.

Untuk membuatnya lebih kuat sebagai karya skripsi, bagian yang paling perlu diperkuat adalah **pengujian akurasi**, **penjelasan label kelas ekstrakurikuler pada KNN**, dan **penyesuaian identitas MTsN 2 Bayang pada tampilan sistem**.

## Rekomendasi Status

**Status akhir: Layak dilanjutkan sebagai implementasi skripsi, dengan revisi metodologi dan evaluasi akurasi.**
