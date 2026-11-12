# BUKU PANDUAN PENGGUNA (MANUAL BOOK)
## Platform Pemesanan Jasa Dokumentasi & Fotografi (LensCraft Studio)

---

## DAFTAR ISI
1. [Pendahuluan](#1-pendahuluan)
2. [Spesifikasi Sistem & Instalasi](#2-spesifikasi-sistem--instalasi)
3. [Daftar Akun & Hak Akses (Aktor Sistem)](#3-daftar-akun--hak-akses-aktor-sistem)
4. [Panduan Pengguna: Aktor Pelanggan (Customer)](#4-panduan-pengguna-aktor-pelanggan-customer)
   - [4.1 Registrasi & Masuk Akun](#41-registrasi--masuk-akun)
   - [4.2 Memilih Layanan Dokumentasi](#42-memilih-layanan-dokumentasi)
   - [4.3 Melakukan Pemesanan (Booking)](#43-melakukan-pemesanan-booking)
   - [4.4 Pembayaran Online (Payment Gateway)](#44-pembayaran-online-payment-gateway)
   - [4.5 Melihat & Mencetak Invoice](#45-melihat--mencetak-invoice)
   - [4.6 Memantau Riwayat Pesanan](#46-memantau-riwayat-pesanan)
5. [Panduan Pengguna: Aktor Admin & Super Admin](#5-panduan-pengguna-aktor-admin--super-admin)
   - [5.1 Mengakses Dasbor Admin](#51-mengakses-dasbor-admin)
   - [5.2 Manajemen Layanan / Paket Foto (CRUD)](#52-manajemen-layanan--paket-foto-crud)
   - [5.3 Manajemen Pesanan Pelanggan (CRUD)](#53-manajemen-pesanan-pelanggan-crud)
   - [5.4 Manajemen Pengguna & Peran Akses (CRUD)](#54-manajemen-pengguna--peran-akses-crud)
   - [5.5 Laporan Keuangan, Ekspor Excel, dan Cetak PDF](#55-laporan-keuangan-ekspor-excel-dan-cetak-pdf)
6. [Tanya Jawab & Penanganan Masalah (Troubleshooting)](#6-tanya-jawab--penanganan-masalah-troubleshooting)

---

## 1. Pendahuluan

**LensCraft Studio** adalah platform berbasis web modern yang dibangun untuk menyederhanakan proses pemesanan jasa dokumentasi visual profesional. Platform ini melayani 4 kategori utama:
1. **Foto Wisuda:** Dokumentasi kelulusan personal, bersama rekan, hingga paket wisuda keluarga besar.
2. **Foto Produk UMKM:** Foto katalog berlatar bersih (clean e-commerce) dan foto produk tematik kreatif F&B.
3. **Dokumentasi Acara:** Liputan seminar, gathering kantor, workshop, festival, hingga konferensi bisnis.
4. **Video Promosi:** Konten vertikal sinematik (Reels/TikTok) dan video profil perusahaan 4K (Company Profile).

### Fitur Kunci:
- **Katalog Interaktif:** Tampilan paket detail, durasi sesi, fasilitas, dan transparansi harga diskon.
- **Payment Gateway:** Integrasi simulasi multi-metode pembayaran (QRIS, BCA VA, Mandiri VA, BNI VA, Kartu Kredit).
- **Invoice Otomatis:** Pembuatan faktur digital langsung setelah transaksi, siap dicetak dalam format A4/PDF.
- **Panel CRUD Admin:** Pengelolaan menyeluruh terhadap data paket layanan, status pesanan, dan pengguna.
- **Laporan Finansial:** Laporan pendapatan berbasis rentang tanggal dengan fitur cetak PDF dan ekspor Microsoft Excel (.CSV).

---

## 2. Spesifikasi Sistem & Instalasi

### Spesifikasi Teknis:
* **Framework:** Laravel 12.x
* **Bahasa Pemrograman:** PHP 8.5 (Minimal PHP 8.4+)
* **Database:** MySQL 8.x (Laragon Local Database)
* **Frontend:** Tailwind CSS (Modern Responsive Layout) + Font Awesome 6 Icons
* **Web Server:** Apache / Nginx (Laragon) atau Laravel Built-in Server

### Menjalankan Aplikasi di Lokal (Laragon):
1. Buka aplikasi **Laragon** dan pastikan service **Apache** dan **MySQL** sudah dalam status *Running* (klik **Start All**).
2. Buka terminal (PowerShell atau Laragon Terminal), arahkan ke folder proyek:
   ```bash
   cd c:\laragon\www\JasaFotografi
   ```
3. Jalankan server aplikasi:
   ```bash
   php artisan serve
   ```
4. Buka peramban (browser) dan akses URL:
   * **`http://localhost:8000`** (jika menggunakan `php artisan serve`)
   * Atau **`http://jasafotografi.test`** (jika menggunakan virtual host bawaan Laragon)

---

## 3. Daftar Akun & Hak Akses (Aktor Sistem)

Platform mendukung 3 jenis peran pengguna dengan kredensial bawaan:

| Peran (Role) | Email | Password | Wewenang & Hak Akses |
|---|---|---|---|
| **Super Admin** | `superadmin@jasafotografi.com` | `password` | **Akses Penuh:** Mengelola data master, akun pengguna, paket layanan, pesanan, transaksi, dan laporan finansial studio. |
| **Admin / Mitra** | `admin@jasafotografi.com` | `password` | **Operasional:** Memantau dasbor analitik, memperbarui paket layanan, mengubah status pesanan pelanggan, dan mencetak laporan keuangan. |
| **Pelanggan** | `budi@example.com` | `password` | **Publik & Transaksi:** Menjelajahi katalog layanan, melakukan pemesanan (booking), membayar via simulasi payment gateway, mengunduh invoice, dan memantau status pesanan sendiri. |

---

## 4. Panduan Pengguna: Aktor Pelanggan (Customer)

### 4.1 Registrasi & Masuk Akun
1. Klik tombol **"Masuk"** di pojok kanan atas halaman utama.
2. Jika belum memiliki akun:
   - Klik tautan **"Daftar sekarang"** di bagian bawah form login (atau langsung akses `/register`).
   - Masukkan **Nama Lengkap**, **Alamat Email**, **Nomor WhatsApp**, dan **Kata Sandi** (minimal 6 karakter).
   - Klik **"Daftar Akun Baru"**. Sistem akan otomatis memasukkan Anda ke aplikasi.
3. Jika sudah memiliki akun:
   - Masukkan Email dan Password Anda di form `/login`.
   - Centang *"Ingat saya"* jika ingin sesi tetap aktif di peramban Anda.
   - Klik **"Masuk Sekarang"**.

### 4.2 Memilih Layanan Dokumentasi
1. Akses menu **"Katalog Layanan"** melalui navigasi atas.
2. Gunakan filter kategori di bagian atas:
   - *Semua Layanan*, *Foto Wisuda*, *Foto Produk UMKM*, *Dokumentasi Acara*, atau *Video Promosi*.
3. Klik tombol **"Lihat Detail Paket"** pada kartu layanan yang diinginkan untuk membaca:
   - Rincian deskripsi lengkap layanan.
   - Durasi sesi foto/video.
   - Daftar fasilitas yang didapatkan (format file, jumlah foto edit, penata gaya, drone, dsb).
   - Harga asli dan harga promo diskon.

### 4.3 Melakukan Pemesanan (Booking)
1. Klik tombol **"Pesan Sekarang"** pada paket yang dipilih.
2. Isi formulir pemesanan:
   - **Layanan Dipilih:** Pastikan nama paket sudah sesuai.
   - **Nama Lengkap & Kontak:** Otomatis terisi dari profil Anda (dapat diubah jika diperlukan).
   - **Tanggal Sesi:** Pilih tanggal pelaksanaan (harus hari ini atau tanggal mendatang).
   - **Waktu / Sesi Jam:** Tentukan rentang jam (misalnya `09:00 - 11:00 WIB`).
   - **Lokasi Pelaksanaan:** Cantumkan alamat studio, kampus, aula acara, atau lokasi outdoor.
   - **Catatan Tambahan:** Tulis permintaan khusus (contoh: *mohon bawa reflektor*, *konsep pakaian adat*, dsb).
   - **Metode Pembayaran:** Pilih metode pembayaran awal yang diinginkan.
3. Klik **"Konfirmasi & Lanjutkan Pembayaran"**.

### 4.4 Pembayaran Online (Payment Gateway)
1. Anda akan diarahkan ke halaman gerbang pembayaran (Payment Gateway).
2. Sistem menyajikan informasi ringkasan tagihan beserta instruksi pembayaran sesuai metode yang dipilih:
   - **QRIS:** Pindai kode QR dinamis yang muncul di layar.
   - **Virtual Account (BCA / Mandiri / BNI):** Nomor VA unik dan panduan transfer m-Banking/ATM.
   - **Kartu Kredit:** Nomor kartu simulasi standar perbankan.
3. Anda dapat mengganti metode pembayaran sebelum bayar dengan mengklik opsi metode lain di bawah tagihan.
4. Klik tombol hijau **"Simulasikan Bayar Lunas Sekarang"**.
5. Status pembayaran akan seketika berubah menjadi **LUNAS (PAID)** dan pesanan terkonfirmasi otomatis.

### 4.5 Melihat & Mencetak Invoice
1. Setelah pembayaran lunas, halaman akan otomatis dialihkan ke halaman **Faktur Resmi (Invoice)**.
2. Invoice menyajikan:
   - Nomor Invoice resmi (contoh: `INV-20261113-0001`).
   - Kode Transaksi Pembayaran (contoh: `TRX-...`).
   - Rincian identitas pemesan, tanggal, jam, dan lokasi sesi.
   - Rincian harga paket dan stempel status **LUNAS**.
3. Klik tombol **"Cetak Invoice (PDF)"** untuk mencetak fisik atau menyimpannya sebagai file PDF melalui dialog print browser (Ctrl + P).

### 4.6 Memantau Riwayat Pesanan
1. Klik menu **"Pesanan Saya"** di navigasi bar atas.
2. Anda akan melihat seluruh riwayat pesanan dengan badge status:
   - **Menunggu Pembayaran (Kuning):** Pesanan baru dibuat, belum dibayar.
   - **Terkonfirmasi (Biru):** Pembayaran telah lunas, jadwal terkunci.
   - **Sedang Diproses (Indigo):** Tim fotografer sedang persiapan / editing hasil foto.
   - **Selesai (Hijau):** Sesi dan penyerahan file foto telah rampung.
   - **Dibatalkan (Merah):** Pesanan dibatalkan.
3. Klik **"Rincian"** untuk melihat kembali invoice atau melanjutkan pembayaran yang tertunda.

---

## 5. Panduan Pengguna: Aktor Admin & Super Admin

### 5.1 Mengakses Dasbor Admin
1. Buka halaman `/login` dan gunakan akun Super Admin (`superadmin@jasafotografi.com`) atau Admin (`admin@jasafotografi.com`).
2. Setelah berhasil masuk, Anda akan langsung diarahkan ke **Panel Administrasi** (`/admin/dashboard`).
3. Pada Dasbor utama, Anda dapat memantau:
   - **Kartu Metrik KPI:** Total Pendapatan Lunas, Total Pesanan, Pesanan Aktif, dan Jumlah Layanan.
   - **Aktivitas Pesanan Terbaru:** Daftar pesanan paling baru beserta tombol aksi cepat.
   - **Status Breakdown:** Grafik persentase pesanan berdasarkan status operasional.

### 5.2 Manajemen Layanan / Paket Foto (CRUD)
Akses menu **"Kelola Layanan"** di sidebar:
1. **Melihat Data (Read):** Daftar seluruh paket foto/video, lengkap dengan harga, kategori, dan status aktif.
2. **Menambah Paket Baru (Create):**
   - Klik tombol **"Tambah Layanan Baru"**.
   - Masukkan *Nama Paket*, *Kategori*, *Harga Normal*, *Harga Diskon (Opsional)*, *Durasi*, dan *URL Foto Sampul*.
   - Masukkan *Fasilitas Paket* (pisahkan tiap poin fasilitas dengan baris baru).
   - Centang *Paket Populer* jika ingin disorot dengan badge rekomendasi di halaman depan.
   - Klik **"Simpan Layanan"**.
3. **Mengubah Paket (Update):**
   - Klik ikon pensil (Edit) pada baris layanan yang ingin diperbarui.
   - Modifikasi data yang diinginkan lalu klik **"Perbarui Layanan"**.
4. **Menonaktifkan / Mengaktifkan:**
   - Klik tombol **Aktif / Nonaktif** untuk menyembunyikan sementara layanan dari pelanggan tanpa menghapusnya.
5. **Menghapus Paket (Delete):**
   - Klik ikon tempat sampah (Hapus), lalu konfirmasi dialog browser.

### 5.3 Manajemen Pesanan Pelanggan (CRUD)
Akses menu **"Pesanan Masuk"** di sidebar:
1. **Filter Status:** Filter daftar pesanan berdasarkan status (*Semua, Menunggu Pembayaran, Terkonfirmasi, Sedang Diproses, Selesai, Dibatalkan*).
2. **Melihat Detail Pesanan:** Klik tombol detail pada pesanan untuk memeriksa alamat lokasi, nomor WhatsApp pemesan, catatan khusus, dan informasi transaksi gateway.
3. **Memperbarui Status Operasional:**
   - Ubah status pesanan secara berkala sesuai progres di lapangan:
     - Ubah ke **Sedang Diproses** saat sesi pemotretan berlangsung atau tahap retouching.
     - Ubah ke **Selesai** saat seluruh hasil foto/video sudah diserahkan ke klien.

### 5.4 Manajemen Pengguna & Peran Akses (CRUD)
Akses menu **"Kelola Pengguna"** di sidebar (Khusus Administrator):
1. **Melihat Daftar Pengguna:** Cari pengguna berdasarkan nama/email, atau filter berdasarkan peran (*Super Administrator, Admin / Mitra, Pelanggan*).
2. **Menambah Pengguna Baru:**
   - Klik **"Tambah Pengguna Baru"**.
   - Masukkan Nama, Email, Nomor Telepon, Alamat, dan Password.
   - Tentukan **Peran Akses (Role)**: pilih `Super Administrator`, `Administrator / Mitra`, atau `Pelanggan`.
3. **Mengedit Pengguna:**
   - Anda dapat memperbarui profil atau mengganti peran pengguna.
   - Password dapat dikosongkan jika tidak ingin diubah.
4. **Keamanan:** Akun yang sedang login tidak dapat menghapus dirinya sendiri demi mencegah hilangnya akses sistem.

### 5.5 Laporan Keuangan, Ekspor Excel, dan Cetak PDF
Akses menu **"Laporan Keuangan"** di sidebar:
1. **Filter Periode & Kriteria:**
   - Atur **Tanggal Mulai** dan **Tanggal Akhir**.
   - Filter berdasarkan **Kategori Layanan** atau **Status Pembayaran**.
   - Klik tombol **"Terapkan Filter"**.
2. **Menganalisis Angka Finansial:**
   - Total Omset Lunas (Rp).
   - Jumlah Transaksi Berhasil.
   - Rata-rata Nilai Transaksi (AOV).
   - Total Nominal Tagihan Belum Lunas.
   - Distribusi Pendapatan per Kategori Layanan.
3. **Ekspor ke Excel (.CSV):**
   - Klik tombol hijau **"Ekspor ke Excel (.csv)"**.
   - File berformat CSV UTF-BOM akan otomatis terunduh dan siap dibuka di Microsoft Excel dengan kolom-kolom rapi (Nomor, Invoice, Nama Pelanggan, Layanan, Tanggal Lunas, dan Nominal).
4. **Cetak Laporan PDF:**
   - Klik tombol biru **"Cetak Laporan (PDF)"**.
   - Halaman cetak laporan resmi dengan kop surat studio, tabel ringkasan, dan kolom tanda tangan pimpinan akan terbuka dalam format siap cetak/simpan PDF.

---

## 6. Tanya Jawab & Penanganan Masalah (Troubleshooting)

### Q: Apa yang harus dilakukan jika muncul error "SQLSTATE[HY000] [2002] Connection refused"?
> **Solusi:** Pastikan server MySQL di Laragon sudah dinyalakan (klik tombol **Start All** pada jendela Laragon). Pastikan juga port di file `.env` adalah `3306`.

### Q: Bagaimana jika pelanggan salah memilih metode pembayaran saat checkout?
> **Solusi:** Di halaman pembayaran (`/pembayaran/{id}`), pelanggan dapat langsung mengklik pilihan metode pembayaran lain di daftar bagian bawah tagihan. Sistem akan seketika memperbarui metode pembayaran tanpa perlu membatalkan pesanan.

### Q: Bagaimana cara mereset seluruh database ke kondisi awal (fresh install)?
> **Solusi:** Buka terminal dan jalankan:
> ```bash
> php artisan migrate:fresh --seed
> ```
> Perintah ini akan menyusun ulang seluruh tabel dan mengisi kembali akun default (Super Admin, Admin, Customer) beserta 8 paket layanan fotografi bawaan.

### Q: Apakah pelanggan bisa memesan jadwal sesi di hari yang sudah lewat?
> **Solusi:** Tidak bisa. Sistem validasi backend secara otomatis menolak tanggal pemesanan sebelum hari ini (`after_or_equal:today`) untuk mencegah salah input jadwal.

---

*Manual Book ini disusun untuk pengoperasian sistem LensCraft Studio versi 1.0.*
