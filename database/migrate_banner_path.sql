-- ================================================================
-- migrate_banner_path.sql
-- Update path banner event dari uploads/event/ → assets/img/event/
-- Jalankan sekali di phpMyAdmin atau MySQL CLI
-- ================================================================
UPDATE event_organisasi
SET banner = REPLACE(banner, 'uploads/event/', 'assets/img/event/')
WHERE banner LIKE 'uploads/event/%';
