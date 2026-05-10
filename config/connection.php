<?php
// config/connection.php — Konfigurasi Database & BASE_URL

// Mulai session jika belum dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_orc');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// BASE_URL otomatis dari posisi file ini (/config/)
if (!defined('BASE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host     = $_SERVER['HTTP_HOST'];
    $docRoot  = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT']));
    $rootDir  = str_replace('\\', '/', realpath(__DIR__ . '/..'));
    $basePath = '/' . ltrim(str_replace($docRoot, '', $rootDir), '/');
    $basePath = rtrim($basePath, '/') . '/';
    define('BASE_URL', $protocol . '://' . $host . $basePath);
}
