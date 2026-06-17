<?php
// proccess/organisasi_process.php — Admin: tambah, aktifkan, nonaktifkan organisasi
require_once '../config/connection.php';
require_login();

$jabatan = $_SESSION['jabatan'] ?? 'Anggota';

if ($jabatan !== 'Admin') {
    header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?error=' . urlencode('Akses ditolak.'));
    exit;
}

$action = $_POST['action'] ?? '';

// ── TAMBAH ─────────────────────────────────────────────────────────
if ($action === 'tambah') {
    $nama      = trim($_POST['nama'] ?? '');
    $deskripsi = trim($_POST['deskripsi'] ?? '');
    $slug      = strtolower(preg_replace('/[^a-z0-9]+/', '-', trim($_POST['slug'] ?? '')));
    $kategori  = trim($_POST['kategori'] ?? 'ukm');

    if (!$nama || !$slug) {
        header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=org_admin&error=' . urlencode('Nama dan slug wajib diisi.'));
        exit;
    }

    // Handle logo upload
    $logo_path = null;
    if (!empty($_FILES['logo']['name'])) {
        $ext     = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (in_array($ext, $allowed)) {
            $fname = 'org_' . $slug . '_' . time() . '.' . $ext;
            $dest  = __DIR__ . '/../assets/img/logo/' . $fname;
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $dest)) {
                $logo_path = 'assets/img/logo/' . $fname;
            }
        }
    }

    $stmt = $conn->prepare(
        "INSERT INTO organisasi (nama,deskripsi,logo,slug,kategori,status) VALUES (?,?,?,?,?,'aktif')"
    );
    $stmt->bind_param('sssss', $nama, $deskripsi, $logo_path, $slug, $kategori);
    $ok = $stmt->execute();
    $stmt->close();

    $msg = $ok ? 'Organisasi berhasil ditambahkan!' : 'Gagal: slug mungkin sudah ada.';
    $key = $ok ? 'success' : 'error';
    header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=org_admin&' . $key . '=' . urlencode($msg));
    exit;
}

// ── TOGGLE STATUS ──────────────────────────────────────────────────
if ($action === 'toggle_status') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id) {
        $conn->query("UPDATE organisasi SET status = IF(status='aktif','nonaktif','aktif') WHERE id=$id");
    }
    header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=org_admin&success=' . urlencode('Status organisasi diperbarui.'));
    exit;
}

header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=org_admin');
exit;
