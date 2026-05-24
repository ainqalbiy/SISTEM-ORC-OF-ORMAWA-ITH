<?php
// proccess/kegiatan_process.php — CRUD Kegiatan
require_once '../config/connection.php';
require_login();

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// ── TAMBAH ──────────────────────────────────────────────────
if ($action === 'tambah' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama_kegiatan']  ?? '');
    $jenis  = trim($_POST['jenis_kegiatan'] ?? '');
    $tgl    = trim($_POST['tanggal']        ?? '');
    $waktu  = trim($_POST['waktu']          ?? '00:00');
    $tempat = trim($_POST['tempat']         ?? '');
    $pj     = trim($_POST['penanggung_jawab'] ?? $_SESSION['nama']);
    $desk   = trim($_POST['deskripsi']      ?? '');
    $status = 'Terjadwal';

    if (!$nama || !$jenis || !$tgl || !$tempat) {
        redirect_back('kegiatan', 'error', 'Field wajib tidak boleh kosong!');
    }

    $stmt = $conn->prepare(
        "INSERT INTO kegiatan (nama_kegiatan,jenis_kegiatan,tanggal,waktu,tempat,penanggung_jawab,deskripsi,status)
         VALUES (?,?,?,?,?,?,?,?)"
    );
    $stmt->bind_param('ssssssss', $nama, $jenis, $tgl, $waktu, $tempat, $pj, $desk, $status);
    $ok = $stmt->execute();
    $stmt->close();

    redirect_back('kegiatan', $ok ? 'success' : 'error', $ok ? 'Kegiatan berhasil ditambahkan!' : 'Gagal menambahkan kegiatan.');
}

// ── HAPUS ───────────────────────────────────────────────────
if ($action === 'hapus' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    $stmt = $conn->prepare("DELETE FROM kegiatan WHERE id_kegiatan = ?");
    $stmt->bind_param('i', $id);
    $ok = $stmt->execute();
    $stmt->close();
    redirect_back('kegiatan', $ok ? 'success' : 'error', $ok ? 'Kegiatan dihapus.' : 'Gagal hapus.');
}

// ── UPDATE STATUS ────────────────────────────────────────────
if ($action === 'update_status' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = (int)($_POST['id'] ?? 0);
    $status = trim($_POST['status'] ?? '');
    $allowed = ['Terjadwal','Berlangsung','Selesai','Dibatalkan'];
    if (!in_array($status, $allowed)) redirect_back('kegiatan', 'error', 'Status tidak valid.');
    $stmt = $conn->prepare("UPDATE kegiatan SET status=? WHERE id_kegiatan=?");
    $stmt->bind_param('si', $status, $id);
    $ok = $stmt->execute();
    $stmt->close();
    redirect_back('kegiatan', $ok ? 'success' : 'error', $ok ? 'Status diperbarui.' : 'Gagal update.');
}

redirect_back('kegiatan', 'error', 'Aksi tidak dikenali.');

function redirect_back(string $module, string $type, string $msg): void {
    $url = defined('BASE_URL')
        ? BASE_URL . "pages/dashboard/dashboard.php?tab={$module}&{$type}=" . urlencode($msg)
        : "../pages/dashboard/dashboard.php?tab={$module}&{$type}=" . urlencode($msg);
    header('Location: ' . $url);
    exit;
}
