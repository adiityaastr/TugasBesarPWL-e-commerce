# Fitur dan Fungsionalitas Herbamart E-Commerce

## 1. Pendahuluan

Dokumen ini menjelaskan secara detail semua fitur dan fungsionalitas yang tersedia dalam aplikasi Herbamart E-Commerce, baik untuk pengguna customer maupun administrator.

## 2. Fitur Autentikasi dan Manajemen Pengguna

### 2.1 Registrasi Pengguna

**Deskripsi**: Sistem registrasi untuk pengguna baru.

**Fitur:**
- Form registrasi dengan validasi
- Input: name, username, email, password, password confirmation
- Validasi email unik
- Password hashing dengan bcrypt
- Auto login setelah registrasi
- Email verification (opsional)

**Alur:**
1. User mengisi form registrasi
2. Validasi input
3. Cek email unik
4. Hash password
5. Simpan user dengan role 'customer'
6. Auto login
7. Redirect ke dashboard

**File Terkait:**
- `app/Http/Controllers/Auth/RegisteredUserController.php`
- `resources/views/auth/register.blade.php`

### 2.2 Login

**Deskripsi**: Sistem login untuk pengguna terdaftar.

**Fitur:**
- Form login dengan email/username dan password
- Remember me functionality
- Session management
- Redirect berdasarkan role (customer → home, admin → admin dashboard)
- Interactive login mascot dengan eye-tracking

**Alur:**
1. User memasukkan kredensial
2. Validasi input
3. Cek kredensial di database
4. Verifikasi password
5. Create session
6. Redirect berdasarkan role

**File Terkait:**
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php`
- `resources/views/auth/login.blade.php`

### 2.3 Logout

**Deskripsi**: Sistem logout untuk mengakhiri session.

**Fitur:**
- Logout dengan menghapus session
- Redirect ke halaman login

### 2.4 Password Reset

**Deskripsi**: Sistem reset password untuk pengguna yang lupa password.

**Fitur:**
- Request password reset dengan email
- Token generation
- Email dengan link reset password
- Form reset password dengan token
- Validasi token
- Update password baru

**Alur:**
1. User request password reset
2. Generate token
3. Kirim email dengan link reset
4. User klik link dan masuk form reset
5. Validasi token
6. Update password
7. Redirect ke login

**File Terkait:**
- `app/Http/Controllers/Auth/PasswordResetLinkController.php`
- `app/Http/Controllers/Auth/NewPasswordController.php`

### 2.5 Manajemen Profil

**Deskripsi**: Pengguna dapat mengelola profil mereka.

**Fitur:**
- Update informasi profil (name, username, full_name)
- Upload foto profil
- Update password
- Hapus akun

**File Terkait:**
- `app/Http/Controllers/ProfileController.php`
- `resources/views/profile/edit.blade.php`

## 3. Fitur Katalog Produk

### 3.1 Daftar Produk

**Deskripsi**: Halaman utama menampilkan daftar produk dengan berbagai opsi filter dan sorting.

**Fitur:**
- Pagination (12 produk per halaman)
- Filter berdasarkan kategori (multi-select)
- Sorting berdasarkan:
  - Terbaru (default)
  - Rating tertinggi
  - Harga terendah
  - Harga tertinggi
  - Penjualan terbanyak
- Pencarian produk (jika diimplementasikan)
- AJAX untuk filter dan sorting (tanpa refresh)
- Responsive grid layout

**Alur:**
1. User membuka halaman produk
2. Sistem menampilkan produk dengan pagination
3. User memilih filter/sorting
4. AJAX request ke server
5. Update tampilan tanpa refresh

**File Terkait:**
- `app/Http/Controllers/ProductController.php::index()`
- `resources/views/products/index.blade.php`

### 3.2 Detail Produk

**Deskripsi**: Halaman detail produk dengan informasi lengkap.

**Fitur:**
- Informasi produk lengkap (nama, deskripsi, harga, stok, kategori)
- Gambar produk
- Tombol "Tambah ke Keranjang"
- Form quantity
- Validasi stok
- AJAX untuk menambah ke keranjang
- Notifikasi sukses/error
- Ulasan produk (jika ada)

**Alur:**
1. User membuka detail produk
2. User memilih quantity
3. User klik "Tambah ke Keranjang"
4. AJAX request
5. Validasi stok
6. Tambah ke cart
7. Update badge cart
8. Show notification

**File Terkait:**
- `app/Http/Controllers/ProductController.php::show()`
- `resources/views/products/show.blade.php`

## 4. Fitur Keranjang Belanja

### 4.1 Menampilkan Keranjang

**Deskripsi**: Halaman keranjang menampilkan semua item yang ditambahkan.

**Fitur:**
- Daftar item di keranjang
- Informasi produk (nama, gambar, harga)
- Quantity per item
- Subtotal per item
- Total keseluruhan
- Update quantity
- Hapus item
- Tombol checkout
- AJAX untuk semua operasi
- Real-time update total

**File Terkait:**
- `app/Http/Controllers/CartController.php::index()`
- `resources/views/cart/index.blade.php`

### 4.2 Menambah Item ke Keranjang

**Deskripsi**: Menambahkan produk ke keranjang.

**Fitur:**
- Validasi stok
- Jika produk sudah ada, tambah quantity
- Jika produk belum ada, buat cart item baru
- Update badge cart di navbar
- Notifikasi sukses
- AJAX implementation (no page refresh)

**Alur:**
1. User klik "Tambah ke Keranjang"
2. AJAX POST request
3. Validasi stok
4. Cek apakah produk sudah ada di cart
5. Update atau create cart item
6. Return JSON response
7. Update UI (badge, notification)

**File Terkait:**
- `app/Http/Controllers/CartController.php::store()`

### 4.3 Update Quantity

**Deskripsi**: Mengubah jumlah item di keranjang.

**Fitur:**
- Update quantity dengan input number
- Validasi stok tersedia
- Real-time update subtotal
- Real-time update total
- AJAX implementation

**File Terkait:**
- `app/Http/Controllers/CartController.php::update()`

### 4.4 Hapus Item dari Keranjang

**Deskripsi**: Menghapus item dari keranjang.

**Fitur:**
- Konfirmasi sebelum hapus (modal)
- Hapus item dari database
- Update total
- Update badge cart
- AJAX implementation

**File Terkait:**
- `app/Http/Controllers/CartController.php::destroy()`

## 5. Fitur Checkout

### 5.1 Halaman Checkout

**Deskripsi**: Halaman checkout untuk menyelesaikan pembelian.

**Fitur:**
- Ringkasan item yang dibeli
- Pilih alamat pengiriman:
  - Gunakan alamat tersimpan
  - Tambah alamat baru
  - Edit alamat tersimpan
- Form alamat dengan dropdown provinsi/kota/kecamatan/kelurahan (API)
- Pilih metode pengiriman:
  - Reguler (Rp 15.000)
  - Kargo (Rp 10.000)
  - Same Day (Rp 30.000)
- Pilih metode pembayaran:
  - Transfer Bank
  - Kartu Kredit/Debit
  - COD
- Ringkasan total (subtotal + shipping)
- Tombol "Buat Pesanan"

**File Terkait:**
- `app/Http/Controllers/OrderController.php::create()`
- `resources/views/checkout/index.blade.php`

### 5.2 Proses Checkout

**Deskripsi**: Memproses pembuatan pesanan dari keranjang.

**Fitur:**
- Validasi cart tidak kosong
- Validasi alamat
- Validasi stok semua produk
- Hitung total harga
- Hitung biaya pengiriman
- Create order dengan order number unik
- Create order items
- Decrement stock produk
- Clear cart
- Transaction management (rollback jika error)
- Redirect ke detail pesanan

**Alur:**
1. User klik "Buat Pesanan"
2. Validasi semua input
3. Begin transaction
4. Cek stok semua produk
5. Lock produk untuk update (prevent race condition)
6. Decrement stock
7. Create order
8. Create order items
9. Clear cart
10. Commit transaction
11. Redirect ke detail order

**File Terkait:**
- `app/Http/Controllers/OrderController.php::store()`

## 6. Fitur Manajemen Alamat

### 6.1 Menyimpan Alamat

**Deskripsi**: Menyimpan alamat pengiriman untuk penggunaan selanjutnya.

**Fitur:**
- Form alamat lengkap
- Integrasi dengan API wilayah Indonesia
- Set alamat default
- Validasi input
- AJAX untuk save
- Notifikasi sukses

**File Terkait:**
- `app/Http/Controllers/AddressController.php::store()`

### 6.2 Edit Alamat

**Deskripsi**: Mengedit alamat yang sudah tersimpan.

**Fitur:**
- Form edit dengan data existing
- Update alamat
- Update default status
- AJAX implementation
- Notifikasi sukses

**File Terkait:**
- `app/Http/Controllers/AddressController.php::update()`

### 6.3 Hapus Alamat

**Deskripsi**: Menghapus alamat yang sudah tersimpan.

**Fitur:**
- Konfirmasi sebelum hapus
- Hapus dari database
- AJAX implementation
- Notifikasi sukses

**File Terkait:**
- `app/Http/Controllers/AddressController.php::destroy()`

### 6.4 Set Alamat Default

**Deskripsi**: Menetapkan alamat sebagai default.

**Fitur:**
- Set satu alamat sebagai default
- Otomatis unset alamat default lainnya
- AJAX implementation

**File Terkait:**
- `app/Http/Controllers/AddressController.php::setDefault()`

## 7. Fitur Manajemen Pesanan

### 7.1 Daftar Pesanan

**Deskripsi**: Halaman riwayat pesanan customer.

**Fitur:**
- Daftar semua pesanan user
- Informasi pesanan (order number, tanggal, status, total)
- Filter berdasarkan status
- Pagination
- Link ke detail pesanan

**File Terkait:**
- `app/Http/Controllers/OrderController.php::index()`
- `resources/views/orders/index.blade.php`

### 7.2 Detail Pesanan

**Deskripsi**: Halaman detail pesanan dengan informasi lengkap.

**Fitur:**
- Informasi pesanan lengkap
- Daftar item pesanan
- Informasi pengiriman
- Status pesanan
- Tombol aksi berdasarkan status:
  - Cetak Invoice
  - Selesaikan Pesanan (jika sudah sampai)
  - Ajukan Pembatalan (jika belum selesai)
  - Ajukan Komplain (jika sudah selesai)
- Form ulasan produk (saat selesai)

**File Terkait:**
- `app/Http/Controllers/OrderController.php::show()`
- `resources/views/orders/show.blade.php`

### 7.3 Cetak Invoice

**Deskripsi**: Mencetak invoice pesanan.

**Fitur:**
- Template invoice
- Informasi lengkap pesanan
- Format untuk print
- PDF generation (jika diimplementasikan)

**File Terkait:**
- `app/Http/Controllers/OrderController.php::invoice()`
- `resources/views/orders/invoice.blade.php`

### 7.4 Menyelesaikan Pesanan

**Deskripsi**: Customer menyelesaikan pesanan setelah menerima barang.

**Fitur:**
- Hanya bisa dilakukan jika status 'pengiriman' atau 'sudah_sampai'
- Form ulasan produk (opsional)
- Upload gambar ulasan (opsional)
- Update status menjadi 'selesai'
- Update payment status menjadi 'released'
- Transaction management

**Alur:**
1. Customer klik "Selesaikan Pesanan"
2. Form ulasan muncul (jika ada produk)
3. Customer isi ulasan (opsional)
4. Submit
5. Create reviews
6. Update order status
7. Update payment status
8. Notifikasi sukses

**File Terkait:**
- `app/Http/Controllers/OrderController.php::complete()`

### 7.5 Membatalkan Pesanan

**Deskripsi**: Customer mengajukan pembatalan pesanan.

**Fitur:**
- Hanya bisa dilakukan jika status belum 'selesai' atau 'cancelled'
- Form alasan pembatalan
- Update status menjadi 'pending_cancellation'
- Menunggu konfirmasi admin
- Stok dikembalikan setelah admin approve

**File Terkait:**
- `app/Http/Controllers/OrderCancelController.php`

## 8. Fitur Ulasan Produk

### 8.1 Memberikan Ulasan

**Deskripsi**: Customer memberikan ulasan untuk produk yang dibeli.

**Fitur:**
- Form ulasan saat menyelesaikan pesanan
- Rating 1-5 bintang
- Komentar (opsional)
- Upload gambar (opsional)
- Satu ulasan per produk per order
- Validasi rating

**File Terkait:**
- `app/Http/Controllers/OrderController.php::complete()`
- Model: `app/Models/Review.php`

## 9. Fitur Komplain

### 9.1 Mengajukan Komplain

**Deskripsi**: Customer mengajukan komplain untuk pesanan yang sudah selesai.

**Fitur:**
- Hanya untuk pesanan dengan status 'selesai'
- Form komplain (judul, detail)
- Upload gambar bukti (opsional)
- Status default 'pending'
- Menunggu peninjauan admin

**File Terkait:**
- `app/Http/Controllers/ComplaintController.php::store()`

### 9.2 Melihat Status Komplain

**Deskripsi**: Customer melihat status komplain mereka.

**Fitur:**
- Daftar komplain di detail pesanan
- Status komplain
- Respons admin (jika ada)

## 10. Fitur Admin - Dashboard

### 10.1 Dashboard Admin

**Deskripsi**: Halaman dashboard admin dengan statistik dan grafik.

**Fitur:**
- Statistik ringkas:
  - Total pesanan
  - Total produk
  - Total customer
  - Total pendapatan (hanya dari pesanan selesai)
- Grafik pendapatan bulanan (6 bulan terakhir)
- Grafik produk terlaris (top 5)
- Grafik status pesanan
- Daftar pesanan terbaru (5 pesanan)

**File Terkait:**
- `app/Http/Controllers/Admin/DashboardController.php::index()`
- `resources/views/admin/dashboard.blade.php`

## 11. Fitur Admin - Manajemen Produk

### 11.1 Daftar Produk

**Deskripsi**: Halaman daftar produk untuk admin.

**Fitur:**
- Daftar semua produk
- Informasi produk (nama, harga, stok, kategori)
- Tombol edit dan hapus
- Pagination

**File Terkait:**
- `app/Http/Controllers/ProductController.php::adminIndex()`
- `resources/views/admin/products/index.blade.php`

### 11.2 Tambah Produk

**Deskripsi**: Form untuk menambahkan produk baru.

**Fitur:**
- Form input (nama, deskripsi, harga, stok, kategori)
- Upload gambar produk
- Validasi input
- Auto-generate slug
- Simpan ke database

**File Terkait:**
- `app/Http/Controllers/ProductController.php::create()` dan `store()`
- `resources/views/admin/products/create.blade.php`

### 11.3 Edit Produk

**Deskripsi**: Form untuk mengedit produk yang sudah ada.

**Fitur:**
- Form edit dengan data existing
- Update informasi produk
- Update atau ganti gambar
- Hapus gambar lama jika diganti
- Validasi input

**File Terkait:**
- `app/Http/Controllers/ProductController.php::edit()` dan `update()`
- `resources/views/admin/products/edit.blade.php`

### 11.4 Hapus Produk

**Deskripsi**: Menghapus produk dari sistem.

**Fitur:**
- Konfirmasi sebelum hapus
- Hapus gambar dari storage
- Hapus dari database
- Cascade delete ke cart dan order_items

**File Terkait:**
- `app/Http/Controllers/ProductController.php::destroy()`

## 12. Fitur Admin - Manajemen Pesanan

### 12.1 Daftar Pesanan

**Deskripsi**: Halaman daftar semua pesanan untuk admin.

**Fitur:**
- Daftar semua pesanan
- Informasi customer
- Status pesanan
- Total harga
- Filter dan search
- Pagination

**File Terkait:**
- `app/Http/Controllers/Admin/DashboardController.php::orders()`
- `resources/views/admin/orders/index.blade.php`

### 12.2 Update Status Pesanan

**Deskripsi**: Admin mengupdate status pesanan.

**Fitur:**
- Update status: proses → pengemasan → pengiriman → sudah_sampai
- Tidak bisa update ke 'selesai' (hanya customer)
- Jika status 'cancelled', kembalikan stok
- Validasi status transition

**Status Flow:**
```
proses → pengemasan → pengiriman → sudah_sampai
```

**File Terkait:**
- `app/Http/Controllers/Admin/DashboardController.php::updateOrderStatus()`

### 12.3 Approve/Reject Pembatalan

**Deskripsi**: Admin menyetujui atau menolak permintaan pembatalan.

**Fitur:**
- Approve: Update status menjadi 'cancelled', kembalikan stok
- Reject: Kembalikan status ke 'proses', hapus alasan pembatalan
- Hanya untuk pesanan dengan status 'pending_cancellation'

**File Terkait:**
- `app/Http/Controllers/Admin/DashboardController.php::approveCancellation()`
- `app/Http/Controllers/Admin/DashboardController.php::rejectCancellation()`

### 12.4 Cetak Shipping Label

**Deskripsi**: Admin mencetak shipping label/resi untuk pengiriman.

**Fitur:**
- Template shipping label
- Informasi pengiriman lengkap
- Format untuk print

**File Terkait:**
- `app/Http/Controllers/Admin/DashboardController.php::label()`
- `resources/views/admin/orders/label.blade.php`

## 13. Fitur Admin - Manajemen Komplain

### 13.1 Daftar Komplain

**Deskripsi**: Halaman daftar semua komplain untuk admin.

**Fitur:**
- Daftar semua komplain
- Informasi pesanan dan customer
- Status komplain
- Pagination

**File Terkait:**
- `app/Http/Controllers/ComplaintController.php::index()`
- `resources/views/admin/complaints/index.blade.php`

### 13.2 Detail Komplain

**Deskripsi**: Halaman detail komplain dengan informasi lengkap.

**Fitur:**
- Informasi komplain lengkap
- Detail pesanan
- Gambar bukti (jika ada)
- Form update status
- Form respons admin

**File Terkait:**
- `app/Http/Controllers/ComplaintController.php::show()`
- `resources/views/admin/complaints/show.blade.php`

### 13.3 Update Status Komplain

**Deskripsi**: Admin mengupdate status dan memberikan respons.

**Fitur:**
- Update status: pending → in_progress → resolved/rejected
- Tambah respons admin
- Notifikasi ke customer (jika diimplementasikan)

**File Terkait:**
- `app/Http/Controllers/ComplaintController.php::updateStatus()`

## 14. Fitur Admin - Laporan

### 14.1 Laporan Penjualan

**Deskripsi**: Halaman laporan penjualan untuk admin.

**Fitur:**
- Filter berdasarkan tanggal
- Filter berdasarkan status
- Statistik:
  - Total pesanan
  - Total pendapatan (hanya selesai)
  - Total dibatalkan
  - Total dikirim
- Daftar pesanan sesuai filter
- Export ke PDF/Excel (jika diimplementasikan)

**File Terkait:**
- `app/Http/Controllers/Admin/DashboardController.php::reports()`
- `resources/views/admin/reports/index.blade.php`

## 15. Fitur Sistem Otomatis

### 15.1 Auto-Complete Order

**Deskripsi**: Sistem otomatis menyelesaikan pesanan setelah 3 hari.

**Fitur:**
- Jika status 'sudah_sampai' dan sudah 3 hari
- Auto update status menjadi 'selesai'
- Auto update payment status menjadi 'released'
- Dijalankan via Laravel Scheduler

**Implementasi:**
- Schedule task di `app/Console/Kernel.php`
- Command untuk check dan update orders

### 15.2 Order Number Generation

**Deskripsi**: Generate nomor pesanan unik.

**Fitur:**
- Format: HM-{10 random alphanumeric}
- Unik check sebelum save
- Retry jika duplicate

**File Terkait:**
- `app/Http/Controllers/OrderController.php::generateOrderNumber()`

## 16. Fitur UI/UX

### 16.1 AJAX Implementation

**Deskripsi**: Semua operasi penting menggunakan AJAX untuk UX yang lebih baik.

**Fitur:**
- No page refresh
- Real-time updates
- Loading indicators
- Error handling
- Success notifications

**Operasi yang menggunakan AJAX:**
- Cart operations (add, update, delete)
- Address management
- Filter dan sorting produk
- Update quantity
- Notifications

### 16.2 Notifikasi

**Deskripsi**: Sistem notifikasi untuk feedback ke user.

**Fitur:**
- Success notifications
- Error notifications
- Warning notifications
- Auto dismiss setelah beberapa detik
- Custom styling

### 16.3 Responsive Design

**Deskripsi**: Aplikasi responsive untuk mobile dan desktop.

**Fitur:**
- Mobile-first approach
- Breakpoints untuk tablet dan desktop
- Touch-friendly buttons
- Responsive tables
- Responsive forms

### 16.4 Interactive Elements

**Deskripsi**: Elemen interaktif untuk meningkatkan UX.

**Fitur:**
- Interactive login mascot dengan eye-tracking
- Modal dialogs untuk konfirmasi
- Dropdown menus
- Smooth transitions
- Loading states

---

**Catatan**: Semua fitur di atas telah diimplementasikan dalam aplikasi. Beberapa fitur tambahan seperti email notifications, payment gateway integration, dan export laporan dapat ditambahkan untuk production.
