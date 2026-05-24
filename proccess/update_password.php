<?php
// proccess/update_password.php
require_once '../config/connection.php';

if (empty($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'pages/login/login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=profil');
    exit;
}

$uid              = (int)$_SESSION['user_id'];
$old_password     = $_POST['old_password']     ?? '';
$new_password     = $_POST['new_password']     ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

$pk = get_user_pk($conn);

// Ambil hash lama
$stmt = $conn->prepare("SELECT password FROM users WHERE `$pk` = ? LIMIT 1");
$stmt->bind_param('i', $uid);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$row || !password_verify($old_password, $row['password'])) {
    header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=profil&error=Password+lama+salah!');
    exit;
}
if (strlen($new_password) < 6) {
    header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=profil&error=Password+baru+minimal+6+karakter!');
    exit;
}
if ($new_password !== $confirm_password) {
    header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=profil&error=Konfirmasi+password+tidak+cocok!');
    exit;
}

$hash = password_hash($new_password, PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE `$pk` = ?");
$stmt->bind_param('si', $hash, $uid);
$stmt->execute();
$stmt->close();

header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=profil&success=Password+berhasil+diubah!');
exit;
