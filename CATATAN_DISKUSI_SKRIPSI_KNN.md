# CATATAN DISKUSI DAN PERUBAHAN SISTEM REKOMENDASI EKSTRAKURIKULER (KNN)
**Tanggal:** 29 Juli 2026  
**Lokasi Project:** `f:\Laragon\skripsi_yu`

---

## 📌 Ringkasan Hasil Diskusi & Penyelesaian Tugas

### 1. Excel Perhitungan Manual K-NN
- **Nama File:** `Perhitungan_Manual_KNN_Ekstrakurikuler.xlsx`
- **Isi Worksheet:**
  1. `Data & Parameter`: Input data uji (Contoh: Abdi Wijaya, MTK=83, IPA=81, IPS=84, BINDO=80, PJOK=81, SBP=85, K=3) dan 32 Data Training.
  2. `Langkah 1 - Jarak Euclidean`: Perhitungan selisih kuadrat per atribut `(X - Y)^2`, total selisih kuadrat `=SUM(...)`, dan akar kuadrat Jarak Euclidean `=SQRT(...)`.
  3. `Langkah 2 - Ranking & Voting`: Pengurutan jarak dari terkecil, seleksi Top-K, rekapitulasi suara `=COUNTIF(...)`, dan penentuan rekomendasi otomatis `=INDEX(..., MATCH(MAX(...)))`.
  4. `Rekap Laporan KNN`: Rangkuman siap cetak/lampiran skripsi.

---

### 2. Penyederhanaan Aktor Sistem (Single-Actor: Admin)
- **Role Siswa Dihapuskan:** Seluruh portal dan hak akses khusus siswa diabaikan untuk menyederhanakan arsitektur sistem skripsi.
- **1 Aktor Utama:** **Admin / Pembina Ekstrakurikuler** memegang kendali penuh atas:
  - Import dan pengelolaan data latih (Excel/CSV).
  - Penginputan data uji nilai akademik siswa & slider parameter K.
  - Eksekusi algoritma K-NN dan verifikasi rincian matematis.
  - Riwayat kalkulasi dan pencetakan laporan PDF.

---

### 3. Perubahan Laporan PDF (`resources/views/laporan_pdf.blade.php`)
- **Tabel K-Tetangga Terdekat:** Menampilkan kolom **Ekstrakurikuler** pada laporan yang diakses/dicetak oleh Admin.
- **Pengesahan / Tanda Tangan:** Tanda tangan sebelah kanan (Pembina / Admin Ekstrakurikuler) diubah menjadi garis NIP formal:
  ```text
  Pesisir Selatan, [Tanggal]
  Pembina / Admin Ekstrakurikuler

  NIP. ........................................
  ```

---

### 4. Perbaikan Dokumen Skripsi Bab IV (`BAB_IV_ANALISA_DAN_PERANCANGAN.md`)
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

### 5. Perbaikan Tampilan Dashboard (`resources/views/knn.blade.php`)
- Membersihkan duplikasi tag HTML `<aside>` dan icon navigation yang sempat membuat layout sidebar berantakan.

---
*Catatan ini disimpan secara permanen di repositori project.*
