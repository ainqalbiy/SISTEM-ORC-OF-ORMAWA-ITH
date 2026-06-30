<?php
/**
 * partials/tab_org_admin.php
 * Pengganti konten tab org_admin (Manajemen Organisasi) yang lebih kaya tampilan.
 * Logika tetap sama: data dari $org_list_admin, form action ke organisasi_process.php.
 * Menambahkan: toggle tampilan tabel/kartu, info kategori & status visual lebih baik.
 */
?>
<div class="section-header">
    <h2><i class="bi bi-building" style="color:var(--orange)"></i> Manajemen Organisasi</h2>
    <div style="display:flex;align-items:center;gap:10px">
        <!-- Toggle view -->
        <div class="view-toggle">
            <button class="view-toggle-btn active" id="btnViewCard" onclick="setOrgView('card')" title="Tampilan Kartu">
                <i class="bi bi-grid-3x3-gap"></i>
            </button>
            <button class="view-toggle-btn" id="btnViewTable" onclick="setOrgView('table')" title="Tampilan Tabel">
                <i class="bi bi-list-ul"></i>
            </button>
        </div>
        <button class="btn-primary" onclick="document.getElementById('modalOrgTambah').classList.add('open')">
            <i class="bi bi-plus-lg"></i> Tambah Organisasi
        </button>
    </div>
</div>

<?php if (empty($org_list_admin)): ?>
<div class="panel">
    <div class="empty-big">
        <div class="e-icon-big"><i class="bi bi-building"></i></div>
        <div class="e-title">Belum ada data organisasi di database</div>
        <div class="e-sub">Jalankan migration v3 terlebih dahulu, lalu tambahkan organisasi pertama.</div>
        <button class="btn-primary" onclick="document.getElementById('modalOrgTambah').classList.add('open')">
            <i class="bi bi-plus-lg"></i> Tambah Organisasi
        </button>
    </div>
</div>
<?php else: ?>

<!-- Stat strip ringkas -->
<?php
$total_org_tab  = count($org_list_admin);
$aktif_org_tab  = count(array_filter($org_list_admin, fn($o) => ($o['status'] ?? 'aktif') === 'aktif'));
$nonaktif_org   = $total_org_tab - $aktif_org_tab;
?>
<div class="admin-stat-strip" style="margin-bottom:4px">
    <div class="admin-stat-item">
        <div class="admin-stat-icon orange"><i class="bi bi-building-check"></i></div>
        <div><div class="admin-stat-num"><?= $total_org_tab ?></div><div class="admin-stat-lbl">Total Organisasi</div></div>
    </div>
    <div class="admin-stat-item">
        <div class="admin-stat-icon green"><i class="bi bi-check-circle"></i></div>
        <div><div class="admin-stat-num"><?= $aktif_org_tab ?></div><div class="admin-stat-lbl">Aktif</div></div>
    </div>
    <div class="admin-stat-item">
        <div class="admin-stat-icon" style="background:#fff0ee;color:#c0392b"><i class="bi bi-pause-circle"></i></div>
        <div><div class="admin-stat-num"><?= $nonaktif_org ?></div><div class="admin-stat-lbl">Nonaktif</div></div>
    </div>
</div>

<!-- VIEW: KARTU -->
<div id="orgViewCard">
    <div class="org-card-grid">
        <?php foreach ($org_list_admin as $i => $org): ?>
        <div class="org-card <?= ($org['status'] ?? 'aktif') !== 'aktif' ? 'nonaktif' : '' ?>">
            <!-- Status badge pojok kanan atas -->
            <div class="org-card-status">
                <span class="badge-<?= e($org['status'] ?? 'aktif') ?>"><?= ucfirst(e($org['status'] ?? 'aktif')) ?></span>
            </div>

            <!-- Header: logo + nama -->
            <div class="org-card-header">
                <?php if (!empty($org['logo'])): ?>
                <img src="<?= BASE_URL . e($org['logo']) ?>" alt="logo" class="org-card-logo">
                <?php else: ?>
                <div class="org-card-logo-ph"><i class="bi bi-building"></i></div>
                <?php endif; ?>
                <div>
                    <div class="org-card-name"><?= e($org['nama']) ?></div>
                    <div class="org-card-slug"><code><?= e($org['slug']) ?></code></div>
                </div>
            </div>

            <!-- Kategori -->
            <?php if (!empty($org['kategori'])): ?>
            <div class="org-card-kategori"><i class="bi bi-tag"></i> <?= e($org['kategori']) ?></div>
            <?php endif; ?>

            <!-- Deskripsi singkat jika ada -->
            <?php if (!empty($org['deskripsi'])): ?>
            <div style="font-size:.75rem;color:var(--text-muted);line-height:1.5;max-height:44px;overflow:hidden">
                <?= e(mb_substr($org['deskripsi'], 0, 100)) ?><?= mb_strlen($org['deskripsi']) > 100 ? '...' : '' ?>
            </div>
            <?php endif; ?>

            <!-- Aksi -->
            <div class="org-card-actions">
                <form method="POST" action="<?= BASE_URL ?>proccess/organisasi_process.php" style="flex:1">
                    <input type="hidden" name="action" value="toggle_status">
                    <input type="hidden" name="id" value="<?= $org['id'] ?>">
                    <?php if (($org['status'] ?? 'aktif') === 'aktif'): ?>
                    <button type="submit" class="btn-danger" style="width:100%;justify-content:center"
                        onclick="return confirm('Nonaktifkan organisasi <?= e($org['nama']) ?>?')">
                        <i class="bi bi-pause-circle"></i> Nonaktifkan
                    </button>
                    <?php else: ?>
                    <button type="submit" class="btn-success" style="width:100%;justify-content:center"
                        onclick="return confirm('Aktifkan kembali <?= e($org['nama']) ?>?')">
                        <i class="bi bi-play-circle"></i> Aktifkan
                    </button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- VIEW: TABEL (hidden by default) -->
<div id="orgViewTable" style="display:none">
    <div class="panel" style="padding:0">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>#</th><th>Logo</th><th>Nama</th><th>Slug</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                <?php foreach ($org_list_admin as $i => $org): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td>
                        <?php if (!empty($org['logo'])): ?>
                        <img src="<?= BASE_URL . e($org['logo']) ?>" alt="logo"
                             style="width:40px;height:40px;object-fit:contain;border-radius:8px;background:var(--cream)">
                        <?php else: ?>
                        <div style="width:40px;height:40px;border-radius:8px;background:var(--cream);display:flex;align-items:center;justify-content:center;color:var(--text-muted)">
                            <i class="bi bi-building"></i>
                        </div>
                        <?php endif; ?>
                    </td>
                    <td style="font-weight:600"><?= e($org['nama']) ?></td>
                    <td><code><?= e($org['slug']) ?></code></td>
                    <td><?= e($org['kategori'] ?? '-') ?></td>
                    <td>
                        <span class="badge-<?= e($org['status'] ?? 'aktif') ?>"><?= ucfirst(e($org['status'] ?? 'aktif')) ?></span>
                    </td>
                    <td>
                        <form method="POST" action="<?= BASE_URL ?>proccess/organisasi_process.php" style="display:inline">
                            <input type="hidden" name="action" value="toggle_status">
                            <input type="hidden" name="id" value="<?= $org['id'] ?>">
                            <?php if (($org['status'] ?? 'aktif') === 'aktif'): ?>
                            <button type="submit" class="btn-danger"
                                onclick="return confirm('Nonaktifkan organisasi ini?')">
                                <i class="bi bi-pause-circle"></i> Nonaktifkan
                            </button>
                            <?php else: ?>
                            <button type="submit" class="btn-success"
                                onclick="return confirm('Aktifkan kembali organisasi ini?')">
                                <i class="bi bi-play-circle"></i> Aktifkan
                            </button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php endif; ?>

<script>
function setOrgView(view) {
    const card  = document.getElementById('orgViewCard');
    const table = document.getElementById('orgViewTable');
    const btnC  = document.getElementById('btnViewCard');
    const btnT  = document.getElementById('btnViewTable');
    if (!card || !table) return;
    if (view === 'card') {
        card.style.display  = '';
        table.style.display = 'none';
        btnC.classList.add('active');
        btnT.classList.remove('active');
        localStorage.setItem('orc_org_view', 'card');
    } else {
        card.style.display  = 'none';
        table.style.display = '';
        btnC.classList.remove('active');
        btnT.classList.add('active');
        localStorage.setItem('orc_org_view', 'table');
    }
}
// Restore preference
(function() {
    const pref = localStorage.getItem('orc_org_view');
    if (pref === 'table') setOrgView('table');
})();
</script>
