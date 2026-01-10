# Diagram PlantUML - Herbamart E-Commerce

Dokumen ini berisi kumpulan diagram PlantUML lengkap untuk sistem Herbamart E-Commerce. Semua diagram dibuat berdasarkan analisis lengkap terhadap seluruh codebase project.

## Daftar Diagram

### 1. Class Diagram
**File**: `01-class-diagram.puml`

Diagram ini menampilkan struktur kelas dalam sistem, termasuk:
- **Models**: User, Product, Order, OrderItem, Cart, Address, Complaint, Review
- **Controllers**: ProductController, OrderController, CartController, AddressController, ComplaintController, OrderCancelController, ProfileController, Admin\DashboardController
- **Middleware**: AdminMiddleware, RedirectAdminFromCustomer
- **Relationships**: Relasi antar model (hasMany, belongsTo) dan penggunaan model oleh controller

### 2. Use Case Diagram
**File**: `02-use-case-diagram.puml`

Diagram ini menampilkan use case untuk semua aktor dalam sistem:
- **Guest User**: Browse products, view product details
- **Customer**: 
  - Authentication & Profile management
  - Shopping (browse, add to cart, checkout)
  - Order management (view, cancel, complete)
  - Address management
  - Review & Complaint submission
- **Admin**:
  - Product management (CRUD)
  - Order management (update status, approve/reject cancellation)
  - Complaint management
  - Dashboard & Reports

### 3. Sequence Diagrams
**File**: 
- `03-sequence-diagram.puml` - Place Order Process
- `03-sequence-diagram-order-cancel.puml` - Order Cancellation Process
- `03-sequence-diagram-complete-order.puml` - Complete Order Process
- `03-sequence-diagram-admin-update-status.puml` - Admin Update Order Status

Sequence diagram menampilkan alur interaksi antar komponen untuk:
- **Place Order**: Proses checkout dari cart hingga order dibuat
- **Order Cancellation**: Alur pembatalan pesanan oleh customer dan review oleh admin
- **Complete Order**: Proses penyelesaian pesanan oleh customer dengan optional reviews
- **Admin Update Status**: Proses admin mengupdate status pesanan

### 4. Activity Diagrams
**File**:
- `04-activity-diagram.puml` - Shopping & Checkout Process
- `04-activity-diagram-order-lifecycle.puml` - Order Lifecycle
- `04-activity-diagram-admin-product-management.puml` - Admin Product Management

Activity diagram menampilkan alur aktivitas untuk:
- **Shopping & Checkout**: Alur lengkap dari browsing produk hingga checkout
- **Order Lifecycle**: Siklus hidup pesanan dari dibuat hingga selesai/dibatalkan
- **Admin Product Management**: Alur CRUD produk oleh admin

### 5. Component Diagram
**File**: `05-component-diagram.puml`

Diagram ini menampilkan arsitektur komponen sistem:
- **Presentation Layer**: Web Browser, Blade Templates, JavaScript/AJAX, CSS/Tailwind
- **Application Layer**: 
  - Laravel Framework (Routing, Middleware, Controllers, Validation)
  - Authentication System
  - Business Logic (Product, Cart, Order, Address, Review, Complaint, Admin Dashboard)
- **Data Layer**: Eloquent ORM, Database, File Storage
- **External Services**: Email Service, Payment Gateway

### 6. Deployment Diagram
**File**: `06-deployment-diagram.puml`

Diagram ini menampilkan arsitektur deployment sistem:
- **Client Devices**: Web Browser, Mobile Browser
- **Web Server**: Nginx/Apache, PHP-FPM, Laravel Application, Vite Dev Server
- **Application Server**: Laravel Queue Worker, Scheduler, Logs
- **Database Server**: MySQL/MariaDB dengan semua tabel
- **File Storage Server**: Local storage untuk images
- **External Services**: Email Service, Payment Gateway

### 7. State Machine Diagrams
**File**:
- `07-state-machine-diagram.puml` - Order State Machine
- `07-state-machine-diagram-complaint.puml` - Complaint State Machine

State machine diagram menampilkan state dan transisi untuk:
- **Order States**: 
  - proses → pengemasan → pengiriman → sudah_sampai → selesai
  - proses/pengemasan/pengiriman → pending_cancellation → cancelled
- **Complaint States**:
  - pending → in_progress → resolved/rejected
  - pending → resolved/rejected (direct)

## Cara Menggunakan

### Prerequisites
1. Install PlantUML: https://plantuml.com/download
2. Atau gunakan online editor: http://www.plantuml.com/plantuml/uml/

### Generate Diagram

#### Menggunakan Command Line
```bash
# Install PlantUML (Java required)
# Ubuntu/Debian
sudo apt-get install plantuml

# Generate PNG
plantuml -tpng diagrams/*.puml

# Generate SVG
plantuml -tsvg diagrams/*.puml

# Generate PDF
plantuml -tpdf diagrams/*.puml
```

#### Menggunakan VS Code Extension
1. Install extension "PlantUML" di VS Code
2. Buka file `.puml`
3. Tekan `Alt+D` atau klik kanan → "Preview PlantUML"

#### Menggunakan Online Editor
1. Buka http://www.plantuml.com/plantuml/uml/
2. Copy-paste isi file `.puml`
3. Diagram akan otomatis ter-render

## Struktur File

```
diagrams/
├── README.md
├── 01-class-diagram.puml
├── 02-use-case-diagram.puml
├── 03-sequence-diagram.puml
├── 03-sequence-diagram-order-cancel.puml
├── 03-sequence-diagram-complete-order.puml
├── 03-sequence-diagram-admin-update-status.puml
├── 04-activity-diagram.puml
├── 04-activity-diagram-order-lifecycle.puml
├── 04-activity-diagram-admin-product-management.puml
├── 05-component-diagram.puml
├── 06-deployment-diagram.puml
├── 07-state-machine-diagram.puml
└── 07-state-machine-diagram-complaint.puml
```

## Catatan Penting

1. **Class Diagram**: Menampilkan semua model dan controller utama dengan atribut dan method penting
2. **Use Case Diagram**: Mencakup semua fitur untuk Guest, Customer, dan Admin
3. **Sequence Diagrams**: Fokus pada alur bisnis utama (checkout, cancellation, completion)
4. **Activity Diagrams**: Menampilkan alur aktivitas kompleks dengan decision points
5. **Component Diagram**: Arsitektur sistem secara keseluruhan
6. **Deployment Diagram**: Infrastruktur deployment dengan semua komponen
7. **State Machine Diagrams**: State dan transisi untuk Order dan Complaint

## Update Diagram

Jika ada perubahan pada codebase, diagram harus diupdate sesuai dengan perubahan tersebut. Pastikan untuk:
1. Update class diagram jika ada model/controller baru
2. Update use case diagram jika ada fitur baru
3. Update sequence/activity diagram jika ada perubahan alur bisnis
4. Update component/deployment diagram jika ada perubahan arsitektur
5. Update state machine diagram jika ada perubahan state/transisi

## Referensi

- PlantUML Documentation: https://plantuml.com/
- PlantUML Syntax: https://plantuml.com/guide
- UML Diagrams: https://www.uml-diagrams.org/
