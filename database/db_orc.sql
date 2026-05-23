-- ============================================================
-- ORC ORMAWA ITH — Database (Fixed & Completed)
-- ============================================================
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET NAMES utf8mb4;

-- Drop jika sudah ada
DROP DATABASE IF EXISTS `db_orc`;
CREATE DATABASE `db_orc` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_orc`;

-- ============================================================
-- Tabel: users
-- ============================================================
CREATE TABLE `users` (
  `id`         int(11)      NOT NULL AUTO_INCREMENT,
  `nama`       varchar(100) NOT NULL,
  `nim`        varchar(20)  NOT NULL,
  `email`      varchar(150) NOT NULL,
  `no_hp`      varchar(20)  DEFAULT NULL,
  `password`   varchar(255) NOT NULL,
  `jabatan`    varchar(100) NOT NULL DEFAULT 'Anggota',
  `organisasi` varchar(100) DEFAULT NULL,
  `angkatan`   varchar(10)  DEFAULT NULL,
  `status`     enum('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
  `foto`       varchar(255) DEFAULT NULL,
  `created_at` timestamp    NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `nim`   (`nim`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Akun demo (password: Admin123!)
INSERT INTO `users` (`nama`,`nim`,`email`,`no_hp`,`password`,`jabatan`,`organisasi`,`angkatan`,`status`) VALUES
('Administrator ORC','000000000','admin@orc.ith.ac.id','081200000000',
 '$2y$12$Fz9wKGV3ZVnY2Oz4YGkFxeQzM7qcDZ0i6JgHBXSRiPnFjjpFXrRLG',
 'Admin','BEM','2022','Aktif'),
('Demo Mahasiswa','241011001','demo@orc.ith.ac.id','081200000001',
 '$2y$12$Fz9wKGV3ZVnY2Oz4YGkFxeQzM7qcDZ0i6JgHBXSRiPnFjjpFXrRLG',
 'Anggota','HCC','2024','Aktif');

-- ============================================================
-- Tabel: anggota
-- ============================================================
CREATE TABLE `anggota` (
  `id_anggota`     int(11)      NOT NULL AUTO_INCREMENT,
  `user_id`        int(11)      DEFAULT NULL,
  `nama`           varchar(100) NOT NULL,
  `alamat`         varchar(255) NOT NULL,
  `no_hp`          varchar(15)  NOT NULL,
  `tanggal_daftar` date         NOT NULL,
  PRIMARY KEY (`id_anggota`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- Tabel: kegiatan
-- ============================================================
CREATE TABLE `kegiatan` (
  `id_kegiatan`      int(11)      NOT NULL AUTO_INCREMENT,
  `nama_kegiatan`    varchar(150) NOT NULL,
  `jenis_kegiatan`   varchar(50)  NOT NULL,
  `tanggal`          date         NOT NULL,
  `waktu`            time         NOT NULL,
  `tempat`           varchar(150) NOT NULL,
  `penanggung_jawab` varchar(100) NOT NULL,
  `deskripsi`        text         DEFAULT NULL,
  `status`           varchar(50)  NOT NULL DEFAULT 'Terjadwal',
  PRIMARY KEY (`id_kegiatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- Tabel: dokumen
-- ============================================================
CREATE TABLE `dokumen` (
  `id_dokumen`     int(11)      NOT NULL AUTO_INCREMENT,
  `judul`          varchar(255) NOT NULL,
  `jenis`          varchar(100) NOT NULL,
  `file`           varchar(255) NOT NULL,
  `tanggal_upload` datetime     NOT NULL DEFAULT current_timestamp(),
  `user_id`        int(11)      NOT NULL,
  PRIMARY KEY (`id_dokumen`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- Tabel: dokumentasi
-- ============================================================
CREATE TABLE `dokumentasi` (
  `dokumentasi_id` int(11)                       NOT NULL AUTO_INCREMENT,
  `kegiatan_id`    int(11)                       NOT NULL,
  `file_path`      varchar(255)                  NOT NULL,
  `tipe_file`      enum('foto','video','file')   NOT NULL,
  `keterangan`     varchar(255)                  DEFAULT NULL,
  `tanggal`        date                          NOT NULL,
  PRIMARY KEY (`dokumentasi_id`),
  KEY `kegiatan_id` (`kegiatan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- Tabel: materi_rapat
-- ============================================================
CREATE TABLE `materi_rapat` (
  `materi_id`   int(11)      NOT NULL AUTO_INCREMENT,
  `kegiatan_id` int(11)      NOT NULL,
  `file_path`   varchar(255) NOT NULL,
  `tanggal`     date         NOT NULL,
  PRIMARY KEY (`materi_id`),
  KEY `kegiatan_id` (`kegiatan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
-- Tabel: pengumuman
-- ============================================================
CREATE TABLE `pengumuman` (
  `pengumuman_id` int(11)                                         NOT NULL AUTO_INCREMENT,
  `user_id`       int(11)                                         NOT NULL,
  `judul`         varchar(200)                                    NOT NULL,
  `konten`        text                                            NOT NULL,
  `target_role`   enum('semua','anggota','pengurus','pembina')    DEFAULT 'semua',
  `tanggal`       timestamp                                       NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`pengumuman_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Foreign Keys
ALTER TABLE `dokumentasi`
  ADD CONSTRAINT `dokumentasi_ibfk_1` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id_kegiatan`) ON DELETE CASCADE;

ALTER TABLE `materi_rapat`
  ADD CONSTRAINT `materi_rapat_ibfk_1` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan` (`id_kegiatan`) ON UPDATE CASCADE;

ALTER TABLE `pengumuman`
  ADD CONSTRAINT `pengumuman_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

ALTER TABLE `dokumen`
  ADD CONSTRAINT `dokumen_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

COMMIT;
