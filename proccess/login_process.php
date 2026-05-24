<?php
// proccess/login_process.php
require_once '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'pages/login/login.php');
    exit;
}

$email    = trim($_POST['email']    ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($email) || empty($password)) {
    header('Location: ' . BASE_URL . 'pages/login/login.php?error=empty');
    exit;
}

// ── Deteksi primary key dan kolom yang ada ─────────────────────────
function get_pk_column(mysqli $conn): string {
    $res = $conn->query("SELECT COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE
                         WHERE TABLE_SCHEMA = DATABASE()
                           AND TABLE_NAME   = 'users'
                           AND CONSTRAINT_NAME = 'PRIMARY'
                         LIMIT 1");
    return ($res && $row = $res->fetch_assoc()) ? $row['COLUMN_NAME'] : 'id';
}

function col_exists(mysqli $conn, string $col): bool {
    $res = $conn->query("SELECT COUNT(*) AS c FROM information_schema.COLUMNS
                         WHERE TABLE_SCHEMA = DATABASE()
                           AND TABLE_NAME   = 'users'
                           AND COLUMN_NAME  = '$col'");
    return $res && $res->fetch_assoc()['c'] > 0;
}

$pk      = get_pk_column($conn);
$has_nim = col_exists($conn, 'nim');

// ── Cari user berdasarkan email atau NIM ───────────────────────────
if ($has_nim) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR nim = ? LIMIT 1");
    $stmt->bind_param('ss', $email, $email);
} else {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);
}
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($user && password_verify($password, $user['password'])) {
    // Pakai PK yang terdeteksi (id / user_id / id_user)
    $_SESSION['user_id']    = $user[$pk];
    $_SESSION['nama']       = $user['nama']        ?? '';
    $_SESSION['email']      = $user['email']       ?? '';
    $_SESSION['nim']        = $user['nim']         ?? '';
    $_SESSION['jabatan']    = $user['jabatan']     ?? 'Anggota';
    $_SESSION['no_hp']      = $user['no_hp']       ?? '';
    $_SESSION['organisasi'] = $user['organisasi']  ?? '';
    $_SESSION['angkatan']   = $user['angkatan']    ?? '';
    $_SESSION['status']     = $user['status']      ?? 'Aktif';
    $_SESSION['foto']       = $user['foto']        ?? '';

    header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?from=login');
    exit;
} else {
    header('Location: ' . BASE_URL . 'pages/login/login.php?error=invalid');
    exit;
}
