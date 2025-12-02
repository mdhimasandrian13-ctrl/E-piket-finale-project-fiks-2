# Dokumentasi Perubahan - Fitur Upload Foto Absensi

## Ringkasan
Menambahkan fitur upload foto pada absensi hadir siswa yang dapat dilihat oleh admin dan guru.

## File yang Diubah

### 1. **siswa/absensi-hadir.php**
   
#### Perubahan Backend (PHP):
- **Baris 30-70**: Menambahkan proses upload foto saat absensi
  - Validasi tipe file (JPG, PNG)
  - Validasi ukuran maksimal 5MB
  - Menyimpan foto ke folder `uploads/attendance/`
  - Menyimpan path foto ke database
  
- **Baris 75**: Menambahkan kolom `photo_path` pada query SELECT jadwal

#### Perubahan Frontend (HTML/CSS):
- **CSS (Baris 250-350)**: Menambahkan style untuk:
  - `.upload-section` - Section untuk upload foto
  - `.file-input-wrapper` - Wrapper untuk input file
  - `.file-input-label` - Label custom untuk input file
  - `.file-preview` - Preview gambar sebelum upload
  - `.photo-display` - Tampilan foto yang sudah diupload
  - `.photo-modal` - Modal untuk melihat foto full size
  
- **HTML (Baris 400-430)**: Menambahkan:
  - Form upload dengan `enctype="multipart/form-data"`
  - Input file dengan accept image
  - Preview area untuk gambar
  - Tampilan foto yang sudah diupload (jika ada)
  - Modal untuk zoom foto

#### Perubahan JavaScript:
- **Fungsi `previewImage()`**: Preview gambar sebelum upload dengan validasi
- **Fungsi `showPhotoModal()`**: Menampilkan foto dalam modal full size
- **Fungsi `closePhotoModal()`**: Menutup modal foto
- **Event listener ESC**: Menutup modal dengan tombol ESC

### 2. **Database**
   
#### File: `database_update_photo.sql`
- Menambahkan kolom `photo_path` VARCHAR(255) NULL pada tabel `attendances`

### 3. **Folder Baru**
   
#### `uploads/attendance/`
- Folder untuk menyimpan foto absensi
- Dibuat otomatis jika belum ada
- Format nama file: `attendance_{student_id}_{timestamp}.{ext}`

### 4. **Halaman Baru untuk Melihat Foto**

#### `admin/detail-absensi.php`
- Halaman khusus admin untuk melihat semua foto absensi
- Filter: tanggal, kelas, status
- Tampilan grid card dengan foto
- Modal zoom untuk melihat foto full size

#### `guru/detail-absensi.php`
- Halaman khusus guru untuk melihat foto absensi kelas yang diampu
- Filter: tanggal, kelas, status
- Tampilan grid card dengan foto
- Modal zoom untuk melihat foto full size

## Cara Menggunakan

### Untuk Siswa:
1. Buka halaman **Absensi Hadir**
2. Pilih jadwal piket yang aktif
3. (Opsional) Klik area upload untuk memilih foto
4. Preview foto akan muncul setelah dipilih
5. Klik tombol **Absensi Sekarang**
6. Foto akan tersimpan bersama data absensi

### Untuk Admin/Guru:
Foto absensi dapat dilihat di halaman khusus:
- **Admin**: Akses `admin/detail-absensi.php` untuk melihat semua foto absensi
- **Guru**: Akses `guru/detail-absensi.php` untuk melihat foto absensi kelas yang diampu

Fitur halaman detail absensi:
- Filter berdasarkan tanggal, kelas, dan status
- Tampilan card dengan foto thumbnail
- Klik foto untuk zoom/melihat ukuran penuh
- Informasi lengkap (NIS, nama, kelas, shift, waktu check-in, catatan)

## Instalasi

1. **Update Database**:
   ```sql
   -- Jalankan query di phpMyAdmin atau MySQL client
   source database_update_photo.sql;
   ```
   
   Atau manual:
   ```sql
   ALTER TABLE `attendances` 
   ADD COLUMN `photo_path` VARCHAR(255) NULL AFTER `notes`;
   ```

2. **Buat Folder Upload**:
   - Folder `uploads/attendance/` sudah dibuat otomatis
   - Pastikan folder memiliki permission write (777)

3. **Test Fitur**:
   - Login sebagai siswa
   - Lakukan absensi dengan upload foto
   - Verifikasi foto tersimpan di `uploads/attendance/`
   - Cek database kolom `photo_path` terisi

## Validasi Upload

- **Tipe File**: JPG, JPEG, PNG
- **Ukuran Maksimal**: 5MB
- **Nama File**: Otomatis (attendance_{student_id}_{timestamp}.{ext})
- **Lokasi**: `uploads/attendance/`

## Fitur Tambahan

1. **Preview Sebelum Upload**: Siswa dapat melihat foto sebelum submit
2. **Zoom Foto**: Klik foto untuk melihat ukuran penuh
3. **Validasi Client-Side**: Validasi ukuran dan tipe file sebelum upload
4. **Responsive**: Tampilan menyesuaikan di mobile dan desktop
5. **Opsional**: Upload foto tidak wajib, absensi tetap bisa tanpa foto

## Keamanan

- Validasi tipe file di server-side
- Validasi ukuran file (max 5MB)
- Nama file di-generate otomatis (mencegah overwrite)
- Folder upload di luar root web (jika diperlukan, pindahkan ke luar htdocs)

## Catatan Penting

- Desain UI tidak berubah, hanya menambahkan section upload
- Fitur backward compatible (data lama tanpa foto tetap berfungsi)
- Foto bersifat opsional, tidak wajib diupload
- Admin dan guru perlu update tampilan untuk melihat foto (lihat section selanjutnya)

## Cara Melihat Foto Absensi

### Untuk Admin:
1. Login sebagai admin
2. Akses URL: `http://localhost/E-piket-smekda/admin/detail-absensi.php`
3. Pilih filter tanggal, kelas, atau status (opsional)
4. Klik tombol **Filter**
5. Foto akan ditampilkan dalam bentuk card
6. Klik foto untuk melihat ukuran penuh

### Untuk Guru:
1. Login sebagai guru
2. Akses URL: `http://localhost/E-piket-smekda/guru/detail-absensi.php`
3. Pilih filter tanggal, kelas, atau status (opsional)
4. Klik tombol **Filter**
5. Foto akan ditampilkan dalam bentuk card (hanya kelas yang diampu)
6. Klik foto untuk melihat ukuran penuh

### Menambahkan Link di Menu (Opsional):

Jika ingin menambahkan link di sidebar, tambahkan menu item ini:

**Untuk Admin** (di `admin/dashboard.php`, `admin/laporan.php`, dll):
```php
<li class="nav-item">
    <a href="detail-absensi.php" class="nav-link">
        <i class="fas fa-images"></i>
        <span>Foto Absensi</span>
    </a>
</li>
```

**Untuk Guru** (di `guru/dashboard.php`, `guru/monitoring.php`, dll):
```php
<li class="nav-item">
    <a href="detail-absensi.php" class="nav-link">
        <i class="fas fa-images"></i>
        <span>Foto Absensi</span>
    </a>
</li>
```
