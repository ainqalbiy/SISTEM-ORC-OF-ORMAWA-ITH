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
$organisasi = trim($_POST['organisasi'] ?? '');
$angkatan   = trim($_POST['angkatan']  ?? '');

// Jabatan HANYA bisa diubah oleh Super Admin — user biasa tidak bisa ubah role sendiri
$current_jabatan = $_SESSION['jabatan'] ?? 'Anggota';
$jabatan = $current_jabatan; // default: pertahankan role saat ini

if (empty($nama)) {
    header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=profil&error=Nama+tidak+boleh+kosong!');
    exit;
}

// Ambil foto lama (buat dihapus nanti kalau ada foto baru / dihapus)
$foto_lama = null;
if (user_col_exists($conn, 'foto')) {
    $stmt_foto = $conn->prepare("SELECT foto FROM users WHERE id = ? LIMIT 1");
    $stmt_foto->bind_param('i', $uid);
    $stmt_foto->execute();
    $row_foto  = $stmt_foto->get_result()->fetch_assoc();
    $foto_lama = $row_foto['foto'] ?? null;
    $stmt_foto->close();
}

// ── HAPUS FOTO (kalau checkbox "Hapus foto profil" dicentang) ──
if (!empty($_POST['hapus_foto']) && $_POST['hapus_foto'] === '1') {
    if (!empty($foto_lama)) {
        $old_file = __DIR__ . '/../' . $foto_lama;
        if (is_file($old_file)) {
            unlink($old_file);
        }
    }

    $pk = get_user_pk($conn);
    $stmt_hapus = $conn->prepare("UPDATE users SET foto = NULL WHERE `$pk` = ?");
    $stmt_hapus->bind_param('i', $uid);
    $stmt_hapus->execute();
    $stmt_hapus->close();

    unset($_SESSION['foto']);

    // Tetap update data lain (nama, no_hp, dll) sekalian biar konsisten
    $sql_hapus_lain = "UPDATE users SET nama=?";
    $types_hl = 's';
    $vals_hl  = [$nama];
    if (user_col_exists($conn, 'no_hp'))      { $sql_hapus_lain .= ', no_hp=?';      $types_hl .= 's'; $vals_hl[] = $no_hp; }
    if (user_col_exists($conn, 'jabatan'))    { $sql_hapus_lain .= ', jabatan=?';    $types_hl .= 's'; $vals_hl[] = $jabatan; }
    if (user_col_exists($conn, 'organisasi')) { $sql_hapus_lain .= ', organisasi=?'; $types_hl .= 's'; $vals_hl[] = $organisasi; }
    if (user_col_exists($conn, 'angkatan'))   { $sql_hapus_lain .= ', angkatan=?';   $types_hl .= 's'; $vals_hl[] = $angkatan; }
    $sql_hapus_lain .= " WHERE `$pk` = ?";
    $types_hl .= 'i';
    $vals_hl[] = $uid;

    $stmt_hl = $conn->prepare($sql_hapus_lain);
    $stmt_hl->bind_param($types_hl, ...$vals_hl);
    $stmt_hl->execute();
    $stmt_hl->close();

    $_SESSION['nama']       = $nama;
    $_SESSION['jabatan']    = $jabatan;
    $_SESSION['no_hp']      = $no_hp;
    $_SESSION['organisasi'] = $organisasi;
    $_SESSION['angkatan']   = $angkatan;

    header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=profil&success=Foto+profil+dihapus!');
    exit;
}

// ── UPLOAD FOTO PROFIL ──────────────────────────────
$foto_path = null; // null = tidak ada foto baru, kolom foto tidak diubah

if (!empty($_FILES['foto']['name']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {

    $allowed_ext  = ['jpg', 'jpeg', 'png'];
    $max_size     = 2 * 1024 * 1024; // 2MB
    $tmp_name     = $_FILES['foto']['tmp_name'];
    $original_ext = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));

    // Validasi ekstensi
    if (!in_array($original_ext, $allowed_ext)) {
        header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=profil&error=Format+foto+harus+JPG+atau+PNG!');
        exit;
    }

    // Validasi ukuran file
    if ($_FILES['foto']['size'] > $max_size) {
        header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=profil&error=Ukuran+foto+maksimal+2MB!');
        exit;
    }

    // Validasi isi file benar-benar gambar (bukan file lain yang disamarkan)
    $check_image = getimagesize($tmp_name);
    if ($check_image === false) {
        header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=profil&error=File+bukan+gambar+valid!');
        exit;
    }

    // Nama file unik supaya tidak bentrok antar user
    $new_filename = 'user_' . $uid . '_' . time() . '.' . $original_ext;
    $upload_dir   = __DIR__ . '/../assets/img/profile/';

    // Buat folder kalau belum ada
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    $upload_full_path = $upload_dir . $new_filename;

    if (move_uploaded_file($tmp_name, $upload_full_path)) {
        // Path relatif yang disimpan ke database (dipakai bareng BASE_URL saat ditampilkan)
        $foto_path = 'assets/img/profile/' . $new_filename;

        // Hapus foto lama supaya tidak numpuk file sampah
        if (!empty($foto_lama)) {
            $old_file = __DIR__ . '/../' . $foto_lama;
            if (is_file($old_file)) {
                unlink($old_file);
            }
        }
    } else {
        // Upload gagal -- kasih tau errornya biar ketauan penyebabnya
        header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=profil&error=Gagal+simpan+foto.+Cek+folder:+' . urlencode($upload_dir));
        exit;
    }
}

$pk  = get_user_pk($conn);
$sql = "UPDATE users SET nama=?";
$types = 's';
$vals  = [$nama];

if (user_col_exists($conn, 'no_hp'))      { $sql .= ', no_hp=?';      $types .= 's'; $vals[] = $no_hp; }
if (user_col_exists($conn, 'jabatan'))    { $sql .= ', jabatan=?';    $types .= 's'; $vals[] = $jabatan; }
if (user_col_exists($conn, 'organisasi')) { $sql .= ', organisasi=?'; $types .= 's'; $vals[] = $organisasi; }
if (user_col_exists($conn, 'angkatan'))  { $sql .= ', angkatan=?';   $types .= 's'; $vals[] = $angkatan; }
if ($foto_path !== null)                  { $sql .= ', foto=?';       $types .= 's'; $vals[] = $foto_path; }

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
if ($foto_path !== null) {
    $_SESSION['foto'] = $foto_path;
}

header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=profil&success=Profil+berhasil+diperbarui!');
exit;