<p align="center">
  <a href="#" target="_blank">
    <img src="public/images/herbamart-logo.svg" width="200" alt="Herbamart Logo">
  </a>
</p>

# Herbamart E-commerce

Ini adalah proyek e-commerce yang dibangun menggunakan framework Laravel. Aplikasi ini menyediakan fungsionalitas dasar toko online, termasuk manajemen produk, keranjang belanja, proses checkout, dan panel admin.

## Fitur Utama

-   **Otentikasi Pengguna:** Pengguna dapat mendaftar, login, dan mengelola profil mereka.
-   **Katalog Produk:** Menampilkan daftar produk dengan detail dan pencarian.
-   **Keranjang Belanja:** Pengguna dapat menambahkan produk ke keranjang belanja.
-   **Proses Checkout:** Proses pemesanan untuk membeli produk di keranjang.
-   **Riwayat Pesanan:** Pengguna dapat melihat riwayat pesanan mereka.
-   **Panel Admin:** Antarmuka terpisah untuk admin mengelola produk dan pesanan.
-   **Ulasan Produk:** Pengguna dapat memberikan ulasan untuk produk yang telah mereka beli.

## Teknologi yang Digunakan

-   **Backend:** PHP 8.2, Laravel 12
-   **Frontend:** Vite, Tailwind CSS, Alpine.js
-   **Database:** Kompatibel dengan MySQL, PostgreSQL, dll. (dikonfigurasi di `.env`)

## Panduan Instalasi

Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan lokal Anda.

### Prasyarat

-   PHP >= 8.2
-   Composer
-   Node.js & NPM
-   Database Server (misalnya MySQL)

### Langkah-langkah Instalasi

1.  **Clone repository:**
    ```bash
    git clone https://github.com/username/TugasBesarPWL-e-commerce.git
    cd TugasBesarPWL-e-commerce
    ```

2.  **Install dependensi PHP:**
    ```bash
    composer install
    ```

3.  **Install dependensi Node.js:**
    ```bash
    npm install
    ```

4.  **Buat file environment:**
    Salin file `.env.example` menjadi `.env`.
    ```bash
    cp .env.example .env
    ```

5.  **Generate kunci aplikasi:**
    ```bash
    php artisan key:generate
    ```

6.  **Konfigurasi database:**
    Buka file `.env` dan sesuaikan pengaturan koneksi database Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
    ```ini
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=herbamart
    DB_USERNAME=root
    DB_PASSWORD=
    ```

7.  **Jalankan migrasi database:**
    Perintah ini akan membuat semua tabel yang diperlukan dalam database Anda.
    ```bash
    php artisan migrate
    ```

8.  **Jalankan database seeder:**
    Perintah ini akan mengisi database dengan data awal, termasuk akun admin dan pengguna.
    ```bash
    php artisan db:seed
    ```

## Menjalankan Aplikasi

1.  **Jalankan build asset frontend (Vite):**
    ```bash
    npm run dev
    ```

2.  **Jalankan server pengembangan Laravel:**
    Buka terminal baru dan jalankan perintah berikut:
    ```bash
    php artisan serve
    ```

Aplikasi sekarang akan berjalan di `http://127.0.0.1:8000`.

## Akun Default

Setelah menjalankan database seeder, Anda dapat login menggunakan akun berikut:

-   **Admin:**
    -   **Email:** `admin@example.com`
    -   **Password:** `password`

-   **Customer:**
    -   **Email:** `user@example.com`
    -   **Password:** `password`