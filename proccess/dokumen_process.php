<?php
// proccess/dokumen_process.php — Upload & Delete Dokumen
require_once '../config/connection.php';
require_login();

$action = $_POST['action'] ?? '';

// ── UPLOAD ──────────────────────────────────────────────────
if ($action === 'upload' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul'] ?? '');
    $jenis = trim($_POST['jenis'] ?? '');
    $uid   = (int)$_SESSION['user_id'];

    if (!$judul || !$jenis) {
        redirect_back('dokumen', 'error', 'Judul dan jenis wajib diisi!');
    }

    // Validasi file upload
    if (empty($_FILES['file']['name'])) {
        redirect_back('dokumen', 'error', 'Harap pilih file untuk diunggah!');
    }

    $file        = $_FILES['file'];
    $allowed_ext = ['pdf','doc','docx','xls','xlsx','ppt','pptx','jpg','jpeg','png','zip'];
    $max_size    = 10 * 1024 * 1024; // 10 MB

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed_ext)) {
        redirect_back('dokumen', 'error', 'Tipe file tidak diizinkan! Gunakan: pdf, doc, xls, ppt, jpg, png, zip.');
    }
    if ($file['size'] > $max_size) {
        redirect_back('dokumen', 'error', 'Ukuran file melebihi 10MB!');
    }

    // Buat folder uploads jika belum ada
    $upload_dir = dirname(__DIR__) . '/uploads/dokumen/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }

    // Nama file unik
    $new_name  = 'dok_' . $uid . '_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $file_path = 'uploads/dokumen/' . $new_name;
    $dest      = dirname(__DIR__) . '/' . $file_path;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        redirect_back('dokumen', 'error', 'Gagal mengunggah file. Coba lagi!');
    }

    $stmt = $conn->prepare(
        "INSERT INTO dokumen (judul, jenis, file, user_id) VALUES (?,?,?,?)"
    );
    $stmt->bind_param('sssi', $judul, $jenis, $file_path, $uid);
    $ok = $stmt->execute();
    $stmt->close();

    if (!$ok) {
        // Hapus file jika insert gagal
        @unlink($dest);
        redirect_back('dokumen', 'error', 'Gagal menyimpan data dokumen.');
    }

    redirect_back('dokumen', 'success', 'Dokumen "' . $judul . '" berhasil diunggah!');
}

// ── HAPUS ───────────────────────────────────────────────────
if ($action === 'hapus' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $id  = (int)($_POST['id'] ?? 0);
    $uid = (int)$_SESSION['user_id'];

    // Ambil info dokumen dulu (untuk hapus file fisik)
    $stmt = $conn->prepare("SELECT file FROM dokumen WHERE id_dokumen = ? AND user_id = ?");
    $stmt->bind_param('ii', $id, $uid);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    $stmt->close();

    if (!$row) {
        redirect_back('dokumen', 'error', 'Dokumen tidak ditemukan atau bukan milikmu.');
    }

    // Hapus dari DB
    $stmt = $conn->prepare("DELETE FROM dokumen WHERE id_dokumen = ? AND user_id = ?");
    $stmt->bind_param('ii', $id, $uid);
    $ok = $stmt->execute();
    $stmt->close();

    // Hapus file fisik
    if ($ok && !empty($row['file'])) {
        $file_path = dirname(__DIR__) . '/' . $row['file'];
        if (file_exists($file_path)) @unlink($file_path);
    }

    redirect_back('dokumen', $ok ? 'success' : 'error', $ok ? 'Dokumen dihapus.' : 'Gagal hapus dokumen.');
}

redirect_back('dokumen', 'error', 'Aksi tidak dikenali.');

function redirect_back(string $module, string $type, string $msg): void {
    header('Location: ' . BASE_URL . "pages/dashboard/dashboard.php?tab={$module}&{$type}=" . urlencode($msg));
    exit;
}
