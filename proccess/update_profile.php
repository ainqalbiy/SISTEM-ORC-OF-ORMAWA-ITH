<?php
// proccess/update_profile.php
require_once '../config/connection.php';

if (empty($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'pages/login/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'pages/profile/profile.php');
    exit;
}

$uid        = (int)$_SESSION['user_id'];
$nama       = trim($_POST['nama']       ?? '');
$no_hp      = trim($_POST['no_hp']      ?? '');
$jabatan    = trim($_POST['jabatan']    ?? '');
$organisasi = trim($_POST['organisasi'] ?? '');
$angkatan   = trim($_POST['angkatan']  ?? '');

if (empty($nama)) {
    header('Location: ' . BASE_URL . 'pages/profile/profile.php?error=empty');
    exit;
}

$stmt = $conn->prepare(
    "UPDATE users SET nama=?, no_hp=?, jabatan=?, organisasi=?, angkatan=? WHERE id=?"
);
$stmt->bind_param('sssssi', $nama, $no_hp, $jabatan, $organisasi, $angkatan, $uid);
$stmt->execute();
$stmt->close();

// Update session
$_SESSION['nama']       = $nama;
$_SESSION['jabatan']    = $jabatan;
$_SESSION['no_hp']      = $no_hp;
$_SESSION['organisasi'] = $organisasi;
$_SESSION['angkatan']   = $angkatan;

header('Location: ' . BASE_URL . 'pages/profile/profile.php?updated=1');
exit;
