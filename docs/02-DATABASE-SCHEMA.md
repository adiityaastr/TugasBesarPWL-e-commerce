# Database Schema Documentation

## 1. Pendahuluan

Dokumen ini menjelaskan struktur database Herbamart E-Commerce secara lengkap, termasuk semua tabel, relasi, constraints, dan business rules.

## 2. Entity Relationship Diagram (ERD) Konseptual

```
┌─────────────┐
│    Users    │
│─────────────│
│ id (PK)     │
│ name        │
│ username    │
│ email       │
│ password    │
│ role        │
│ ...         │
└──────┬──────┘
       │
       │ 1:N
       │
       ├─────────────────────────────────┐
       │                                 │
       ▼                                 ▼
┌─────────────┐                  ┌─────────────┐
│   Orders    │                  │  Addresses  │
│─────────────│                  │─────────────│
│ id (PK)     │                  │ id (PK)     │
│ user_id(FK) │                  │ user_id(FK) │
│ order_number│                  │ recipient_ │
│ total_price │                  │   name      │
│ status      │                  │ shipping_   │
│ ...         │                  │   address  │
└──────┬──────┘                  │ ...         │
       │                         └─────────────┘
       │ 1:N
       │
       ├─────────────────────────┐
       │                         │
       ▼                         ▼
┌─────────────┐          ┌─────────────┐
│ Order Items │          │ Complaints  │
│─────────────│          │─────────────│
│ id (PK)     │          │ id (PK)     │
│ order_id(FK)│          │ order_id(FK)│
│ product_id  │          │ user_id(FK) │
│ quantity    │          │ title       │
│ price       │          │ detail      │
└──────┬──────┘          │ status      │
       │                 │ ...         │
       │ N:1             └─────────────┘
       │
       ▼
┌─────────────┐
│  Products   │
│─────────────│
│ id (PK)     │
│ name        │
│ slug        │
│ description │
│ price       │
│ stock       │
│ image       │
│ category    │
└──────┬──────┘
       │
       │ 1:N
       │
       ├─────────────────────────┐
       │                         │
       ▼                         ▼
┌─────────────┐          ┌─────────────┐
│    Carts    │          │   Reviews   │
│─────────────│          │─────────────│
│ id (PK)     │          │ id (PK)     │
│ user_id(FK) │          │ user_id(FK) │
│ product_id  │          │ product_id  │
│ quantity    │          │ order_id(FK)│
└─────────────┘          │ rating      │
                        │ comment     │
                        │ image_path  │
                        └─────────────┘
```

## 3. Tabel Database

### 3.1 Tabel `users`

Tabel untuk menyimpan data pengguna (customer dan admin).

| Kolom | Tipe | Constraints | Deskripsi |
|-------|------|-------------|-----------|
| id | bigint unsigned | PRIMARY KEY, AUTO_INCREMENT | ID unik pengguna |
| name | varchar(255) | NOT NULL | Nama pengguna |
| username | varchar(255) | NULLABLE | Username pengguna |
| full_name | varchar(255) | NULLABLE | Nama lengkap |
| profile_photo_path | text | NULLABLE | Path foto profil |
| email | varchar(255) | UNIQUE, NOT NULL | Email pengguna (unik) |
| email_verified_at | timestamp | NULLABLE | Waktu verifikasi email |
| password | varchar(255) | NOT NULL | Password ter-hash |
| role | varchar(255) | DEFAULT 'customer' | Role: 'customer' atau 'admin' |
| remember_token | varchar(100) | NULLABLE | Token untuk remember me |
| created_at | timestamp | NULLABLE | Waktu pembuatan |
| updated_at | timestamp | NULLABLE | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY: `id`
- UNIQUE: `email`

**Relationships:**
- `hasMany` Orders
- `hasMany` Addresses
- `hasMany` Carts
- `hasMany` Reviews
- `hasMany` Complaints

**Business Rules:**
- Email harus unik
- Password di-hash menggunakan bcrypt
- Role default adalah 'customer'
- Admin tidak dapat berbelanja (dicegah di middleware)

### 3.2 Tabel `products`

Tabel untuk menyimpan data produk.

| Kolom | Tipe | Constraints | Deskripsi |
|-------|------|-------------|-----------|
| id | bigint unsigned | PRIMARY KEY, AUTO_INCREMENT | ID unik produk |
| name | varchar(255) | NOT NULL | Nama produk |
| slug | varchar(255) | UNIQUE, NOT NULL | URL-friendly identifier |
| description | text | NOT NULL | Deskripsi produk |
| price | decimal(10,2) | NOT NULL | Harga produk |
| stock | integer | NOT NULL | Stok tersedia |
| image | varchar(255) | NULLABLE | Path gambar produk |
| category | varchar(255) | NULLABLE | Kategori produk |
| created_at | timestamp | NULLABLE | Waktu pembuatan |
| updated_at | timestamp | NULLABLE | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY: `id`
- UNIQUE: `slug`

**Relationships:**
- `hasMany` OrderItems
- `hasMany` Carts
- `hasMany` Reviews

**Business Rules:**
- Slug harus unik (format: nama-produk-{uniqid})
- Price harus >= 0
- Stock harus >= 0
- Stock dikurangi saat order dibuat
- Stock dikembalikan saat order dibatalkan

**Kategori Standar:**
- Jamu Tradisional
- Suplemen Alami
- Madu & Propolis
- Teh & Infus Herbal
- Minyak Atsiri
- Aromaterapi

### 3.3 Tabel `carts`

Tabel untuk menyimpan item keranjang belanja pengguna.

| Kolom | Tipe | Constraints | Deskripsi |
|-------|------|-------------|-----------|
| id | bigint unsigned | PRIMARY KEY, AUTO_INCREMENT | ID unik cart item |
| user_id | bigint unsigned | FOREIGN KEY, NOT NULL | ID pengguna |
| product_id | bigint unsigned | FOREIGN KEY, NOT NULL | ID produk |
| quantity | integer | NOT NULL | Jumlah produk |
| created_at | timestamp | NULLABLE | Waktu pembuatan |
| updated_at | timestamp | NULLABLE | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY: `id`
- FOREIGN KEY: `user_id` → `users.id` (ON DELETE CASCADE)
- FOREIGN KEY: `product_id` → `products.id` (ON DELETE CASCADE)

**Relationships:**
- `belongsTo` User
- `belongsTo` Product

**Business Rules:**
- Quantity harus >= 1
- Stok dicek sebelum menambahkan ke cart
- Cart dihapus setelah order dibuat
- Satu user dapat memiliki multiple cart items

### 3.4 Tabel `orders`

Tabel untuk menyimpan data pesanan.

| Kolom | Tipe | Constraints | Deskripsi |
|-------|------|-------------|-----------|
| id | bigint unsigned | PRIMARY KEY, AUTO_INCREMENT | ID unik pesanan |
| user_id | bigint unsigned | FOREIGN KEY, NOT NULL | ID pengguna |
| order_number | varchar(255) | UNIQUE, NOT NULL | Nomor pesanan (HM-XXXXXXXXXX) |
| total_price | decimal(10,2) | NOT NULL | Total harga termasuk shipping |
| status | varchar(255) | DEFAULT 'proses' | Status pesanan |
| cancellation_reason | text | NULLABLE | Alasan pembatalan |
| shipping_address | text | NOT NULL | Alamat pengiriman |
| provinsi | varchar(255) | NULLABLE | Provinsi |
| kota | varchar(255) | NULLABLE | Kota |
| kecamatan | varchar(255) | NULLABLE | Kecamatan |
| kelurahan | varchar(255) | NULLABLE | Kelurahan |
| kode_pos | varchar(10) | NULLABLE | Kode pos |
| shipping_method | varchar(255) | NOT NULL | Metode pengiriman |
| shipping_cost | decimal(10,2) | NOT NULL | Biaya pengiriman |
| payment_method | varchar(255) | NOT NULL | Metode pembayaran |
| payment_status | varchar(255) | DEFAULT 'pending' | Status pembayaran |
| created_at | timestamp | NULLABLE | Waktu pembuatan |
| updated_at | timestamp | NULLABLE | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY: `id`
- UNIQUE: `order_number`
- FOREIGN KEY: `user_id` → `users.id` (ON DELETE CASCADE)

**Relationships:**
- `belongsTo` User
- `hasMany` OrderItems
- `hasMany` Reviews
- `hasMany` Complaints

**Status Values:**
- `proses`: Pesanan sedang diproses
- `pengemasan`: Produk sedang dikemas
- `pengiriman`: Produk sedang dalam perjalanan
- `sudah_sampai`: Produk sudah sampai, menunggu konfirmasi
- `selesai`: Pesanan selesai
- `pending_cancellation`: Menunggu konfirmasi pembatalan
- `cancelled`: Pesanan dibatalkan

**Payment Status Values:**
- `pending`: Menunggu pembayaran
- `released`: Pembayaran sudah direlease

**Shipping Methods:**
- `reguler`: Pengiriman reguler (Rp 15.000)
- `kargo`: Pengiriman kargo (Rp 10.000)
- `same_day`: Pengiriman same day (Rp 30.000)

**Payment Methods:**
- `bank_transfer`: Transfer Bank
- `credit_card`: Kartu Kredit/Debit
- `cod`: Cash on Delivery

**Business Rules:**
- Order number unik dengan format: HM-{10 random alphanumeric}
- Total price = sum(order_items) + shipping_cost
- Status hanya bisa diubah oleh admin (kecuali selesai)
- Status 'selesai' hanya bisa diubah oleh customer
- Auto-complete setelah 3 hari jika status 'sudah_sampai'
- Payment status otomatis 'released' saat status 'selesai'
- Stok dikurangi saat order dibuat
- Stok dikembalikan saat order dibatalkan

### 3.5 Tabel `order_items`

Tabel untuk menyimpan item-item dalam pesanan.

| Kolom | Tipe | Constraints | Deskripsi |
|-------|------|-------------|-----------|
| id | bigint unsigned | PRIMARY KEY, AUTO_INCREMENT | ID unik item |
| order_id | bigint unsigned | FOREIGN KEY, NOT NULL | ID pesanan |
| product_id | bigint unsigned | FOREIGN KEY, NOT NULL | ID produk |
| quantity | integer | NOT NULL | Jumlah produk |
| price | decimal(10,2) | NOT NULL | Harga per unit saat order |
| created_at | timestamp | NULLABLE | Waktu pembuatan |
| updated_at | timestamp | NULLABLE | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY: `id`
- FOREIGN KEY: `order_id` → `orders.id` (ON DELETE CASCADE)
- FOREIGN KEY: `product_id` → `products.id` (ON DELETE CASCADE)

**Relationships:**
- `belongsTo` Order
- `belongsTo` Product

**Business Rules:**
- Price disimpan saat order dibuat (snapshot)
- Quantity harus >= 1
- Total order = sum(quantity * price) dari semua order_items

### 3.6 Tabel `addresses`

Tabel untuk menyimpan alamat pengiriman pengguna.

| Kolom | Tipe | Constraints | Deskripsi |
|-------|------|-------------|-----------|
| id | bigint unsigned | PRIMARY KEY, AUTO_INCREMENT | ID unik alamat |
| user_id | bigint unsigned | FOREIGN KEY, NOT NULL | ID pengguna |
| recipient_name | varchar(255) | NOT NULL | Nama penerima |
| shipping_address | text | NOT NULL | Alamat lengkap |
| provinsi | varchar(255) | NULLABLE | Provinsi |
| kota | varchar(255) | NULLABLE | Kota |
| kecamatan | varchar(255) | NULLABLE | Kecamatan |
| kelurahan | varchar(255) | NULLABLE | Kelurahan |
| kode_pos | varchar(10) | NULLABLE | Kode pos |
| is_default | boolean | DEFAULT false | Alamat default |
| created_at | timestamp | NULLABLE | Waktu pembuatan |
| updated_at | timestamp | NULLABLE | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY: `id`
- FOREIGN KEY: `user_id` → `users.id` (ON DELETE CASCADE)

**Relationships:**
- `belongsTo` User

**Business Rules:**
- Satu user dapat memiliki multiple alamat
- Hanya satu alamat yang bisa menjadi default per user
- Alamat default digunakan sebagai default di checkout
- Alamat dapat dihapus jika tidak digunakan dalam order aktif

### 3.7 Tabel `reviews`

Tabel untuk menyimpan ulasan produk dari customer.

| Kolom | Tipe | Constraints | Deskripsi |
|-------|------|-------------|-----------|
| id | bigint unsigned | PRIMARY KEY, AUTO_INCREMENT | ID unik review |
| user_id | bigint unsigned | FOREIGN KEY, NOT NULL | ID pengguna |
| product_id | bigint unsigned | FOREIGN KEY, NOT NULL | ID produk |
| order_id | bigint unsigned | FOREIGN KEY, NOT NULL | ID pesanan |
| rating | integer | NOT NULL | Rating (1-5) |
| comment | text | NULLABLE | Komentar review |
| image_path | varchar(2048) | NULLABLE | Path gambar review |
| created_at | timestamp | NULLABLE | Waktu pembuatan |
| updated_at | timestamp | NULLABLE | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY: `id`
- FOREIGN KEY: `user_id` → `users.id` (ON DELETE CASCADE)
- FOREIGN KEY: `product_id` → `products.id` (ON DELETE CASCADE)
- FOREIGN KEY: `order_id` → `orders.id` (ON DELETE CASCADE)

**Relationships:**
- `belongsTo` User
- `belongsTo` Product
- `belongsTo` Order

**Business Rules:**
- Rating harus antara 1-5
- Review hanya bisa dibuat untuk order yang sudah selesai
- Satu order dapat memiliki multiple reviews (satu per produk)
- Review dapat memiliki gambar

### 3.8 Tabel `complaints`

Tabel untuk menyimpan komplain dari customer.

| Kolom | Tipe | Constraints | Deskripsi |
|-------|------|-------------|-----------|
| id | bigint unsigned | PRIMARY KEY, AUTO_INCREMENT | ID unik komplain |
| order_id | bigint unsigned | FOREIGN KEY, NOT NULL | ID pesanan |
| user_id | bigint unsigned | FOREIGN KEY, NOT NULL | ID pengguna |
| title | varchar(255) | NOT NULL | Judul komplain |
| detail | text | NOT NULL | Detail komplain |
| image_path | varchar(255) | NULLABLE | Path gambar bukti |
| status | enum | DEFAULT 'pending' | Status komplain |
| admin_response | text | NULLABLE | Respons admin |
| created_at | timestamp | NULLABLE | Waktu pembuatan |
| updated_at | timestamp | NULLABLE | Waktu update terakhir |

**Indexes:**
- PRIMARY KEY: `id`
- FOREIGN KEY: `order_id` → `orders.id` (ON DELETE CASCADE)
- FOREIGN KEY: `user_id` → `users.id` (ON DELETE CASCADE)

**Relationships:**
- `belongsTo` Order
- `belongsTo` User

**Status Values:**
- `pending`: Menunggu peninjauan
- `in_progress`: Sedang ditangani
- `resolved`: Sudah diselesaikan
- `rejected`: Ditolak

**Business Rules:**
- Komplain hanya bisa dibuat untuk order yang sudah selesai
- Komplain dapat memiliki gambar bukti
- Admin dapat mengupdate status dan memberikan respons

## 4. Relasi Database

### 4.1 Relasi One-to-Many

1. **User → Orders**: Satu user dapat memiliki banyak pesanan
2. **User → Addresses**: Satu user dapat memiliki banyak alamat
3. **User → Carts**: Satu user dapat memiliki banyak cart items
4. **User → Reviews**: Satu user dapat memberikan banyak review
5. **User → Complaints**: Satu user dapat membuat banyak komplain
6. **Order → OrderItems**: Satu pesanan memiliki banyak item
7. **Order → Reviews**: Satu pesanan dapat memiliki banyak review
8. **Order → Complaints**: Satu pesanan dapat memiliki banyak komplain
9. **Product → OrderItems**: Satu produk dapat ada di banyak order items
10. **Product → Carts**: Satu produk dapat ada di banyak cart
11. **Product → Reviews**: Satu produk dapat memiliki banyak review

### 4.2 Relasi Many-to-One

1. **OrderItems → Order**: Banyak order items milik satu order
2. **OrderItems → Product**: Banyak order items merujuk ke satu produk
3. **Carts → User**: Banyak cart items milik satu user
4. **Carts → Product**: Banyak cart items merujuk ke satu produk
5. **Reviews → User**: Banyak review dari satu user
6. **Reviews → Product**: Banyak review untuk satu produk
7. **Reviews → Order**: Banyak review dari satu order
8. **Complaints → Order**: Banyak komplain untuk satu order
9. **Complaints → User**: Banyak komplain dari satu user

## 5. Constraints dan Validasi

### 5.1 Foreign Key Constraints

Semua foreign key menggunakan `ON DELETE CASCADE` untuk menjaga referential integrity:
- Jika user dihapus, semua data terkait (orders, addresses, carts, dll) juga dihapus
- Jika product dihapus, semua order_items dan carts terkait dihapus
- Jika order dihapus, semua order_items, reviews, dan complaints terkait dihapus

### 5.2 Unique Constraints

- `users.email`: Email harus unik
- `products.slug`: Slug produk harus unik
- `orders.order_number`: Nomor pesanan harus unik

### 5.3 Check Constraints (Business Logic)

Meskipun tidak didefinisikan di database level, validasi dilakukan di application level:
- `products.price >= 0`
- `products.stock >= 0`
- `carts.quantity >= 1`
- `order_items.quantity >= 1`
- `reviews.rating >= 1 AND <= 5`
- `orders.total_price >= 0`

## 6. Indexes

### 6.1 Primary Keys

Semua tabel memiliki primary key `id` dengan auto increment.

### 6.2 Foreign Key Indexes

Semua foreign key otomatis ter-index oleh database untuk performa query.

### 6.3 Recommended Additional Indexes

Untuk optimasi performa, pertimbangkan index pada:
- `orders.status` (untuk filtering)
- `orders.user_id` (untuk query orders per user)
- `orders.created_at` (untuk sorting)
- `products.category` (untuk filtering)
- `products.price` (untuk sorting)
- `reviews.product_id` (untuk query reviews per produk)
- `reviews.rating` (untuk sorting)

## 7. Data Integrity Rules

### 7.1 Stock Management

- Stock dikurangi saat order dibuat
- Stock dikembalikan saat order dibatalkan
- Stock dicek sebelum menambahkan ke cart
- Stock dicek sebelum membuat order

### 7.2 Order State Management

- Order tidak bisa diubah setelah status 'selesai'
- Order tidak bisa dibatalkan setelah status 'selesai'
- Hanya customer yang bisa menyelesaikan order
- Hanya admin yang bisa mengubah status order (kecuali selesai)

### 7.3 Address Management

- Hanya satu alamat default per user
- Alamat tidak bisa dihapus jika digunakan dalam order aktif

## 8. Migration History

### 8.1 Initial Migrations

1. `0001_01_01_000000_create_users_table` - Tabel users
2. `2025_12_07_150804_create_products_table` - Tabel products
3. `2025_12_07_150805_create_orders_table` - Tabel orders
4. `2025_12_07_150806_create_order_items_table` - Tabel order_items
5. `2025_12_07_153232_create_carts_table` - Tabel carts

### 8.2 Feature Migrations

6. `2025_12_08_135154_add_category_to_products_table` - Menambah kategori produk
7. `2025_12_08_154555_add_address_and_shipping_fields_to_orders_table` - Menambah field alamat dan shipping
8. `2025_12_08_170000_add_cancellation_reason_to_orders_table` - Menambah alasan pembatalan
9. `2025_12_09_000000_add_order_number_to_orders_table` - Menambah nomor pesanan
10. `2025_12_10_125640_add_profile_fields_to_users_table` - Menambah field profil
11. `2025_12_10_131614_create_reviews_table` - Tabel reviews
12. `2025_12_19_143511_create_addresses_table` - Tabel addresses
13. `2025_12_19_174449_create_complaints_table` - Tabel complaints

## 9. Database Seeding

### 9.1 Seeders

- **UserSeeder**: Membuat user admin dan customer default
- **CategorySeeder**: Mengisi kategori produk
- **ProductSeeder**: Membuat produk sample

### 9.2 Default Data

**Admin User:**
- Email: `admin@example.com`
- Password: `password`
- Role: `admin`

**Customer User:**
- Email: `user@example.com`
- Password: `password`
- Role: `customer`

## 10. Query Optimization

### 10.1 Eager Loading

Gunakan eager loading untuk menghindari N+1 query problem:
```php
Order::with(['user', 'items.product'])->get();
```

### 10.2 Query Scopes

Pertimbangkan untuk membuat query scopes untuk query yang sering digunakan:
- `Order::completed()`
- `Product::inStock()`
- `User::customers()`

---

**Catatan**: Schema ini dirancang untuk aplikasi e-commerce dengan fokus pada maintainability dan scalability. Untuk production, pertimbangkan untuk menambahkan indexes tambahan dan optimasi query berdasarkan usage patterns.
