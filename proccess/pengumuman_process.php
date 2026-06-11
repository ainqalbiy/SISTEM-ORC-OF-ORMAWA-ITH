<?php
// proccess/pengumuman_process.php — CRUD Pengumuman
require_once '../config/connection.php';
require_login();

$action = $_POST['action'] ?? '';

function redirect_back(string $module, string $type, string $msg): void {
    header('Location: ' . BASE_URL . "pages/dashboard/dashboard.php?tab={$module}&{$type}=" . urlencode($msg));
    exit;
}

// ── TAMBAH ──────────────────────────────────────────────────
if ($action === 'tambah' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul  = trim($_POST['judul']       ?? '');
    $konten = trim($_POST['konten']      ?? '');
    $target = trim($_POST['target_role'] ?? 'semua');
    $uid    = (int)$_SESSION['user_id'];

    $allowed_target = ['semua', 'anggota', 'pengurus', 'pembina'];
    if (!in_array($target, $allowed_target)) $target = 'semua';

    if (!$judul || !$konten) {
        redirect_back('pengumuman', 'error', 'Judul dan konten wajib diisi!');
    }

    $stmt = $conn->prepare(
        "INSERT INTO pengumuman (user_id, judul, konten, target_role) VALUES (?,?,?,?)"
    );
    $stmt->bind_param('isss', $uid, $judul, $konten, $target);
    $ok = $stmt->execute();
    $stmt->close();

    redirect_back('pengumuman', $ok ? 'success' : 'error', $ok ? 'Pengumuman berhasil dibuat!' : 'Gagal membuat pengumuman.');
}

// ── EDIT ────────────────────────────────────────────────────
if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = (int)($_POST['id']          ?? 0);
    $judul  = trim($_POST['judul']        ?? '');
    $konten = trim($_POST['konten']       ?? '');
    $target = trim($_POST['target_role']  ?? 'semua');
    $uid    = (int)$_SESSION['user_id'];

    $allowed_target = ['semua', 'anggota', 'pengurus', 'pembina'];
    if (!in_array($target, $allowed_target)) $target = 'semua';

    if (!$id || !$judul || !$konten) {
        redirect_back('pengumuman', 'error', 'Judul dan konten wajib diisi!');
    }

    // Hanya bisa edit pengumuman milik sendiri
    $stmt = $conn->prepare(
        "UPDATE pengumuman SET judul=?, konten=?, target_role=? WHERE pengumuman_id=? AND user_id=?"
    );
    $stmt->bind_param('sssii', $judul, $konten, $target, $id, $uid);
    $ok = $stmt->execute();
    $affected = $stmt->affected_rows;
    $stmt->close();

    if ($ok && $affected > 0) {
        redirect_back('pengumuman', 'success', 'Pengumuman berhasil diperbarui!');
    } else {
        redirect_back('pengumuman', 'error', 'Gagal memperbarui atau bukan milikmu.');
    }
}

// ── HAPUS ───────────────────────────────────────────────────
if ($action === 'hapus' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id  = (int)($_POST['id'] ?? 0);
    $uid = (int)$_SESSION['user_id'];
    // Hanya bisa hapus pengumuman milik sendiri
    $stmt = $conn->prepare("DELETE FROM pengumuman WHERE pengumuman_id = ? AND user_id = ?");
    $stmt->bind_param('ii', $id, $uid);
    $ok = $stmt->execute();
    $stmt->close();
    redirect_back('pengumuman', $ok ? 'success' : 'error', $ok ? 'Pengumuman dihapus.' : 'Gagal hapus atau bukan milikmu.');
}

redirect_back('pengumuman', 'error', 'Aksi tidak dikenali.');
