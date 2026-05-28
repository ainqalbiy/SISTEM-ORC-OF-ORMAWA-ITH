<?php
/**
 * includes/org_query.php
 * Helper: query kegiatan & anggota per organisasi dari DB.
 * $org_key harus di-set sebelum include file ini.
 * Contoh: $org_key = 'HERO';
 */
if (!isset($org_key)) $org_key = 'Umum';

// Cek kolom organisasi
function tbl_col_exists(mysqli $conn, string $table, string $col): bool {
    static $cache = [];
    $k = "$table.$col";
    if (isset($cache[$k])) return $cache[$k];
    $t = $conn->real_escape_string($table);
    $c = $conn->real_escape_string($col);
    $r = $conn->query("SELECT COUNT(*) AS n FROM information_schema.COLUMNS
                       WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='$t' AND COLUMN_NAME='$c'");
    return $cache[$k] = ($r && $r->fetch_assoc()['n'] > 0);
}

// ── Kegiatan ─────────────────────────────────────────────
$kegiatan_db = [];
$like = "%{$org_key}%";
if (tbl_col_exists($conn, 'kegiatan', 'organisasi')) {
    $st = $conn->prepare("SELECT * FROM kegiatan WHERE organisasi LIKE ? ORDER BY tanggal DESC LIMIT 6");
    $st->bind_param('s', $like);
    $st->execute();
    $kegiatan_db = $st->get_result()->fetch_all(MYSQLI_ASSOC);
    $st->close();
} else {
    $r = $conn->query("SELECT * FROM kegiatan ORDER BY tanggal DESC LIMIT 6");
    if ($r) $kegiatan_db = $r->fetch_all(MYSQLI_ASSOC);
}

// ── Anggota ──────────────────────────────────────────────
$anggota_db = [];
// Deteksi PK users
$pk_res = $conn->query("SELECT COLUMN_NAME FROM information_schema.KEY_COLUMN_USAGE
    WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='users' AND CONSTRAINT_NAME='PRIMARY' LIMIT 1");
$pk = $pk_res ? ($pk_res->fetch_assoc()['COLUMN_NAME'] ?? 'id') : 'id';

if (tbl_col_exists($conn, 'anggota', 'organisasi')) {
    $st = $conn->prepare(
        "SELECT a.*, u.nama AS nama_user, u.jabatan AS jabatan_user, u.angkatan
         FROM anggota a
         LEFT JOIN users u ON a.user_id = u.`$pk`
         WHERE a.organisasi LIKE ?
         ORDER BY a.tanggal_daftar DESC LIMIT 8"
    );
    $st->bind_param('s', $like);
    $st->execute();
    $anggota_db = $st->get_result()->fetch_all(MYSQLI_ASSOC);
    $st->close();
} else {
    $st = $conn->prepare(
        "SELECT `$pk` AS id, nama, jabatan, organisasi, angkatan FROM users
         WHERE organisasi LIKE ? AND status='Aktif' ORDER BY nama LIMIT 8"
    );
    $st->bind_param('s', $like);
    $st->execute();
    $anggota_db = $st->get_result()->fetch_all(MYSQLI_ASSOC);
    $st->close();
}
