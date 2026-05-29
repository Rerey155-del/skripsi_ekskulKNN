# Report Kesesuaian Sistem dengan Judul dan Rumusan Masalah

## Identitas Skripsi

**Judul skripsi:**
Implementasi Algoritma K-Nearest Neighbor (KNN) dalam Merekomendasikan Ekstrakurikuler yang Tepat bagi Siswa MTsN 2 Bayang Berbasis Web

**Platform sistem:**
Laravel berbasis web dengan database MySQL.

## Ringkasan Hasil Pemeriksaan

Secara umum, implementasi sistem saat ini **sudah mengarah sesuai** dengan judul skripsi dan rumusan masalah. Sistem sudah memiliki fitur utama berupa import data training siswa dari file, proses rekomendasi ekstrakurikuler menggunakan algoritma KNN, penyimpanan hasil prediksi, dan penggunaan database MySQL.

Namun, masih ada beberapa catatan metodologis yang sebaiknya diperjelas dalam skripsi, terutama terkait cara menggunakan variabel ekstrakurikuler sebagai fitur kategorikal dalam perhitungan jarak.

## Kesesuaian dengan Judul Skripsi

| Komponen Judul | Status | Bukti Implementasi | Catatan |
|---|---|---|---|
| Implementasi algoritma KNN | Sesuai | Perhitungan jarak Euclidean, pengurutan jarak, pengambilan K tetangga, voting mayoritas, dan tie-break rank ada di `KnnController`. | Sudah mencerminkan proses inti KNN. |
| Rekomendasi ekstrakurikuler | Sesuai | Output sistem berupa `hasil_rekomendasi` pada tabel riwayat prediksi. | Hasil rekomendasi tampil pada halaman prediksi dan tersimpan ke database. |
| Tepat bagi siswa | Cukup sesuai | Input siswa menggunakan nilai akademik dan ekstrakurikuler. | Ketepatan perlu dibuktikan dengan pengujian akurasi atau validasi terhadap data aktual. |
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

### 2. Bagaimana penggunaan data nilai rapor dan ekstrakurikuler siswa dalam algoritma K-Nearest Neighbor untuk menghasilkan rekomendasi ekstrakurikuler yang sesuai dengan karakteristik siswa?

**Status: Sebagian besar sesuai.**

Sistem sudah menggunakan data berikut sebagai fitur perhitungan:

- Nilai Matematika
- Nilai IPA
- Nilai PJOK
- Nilai Seni Budaya
- Ekstrakurikuler

Data training dapat diimport dari file `.xlsx` atau `.csv` dengan format rapor yang memiliki kolom seperti `Nama`, `IPA`, `PJOK`, `SBP`, `RANK`, dan `Ekskul`. Jika kolom `MTK` tersedia pada file, nilainya ikut disimpan untuk kebutuhan perhitungan KNN. Data tersebut disimpan dalam tabel `knn_training_samples` dan digunakan dalam proses prediksi.

**Catatan penting:**

Variabel `ekstrakurikuler` masih berbentuk kategori teks. Pada kode, perbedaan ekstrakurikuler dihitung dengan penalti jarak `25` jika input berbeda dari data training. Ini boleh digunakan, tetapi harus dijelaskan dalam bab metode sebagai proses transformasi data kategorikal ke bentuk numerik.

Jika ingin lebih kuat secara akademik, opsi perbaikannya:

- Gunakan encoding numerik untuk setiap ekstrakurikuler.
- Gunakan one-hot encoding.
- Jelaskan bobot penalti ekstrakurikuler berdasarkan pertimbangan penelitian.
- Normalisasi seluruh fitur agar skala nilai akademik dan ekstrakurikuler seimbang.

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

## Struktur Database yang Mendukung Rumusan Masalah

### Tabel `knn_training_samples`

Tabel ini menyimpan dataset siswa sebagai data latih.

Kolom penting:

- `nama_siswa`
- `nilai_ipa`
- `nilai_pjok`
- `nilai_seni_budaya`
- `nilai_matematika` jika tersedia pada file
- `rank`
- `ekstrakurikuler`

### Tabel `knn_prediction_histories`

Tabel ini menyimpan hasil rekomendasi yang pernah dilakukan.

Kolom penting:

- `nama_siswa`
- nilai input siswa
- `ekstrakurikuler` disimpan pada kolom kompatibilitas riwayat
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
| Ekstrakurikuler masih dihitung sebagai penalti tetap `25` | Perlu dasar metodologi | Jelaskan dalam bab metode atau ubah ke encoding yang lebih formal. |
| Belum ada laporan akurasi | Klaim "tepat" belum terbukti kuat | Tambahkan pengujian akurasi dengan data uji. |
| Data ekstrakurikuler masih input teks bebas | Potensi typo seperti "Basket" dan "basket" dianggap berbeda | Gunakan dropdown atau tabel master ekstrakurikuler. |
| K belum divalidasi harus ganjil | K genap bisa meningkatkan peluang seri | Batasi K ke bilangan ganjil atau jelaskan tie-break rank. |

## Kesimpulan Kesesuaian

Berdasarkan pemeriksaan kode dan alur sistem, aplikasi ini **sudah sesuai secara fungsional** dengan judul skripsi dan rumusan masalah. Sistem sudah mampu menyimpan data siswa di MySQL, menggunakan data nilai dan ekstrakurikuler dalam proses KNN, menghasilkan rekomendasi ekstrakurikuler, serta menyimpan riwayat hasil rekomendasi.

Untuk membuatnya lebih kuat sebagai karya skripsi, bagian yang paling perlu diperkuat adalah **penjelasan metode perhitungan fitur ekstrakurikuler**, **pengujian akurasi**, dan **penyesuaian identitas MTsN 2 Bayang pada tampilan sistem**.

## Rekomendasi Status

**Status akhir: Layak dilanjutkan sebagai implementasi skripsi, dengan revisi metodologi dan evaluasi akurasi.**
