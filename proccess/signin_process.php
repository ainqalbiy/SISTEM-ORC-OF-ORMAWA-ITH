<?php
// proccess/signin_process.php
require_once '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'pages/signin.php');
    exit;
}

$nama             = trim($_POST['nama']             ?? '');
$nim              = trim($_POST['nim']              ?? '');
$email            = trim($_POST['email']            ?? '');
$password         = trim($_POST['password']         ?? '');
$confirm_password = trim($_POST['confirm_password'] ?? '');

if (empty($nama) || empty($nim) || empty($email) || empty($password)) {
    header('Location: ' . BASE_URL . 'pages/signin.php?error=empty');
    exit;
}
if (strlen($password) < 6) {
    header('Location: ' . BASE_URL . 'pages/signin.php?error=short');
    exit;
}
if ($password !== $confirm_password) {
    header('Location: ' . BASE_URL . 'pages/signin.php?error=mismatch');
    exit;
}

// ── Deteksi nama kolom primary key tabel users ─────────────────────
function get_pk_column(mysqli $conn): string {
    $res = $conn->query("SELECT COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE
                         WHERE TABLE_SCHEMA = DATABASE()
                           AND TABLE_NAME   = 'users'
                           AND CONSTRAINT_NAME = 'PRIMARY'
                         LIMIT 1");
    if ($res && $row = $res->fetch_assoc()) {
        return $row['COLUMN_NAME'];
    }
    return 'id'; // fallback
}

// ── Deteksi kolom yang ada di tabel users ──────────────────────────
function col_exists(mysqli $conn, string $col): bool {
    $res = $conn->query("SELECT COUNT(*) AS c FROM information_schema.COLUMNS
                         WHERE TABLE_SCHEMA = DATABASE()
                           AND TABLE_NAME   = 'users'
                           AND COLUMN_NAME  = '$col'");
    return $res && $res->fetch_assoc()['c'] > 0;
}

$pk = get_pk_column($conn);

// ── Cek apakah email/NIM sudah terdaftar ───────────────────────────
$has_nim = col_exists($conn, 'nim');
if ($has_nim) {
    $stmt = $conn->prepare("SELECT $pk FROM users WHERE email = ? OR nim = ? LIMIT 1");
    $stmt->bind_param('ss', $email, $nim);
} else {
    $stmt = $conn->prepare("SELECT $pk FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param('s', $email);
}
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->close();
    header('Location: ' . BASE_URL . 'pages/signin.php?error=exists');
    exit;
}
$stmt->close();

// ── Build INSERT sesuai kolom yang tersedia ────────────────────────
$hash = password_hash($password, PASSWORD_DEFAULT);
$has_jabatan    = col_exists($conn, 'jabatan');
$has_no_hp      = col_exists($conn, 'no_hp');
$has_organisasi = col_exists($conn, 'organisasi');
$has_angkatan   = col_exists($conn, 'angkatan');
$has_status     = col_exists($conn, 'status');
$has_created_at = col_exists($conn, 'created_at');

// Bangun query dinamis
$cols   = ['nama', 'email', 'password'];
$pholds = ['?',    '?',     '?'];
$types  = 'sss';
$vals   = [$nama, $email, $hash];

if ($has_nim)      { $cols[] = 'nim';        $pholds[] = '?'; $types .= 's'; $vals[] = $nim; }
if ($has_jabatan)  { $cols[] = 'jabatan';    $pholds[] = "'Anggota'"; }
if ($has_status)   { $cols[] = 'status';     $pholds[] = "'Aktif'"; }
if ($has_created_at){ $cols[] = 'created_at'; $pholds[] = 'NOW()'; }

$sql = "INSERT INTO users (" . implode(',', $cols) . ") VALUES (" . implode(',', $pholds) . ")";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$vals);

if ($stmt->execute()) {
    $new_id = $conn->insert_id;

    $_SESSION['user_id']    = $new_id;
    $_SESSION['nama']       = $nama;
    $_SESSION['email']      = $email;
    $_SESSION['nim']        = $nim;
    $_SESSION['jabatan']    = 'Anggota';
    $_SESSION['no_hp']      = '';
    $_SESSION['organisasi'] = '';
    $_SESSION['angkatan']   = '';
    $_SESSION['status']     = 'Aktif';
    $_SESSION['foto']       = '';

    $stmt->close();
    header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?from=signin');
    exit;
} else {
    $err = $conn->error;
    $stmt->close();
    header('Location: ' . BASE_URL . 'pages/signin.php?error=failed&detail=' . urlencode($err));
    exit;
}
