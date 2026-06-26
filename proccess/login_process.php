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

$pk      = get_user_pk($conn);
$has_nim = user_col_exists($conn, 'nim');

// Cari user berdasarkan email, NIM, atau username
$has_username = user_col_exists($conn, 'username');
if ($has_nim && $has_username) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR nim = ? OR username = ? LIMIT 1");
    $stmt->bind_param('sss', $email, $email, $email);
} elseif ($has_nim) {
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
    // Cek status akun — Nonaktif tidak bisa login
    if (($user['status'] ?? 'Aktif') === 'Nonaktif') {
        header('Location: ' . BASE_URL . 'pages/login/login.php?error=nonaktif');
        exit;
    }

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
