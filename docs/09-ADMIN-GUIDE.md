# Panduan Administrator Herbamart E-Commerce

## 1. Pendahuluan

Panduan ini menjelaskan cara menggunakan panel admin Herbamart E-Commerce untuk mengelola produk, pesanan, komplain, dan melihat laporan.

## 2. Akses Admin

### 2.1 Login sebagai Admin

1. Buka halaman login
2. Masukkan kredensial admin:
   - **Email**: `admin@example.com` (default)
   - **Password**: `password` (default)
3. Klik **"Login"**
4. Anda akan diarahkan ke dashboard admin

**Catatan**: Pastikan untuk mengubah password default setelah login pertama kali.

### 2.2 Navigasi Admin

Setelah login sebagai admin, Anda akan melihat menu admin di sidebar:
- **Dashboard**: Halaman utama admin
- **Produk**: Manajemen produk
- **Pesanan**: Manajemen pesanan
- **Komplain**: Manajemen komplain
- **Laporan**: Laporan penjualan

## 3. Dashboard Admin

### 3.1 Statistik Ringkas

Di dashboard, Anda akan melihat statistik:
- **Total Pesanan**: Jumlah semua pesanan
- **Total Produk**: Jumlah produk di sistem
- **Total Customer**: Jumlah customer terdaftar
- **Total Pendapatan**: Total pendapatan dari pesanan selesai

### 3.2 Grafik dan Visualisasi

**Grafik Pendapatan Bulanan:**
- Menampilkan pendapatan 6 bulan terakhir
- Hanya menghitung dari pesanan yang status "Selesai"

**Grafik Produk Terlaris:**
- Menampilkan 5 produk terlaris
- Berdasarkan jumlah terjual dari pesanan selesai

**Grafik Status Pesanan:**
- Distribusi pesanan berdasarkan status
- Memberikan overview kondisi pesanan

### 3.3 Pesanan Terbaru

Daftar 5 pesanan terbaru dengan informasi:
- Nomor pesanan
- Customer
- Total harga
- Status
- Tanggal

## 4. Manajemen Produk

### 4.1 Melihat Daftar Produk

1. Klik **"Produk"** di menu sidebar
2. Anda akan melihat daftar semua produk dengan:
   - Nama produk
   - Harga
   - Stok
   - Kategori
   - Aksi (Edit, Hapus)

### 4.2 Menambah Produk Baru

1. Di halaman daftar produk, klik **"Tambah Produk"**
2. Isi form:
   - **Nama**: Nama produk
   - **Deskripsi**: Deskripsi lengkap produk
   - **Harga**: Harga produk (format: angka, tanpa titik/koma)
   - **Stok**: Jumlah stok tersedia
   - **Kategori**: Pilih kategori dari dropdown
   - **Gambar**: Upload gambar produk (opsional, max 2MB)
3. Klik **"Simpan"**
4. Produk akan muncul di daftar

**Kategori Tersedia:**
- Jamu Tradisional
- Suplemen Alami
- Madu & Propolis
- Teh & Infus Herbal
- Minyak Atsiri
- Aromaterapi

### 4.3 Edit Produk

1. Di halaman daftar produk, klik **"Edit"** pada produk yang ingin diubah
2. Ubah informasi yang diperlukan
3. Untuk mengganti gambar, upload gambar baru (gambar lama akan otomatis dihapus)
4. Klik **"Simpan"**

**Catatan**: Slug produk akan otomatis di-generate ulang jika nama diubah.

### 4.4 Hapus Produk

1. Di halaman daftar produk, klik **"Hapus"** pada produk yang ingin dihapus
2. Konfirmasi penghapusan
3. Produk akan dihapus beserta gambar terkait

**Peringatan**: 
- Produk yang sudah ada di pesanan tidak dapat dihapus (akan error)
- Hapus produk dengan hati-hati karena akan mempengaruhi data terkait

## 5. Manajemen Pesanan

### 5.1 Melihat Daftar Pesanan

1. Klik **"Pesanan"** di menu sidebar
2. Anda akan melihat daftar semua pesanan dengan:
   - Nomor pesanan
   - Customer
   - Total harga
   - Status
   - Tanggal
   - Aksi

### 5.2 Melihat Detail Pesanan

1. Klik pada nomor pesanan atau tombol **"Detail"**
2. Anda akan melihat informasi lengkap:
   - Informasi customer
   - Daftar produk yang dibeli
   - Alamat pengiriman
   - Metode pengiriman dan pembayaran
   - Status pesanan
   - Alasan pembatalan (jika ada)

### 5.3 Update Status Pesanan

**Alur Status Pesanan:**
```
proses → pengemasan → pengiriman → sudah_sampai
```

**Cara Update:**

1. Di halaman detail pesanan atau daftar pesanan
2. Pilih status baru dari dropdown
3. Klik **"Update Status"**
4. Status akan ter-update

**Catatan Penting:**
- Admin **TIDAK DAPAT** mengubah status menjadi "Selesai"
- Hanya customer yang dapat menyelesaikan pesanan
- Status "Selesai" akan otomatis setelah customer konfirmasi atau 3 hari setelah "Sudah Sampai"

### 5.4 Menyetujui Pembatalan Pesanan

Jika customer mengajukan pembatalan:

1. Di halaman detail pesanan, Anda akan melihat notifikasi pembatalan
2. Baca alasan pembatalan
3. Klik **"Setujui Pembatalan"** untuk menyetujui
   - Status akan berubah menjadi "Cancelled"
   - Stok produk akan otomatis dikembalikan
4. Atau klik **"Tolak Pembatalan"** untuk menolak
   - Status akan kembali ke "Proses"
   - Alasan pembatalan akan dihapus

**Catatan**: Setelah menyetujui pembatalan, stok produk akan otomatis dikembalikan.

### 5.5 Cetak Shipping Label

1. Di halaman detail pesanan, klik **"Cetak Label"**
2. Shipping label akan terbuka di tab baru
3. Gunakan print browser untuk mencetak
4. Label berisi:
   - Nomor pesanan
   - Informasi customer
   - Alamat pengiriman lengkap
   - Daftar produk

## 6. Manajemen Komplain

### 6.1 Melihat Daftar Komplain

1. Klik **"Komplain"** di menu sidebar
2. Anda akan melihat daftar semua komplain dengan:
   - Nomor pesanan
   - Customer
   - Judul komplain
   - Status
   - Tanggal

### 6.2 Melihat Detail Komplain

1. Klik pada komplain yang ingin dilihat
2. Anda akan melihat:
   - Informasi pesanan terkait
   - Detail komplain (judul dan isi)
   - Gambar bukti (jika ada)
   - Status saat ini
   - Respons admin (jika sudah ada)

### 6.3 Menangani Komplain

1. Di halaman detail komplain, baca detail komplain
2. Periksa gambar bukti (jika ada)
3. Update status komplain:
   - **Pending**: Menunggu peninjauan
   - **In Progress**: Sedang ditangani
   - **Resolved**: Sudah diselesaikan
   - **Rejected**: Ditolak
4. (Opsional) Tambahkan respons admin di field **"Admin Response"**
5. Klik **"Update Status"**

**Tips:**
- Berikan respons yang jelas dan profesional
- Jika komplain valid, segera tindak lanjuti
- Jika komplain tidak valid, jelaskan alasan penolakan

## 7. Laporan

### 7.1 Melihat Laporan Penjualan

1. Klik **"Laporan"** di menu sidebar
2. Anda akan melihat laporan dengan filter:
   - **Tanggal Mulai**: Filter dari tanggal tertentu
   - **Tanggal Akhir**: Filter sampai tanggal tertentu
   - **Status**: Filter berdasarkan status pesanan
3. Klik **"Filter"** untuk menerapkan filter
4. Laporan akan menampilkan:
   - **Total Pesanan**: Jumlah pesanan sesuai filter
   - **Total Pendapatan**: Total pendapatan (hanya dari pesanan selesai)
   - **Total Dibatalkan**: Jumlah pesanan yang dibatalkan
   - **Total Dikirim**: Jumlah pesanan yang sedang dikirim
   - Daftar pesanan sesuai filter

### 7.2 Export Laporan

**Catatan**: Fitur export ke PDF/Excel belum diimplementasikan. Untuk saat ini, gunakan print browser untuk mencetak laporan.

## 8. Best Practices

### 8.1 Manajemen Produk

- **Update Stok Secara Berkala**: Pastikan stok selalu akurat
- **Gunakan Gambar Berkualitas**: Upload gambar produk yang jelas dan menarik
- **Deskripsi Lengkap**: Tulis deskripsi yang informatif untuk customer
- **Harga Kompetitif**: Periksa harga secara berkala

### 8.2 Manajemen Pesanan

- **Update Status Tepat Waktu**: Update status pesanan segera setelah setiap tahap
- **Komunikasi dengan Customer**: Jika ada masalah, hubungi customer
- **Periksa Alamat Pengiriman**: Pastikan alamat lengkap dan benar sebelum mengirim
- **Cetak Label dengan Benar**: Pastikan informasi di shipping label akurat

### 8.3 Manajemen Komplain

- **Respon Cepat**: Tanggapi komplain dalam waktu 24 jam
- **Investigasi Mendalam**: Periksa detail komplain dengan teliti
- **Solusi yang Adil**: Berikan solusi yang adil untuk customer
- **Dokumentasi**: Catat semua tindakan yang diambil

### 8.4 Keamanan

- **Ganti Password Default**: Segera ganti password setelah login pertama
- **Gunakan Password Kuat**: Kombinasi huruf, angka, dan simbol
- **Logout Setelah Selesai**: Selalu logout setelah selesai menggunakan
- **Jangan Bagikan Kredensial**: Jangan bagikan kredensial admin kepada siapapun

## 9. Troubleshooting

### 9.1 Produk Tidak Bisa Dihapus

**Penyebab**: Produk masih digunakan dalam pesanan yang aktif.

**Solusi**: 
- Hapus atau selesaikan pesanan terkait terlebih dahulu
- Atau edit produk untuk menonaktifkan (set stok 0)

### 9.2 Status Pesanan Tidak Bisa Diubah

**Penyebab**: 
- Pesanan sudah selesai
- Status transition tidak valid

**Solusi**: 
- Periksa status saat ini
- Ikuti alur status yang benar
- Hanya customer yang dapat menyelesaikan pesanan

### 9.3 Dashboard Tidak Menampilkan Data

**Penyebab**: 
- Belum ada data
- Cache issue

**Solusi**: 
- Pastikan sudah ada data (produk, pesanan)
- Clear cache: `php artisan cache:clear`
- Refresh halaman

### 9.4 Gambar Produk Tidak Muncul

**Penyebab**: 
- Storage link belum dibuat
- Permission issue

**Solusi**: 
- Jalankan: `php artisan storage:link`
- Cek permission folder storage
- Pastikan gambar ter-upload dengan benar

## 10. FAQ Admin

**Q: Bagaimana cara mengubah password admin?**
A: Login sebagai admin, klik profil, lalu ubah password di halaman profil.

**Q: Apakah saya bisa mengubah status pesanan menjadi "Selesai"?**
A: Tidak, hanya customer yang dapat menyelesaikan pesanan setelah menerima barang.

**Q: Apa yang terjadi jika saya menyetujui pembatalan?**
A: Status pesanan akan menjadi "Cancelled" dan stok produk akan otomatis dikembalikan.

**Q: Bagaimana cara melihat pendapatan per periode?**
A: Gunakan fitur Laporan dengan filter tanggal mulai dan akhir.

**Q: Apakah saya bisa menghapus pesanan?**
A: Tidak, pesanan tidak dapat dihapus untuk menjaga integritas data. Namun, pesanan dapat dibatalkan.

**Q: Bagaimana cara menangani komplain yang kompleks?**
A: Investigasi detail komplain, komunikasi dengan customer, dan berikan solusi yang adil. Dokumentasikan semua tindakan.

---

**Catatan**: Panel admin adalah alat yang powerful. Gunakan dengan bertanggung jawab dan selalu prioritaskan kepuasan customer.
