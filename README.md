# Coding for Kids & A.I. for Learning
## Landing Page & Sistem Pendaftaran Event (Laravel + HestiaCP Ecosystem)
**Production URL:** [https://coding.muhijunior.id](https://coding.muhijunior.id)

Aplikasi web modern berbasis **Laravel 11/12** yang dirancang khusus untuk acara workshop edukasi teknologi anak SD kelas 6: **"Coding for Kids and A.I. for Learning"** (Senin, 21 Desember 2026).

Dilengkapi dengan sistem **manajemen kuota otomatis** (*Race-condition protected atomic transaction*) yang memisahkan pendaftar menjadi **Peserta Utama** (50 kursi) dan **Peserta Cadangan / Waitlist** (20 antrean), E-Ticket digital dengan barcode, serta Portal Admin Panitia lengkap dengan fitur presensi cepat hari-H, promosi antrean cadangan 1-klik, dan integrasi WhatsApp.

Aplikasi ini dioptimalkan khusus untuk kemudahan deployment di server panel **HestiaCP (Hestia Control Panel)**.

---

## 🌟 Fitur Utama Aplikasi

### 1. Sisi Pengunjung (Orang Tua & Siswa)
* **Landing Page Interaktif:**
  - Hero section dengan tanggal acara (Senin, 21 Desember 2026), lokasi kegiatan, dan kurikulum ramah anak.
  - **Live Quota Counter:** Indikator bar kapasitas kursi utama & antrean cadangan secara real-time.
  - Rundown kegiatan, 3 pilar materi (Coding Visual Scratch, Pengenalan AI, & AI for Learning), syarat peserta, dan FAQ interaktif.
* **Formulir Pendaftaran Terintegrasi (Atomic & Safe):**
  - Data Siswa: Nama lengkap, nama panggilan (untuk name tag), asal sekolah, jenis kelamin, pengalaman coding.
  - Data Orang Tua: Nama wali, nomor WhatsApp aktif, email, persetujuan syarat & ketentuan.
  - Alokasi otomatis: Jika kuota utama masih tersedia $\rightarrow$ **PESERTA UTAMA**. Jika kuota utama habis $\rightarrow$ **PESERTA CADANGAN (Nomor Urut #X)**.
* **E-Ticket Resmi (Printable & Shareable):**
  - Kode registrasi unik format `AI26-XXX` dengan barcode simulator.
  - Badge status pendaftaran (Hijau untuk Utama, Kuning/Oranye untuk Cadangan).
  - Tombol gabung grup WhatsApp koordinasi peserta & kontak hotline panitia.
  - Cetak atau simpan tiket ke format PDF dalam 1 klik (`window.print()`).
* **Pencarian Tiket / Cek Status:**
  - Orang tua dapat mengecek status pendaftaran kapan saja hanya dengan memasukkan kode registrasi atau nomor WhatsApp.

### 2. Sisi Panitia (Admin Dashboard)
* **Ringkasan Statistik Real-Time:** Total pendaftar, kapasitas kuota utama terpakai vs sisa, jumlah antrean cadangan, jumlah pembatalan, dan persentase kehadiran hari-H.
* **Presensi Cepat / Barcode Scanner:** Input kode registrasi atau nama siswa untuk check-in instan saat hari-H.
* **Tab Manajemen Peserta:**
  - Tab Peserta Utama (dengan tombol batalkan, toggle kehadiran, dan kirim pesan WA).
  - Tab Peserta Cadangan (diurutkan berdasarkan prioritas waktu pendaftaran, tombol promosi 1-klik).
  - Tab Dibatalkan (riwayat pembatalan dengan fitur pemulihan / restore).
* **Otomasi Promosi Antrean & Notifikasi WhatsApp:**
  - Saat ada kursi utama kosong, admin cukup klik tombol **Promosikan ke Utama**. Sistem otomatis mempromosikan antrean nomor teratas dan menyediakan link pesan WhatsApp siap kirim ke orang tua.
* **Export Data:** Unduh seluruh data pendaftar ke format `.csv` dengan UTF-8 BOM agar rapi saat dibuka di Microsoft Excel.
* **Pengaturan Kuota & Acara:** Sesuaikan batas kuota utama, kuota cadangan, status buka/tutup pendaftaran, link grup WhatsApp, dan detail acara langsung dari web GUI.

---

## 🚀 Panduan Menjalankan Secara Lokal

```bash
# 1. Clone repository
git clone <repo-url> codingforkids
cd codingforkids

# 2. Instalasi dependencies
composer install

# 3. Setup environment & database SQLite
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed

# 4. Jalankan server lokal
php artisan serve
```

Buka di browser:
- **Landing Page & Pendaftaran:** `http://localhost:8000`
- **Dashboard Admin:** `http://localhost:8000/admin/login`
  - **Email:** `admin@codingforkids.id`
  - **Password:** `admin12345`

---

## 🧪 Menjalankan Automated Tests

Aplikasi dilengkapi pengujian unit & fitur lengkap menggunakan PHPUnit:
```bash
php artisan test
```

---

## 🌐 Panduan Deployment di Ekosistem HestiaCP

Panduan lengkap mengenai:
- Penambahan Web Domain di HestiaCP
- Pengaturan Document Root & Symlink
- Setup Database MariaDB / MySQL vs SQLite
- Eksekusi script otomasi `hestiacp/deploy.sh`
- Konfigurasi Virtual Host Nginx & Apache
- Pengaturan Cron Job di HestiaCP

Dapat dilihat selengkapnya pada berkas:
👉 **[hestiacp/PANDUAN_DEPLOY_HESTIACP.md](file:///home/dev/PROJECT/codingforkids/hestiacp/PANDUAN_DEPLOY_HESTIACP.md)**
