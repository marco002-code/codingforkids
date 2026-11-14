# Panduan Lengkap Deployment Laravel di HestiaCP
## Aplikasi: Coding for Kids & A.I. for Learning

Dokumen ini memandu langkah demi langkah cara meng-host dan menjalankan aplikasi pendaftaran event **Coding for Kids and A.I. for Learning** berbasis **Laravel** di server yang menggunakan **Hestia Control Panel (HestiaCP)**.

---

## 1. Persyaratan Server HestiaCP
* **OS:** Ubuntu 20.04/22.04/24.04 LTS atau Debian 11/12
* **Web Server:** Nginx + PHP-FPM atau Nginx (Reverse Proxy) + Apache2
* **Versi PHP:** PHP 8.2, 8.3, atau 8.4
* **Ekstensi PHP Wajib:** `pdo_mysql`, `pdo_sqlite`, `curl`, `mbstring`, `xml`, `bcmath`, `fileinfo`
* **Composer:** Composer v2.x terpasang di server
* **Database:** MariaDB / MySQL (atau SQLite tanpa perlu konfigurasi database server)

---

## 2. Langkah 1: Tambahkan Domain di HestiaCP
1. Masuk ke panel HestiaCP Anda (`https://ip-server:8083`).
2. Buat atau pilih **User** (misal: `dev` atau `admin`).
3. Masuk ke tab **WEB**, lalu klik **Add Web Domain** (`+`).
4. Masukkan nama domain/subdomain (misal: `event.codingforkids.id` atau `codingkids.domainanda.com`).
5. Centang opsi **Enable SSL for this domain** dan pilih **Use Let's Encrypt to obtain SSL** (pastikan domain sudah diarahkan ke IP server Anda melalui DNS A Record).
6. Klik **Save**.

---

## 3. Langkah 2: Mengunggah Source Code ke Server
Di HestiaCP, direktori web domain berada di:
```bash
/home/{USER}/web/{DOMAIN}/
```

Anda dapat mengunggah source code melalui **SSH (Git / rsync)** atau **File Manager HestiaCP**:

### Metode SSH / Git (Direkomendasikan):
```bash
# Masuk ke server via SSH
ssh user@ip-server

# Masuk ke folder web domain
cd /home/{USER}/web/{DOMAIN}

# Backup atau hapus folder public_html bawaan yang masih kosong
mv public_html public_html_bak

# Clone atau pindahkan folder project codingforkids
git clone https://github.com/username/codingforkids.git laravel_app
```

---

## 4. Langkah 3: Mengarahkan Document Root ke Folder `public`

Laravel membutuhkan folder `public/` sebagai Document Root. Di HestiaCP ada 2 cara yang dapat Anda pilih:

### Cara A: Menggunakan Symlink (Paling Mudah & Tanpa Perlu Root)
Jalankan perintah ini di SSH pada folder `/home/{USER}/web/{DOMAIN}/`:
```bash
ln -s /home/{USER}/web/{DOMAIN}/laravel_app/public /home/{USER}/web/{DOMAIN}/public_html
```
*Dengan cara ini, web server HestiaCP yang membaca `public_html` otomatis akan melayani folder `laravel_app/public`.*

### Cara B: Menggunakan Fitur Custom Document Root di HestiaCP (GUI)
1. Di panel HestiaCP, masuk ke menu **WEB**.
2. Klik tombol **Edit** (ikon pensil) pada domain Anda.
3. Klik **Advanced Options**.
4. Cari bagian **Custom document root**, aktifkan dan ubah path menjadi:
   ```text
   /home/{USER}/web/{DOMAIN}/public_html/public
   ```
5. Simpan pengaturan.

---

## 5. Langkah 4: Konfigurasi Database

### Pilihan 1: Menggunakan MySQL / MariaDB di HestiaCP (Standar Produksi)
1. Di HestiaCP, masuk ke menu **DB**.
2. Klik tombol **Add Database** (`+`).
3. Masukkan:
   - **Database Name:** `codingforkids` (akan menjadi `{USER}_codingforkids`)
   - **Database User:** `ckadmin` (akan menjadi `{USER}_ckadmin`)
   - **Password:** Masukkan password aman (misal: `Rahasia12345!`)
4. Buka file `.env` di folder project Anda, sesuaikan bagian database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE={USER}_codingforkids
   DB_USERNAME={USER}_ckadmin
   DB_PASSWORD=Rahasia12345!
   ```

### Pilihan 2: Menggunakan SQLite (Tanpa Perlu Setup MySQL)
Jika ingin sangat cepat tanpa konfigurasi database tambahan:
```env
DB_CONNECTION=sqlite
```
File database otomatis berada di `database/database.sqlite`.

---

## 6. Langkah 5: Menjalankan Script Deployment Otomatis

Aplikasi ini sudah dilengkapi dengan script `deploy.sh` khusus ekosistem HestiaCP.

Jalankan perintah berikut:
```bash
cd /home/{USER}/web/{DOMAIN}/laravel_app
bash hestiacp/deploy.sh
```

Script tersebut secara otomatis akan:
1. Menyiapkan file `.env` & `APP_KEY`.
2. Menjalankan `composer install --no-dev --optimize-autoloader`.
3. Menjalankan `php artisan migrate --force`.
4. Membersihkan & mengompilasi cache config, routes, dan views.
5. Membuat `storage:link`.
6. Menyetel hak akses (`chmod -R 775 storage bootstrap/cache`) agar tidak terjadi error *Permission Denied*.

### Seed Data Awal & Demo:
Untuk mengisi akun admin awal serta data simulasi peserta, jalankan:
```bash
php artisan db:seed
```

---

## 7. Langkah 6: Konfigurasi Nginx di HestiaCP

Jika server Anda menggunakan **Nginx Standalone (PHP-FPM)**, pastikan file konfigurasi domain mendukung *routing* Laravel (`try_files $uri $uri/ /index.php?$query_string;`).

Anda cukup menyalin template yang disediakan:
```bash
# Salin konfigurasi custom
cp hestiacp/nginx-laravel-custom.conf /home/{USER}/conf/web/{DOMAIN}/nginx.conf_custom
cp hestiacp/nginx-laravel-custom.conf /home/{USER}/conf/web/{DOMAIN}/nginx.ssl.conf_custom

# Restart Nginx
systemctl restart nginx
```

---

## 8. Langkah 7: Pengaturan Cron Job di HestiaCP

Agar tugas berkala Laravel (pembersihan session, antrean otomatis, dan reminder) berjalan otomatis:
1. Di panel HestiaCP, masuk ke menu **CRON**.
2. Klik **Add Cron Job** (`+`).
3. Masukkan perintah:
   ```bash
   /usr/bin/php /home/{USER}/web/{DOMAIN}/laravel_app/artisan schedule:run >> /dev/null 2>&1
   ```
4. Atur jadwal ke: **Every 1 minute** (`* * * * *`).
5. Klik **Save**.

---

## 9. Akun Default & Penggunaan Sistem

### Akses Pengguna Publik:
* **Landing Page & Pendaftaran:** `https://domain-anda.com/`
* **Cek Tiket / Status Pendaftaran:** Klik tombol **"Cek Tiket / Status"** di navigasi, atau buka link `https://domain-anda.com/ticket/{KODE_REGISTRASI}`.

### Portal Panitia (Admin Dashboard):
* **URL Login:** `https://domain-anda.com/admin/login`
* **Email Default:** `admin@codingforkids.id`
* **Password Default:** `admin12345`

### Fitur Utama Admin:
1. **Live Quota Management:** Kuota utama 50 kursi dan kuota cadangan 20 antrean dapat diubah sewaktu-waktu di menu **Pengaturan Kuota**.
2. **Promosi 1-Klik Cadangan ke Utama:** Jika ada peserta utama yang berhalangan, admin cukup mengklik **"Promosi ↑"** pada antrean cadangan teratas, lalu sistem menyediakan link instan ke WhatsApp orang tua dengan pesan otomatis yang rapi.
3. **Presensi Cepat Hari-H:** Masukkan kode registrasi (`AI26-XXX`) atau nama anak pada bar scanner di dashboard admin untuk absensi kedatangan instan.
4. **Export CSV:** Unduh rekap peserta untuk pencetakan sertifikat dan ID badge.

---

## 10. Troubleshooting Umum di HestiaCP

| Kendala | Penyebab | Solusi |
| :--- | :--- | :--- |
| **Error 500 / Blank White Page** | Permission folder `storage` belum writable oleh web server. | Jalankan `chmod -R 775 storage bootstrap/cache` dan pastikan group user adalah `www-data`. |
| **Halaman 404 saat klik tombol submit atau link tiket** | Nginx belum membaca rule `try_files` Laravel. | Pasang file `nginx-laravel-custom.conf` di `/home/{USER}/conf/web/{DOMAIN}/` lalu restart Nginx. |
| **Gambar atau asset tidak tampil** | Storage symlink belum dibuat. | Jalankan `php artisan storage:link`. |
| **SSL Certificate Error** | DNS domain belum selesai propagasi saat klik Let's Encrypt. | Pastikan DNS A record sudah mengarah ke IP VPS HestiaCP, lalu klik ulang "Issue Let's Encrypt" di HestiaCP. |
