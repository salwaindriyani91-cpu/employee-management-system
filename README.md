<div align="center">

# 👥 EMS Portal
### Employee Management System

Aplikasi web modern untuk mengelola data karyawan, departemen, dan laporan perusahaan — dengan dashboard terpisah untuk Admin dan Karyawan.

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=flat&logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?style=flat&logo=laravel&logoColor=white)
![Tailwind](https://img.shields.io/badge/TailwindCSS-4-06B6D4?style=flat&logo=tailwindcss&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-7-646CFF?style=flat&logo=vite&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-green)

</div>

---

## ✨ Fitur Utama

### 🛠️ Untuk Admin
| Fitur | Deskripsi |
|---|---|
| 📊 **Dashboard** | Ringkasan total karyawan, karyawan aktif, karyawan baru, dan karyawan cuti |
| 👤 **Manajemen Karyawan** | Tambah, cari, dan filter data karyawan berdasarkan departemen, status, dan jenis kelamin |
| 🏢 **Manajemen Departemen** | Kelola daftar departemen beserta jumlah karyawan di masing-masing departemen |
| 📈 **Laporan** | Statistik karyawan per departemen, status (aktif/nonaktif/cuti), dan jenis kelamin |
| 🔄 **Impor / Ekspor Data** | Upload data karyawan lewat CSV atau unduh data dalam format CSV |
| ⚙️ **Pengaturan Akun** | Ubah profil dan password admin |

### 👤 Untuk Karyawan
| Fitur | Deskripsi |
|---|---|
| 📊 **Dashboard** | Ringkasan informasi akun dan menu cepat |
| 🔍 **Cari Rekan Kerja** | Direktori karyawan untuk mencari data rekan kerja (read-only) |
| 💰 **Slip Gaji** | Lihat slip gaji pribadi per periode (read-only) |
| 📇 **Data Diri** | Lihat data kepegawaian dan edit data pribadi (no. telepon, alamat) |
| ⚙️ **Pengaturan Akun** | Ubah profil dan password karyawan |

### 🔐 Keamanan Akses
- Login terpisah untuk **Admin** dan **Karyawan**
- Karyawan hanya bisa melihat data miliknya sendiri (read-only)
- Data kepegawaian (NIP, departemen, jabatan) hanya bisa diubah oleh Admin

---

## 📸 Tampilan Aplikasi

<details open>
<summary><b>🔑 Autentikasi</b></summary>
<br>

**Login**
![Login](picture/login.png.png)

</details>

<details open>
<summary><b>🛠️ Panel Admin</b></summary>
<br>

**Dashboard**
![Dashboard Admin](picture/dashboard-admin.png.png)

**Data Karyawan**
![Data Karyawan](picture/data-karyawan.png.png)

**Departemen**
![Departemen](picture/departemen.png.png)

**Laporan**
![Laporan](picture/laporan.png.png)

**Impor / Ekspor**
![Impor Ekspor](picture/impor-ekspor.png.png)

**Pengaturan Akun**
![Pengaturan Admin](picture/pengaturan-admin.png.png)

</details>

<details open>
<summary><b>👤 Panel Karyawan</b></summary>
<br>

**Dashboard**
![Dashboard Karyawan](picture/dashboard-karyawan.png.png)

**Cari Rekan Kerja**
![Cari Rekan Kerja](picture/cari-rekan-kerja.png.png)

**Slip Gaji**
![Slip Gaji](picture/slip-gaji.png.png)

**Data Diri**
![Data Diri](picture/data-diri.png.png)

**Pengaturan Akun**
![Pengaturan Karyawan](picture/pengaturan-karyawan.png.png)

</details>

---

## 🛠️ Tech Stack

- **Backend:** Laravel 12 (PHP 8.2)
- **Frontend:** Tailwind CSS 4, Vite 7
- **Database:** MySQL

---

## 🚀 Instalasi

```bash
# Clone repository
git clone https://github.com/salwaindriyani91-cpu/employee-management-system.git
cd employee-management-system

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Migrasi database
php artisan migrate

# Jalankan aplikasi
composer run dev
```

---

## 👩‍💻 Author

Dibuat dengan 💙 oleh **Salwa Indriyani**

[![GitHub](https://img.shields.io/badge/GitHub-salwaindriyani91--cpu-181717?style=flat&logo=github)](https://github.com/salwaindriyani91-cpu)

<div align="center">

⭐ Jangan lupa kasih star kalau project ini bermanfaat!

</div>
