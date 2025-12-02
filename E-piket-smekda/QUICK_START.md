# 🚀 Quick Start Guide - E-Piket SMEKDA

## Instalasi Cepat (5 Menit)

### 1️⃣ Setup XAMPP
```bash
# Windows
1. Download XAMPP dari https://www.apachefriends.org
2. Install XAMPP
3. Copy folder E-piket-smekda ke C:\xampp\htdocs\
4. Start Apache & MySQL di XAMPP Control Panel
```

### 2️⃣ Setup Database
```sql
1. Buka http://localhost/phpmyadmin
2. Buat database baru: epiket_smekda
3. Import file: epiket_smekda.sql
4. Jalankan update untuk fitur foto:
   ALTER TABLE `attendances` ADD COLUMN `photo_path` VARCHAR(255) NULL AFTER `notes`;
```

### 3️⃣ Akses Aplikasi
```
URL: http://localhost/E-piket-smekda
```

## 🔑 Login Default

| Role | Username | Password |
|------|----------|----------|
| Admin | admin | admin123 |
| Guru | guru001 | guru123 |
| Siswa | 2024001 | siswa123 |

## ⚡ Fitur Utama

### Admin
1. **Kelola Data** → Siswa, Guru, Kelas
2. **Jadwal Piket** → Generate Otomatis atau Manual (Multiple)
3. **Foto Absensi** → Lihat foto siswa saat absensi

### Guru
1. **Monitoring** → Pantau kehadiran siswa
2. **Foto Absensi** → Lihat foto absensi kelas yang diampu
3. **Laporan** → Generate laporan bulanan/tahunan

### Siswa
1. **Absensi Hadir** → Klik & Upload Foto (opsional)
2. **Riwayat** → Lihat history kehadiran
3. **Jadwal Saya** → Lihat jadwal piket

## 🆕 Fitur Baru v1.1.0

### 📸 Upload Foto Absensi
```
Siswa → Absensi Hadir → Upload Foto → Absensi Sekarang
Admin/Guru → Menu "Foto Absensi" → Filter & Lihat
```

### 📅 Jadwal Multiple
```
Admin → Jadwal Piket → Tambah Jadwal Manual
→ Centang 5 siswa sekaligus → Simpan (1x klik!)
```

## 🔧 Troubleshooting

### Error: Connection Refused
```bash
✓ Pastikan Apache & MySQL running di XAMPP
✓ Restart Apache & MySQL
```

### Error: Table doesn't exist
```bash
✓ Import database SQL file
✓ Jalankan query update foto
```

### Foto tidak muncul
```bash
✓ Cek folder uploads/attendance/ ada
✓ Jalankan query: ALTER TABLE attendances ADD COLUMN photo_path...
```

## 📚 Dokumentasi Lengkap

- `README.md` - Dokumentasi lengkap
- `PANDUAN_SINGKAT.txt` - Panduan visual
- `CARA_MELIHAT_FOTO.txt` - Cara lihat foto
- `FITUR_JADWAL_MULTIPLE.txt` - Panduan jadwal multiple

## 💡 Tips

1. **Ubah password default** setelah instalasi
2. **Backup database** secara berkala
3. **Gunakan Chrome/Firefox** untuk performa terbaik
4. **Upload foto max 5MB** (JPG/PNG)

## 🆘 Butuh Bantuan?

- Baca FAQ di README.md
- Cek file PANDUAN_SINGKAT.txt
- Lihat dokumentasi di folder project

---

**Version:** 1.1.0 | **Last Updated:** Desember 2024
