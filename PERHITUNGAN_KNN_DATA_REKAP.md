# Perhitungan KNN Rekomendasi Ekstrakurikuler

## 1. Sumber Data

Perhitungan ini menggunakan file:

`Data_Rekap_Ekskul_Random_Terarah.xlsx`

Data yang dipakai sebagai data training adalah data siswa yang memiliki nilai lengkap pada atribut:

- MTK
- IPA
- IPS
- Bahasa Indonesia atau BINDO
- PJOK
- Seni Budaya atau SBP
- Rank
- Ekskul

Jumlah data training valid yang terbaca adalah **32 data siswa**. Kolom `Rank` tidak digunakan sebagai atribut jarak Euclidean, tetapi dapat digunakan sebagai informasi tambahan atau pengurutan jika ada nilai jarak yang sama.

## 2. Data Uji Siswa

Data uji adalah data siswa yang dimasukkan pada halaman prediksi untuk dihitung rekomendasinya. Nilai berikut digunakan sebagai contoh data uji pada perhitungan ini:

| Atribut | Nilai |
|---|---:|
| Matematika | 83 |
| IPA | 81 |
| IPS | 84 |
| Bahasa Indonesia | 80 |
| PJOK | 81 |
| Seni Budaya | 85 |

Catatan:

- Data uji bukan diambil dari satu siswa dengan rank tertinggi.
- Data uji adalah data siswa yang ingin diprediksi, bisa berasal dari input manual pada sistem.
- Jika ingin ditulis lebih formal di skripsi, bagian ini bisa disebut sebagai "data siswa uji" atau "data input siswa yang akan direkomendasikan".

Nilai `K` yang digunakan pada contoh perhitungan ini adalah **9**.

## 3. Rumus Euclidean Distance

Rumus jarak Euclidean yang digunakan:

```text
d(x,y) = sqrt(
  (MTKx - MTKy)^2 +
  (IPAx - IPAy)^2 +
  (IPSx - IPSy)^2 +
  (BINDOx - BINDOy)^2 +
  (PJOKx - PJOKy)^2 +
  (SBPx - SBPy)^2
)
```

Keterangan:

- `x` adalah data siswa yang akan diprediksi.
- `y` adalah salah satu data siswa pada data training.
- Setiap siswa pada data training dihitung jaraknya satu per satu terhadap data uji.
- Hasil rekomendasi diambil dari mayoritas ekstrakurikuler pada `K` tetangga terdekat.

### Langkah Perhitungan Matematis

Urutan hitungnya seperti ini:

1. Tentukan data uji siswa yang akan diprediksi.
2. Ambil satu data siswa dari data training.
3. Hitung selisih tiap atribut antara data uji dan data training.
4. Kuadratkan setiap selisih.
5. Jumlahkan semua hasil kuadrat.
6. Ambil akar kuadrat dari total tersebut.
7. Ulangi ke seluruh data training.
8. Urutkan jarak dari yang paling kecil.
9. Ambil `K` data terdekat.
10. Lakukan voting berdasarkan label ekstrakurikuler.

### Bentuk Perhitungan Satu Baris

Untuk satu data training, prosesnya dapat ditulis seperti ini:

```text
Selisih MTK   = MTK uji - MTK training
Selisih IPA   = IPA uji - IPA training
Selisih IPS   = IPS uji - IPS training
Selisih BINDO = BINDO uji - BINDO training
Selisih PJOK  = PJOK uji - PJOK training
Selisih SBP   = SBP uji - SBP training

Total = (Selisih MTK)^2 + (Selisih IPA)^2 + (Selisih IPS)^2 + (Selisih BINDO)^2 + (Selisih PJOK)^2 + (Selisih SBP)^2
Jarak = sqrt(Total)
```

Artinya:

- selisih tiap nilai menunjukkan seberapa jauh data uji dari data training,
- semakin kecil selisihnya, semakin kecil jaraknya,
- semakin kecil jarak, semakin mirip data tersebut dengan siswa uji.

## 4. Contoh Perhitungan 10 Data Training Pertama

### Data 1: ADAM ROMARTA

Data training:

| MTK | IPA | IPS | BINDO | PJOK | SBP | Ekskul |
|---:|---:|---:|---:|---:|---:|---|
| 84 | 88 | 88 | 95 | 88 | 91 | Voli |

Perhitungan:

```text
nilai data uji:
MTK = 83
IPA = 81
IPS = 84
BINDO = 80
PJOK = 81
SBP = 85

selisih tiap atribut:
83 - 84 = -1
81 - 88 = -7
84 - 88 = -4
80 - 95 = -15
81 - 88 = -7
85 - 91 = -6

kuadrat selisih:
(-1)^2 = 1
(-7)^2 = 49
(-4)^2 = 16
(-15)^2 = 225
(-7)^2 = 49
(-6)^2 = 36

d = sqrt((83-84)^2 + (81-88)^2 + (84-88)^2 + (80-95)^2 + (81-88)^2 + (85-91)^2)
d = sqrt(1 + 49 + 16 + 225 + 49 + 36)
d = sqrt(376)
d = 19.39
```

### Data 2: AISYA VANDRILLA

```text
d = sqrt((83-83)^2 + (81-81)^2 + (84-89)^2 + (80-80)^2 + (81-83)^2 + (85-93)^2)
d = sqrt(0 + 0 + 25 + 0 + 4 + 64)
d = sqrt(93)
d = 9.64
```

### Data 3: AJRA TUILHAM

```text
d = sqrt((83-72)^2 + (81-75)^2 + (84-77)^2 + (80-75)^2 + (81-82)^2 + (85-73)^2)
d = sqrt(121 + 36 + 49 + 25 + 1 + 144)
d = sqrt(376)
d = 19.39
```

### Data 4: ANDIKA SAPUTRA

```text
d = sqrt((83-84)^2 + (81-85)^2 + (84-85)^2 + (80-82)^2 + (81-84)^2 + (85-91)^2)
d = sqrt(1 + 16 + 1 + 4 + 9 + 36)
d = sqrt(67)
d = 8.19
```

### Data 5: ANNISA PUTRI FAUZIAH

```text
d = sqrt((83-83)^2 + (81-81)^2 + (84-85)^2 + (80-83)^2 + (81-83)^2 + (85-86)^2)
d = sqrt(0 + 0 + 1 + 9 + 4 + 1)
d = sqrt(15)
d = 3.87
```

### Data 6: AYUNDA WULANDARI

```text
d = sqrt((83-83)^2 + (81-82)^2 + (84-84)^2 + (80-85)^2 + (81-83)^2 + (85-92)^2)
d = sqrt(0 + 1 + 0 + 25 + 4 + 49)
d = sqrt(79)
d = 8.89
```

### Data 7: AZKA APRILLIO AMLI

```text
d = sqrt((83-83)^2 + (81-90)^2 + (84-84)^2 + (80-88)^2 + (81-84)^2 + (85-89)^2)
d = sqrt(0 + 81 + 0 + 64 + 9 + 16)
d = sqrt(170)
d = 13.04
```

### Data 8: AZZAHRA

```text
d = sqrt((83-82)^2 + (81-76)^2 + (84-83)^2 + (80-78)^2 + (81-85)^2 + (85-84)^2)
d = sqrt(1 + 25 + 1 + 4 + 16 + 1)
d = sqrt(48)
d = 6.93
```

### Data 9: AZZAHRA ADENG PRATIWI

```text
d = sqrt((83-83)^2 + (81-81)^2 + (84-85)^2 + (80-87)^2 + (81-83)^2 + (85-86)^2)
d = sqrt(0 + 0 + 1 + 49 + 4 + 1)
d = sqrt(55)
d = 7.42
```

### Data 10: AZZARIA THALITA ARYANDI

```text
d = sqrt((83-83)^2 + (81-83)^2 + (84-84)^2 + (80-83)^2 + (81-83)^2 + (85-84)^2)
d = sqrt(0 + 4 + 0 + 9 + 4 + 1)
d = sqrt(18)
d = 4.24
```

## 5. Hasil Pengurutan Jarak Terdekat

Setelah seluruh 32 data training dihitung jaraknya, data diurutkan dari jarak paling kecil ke paling besar. Karena nilai `K = 9`, maka 9 data terdekat adalah:

| No | Nama Siswa | Ekskul | Rank | Total Selisih Kuadrat | Jarak |
|---:|---|---|---:|---:|---:|
| 1 | MUTIA RAMADHANI | Voli | 21 | 9 | 3.00 |
| 2 | ANNISA PUTRI FAUZIAH | Voli | 20 | 15 | 3.87 |
| 3 | AZZARIA THALITA ARYANDI | Tahfiz | 19 | 18 | 4.24 |
| 4 | KIARA SALSABILLA | Voli | 25 | 21 | 4.58 |
| 5 | AZZAHRA | Tahfiz | 24 | 48 | 6.93 |
| 6 | AZZAHRA ADENG PRATIWI | Musik | 13 | 55 | 7.42 |
| 7 | FEBI ANISA PUTRI | Musik | 18 | 66 | 8.12 |
| 8 | ANDIKA SAPUTRA | Musik | 9 | 67 | 8.19 |
| 9 | SALSHA AMANDA PUTRI | Musik | 23 | 76 | 8.72 |

## 6. Voting K Tetangga Terdekat

Hasil voting dari 9 tetangga terdekat:

| Ekstrakurikuler | Jumlah Suara |
|---|---:|
| Musik | 4 |
| Voli | 3 |
| Tahfiz | 2 |

Karena ekstrakurikuler **Musik** memperoleh suara terbanyak, maka hasil rekomendasi sistem adalah:

```text
Rekomendasi Ekstrakurikuler = Musik
```

## 7. Kesimpulan Perhitungan

Berdasarkan perhitungan algoritma K-Nearest Neighbor menggunakan 6 atribut nilai akademik, yaitu MTK, IPA, IPS, Bahasa Indonesia, PJOK, dan Seni Budaya, sistem membandingkan data siswa uji dengan seluruh data training yang telah diimport dari Excel. Dengan nilai `K = 9`, mayoritas tetangga terdekat memiliki label ekstrakurikuler **Musik**, sehingga siswa direkomendasikan untuk mengikuti ekstrakurikuler **Musik**.

Catatan penting untuk laporan skripsi:

- Data training tidak dipilih dari siswa dengan rank tertinggi saja.
- Semua data training yang valid tetap dihitung jaraknya.
- Rank hanya menjadi informasi pendukung, bukan patokan utama dalam rumus Euclidean.
- Yang menjadi dasar rekomendasi adalah kedekatan nilai atribut siswa uji dengan nilai atribut siswa pada data training.
