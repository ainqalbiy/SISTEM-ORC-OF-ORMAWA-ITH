<?php
// proccess/event_process.php — CRUD event organisasi
require_once '../config/connection.php';
require_login();

$jabatan = $_SESSION['jabatan'] ?? 'Anggota';
$uid     = (int)$_SESSION['user_id'];

// Hanya Pengurus dan Admin boleh mengelola event
if (!in_array($jabatan, ['Pengurus','Admin'])) {
    header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?error=' . urlencode('Akses ditolak. Hanya Pengurus yang dapat mengelola event.'));
    exit;
}

$action = $_POST['action'] ?? '';

// ── TAMBAH ─────────────────────────────────────────────────────────
if ($action === 'tambah') {
    $judul           = trim($_POST['judul'] ?? '');
    $organisasi_slug = trim($_POST['organisasi_slug'] ?? '');
    $nama_organisasi = trim($_POST['nama_organisasi'] ?? '');
    $tanggal         = trim($_POST['tanggal'] ?? '');
    $lokasi          = trim($_POST['lokasi'] ?? '');
    $deskripsi       = trim($_POST['deskripsi'] ?? '');

    if (!$judul || !$organisasi_slug || !$tanggal || !$lokasi) {
        header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=event&error=' . urlencode('Semua field wajib diisi.'));
        exit;
    }

    // Handle banner upload
    $banner_path = null;
    if (!empty($_FILES['banner']['name'])) {
        $ext  = strtolower(pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (!in_array($ext, $allowed)) {
            header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=event&error=' . urlencode('Format banner tidak didukung.'));
            exit;
        }
        $fname = 'event_' . time() . '_' . rand(100,999) . '.' . $ext;
        $dest  = __DIR__ . '/../uploads/event/' . $fname;
        if (!is_dir(dirname($dest))) mkdir(dirname($dest), 0755, true);
        if (move_uploaded_file($_FILES['banner']['tmp_name'], $dest)) {
            $banner_path = 'uploads/event/' . $fname;
        }
    }

    $stmt = $conn->prepare(
        "INSERT INTO event_organisasi (judul,organisasi_slug,nama_organisasi,tanggal,lokasi,deskripsi,banner,user_id)
         VALUES (?,?,?,?,?,?,?,?)"
    );
    $stmt->bind_param('sssssssi', $judul, $organisasi_slug, $nama_organisasi, $tanggal, $lokasi, $deskripsi, $banner_path, $uid);
    $ok = $stmt->execute();
    $stmt->close();

    $msg = $ok ? 'Event berhasil ditambahkan!' : 'Gagal menambahkan event.';
    $key = $ok ? 'success' : 'error';
    header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=event&' . $key . '=' . urlencode($msg));
    exit;
}

// ── EDIT ───────────────────────────────────────────────────────────
if ($action === 'edit') {
    $id              = (int)($_POST['id'] ?? 0);
    $judul           = trim($_POST['judul'] ?? '');
    $organisasi_slug = trim($_POST['organisasi_slug'] ?? '');
    $nama_organisasi = trim($_POST['nama_organisasi'] ?? '');
    $tanggal         = trim($_POST['tanggal'] ?? '');
    $lokasi          = trim($_POST['lokasi'] ?? '');
    $deskripsi       = trim($_POST['deskripsi'] ?? '');

    if (!$id || !$judul || !$tanggal || !$lokasi) {
        header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=event&error=' . urlencode('Data tidak valid.'));
        exit;
    }

    // Ambil banner lama
    $row = $conn->query("SELECT banner FROM event_organisasi WHERE id=$id LIMIT 1")->fetch_assoc();
    $banner_path = $row['banner'] ?? null;

    if (!empty($_FILES['banner']['name'])) {
        $ext  = strtolower(pathinfo($_FILES['banner']['name'], PATHINFO_EXTENSION));
        $allowed = ['jpg','jpeg','png','gif','webp'];
        if (in_array($ext, $allowed)) {
            $fname = 'event_' . time() . '_' . rand(100,999) . '.' . $ext;
            $dest  = __DIR__ . '/../uploads/event/' . $fname;
            if (!is_dir(dirname($dest))) mkdir(dirname($dest), 0755, true);
            if (move_uploaded_file($_FILES['banner']['tmp_name'], $dest)) {
                // Hapus banner lama
                if ($banner_path && file_exists(__DIR__ . '/../' . $banner_path)) {
                    @unlink(__DIR__ . '/../' . $banner_path);
                }
                $banner_path = 'uploads/event/' . $fname;
            }
        }
    }

    $stmt = $conn->prepare(
        "UPDATE event_organisasi SET judul=?,organisasi_slug=?,nama_organisasi=?,tanggal=?,lokasi=?,deskripsi=?,banner=? WHERE id=?"
    );
    $stmt->bind_param('sssssssi', $judul, $organisasi_slug, $nama_organisasi, $tanggal, $lokasi, $deskripsi, $banner_path, $id);
    $ok = $stmt->execute();
    $stmt->close();

    $msg = $ok ? 'Event berhasil diperbarui!' : 'Gagal memperbarui event.';
    $key = $ok ? 'success' : 'error';
    header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=event&' . $key . '=' . urlencode($msg));
    exit;
}

// ── HAPUS ──────────────────────────────────────────────────────────
if ($action === 'hapus') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id) {
        $row = $conn->query("SELECT banner FROM event_organisasi WHERE id=$id LIMIT 1")->fetch_assoc();
        if ($row && $row['banner'] && file_exists(__DIR__ . '/../' . $row['banner'])) {
            @unlink(__DIR__ . '/../' . $row['banner']);
        }
        $conn->query("DELETE FROM event_organisasi WHERE id=$id");
    }
    header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=event&success=' . urlencode('Event berhasil dihapus.'));
    exit;
}

header('Location: ' . BASE_URL . 'pages/dashboard/dashboard.php?tab=event');
exit;
