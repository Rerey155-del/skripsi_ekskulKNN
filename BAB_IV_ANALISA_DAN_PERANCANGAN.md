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

Perancangan sistem bertujuan menghasilkan gambaran detail dan lengkap yang mengakomodasi kebutuhan pengguna. Aspek output, input, dan file tercakup dalam desain ini, yang selanjutnya menjadi acuan pengembangan sistem baru guna mencapai hasil optimal.

### 4.2.1 Perancangan Model

Aplikasi rekomendasi ekstrakurikuler siswa menggunakan metode K-Nearest Neighbor (KNN) ini dirancang menggunakan Unified Modelling Language (UML). UML berperan sebagai alat bantu utama dalam memvisualisasikan struktur, interaksi, dan alur kerja aplikasi melalui serangkaian diagram. Pemanfaatan konsep-konsep UML ini bertujuan memastikan kejelasan, kohesivitas, dan pemahaman mendalam terhadap sistem yang dibangun. Berikut ini adalah perancangan aplikasi yang digambarkan dalam bentuk diagram-diagram UML.

#### 4.2.1.1 Use Case Diagram

Use case diagram digunakan untuk menggambarkan fitur-fitur yang ada dalam sistem dan bagaimana pengguna berinteraksi dengan sistem tersebut. Diagram ini menunjukkan aktivitas-aktivitas yang terjadi dalam sistem serta hubungan antara aktor yang terlibat.

##### A. Definisi Actor dan Deskripsinya
Aktor adalah entitas yang berinteraksi dengan sistem. Pada perancangan sistem rekomendasi ekstrakurikuler menggunakan algoritma K-Nearest Neighbor (KNN) ini hanya terdapat **1 aktor utama**, yaitu **Admin / Pembina Ekstrakurikuler**.

**Tabel 4.13 Definisi Actor**
| No | Nama Aktor | Deskripsi |
|---|---|---|
| 1. | Admin / Pembina Ekstrakurikuler | Pengelola sistem yang memiliki hak akses penuh untuk melakukan login, mengelola data training (unggah file Excel/CSV), mengatur parameter nilai K, memasukkan data nilai uji siswa, menjalankan algoritma K-Nearest Neighbor untuk proses rekomendasi ekstrakurikuler, melihat detail langkah perhitungan matematis (Jarak Euclidean & Voting), serta melihat riwayat dan mencetak laporan rekomendasi (PDF). |

##### B. Definisi Use Case Diagram dalam Sistem
Berikut adalah deskripsi use case yang terdapat dalam sistem:

**Tabel 4.14 Tabel Deskripsi Use Case**
| No | Use Case | Deskripsi | Aktor |
|---|---|---|---|
| 1 | Login | Proses autentikasi Admin untuk masuk ke dalam sistem. | Admin |
| 2 | Kelola Data Training | Proses Admin mengunggah (upload) file Excel (.xlsx/.csv) berisi data historis siswa beserta label ekstrakurikuler sebagai referensi algoritma KNN. | Admin |
| 3 | Lihat Data Training | Proses Admin melihat daftar seluruh data training yang tersimpan di database MySQL, mencakup nama siswa, nilai akademik 6 mapel, rank, dan label ekstrakurikuler. | Admin |
| 4 | Atur Parameter K | Proses Admin menentukan nilai K (jumlah tetangga terdekat) sebagai parameter utama dalam proses klasifikasi KNN melalui slider. | Admin |
| 5 | Prediksi KNN | Proses sistem menjalankan algoritma K-NN untuk menghitung jarak Euclidean antara data uji dan seluruh data training, mengurutkan jarak, mengambil K tetangga terdekat, dan menentukan rekomendasi ekstrakurikuler melalui voting suara mayoritas. | Admin |
| 6 | Lihat Detail Perhitungan | Proses melihat rincian langkah matematis KNN secara transparan, meliputi nilai selisih kuadrat tiap atribut, total jarak Euclidean, serta penghitungan suara voting setiap tetangga terdekat. | Admin |
| 7 | Lihat Riwayat & Cetak PDF | Proses Admin melihat seluruh histori hasil rekomendasi yang pernah dijalankan serta mencetak laporan rekapitulasi / lembar hasil rekomendasi siswa (PDF). | Admin |

Pada Use Case Diagram ini menggambarkan interaksi antara aktor tunggal (Admin / Pembina Ekstrakurikuler) dengan seluruh fungsionalitas sistem. Diagram ini mengilustrasikan secara visual bahwa Admin bertindak sebagai pengelola sistem yang memiliki akses ke seluruh fungsi, mulai dari pengelolaan data training, penginputan data uji siswa, pengaturan parameter K, eksekusi kalkulasi algoritma K-NN, verifikasi detail matematis, hingga pencetakan laporan rekomendasi.

#### 4.2.1.2 Class Diagram

Class diagram menggambarkan suatu sistem dari segi pendefinisian kelas yang akan dibuat untuk membangun sistem dan juga menjelaskan bagaimana hubungan antar kelas. 

**Tabel 4.15 Tabel Deskripsi Class Diagram**
| No | Nama Class | Deskripsi |
|---|---|---|
| 1 | User (Model) | Entity class yang merepresentasikan data akun Admin dalam basis data MySQL untuk kebutuhan autentikasi dan manajemen sesi. |
| 2 | KnnTrainingSample (Model) | Entity class yang mengelola dataset latih di dalam database MySQL, menyimpan riwayat profil akademik siswa (nilai Matematika, IPA, IPS, Bahasa Indonesia, PJOK, Seni Budaya, Rank) beserta label ekstrakurikuler. |
| 3 | KnnPredictionHistory (Model) | Entity class yang mencatat log/riwayat setiap kalkulasi rekomendasi yang dilakukan oleh sistem, menyimpan parameter K yang dipilih, rincian tetangga terdekat, dan keputusan rekomendasi akhir. |
| 4 | KnnController (Controller) | Control class utama yang mengatur aliran data antarmuka, memproses unggahan dataset Excel/CSV (import), memproses parameter K, serta mengkalkulasi jarak Euclidean dan voting keputusan algoritma KNN. |
| 5 | AuthController (Controller) | Control class yang menangani fungsi keamanan dasar sistem, meliputi login, autentikasi sesi, dan logout. |

#### 4.2.1.3 Sequence Diagram

Sequence diagram digunakan untuk menggambarkan interaksi antar objek atau komponen sistem yang disusun secara kronologis berdasarkan urutan waktu. Sequence Diagram memvisualisasikan alur komunikasi data antara aktor (Admin / Pembina Ekstrakurikuler), antarmuka sistem (UI Dashboard), controller (KnnController), serta basis data MySQL. Diagram ini memberikan gambaran mendalam mengenai operasional sistem dalam memproses data, mulai dari pengunggahan data training (dataset Excel/CSV), penginputan data uji, kalkulasi jarak Euclidean dan voting tetangga terdekat, hingga mekanisme pencetakan laporan hasil rekomendasi ekstrakurikuler siswa.

#### 4.2.1.4 Collaboration Diagram

Collaboration diagram (atau Communication diagram) digunakan untuk memberikan gambaran mengenai organisasi objek yang berinteraksi dalam sistem dan urutan pesan (message) yang dikirimkan secara kronologis untuk mencapai tujuan tertentu. Pada sistem rekomendasi ini, diagram ini menunjukkan kolaborasi terstruktur antara antarmuka pengguna (UI Dashboard), logika kontrol (KnnController), dan entitas data (KnnTrainingSample & KnnPredictionHistory) di database MySQL untuk aktor Admin.

**Tabel 4.16 Tabel Definisi Pesan Collaboration Diagram**
| No | Objek Pengirim | Objek Penerima | Deskripsi Interaksi |
|---|---|---|---|
| 1.1 | Admin / Pembina | UI Dashboard | Admin mengunggah file dataset training (.xlsx/.csv) atau memasukkan data nilai uji siswa dan parameter K. |
| 1.2 | UI Dashboard | KnnController | Mengirimkan data input dan parameter K untuk diproses lebih lanjut oleh controller (`predict`). |
| 1.3 | KnnController | KnnTrainingSample | Melakukan query dataset latih dari MySQL untuk proses pencarian tetangga terdekat. |
| 1.4 | KnnTrainingSample | KnnController | Mengembalikan himpunan data latih yang aktif di MySQL (32 data). |
| 1.5 | KnnController | KnnController | Menjalankan fungsi kalkulasi jarak Euclidean dan voting K tetangga terdekat secara lokal (`distanceBreakdown`). |
| 1.6 | KnnController | KnnPredictionHistory | Menyimpan log riwayat kalkulasi data uji beserta hasil akhir rekomendasi ekstrakurikuler (`create`). |
| 1.7 | KnnController | UI Dashboard | Mengirimkan hasil akhir keputusan rekomendasi dan rincian selisih hitung jarak. |
| 1.8 | UI Dashboard | Admin / Pembina | Menampilkan keputusan rekomendasi ekstrakurikuler dan detail matematis di layar dasbor admin serta opsi cetak PDF. |

#### 4.2.1.5 Activity Diagram

Activity diagram menggambarkan alur aktivitas sistem yang dipicu oleh aktor Admin maupun respon dari sistem itu sendiri. Alurnya dimulai dari autentikasi login Admin, pengunggahan data training (dataset Excel/CSV), penginputan data uji nilai akademik siswa, pengaturan slider parameter K, kalkulasi jarak Euclidean dan voting tetangga terdekat, menampilkan modal rincian matematis, hingga pencetakan laporan hasil rekomendasi ekstrakurikuler.

#### 4.2.1.6 Statechart Diagram

Statechart diagram (State Machine Diagram) menggambarkan siklus hidup dari objek-objek dalam sistem serta transisi status yang dialami sistem berdasarkan event atau kejadian (event/trigger) tertentu. Pada sistem rekomendasi ekstrakurikuler berbasis algoritma K-Nearest Neighbor (KNN), diagram ini memetakan perubahan status sistem saat melayani operasional Admin / Pembina Ekstrakurikuler (seperti proses autentikasi login, pengunggahan dan preprocessing dataset latih, penentuan parameter K, kalkulasi matematis Jarak Euclidean dan voting K-NN, serta pencetakan laporan rekomendasi PDF).

#### 4.2.1.7 Deployment Diagram

Deployment diagram menggambarkan konfigurasi fisik dari elemen-elemen sistem yang aktif saat runtime, serta pemetaan perangkat lunak (aplikasi) ke dalam infrastruktur perangkat keras yang digunakan. Diagram ini menunjukkan bagaimana komponen sistem rekomendasi ekstrakurikuler didistribusikan dalam jaringan komputer serta jalur komunikasi yang menghubungkan antar-perangkat keras tersebut. 

Untuk memperjelas infrastruktur yang digunakan, berikut adalah rincian elemen pendukung dalam tabel definisi deployment:

**Tabel 4.17 Definisi Elemen Deployment Diagram**
| Kategori Node | Nama Node | Deskripsi |
|---|---|---|
| Device | Client PC | Perangkat keras (laptop/PC) yang digunakan oleh Admin / Pembina Ekstrakurikuler untuk mengakses antarmuka sistem melalui jaringan. |
| Execution Environment | Web Server | Lingkungan server aplikasi (seperti Apache/Laragon di lokal atau Web Server di produksi) yang menjalankan runtime PHP dan mengelola logika routing sistem Laravel. |
| Database Server | MySQL Server | Perangkat server basis data yang menyimpan data operasional sistem pada basis data `skripsi_yu` (data training, user admin, dan log riwayat prediksi). |
| Artifact | Web Browser | Perangkat lunak penjelajah (Google Chrome, Firefox, Edge) pada client yang merender halaman antarmuka berbasis Laravel Blade (HTML, CSS, JS). |
| Artifact | KNN Calculation Engine | Komponen perangkat lunak Laravel (`KnnController`) yang melakukan pemrosesan logika perhitungan jarak Euclidean dan voting tetangga terdekat di server. |
| Communication Path | HTTP / TCP-IP | Protokol komunikasi yang digunakan untuk mengirim data masukan dari client ke server dan mengembalikan hasil antarmuka rekomendasi. |
| Communication Path | PDO Connection | Jalur komunikasi internal untuk transfer kueri database (SQL) antara server aplikasi (Laravel) dan server database (MySQL). |

### 4.2.2 Perancangan Interface

Perancangan interface dibuat agar pengguna mudah menggunakan sistem. Antarmuka utama pada aplikasi meliputi:
- halaman dashboard admin,
- halaman import data training,
- halaman prediksi data uji siswa,
- halaman hasil rekomendasi & modal rincian kalkulasi matematis,
- halaman riwayat prediksi & cetak laporan PDF.

## 4.3 Ringkasan

Berdasarkan analisa dan perancangan yang dilakukan, sistem rekomendasi ekstrakurikuler telah disusun menggunakan metode K-Nearest Neighbors dengan data training dari Excel yang disimpan ke MySQL. Perhitungan dilakukan menggunakan enam atribut nilai siswa, kemudian hasilnya ditentukan melalui voting tetangga terdekat oleh aktor tunggal (Admin / Pembina Ekstrakurikuler). Perancangan interface juga dibuat agar proses input, perhitungan, dan hasil rekomendasi dapat dipahami dengan jelas dan transparan.
