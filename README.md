<p align="center"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></p>

# SIPEMAS (Sistem Pengaduan Masyarakat)

SIPEMAS adalah aplikasi berbasis web yang dirancang untuk memfasilitasi masyarakat dalam menyampaikan pengaduan, aspirasi, atau permintaan kepada pihak terkait secara online. Sistem ini dibangun dengan tujuan untuk meningkatkan transparansi dan responsivitas layanan publik.

Aplikasi ini dikembangkan menggunakan framework **Laravel** yang handal dan aman.

## 👨‍💻 Pembuat

- **Nama**: Zaki Muhamad
- **GitHub**: [mrzack18](https://github.com/mrzack18)

---

## 🚀 Fitur Utama

- **Dashboard Informatif**: Tampilan data statistik pengaduan yang mudah dipahami.
- **Manajemen Pengaduan**:
    - Masyarakat dapat membuat pengaduan baru dengan melampirkan bukti foto.
    - Petugas dapat memverifikasi dan menanggapi pengaduan.
- **Multi-Level User**:
    - **Admin**: Akses penuh ke seluruh sistem, manajemen user, dan laporan.
    - **Petugas (Staff)**: Menangani pengaduan masuk.
    - **Masyarakat**: Melaporkan dan memantau status pengaduan.
- **Laporan & Export**: Generate laporan pengaduan dalam format PDF atau Excel (jika fitur tersedia).
- **Notifikasi Real-time**: (Opsional: jika ada fitur ini) Pemberitahuan status pengaduan.

## 🛠️ Teknologi yang Digunakan

- **Backend**: Laravel 12.x
- **Frontend**: Blade Templating, Tailwind CSS / Bootstrap (sesuaikan jika perlu)
- **Database**: MySQL / SQLite
- **Bahasa**: PHP ^8.2

---

## ⚙️ Persyaratan Sistem

Sebelum menginstall, pastikan komputer Anda telah terinstall:

- **PHP** >= 8.2
- **Composer** (Manajer paket untuk PHP)
- **Node.js & NPM** (Untuk kompilasi aset frontend)
- **Database Server** (MySQL, MariaDB, atau SQLite)

---

## 📦 Langkah Instalasi

Ikuti langkah-langkah berikut untuk menjalankan aplikasi di komputer lokal Anda:

### 1. Clone Repository

Buka terminal atau command prompt, lalu jalankan perintah berikut:

```bash
git clone https://github.com/mrzack18/TB-PRAKADBO-SIPEMAS.git
cd TB-PRAKADBO-SIPEMAS
```

### 2. Install Dependencies

Install library PHP dan aset frontend yang dibutuhkan:

```bash
composer install
npm install
```

### 3. Konfigurasi Environment

Duplikat file konfigurasi `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```
*Atau jika menggunakan Windows Command Prompt:*
```cmd
copy .env.example .env
```

Buka file `.env` dan sesuaikan konfigurasi database Anda. Contoh jika menggunakan MySQL:

```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sipemas_db
DB_USERNAME=root
DB_PASSWORD=
```
*Pastikan Anda telah membuat database kosong dengan nama `sipemas_db` di database manager Anda.*

### 4. Generate Key & Migrasi Database

Generate application key dan jalankan migrasi database (termasuk seeder jika ada):

```bash
php artisan key:generate
php artisan migrate --seed
```

### 5. Compile Aset & Jalankan Server

Jalankan perintah berikut untuk meng-compile aset (CSS/JS) dan menjalankan server lokal:

```bash
npm run build
php artisan serve
```

Akses aplikasi melalui browser di alamat: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## 📄 Lisensi

Sistem ini open-sourced software di bawah lisensi [MIT license](https://opensource.org/licenses/MIT).
