\# Aplikasi Blog CMS



\## Nama Mahasiswa



\*\*Nama Lengkap:\*\* Dimas Setia Adi

\*\*NIM:\*\* 240605110048



\---



\## Deskripsi Singkat Aplikasi



Aplikasi Blog CMS (Content Management System) merupakan sistem berbasis web yang digunakan untuk mengelola dan mempublikasikan artikel secara online. Sistem ini menyediakan beberapa hak akses pengguna, yaitu Admin, Penulis, dan Tamu.



Fitur utama yang tersedia pada aplikasi ini meliputi:



\* Autentikasi Login dan Register

\* Manajemen Artikel (CRUD)

\* Upload Gambar Artikel

\* Manajemen Kategori

\* Manajemen Profil Pengguna

\* Dashboard Admin dan Penulis

\* Pencarian Artikel

\* Halaman Detail Artikel

\* Sistem Hak Akses Berdasarkan Role

\* Tampilan Responsif dan User Friendly



Aplikasi dibangun menggunakan framework Laravel dengan konsep MVC (Model-View-Controller) dan database MySQL.



\---



\## Teknologi yang Digunakan



\* PHP 8

\* Laravel 12

\* MySQL

\* Bootstrap

\* JavaScript

\* HTML5 \& CSS3



\---



\## Langkah-Langkah Menjalankan Aplikasi Secara Lokal



\### 1. Clone Repository



```bash

git clone https://github.com/dimasadi30/aplikasi-blog-240605110048.git

```



\### 2. Masuk ke Folder Project



```bash

cd aplikasi-blog-240605110048

```



\### 3. Install Dependency



```bash

composer install

```



\### 4. Salin File Environment



```bash

cp .env.example .env

```



Atau pada Windows:



```bash

copy .env.example .env

```



\### 5. Generate Application Key



```bash

php artisan key:generate

```



\### 6. Konfigurasi Database



Buat database baru di MySQL, kemudian sesuaikan konfigurasi pada file `.env`:



```env

DB\_DATABASE=nama\_database

DB\_USERNAME=root

DB\_PASSWORD=

```



\### 7. Jalankan Migrasi Database



```bash

php artisan migrate

```



Jika menggunakan seeder:



```bash

php artisan migrate --seed

```



\### 8. Membuat Symbolic Link Storage



```bash

php artisan storage:link

```



\### 9. Menjalankan Server Laravel



```bash

php artisan serve

```



Aplikasi dapat diakses melalui:



```text

http://127.0.0.1:8000

```



\---



\## Tautan Video Demonstrasi



Video demonstrasi aplikasi dapat diakses melalui:



https://youtu.be/e-tFyU7y5Uo?si=jVhXTuyA-mBp0tJ1



\---



\## Struktur Role Pengguna



\### Admin



\* Mengelola seluruh artikel

\* Mengelola pengguna

\* Mengelola kategori

\* Mengakses dashboard admin



\### Penulis



\* Membuat artikel

\* Mengedit artikel sendiri

\* Menghapus artikel sendiri

\* Mengelola profil



\### Tamu



\* Melihat artikel yang dipublikasikan

\* Mencari artikel

\* Melihat detail artikel



\---



\## Lisensi



Proyek ini dibuat untuk keperluan tugas akademik dan pembelajaran.



