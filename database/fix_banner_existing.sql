-- ================================================================
-- fix_banner_existing.sql
-- Jalankan ini di phpMyAdmin jika database SUDAH ADA sebelumnya
-- (tidak perlu import ulang db_orc.sql dari awal)
-- ================================================================

-- Update banner untuk data event yang banner-nya masih NULL atau path lama
UPDATE event_organisasi SET banner = 'assets/img/event/event_1782479869_256.jpeg'
WHERE judul = 'Habibie Robotic Competition 2026' AND (banner IS NULL OR banner = '');

UPDATE event_organisasi SET banner = 'assets/img/event/event_1782481247_734.jpeg'
WHERE judul = 'HCC Coding Bootcamp 2026' AND (banner IS NULL OR banner = '');

UPDATE event_organisasi SET banner = 'assets/img/event/event_1782481287_787.jpeg'
WHERE judul = 'Seminar Nasional Teknologi & Inovasi' AND (banner IS NULL OR banner = '');

UPDATE event_organisasi SET banner = 'assets/img/event/event_1782481326_296.jpeg'
WHERE judul = 'Pameran Seni ARATTA 2026' AND (banner IS NULL OR banner = '');

UPDATE event_organisasi SET banner = 'assets/img/event/event_1782707321_126.jpeg'
WHERE judul = 'Workshop Kewirausahaan Digital' AND (banner IS NULL OR banner = '');

UPDATE event_organisasi SET banner = 'assets/img/event/event_1782707608_899.jpeg'
WHERE judul = 'Malam Keakraban BEM ITH 2026' AND (banner IS NULL OR banner = '');

-- Jika ada data lama dengan path uploads/event/, pindahkan juga
UPDATE event_organisasi
SET banner = REPLACE(banner, 'uploads/event/', 'assets/img/event/')
WHERE banner LIKE 'uploads/event/%';
