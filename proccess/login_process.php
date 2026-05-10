<?php
// proccess/login_process.php
session_start();
require_once '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'pages/login/login.php');
    exit;
}

$email    = trim($_POST['email']    ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($email) || empty($password)) {
    header('Location: ' . BASE_URL . 'pages/login/login.php?error=invalid');
    exit;
}

// Cari user berdasarkan email ATAU nim
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ? OR nim = ? LIMIT 1");
$stmt->bind_param('ss', $email, $email);
$stmt->execute();
$result = $stmt->get_result();
$user   = $result->fetch_assoc();
$stmt->close();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama']    = $user['nama'];
    $_SESSION['email']   = $user['email'];
    $_SESSION['nim']     = $user['nim'];
    $_SESSION['jabatan'] = $user['jabatan'] ?? 'Anggota';

    header('Location: ' . BASE_URL . 'pages/profile/profile.php');
    exit;
} else {
    header('Location: ' . BASE_URL . 'pages/login/login.php?error=invalid');
    exit;
}
