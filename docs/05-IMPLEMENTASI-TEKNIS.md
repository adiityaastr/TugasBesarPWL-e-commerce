# Implementasi Teknis Herbamart E-Commerce

## 1. Pendahuluan

Dokumen ini menjelaskan detail implementasi teknis dari berbagai fitur dalam aplikasi Herbamart E-Commerce, termasuk algoritma, logika bisnis, dan teknik-teknik yang digunakan.

## 2. Implementasi Order Processing

### 2.1 Order Creation Flow

**Lokasi**: `app/Http/Controllers/OrderController.php::store()`

**Algoritma:**

```php
1. Validasi input (address, shipping method, payment method)
2. Hitung shipping cost berdasarkan metode
3. Begin database transaction
4. Ambil cart items dengan lock (lockForUpdate)
5. Untuk setiap cart item:
   a. Cek produk masih ada
   b. Cek stok cukup
   c. Lock produk untuk update
   d. Decrement stock
   e. Hitung subtotal
6. Hitung total price (subtotal + shipping)
7. Generate order number unik
8. Create order record
9. Create order items records
10. Clear cart
11. Commit transaction
12. Jika error, rollback transaction
```

**Penting:**
- Menggunakan database transaction untuk atomicity
- `lockForUpdate()` untuk mencegah race condition pada stock
- Rollback otomatis jika ada error

### 2.2 Order Number Generation

**Lokasi**: `app/Http/Controllers/OrderController.php::generateOrderNumber()`

**Algoritma:**

```php
do {
    $code = 'HM-' . Str::upper(Str::random(10));
} while (Order::where('order_number', $code)->exists());

return $code;
```

**Karakteristik:**
- Format: `HM-{10 random alphanumeric uppercase}`
- Unik check sebelum return
- Retry jika duplicate (sangat jarang terjadi)

## 3. Implementasi Cart Management

### 3.1 Add to Cart

**Lokasi**: `app/Http/Controllers/CartController.php::store()`

**Algoritma:**

```php
1. Validasi product_id dan quantity
2. Cek produk ada
3. Cek stok cukup
4. Cek apakah produk sudah ada di cart user
5. Jika sudah ada:
   - Update quantity (tambah dengan quantity baru)
6. Jika belum ada:
   - Create cart item baru
7. Hitung cart count
8. Return response (JSON untuk AJAX)
```

**Optimasi:**
- Single query untuk check existing cart item
- Update quantity instead of create duplicate

### 3.2 Update Cart Quantity

**Lokasi**: `app/Http/Controllers/CartController.php::update()`

**Validasi:**
- Quantity >= 1
- Stok produk >= quantity yang diminta

**Response Format:**
```json
{
  "success": true,
  "message": "Cart updated.",
  "cartCount": 5
}
```

## 4. Implementasi Product Filtering dan Sorting

### 4.1 Multi-Category Filter

**Lokasi**: `app/Http/Controllers/ProductController.php::index()`

**Implementasi:**

```php
$selectedCategories = collect((array) $request->input('categories', $request->input('category')))
    ->filter()
    ->values();

if ($selectedCategories->isNotEmpty()) {
    $query->whereIn('category', $selectedCategories);
}
```

**Fitur:**
- Support single category (legacy) dan multiple categories
- Filter null/empty values
- Case-sensitive matching

### 4.2 Best Selling Sort

**Lokasi**: `app/Http/Controllers/ProductController.php::index()`

**Implementasi:**

```php
$salesSub = \DB::table('order_items')
    ->selectRaw('order_items.product_id, SUM(order_items.quantity) as total_sold')
    ->join('orders', 'order_items.order_id', '=', 'orders.id')
    ->where('orders.status', 'selesai')
    ->groupBy('order_items.product_id');

$query->leftJoinSub($salesSub, 'sales', function ($join) {
    $join->on('products.id', '=', 'sales.product_id');
})->select('products.*', \DB::raw('COALESCE(sales.total_sold, 0) as total_sold'))
  ->orderByDesc('total_sold');
```

**Penjelasan:**
- Subquery untuk menghitung total penjualan per produk
- Hanya menghitung dari order yang status 'selesai'
- Left join untuk include produk yang belum pernah dijual
- COALESCE untuk set 0 jika null

## 5. Implementasi Address Management

### 5.1 Set Default Address

**Lokasi**: `app/Http/Controllers/AddressController.php::setDefault()`

**Algoritma:**

```php
DB::transaction(function () use ($address) {
    // Unset semua alamat default user
    Address::where('user_id', Auth::id())
        ->update(['is_default' => false]);
    
    // Set alamat ini sebagai default
    $address->update(['is_default' => true]);
});
```

**Penting:**
- Menggunakan transaction untuk atomicity
- Hanya satu alamat default per user
- Unset semua sebelum set yang baru

### 5.2 Address API Integration

**Frontend Implementation:**

```javascript
// Fetch provinsi
fetch('https://emsifa.github.io/api-wilayah-indonesia/api/provinces.json')
    .then(response => response.json())
    .then(data => {
        // Populate provinsi dropdown
    });

// Fetch kota berdasarkan provinsi
fetch(`https://emsifa.github.io/api-wilayah-indonesia/api/regencies/${provinceId}.json`)
    .then(response => response.json())
    .then(data => {
        // Populate kota dropdown
    });
```

**Fallback:**
- Jika API tidak tersedia, form menjadi manual input
- Tidak ada validasi khusus untuk data dari API

## 6. Implementasi Stock Management

### 6.1 Stock Decrement

**Lokasi**: `app/Http/Controllers/OrderController.php::store()`

**Implementasi:**

```php
foreach ($cartItems as $item) {
    $product = \App\Models\Product::lockForUpdate()->find($item->product_id);
    
    if ($product->stock < $item->quantity) {
        throw new \Exception("Product {$product->name} is out of stock.");
    }
    
    $product->decrement('stock', $item->quantity);
}
```

**Penting:**
- `lockForUpdate()` untuk mencegah race condition
- Cek stok sebelum decrement
- Throw exception jika stok tidak cukup

### 6.2 Stock Restoration

**Lokasi**: `app/Http/Controllers/Admin/DashboardController.php::approveCancellation()`

**Implementasi:**

```php
foreach ($order->items as $item) {
    $product = $item->product;
    if ($product) {
        $product->increment('stock', $item->quantity);
    }
}
```

**Penting:**
- Restore stock saat order dibatalkan
- Cek produk masih ada sebelum increment

## 7. Implementasi AJAX Operations

### 7.1 AJAX Pattern

**Frontend Pattern:**

```javascript
// Setup CSRF token
const token = document.querySelector('meta[name="csrf-token"]').content;

// AJAX request
fetch(url, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token,
        'Accept': 'application/json'
    },
    body: JSON.stringify(data)
})
.then(response => response.json())
.then(data => {
    if (data.success) {
        // Update UI
        updateCartBadge(data.cartCount);
        showNotification(data.message, 'success');
    } else {
        showNotification(data.message, 'error');
    }
})
.catch(error => {
    showNotification('Terjadi kesalahan', 'error');
});
```

**Backend Pattern:**

```php
if ($request->wantsJson() || $request->ajax()) {
    return response()->json([
        'success' => true,
        'message' => 'Operation successful',
        'data' => $data
    ]);
}

return back()->with('success', 'Operation successful');
```

### 7.2 Real-time Cart Updates

**Implementation:**

```javascript
// Update cart badge
function updateCartBadge(count) {
    const badge = document.querySelector('.cart-badge');
    if (badge) {
        badge.textContent = count;
        badge.style.display = count > 0 ? 'block' : 'none';
    }
}

// Update cart total
function updateCartTotal(total) {
    const totalElement = document.querySelector('.cart-total');
    if (totalElement) {
        totalElement.textContent = formatCurrency(total);
    }
}
```

## 8. Implementasi Order Status Management

### 8.1 Status Transition Rules

**Valid Transitions:**

```
proses → pengemasan → pengiriman → sudah_sampai → selesai
                                    ↓
                            pending_cancellation → cancelled
```

**Implementation:**

```php
// Admin update status
if ($request->status === 'selesai') {
    return back()->with('error', 'Admin tidak dapat menyelesaikan pesanan.');
}

if ($order->status === 'selesai' || $order->payment_status === 'released') {
    return back()->with('error', 'Pesanan sudah selesai.');
}

if ($request->status === 'cancelled') {
    if ($order->status !== 'pending_cancellation') {
        return back()->with('error', 'Invalid status transition.');
    }
    // Restore stock
}
```

### 8.2 Auto-Complete Order

**Implementation (Scheduled Task):**

```php
// app/Console/Kernel.php
protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        $orders = Order::where('status', 'sudah_sampai')
            ->where('created_at', '<=', now()->subDays(3))
            ->get();
        
        foreach ($orders as $order) {
            $order->update([
                'status' => 'selesai',
                'payment_status' => 'released'
            ]);
        }
    })->daily();
}
```

## 9. Implementasi File Upload

### 9.1 Product Image Upload

**Lokasi**: `app/Http/Controllers/ProductController.php::store()`

**Implementation:**

```php
$imagePath = null;
if ($request->hasFile('image')) {
    $imagePath = $request->file('image')->store('products', 'public');
}

Product::create([
    // ...
    'image' => $imagePath,
]);
```

**Validation:**
- `image|mimes:jpeg,png,jpg,gif|max:2048`
- Stored di `storage/app/public/products`
- Public access via `storage:link`

### 9.2 Image Deletion

**Implementation:**

```php
if ($request->hasFile('image')) {
    // Delete old image
    if ($product->image) {
        Storage::disk('public')->delete($product->image);
    }
    $product->image = $request->file('image')->store('products', 'public');
}
```

## 10. Implementasi Review System

### 10.1 Review Creation

**Lokasi**: `app/Http/Controllers/OrderController.php::complete()`

**Implementation:**

```php
if ($request->has('reviews')) {
    foreach ($request->reviews as $reviewData) {
        $imagePath = null;
        if (isset($reviewData['image']) && $reviewData['image'] instanceof \Illuminate\Http\UploadedFile) {
            $imagePath = $reviewData['image']->store('review-images', 'public');
        }

        \App\Models\Review::create([
            'user_id' => Auth::id(),
            'product_id' => $reviewData['product_id'],
            'order_id' => $order->id,
            'rating' => $reviewData['rating'],
            'comment' => $reviewData['comment'] ?? null,
            'image_path' => $imagePath,
        ]);
    }
}
```

**Validation:**
- Rating: 1-5
- Comment: optional
- Image: optional, max 2MB

## 11. Implementasi Dashboard Statistics

### 11.1 Monthly Revenue Chart

**Lokasi**: `app/Http/Controllers/Admin/DashboardController.php::index()`

**Implementation:**

```php
$monthlyRevenue = Order::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_price) as revenue')
    ->where('created_at', '>=', now()->subMonths(6))
    ->where('status', 'selesai')
    ->groupBy('month')
    ->orderBy('month')
    ->get();

$revenueLabels = $monthlyRevenue->pluck('month')->map(function($month) {
    return date('M Y', strtotime($month . '-01'));
})->toArray();

$revenueData = $monthlyRevenue->pluck('revenue')->toArray();
```

**Penjelasan:**
- Hanya menghitung dari order yang status 'selesai'
- 6 bulan terakhir
- Format label: "Jan 2024"

### 11.2 Top Products Chart

**Implementation:**

```php
$topProducts = \App\Models\OrderItem::selectRaw('order_items.product_id, SUM(order_items.quantity) as total_sold')
    ->join('orders', 'order_items.order_id', '=', 'orders.id')
    ->where('orders.status', 'selesai')
    ->groupBy('order_items.product_id')
    ->orderByDesc('total_sold')
    ->take(5)
    ->get();

$productIds = $topProducts->pluck('product_id')->toArray();
$products = Product::whereIn('id', $productIds)->get()->keyBy('id');

$productLabels = $topProducts->map(function($item) use ($products) {
    return $products->get($item->product_id)?->name ?? 'Unknown';
})->toArray();
```

## 12. Implementasi Security

### 12.1 CSRF Protection

**Implementation:**

```blade
{{-- Meta tag --}}
<meta name="csrf-token" content="{{ csrf_token() }}">

{{-- Form --}}
@csrf

{{-- AJAX --}}
headers: {
    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
}
```

### 12.2 Authorization Checks

**Implementation:**

```php
// Route level
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin routes
});

// Controller level
if ($order->user_id !== Auth::id()) {
    abort(403);
}

// View level
@if(Auth::user()->role === 'admin')
    // Admin content
@endif
```

### 12.3 Input Validation

**Implementation:**

```php
$request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|unique:users',
    'password' => 'required|min:8|confirmed',
]);
```

## 13. Implementasi Error Handling

### 13.1 Transaction Rollback

**Pattern:**

```php
try {
    DB::beginTransaction();
    
    // Critical operations
    
    DB::commit();
} catch (\Exception $e) {
    DB::rollBack();
    return back()->with('error', 'Operation failed: ' . $e->getMessage());
}
```

### 13.2 Exception Handling

**Implementation:**

```php
if (!$product) {
    throw new \Exception("Product not found.");
}

if ($product->stock < $quantity) {
    throw new \Exception("Insufficient stock.");
}
```

## 14. Implementasi Frontend Interactivity

### 14.1 Alpine.js Integration

**Example:**

```html
<div x-data="{ open: false }">
    <button @click="open = !open">Toggle</button>
    <div x-show="open">Content</div>
</div>
```

### 14.2 Notification System

**Implementation:**

```javascript
function showNotification(message, type = 'success') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.remove();
    }, 3000);
}
```

## 15. Optimasi Query

### 15.1 Eager Loading

**Implementation:**

```php
// N+1 Problem
$orders = Order::all();
foreach ($orders as $order) {
    echo $order->user->name; // Query per order
}

// Solution: Eager Loading
$orders = Order::with('user')->get();
foreach ($orders as $order) {
    echo $order->user->name; // No additional query
}
```

### 15.2 Query Optimization

**Example:**

```php
// Bad: Multiple queries
$products = Product::all();
foreach ($products as $product) {
    $product->reviews_count = Review::where('product_id', $product->id)->count();
}

// Good: Single query with aggregation
$products = Product::withCount('reviews')->get();
```

---

**Catatan**: Implementasi ini menggunakan best practices Laravel dan PHP. Untuk production, pertimbangkan untuk menambahkan caching, queue system untuk heavy operations, dan optimasi database indexes.
