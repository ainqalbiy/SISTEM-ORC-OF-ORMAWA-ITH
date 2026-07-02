<?php

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

if (!defined('BASE_URL')) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host     = $_SERVER['HTTP_HOST'] ?? 'localhost';

    $root_dir  = str_replace('\\', '/', realpath(__DIR__ . '/..'));
    $doc_root  = str_replace('\\', '/', realpath($_SERVER['DOCUMENT_ROOT'] ?? $root_dir));

    if (strpos($root_dir, $doc_root) === 0) {
        $base_path = substr($root_dir, strlen($doc_root));
    } else {
        $script = str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME'] ?? '');
        $base_path = '';
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

/**
 * Cek apakah user yang sedang login adalah Super Admin
 */
function is_super_admin(): bool {
    return ($_SESSION['jabatan'] ?? '') === 'Super Admin';
}

/**
 * Cek apakah user yang sedang login adalah Admin (termasuk Super Admin)
 */
function is_admin_or_super(): bool {
    $j = $_SESSION['jabatan'] ?? '';
    return in_array($j, ['Admin', 'Super Admin']);
}

/**
 * Paksa hanya Super Admin yang boleh akses, redirect jika bukan
 */
function require_super_admin(): void {
    require_login();
    if (!is_super_admin()) {
        header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?error=akses_ditolak');
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
