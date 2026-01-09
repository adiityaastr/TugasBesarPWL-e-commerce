# Routing dan API Documentation

## 1. Pendahuluan

Dokumen ini menjelaskan semua route dan endpoint yang tersedia dalam aplikasi Herbamart E-Commerce, termasuk middleware, parameter, dan response yang dihasilkan.

## 2. Route Groups

### 2.1 Public Routes

Route yang dapat diakses tanpa autentikasi.

**Middleware**: Tidak ada (atau `no_admin_shop` untuk redirect admin)

### 2.2 Authenticated Routes

Route yang memerlukan autentikasi.

**Middleware**: `auth`, `verified`, `no_admin_shop`

### 2.3 Admin Routes

Route yang hanya dapat diakses oleh admin.

**Middleware**: `auth`, `verified`, `admin`

## 3. Route Definitions

### 3.1 Public Routes

#### GET `/`
**Controller**: `ProductController@index`  
**Name**: `home`  
**Middleware**: `no_admin_shop`  
**Deskripsi**: Halaman utama menampilkan daftar produk.

**Query Parameters:**
- `categories[]`: Array kategori untuk filter (optional)
- `sort`: Sorting option (latest, rating, price_asc, price_desc, best_selling) (optional)

**Response**: View `products.index` dengan data:
- `products`: Paginated products
- `categories`: List of categories
- `selectedCategories`: Selected categories
- `selectedSort`: Selected sort option

---

#### GET `/products/{product}`
**Controller**: `ProductController@show`  
**Name**: `products.show`  
**Middleware**: `no_admin_shop`  
**Deskripsi**: Halaman detail produk.

**Route Parameters:**
- `product`: Product slug (model binding)

**Response**: View `products.show` dengan data:
- `product`: Product model

---

### 3.2 Authentication Routes

#### GET `/register`
**Controller**: `RegisteredUserController@create`  
**Name**: `register`  
**Middleware**: `guest`  
**Deskripsi**: Form registrasi.

**Response**: View `auth.register`

---

#### POST `/register`
**Controller**: `RegisteredUserController@store`  
**Name**: `register`  
**Middleware**: `guest`  
**Deskripsi**: Proses registrasi.

**Request Body:**
```json
{
  "name": "string (required)",
  "username": "string (optional)",
  "email": "string (required, unique)",
  "password": "string (required, min:8)",
  "password_confirmation": "string (required)"
}
```

**Response**: Redirect ke dashboard setelah login otomatis.

---

#### GET `/login`
**Controller**: `AuthenticatedSessionController@create`  
**Name**: `login`  
**Middleware**: `guest`  
**Deskripsi**: Form login.

**Response**: View `auth.login`

---

#### POST `/login`
**Controller**: `AuthenticatedSessionController@store`  
**Name**: `login`  
**Middleware**: `guest`  
**Deskripsi**: Proses login.

**Request Body:**
```json
{
  "email": "string (required)",
  "password": "string (required)",
  "remember": "boolean (optional)"
}
```

**Response**: 
- Redirect ke `/dashboard` jika customer
- Redirect ke `/admin` jika admin

---

#### POST `/logout`
**Controller**: `AuthenticatedSessionController@destroy`  
**Name**: `logout`  
**Middleware**: `auth`  
**Deskripsi**: Logout user.

**Response**: Redirect ke home.

---

#### GET `/forgot-password`
**Controller**: `PasswordResetLinkController@create`  
**Name**: `password.request`  
**Middleware**: `guest`  
**Deskripsi**: Form request password reset.

**Response**: View `auth.forgot-password`

---

#### POST `/forgot-password`
**Controller**: `PasswordResetLinkController@store`  
**Name**: `password.email`  
**Middleware**: `guest`  
**Deskripsi**: Kirim email reset password.

**Request Body:**
```json
{
  "email": "string (required)"
}
```

**Response**: Redirect dengan message.

---

#### GET `/reset-password/{token}`
**Controller**: `NewPasswordController@create`  
**Name**: `password.reset`  
**Middleware**: `guest`  
**Deskripsi**: Form reset password.

**Route Parameters:**
- `token`: Password reset token

**Response**: View `auth.reset-password`

---

#### POST `/reset-password`
**Controller**: `NewPasswordController@store`  
**Name**: `password.store`  
**Middleware**: `guest`  
**Deskripsi**: Proses reset password.

**Request Body:**
```json
{
  "token": "string (required)",
  "email": "string (required)",
  "password": "string (required, min:8)",
  "password_confirmation": "string (required)"
}
```

**Response**: Redirect ke login.

---

### 3.3 Customer Routes

#### GET `/dashboard`
**Controller**: `OrderController@index`  
**Name**: `dashboard`  
**Middleware**: `auth`, `verified`, `no_admin_shop`  
**Deskripsi**: Dashboard customer (riwayat pesanan).

**Response**: View `orders.index` dengan data:
- `orders`: Paginated orders

---

#### GET `/cart`
**Controller**: `CartController@index`  
**Name**: `cart.index`  
**Middleware**: `auth`, `verified`, `no_admin_shop`  
**Deskripsi**: Halaman keranjang belanja.

**Accept**: `application/json` (optional, untuk AJAX)

**Response**: 
- View `cart.index` (HTML)
- JSON response jika AJAX:
```json
{
  "success": true,
  "items": [...],
  "total": 0,
  "totalItems": 0,
  "cartCount": 0
}
```

---

#### POST `/cart`
**Controller**: `CartController@store`  
**Name**: `cart.store`  
**Middleware**: `auth`, `verified`, `no_admin_shop`  
**Deskripsi**: Menambahkan produk ke keranjang.

**Request Body:**
```json
{
  "product_id": "integer (required)",
  "quantity": "integer (required, min:1)",
  "redirect_to": "string (optional, 'checkout')"
}
```

**Accept**: `application/json` (optional, untuk AJAX)

**Response**: 
- Redirect jika `redirect_to=checkout`
- JSON jika AJAX:
```json
{
  "success": true,
  "message": "Produk telah ditambahkan ke keranjang.",
  "cartCount": 0
}
```

---

#### PUT `/cart/{cart}`
**Controller**: `CartController@update`  
**Name**: `cart.update`  
**Middleware**: `auth`, `verified`, `no_admin_shop`  
**Deskripsi**: Update quantity item di keranjang.

**Route Parameters:**
- `cart`: Cart ID (model binding)

**Request Body:**
```json
{
  "quantity": "integer (required, min:1)"
}
```

**Accept**: `application/json` (optional, untuk AJAX)

**Response**: 
- JSON jika AJAX:
```json
{
  "success": true,
  "message": "Cart updated.",
  "cartCount": 0
}
```

---

#### DELETE `/cart/{cart}`
**Controller**: `CartController@destroy`  
**Name**: `cart.destroy`  
**Middleware**: `auth`, `verified`, `no_admin_shop`  
**Deskripsi**: Hapus item dari keranjang.

**Route Parameters:**
- `cart`: Cart ID (model binding)

**Accept**: `application/json` (optional, untuk AJAX)

**Response**: 
- JSON jika AJAX:
```json
{
  "success": true,
  "message": "Item removed from cart.",
  "cartCount": 0
}
```

---

#### GET `/checkout`
**Controller**: `OrderController@create`  
**Name**: `checkout.index`  
**Middleware**: `auth`, `verified`, `no_admin_shop`  
**Deskripsi**: Halaman checkout.

**Response**: View `checkout.index` dengan data:
- `cartItems`: Cart items dengan product
- `addresses`: User addresses

---

#### POST `/orders`
**Controller**: `OrderController@store`  
**Name**: `orders.store`  
**Middleware**: `auth`, `verified`, `no_admin_shop`  
**Deskripsi**: Membuat pesanan baru dari keranjang.

**Request Body:**
```json
{
  "address_id": "integer (optional, jika menggunakan alamat tersimpan)",
  "recipient_name": "string (required jika tidak ada address_id)",
  "shipping_address": "string (required jika tidak ada address_id)",
  "provinsi": "string (optional)",
  "kota": "string (optional)",
  "kecamatan": "string (optional)",
  "kelurahan": "string (optional)",
  "kode_pos": "string (optional)",
  "shipping_method": "string (required, in:reguler,kargo,same_day)",
  "payment_method": "string (required, in:bank_transfer,credit_card,cod)",
  "save_address": "boolean (optional)"
}
```

**Response**: Redirect ke `orders.show` dengan success message.

---

#### GET `/orders`
**Controller**: `OrderController@index`  
**Name**: `orders.index`  
**Middleware**: `auth`, `verified`, `no_admin_shop`  
**Deskripsi**: Daftar pesanan customer.

**Response**: View `orders.index` dengan data:
- `orders`: Paginated orders

---

#### GET `/orders/{order}`
**Controller**: `OrderController@show`  
**Name**: `orders.show`  
**Middleware**: `auth`, `verified`, `no_admin_shop`  
**Deskripsi**: Detail pesanan.

**Route Parameters:**
- `order`: Order ID (model binding)

**Response**: View `orders.show` dengan data:
- `order`: Order model dengan relationships

---

#### GET `/orders/{order}/invoice`
**Controller**: `OrderController@invoice`  
**Name**: `orders.invoice`  
**Middleware**: `auth`, `verified`  
**Deskripsi**: Cetak invoice pesanan.

**Route Parameters:**
- `order`: Order ID (model binding)

**Response**: View `orders.invoice` dengan data:
- `order`: Order model

---

#### PATCH `/orders/{order}/cancel`
**Controller**: `OrderCancelController@__invoke`  
**Name**: `orders.cancel`  
**Middleware**: `auth`, `verified`, `no_admin_shop`  
**Deskripsi**: Ajukan pembatalan pesanan.

**Route Parameters:**
- `order`: Order ID (model binding)

**Request Body:**
```json
{
  "cancellation_reason": "string (required, max:500)"
}
```

**Response**: Redirect ke `orders.show` dengan success message.

---

#### PATCH `/orders/{order}/complete`
**Controller**: `OrderController@complete`  
**Name**: `orders.complete`  
**Middleware**: `auth`, `verified`, `no_admin_shop`  
**Deskripsi**: Selesaikan pesanan dan berikan ulasan.

**Route Parameters:**
- `order`: Order ID (model binding)

**Request Body:**
```json
{
  "reviews": [
    {
      "product_id": "integer (required)",
      "rating": "integer (required, min:1, max:5)",
      "comment": "string (optional)",
      "image": "file (optional, image, max:2048)"
    }
  ]
}
```

**Response**: Redirect ke `orders.show` dengan success message.

---

#### POST `/orders/{order}/complaints`
**Controller**: `ComplaintController@store`  
**Name**: `complaints.store`  
**Middleware**: `auth`, `verified`, `no_admin_shop`  
**Deskripsi**: Ajukan komplain untuk pesanan.

**Route Parameters:**
- `order`: Order ID (model binding)

**Request Body:**
```json
{
  "complaint_title": "string (required, max:255)",
  "complaint_detail": "string (required, max:2000)",
  "complaint_image": "file (optional, image, max:2048)"
}
```

**Response**: Redirect ke `orders.show` dengan success message.

---

#### GET `/profile`
**Controller**: `ProfileController@edit`  
**Name**: `profile.edit`  
**Middleware**: `auth`, `verified`  
**Deskripsi**: Form edit profil.

**Response**: View `profile.edit`

---

#### PATCH `/profile`
**Controller**: `ProfileController@update`  
**Name**: `profile.update`  
**Middleware**: `auth`, `verified`  
**Deskripsi**: Update profil.

**Request Body:**
```json
{
  "name": "string (required)",
  "username": "string (optional)",
  "full_name": "string (optional)",
  "email": "string (required, unique)",
  "profile_photo": "file (optional, image)"
}
```

**Response**: Redirect ke `profile.edit` dengan success message.

---

#### DELETE `/profile`
**Controller**: `ProfileController@destroy`  
**Name**: `profile.destroy`  
**Middleware**: `auth`, `verified`  
**Deskripsi**: Hapus akun.

**Response**: Redirect ke home.

---

#### POST `/addresses`
**Controller**: `AddressController@store`  
**Name**: `addresses.store`  
**Middleware**: `auth`, `verified`, `no_admin_shop`  
**Deskripsi**: Simpan alamat baru.

**Request Body:**
```json
{
  "recipient_name": "string (required, max:255)",
  "shipping_address": "string (required)",
  "provinsi": "string (optional, max:255)",
  "kota": "string (optional, max:255)",
  "kecamatan": "string (optional, max:255)",
  "kelurahan": "string (optional, max:255)",
  "kode_pos": "string (optional, max:10)",
  "is_default": "boolean (optional)"
}
```

**Accept**: `application/json` (optional, untuk AJAX)

**Response**: 
- Redirect dengan success message
- JSON jika AJAX:
```json
{
  "success": true,
  "message": "Alamat berhasil disimpan."
}
```

---

#### PATCH `/addresses/{address}`
**Controller**: `AddressController@update`  
**Name**: `addresses.update`  
**Middleware**: `auth`, `verified`, `no_admin_shop`  
**Deskripsi**: Update alamat.

**Route Parameters:**
- `address`: Address ID (model binding)

**Request Body:**
```json
{
  "recipient_name": "string (required, max:255)",
  "shipping_address": "string (required)",
  "provinsi": "string (optional, max:255)",
  "kota": "string (optional, max:255)",
  "kecamatan": "string (optional, max:255)",
  "kelurahan": "string (optional, max:255)",
  "kode_pos": "string (optional, max:10)",
  "is_default": "boolean (optional)"
}
```

**Accept**: `application/json` (optional, untuk AJAX)

**Response**: 
- Redirect dengan success message
- JSON jika AJAX:
```json
{
  "success": true,
  "message": "Alamat berhasil diperbarui."
}
```

---

#### DELETE `/addresses/{address}`
**Controller**: `AddressController@destroy`  
**Name**: `addresses.destroy`  
**Middleware**: `auth`, `verified`, `no_admin_shop`  
**Deskripsi**: Hapus alamat.

**Route Parameters:**
- `address`: Address ID (model binding)

**Accept**: `application/json` (optional, untuk AJAX)

**Response**: 
- Redirect dengan success message
- JSON jika AJAX:
```json
{
  "success": true,
  "message": "Alamat berhasil dihapus."
}
```

---

#### PATCH `/addresses/{address}/set-default`
**Controller**: `AddressController@setDefault`  
**Name**: `addresses.set-default`  
**Middleware**: `auth`, `verified`, `no_admin_shop`  
**Deskripsi**: Set alamat sebagai default.

**Route Parameters:**
- `address`: Address ID (model binding)

**Response**: Redirect dengan success message.

---

### 3.4 Admin Routes

Semua route admin menggunakan prefix `/admin` dan name prefix `admin.`.

#### GET `/admin`
**Controller**: `Admin\DashboardController@index`  
**Name**: `admin.dashboard`  
**Middleware**: `auth`, `verified`, `admin`  
**Deskripsi**: Dashboard admin.

**Response**: View `admin.dashboard` dengan data:
- `totalOrders`: Total pesanan
- `totalProducts`: Total produk
- `totalUsers`: Total customer
- `recentOrders`: 5 pesanan terbaru
- `revenueLabels`: Labels untuk grafik pendapatan
- `revenueData`: Data untuk grafik pendapatan
- `productLabels`: Labels untuk grafik produk terlaris
- `productData`: Data untuk grafik produk terlaris
- `statusLabels`: Labels untuk grafik status
- `statusData`: Data untuk grafik status
- `totalRevenue`: Total pendapatan

---

#### GET `/admin/products`
**Controller**: `ProductController@adminIndex`  
**Name**: `admin.products.index`  
**Middleware**: `auth`, `verified`, `admin`  
**Deskripsi**: Daftar produk untuk admin.

**Response**: View `admin.products.index` dengan data:
- `products`: Paginated products

---

#### GET `/admin/products/create`
**Controller**: `ProductController@create`  
**Name**: `admin.products.create`  
**Middleware**: `auth`, `verified`, `admin`  
**Deskripsi**: Form tambah produk.

**Response**: View `admin.products.create` dengan data:
- `categories`: List of categories

---

#### POST `/admin/products`
**Controller**: `ProductController@store`  
**Name**: `admin.products.store`  
**Middleware**: `auth`, `verified`, `admin`  
**Deskripsi**: Simpan produk baru.

**Request Body:**
```json
{
  "name": "string (required, max:255)",
  "description": "string (required)",
  "price": "decimal (required, min:0)",
  "stock": "integer (required, min:0)",
  "image": "file (optional, image, mimes:jpeg,png,jpg,gif, max:2048)",
  "category": "string (optional, max:255)"
}
```

**Response**: Redirect ke `admin.products.index` dengan success message.

---

#### GET `/admin/products/{product}/edit`
**Controller**: `ProductController@edit`  
**Name**: `admin.products.edit`  
**Middleware**: `auth`, `verified`, `admin`  
**Deskripsi**: Form edit produk.

**Route Parameters:**
- `product`: Product ID (model binding)

**Response**: View `admin.products.edit` dengan data:
- `product`: Product model
- `categories`: List of categories

---

#### PUT `/admin/products/{product}`
**Controller**: `ProductController@update`  
**Name**: `admin.products.update`  
**Middleware**: `auth`, `verified`, `admin`  
**Deskripsi**: Update produk.

**Route Parameters:**
- `product`: Product ID (model binding)

**Request Body:**
```json
{
  "name": "string (required, max:255)",
  "description": "string (required)",
  "price": "decimal (required, min:0)",
  "stock": "integer (required, min:0)",
  "image": "file (optional, image, mimes:jpeg,png,jpg,gif, max:2048)",
  "category": "string (optional, max:255)"
}
```

**Response**: Redirect ke `admin.products.index` dengan success message.

---

#### DELETE `/admin/products/{product}`
**Controller**: `ProductController@destroy`  
**Name**: `admin.products.destroy`  
**Middleware**: `auth`, `verified`, `admin`  
**Deskripsi**: Hapus produk.

**Route Parameters:**
- `product`: Product ID (model binding)

**Response**: Redirect ke `admin.products.index` dengan success message.

---

#### GET `/admin/orders`
**Controller**: `Admin\DashboardController@orders`  
**Name**: `admin.orders.index`  
**Middleware**: `auth`, `verified`, `admin`  
**Deskripsi**: Daftar pesanan untuk admin.

**Response**: View `admin.orders.index` dengan data:
- `orders`: Paginated orders dengan user

---

#### PATCH `/admin/orders/{order}`
**Controller**: `Admin\DashboardController@updateOrderStatus`  
**Name**: `admin.orders.update`  
**Middleware**: `auth`, `verified`, `admin`  
**Deskripsi**: Update status pesanan.

**Route Parameters:**
- `order`: Order ID (model binding)

**Request Body:**
```json
{
  "status": "string (required, in:proses,pengemasan,pengiriman,sudah_sampai,cancelled)"
}
```

**Response**: Redirect dengan success/error message.

---

#### POST `/admin/orders/{order}/approve-cancellation`
**Controller**: `Admin\DashboardController@approveCancellation`  
**Name**: `admin.orders.approve-cancellation`  
**Middleware**: `auth`, `verified`, `admin`  
**Deskripsi**: Setujui pembatalan pesanan.

**Route Parameters:**
- `order`: Order ID (model binding)

**Response**: Redirect dengan success message.

---

#### POST `/admin/orders/{order}/reject-cancellation`
**Controller**: `Admin\DashboardController@rejectCancellation`  
**Name**: `admin.orders.reject-cancellation`  
**Middleware**: `auth`, `verified`, `admin`  
**Deskripsi**: Tolak pembatalan pesanan.

**Route Parameters:**
- `order`: Order ID (model binding)

**Response**: Redirect dengan success message.

---

#### GET `/admin/orders/{order}/label`
**Controller**: `Admin\DashboardController@label`  
**Name**: `admin.orders.label`  
**Middleware**: `auth`, `verified`, `admin`  
**Deskripsi**: Cetak shipping label.

**Route Parameters:**
- `order`: Order ID (model binding)

**Response**: View `admin.orders.label` dengan data:
- `order`: Order model dengan relationships

---

#### GET `/admin/complaints`
**Controller**: `ComplaintController@index`  
**Name**: `admin.complaints.index`  
**Middleware**: `auth`, `verified`, `admin`  
**Deskripsi**: Daftar komplain untuk admin.

**Response**: View `admin.complaints.index` dengan data:
- `complaints`: Paginated complaints dengan order dan user

---

#### GET `/admin/complaints/{complaint}`
**Controller**: `ComplaintController@show`  
**Name**: `admin.complaints.show`  
**Middleware**: `auth`, `verified`, `admin`  
**Deskripsi**: Detail komplain untuk admin.

**Route Parameters:**
- `complaint`: Complaint ID (model binding)

**Response**: View `admin.complaints.show` dengan data:
- `complaint`: Complaint model dengan relationships

---

#### PATCH `/admin/complaints/{complaint}/status`
**Controller**: `ComplaintController@updateStatus`  
**Name**: `admin.complaints.update-status`  
**Middleware**: `auth`, `verified`, `admin`  
**Deskripsi**: Update status komplain.

**Route Parameters:**
- `complaint`: Complaint ID (model binding)

**Request Body:**
```json
{
  "status": "string (required, in:pending,in_progress,resolved,rejected)",
  "admin_response": "string (optional, max:2000)"
}
```

**Response**: Redirect dengan success message.

---

#### GET `/admin/reports`
**Controller**: `Admin\DashboardController@reports`  
**Name**: `admin.reports.index`  
**Middleware**: `auth`, `verified`, `admin`  
**Deskripsi**: Laporan penjualan.

**Query Parameters:**
- `start_date`: Tanggal mulai (optional)
- `end_date`: Tanggal akhir (optional)
- `status`: Status filter (optional, 'all' untuk semua)

**Response**: View `admin.reports.index` dengan data:
- `orders`: Filtered orders
- `totalOrders`: Total pesanan
- `totalRevenue`: Total pendapatan
- `totalCancelled`: Total dibatalkan
- `totalShipped`: Total dikirim

---

## 4. Middleware

### 4.1 Authentication Middleware

**Laravel Built-in**: `auth`, `verified`

- `auth`: Memastikan user sudah login
- `verified`: Memastikan email sudah diverifikasi (jika email verification diaktifkan)

### 4.2 Custom Middleware

#### `admin`
**File**: `app/Http/Middleware/Admin.php`  
**Deskripsi**: Memastikan user adalah admin.

**Logic:**
```php
if (Auth::user()->role !== 'admin') {
    abort(403);
}
```

#### `no_admin_shop`
**Deskripsi**: Mencegah admin mengakses halaman shop/customer.

**Logic:**
```php
if (Auth::check() && Auth::user()->role === 'admin') {
    return redirect()->route('admin.dashboard');
}
```

## 5. Route Model Binding

Laravel menggunakan route model binding untuk otomatis resolve model dari route parameter:

- `{product}` → `Product` model (menggunakan `slug` sebagai key)
- `{order}` → `Order` model
- `{cart}` → `Cart` model
- `{address}` → `Address` model
- `{complaint}` → `Complaint` model

## 6. CSRF Protection

Semua POST, PUT, PATCH, DELETE request memerlukan CSRF token.

**Implementation:**
- Token di meta tag: `<meta name="csrf-token" content="{{ csrf_token() }}">`
- Token di form: `@csrf` directive
- Token di AJAX: Header `X-CSRF-TOKEN`

## 7. Rate Limiting

Laravel default rate limiting diterapkan untuk:
- Login attempts: 5 attempts per minute
- Password reset: 6 requests per minute
- Email verification: 6 requests per minute

## 8. Response Formats

### 8.1 HTML Response

Default response untuk web routes adalah HTML view.

### 8.2 JSON Response

Beberapa route mendukung JSON response untuk AJAX:
- Cart operations
- Address operations
- Filter dan sorting produk

**Condition**: Check `$request->wantsJson()` atau `$request->ajax()`

---

**Catatan**: Semua route menggunakan Laravel routing system dengan model binding, middleware, dan validation. Untuk production, pertimbangkan untuk menambahkan API rate limiting dan API documentation tools seperti Swagger/OpenAPI.
