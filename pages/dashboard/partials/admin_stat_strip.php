<?php
/**
 * partials/admin_stat_strip.php
 * Tambahan stat strip untuk Admin & Super Admin di tab Dashboard.
 * Di-include SETELAH stats-grid yang sudah ada.
 * Tidak mengubah logika apapun — hanya menambah tampilan informatif.
 */
if (!$is_admin) return; // hanya tampil untuk Admin ke atas

// Hitung stat tambahan
$total_org    = count($org_list_admin);
$org_aktif    = count(array_filter($org_list_admin, fn($o) => ($o['status'] ?? 'aktif') === 'aktif'));
$total_akun   = $is_super_admin ? count($all_users_list) : null;
$akun_aktif   = $is_super_admin ? count(array_filter($all_users_list, fn($u) => $u['status'] === 'Aktif')) : null;
?>

<div class="panel" style="margin-top:0">
    <div class="panel-header" style="margin-bottom:14px">
        <div class="panel-icon"><i class="bi bi-speedometer2"></i></div>
        <span class="panel-title">Ringkasan Sistem</span>
        <span style="font-size:.7rem;color:var(--text-muted);margin-left:auto;font-weight:600">
            <?= $is_super_admin ? 'Super Admin View' : 'Admin View' ?>
        </span>
    </div>
    <div class="admin-stat-strip">
        <!-- Organisasi -->
        <div class="admin-stat-item" onclick="location='?tab=org_admin'" style="cursor:pointer" title="Lihat Manajemen Organisasi">
            <div class="admin-stat-icon orange"><i class="bi bi-building"></i></div>
            <div class="admin-stat-text">
                <div class="admin-stat-num"><?= $total_org ?></div>
                <div class="admin-stat-lbl">Organisasi Terdaftar</div>
            </div>
        </div>
        <!-- Aktif -->
        <div class="admin-stat-item" title="Organisasi berstatus aktif">
            <div class="admin-stat-icon green"><i class="bi bi-check-circle"></i></div>
            <div class="admin-stat-text">
                <div class="admin-stat-num"><?= $org_aktif ?></div>
                <div class="admin-stat-lbl">Org. Aktif</div>
            </div>
        </div>
        <?php if ($is_super_admin): ?>
        <!-- Total Akun -->
        <div class="admin-stat-item" onclick="location='?tab=superadmin'" style="cursor:pointer" title="Lihat Manajemen Akun">
            <div class="admin-stat-icon blue"><i class="bi bi-people"></i></div>
            <div class="admin-stat-text">
                <div class="admin-stat-num"><?= $total_akun ?></div>
                <div class="admin-stat-lbl">Total Akun</div>
            </div>
        </div>
        <!-- Akun Aktif -->
        <div class="admin-stat-item" title="Akun berstatus aktif">
            <div class="admin-stat-icon purple"><i class="bi bi-person-check"></i></div>
            <div class="admin-stat-text">
                <div class="admin-stat-num"><?= $akun_aktif ?></div>
                <div class="admin-stat-lbl">Akun Aktif</div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php if ($is_super_admin && !empty($all_users_list)): ?>
<!-- Distribusi role — mini bar chart inline di dashboard -->
<?php
$roles = ['Super Admin', 'Admin', 'Pengurus', 'Anggota'];
$role_counts = [];
foreach ($roles as $r) {
    $role_counts[$r] = count(array_filter($all_users_list, fn($u) => $u['jabatan'] === $r));
}
$max_count = max($role_counts) ?: 1;
$role_colors_css = [
    'Super Admin' => '#4a148c',
    'Admin'       => '#1565c0',
    'Pengurus'    => '#e65100',
    'Anggota'     => '#2e7d32',
];
?>
<div class="panel">
    <div class="panel-header" style="margin-bottom:14px">
        <div class="panel-icon"><i class="bi bi-bar-chart-line"></i></div>
        <span class="panel-title">Distribusi Peran Akun</span>
        <a href="?tab=superadmin" class="btn-sm-outline" style="margin-left:auto;font-size:.72rem">Kelola Akun <i class="bi bi-arrow-right"></i></a>
    </div>
    <div style="display:flex;flex-direction:column;gap:10px">
        <?php foreach ($role_counts as $role => $count): ?>
        <div class="sa-bar-row">
            <span class="sa-bar-label"><?= e($role) ?></span>
            <div class="sa-bar-track">
                <div class="sa-bar-fill" style="width:<?= $max_count > 0 ? round($count/$max_count*100) : 0 ?>%;background:<?= $role_colors_css[$role] ?? 'var(--orange)' ?>"></div>
            </div>
            <span class="sa-bar-count"><?= $count ?></span>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>
