# BAB IV ANALISA DAN PERANCANGAN

## 4.1 Analisa

Bab ini membahas analisa data, analisa proses, dan evaluasi penerapan algoritma K-Nearest Neighbors pada sistem rekomendasi ekstrakurikuler berbasis Laravel dan MySQL.

### 4.1.1 Analisa Data

Data yang digunakan pada sistem ini berasal dari file Excel rekap nilai siswa yang telah diimport ke dalam database MySQL. Data training terdiri dari nilai siswa pada beberapa atribut yang menjadi dasar perhitungan rekomendasi, yaitu:

- Matematika
- IPA
- IPS
- Bahasa Indonesia
- PJOK
- Seni Budaya

Selain nilai akademik, setiap data training juga memiliki label ekstrakurikuler sebagai hasil klasifikasi, seperti Voli, Musik, Tahfiz, Basket, atau Tari.

Pada proses import, data lama pada tabel training dihapus terlebih dahulu agar data yang digunakan selalu sesuai dengan file terbaru yang diunggah. Dengan demikian, data training yang tersimpan di database merupakan data yang aktif digunakan pada perhitungan rekomendasi.

### 4.1.2 Analisa Proses

Sistem rekomendasi ekstrakurikuler bekerja melalui beberapa tahapan utama, yaitu preprocessing data training, perhitungan jarak Euclidean, pengurutan jarak terdekat, voting berdasarkan nilai K, dan penentuan hasil rekomendasi.

#### 4.1.2.1 Preprocessing

Tahap preprocessing dilakukan ketika file data training diunggah ke sistem. Sistem membaca file Excel atau CSV, mencari baris header, lalu mencocokkan nama kolom seperti `MTK`, `IPA`, `IPS`, `BINDO`, `PJOK`, `SBP`, `Rank`, dan `Ekskul`.

Data yang tidak lengkap atau tidak memiliki nama siswa dan label ekstrakurikuler akan diabaikan. Data valid kemudian disimpan ke tabel `knn_training_samples` di MySQL.

#### 4.1.2.2 Algoritma K-Nearest Neighbors

Algoritma K-Nearest Neighbors digunakan untuk mencari kelas atau label ekstrakurikuler berdasarkan kedekatan nilai siswa uji terhadap data training. Prinsip dasarnya adalah:

1. Menentukan satu data uji siswa.
2. Membandingkan data uji dengan seluruh data training.
3. Menghitung jarak antar data menggunakan Euclidean Distance.
4. Mengurutkan jarak dari yang paling kecil.
5. Mengambil `K` data terdekat.
6. Melakukan voting berdasarkan label ekstrakurikuler pada tetangga terdekat.

Label yang paling banyak muncul pada `K` tetangga terdekat menjadi hasil rekomendasi.

#### 4.1.2.3 Menentukan Nilai K

Nilai `K` adalah jumlah tetangga terdekat yang digunakan untuk menentukan hasil rekomendasi. Pada sistem ini, nilai `K` dapat diatur melalui input slider pada halaman prediksi siswa.

Pemilihan nilai `K` memengaruhi hasil rekomendasi:

- `K` kecil cenderung lebih sensitif terhadap data terdekat.
- `K` besar cenderung lebih stabil, tetapi dapat memperlebar pengaruh data yang lebih jauh.

Pada implementasi sistem, nilai `K` dibatasi agar tidak melebihi jumlah data training yang tersedia.

#### 4.1.2.4 Menghitung Jarak Euclidean Data Uji dan Data Training

Perhitungan jarak menggunakan enam atribut nilai siswa, yaitu Matematika, IPA, IPS, Bahasa Indonesia, PJOK, dan Seni Budaya.

Rumus jarak Euclidean yang digunakan adalah:

```text
d(x,y) = sqrt((MTKx - MTKy)^2 + (IPAx - IPAy)^2 + (IPSx - IPSy)^2 + (BINDOx - BINDOy)^2 + (PJOKx - PJOKy)^2 + (SBPx - SBPy)^2)
```

Keterangan:

- `x` adalah data uji siswa.
- `y` adalah data training.
- Semakin kecil hasil jarak, semakin mirip data training tersebut dengan data uji.

Dalam sistem, setiap data training dihitung satu per satu terhadap data uji. Hasil perhitungan juga ditampilkan pada modal agar pengguna dapat melihat langkah matematisnya.

#### 4.1.2.5 Mengurutkan Berdasarkan Jarak Euclidean

Setelah semua jarak dihitung, sistem mengurutkan data training berdasarkan jarak dari yang paling kecil ke yang paling besar. Jika terdapat jarak yang sama, sistem menggunakan nilai `Rank` sebagai pembanding tambahan untuk membantu pengurutan.

Setelah diurutkan, sistem mengambil sejumlah `K` data terdekat sebagai dasar voting.

#### 4.1.2.6 Evaluasi Model dengan Confusion Matrix

Evaluasi model dapat dilakukan dengan membandingkan hasil prediksi sistem terhadap label aktual pada data uji tertentu. Dari perbandingan tersebut dapat disusun confusion matrix untuk melihat performa sistem.

Jika data pengujian tersedia, maka evaluasi dapat menggunakan:

- True Positive
- True Negative
- False Positive
- False Negative

Dari confusion matrix tersebut dapat dihitung metrik evaluasi seperti:

- Akurasi
- Presisi
- Recall
- F1-Score

Namun pada implementasi utama sistem ini, evaluasi lebih difokuskan pada kesesuaian hasil rekomendasi dengan data training dan proses voting KNN.

## 4.2 Perancangan

Bagian perancangan menjelaskan model sistem, alur kerja, hubungan antar komponen, serta desain antarmuka yang digunakan pada aplikasi.

### 4.2.1 Perancangan Model

Perancangan model sistem dilakukan untuk menggambarkan alur kerja aplikasi mulai dari import data training, prediksi rekomendasi, hingga penyimpanan hasil prediksi.

#### 4.2.1.1 Use Case Diagram

Use case diagram menggambarkan interaksi aktor dengan sistem. Pada sistem ini terdapat dua aktor utama, yaitu admin dan siswa.

Admin berperan dalam pengelolaan data dan pemantauan hasil sistem, sedangkan siswa berperan sebagai pengguna data uji yang nilai akademiknya diproses untuk mendapatkan rekomendasi ekstrakurikuler.

Aktivitas admin meliputi:

- mengimport data training,
- melihat data training yang tersimpan,
- mengatur parameter `K`,
- melihat hasil rekomendasi dan riwayat prediksi,
- melihat langkah perhitungan matematis.

Aktivitas siswa meliputi:

- memasukkan nilai akademik sebagai data uji,
- menjalankan proses prediksi,
- melihat hasil rekomendasi,
- melihat langkah perhitungan matematis.

#### 4.2.1.2 Activity Diagram

Activity diagram menggambarkan alur aktivitas sistem secara berurutan. Alurnya dimulai dari upload file data training, penyimpanan ke database, pengisian data siswa uji, proses perhitungan KNN, pengurutan jarak, voting tetangga terdekat, dan menampilkan hasil rekomendasi.

#### 4.2.1.3 Sequence Diagram

Sequence diagram menggambarkan pertukaran pesan antara pengguna, controller, model, dan database. Saat admin mengirim data prediksi, controller akan mengambil data training dari database, menghitung jarak Euclidean, menentukan hasil rekomendasi, lalu menyimpan hasil ke tabel histori.

#### 4.2.1.4 Class Diagram

Class diagram pada sistem ini terdiri dari beberapa komponen utama:

- `KnnController` untuk mengelola proses import dan prediksi,
- `KnnTrainingSample` untuk menyimpan data training,
- `KnnPredictionHistory` untuk menyimpan histori prediksi.

Ketiga komponen tersebut saling berhubungan untuk mendukung proses rekomendasi.

#### 4.2.1.5 Collaboration Diagram

Collaboration diagram menunjukkan hubungan kerja antar objek dalam sistem. Objek utama bekerja secara terkoordinasi saat menerima data input, membaca data training, menghitung jarak, dan menghasilkan rekomendasi.

#### 4.2.1.6 State Chart Diagram

State chart diagram menjelaskan perubahan status data dalam sistem, misalnya:

- data training belum diimport,
- data training berhasil diimport,
- data prediksi sedang diproses,
- hasil rekomendasi berhasil disimpan,
- riwayat prediksi tersedia.

#### 4.2.1.7 Deployment Diagram

Deployment diagram menggambarkan penerapan sistem pada lingkungan kerja. Sistem dijalankan pada server Laravel, menggunakan database MySQL sebagai penyimpanan data, dan diakses melalui browser oleh admin atau guru.

### 4.2.2 Perancangan Interface

Perancangan interface dibuat agar pengguna mudah menggunakan sistem. Antarmuka utama pada aplikasi meliputi:

- halaman dashboard,
- halaman import data training,
- halaman prediksi siswa,
- halaman hasil rekomendasi,
- halaman riwayat prediksi,
- modal perhitungan matematis KNN.

Desain interface dibuat sederhana dan informatif agar pengguna dapat memahami proses rekomendasi dengan mudah. Pada halaman prediksi, pengguna hanya perlu mengisi nilai siswa, memilih parameter `K`, lalu sistem akan menampilkan hasil rekomendasi beserta langkah perhitungan matematisnya.

## 4.3 Ringkasan

Berdasarkan analisa dan perancangan yang dilakukan, sistem rekomendasi ekstrakurikuler telah disusun menggunakan metode K-Nearest Neighbors dengan data training dari Excel yang disimpan ke MySQL. Perhitungan dilakukan menggunakan enam atribut nilai siswa, kemudian hasilnya ditentukan melalui voting tetangga terdekat. Perancangan interface juga dibuat agar proses input, perhitungan, dan hasil rekomendasi dapat dipahami dengan jelas oleh pengguna.
