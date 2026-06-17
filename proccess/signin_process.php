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

$pk      = get_user_pk($conn);
$has_nim = user_col_exists($conn, 'nim');

// Cek apakah email/NIM sudah terdaftar
if ($has_nim) {
    $stmt = $conn->prepare("SELECT `$pk` FROM users WHERE email = ? OR nim = ? LIMIT 1");
    $stmt->bind_param('ss', $email, $nim);
} else {
    $stmt = $conn->prepare("SELECT `$pk` FROM users WHERE email = ? LIMIT 1");
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

// Build INSERT sesuai kolom yang tersedia
$hash = password_hash($password, PASSWORD_DEFAULT);
$has_jabatan    = user_col_exists($conn, 'jabatan');
$has_status     = user_col_exists($conn, 'status');
$has_created_at = user_col_exists($conn, 'created_at');

$cols   = ['nama', 'email', 'password'];
$pholds = ['?',    '?',     '?'];
$types  = 'sss';
$vals   = [$nama, $email, $hash];

if ($has_nim)       { $cols[] = 'nim';        $pholds[] = '?'; $types .= 's'; $vals[] = $nim; }
if ($has_jabatan)   { $cols[] = 'jabatan';    $pholds[] = "'Anggota'"; }  // ← default Anggota
if ($has_status)    { $cols[] = 'status';     $pholds[] = "'Aktif'"; }
if ($has_created_at){ $cols[] = 'created_at'; $pholds[] = 'NOW()'; }

$sql  = "INSERT INTO users (" . implode(',', $cols) . ") VALUES (" . implode(',', $pholds) . ")";
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$vals);

if ($stmt->execute()) {
    $new_id = $conn->insert_id;

    $_SESSION['user_id']    = $new_id;
    $_SESSION['nama']       = $nama;
    $_SESSION['email']      = $email;
    $_SESSION['nim']        = $nim;
    $_SESSION['jabatan']    = 'Anggota';  // ← default Anggota
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