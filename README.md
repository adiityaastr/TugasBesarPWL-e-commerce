# HerbaMart E-Commerce (Laravel)

Toko daring produk herbal (jamu, madu, minyak atsiri, suplemen, aromaterapi) dengan pemisahan peran penjual/pembeli, checkout beralamat dinamis (wilayah Indonesia), laporan penjualan, dan alur status pesanan hingga rilis pembayaran.

## Fitur Utama
- **Tema HerbaMart**: branding hijau, logo, ikon sosial.
- **Katalog & Filter**:
  - Multi-kategori (checkbox pills) dengan ikon per kategori.
  - Sort: terbaru, harga tertinggi/terendah, penjualan terbanyak, rating (jika kolom tersedia).
  - AJAX tanpa reload untuk filter/sort/paginasi/tambah keranjang.
- **Keranjang & Beli Langsung**: tombol tambah keranjang dan beli langsung; badge keranjang diperbarui via AJAX.
- **Checkout**:
  - Alamat detail (provinsi/kota/kecamatan/kelurahan/kode pos) via API wilayah; fallback manual saat gagal.
  - Pilihan metode pengiriman dengan ongkir.
  - Pembayaran disimulasikan (payment_status awal: `pending`).
- **Pesanan Pembeli**:
  - Status: proses → pengemasan → pengiriman → sudah_sampai → selesai; pembatalan (pending_cancellation → cancelled).
  - Konfirmasi “Selesaikan pesanan” muncul setelah status “sudah_sampai”; rilis pembayaran ke penjual.
  - Invoice dan label resi dapat dicetak.
- **Admin/Penjual**:
  - Manajemen produk, pesanan, laporan penjualan, grafik (Chart.js).
  - Update status, cetak resi, lihat permintaan pembatalan.
  - Total pendapatan hanya dari pesanan `selesai`.
- **Order Number**: format acak `HM-XXXXXXXXXX` per pesanan.
- **Scheduler**: auto-release pembayaran setelah `sudah_sampai` > 3 hari (set ke `selesai`, payment_status `released`).
- **Role-based access**: admin diarahkan ke dashboard, pembeli ke katalog/home; admin tidak bisa checkout.

## Prasyarat
- PHP 8.1+ dan Composer
- Node.js 16+ dan npm
- MySQL/MariaDB

## Setup & Jalankan
1. Kloning repo dan masuk ke direktori.
2. Install dependency backend:
   ```bash
   composer install
   ```
3. Install dependency frontend:
   ```bash
   npm install
   ```
4. Salin env:
   ```bash
   cp .env.example .env
   ```
5. Set koneksi database di `.env`, lalu generate key:
   ```bash
   php artisan key:generate
   ```
6. Migrasi + seed (termasuk kategori & sample produk herbal):
   ```bash
   php artisan migrate --seed
   ```
7. Build asset (dev server atau production):
   ```bash
   npm run dev   # atau npm run build
   ```
8. Jalankan server:
   ```bash
   php artisan serve
   ```
9. (Opsional, untuk auto-release 3 hari) Jalankan scheduler:
   ```bash
   php artisan schedule:work
   ```
   atau set cron: `* * * * * php /path/to/artisan schedule:run`.

## Alur Status & Pembayaran
- Admin/penjual dapat set status hingga `sudah_sampai`.
- Pembeli menekan “Selesaikan Pesanan” (status `selesai`, `payment_status=released`).
- Jika pembeli tidak menekan, scheduler otomatis set `selesai` + release setelah 3 hari di status `sudah_sampai`.
- Pesanan `selesai` atau `payment_status=released` tidak dapat diubah lagi oleh penjual.

## Endpoint Penting
- Pembeli: `/` katalog, `/cart`, `/checkout`, `/orders`, `/orders/{order}`, `/orders/{order}/invoice`.
- Admin: `/admin`, `/admin/products`, `/admin/orders`, `/admin/orders/{order}/label`, `/admin/reports`.

## Catatan Teknis
- `order_number` disimpan di kolom `orders.order_number` (unik).
- `payment_status` default `pending`, dirilis (`released`) saat pesanan selesai atau auto-release.
- Filter/sort/paginasi/tambah keranjang memakai fetch dengan `X-Requested-With: XMLHttpRequest`.
- Revenue di dashboard/laporan hanya dari pesanan `selesai`.

## Akun & Seed
- Seeder membuat user & sample produk herbal (lihat `database/seeders/UserSeeder.php`, `ProductSeeder.php`, `CategorySeeder.php`). Sesuaikan credential di seeder jika perlu.

## Lisensi
Internal/project-based. Sesuaikan sesuai kebutuhan.*** End Patch*** End Patch ***!
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
