-- ============================================================
-- MIGRATION v2 — Tambah kolom organisasi ke tabel kegiatan & anggota
-- Aman dijalankan pada database yang sudah ada
-- ============================================================
USE `db_orc`;

-- Tambah kolom organisasi ke tabel kegiatan (jika belum ada)
SET @col = (SELECT COUNT(*) FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA='db_orc' AND TABLE_NAME='kegiatan' AND COLUMN_NAME='organisasi');
SET @sql = IF(@col=0,
    "ALTER TABLE kegiatan ADD COLUMN organisasi varchar(100) NOT NULL DEFAULT 'Umum' AFTER nama_kegiatan",
    'SELECT "organisasi di kegiatan sudah ada"');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Tambah kolom organisasi ke tabel anggota (jika belum ada)
SET @col = (SELECT COUNT(*) FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA='db_orc' AND TABLE_NAME='anggota' AND COLUMN_NAME='organisasi');
SET @sql = IF(@col=0,
    "ALTER TABLE anggota ADD COLUMN organisasi varchar(100) NOT NULL DEFAULT 'Umum' AFTER user_id",
    'SELECT "organisasi di anggota sudah ada"');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Tambah kolom jabatan ke tabel anggota (untuk keperluan tampilan)
SET @col = (SELECT COUNT(*) FROM information_schema.COLUMNS
            WHERE TABLE_SCHEMA='db_orc' AND TABLE_NAME='anggota' AND COLUMN_NAME='jabatan');
SET @sql = IF(@col=0,
    "ALTER TABLE anggota ADD COLUMN jabatan varchar(100) DEFAULT 'Anggota' AFTER organisasi",
    'SELECT "jabatan di anggota sudah ada"');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SELECT 'Migration v2 selesai! Kolom organisasi & jabatan ditambahkan.' AS Status;
