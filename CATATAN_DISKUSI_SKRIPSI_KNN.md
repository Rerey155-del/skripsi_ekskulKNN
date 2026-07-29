# CATATAN DISKUSI DAN PERUBAHAN SISTEM REKOMENDASI EKSTRAKURIKULER (KNN)
**Tanggal:** 29 Juli 2026  
**Lokasi Project:** `f:\Laragon\skripsi_yu`

---

## 📌 Ringkasan Hasil Diskusi & Penyelesaian Tugas

### 1. Excel & Word Perhitungan Manual K-NN
- **File Excel Perhitungan:** [`Perhitungan_Manual_KNN_Ekstrakurikuler.xlsx`](file:///f:/Laragon/skripsi_yu/Perhitungan_Manual_KNN_Ekstrakurikuler.xlsx)  
  Berisi 4 worksheet dinamis (`Data & Parameter`, `Langkah 1 - Jarak Euclidean`, `Langkah 2 - Ranking & Voting`, `Rekap Laporan KNN`).
- **File Word Laporan Bab IV (Revisi):** [`Tabel_4_10_Rekapitulasi_Hasil_Perhitungan_Jarak_Euclidean_Revisi.docx`](file:///f:/Laragon/skripsi_yu/Tabel_4_10_Rekapitulasi_Hasil_Perhitungan_Jarak_Euclidean_Revisi.docx)  
  Berisi pengantar kalimat yang sudah dikoreksi posisi dan urutannya, Tabel 4.9 (Data Uji), Tabel 4.10 (Rekapitulasi Jarak 32 Data), Tabel 4.11 (Pengurutan Jarak Terkecil Top-K), dan Kesimpulan Voting K-NN.

---

### 2. Alur Kalimat Narasi Bab IV (Perhitungan & Pengurutan Jarak)
- **Sebelum Tabel 4.10:**  
  *"Berdasarkan 32 kali perhitungan manual jarak Euclidean di atas, seluruh hasil perhitungan antara data uji (Abdi Wijaya) dengan masing-masing data latih dirangkum pada Tabel 4.10 berikut:"*
- **Sebelum Tabel 4.11 (Pengurutan Jarak):**  
  *"Berdasarkan hasil perhitungan pada Tabel 4.10 di atas, setiap data latih menghasilkan satu nilai jarak Euclidean. Nilai jarak tersebut kemudian diurutkan dari nilai terkecil sampai terbesar untuk menentukan tetangga terdekat pada proses K-Nearest Neighbors, sebagaimana ditunjukkan pada Tabel 4.11 berikut:"*

---

### 3. Penyederhanaan Aktor Sistem (Single-Actor: Admin)
- **Role Siswa Dihapuskan:** Seluruh portal dan hak akses khusus siswa diabaikan untuk menyederhanakan arsitektur sistem skripsi.
- **1 Aktor Utama:** **Admin / Pembina Ekstrakurikuler** memegang kendali penuh atas:
  - Import dan pengelolaan data latih (Excel/CSV).
  - Penginputan data uji nilai akademik siswa & slider parameter K.
  - Eksekusi algoritma K-NN dan verifikasi rincian matematis.
  - Riwayat kalkulasi dan pencetakan laporan PDF.

---

### 4. Perubahan Laporan PDF (`resources/views/laporan_pdf.blade.php`)
- **Tabel K-Tetangga Terdekat:** Menampilkan kolom **Ekstrakurikuler** pada laporan yang diakses/dicetak oleh Admin.
- **Pengesahan / Tanda Tangan:** Tanda tangan sebelah kanan (Pembina / Admin Ekstrakurikuler) diubah menjadi garis NIP formal:
  ```text
  Pesisir Selatan, [Tanggal]
  Pembina / Admin Ekstrakurikuler

  NIP. ........................................
  ```

---

### 5. Perbaikan Dokumen Skripsi Bab IV (`BAB_IV_ANALISA_DAN_PERANCANGAN.md`)
- **Tabel 4.13 (Definisi Actor):** Hanya berisi 1 Aktor (Admin / Pembina Ekstrakurikuler).
- **Tabel 4.14 (Deskripsi Use Case):** 7 Use Case terintegrasi untuk Admin.
- **Tabel 4.15 (Deskripsi Class Diagram):** Model & Controller terkait.
- **Tabel 4.16 (Collaboration Messages):** Alur interaksi Admin.
- **Tabel 4.17 (Deployment Nodes):** Elemen node fisik & software.
- **Diagram Mermaid UML Lengkap:** 
  - Use Case Diagram
  - Class Diagram
  - Sequence Diagram
  - Collaboration Diagram
  - Activity Diagram
  - Statechart Diagram
  - Deployment Diagram

---

### 6. Perbaikan Tampilan Dashboard (`resources/views/knn.blade.php`)
- Membersihkan duplikasi tag HTML `<aside>` pada layout sidebar navigasi kiri.

---
*Catatan ini disimpan secara permanen di repositori project.*
