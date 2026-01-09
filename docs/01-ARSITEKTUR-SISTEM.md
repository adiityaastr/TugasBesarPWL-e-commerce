# Arsitektur Sistem Herbamart E-Commerce

## 1. Pendahuluan

Dokumen ini menjelaskan arsitektur sistem Herbamart E-Commerce secara detail, termasuk pola desain, struktur aplikasi, dan alur kerja sistem.

## 2. Arsitektur Umum

### 2.1 Model Arsitektur

Aplikasi Herbamart menggunakan arsitektur **Model-View-Controller (MVC)** yang merupakan pola standar dalam framework Laravel.

```
┌─────────────┐
│   Browser   │
└──────┬──────┘
       │ HTTP Request
       ▼
┌─────────────────────────────────────┐
│         Laravel Application         │
│  ┌──────────┐  ┌──────────┐        │
│  │  Routes  │─▶│Controller│        │
│  └──────────┘  └────┬─────┘        │
│                     │               │
│              ┌──────▼──────┐        │
│              │   Models    │        │
│              └──────┬──────┘        │
│                     │               │
│              ┌──────▼──────┐        │
│              │  Database   │        │
│              └─────────────┘        │
│                     │               │
│              ┌──────▼──────┐        │
│              │   Views    │        │
│              └────────────┘        │
└─────────────────────────────────────┘
```

### 2.2 Layer Architecture

Sistem dibagi menjadi beberapa layer:

1. **Presentation Layer** (View)
   - Blade templates untuk rendering HTML
   - JavaScript (Alpine.js + Vanilla JS) untuk interaktivitas
   - Tailwind CSS untuk styling

2. **Application Layer** (Controller)
   - Menangani HTTP request/response
   - Validasi input
   - Business logic coordination
   - Session management

3. **Domain Layer** (Model)
   - Eloquent ORM models
   - Business logic
   - Data relationships

4. **Data Access Layer**
   - Database migrations
   - Query builders
   - Eloquent relationships

## 3. Pola Desain yang Digunakan

### 3.1 Repository Pattern (Implicit)

Meskipun tidak menggunakan repository pattern secara eksplisit, Laravel Eloquent ORM mengimplementasikan konsep repository pattern di balik layar. Model Eloquent bertindak sebagai repository.

### 3.2 Service Layer Pattern

Beberapa logika bisnis kompleks diimplementasikan di controller, namun dapat di-refactor menjadi service classes untuk maintainability yang lebih baik.

**Contoh:**
- Order processing logic di `OrderController::store()`
- Address management di `AddressController`
- Cart management di `CartController`

### 3.3 Middleware Pattern

Laravel middleware digunakan untuk:
- Authentication (`auth`)
- Authorization (`admin` middleware)
- Custom business rules (`no_admin_shop`)

### 3.4 Factory Pattern

Laravel menggunakan factory pattern untuk:
- Model factories (UserFactory)
- Database seeding
- Testing

## 4. Struktur Direktori dan Organisasi Kode

### 4.1 Struktur Direktori Utama

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/              # Admin-specific controllers
│   │   ├── Auth/               # Authentication controllers
│   │   └── [Other Controllers] # Public/Customer controllers
│   ├── Middleware/             # Custom middleware
│   └── Requests/               # Form request validation
├── Models/                      # Eloquent models
├── Providers/                   # Service providers
└── View/                        # View components

resources/
├── views/
│   ├── admin/                   # Admin views
│   ├── auth/                    # Authentication views
│   ├── components/              # Reusable components
│   ├── layouts/                 # Layout templates
│   └── [Feature views]          # Feature-specific views
├── css/                         # Stylesheets
└── js/                          # JavaScript files

routes/
├── web.php                      # Web routes
└── auth.php                     # Authentication routes
```

### 4.2 Organisasi Controller

Controller diorganisir berdasarkan fungsionalitas:

- **ProductController**: Menangani produk (public dan admin)
- **OrderController**: Menangani pesanan customer
- **CartController**: Menangani keranjang belanja
- **AddressController**: Menangani alamat pengiriman
- **ComplaintController**: Menangani komplain
- **Admin/DashboardController**: Dashboard dan manajemen admin

### 4.3 Organisasi View

View diorganisir berdasarkan:
- **Role-based**: `admin/`, `auth/`
- **Feature-based**: `products/`, `orders/`, `cart/`, `checkout/`
- **Component-based**: `components/`, `layouts/`

## 5. Alur Request-Response

### 5.1 Alur Request Standar

```
1. User Request
   ↓
2. Route Matching (web.php)
   ↓
3. Middleware Stack
   - Authentication
   - Authorization
   - Custom Middleware
   ↓
4. Controller Method
   - Validation
   - Business Logic
   - Model Interaction
   ↓
5. View Rendering
   - Blade Template
   - Data Binding
   ↓
6. Response to Browser
```

### 5.2 Contoh Alur: Menambahkan Produk ke Keranjang

```
1. User klik "Tambah ke Keranjang"
   ↓
2. JavaScript (AJAX) mengirim POST request ke /cart
   ↓
3. Route: POST /cart → CartController@store
   ↓
4. Middleware: auth, verified, no_admin_shop
   ↓
5. CartController::store()
   - Validasi input
   - Cek stok produk
   - Update/create cart item
   ↓
6. Response JSON
   - success: true
   - cartCount: updated count
   ↓
7. JavaScript update UI
   - Update badge cart
   - Show notification
   - No page refresh
```

## 6. Authentication dan Authorization

### 6.1 Authentication Flow

Aplikasi menggunakan Laravel Breeze untuk authentication:

```
Registration/Login
   ↓
Email Verification (optional)
   ↓
Session Creation
   ↓
Role-based Access Control
```

### 6.2 Role System

Sistem menggunakan role-based access control dengan dua role utama:

- **customer**: Pengguna biasa yang dapat berbelanja
- **admin**: Administrator yang mengelola sistem

**Implementasi:**
- Field `role` di tabel `users`
- Middleware `admin` untuk proteksi route admin
- Middleware `no_admin_shop` untuk mencegah admin berbelanja

### 6.3 Authorization Points

1. **Route Level**: Middleware di route definition
2. **Controller Level**: Manual check di controller method
3. **View Level**: Conditional rendering berdasarkan role

## 7. Data Flow

### 7.1 Create Order Flow

```
1. Customer menambahkan produk ke cart
   ↓
2. Cart items disimpan di database (carts table)
   ↓
3. Customer checkout
   ↓
4. OrderController::store()
   - Validasi cart items
   - Validasi alamat
   - Calculate total price
   - Create order record
   - Create order_items records
   - Decrement product stock
   - Clear cart
   ↓
5. Order created dengan status 'proses'
   ↓
6. Admin update status order
   ↓
7. Customer complete order
   ↓
8. Payment status: 'released'
```

### 7.2 State Management

**Order Status Flow:**
```
proses → pengemasan → pengiriman → sudah_sampai → selesai
                                    ↓
                            pending_cancellation → cancelled
```

**Payment Status Flow:**
```
pending → released (setelah order selesai)
```

## 8. Frontend Architecture

### 8.1 JavaScript Architecture

Aplikasi menggunakan kombinasi:

1. **Alpine.js**: Untuk interaktivitas komponen
   - Dropdown menus
   - Modal dialogs
   - Form interactions

2. **Vanilla JavaScript**: Untuk AJAX dan custom logic
   - Cart operations
   - Address management
   - Dynamic form updates
   - Notifications

### 8.2 AJAX Implementation

Semua operasi cart dan beberapa operasi lainnya menggunakan AJAX untuk:
- No page refresh
- Better user experience
- Real-time updates

**Pattern:**
```javascript
fetch(url, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
    },
    body: JSON.stringify(data)
})
.then(response => response.json())
.then(data => {
    // Update UI
})
```

### 8.3 CSS Architecture

- **Tailwind CSS**: Utility-first CSS framework
- **Custom CSS**: Minimal, hanya untuk custom styling
- **Responsive Design**: Mobile-first approach

## 9. Security Architecture

### 9.1 Security Measures

1. **CSRF Protection**: Laravel CSRF token untuk semua form
2. **SQL Injection Prevention**: Eloquent ORM dengan parameter binding
3. **XSS Protection**: Blade template auto-escaping
4. **Authentication**: Laravel Breeze dengan password hashing
5. **Authorization**: Role-based access control
6. **Input Validation**: Form request validation
7. **File Upload Security**: Validation dan storage isolation

### 9.2 Data Protection

- Password hashing menggunakan bcrypt
- Sensitive data tidak disimpan di session
- Order number menggunakan random alphanumeric untuk keamanan

## 10. Scalability Considerations

### 10.1 Current Architecture Limitations

- Monolithic architecture (semua fitur dalam satu aplikasi)
- Single database instance
- File storage lokal

### 10.2 Potential Improvements

1. **Database Optimization**:
   - Indexing pada kolom yang sering di-query
   - Query optimization
   - Database caching

2. **Caching Strategy**:
   - Cache product listings
   - Cache user sessions
   - Cache API responses

3. **File Storage**:
   - Move to cloud storage (S3, etc.)
   - CDN for static assets

4. **Queue System**:
   - Background jobs untuk email
   - Image processing
   - Report generation

## 11. Integration Points

### 11.1 External APIs

**EMSIFA API Wilayah Indonesia**
- Endpoint: Untuk mendapatkan data provinsi/kota/kecamatan/kelurahan
- Fallback: Manual input jika API tidak tersedia
- Implementation: JavaScript fetch di frontend

### 11.2 Payment Gateway (Future)

Saat ini payment method hanya simulasi. Untuk production:
- Integrate payment gateway (Midtrans, Xendit, etc.)
- Webhook handling untuk payment confirmation
- Payment status synchronization

## 12. Error Handling

### 12.1 Error Handling Strategy

1. **Validation Errors**: Ditampilkan di form dengan error messages
2. **Database Errors**: Ditangani dengan try-catch dan transaction rollback
3. **Authorization Errors**: 403 Forbidden response
4. **Not Found Errors**: 404 Not Found response
5. **Server Errors**: 500 error dengan error logging

### 12.2 Transaction Management

Operasi kritis menggunakan database transactions:
- Order creation
- Stock updates
- Address management

**Pattern:**
```php
DB::beginTransaction();
try {
    // Critical operations
    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
    // Error handling
}
```

## 13. Logging and Monitoring

### 13.1 Logging

Laravel logging system digunakan untuk:
- Error logging
- Query logging (development)
- Custom application logs

### 13.2 Monitoring Points

- Order creation rate
- Error rate
- Response time
- Database query performance

## 14. Testing Architecture

### 14.1 Testing Strategy

- **Unit Tests**: Model methods, helper functions
- **Feature Tests**: HTTP requests, authentication, authorization
- **Integration Tests**: Database operations, external API calls

### 14.2 Test Structure

```
tests/
├── Feature/
│   ├── Auth/           # Authentication tests
│   └── [Feature]/      # Feature-specific tests
└── Unit/
    └── [Model]/        # Model tests
```

## 15. Deployment Architecture

### 15.1 Development Environment

- Local server dengan `php artisan serve`
- Vite dev server untuk frontend
- SQLite atau MySQL lokal

### 15.2 Production Considerations

- Web server (Nginx/Apache)
- PHP-FPM
- Database server
- File storage
- SSL certificate
- Environment configuration

---

**Catatan**: Arsitektur ini dirancang untuk aplikasi e-commerce skala menengah. Untuk skala yang lebih besar, pertimbangkan microservices architecture atau service-oriented architecture.
