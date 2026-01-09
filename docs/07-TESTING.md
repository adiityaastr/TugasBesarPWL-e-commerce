# Dokumentasi Testing Herbamart E-Commerce

## 1. Pendahuluan

Dokumen ini menjelaskan strategi testing, test cases, dan panduan untuk melakukan testing pada aplikasi Herbamart E-Commerce.

## 2. Strategi Testing

### 2.1 Jenis Testing

Aplikasi menggunakan beberapa jenis testing:

1. **Unit Testing**: Testing untuk unit terkecil (models, helpers)
2. **Feature Testing**: Testing untuk HTTP requests dan responses
3. **Integration Testing**: Testing untuk integrasi antar komponen
4. **Manual Testing**: Testing manual untuk UI/UX

### 2.2 Testing Framework

- **PHPUnit**: Framework testing untuk PHP/Laravel
- **Laravel Testing**: Built-in testing tools dari Laravel

## 3. Setup Testing Environment

### 3.1 Konfigurasi PHPUnit

File `phpunit.xml` sudah dikonfigurasi untuk testing:

```xml
<php>
    <env name="APP_ENV" value="testing"/>
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
</php>
```

### 3.2 Menjalankan Tests

**Semua tests:**
```bash
php artisan test
```

**Specific test file:**
```bash
php artisan test tests/Feature/Auth/LoginTest.php
```

**Specific test method:**
```bash
php artisan test --filter test_user_can_login
```

**Dengan coverage:**
```bash
php artisan test --coverage
```

## 4. Test Cases

### 4.1 Authentication Tests

#### Test: User Registration

**File**: `tests/Feature/Auth/RegistrationTest.php`

**Test Cases:**
1. ✅ User dapat melihat form registrasi
2. ✅ User dapat registrasi dengan data valid
3. ✅ User tidak dapat registrasi dengan email duplikat
4. ✅ User tidak dapat registrasi dengan password kurang dari 8 karakter
5. ✅ Password confirmation harus match

**Example:**
```php
public function test_user_can_register()
{
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect('/dashboard');
    $this->assertAuthenticated();
}
```

#### Test: User Login

**File**: `tests/Feature/Auth/LoginTest.php`

**Test Cases:**
1. ✅ User dapat melihat form login
2. ✅ User dapat login dengan kredensial valid
3. ✅ User tidak dapat login dengan email salah
4. ✅ User tidak dapat login dengan password salah
5. ✅ User di-redirect ke dashboard setelah login
6. ✅ Admin di-redirect ke admin dashboard setelah login

#### Test: Password Reset

**File**: `tests/Feature/Auth/PasswordResetTest.php`

**Test Cases:**
1. ✅ User dapat request password reset
2. ✅ User menerima email dengan reset link
3. ✅ User dapat reset password dengan token valid
4. ✅ User tidak dapat reset password dengan token invalid

### 4.2 Product Tests

#### Test: Product Listing

**Test Cases:**
1. ✅ User dapat melihat daftar produk
2. ✅ Produk ditampilkan dengan pagination
3. ✅ User dapat filter produk berdasarkan kategori
4. ✅ User dapat sort produk (latest, price, rating, best selling)
5. ✅ Filter dan sort bekerja dengan AJAX

#### Test: Product Detail

**Test Cases:**
1. ✅ User dapat melihat detail produk
2. ✅ Informasi produk lengkap ditampilkan
3. ✅ User dapat menambahkan produk ke keranjang dari detail page

### 4.3 Cart Tests

#### Test: Add to Cart

**Test Cases:**
1. ✅ User dapat menambahkan produk ke keranjang
2. ✅ Quantity bertambah jika produk sudah ada di cart
3. ✅ User tidak dapat menambahkan produk dengan stok tidak cukup
4. ✅ Cart count update setelah menambah produk
5. ✅ AJAX response berisi cart count yang benar

#### Test: Update Cart

**Test Cases:**
1. ✅ User dapat update quantity item di cart
2. ✅ User tidak dapat update quantity melebihi stok
3. ✅ Subtotal update setelah update quantity
4. ✅ Total update setelah update quantity

#### Test: Remove from Cart

**Test Cases:**
1. ✅ User dapat menghapus item dari cart
2. ✅ Cart count update setelah hapus
3. ✅ Total update setelah hapus

### 4.4 Order Tests

#### Test: Create Order

**Test Cases:**
1. ✅ User dapat membuat order dari cart
2. ✅ Order dibuat dengan data yang benar
3. ✅ Stock produk berkurang setelah order dibuat
4. ✅ Cart dihapus setelah order dibuat
5. ✅ Order number unik dan dalam format yang benar
6. ✅ Total price termasuk shipping cost
7. ✅ Transaction rollback jika ada error

#### Test: Order Status

**Test Cases:**
1. ✅ Admin dapat update status order
2. ✅ Customer tidak dapat update status order
3. ✅ Status transition valid
4. ✅ Stock dikembalikan jika order dibatalkan
5. ✅ Order tidak dapat diubah setelah selesai

#### Test: Order Cancellation

**Test Cases:**
1. ✅ Customer dapat mengajukan pembatalan
2. ✅ Admin dapat approve pembatalan
3. ✅ Admin dapat reject pembatalan
4. ✅ Stock dikembalikan setelah approve pembatalan

### 4.5 Address Tests

#### Test: Address Management

**Test Cases:**
1. ✅ User dapat menyimpan alamat baru
2. ✅ User dapat edit alamat
3. ✅ User dapat hapus alamat
4. ✅ User dapat set alamat default
5. ✅ Hanya satu alamat default per user

### 4.6 Review Tests

#### Test: Review Creation

**Test Cases:**
1. ✅ Customer dapat memberikan review saat complete order
2. ✅ Rating harus antara 1-5
3. ✅ Review hanya bisa untuk order yang selesai
4. ✅ Review dapat memiliki gambar

### 4.7 Complaint Tests

#### Test: Complaint Management

**Test Cases:**
1. ✅ Customer dapat mengajukan komplain untuk order selesai
2. ✅ Admin dapat melihat daftar komplain
3. ✅ Admin dapat update status komplain
4. ✅ Admin dapat memberikan respons

### 4.8 Admin Tests

#### Test: Product Management

**Test Cases:**
1. ✅ Admin dapat melihat daftar produk
2. ✅ Admin dapat menambah produk
3. ✅ Admin dapat edit produk
4. ✅ Admin dapat hapus produk
5. ✅ Gambar produk ter-upload dengan benar

#### Test: Order Management

**Test Cases:**
1. ✅ Admin dapat melihat semua order
2. ✅ Admin dapat update status order
3. ✅ Admin dapat cetak shipping label
4. ✅ Admin dapat approve/reject pembatalan

#### Test: Dashboard

**Test Cases:**
1. ✅ Admin dapat melihat dashboard
2. ✅ Statistik ditampilkan dengan benar
3. ✅ Grafik pendapatan ditampilkan
4. ✅ Grafik produk terlaris ditampilkan

## 5. Manual Testing Checklist

### 5.1 Functional Testing

#### Authentication
- [ ] Registrasi user baru
- [ ] Login dengan kredensial valid
- [ ] Login dengan kredensial invalid
- [ ] Logout
- [ ] Password reset
- [ ] Email verification (jika diaktifkan)

#### Product Browsing
- [ ] Melihat daftar produk
- [ ] Filter produk berdasarkan kategori
- [ ] Sort produk (latest, price, rating, best selling)
- [ ] Melihat detail produk
- [ ] Pencarian produk (jika ada)

#### Cart Operations
- [ ] Menambahkan produk ke cart
- [ ] Update quantity di cart
- [ ] Hapus item dari cart
- [ ] Cart count update real-time
- [ ] Badge cart di navbar update

#### Checkout Process
- [ ] Melihat halaman checkout
- [ ] Pilih alamat tersimpan
- [ ] Tambah alamat baru
- [ ] Edit alamat
- [ ] Pilih metode pengiriman
- [ ] Pilih metode pembayaran
- [ ] Membuat order
- [ ] Order number unik

#### Order Management
- [ ] Melihat riwayat pesanan
- [ ] Melihat detail pesanan
- [ ] Cetak invoice
- [ ] Selesaikan pesanan
- [ ] Berikan ulasan
- [ ] Ajukan pembatalan
- [ ] Ajukan komplain

#### Address Management
- [ ] Simpan alamat baru
- [ ] Edit alamat
- [ ] Hapus alamat
- [ ] Set alamat default
- [ ] Integrasi API wilayah Indonesia

#### Admin Functions
- [ ] Login sebagai admin
- [ ] Melihat dashboard admin
- [ ] Manajemen produk (CRUD)
- [ ] Manajemen pesanan
- [ ] Update status pesanan
- [ ] Manajemen komplain
- [ ] Melihat laporan

### 5.2 UI/UX Testing

#### Responsiveness
- [ ] Layout responsive di mobile
- [ ] Layout responsive di tablet
- [ ] Layout responsive di desktop
- [ ] Touch-friendly buttons di mobile

#### Interactivity
- [ ] AJAX operations tanpa refresh
- [ ] Notifications muncul dan hilang
- [ ] Modal dialogs bekerja
- [ ] Dropdown menus bekerja
- [ ] Form validation real-time

#### Visual
- [ ] Styling konsisten
- [ ] Images load dengan benar
- [ ] Icons tampil dengan benar
- [ ] Colors sesuai design
- [ ] Typography readable

### 5.3 Security Testing

#### Authentication & Authorization
- [ ] Unauthorized access diblokir
- [ ] CSRF protection bekerja
- [ ] Password hashing
- [ ] Session management
- [ ] Role-based access control

#### Input Validation
- [ ] SQL injection prevention
- [ ] XSS prevention
- [ ] File upload validation
- [ ] Input sanitization

#### Data Protection
- [ ] Sensitive data tidak ter-expose
- [ ] Order number tidak dapat ditebak
- [ ] User hanya dapat akses data sendiri

### 5.4 Performance Testing

#### Load Testing
- [ ] Halaman load dalam waktu wajar (< 2 detik)
- [ ] AJAX requests cepat (< 1 detik)
- [ ] Database queries optimal
- [ ] Images optimized

#### Scalability
- [ ] Aplikasi dapat handle multiple users
- [ ] Database queries efficient
- [ ] No N+1 query problems

## 6. Test Data

### 6.1 Seeding Test Data

```bash
php artisan db:seed
```

**Default Data:**
- 1 Admin user
- 1 Customer user
- Sample products
- Sample categories

### 6.2 Creating Test Data

**Via Factory:**

```php
$user = User::factory()->create();
$product = Product::factory()->create();
$order = Order::factory()->create(['user_id' => $user->id]);
```

**Via Seeder:**

```bash
php artisan db:seed --class=TestDataSeeder
```

## 7. Continuous Integration

### 7.1 GitHub Actions (Example)

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
    
    - name: Install Dependencies
      run: composer install
    
    - name: Run Tests
      run: php artisan test
```

## 8. Bug Reporting

### 8.1 Bug Report Template

**Title**: [Brief description]

**Steps to Reproduce:**
1. Step 1
2. Step 2
3. Step 3

**Expected Behavior:**
[What should happen]

**Actual Behavior:**
[What actually happens]

**Environment:**
- PHP Version: 
- Laravel Version:
- Browser:
- OS:

**Screenshots:**
[If applicable]

**Additional Context:**
[Any other relevant information]

## 9. Test Coverage Goals

### 9.1 Coverage Targets

- **Critical Features**: 90%+
- **Core Features**: 80%+
- **Overall**: 70%+

### 9.2 Critical Features

1. Authentication
2. Order creation
3. Stock management
4. Payment processing
5. Admin functions

## 10. Regression Testing

### 10.1 Before Release

Sebelum release, pastikan semua fitur utama masih bekerja:

- [ ] User registration dan login
- [ ] Product browsing dan filtering
- [ ] Cart operations
- [ ] Checkout process
- [ ] Order management
- [ ] Admin functions

### 10.2 After Update

Setelah update code, jalankan:

```bash
php artisan test
```

Pastikan semua tests pass sebelum deploy.

---

**Catatan**: Testing adalah proses berkelanjutan. Pastikan untuk menambahkan test cases baru setiap kali menambahkan fitur baru atau memperbaiki bug.
