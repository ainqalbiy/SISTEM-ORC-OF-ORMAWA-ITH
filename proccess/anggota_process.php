<?php
// proccess/anggota_process.php — CRUD Anggota
require_once '../config/connection.php';
require_login();

$action = $_POST['action'] ?? '';

// Helper: cek kolom di tabel tertentu (bukan users)
function anggota_col_exists(mysqli $conn, string $table, string $col): bool {
    static $cache = [];
    $key = "$table.$col";
    if (isset($cache[$key])) return $cache[$key];
    $t = $conn->real_escape_string($table);
    $c = $conn->real_escape_string($col);
    $r = $conn->query("SELECT COUNT(*) AS n FROM information_schema.COLUMNS
                       WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='$t' AND COLUMN_NAME='$c'");
    return $cache[$key] = ($r && $r->fetch_assoc()['n'] > 0);
}

function redirect_back(string $module, string $type, string $msg): void {
    header('Location: ' . BASE_URL . "pages/dashboard/dashboard.php?tab={$module}&{$type}=" . urlencode($msg));
    exit;
}

// ── TAMBAH ──────────────────────────────────────────────────
if ($action === 'tambah' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama       = trim($_POST['nama']           ?? '');
    $alamat     = trim($_POST['alamat']         ?? '');
    $no_hp      = trim($_POST['no_hp']          ?? '');
    $tgl        = trim($_POST['tanggal_daftar'] ?? date('Y-m-d'));
    $organisasi = trim($_POST['organisasi']     ?? $_SESSION['organisasi'] ?? 'Umum');
    $jabatan    = trim($_POST['jabatan']        ?? 'Anggota');
    $user_id    = (int)$_SESSION['user_id'];

    if (!$nama || !$alamat || !$no_hp) {
        redirect_back('anggota', 'error', 'Field wajib tidak boleh kosong!');
    }

    $has_org = anggota_col_exists($conn, 'anggota', 'organisasi');
    $has_jab = anggota_col_exists($conn, 'anggota', 'jabatan');

    if ($has_org && $has_jab) {
        $stmt = $conn->prepare(
            "INSERT INTO anggota (user_id, organisasi, jabatan, nama, alamat, no_hp, tanggal_daftar)
             VALUES (?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('issssss', $user_id, $organisasi, $jabatan, $nama, $alamat, $no_hp, $tgl);
    } elseif ($has_org) {
        $stmt = $conn->prepare(
            "INSERT INTO anggota (user_id, organisasi, nama, alamat, no_hp, tanggal_daftar)
             VALUES (?,?,?,?,?,?)"
        );
        $stmt->bind_param('isssss', $user_id, $organisasi, $nama, $alamat, $no_hp, $tgl);
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO anggota (user_id, nama, alamat, no_hp, tanggal_daftar) VALUES (?,?,?,?,?)"
        );
        $stmt->bind_param('issss', $user_id, $nama, $alamat, $no_hp, $tgl);
    }

    $ok = $stmt->execute();
    $stmt->close();

    redirect_back('anggota', $ok ? 'success' : 'error', $ok ? 'Anggota berhasil ditambahkan!' : 'Gagal menambahkan anggota: ' . $conn->error);
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
