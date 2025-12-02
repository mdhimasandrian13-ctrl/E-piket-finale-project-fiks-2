# Changelog

All notable changes to E-Piket SMEKDA will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.0] - 2024-12-01

### 🎉 Added

#### Upload Foto Absensi
- Siswa dapat upload foto saat melakukan absensi (opsional)
- Preview foto sebelum upload dengan validasi client-side
- Validasi format file (JPG, PNG) dan ukuran (max 5MB)
- Halaman baru `admin/detail-absensi.php` untuk admin melihat foto
- Halaman baru `guru/detail-absensi.php` untuk guru melihat foto
- Menu baru "Foto Absensi" di sidebar admin dan guru
- Modal zoom untuk melihat foto dalam ukuran penuh
- Filter foto berdasarkan tanggal, kelas, dan status
- Tampilan grid card untuk foto absensi
- Folder `uploads/attendance/` untuk penyimpanan foto
- Kolom `photo_path` di tabel `attendances`

#### Jadwal Multiple Siswa
- Form tambah jadwal manual sekarang support multiple siswa
- Checkbox untuk memilih banyak siswa sekaligus
- Tombol "Pilih Semua" dan "Batal Semua"
- Deteksi duplikat otomatis untuk setiap siswa
- Notifikasi detail berapa siswa berhasil dijadwalkan
- Tampilan NIS dan nama siswa yang lebih informatif

#### Dokumentasi
- File `PANDUAN_SINGKAT.txt` - Panduan visual lengkap
- File `CARA_MELIHAT_FOTO.txt` - Cara melihat foto absensi
- File `FITUR_JADWAL_MULTIPLE.txt` - Panduan jadwal multiple
- File `PERUBAHAN_FITUR_UPLOAD_FOTO.md` - Dokumentasi teknis
- File `RINGKASAN_UPDATE.txt` - Ringkasan semua update
- File `QUICK_START.md` - Quick start guide
- File `CHANGELOG.md` - File ini
- File `database_update_photo.sql` - SQL update untuk fitur foto

### 🔧 Changed
- Form tambah jadwal manual dari dropdown menjadi checkbox
- Modal tambah jadwal diperbesar untuk menampung list siswa
- Proses tambah jadwal sekarang loop untuk multiple siswa
- Query database dioptimasi untuk performa lebih baik
- UI/UX lebih responsif di mobile device

### 🐛 Fixed
- Validasi upload file lebih ketat
- Deteksi duplikat jadwal lebih akurat
- Session handling lebih stabil
- Error handling lebih informatif

### 📊 Database
- Tambah kolom `photo_path VARCHAR(255) NULL` di tabel `attendances`

### 📁 Files Added
```
admin/detail-absensi.php
guru/detail-absensi.php
uploads/attendance/
database_update_photo.sql
PANDUAN_SINGKAT.txt
CARA_MELIHAT_FOTO.txt
FITUR_JADWAL_MULTIPLE.txt
PERUBAHAN_FITUR_UPLOAD_FOTO.md
RINGKASAN_UPDATE.txt
QUICK_START.md
CHANGELOG.md
```

### 📁 Files Modified
```
siswa/absensi-hadir.php
admin/dashboard.php
admin/laporan.php
admin/kelola-jadwal.php
guru/dashboard.php
guru/monitoring.php
guru/laporan.php
README.md
```

---

## [1.0.0] - 2024-10-01

### 🎉 Added

#### Core Features
- Sistem autentikasi dengan 3 role (Admin, Guru, Siswa)
- Dashboard untuk setiap role dengan statistik
- Session management dan security

#### Admin Features
- CRUD Siswa (Create, Read, Update, Delete)
- CRUD Guru (Create, Read, Update, Delete)
- CRUD Kelas (Create, Read, Update, Delete)
- Generate jadwal piket otomatis
- CRUD jadwal piket manual
- Hapus jadwal berdasarkan range tanggal
- Filter dan search data
- Statistik real-time

#### Guru Features
- Dashboard kelas yang diampu
- Monitoring jadwal piket harian
- Input absensi manual untuk siswa
- Generate laporan kehadiran bulanan/tahunan
- Statistik kehadiran per kelas
- Export laporan

#### Siswa Features
- Dashboard dengan jadwal hari ini
- Absensi piket 1 klik
- Riwayat kehadiran
- Statistik kehadiran bulanan
- Lihat jadwal piket pribadi

#### Database
- Tabel `users` untuk data user (admin, guru, siswa)
- Tabel `classes` untuk data kelas
- Tabel `schedules` untuk jadwal piket
- Tabel `attendances` untuk data absensi
- Helper functions untuk database operations

#### UI/UX
- Modern gradient design
- Responsive layout (mobile & desktop)
- Hamburger sidebar menu
- Modal dialogs
- Alert notifications
- Loading states
- Empty states
- Font Awesome icons
- Google Fonts (Poppins)

#### Security
- Password hashing
- SQL injection prevention
- XSS protection
- Session security
- Input validation
- Escape functions

### 📁 Initial Files
```
config/database.php
auth/login.php
auth/logout.php
admin/dashboard.php
admin/kelola-siswa.php
admin/kelola-guru.php
admin/kelola-kelas.php
admin/kelola-jadwal.php
admin/laporan.php
admin/pengaturan.php
admin/get-siswa.php
guru/dashboard.php
guru/monitoring.php
guru/laporan.php
siswa/dashboard.php
siswa/absensi-hadir.php
siswa/pengajuan-izin.php
siswa/riwayat.php
siswa/jadwal-saya.php
includes/navbar.php
includes/sidebar.php
asset/css/style.css
asset/css/login.css
asset/js/script.js
asset/js/login.js
asset/img/logo_E_Piket_*.png
index.php
README.md
epiket_smekda.sql
```

---

## Roadmap

### [1.2.0] - Planned (Q1 2025)
- [ ] Export laporan ke Excel
- [ ] Notifikasi email untuk siswa alpha
- [ ] Dashboard analytics dengan chart (Chart.js)
- [ ] Progressive Web App (PWA)
- [ ] QR Code untuk absensi
- [ ] Backup otomatis database

### [1.3.0] - Planned (Q2 2025)
- [ ] Multi-language support (ID, EN)
- [ ] Dark mode theme
- [ ] REST API untuk integrasi
- [ ] Mobile app (React Native)
- [ ] Push notifications
- [ ] Advanced reporting

### [2.0.0] - Planned (Q3 2025)
- [ ] Microservices architecture
- [ ] Real-time updates (WebSocket)
- [ ] AI-powered analytics
- [ ] Face recognition untuk absensi
- [ ] Blockchain untuk data integrity

---

## Support

Jika menemukan bug atau ingin request fitur:
- Buat issue di GitHub
- Email: support@smkn2sby.sch.id
- Dokumentasi: Lihat README.md

---

**Maintained by:** Tim Pengembang SMKN 2 Surabaya
**License:** MIT
