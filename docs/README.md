# Dokumentasi Herbamart E-Commerce Platform

## Daftar Isi

Dokumentasi ini dibuat untuk keperluan bahan jurnal dan dokumentasi lengkap sistem e-commerce Herbamart. Dokumentasi ini mencakup semua aspek teknis dan fungsional dari aplikasi.

### Daftar Dokumentasi

1. **[Arsitektur Sistem](./01-ARSITEKTUR-SISTEM.md)** - Arsitektur, desain sistem, dan pola yang digunakan
2. **[Database Schema](./02-DATABASE-SCHEMA.md)** - Struktur database, relasi, dan ERD
3. **[Fitur dan Fungsionalitas](./03-FITUR-DAN-FUNGSIONALITAS.md)** - Dokumentasi lengkap semua fitur aplikasi
4. **[Routing dan API](./04-ROUTING-DAN-API.md)** - Daftar route, endpoint, dan alur request
5. **[Implementasi Teknis](./05-IMPLEMENTASI-TEKNIS.md)** - Detail implementasi, algoritma, dan logika bisnis
6. **[Instalasi dan Deployment](./06-INSTALASI-DAN-DEPLOYMENT.md)** - Panduan instalasi, konfigurasi, dan deployment
7. **[Testing](./07-TESTING.md)** - Strategi testing dan dokumentasi test case
8. **[User Guide](./08-USER-GUIDE.md)** - Panduan penggunaan untuk pengguna akhir
9. **[Admin Guide](./09-ADMIN-GUIDE.md)** - Panduan penggunaan untuk administrator

## Tentang Proyek

**Herbamart** adalah platform e-commerce yang dibangun menggunakan framework Laravel untuk penjualan produk herbal dan kesehatan. Aplikasi ini menyediakan fungsionalitas lengkap untuk toko online dengan sistem manajemen produk, keranjang belanja, proses checkout, manajemen pesanan, dan panel admin yang komprehensif.

## Teknologi yang Digunakan

### Backend
- **PHP 8.2+** - Bahasa pemrograman
- **Laravel 12** - Framework PHP
- **MySQL/PostgreSQL** - Database management system

### Frontend
- **Vite** - Build tool dan development server
- **Tailwind CSS 3.1** - Utility-first CSS framework
- **Alpine.js 3.4** - JavaScript framework untuk interaktivitas
- **Vanilla JavaScript** - AJAX, DOM manipulation, dan interaksi dinamis

### External Services
- **EMSIFA API Wilayah Indonesia** - API untuk data provinsi/kota/kecamatan/kelurahan

## Struktur Proyek

```
TugasBesarPWL-e-commerce/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # Controller untuk handling request
│   │   ├── Middleware/         # Custom middleware
│   │   └── Requests/           # Form request validation
│   ├── Models/                 # Eloquent models
│   ├── Providers/              # Service providers
│   └── View/                   # View components
├── database/
│   ├── migrations/             # Database migrations
│   └── seeders/                # Database seeders
├── resources/
│   ├── views/                  # Blade templates
│   ├── css/                    # Stylesheet
│   └── js/                     # JavaScript files
├── routes/                     # Route definitions
├── public/                     # Public assets
├── storage/                     # File storage
└── tests/                      # Test files
```

## Fitur Utama

### Fitur Pelanggan
- ✅ Sistem autentikasi lengkap (register, login, password reset)
- ✅ Katalog produk dengan filter dan sorting
- ✅ Keranjang belanja dinamis (AJAX)
- ✅ Checkout dengan manajemen alamat
- ✅ Riwayat pesanan dan tracking
- ✅ Sistem ulasan produk
- ✅ Komplain dan customer support

### Fitur Admin
- ✅ Dashboard dengan statistik dan grafik
- ✅ Manajemen produk (CRUD)
- ✅ Manajemen pesanan
- ✅ Manajemen komplain
- ✅ Laporan penjualan

## Kontributor

Proyek ini dibuat untuk keperluan akademik (Tugas Besar Pemrograman Web Lanjut).

## Lisensi

Proyek ini dibuat untuk keperluan akademik.

---

**Catatan**: Dokumentasi ini dibuat secara komprehensif untuk keperluan bahan jurnal. Setiap bagian didokumentasikan dengan detail untuk memudahkan pemahaman dan pengembangan lebih lanjut.
