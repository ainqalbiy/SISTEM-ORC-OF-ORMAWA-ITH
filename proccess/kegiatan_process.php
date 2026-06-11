<?php
// proccess/kegiatan_process.php — CRUD Kegiatan
require_once '../config/connection.php';
require_login();

$action = $_POST['action'] ?? $_GET['action'] ?? '';

function redirect_back(string $module, string $type, string $msg): void {
    header('Location: ' . BASE_URL . "pages/dashboard/dashboard.php?tab={$module}&{$type}=" . urlencode($msg));
    exit;
}

// Helper cek kolom kegiatan
function keg_col_exists(mysqli $conn, string $col): bool {
    $col = $conn->real_escape_string($col);
    $r   = $conn->query("SELECT COUNT(*) AS n FROM information_schema.COLUMNS
                         WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='kegiatan' AND COLUMN_NAME='$col'");
    return $r && $r->fetch_assoc()['n'] > 0;
}

// ── TAMBAH ──────────────────────────────────────────────────
if ($action === 'tambah' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama       = trim($_POST['nama_kegiatan']    ?? '');
    $jenis      = trim($_POST['jenis_kegiatan']   ?? '');
    $tgl        = trim($_POST['tanggal']          ?? '');
    $waktu      = trim($_POST['waktu']            ?? '00:00');
    $tempat     = trim($_POST['tempat']           ?? '');
    $pj         = trim($_POST['penanggung_jawab'] ?? $_SESSION['nama'] ?? '');
    $desk       = trim($_POST['deskripsi']        ?? '');
    $organisasi = trim($_POST['organisasi']       ?? $_SESSION['organisasi'] ?? 'Umum');
    $status     = 'Terjadwal';

    if (!$nama || !$jenis || !$tgl || !$tempat) {
        redirect_back('kegiatan', 'error', 'Field wajib tidak boleh kosong!');
    }

    $has_org = keg_col_exists($conn, 'organisasi');

    if ($has_org) {
        $stmt = $conn->prepare(
            "INSERT INTO kegiatan (nama_kegiatan,organisasi,jenis_kegiatan,tanggal,waktu,tempat,penanggung_jawab,deskripsi,status)
             VALUES (?,?,?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('sssssssss', $nama, $organisasi, $jenis, $tgl, $waktu, $tempat, $pj, $desk, $status);
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO kegiatan (nama_kegiatan,jenis_kegiatan,tanggal,waktu,tempat,penanggung_jawab,deskripsi,status)
             VALUES (?,?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('ssssssss', $nama, $jenis, $tgl, $waktu, $tempat, $pj, $desk, $status);
    }

    $ok = $stmt->execute();
    $stmt->close();

    redirect_back('kegiatan', $ok ? 'success' : 'error', $ok ? 'Kegiatan berhasil ditambahkan!' : 'Gagal menambahkan kegiatan: ' . $conn->error);
}

// ── EDIT ────────────────────────────────────────────────────
if ($action === 'edit' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = (int)($_POST['id']               ?? 0);
    $nama       = trim($_POST['nama_kegiatan']     ?? '');
    $jenis      = trim($_POST['jenis_kegiatan']    ?? '');
    $tgl        = trim($_POST['tanggal']           ?? '');
    $waktu      = trim($_POST['waktu']             ?? '00:00');
    $tempat     = trim($_POST['tempat']            ?? '');
    $pj         = trim($_POST['penanggung_jawab']  ?? '');
    $desk       = trim($_POST['deskripsi']         ?? '');
    $organisasi = trim($_POST['organisasi']        ?? 'Umum');
    $status     = trim($_POST['status']            ?? 'Terjadwal');

    if (!$id || !$nama || !$jenis || !$tgl || !$tempat) {
        redirect_back('kegiatan', 'error', 'Field wajib tidak boleh kosong!');
    }

    $allowed_status = ['Terjadwal', 'Berlangsung', 'Selesai', 'Dibatalkan'];
    if (!in_array($status, $allowed_status)) $status = 'Terjadwal';

    $has_org = keg_col_exists($conn, 'organisasi');

    if ($has_org) {
        $stmt = $conn->prepare(
            "UPDATE kegiatan SET nama_kegiatan=?,organisasi=?,jenis_kegiatan=?,tanggal=?,
             waktu=?,tempat=?,penanggung_jawab=?,deskripsi=?,status=? WHERE id_kegiatan=?"
        );
        $stmt->bind_param('sssssssssi', $nama, $organisasi, $jenis, $tgl, $waktu, $tempat, $pj, $desk, $status, $id);
    } else {
        $stmt = $conn->prepare(
            "UPDATE kegiatan SET nama_kegiatan=?,jenis_kegiatan=?,tanggal=?,
             waktu=?,tempat=?,penanggung_jawab=?,deskripsi=?,status=? WHERE id_kegiatan=?"
        );
        $stmt->bind_param('ssssssssi', $nama, $jenis, $tgl, $waktu, $tempat, $pj, $desk, $status, $id);
    }

    $ok = $stmt->execute();
    $stmt->close();

    redirect_back('kegiatan', $ok ? 'success' : 'error', $ok ? 'Kegiatan berhasil diperbarui!' : 'Gagal memperbarui kegiatan.');
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
    $allowed = ['Terjadwal', 'Berlangsung', 'Selesai', 'Dibatalkan'];
    if (!in_array($status, $allowed)) redirect_back('kegiatan', 'error', 'Status tidak valid.');
    $stmt = $conn->prepare("UPDATE kegiatan SET status=? WHERE id_kegiatan=?");
    $stmt->bind_param('si', $status, $id);
    $ok = $stmt->execute();
    $stmt->close();
    redirect_back('kegiatan', $ok ? 'success' : 'error', $ok ? 'Status diperbarui.' : 'Gagal update.');
}

redirect_back('kegiatan', 'error', 'Aksi tidak dikenali.');
