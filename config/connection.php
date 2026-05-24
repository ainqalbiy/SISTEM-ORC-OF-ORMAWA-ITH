<?php
// config/connection.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ── Database ──────────────────────────────────────────────────────
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'db_orc');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// ── BASE_URL — cara paling reliable lintas setup XAMPP/Laragon/dll ─
if (!defined('BASE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host     = $_SERVER['HTTP_HOST'] ?? 'localhost';

    // Posisi folder root proyek ini = satu level di atas /config/
    $root_dir  = str_replace('\\', '/', realpath(__DIR__ . '/..'));
    $doc_root  = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'] ?? $root_dir));

    // Buat relative path dari document root ke root proyek
    if (strpos($root_dir, $doc_root) === 0) {
        $base_path = substr($root_dir, strlen($doc_root));
    } else {
        // Fallback: ambil dari SCRIPT_NAME
        $script = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME'] ?? '');
        $base_path = '';
        // Cari nama folder orc_fixed di path
        if (preg_match('#(/[^/]+/orc_fixed)#', str_replace($doc_root, '', $script), $m)) {
            $base_path = $m[1];
        }
    }

    $base_path = '/' . trim($base_path, '/') . '/';
    if ($base_path === '//') $base_path = '/';

    define('BASE_URL', $protocol . '://' . $host . $base_path);
}

// ── Helpers ───────────────────────────────────────────────────────
function require_login(): void {
    if (empty($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . 'pages/login/login.php');
        exit;
    }
}

function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path, array $params = []): void {
    $url = BASE_URL . ltrim($path, '/');
    if (!empty($params)) {
        $url .= '?' . http_build_query($params);
    }
    header('Location: ' . $url);
    exit;
}

/**
 * Deteksi nama kolom primary key tabel users secara otomatis.
 * Menangani database lama (user_id, id_user, dll) maupun baru (id).
 */
function get_user_pk(mysqli $conn): string {
    static $cache = null;
    if ($cache !== null) return $cache;
    $res = $conn->query(
        "SELECT COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE
         WHERE TABLE_SCHEMA = DATABASE()
           AND TABLE_NAME   = 'users'
           AND CONSTRAINT_NAME = 'PRIMARY'
         LIMIT 1"
    );
    $cache = ($res && $row = $res->fetch_assoc()) ? $row['COLUMN_NAME'] : 'id';
    return $cache;
}

/**
 * Cek apakah kolom tertentu ada di tabel users.
 */
function user_col_exists(mysqli $conn, string $col): bool {
    $col_esc = $conn->real_escape_string($col);
    $res = $conn->query(
        "SELECT COUNT(*) AS c FROM information_schema.COLUMNS
         WHERE TABLE_SCHEMA = DATABASE()
           AND TABLE_NAME   = 'users'
           AND COLUMN_NAME  = '$col_esc'"
    );
    return $res && $res->fetch_assoc()['c'] > 0;
}
