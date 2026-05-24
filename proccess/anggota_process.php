<?php
// proccess/anggota_process.php — CRUD Anggota
require_once '../config/connection.php';
require_login();

$action = $_POST['action'] ?? '';

// ── TAMBAH ──────────────────────────────────────────────────
if ($action === 'tambah' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama    = trim($_POST['nama']    ?? '');
    $alamat  = trim($_POST['alamat']  ?? '');
    $no_hp   = trim($_POST['no_hp']   ?? '');
    $tgl     = trim($_POST['tanggal_daftar'] ?? date('Y-m-d'));
    $user_id = (int)$_SESSION['user_id'];

    if (!$nama || !$alamat || !$no_hp) {
        redirect_back('anggota', 'error', 'Field wajib tidak boleh kosong!');
    }

    $stmt = $conn->prepare(
        "INSERT INTO anggota (user_id, nama, alamat, no_hp, tanggal_daftar) VALUES (?,?,?,?,?)"
    );
    $stmt->bind_param('issss', $user_id, $nama, $alamat, $no_hp, $tgl);
    $ok = $stmt->execute();
    $stmt->close();

    redirect_back('anggota', $ok ? 'success' : 'error', $ok ? 'Anggota berhasil ditambahkan!' : 'Gagal menambahkan anggota.');
}

// ── HAPUS ───────────────────────────────────────────────────
if ($action === 'hapus' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $stmt = $conn->prepare("DELETE FROM anggota WHERE id_anggota = ?");
    $stmt->bind_param('i', $id);
    $ok = $stmt->execute();
    $stmt->close();
    redirect_back('anggota', $ok ? 'success' : 'error', $ok ? 'Anggota dihapus.' : 'Gagal hapus.');
}

redirect_back('anggota', 'error', 'Aksi tidak dikenali.');

function redirect_back(string $module, string $type, string $msg): void {
    header('Location: ' . BASE_URL . "pages/dashboard/dashboard.php?tab={$module}&{$type}=" . urlencode($msg));
    exit;
}
