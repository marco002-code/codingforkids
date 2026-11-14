# Rancangan Aplikasi: Landing Page & Sistem Pendaftaran Event
**Nama Kegiatan:** Coding for Kids and A.I. for Learning  
**Target Peserta:** Siswa SD Kelas 6  
**Waktu Pelaksanaan:** Senin, 21 Desember 2026  
**Biaya:** Gratis (Gratis dengan sistem Kuota Utama & Peserta Cadangan / *Waitlist*)

---

## 1. Gambaran Umum & Tujuan Sistem
Aplikasi berbasis web ini berfungsi sebagai pusat informasi (*landing page*) sekaligus gerbang pendaftaran otomatis untuk kegiatan edukasi teknologi bagi siswa SD kelas 6. Fitur utama dari sistem ini adalah **manajemen kuota otomatis**, di mana sistem secara *real-time* memisahkan pendaftar menjadi **Peserta Utama** dan **Peserta Cadangan (Waitlist)** apabila kuota utama telah penuh, tanpa perlu menutup formulir pendaftaran secara manual.

---

## 2. Alur Pengguna (*User Flow*)
1. **Pengunjung (Orang Tua/Wali)** membuka halaman utama (*Landing Page*).
2. Pengunjung membaca informasi acara, kurikulum singkat, jadwal, dan melihat **indikator sisa kuota utama** secara *real-time*.
3. Pengunjung mengklik tombol **"Daftar Sekarang"** (atau **"Daftar Antrean Cadangan"** jika kuota utama sudah $0$).
4. Pengunjung mengisi formulir pendaftaran dan menyetujui syarat & ketentuan (termasuk persetujuan publikasi dokumentasi anak).
5. **Sistem memproses data:**
   * Jika `Jumlah Peserta Utama < Kuota Maksimal` $\rightarrow$ Status pendaftar otomatis menjadi **PESERTA UTAMA**.
   * Jika `Jumlah Peserta Utama >= Kuota Maksimal` $\rightarrow$ Status pendaftar otomatis menjadi **PESERTA CADANGAN (Nomor Urut #X)**.
6. Pengunjung diarahkan ke halaman **Konfirmasi / E-Ticket** yang menampilkan status pendaftaran, nomor registrasi, dan tombol untuk bergabung ke Grup WhatsApp Koordinasi.

---

## 3. Struktur Halaman (*Landing Page Wireframe*)

### A. Hero Section (Bagian Atas)
* **Headline:** "Kenalkan Dunia Coding & Kecerdasan Buatan (A.I.) Sejak Dini!"
* **Sub-headline:** Workshop seru, interaktif, dan **100% GRATIS** khusus untuk siswa SD Kelas 6.
* **Badge Informasi Utama:** 
  * 📅 Senin, 21 Desember 2026
  * 📍 [Lokasi Kegiatan / Online via Zoom]
  * 🎟️ Gratis (Kuota Terbatas)
* **Live Quota Counter:** Bar progres visual (Contoh: *"Tersisa 12 dari 50 Kursi Utama!"* atau *"Kuota Utama Penuh — Pendaftaran Dialihkan ke Jalur Cadangan"*).
* **Call to Action (CTA):** Tombol besar **"Amankan Kursi Sekarang"**.

### B. Tentang Acara & Manfaat (Value Proposition)
* Penjelasan singkat mengapa siswa kelas 6 SD perlu mengenal logika *coding* dan pemanfaatan A.I. secara bijak untuk belajar (*A.I. for Learning*).
* **Poin Utama yang Dipelajari:**
  1. Logika dasar pemrograman visual (misal: Scratch / Blockly).
  2. Mengenal cara kerja A.I. dengan bahasa yang mudah dipahami anak.
  3. Praktik menggunakan A.I. sebagai asisten belajar yang positif dan kreatif.

### C. Rundown / Jadwal Kegiatan (Senin, 21 Desember 2026)
* **08.30 – 09.00:** Registrasi Ulang & Pembukaan
* **09.00 – 10.30:** Sesi 1: *Fun Coding for Kids* (Membuat Game/Animasi Sederhana)
* **10.30 – 10.45:** Istirahat (*Snack Time*)
* **10.45 – 12.00:** Sesi 2: *A.I. for Learning* (Belajar Cerdas dengan Bantuan A.I.)
* **12.00 – 12.30:** *Showcase* Karya Siswa, Pembagian Sertifikat, & Penutup

### D. Persyaratan Peserta
* Siswa aktif SD Kelas 6 (Tahun Ajaran 2026/2027).
* Membawa laptop pribadi dan *charger* (opsional: sesuaikan dengan fasilitas panitia).
* Didampingi atau mendapat izin dari orang tua/wali.

### E. Bagian Formulir Pendaftaran (*Embedded Form*)
* Diletakkan langsung di bagian bawah halaman agar orang tua tidak perlu berpindah halaman terlalu banyak.

### F. FAQ (Pertanyaan yang Sering Diajukan)
* *Apakah benar-benar gratis?*
* *Bagaimana sistem peserta cadangan bekerja?* (Menjelaskan bahwa peserta cadangan akan dihubungi H-2 jika ada peserta utama yang membatalkan kehadiran).
* *Apakah anak harus sudah bisa coding sebelumnya?*

---

## 4. Desain Formulir Pendaftaran
Karena target peserta adalah anak SD (usia ~11–12 tahun), formulir dirancang agar diisi oleh **Orang Tua/Wali** demi keakuratan data dan keamanan privasi anak.

### Data Siswa (Peserta)
1. **Nama Lengkap Siswa** *(Teks - Wajib)*
2. **Nama Panggilan** *(Teks - Wajib, untuk Name Tag)*
3. **Asal Sekolah (SD/MI)** *(Teks - Wajib)*
4. **Jenis Kelamin** *(Radio Button: Laki-laki / Perempuan)*
5. **Pengalaman Coding/Komputer** *(Pilihan: Belum Pernah / Pernah Sedikit / Sudah Terbiasa)*

### Data Orang Tua / Wali
6. **Nama Lengkap Orang Tua/Wali** *(Teks - Wajib)*
7. **Nomor WhatsApp Aktif** *(Angka/Telepon - Wajib, untuk pengiriman tiket & info cadangan)*
8. **Alamat Email** *(Email - Opsional/Wajib)*
9. **Persetujuan (Checkbox - Wajib):**
   * *"Saya menyatakan data yang diisi benar dan mengizinkan putra/putri saya mengikuti kegiatan ini."*
   * *"Saya memahami bahwa jika kuota utama penuh, pendaftar akan masuk ke daftar cadangan dan akan dihubungi panitia apabila terdapat kursi kosong."*

---

## 5. Logika Backend & Manajemen Kuota (Utama vs Cadangan)

### Variabel Pengaturan Admin
* `MAX_MAIN_QUOTA`: Contoh `50` (Batas peserta utama).
* `MAX_WAITLIST_QUOTA`: Contoh `20` (Batas peserta cadangan agar tidak terlalu menumpuk).
* `REGISTRATION_STATUS`: `OPEN` / `CLOSED`.

### Algoritma Penentuan Status Saat Submit
```text
MULAI Proses Pendaftaran
  HITUNG jumlah_utama = COUNT(peserta WHERE status == 'UTAMA' AND is_cancelled == FALSE)
  HITUNG jumlah_cadangan = COUNT(peserta WHERE status == 'CADANGAN' AND is_cancelled == FALSE)

  JIKA jumlah_utama < MAX_MAIN_QUOTA MAKA
      status_pendaftar = 'UTAMA'
      nomor_urut = jumlah_utama + 1
  LAIN JIKA jumlah_cadangan < MAX_WAITLIST_QUOTA MAKA
      status_pendaftar = 'CADANGAN'
      nomor_urut = jumlah_cadangan + 1
  LAINNYA
      TOLAK pendaftaran ("Mohon maaf, kuota utama dan cadangan telah penuh")
  AKHIR JIKA

  SIMPAN data ke Database
  KIRIM notifikasi konfirmasi (Halaman Sukses / WhatsApp / Email)
SELESAI
```

### Alur Promosi Peserta Cadangan ke Utama (Fitur Admin)
Apabila ada **Peserta Utama** yang mengonfirmasi tidak bisa hadir sebelum tanggal 21 Desember 2026:
1. Admin mengubah status peserta tersebut menjadi `DIBATALKAN`.
2. Sistem (atau Admin melalui 1 klik tombol **"Promosikan ke Utama"**) mengambil **Peserta Cadangan nomor urut teratas**.
3. Status peserta cadangan berubah menjadi `UTAMA`, dan sistem menyediakan tombol **"Kirim WA Pemberitahuan"** yang langsung membuka WhatsApp dengan *template* pesan otomatis kepada orang tua siswa tersebut.

---

## 6. Struktur Database (Skema Tabel)

### Tabel `participants` (Peserta)
| Nama Kolom | Tipe Data | Keterangan |
| :--- | :--- | :--- |
| `id` | INT / UUID | Primary Key |
| `reg_code` | VARCHAR(15) | Kode Unik (misal: `AI26-001`) |
| `student_name` | VARCHAR(100) | Nama lengkap siswa |
| `nickname` | VARCHAR(50) | Nama panggilan siswa |
| `school_name` | VARCHAR(100) | Asal SD |
| `gender` | ENUM | `L`, `P` |
| `experience_level` | VARCHAR(50) | Tingkat pengalaman komputer |
| `parent_name` | VARCHAR(100) | Nama orang tua/wali |
| `whatsapp` | VARCHAR(20) | Nomor WA orang tua |
| `status` | ENUM | `UTAMA`, `CADANGAN`, `DIBATALKAN` |
| `waitlist_order` | INT | Nomor urut jika statusnya `CADANGAN` (NULL jika `UTAMA`) |
| `is_attended` | BOOLEAN | Status kehadiran saat hari-H (Default: `FALSE`) |
| `created_at` | TIMESTAMP | Waktu mendaftar (penentu prioritas antrean) |

---

## 7. Fitur Halaman Admin (Dashboard Panitia)
1. **Ringkasan Statistik:** Total Pendaftar, Sisa Kuota Utama, Jumlah Peserta Cadangan, Jumlah Pembatalan.
2. **Tabel Data Peserta (Terpisah Tab):**
   * Tab 1: **Peserta Utama** (Dilengkapi tombol *Batalkan* jika berhalangan).
   * Tab 2: **Peserta Cadangan** (Diurutkan berdasarkan waktu daftar tercepat, dilengkapi tombol *Naikkan ke Utama*).
3. **Fitur Check-in Hari-H:** Pencarian cepat berdasarkan Nama Siswa atau Kode Registrasi (`AI26-XXX`) untuk absensi kedatangan pada Senin, 21 Desember 2026.
4. **Export Data:** Unduh data peserta ke format `.xlsx` (Excel) atau `.csv` untuk keperluan pencetakan sertifikat dan *name tag*.

---

## 8. Rekomendasi Teknologi (*Tech Stack*)
* **Opsi 1: Cepat & Modern (Custom Web App)**
  * **Frontend:** HTML5, Tailwind CSS, JavaScript / React (Next.js) — ringan dan responsif di HP orang tua.
  * **Backend & Database:** Supabase atau Firebase (memiliki fitur *real-time database* untuk menghitung kuota secara langsung tanpa bentrok saat banyak orang mendaftar bersamaan).
  * **Hosting:** Vercel atau Netlify (Gratis & cepat).
* **Opsi 2: Tanpa Coding / Low-Code (Alternatif Praktis)**
  * **Landing Page:** Carrd.co atau Google Sites.
  * **Form & Logika Kuota:** Tally.so atau Google Forms yang dihubungkan dengan Google Sheets + Apps Script untuk otomatisasi status Utama/Cadangan.