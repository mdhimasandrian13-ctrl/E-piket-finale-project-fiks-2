# E-Piket SMEKDA v1.1.0

> Sistem Manajemen Absensi Piket Siswa Berbasis Web untuk SMKN 2 Surabaya

## Deskripsi

E-Piket SMEKDA adalah aplikasi web untuk mengelola sistem absensi piket siswa secara digital. Menggantikan pencatatan manual dengan solusi yang lebih efisien, transparan, dan akurat.

## Fitur Utama

### Admin
- Dashboard dengan statistik real-time
- Kelola Siswa, Guru, dan Kelas (CRUD)
- Generate Jadwal Piket Otomatis
- **Tambah Jadwal Multiple Siswa Sekaligus** (NEW)
- **Lihat Foto Absensi Siswa** (NEW)
- Hapus Jadwal berdasarkan Range Tanggal

### Guru
- Monitoring Jadwal Piket Real-time
- Input Absensi Manual
- **Lihat Foto Absensi Siswa** (NEW)
- Generate Laporan Bulanan/Tahunan
- Export Laporan

### Siswa
- Absensi Piket 1 Klik
- **Upload Foto saat Absensi** (NEW)
- Riwayat Kehadiran
- Statistik Bulanan
- Lihat Jadwal Piket

## Fitur Baru v1.1.0

### Upload Foto Absensi
Siswa dapat upload foto saat absensi (opsional). Admin dan Guru dapat melihat foto di menu "Foto Absensi" dengan fitur filter dan zoom.

### Jadwal Multiple Siswa
Admin dapat menambahkan banyak siswa sekaligus untuk satu jadwal. Contoh: Senin 5 siswa, centang 5 siswa, simpan (1x klik).

## Quick Start

### Persyaratan Sistem
- PHP 7.4+
- MySQL 5.7+ / MariaDB 10.3+
- Apache Web Server
- Browser modern (Chrome, Firefox, Edge)

### Instalasi (5 Menit)

**1. Setup XAMPP**
```
1. Download dan Install XAMPP
2. Copy folder ke C:\xampp\htdocs\E-piket-smekda
3. Start Apache dan MySQL di XAMPP Control Panel
```

**2. Setup Database**
```sql
1. Buka http://localhost/phpmyadmin
2. Buat database: epiket_smekda
3. Import file: epiket_smekda.sql
4. PENTING! Jalankan query ini:

ALTER TABLE attendances 
ADD COLUMN photo_path VARCHAR(255) NULL AFTER notes;
```

**3. Konfigurasi (Opsional)**

Edit `config/database.php` jika perlu:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'epiket_smekda');
```

**4. Akses Aplikasi**
```
http://localhost/E-piket-smekda
```

### Login Default

| Role | Username | Password |
|------|----------|----------|
| Admin | admin | admin123 |
| Guru | guru001 | guru123 |
| Siswa | 2024001 | siswa123 |

**PENTING:** Ubah password default setelah login pertama!

## Cara Menggunakan

### Admin Workflow
1. **Kelola Data** - Tambah Siswa, Guru, Kelas
2. **Jadwal Piket** - Generate Otomatis atau Manual
   - Klik "Tambah Jadwal Manual"
   - Pilih Kelas dan Tanggal
   - Centang multiple siswa (bisa 5 siswa sekaligus)
   - Klik Simpan
3. **Foto Absensi** - Lihat foto siswa dengan filter

### Guru Workflow
1. **Monitoring** - Pantau kehadiran siswa real-time
2. **Foto Absensi** - Lihat foto kelas yang diampu
3. **Laporan** - Generate dan Export laporan

### Siswa Workflow
1. **Absensi Hadir** - Upload Foto (opsional), Absensi Sekarang
2. **Riwayat** - Lihat history kehadiran
3. **Jadwal Saya** - Lihat jadwal piket

## Teknologi

**Frontend:**
- HTML5, CSS3, JavaScript (ES6+)
- Bootstrap 5
- Font Awesome 6
- Google Fonts (Poppins)

**Backend:**
- PHP 7.4+
- MySQL 5.7+

**Tools:**
- XAMPP
- Git dan GitHub

## Struktur Project

```
E-piket-smekda/
├── config/
│   └── database.php              # Database config
├── auth/
│   ├── login.php                 # Login page
│   └── logout.php                # Logout
├── admin/
│   ├── dashboard.php             # Admin dashboard
│   ├── kelola-siswa.php          # Manage students
│   ├── kelola-guru.php           # Manage teachers
│   ├── kelola-kelas.php          # Manage classes
│   ├── kelola-jadwal.php         # Manage schedules
│   ├── laporan.php               # Reports
│   ├── detail-absensi.php        # View photos (NEW)
│   └── get-siswa.php             # AJAX helper
├── guru/
│   ├── dashboard.php             # Teacher dashboard
│   ├── monitoring.php            # Monitoring
│   ├── laporan.php               # Reports
│   └── detail-absensi.php        # View photos (NEW)
├── siswa/
│   ├── dashboard.php             # Student dashboard
│   ├── absensi-hadir.php         # Attendance with photo (NEW)
│   ├── pengajuan-izin.php        # Leave request
│   ├── riwayat.php               # History
│   └── jadwal-saya.php           # My schedule
├── uploads/
│   └── attendance/               # Photo storage (NEW)
├── asset/
│   ├── css/                      # Stylesheets
│   ├── js/                       # JavaScript
│   └── img/                      # Images
├── database_update_photo.sql     # SQL update (NEW)
├── epiket_smekda.sql             # Database file
└── README.md                     # This file
```

## Troubleshooting

### Error: Connection Refused
- Pastikan Apache dan MySQL running di XAMPP
- Restart Apache dan MySQL

### Error: Table doesn't exist
- Import database: epiket_smekda.sql
- Jalankan: database_update_photo.sql

### Foto tidak muncul
- Pastikan sudah jalankan query update database
- Cek folder uploads/attendance/ ada
- Refresh browser (Ctrl + F5)

### Menu "Foto Absensi" tidak ada
- Clear browser cache
- Refresh halaman (Ctrl + F5)

## Tips dan Best Practices

### Security
- Ubah password default setelah instalasi
- Gunakan HTTPS di production
- Backup database secara berkala
- Update PHP dan MySQL ke versi terbaru

### Performance
```sql
-- Tambahkan index untuk query lebih cepat
CREATE INDEX idx_schedule_date ON schedules(schedule_date);
CREATE INDEX idx_attendance_date ON attendances(attendance_date);
CREATE INDEX idx_student_class ON users(class_id);
```

### Upload Foto
- Format: JPG, PNG
- Ukuran Max: 5MB
- Lokasi: uploads/attendance/
- Nama file: attendance_{student_id}_{timestamp}.ext

## Dokumentasi Tambahan

- `QUICK_START.md` - Instalasi cepat
- `CHANGELOG.md` - Riwayat perubahan
- `CARA_MELIHAT_FOTO.txt` - Panduan foto
- `FITUR_JADWAL_MULTIPLE.txt` - Panduan jadwal
- `PANDUAN_SINGKAT.txt` - Panduan visual

## Changelog

### v1.1.0 (Desember 2024)
**Added:**
- Upload foto saat absensi
- Halaman "Foto Absensi" untuk admin dan guru
- Tambah jadwal multiple siswa sekaligus
- Tombol "Pilih Semua" di form jadwal
- Preview foto sebelum upload
- Modal zoom untuk foto
- Filter foto berdasarkan tanggal/kelas/status

**Fixed:**
- Optimasi query database
- Validasi upload file lebih ketat
- UI/UX lebih responsif
- Deteksi duplikat jadwal lebih akurat

**Database:**
- Tambah kolom photo_path di tabel attendances

### v1.0.0 (Oktober 2025)
- Initial Release
- Admin, Guru, Siswa Features
- Database Setup

## Roadmap

### v1.2.0 (Planned)
- Export laporan ke Excel
- Notifikasi email untuk siswa alpha
- Dashboard analytics dengan chart
- QR Code untuk absensi

### v1.3.0 (Planned)
- Multi-language support
- Dark mode
- REST API
- Mobile app (PWA)

## FAQ

**Q: Apakah upload foto wajib?**
A: Tidak, upload foto bersifat opsional.

**Q: Format foto apa yang didukung?**
A: JPG, JPEG, dan PNG dengan ukuran maksimal 5MB.

**Q: Bagaimana cara melihat foto absensi?**
A: Admin/Guru klik menu "Foto Absensi", pilih filter, klik foto untuk zoom.

**Q: Apakah bisa menambahkan banyak siswa sekaligus?**
A: Ya! Gunakan fitur "Tambah Jadwal Manual" dan centang multiple siswa.

**Q: Bagaimana cara update database untuk fitur foto?**
A: Jalankan query SQL yang ada di file database_update_photo.sql.

## Kontribusi

Ingin berkontribusi? Silakan:
1. Fork repository
2. Buat branch baru (git checkout -b feature/fitur-baru)
3. Commit changes (git commit -m 'Add new feature')
4. Push ke branch (git push origin feature/fitur-baru)
5. Buat Pull Request

## Kontak dan Support

**Email:** support@smkn2sby.sch.id  
**Website:** https://smkn2sby.sch.id  
**GitHub:** Report Bug

**Jam Support:** Senin-Jumat, 08:00-16:00 WIB

## Lisensi

Project ini dilisensikan di bawah MIT License.

## Credits

**Developed by:** Tim Pengembang SMKN 2 Surabaya

**Special Thanks:**
- Kepala Sekolah SMKN 2 Surabaya
- Guru-guru SMKN 2 Surabaya
- Siswa-siswi yang telah memberikan feedback

**Libraries:**
- Bootstrap 5
- Font Awesome 6
- Google Fonts (Poppins)

---

**Version:** 1.1.0 | **Status:** Production Ready

**Last Updated:** Desember 2025

Made with ❤️ by SMKN 2 Surabaya
