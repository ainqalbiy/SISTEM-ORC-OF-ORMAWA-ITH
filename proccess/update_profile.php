<?php
// proccess/update_profile.php
require_once '../config/connection.php';

if (empty($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'pages/login/login.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=profil');
    exit;
}

$uid        = (int)$_SESSION['user_id'];
$nama       = trim($_POST['nama']       ?? '');
$no_hp      = trim($_POST['no_hp']      ?? '');
$jabatan    = trim($_POST['jabatan']    ?? '');
$organisasi = trim($_POST['organisasi'] ?? '');
$angkatan   = trim($_POST['angkatan']  ?? '');
$from       = trim($_POST['from']       ?? 'dashboard'); // 'profile' or 'dashboard'

// Tentukan tujuan redirect
$redirect_ok  = ($from === 'profile')
    ? BASE_URL . 'pages/profile/profile.php?updated=1'
    : BASE_URL . 'pages/dashboard/dashboard.php?tab=profil&success=Profil+berhasil+diperbarui!';
$redirect_err = ($from === 'profile')
    ? BASE_URL . 'pages/profile/profile.php?error='
    : BASE_URL . 'pages/dashboard/dashboard.php?tab=profil&error=';

if (empty($nama)) {
    header('Location: ' . $redirect_err . urlencode('Nama tidak boleh kosong!'));
    exit;
}

$pk  = get_user_pk($conn);
$sql = "UPDATE users SET nama=?";
$types = 's';
$vals  = [$nama];

if (user_col_exists($conn, 'no_hp'))      { $sql .= ', no_hp=?';      $types .= 's'; $vals[] = $no_hp; }
if (user_col_exists($conn, 'jabatan'))    { $sql .= ', jabatan=?';    $types .= 's'; $vals[] = $jabatan; }
if (user_col_exists($conn, 'organisasi')) { $sql .= ', organisasi=?'; $types .= 's'; $vals[] = $organisasi; }
if (user_col_exists($conn, 'angkatan'))  { $sql .= ', angkatan=?';   $types .= 's'; $vals[] = $angkatan; }

$sql .= " WHERE `$pk` = ?";
$types .= 'i';
$vals[] = $uid;

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$vals);
$stmt->execute();
$stmt->close();

$_SESSION['nama']       = $nama;
$_SESSION['jabatan']    = $jabatan;
$_SESSION['no_hp']      = $no_hp;
$_SESSION['organisasi'] = $organisasi;
$_SESSION['angkatan']   = $angkatan;

header('Location: ' . $redirect_ok);
exit;
