# Panduan Pengguna Herbamart E-Commerce

## 1. Pendahuluan

Panduan ini menjelaskan cara menggunakan aplikasi Herbamart E-Commerce untuk pengguna customer, mulai dari registrasi hingga menyelesaikan pembelian.

## 2. Memulai

### 2.1 Registrasi Akun

1. Buka halaman utama aplikasi
2. Klik tombol **"Register"** di pojok kanan atas
3. Isi form registrasi:
   - **Nama**: Masukkan nama Anda
   - **Username**: Masukkan username (opsional)
   - **Email**: Masukkan alamat email yang valid
   - **Password**: Masukkan password minimal 8 karakter
   - **Konfirmasi Password**: Masukkan password yang sama
4. Klik tombol **"Register"**
5. Anda akan otomatis login dan diarahkan ke dashboard

**Catatan**: Pastikan email yang digunakan belum terdaftar sebelumnya.

### 2.2 Login

1. Klik tombol **"Login"** di pojok kanan atas
2. Masukkan **Email** dan **Password**
3. Centang **"Remember me"** jika ingin tetap login (opsional)
4. Klik tombol **"Login"**
5. Anda akan diarahkan ke dashboard

### 2.3 Lupa Password

1. Di halaman login, klik **"Forgot your password?"**
2. Masukkan alamat email Anda
3. Klik **"Email Password Reset Link"**
4. Cek email Anda untuk link reset password
5. Klik link di email dan ikuti instruksi untuk reset password

## 3. Berbelanja

### 3.1 Melihat Produk

1. Di halaman utama, Anda akan melihat daftar produk
2. Scroll untuk melihat lebih banyak produk
3. Klik **"Next"** atau **"Previous"** untuk melihat halaman berikutnya

### 3.2 Filter Produk

1. Di sidebar kiri, Anda akan melihat daftar kategori
2. Centang kategori yang ingin Anda lihat (bisa lebih dari satu)
3. Produk akan otomatis ter-filter tanpa refresh halaman

### 3.3 Sort Produk

1. Di bagian atas daftar produk, pilih opsi sorting:
   - **Terbaru**: Produk terbaru (default)
   - **Rating Tertinggi**: Produk dengan rating tertinggi
   - **Harga Terendah**: Produk dengan harga terendah
   - **Harga Tertinggi**: Produk dengan harga tertinggi
   - **Penjualan Terbanyak**: Produk yang paling banyak terjual
2. Produk akan otomatis ter-sort tanpa refresh halaman

### 3.4 Melihat Detail Produk

1. Klik pada produk yang ingin Anda lihat detailnya
2. Anda akan melihat:
   - Gambar produk
   - Nama produk
   - Deskripsi produk
   - Harga
   - Stok tersedia
   - Kategori
3. Masukkan jumlah yang ingin dibeli di field **"Quantity"**
4. Klik tombol **"Tambah ke Keranjang"**
5. Notifikasi akan muncul jika produk berhasil ditambahkan

## 4. Keranjang Belanja

### 4.1 Melihat Keranjang

1. Klik ikon keranjang di navbar (ada badge dengan jumlah item)
2. Atau klik **"Keranjang"** di menu
3. Anda akan melihat semua item di keranjang Anda

### 4.2 Update Quantity

1. Di halaman keranjang, temukan item yang ingin diubah
2. Ubah angka di field quantity
3. Klik tombol **"Update"** atau tekan Enter
4. Subtotal dan total akan otomatis ter-update

**Catatan**: Quantity tidak boleh melebihi stok yang tersedia.

### 4.3 Hapus Item dari Keranjang

1. Di halaman keranjang, temukan item yang ingin dihapus
2. Klik tombol **"Hapus"** atau ikon trash
3. Konfirmasi penghapusan
4. Item akan dihapus dan total akan ter-update

## 5. Checkout

### 5.1 Memulai Checkout

1. Dari halaman keranjang, klik tombol **"Checkout"**
2. Atau langsung klik **"Checkout"** setelah menambahkan produk

### 5.2 Memilih Alamat Pengiriman

**Menggunakan Alamat Tersimpan:**

1. Di bagian **"Alamat Pengiriman"**, pilih alamat dari dropdown
2. Alamat akan otomatis terisi

**Menambah Alamat Baru:**

1. Klik **"Tambah Alamat Baru"**
2. Isi form alamat:
   - **Nama Penerima**: Nama orang yang akan menerima
   - **Alamat Lengkap**: Alamat detail
   - **Provinsi**: Pilih dari dropdown (jika API tersedia)
   - **Kota**: Pilih dari dropdown (jika API tersedia)
   - **Kecamatan**: Pilih dari dropdown (jika API tersedia)
   - **Kelurahan**: Pilih dari dropdown (jika API tersedia)
   - **Kode Pos**: Masukkan kode pos
3. Centang **"Simpan sebagai alamat default"** jika ingin menyimpan (opsional)
4. Klik **"Simpan Alamat"**

**Edit Alamat:**

1. Klik **"Edit"** pada alamat yang ingin diubah
2. Ubah data yang diperlukan
3. Klik **"Simpan"**

### 5.3 Memilih Metode Pengiriman

1. Pilih salah satu metode pengiriman:
   - **Reguler** (Rp 15.000): Pengiriman standar
   - **Kargo** (Rp 10.000): Pengiriman ekonomis
   - **Same Day** (Rp 30.000): Pengiriman hari yang sama
2. Biaya pengiriman akan otomatis ditambahkan ke total

### 5.4 Memilih Metode Pembayaran

1. Pilih salah satu metode pembayaran:
   - **Transfer Bank**: Transfer melalui bank
   - **Kartu Kredit/Debit**: Pembayaran dengan kartu
   - **COD**: Cash on Delivery (Bayar di tempat)

### 5.5 Menyelesaikan Checkout

1. Periksa ringkasan pesanan:
   - Daftar produk
   - Subtotal
   - Biaya pengiriman
   - **Total**
2. Klik tombol **"Buat Pesanan"**
3. Anda akan diarahkan ke halaman detail pesanan
4. Pesanan Anda akan memiliki nomor pesanan unik (format: HM-XXXXXXXXXX)

## 6. Manajemen Pesanan

### 6.1 Melihat Riwayat Pesanan

1. Klik **"Dashboard"** di menu atau setelah login
2. Anda akan melihat daftar semua pesanan Anda
3. Klik pada pesanan untuk melihat detail

### 6.2 Melihat Detail Pesanan

Di halaman detail pesanan, Anda akan melihat:

- **Nomor Pesanan**: Nomor unik pesanan Anda
- **Status Pesanan**: Status saat ini
- **Tanggal Pesanan**: Kapan pesanan dibuat
- **Daftar Produk**: Produk yang dibeli beserta quantity dan harga
- **Informasi Pengiriman**: Alamat dan metode pengiriman
- **Informasi Pembayaran**: Metode pembayaran dan status
- **Total Harga**: Total yang harus dibayar

### 6.3 Cetak Invoice

1. Di halaman detail pesanan, klik tombol **"Cetak Invoice"**
2. Invoice akan terbuka di tab baru
3. Gunakan print browser untuk mencetak

### 6.4 Menyelesaikan Pesanan

Setelah menerima barang:

1. Buka detail pesanan
2. Klik tombol **"Selesaikan Pesanan"**
3. (Opsional) Berikan ulasan untuk produk:
   - Pilih rating (1-5 bintang)
   - Tulis komentar (opsional)
   - Upload gambar (opsional)
4. Klik **"Selesaikan Pesanan"**
5. Status pesanan akan berubah menjadi **"Selesai"**
6. Pembayaran akan otomatis direlease

**Catatan**: Jika Anda tidak menyelesaikan pesanan dalam 3 hari setelah status "Sudah Sampai", pesanan akan otomatis diselesaikan.

### 6.5 Membatalkan Pesanan

Jika Anda ingin membatalkan pesanan:

1. Buka detail pesanan
2. Klik tombol **"Ajukan Pembatalan"**
3. Masukkan alasan pembatalan
4. Klik **"Ajukan Pembatalan"**
5. Status akan berubah menjadi **"Menunggu Konfirmasi"**
6. Tunggu admin menyetujui atau menolak pembatalan

**Catatan**: Pesanan yang sudah selesai tidak dapat dibatalkan. Jika ada masalah, ajukan komplain.

### 6.6 Mengajukan Komplain

Jika ada masalah dengan pesanan yang sudah selesai:

1. Buka detail pesanan yang sudah selesai
2. Klik tombol **"Ajukan Komplain"**
3. Isi form komplain:
   - **Judul**: Judul komplain
   - **Detail**: Jelaskan masalah secara detail
   - **Gambar Bukti**: Upload gambar bukti (opsional)
4. Klik **"Ajukan Komplain"**
5. Status komplain akan **"Pending"** menunggu peninjauan admin
6. Anda dapat melihat respons admin di halaman detail pesanan

## 7. Manajemen Alamat

### 7.1 Menambah Alamat

1. Di halaman checkout atau profil, klik **"Tambah Alamat"**
2. Isi form alamat lengkap
3. Centang **"Set sebagai alamat default"** jika ingin (opsional)
4. Klik **"Simpan"**

### 7.2 Edit Alamat

1. Di halaman checkout atau profil, klik **"Edit"** pada alamat yang ingin diubah
2. Ubah data yang diperlukan
3. Klik **"Simpan"**

### 7.3 Hapus Alamat

1. Klik **"Hapus"** pada alamat yang ingin dihapus
2. Konfirmasi penghapusan
3. Alamat akan dihapus

### 7.4 Set Alamat Default

1. Klik **"Set sebagai Default"** pada alamat yang ingin dijadikan default
2. Alamat tersebut akan menjadi default untuk checkout selanjutnya

## 8. Manajemen Profil

### 8.1 Edit Profil

1. Klik nama Anda di navbar atau menu **"Profile"**
2. Klik tab **"Profile Information"**
3. Ubah informasi yang ingin diubah:
   - Nama
   - Username
   - Email
   - Foto profil (upload gambar)
4. Klik **"Save"**

### 8.2 Ubah Password

1. Di halaman profil, klik tab **"Update Password"**
2. Masukkan password lama
3. Masukkan password baru
4. Konfirmasi password baru
5. Klik **"Save"**

### 8.3 Hapus Akun

1. Di halaman profil, scroll ke bawah
2. Klik tab **"Delete Account"**
3. Masukkan password untuk konfirmasi
4. Klik **"Delete Account"**
5. Konfirmasi penghapusan

**Peringatan**: Tindakan ini tidak dapat dibatalkan. Semua data Anda akan dihapus.

## 9. Tips dan Trik

### 9.1 Tips Berbelanja

- Gunakan filter kategori untuk menemukan produk dengan cepat
- Sort berdasarkan rating untuk melihat produk terbaik
- Periksa stok sebelum menambahkan ke keranjang
- Simpan alamat untuk checkout yang lebih cepat

### 9.2 Tips Keamanan

- Gunakan password yang kuat (minimal 8 karakter, kombinasi huruf, angka, simbol)
- Jangan bagikan kredensial login Anda
- Logout setelah selesai menggunakan (terutama di komputer umum)
- Periksa detail pesanan sebelum menyelesaikan checkout

### 9.3 Troubleshooting

**Produk tidak bisa ditambahkan ke keranjang:**
- Periksa apakah stok masih tersedia
- Refresh halaman dan coba lagi
- Pastikan Anda sudah login

**Checkout tidak bisa diselesaikan:**
- Pastikan keranjang tidak kosong
- Pastikan alamat pengiriman sudah diisi
- Periksa koneksi internet

**Pesanan tidak muncul:**
- Refresh halaman
- Pastikan Anda login dengan akun yang benar
- Cek folder spam email (jika ada notifikasi email)

## 10. FAQ (Frequently Asked Questions)

**Q: Apakah saya bisa membatalkan pesanan?**
A: Ya, Anda dapat mengajukan pembatalan untuk pesanan yang belum selesai. Admin akan meninjau permintaan Anda.

**Q: Bagaimana cara mengubah alamat pengiriman setelah checkout?**
A: Setelah checkout, alamat tidak dapat diubah. Hubungi admin jika perlu perubahan.

**Q: Kapan pembayaran akan direlease?**
A: Pembayaran akan otomatis direlease setelah pesanan selesai (setelah Anda konfirmasi menerima barang atau setelah 3 hari otomatis).

**Q: Apakah saya bisa memberikan ulasan untuk produk?**
A: Ya, Anda dapat memberikan ulasan saat menyelesaikan pesanan.

**Q: Bagaimana cara melacak pesanan?**
A: Status pesanan dapat dilihat di halaman detail pesanan. Admin akan mengupdate status secara berkala.

**Q: Apakah ada biaya pengiriman?**
A: Ya, biaya pengiriman bervariasi tergantung metode yang dipilih (Reguler: Rp 15.000, Kargo: Rp 10.000, Same Day: Rp 30.000).

---

**Catatan**: Jika Anda mengalami masalah atau memiliki pertanyaan, silakan hubungi customer service atau ajukan komplain melalui aplikasi.
