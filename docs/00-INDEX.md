# Index Dokumentasi Herbamart E-Commerce

## Daftar Isi Lengkap

Dokumentasi ini dibuat secara komprehensif untuk keperluan bahan jurnal. Setiap dokumen mencakup detail lengkap tentang aspek tertentu dari aplikasi.

### 📚 Dokumentasi Utama

#### 1. [README.md](./README.md)
   - Overview proyek
   - Daftar isi dokumentasi
   - Teknologi yang digunakan
   - Struktur proyek
   - Fitur utama

#### 2. [Arsitektur Sistem](./01-ARSITEKTUR-SISTEM.md)
   - Model arsitektur MVC
   - Layer architecture
   - Pola desain yang digunakan
   - Struktur direktori
   - Alur request-response
   - Authentication dan authorization
   - Data flow
   - Frontend architecture
   - Security architecture
   - Scalability considerations
   - Integration points
   - Error handling
   - Logging dan monitoring
   - Testing architecture
   - Deployment architecture

#### 3. [Database Schema](./02-DATABASE-SCHEMA.md)
   - Entity Relationship Diagram (ERD)
   - Tabel database lengkap:
     - users
     - products
     - carts
     - orders
     - order_items
     - addresses
     - reviews
     - complaints
   - Relasi database
   - Constraints dan validasi
   - Indexes
   - Data integrity rules
   - Migration history
   - Database seeding
   - Query optimization

#### 4. [Fitur dan Fungsionalitas](./03-FITUR-DAN-FUNGSIONALITAS.md)
   - Fitur autentikasi dan manajemen pengguna
   - Fitur katalog produk
   - Fitur keranjang belanja
   - Fitur checkout
   - Fitur manajemen alamat
   - Fitur manajemen pesanan
   - Fitur ulasan produk
   - Fitur komplain
   - Fitur admin - dashboard
   - Fitur admin - manajemen produk
   - Fitur admin - manajemen pesanan
   - Fitur admin - manajemen komplain
   - Fitur admin - laporan
   - Fitur sistem otomatis
   - Fitur UI/UX

#### 5. [Routing dan API](./04-ROUTING-DAN-API.md)
   - Route groups (Public, Authenticated, Admin)
   - Route definitions lengkap:
     - Public routes
     - Authentication routes
     - Customer routes
     - Admin routes
   - Middleware documentation
   - Route model binding
   - CSRF protection
   - Rate limiting
   - Response formats

#### 6. [Implementasi Teknis](./05-IMPLEMENTASI-TEKNIS.md)
   - Implementasi order processing
   - Order number generation
   - Cart management
   - Product filtering dan sorting
   - Address management
   - Stock management
   - AJAX operations
   - Order status management
   - Auto-complete order
   - File upload
   - Review system
   - Dashboard statistics
   - Security implementation
   - Error handling
   - Frontend interactivity
   - Query optimization

#### 7. [Instalasi dan Deployment](./06-INSTALASI-DAN-DEPLOYMENT.md)
   - Prasyarat
   - Instalasi development environment
   - Konfigurasi tambahan
   - Production deployment
   - Server setup
   - Nginx configuration
   - SSL certificate
   - Supervisor setup
   - Cron job setup
   - Troubleshooting
   - Backup dan restore
   - Update application
   - Monitoring
   - Security checklist

#### 8. [Testing](./07-TESTING.md)
   - Strategi testing
   - Setup testing environment
   - Test cases lengkap:
     - Authentication tests
     - Product tests
     - Cart tests
     - Order tests
     - Address tests
     - Review tests
     - Complaint tests
     - Admin tests
   - Manual testing checklist
   - Test data
   - Continuous integration
   - Bug reporting
   - Test coverage goals
   - Regression testing

#### 9. [User Guide](./08-USER-GUIDE.md)
   - Memulai (Registrasi, Login, Lupa Password)
   - Berbelanja (Melihat Produk, Filter, Sort, Detail)
   - Keranjang Belanja
   - Checkout
   - Manajemen Pesanan
   - Manajemen Alamat
   - Manajemen Profil
   - Tips dan Trik
   - FAQ

#### 10. [Admin Guide](./09-ADMIN-GUIDE.md)
   - Akses admin
   - Dashboard admin
   - Manajemen produk
   - Manajemen pesanan
   - Manajemen komplain
   - Laporan
   - Best practices
   - Troubleshooting
   - FAQ admin

## Quick Reference

### Untuk Developer
- **Memahami Arsitektur**: Baca [01-ARSITEKTUR-SISTEM.md](./01-ARSITEKTUR-SISTEM.md)
- **Memahami Database**: Baca [02-DATABASE-SCHEMA.md](./02-DATABASE-SCHEMA.md)
- **Memahami Routing**: Baca [04-ROUTING-DAN-API.md](./04-ROUTING-DAN-API.md)
- **Memahami Implementasi**: Baca [05-IMPLEMENTASI-TEKNIS.md](./05-IMPLEMENTASI-TEKNIS.md)
- **Setup Development**: Baca [06-INSTALASI-DAN-DEPLOYMENT.md](./06-INSTALASI-DAN-DEPLOYMENT.md)
- **Testing**: Baca [07-TESTING.md](./07-TESTING.md)

### Untuk User
- **Panduan Pengguna**: Baca [08-USER-GUIDE.md](./08-USER-GUIDE.md)

### Untuk Admin
- **Panduan Admin**: Baca [09-ADMIN-GUIDE.md](./09-ADMIN-GUIDE.md)

### Untuk Peneliti/Jurnal
- **Overview**: Baca [README.md](./README.md)
- **Arsitektur**: Baca [01-ARSITEKTUR-SISTEM.md](./01-ARSITEKTUR-SISTEM.md)
- **Database**: Baca [02-DATABASE-SCHEMA.md](./02-DATABASE-SCHEMA.md)
- **Fitur**: Baca [03-FITUR-DAN-FUNGSIONALITAS.md](./03-FITUR-DAN-FUNGSIONALITAS.md)
- **Implementasi**: Baca [05-IMPLEMENTASI-TEKNIS.md](./05-IMPLEMENTASI-TEKNIS.md)

## Struktur Dokumentasi

```
docs/
├── 00-INDEX.md                    # File ini - Index dan navigasi
├── README.md                       # Overview dan daftar isi
├── 01-ARSITEKTUR-SISTEM.md        # Arsitektur dan desain sistem
├── 02-DATABASE-SCHEMA.md          # Schema database lengkap
├── 03-FITUR-DAN-FUNGSIONALITAS.md  # Dokumentasi fitur
├── 04-ROUTING-DAN-API.md          # Routing dan endpoint
├── 05-IMPLEMENTASI-TEKNIS.md      # Detail implementasi teknis
├── 06-INSTALASI-DAN-DEPLOYMENT.md  # Panduan instalasi
├── 07-TESTING.md                  # Dokumentasi testing
├── 08-USER-GUIDE.md               # Panduan pengguna
└── 09-ADMIN-GUIDE.md              # Panduan administrator
```

## Informasi Proyek

**Nama Proyek**: Herbamart E-Commerce  
**Framework**: Laravel 12  
**PHP Version**: 8.2+  
**Database**: MySQL/PostgreSQL/SQLite  
**Frontend**: Tailwind CSS, Alpine.js, Vanilla JavaScript  
**Build Tool**: Vite  

## Kontribusi

Dokumentasi ini dibuat untuk keperluan akademik (Tugas Besar Pemrograman Web Lanjut). Setiap bagian didokumentasikan dengan detail untuk memudahkan pemahaman dan pengembangan lebih lanjut.

## Catatan Penting

1. **Untuk Jurnal**: Dokumentasi ini dapat digunakan sebagai referensi untuk penulisan jurnal. Setiap bagian mencakup detail teknis yang diperlukan.

2. **Untuk Development**: Dokumentasi ini dapat digunakan sebagai panduan untuk development dan maintenance aplikasi.

3. **Untuk User**: Panduan user dan admin dapat digunakan sebagai manual untuk pengguna aplikasi.

4. **Update**: Dokumentasi ini akan terus diupdate seiring dengan perkembangan aplikasi.

---

**Terakhir Diupdate**: Desember 2024  
**Versi Dokumentasi**: 1.0  
**Status**: Lengkap dan Siap Digunakan
