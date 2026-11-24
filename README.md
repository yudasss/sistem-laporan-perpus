# Sistem Informasi Pelaporan & Inventaris E-Perpustakaan Kampus

Aplikasi web berbasis **Laravel** untuk mengelola pelaporan inventaris koleksi buku perpustakaan, perhitungan nilai aset, filter kategori buku, serta export dokumen resmi ke format **PDF (DomPDF)** dan **Excel/CSV (UTF-8 BOM)**.

## Identitas Pengembang
- **Nama:** Yuda Prima
- **NIM:** 231011400727
- **Kelas:** 05TPLP017
- **Program Studi:** Teknik Informatika — Universitas Pamulang

## Fitur Utama
1. **Filter Dinamis:** Menyaring laporan koleksi buku berdasarkan kategori (*Pemrograman*, *Kecerdasan Buatan*, *Jaringan & Keamanan*).
2. **Export PDF Resmi:** Menghasilkan dokumen siap cetak lengkap dengan kop surat instansi, tanggal cetak, tabel rekapitulasi aset, dan kolom tanda tangan.
3. **Export Excel (CSV):** Menghasilkan file laporan tabular dengan dukungan *UTF-8 BOM* agar terbaca rapi di Microsoft Excel.
4. **Cetak Langsung (`@media print`):** Mencetak laporan langsung dari browser tanpa menyertakan tombol navigasi.

## Cara Menjalankan Proyek
1. Clone repositori ini: `git clone https://github.com/<username-kamu>/sistem-laporan-perpus.git`
2. Masuk ke folder proyek: `cd sistem-laporan-perpus`
3. Instal dependensi PHP: `composer install`
4. Salin konfigurasi environment: `cp .env.example .env`
5. Generate application key: `php artisan key:generate`
6. Jalankan server lokal: `php artisan serve`
7. Akses di browser: `http://127.0.0.1:8000/perpus-laporan`