-- ============================================
-- E-PIKET SMEKDA - Database Update
-- ============================================
-- Menambahkan kolom photo_path untuk fitur upload foto absensi
-- ============================================

-- Tambahkan kolom photo_path ke tabel attendances
ALTER TABLE `attendances` 
ADD COLUMN `photo_path` VARCHAR(255) NULL AFTER `notes`;

-- Update komentar tabel
ALTER TABLE `attendances` 
COMMENT = 'Tabel untuk menyimpan data absensi siswa dengan foto';
