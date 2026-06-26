-- ============================================================
--  ORC ORMAWA ITH — Database Lengkap (All-in-One)
--  Import file ini saja, tidak perlu file SQL lain.
--  Aman dijalankan ulang (idempoten).
-- ============================================================
SET SQL_MODE   = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone  = "+00:00";
SET NAMES utf8mb4;
START TRANSACTION;

DROP DATABASE IF EXISTS `db_orc`;
CREATE DATABASE `db_orc` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_orc`;

-- ============================================================
--  TABEL: users
-- ============================================================
CREATE TABLE `users` (
  `id`         int(11)      NOT NULL AUTO_INCREMENT,
  `nama`       varchar(100) NOT NULL,
  `nim`        varchar(20)  NOT NULL DEFAULT '',
  `email`      varchar(150) NOT NULL,
  `username`   varchar(100) DEFAULT NULL,
  `no_hp`      varchar(20)  DEFAULT NULL,
  `password`   varchar(255) NOT NULL,
  `jabatan`    varchar(100) NOT NULL DEFAULT 'Anggota',
  `organisasi` varchar(100) DEFAULT NULL,
  `angkatan`   varchar(10)  DEFAULT NULL,
  `status`     enum('Aktif','Nonaktif') NOT NULL DEFAULT 'Aktif',
  `foto`       varchar(255) DEFAULT NULL,
  `created_at` timestamp    NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11)      DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `nim`   (`nim`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Akun demo (password plaintext: Admin123!)
-- Super Admin
INSERT INTO `users` (`nama`,`nim`,`email`,`username`,`no_hp`,`password`,`jabatan`,`organisasi`,`angkatan`,`status`) VALUES
('Super Admin ORC','000000000','superadmin@orc.ith.ac.id','superadmin','081200000000',
 '$2y$12$Fz9wKGV3ZVnY2Oz4YGkFxeQzM7qcDZ0i6JgHBXSRiPnFjjpFXrRLG',
 'Super Admin',NULL,NULL,'Aktif'),
('Administrator ORC','000000001','admin@orc.ith.ac.id','admin_orc','081200000099',
 '$2y$12$Fz9wKGV3ZVnY2Oz4YGkFxeQzM7qcDZ0i6JgHBXSRiPnFjjpFXrRLG',
 'Admin','BEM','2022','Aktif'),
('Demo Pengurus','241011002','pengurus@orc.ith.ac.id','pengurus_demo','081200000002',
 '$2y$12$Fz9wKGV3ZVnY2Oz4YGkFxeQzM7qcDZ0i6JgHBXSRiPnFjjpFXrRLG',
 'Pengurus','HCC','2023','Aktif'),
('Demo Mahasiswa','241011001','demo@orc.ith.ac.id','demo_mhs','081200000001',
 '$2y$12$Fz9wKGV3ZVnY2Oz4YGkFxeQzM7qcDZ0i6JgHBXSRiPnFjjpFXrRLG',
 'Anggota','HCC','2024','Aktif');

-- ============================================================
--  TABEL: organisasi
-- ============================================================
CREATE TABLE `organisasi` (
  `id`         int(11)      NOT NULL AUTO_INCREMENT,
  `nama`       varchar(150) NOT NULL,
  `singkatan`  varchar(30)  NOT NULL DEFAULT '',
  `deskripsi`  text         DEFAULT NULL,
  `slug`       varchar(60)  NOT NULL,
  `logo`       varchar(255) DEFAULT NULL,
  `foto_card`  varchar(255) DEFAULT NULL,
  `kategori`   varchar(50)  DEFAULT 'ukm',
  `status`     enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp    NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `organisasi` (`nama`,`singkatan`,`deskripsi`,`slug`,`logo`,`kategori`,`status`) VALUES
('Badan Eksekutif Mahasiswa (BEM) – ITH','BEM',
 'Wadah aspirasi, koordinasi kegiatan kampus, serta pengembangan kepemimpinan mahasiswa ITH.',
 'bem','assets/img/logo/logo-bem.jpeg','bem','aktif'),
('Habibie Engineering Robotic of Organization (HERO) – ITH','HERO',
 'Berfokus pada pengembangan teknologi robotika, IoT, dan inovasi di bidang engineering.',
 'hero','assets/img/logo/logo-hero.png','ukm','aktif'),
('Habibie Coding Club (HCC) – ITH','HCC',
 'Mendukung pengembangan skill coding, software, dan digital creativity mahasiswa ITH.',
 'hcc','assets/img/logo/logo-hcc.png','ukm','aktif'),
('UKM Seni Art & Talent (ARATTA) – ITH','ARATTA',
 'Wadah pengembangan minat, kreativitas, dan bakat mahasiswa di bidang seni dan hiburan.',
 'aratta','assets/img/logo/logo-aratta.png','ukm','aktif'),
('Wirausaha (WITH) – ITH','Wirausaha',
 'Berfokus pada pengembangan jiwa kewirausahaan, kreativitas bisnis, dan inovasi usaha.',
 'wirausaha','assets/img/logo/logo-with.png','ukm','aktif');

-- ============================================================
--  TABEL: kegiatan
-- ============================================================
CREATE TABLE `kegiatan` (
  `id_kegiatan`      int(11)      NOT NULL AUTO_INCREMENT,
  `nama_kegiatan`    varchar(150) NOT NULL,
  `organisasi`       varchar(100) NOT NULL DEFAULT 'Umum',
  `jenis_kegiatan`   varchar(50)  NOT NULL,
  `tanggal`          date         NOT NULL,
  `waktu`            time         NOT NULL DEFAULT '08:00:00',
  `tempat`           varchar(150) NOT NULL,
  `penanggung_jawab` varchar(100) NOT NULL,
  `deskripsi`        text         DEFAULT NULL,
  `status`           varchar(50)  NOT NULL DEFAULT 'Terjadwal',
  PRIMARY KEY (`id_kegiatan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
--  TABEL: anggota
-- ============================================================
CREATE TABLE `anggota` (
  `id_anggota`     int(11)      NOT NULL AUTO_INCREMENT,
  `user_id`        int(11)      DEFAULT NULL,
  `organisasi`     varchar(100) NOT NULL DEFAULT 'Umum',
  `jabatan`        varchar(100) DEFAULT 'Anggota',
  `nama`           varchar(100) NOT NULL,
  `alamat`         varchar(255) NOT NULL,
  `no_hp`          varchar(15)  NOT NULL,
  `tanggal_daftar` date         NOT NULL,
  PRIMARY KEY (`id_anggota`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
--  TABEL: dokumen
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
--  TABEL: dokumentasi
-- ============================================================
CREATE TABLE `dokumentasi` (
  `dokumentasi_id` int(11)                     NOT NULL AUTO_INCREMENT,
  `kegiatan_id`    int(11)                     NOT NULL,
  `file_path`      varchar(255)                NOT NULL,
  `tipe_file`      enum('foto','video','file') NOT NULL,
  `keterangan`     varchar(255)                DEFAULT NULL,
  `tanggal`        date                        NOT NULL,
  PRIMARY KEY (`dokumentasi_id`),
  KEY `kegiatan_id` (`kegiatan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
--  TABEL: materi_rapat
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
--  TABEL: pengumuman
-- ============================================================
CREATE TABLE `pengumuman` (
  `pengumuman_id` int(11)                                      NOT NULL AUTO_INCREMENT,
  `user_id`       int(11)                                      NOT NULL,
  `judul`         varchar(200)                                 NOT NULL,
  `konten`        text                                         NOT NULL,
  `target_role`   enum('semua','anggota','pengurus','pembina') DEFAULT 'semua',
  `tanggal`       timestamp                                    NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`pengumuman_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ============================================================
--  TABEL: event_organisasi
-- ============================================================
CREATE TABLE `event_organisasi` (
  `id`              int(11)      NOT NULL AUTO_INCREMENT,
  `judul`           varchar(200) NOT NULL,
  `organisasi_slug` varchar(60)  NOT NULL,
  `nama_organisasi` varchar(150) NOT NULL DEFAULT 'ORMAWA ITH',
  `tanggal`         date         NOT NULL,
  `lokasi`          varchar(200) NOT NULL,
  `deskripsi`       text         DEFAULT NULL,
  `banner`          varchar(255) DEFAULT NULL,
  `user_id`         int(11)      NOT NULL,
  `created_at`      timestamp    NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Data demo event
INSERT INTO `event_organisasi` (`judul`,`organisasi_slug`,`nama_organisasi`,`tanggal`,`lokasi`,`deskripsi`,`user_id`) VALUES
('Habibie Robotic Competition 2026','hero','HERO – ITH','2026-08-05','Lapangan Kampus ITH','Kompetisi robotika antar kampus tingkat nasional yang diselenggarakan oleh HERO ITH.',1),
('HCC Coding Bootcamp 2026','hcc','HCC – ITH','2026-07-20','Lab Komputer Lantai 3','Bootcamp intensif pemrograman web dan mobile selama 3 hari untuk mahasiswa ITH.',1),
('Seminar Nasional Teknologi & Inovasi','bem','BEM – ITH','2026-07-15','Aula Utama ITH Parepare','Seminar nasional membahas perkembangan teknologi dan inovasi terkini di era digital.',1),
('Pameran Seni ARATTA 2026','aratta','ARATTA – ITH','2026-07-10','Gedung Serbaguna ITH','Pameran karya seni mahasiswa ITH: lukisan, fotografi, dan pertunjukan musik live.',1),
('Workshop Kewirausahaan Digital','wirausaha','Wirausaha (WITH) – ITH','2026-07-05','Ruang Seminar Kampus ITH','Workshop praktis membangun bisnis digital dari nol bersama mentor berpengalaman.',1),
('Malam Keakraban BEM ITH 2026','bem','BEM – ITH','2026-06-28','Lapangan Olahraga ITH','Malam keakraban dan pelantikan pengurus BEM ITH periode 2026/2027.',1);

-- ============================================================
--  FOREIGN KEYS
-- ============================================================
ALTER TABLE `dokumentasi`
  ADD CONSTRAINT `fk_dok_kegiatan`   FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan`  (`id_kegiatan`) ON DELETE CASCADE;
ALTER TABLE `materi_rapat`
  ADD CONSTRAINT `fk_materi_kegiatan` FOREIGN KEY (`kegiatan_id`) REFERENCES `kegiatan`  (`id_kegiatan`) ON UPDATE CASCADE;
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `fk_pengumuman_user` FOREIGN KEY (`user_id`)     REFERENCES `users`     (`id`)          ON DELETE CASCADE;
ALTER TABLE `dokumen`
  ADD CONSTRAINT `fk_dokumen_user`    FOREIGN KEY (`user_id`)     REFERENCES `users`     (`id`)          ON DELETE CASCADE;
ALTER TABLE `event_organisasi`
  ADD CONSTRAINT `fk_event_user`      FOREIGN KEY (`user_id`)     REFERENCES `users`     (`id`)          ON DELETE CASCADE;

COMMIT;
-- ============================================================
--  SELESAI — cukup import file ini saja via phpMyAdmin
-- ============================================================
