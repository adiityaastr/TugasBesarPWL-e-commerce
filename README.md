<p align="center">
  <a href="#" target="_blank">
    <img src="public/images/herbamart-logo.svg" width="200" alt="Herbamart Logo">
  </a>
</p>

# Herbamart E-commerce

Herbamart adalah platform e-commerce yang dibangun menggunakan framework Laravel untuk penjualan produk herbal dan kesehatan. Aplikasi ini menyediakan fungsionalitas lengkap untuk toko online, termasuk manajemen produk, keranjang belanja, proses checkout, manajemen pesanan, dan panel admin yang komprehensif.

## Fitur Utama

### Fitur Pelanggan

-   **Otentikasi Pengguna:** Sistem registrasi, login, dan manajemen profil pengguna.
-   **Katalog Produk:**
    -   Menampilkan daftar produk dengan detail lengkap
    -   Filter produk berdasarkan kategori (multi-select)
    -   Sorting produk berdasarkan rating, harga (tertinggi/terendah), penjualan terbanyak, dan terbaru
    -   Pencarian produk
    -   Semua interaksi tanpa refresh halaman (AJAX)
-   **Keranjang Belanja:**
    -   Menambahkan produk ke keranjang tanpa redirect
    -   Notifikasi custom saat produk ditambahkan
    -   Update jumlah produk secara dinamis
    -   Hapus item dari keranjang
    -   Ringkasan belanja yang update real-time berdasarkan item yang dipilih
    -   Badge jumlah item di navbar
-   **Proses Checkout:**
    -   Manajemen alamat pengiriman
    -   Simpan alamat untuk penggunaan selanjutnya
    -   Edit alamat tersimpan
    -   Hapus alamat tersimpan
    -   Pilih metode pengiriman (Reguler, Kargo, Same Day)
    -   Pilih metode pembayaran (Transfer Bank, Kartu Kredit/Debit, COD)
    -   Notifikasi custom untuk semua aksi alamat
-   **Riwayat Pesanan:**
    -   Melihat detail pesanan lengkap
    -   Melacak status pesanan
    -   Mencetak invoice
    -   Menyelesaikan pesanan setelah menerima barang
    -   Mengajukan pembatalan pesanan
    -   Mengajukan komplain untuk pesanan yang selesai
-   **Ulasan Produk:** Memberikan rating dan ulasan untuk produk yang telah dibeli

### Fitur Admin

-   **Dashboard:**
    -   Statistik penjualan dan pendapatan
    -   Grafik pendapatan bulanan
    -   Produk terlaris
    -   Total pendapatan hanya dihitung dari pesanan yang selesai
-   **Manajemen Produk:**
    -   CRUD produk lengkap
    -   Upload gambar produk
    -   Manajemen stok
    -   Manajemen kategori
-   **Manajemen Pesanan:**
    -   Melihat semua pesanan pelanggan
    -   Update status pesanan (Proses, Pengemasan, Pengiriman, Sudah Sampai)
    -   Mencetak shipping label/resi untuk pengiriman
    -   Tidak dapat menyelesaikan pesanan (hanya pelanggan yang bisa)
    -   Order number dengan format random untuk keamanan
-   **Manajemen Komplain:**
    -   Melihat daftar komplain pelanggan
    -   Melihat detail komplain dengan foto bukti
    -   Update status komplain (Pending, In Progress, Resolved, Rejected)
    -   Menambahkan respons admin
-   **Laporan:** Laporan penjualan dan pendapatan

### Fitur Sistem

-   **Order Management:**
    -   Order number dengan format random alphanumeric (HM-XXXXXXXXXX)
    -   Status tracking lengkap
    -   Auto-complete order setelah 3 hari jika pelanggan tidak konfirmasi
    -   Auto-release payment setelah order selesai
-   **Address Management:**
    -   Simpan multiple alamat
    -   Set alamat default
    -   Edit alamat tersimpan
    -   Hapus alamat tersimpan
    -   Integrasi dengan API wilayah Indonesia untuk dropdown provinsi/kota/kecamatan/kelurahan
-   **User Experience:**
    -   Semua interaksi tanpa page refresh (AJAX)
    -   Notifikasi custom untuk semua aksi penting
    -   Modal konfirmasi untuk aksi destruktif
    -   Responsive design untuk mobile dan desktop
    -   Interactive login mascot dengan eye-tracking

## Teknologi yang Digunakan

-   **Backend:**
    -   PHP 8.2+
    -   Laravel 12
    -   MySQL/PostgreSQL
-   **Frontend:**
    -   Vite (Build tool)
    -   Tailwind CSS (Styling)
    -   Alpine.js (JavaScript framework)
    -   Vanilla JavaScript (AJAX, DOM manipulation)
-   **External APIs:**
    -   EMSIFA API Wilayah Indonesia (untuk data provinsi/kota/kecamatan/kelurahan)

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

9.  **Setup storage link (untuk gambar produk):**
    ```bash
    php artisan storage:link
    ```

## Menjalankan Aplikasi

1.  **Jalankan build asset frontend (Vite):**
    ```bash
    npm run dev
    ```
    Biarkan terminal ini tetap berjalan untuk development mode.

2.  **Jalankan server pengembangan Laravel:**
    Buka terminal baru dan jalankan perintah berikut:
    ```bash
    php artisan serve
    ```

3.  **Setup Scheduler (Opsional, untuk auto-complete order):**
    Untuk fitur auto-complete order setelah 3 hari, pastikan cron job sudah dikonfigurasi:
    ```bash
    * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
    ```

Aplikasi sekarang akan berjalan di `http://127.0.0.1:8000`.

### Build untuk Production

Jika ingin build untuk production:

```bash
npm run build
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Akun Default

Setelah menjalankan database seeder, Anda dapat login menggunakan akun berikut:

-   **Admin:**
    -   **Email:** `admin@example.com`
    -   **Password:** `password`
    -   **Akses:** Dashboard admin, manajemen produk, manajemen pesanan, manajemen komplain, laporan

-   **Customer:**
    -   **Email:** `user@example.com`
    -   **Password:** `password`
    -   **Akses:** Berbelanja, keranjang, checkout, riwayat pesanan, ulasan produk

## Struktur Fitur

### Alur Pembelian

1. **Browse Produk:** Pelanggan dapat melihat produk, filter berdasarkan kategori, dan sorting
2. **Tambah ke Keranjang:** Klik tombol "Keranjang" pada produk, muncul notifikasi sukses
3. **Checkout:** Pilih alamat pengiriman (atau tambah baru), pilih metode pengiriman dan pembayaran
4. **Pesanan:** Admin mengupdate status pesanan (Proses → Pengemasan → Pengiriman → Sudah Sampai)
5. **Konfirmasi:** Pelanggan menyelesaikan pesanan setelah menerima barang
6. **Selesai:** Payment otomatis direlease ke penjual, atau setelah 3 hari jika pelanggan tidak konfirmasi

### Status Pesanan

-   **proses:** Pesanan sedang diproses
-   **pengemasan:** Produk sedang dikemas
-   **pengiriman:** Produk sedang dalam perjalanan
-   **sudah_sampai:** Produk sudah sampai, menunggu konfirmasi pelanggan
-   **selesai:** Pesanan selesai, payment released
-   **pending_cancellation:** Menunggu konfirmasi pembatalan dari admin
-   **cancelled:** Pesanan dibatalkan

### Payment Status

-   **pending:** Menunggu pembayaran
-   **released:** Pembayaran sudah direlease ke penjual

## Catatan Penting

-   **Order Number:** Setiap pesanan memiliki order number unik dengan format `HM-XXXXXXXXXX` untuk keamanan
-   **Auto-Complete:** Pesanan dengan status "sudah_sampai" akan otomatis menjadi "selesai" setelah 3 hari jika pelanggan tidak mengkonfirmasi
-   **Address API:** Jika API wilayah Indonesia tidak tersedia, form akan otomatis menjadi input manual
-   **Storage:** Pastikan folder `storage/app/public` memiliki permission yang tepat untuk upload gambar

## Troubleshooting

### Gambar produk tidak muncul
- Pastikan `php artisan storage:link` sudah dijalankan
- Cek permission folder `storage/app/public`
- Pastikan `APP_URL` di `.env` sudah benar

### AJAX tidak bekerja
- Pastikan `npm run dev` sedang berjalan
- Cek console browser untuk error JavaScript
- Pastikan CSRF token tersedia di meta tag

### Scheduler tidak berjalan
- Pastikan cron job sudah dikonfigurasi di server
- Test dengan `php artisan schedule:run` secara manual
- Cek log Laravel untuk error

## Kontribusi

Jika Anda ingin berkontribusi pada proyek ini, silakan buat pull request atau buka issue untuk diskusi.

## Lisensi

Proyek ini dibuat untuk keperluan akademik (Tugas Besar Pemrograman Web Lanjut).