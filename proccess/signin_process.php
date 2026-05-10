<?php
// proccess/signin_process.php
session_start();
require_once '../config/connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'pages/signin/signin.php');
    exit;
}

$nama     = trim($_POST['nama']     ?? '');
$nim      = trim($_POST['nim']      ?? '');
$email    = trim($_POST['email']    ?? '');
$password = trim($_POST['password'] ?? '');

// Validasi sederhana
if (empty($nama) || empty($nim) || empty($email) || empty($password)) {
    header('Location: ' . BASE_URL . 'pages/signin/signin.php?error=empty');
    exit;
}

// Cek apakah email/nim sudah ada
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ? OR nim = ? LIMIT 1");
$stmt->bind_param('ss', $email, $nim);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    header('Location: ' . BASE_URL . 'pages/signin/signin.php?error=exists');
    exit;
}
$stmt->close();

// Insert user baru
$hash = password_hash($password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("INSERT INTO users (nama, nim, email, password, jabatan, created_at) VALUES (?, ?, ?, ?, 'Anggota', NOW())");
$stmt->bind_param('ssss', $nama, $nim, $email, $hash);

if ($stmt->execute()) {
    $new_id = $conn->insert_id;
    $_SESSION['user_id'] = $new_id;
    $_SESSION['nama']    = $nama;
    $_SESSION['email']   = $email;
    $_SESSION['nim']     = $nim;
    $_SESSION['jabatan'] = 'Anggota';
    $stmt->close();
    header('Location: ' . BASE_URL . 'pages/profile/profile.php');
    exit;
} else {
    $stmt->close();
    header('Location: ' . BASE_URL . 'pages/signin/signin.php?error=failed');
    exit;
}
