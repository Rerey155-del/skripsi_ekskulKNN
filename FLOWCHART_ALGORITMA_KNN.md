# Flowchart Algoritma K-Nearest Neighbors

## Narasi Subbab

Berdasarkan algoritma K-Nearest Neighbors yang telah dijelaskan di atas, langkah-langkah prosesnya digambarkan dalam sebuah flowchart. Flowchart ini menunjukkan proses perhitungan KNN mulai dari pengambilan data latih, input data uji, perhitungan jarak Euclidean, pengurutan jarak, penentuan K tetangga terdekat, hingga menghasilkan rekomendasi ekstrakurikuler. Flowchart proses algoritma KNN dapat dilihat pada gambar 4.1 berikut:

## Flowchart

```mermaid
flowchart TD
    A([Mulai])
    B[/Ambil Data Latih<br/>dari Database MySQL/]
    C[/Input Data Uji Siswa<br/>Nama dan Nilai Akademik/]
    D[Validasi Data Uji<br/>dan Data Latih]
    E{Data Lengkap?}
    F[/Tampilkan Pesan<br/>Data Belum Lengkap/]
    G[Hitung Jarak Euclidean<br/>Data Uji terhadap Semua Data Latih]
    H[Urutkan Data Latih<br/>Berdasarkan Jarak Terkecil]
    I[Ambil K Tetangga Terdekat]
    J[Hitung Voting<br/>Label Ekstrakurikuler]
    K{Ada Hasil Seri?}
    L[Pilih Label dari Tetangga<br/>dengan Jarak Terkecil]
    M[Pilih Label dengan<br/>Suara Terbanyak]
    N[/Tampilkan Rekomendasi<br/>Ekstrakurikuler/]
    O[Simpan Hasil Prediksi<br/>ke Riwayat]
    P([Selesai])

    A --> B
    B --> C
    C --> D
    D --> E
    E -- Tidak --> F
    F --> P
    E -- Ya --> G
    G --> H
    H --> I
    I --> J
    J --> K
    K -- Ya --> L
    K -- Tidak --> M
    L --> N
    M --> N
    N --> O
    O --> P
```

## Caption Gambar

**Gambar 4.1 Flowchart Algoritma K-Nearest Neighbors**

## Versi Teks Isi Flowchart

1. Mulai.
2. Sistem mengambil data latih dari database MySQL.
3. Siswa atau admin memasukkan data uji berupa nama siswa dan nilai akademik.
4. Sistem melakukan validasi terhadap data uji dan data latih.
5. Jika data belum lengkap, sistem menampilkan pesan kesalahan.
6. Jika data lengkap, sistem menghitung jarak Euclidean antara data uji dan seluruh data latih.
7. Sistem mengurutkan data latih berdasarkan jarak terkecil.
8. Sistem mengambil sejumlah K tetangga terdekat.
9. Sistem melakukan voting berdasarkan label ekstrakurikuler pada tetangga terdekat.
10. Jika terdapat hasil seri, sistem memilih label dari tetangga dengan jarak terkecil.
11. Jika tidak terdapat hasil seri, sistem memilih label dengan suara terbanyak.
12. Sistem menampilkan rekomendasi ekstrakurikuler.
13. Sistem menyimpan hasil prediksi ke riwayat.
14. Selesai.
