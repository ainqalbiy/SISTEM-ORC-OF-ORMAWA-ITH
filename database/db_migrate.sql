-- ============================================================
-- MIGRATION SCRIPT — Jalankan ini jika database lama sudah ada
-- Aman dijalankan pada database yang sudah ada datanya
-- ============================================================
USE `db_orc`;

-- Cek dan tambah kolom yang kurang ke tabel users
-- (MySQL akan skip jika kolom sudah ada via IGNORE workaround)

-- Tambah kolom nim jika belum ada
SET @col = (SELECT COUNT(*) FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA='db_orc' AND TABLE_NAME='users' AND COLUMN_NAME='nim');
SET @sql = IF(@col=0, 
    'ALTER TABLE users ADD COLUMN nim varchar(20) NOT NULL DEFAULT "" AFTER nama',
    'SELECT "nim sudah ada"');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Tambah kolom no_hp jika belum ada
SET @col = (SELECT COUNT(*) FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA='db_orc' AND TABLE_NAME='users' AND COLUMN_NAME='no_hp');
SET @sql = IF(@col=0, 
    'ALTER TABLE users ADD COLUMN no_hp varchar(20) DEFAULT NULL AFTER email',
    'SELECT "no_hp sudah ada"');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Tambah kolom jabatan jika belum ada
SET @col = (SELECT COUNT(*) FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA='db_orc' AND TABLE_NAME='users' AND COLUMN_NAME='jabatan');
SET @sql = IF(@col=0,
    'ALTER TABLE users ADD COLUMN jabatan varchar(100) NOT NULL DEFAULT "Anggota" AFTER password',
    'SELECT "jabatan sudah ada"');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Tambah kolom organisasi jika belum ada
SET @col = (SELECT COUNT(*) FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA='db_orc' AND TABLE_NAME='users' AND COLUMN_NAME='organisasi');
SET @sql = IF(@col=0,
    'ALTER TABLE users ADD COLUMN organisasi varchar(100) DEFAULT NULL AFTER jabatan',
    'SELECT "organisasi sudah ada"');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Tambah kolom angkatan jika belum ada
SET @col = (SELECT COUNT(*) FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA='db_orc' AND TABLE_NAME='users' AND COLUMN_NAME='angkatan');
SET @sql = IF(@col=0,
    'ALTER TABLE users ADD COLUMN angkatan varchar(10) DEFAULT NULL AFTER organisasi',
    'SELECT "angkatan sudah ada"');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Tambah kolom status jika belum ada
SET @col = (SELECT COUNT(*) FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA='db_orc' AND TABLE_NAME='users' AND COLUMN_NAME='status');
SET @sql = IF(@col=0,
    "ALTER TABLE users ADD COLUMN status enum('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif' AFTER angkatan",
    'SELECT "status sudah ada"');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Tambah kolom foto jika belum ada
SET @col = (SELECT COUNT(*) FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA='db_orc' AND TABLE_NAME='users' AND COLUMN_NAME='foto');
SET @sql = IF(@col=0,
    'ALTER TABLE users ADD COLUMN foto varchar(255) DEFAULT NULL AFTER status',
    'SELECT "foto sudah ada"');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Pastikan PRIMARY KEY bernama id (bukan user_id atau lainnya)
-- Cek nama kolom primary key
SELECT COLUMN_NAME as 'Primary Key users table:' 
FROM information_schema.KEY_COLUMN_USAGE 
WHERE TABLE_SCHEMA='db_orc' AND TABLE_NAME='users' AND CONSTRAINT_NAME='PRIMARY';

-- Pastikan tabel-tabel lain ada
CREATE TABLE IF NOT EXISTS `kegiatan` (
  `id_kegiatan`      int(11)      NOT NULL AUTO_INCREMENT,
  `nama_kegiatan`    varchar(150) NOT NULL,
  `jenis_kegiatan`   varchar(50)  NOT NULL,
  `tanggal`          date         NOT NULL,
  `waktu`            time         NOT NULL DEFAULT '08:00:00',
  `tempat`           varchar(150) NOT NULL,
  `penanggung_jawab` varchar(100) NOT NULL,
  `deskripsi`        text         DEFAULT NULL,
  `status`           varchar(50)  NOT NULL DEFAULT 'Terjadwal',
  PRIMARY KEY (`id_kegiatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `dokumen` (
  `id_dokumen`     int(11)      NOT NULL AUTO_INCREMENT,
  `judul`          varchar(255) NOT NULL,
  `jenis`          varchar(100) NOT NULL,
  `file`           varchar(255) NOT NULL,
  `tanggal_upload` datetime     NOT NULL DEFAULT current_timestamp(),
  `user_id`        int(11)      NOT NULL,
  PRIMARY KEY (`id_dokumen`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `anggota` (
  `id_anggota`     int(11)      NOT NULL AUTO_INCREMENT,
  `user_id`        int(11)      DEFAULT NULL,
  `nama`           varchar(100) NOT NULL,
  `alamat`         varchar(255) NOT NULL,
  `no_hp`          varchar(15)  NOT NULL,
  `tanggal_daftar` date         NOT NULL,
  PRIMARY KEY (`id_anggota`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `pengumuman` (
  `pengumuman_id` int(11)      NOT NULL AUTO_INCREMENT,
  `user_id`       int(11)      NOT NULL,
  `judul`         varchar(200) NOT NULL,
  `konten`        text         NOT NULL,
  `target_role`   enum('semua','anggota','pengurus','pembina') DEFAULT 'semua',
  `tanggal`       timestamp    NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`pengumuman_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SELECT 'Migration selesai!' AS Status;
