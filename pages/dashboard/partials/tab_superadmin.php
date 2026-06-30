<?php
/**
 * partials/tab_superadmin.php
 * Tampilan yang lebih kaya untuk tab Manajemen Akun (Super Admin).
 * Semua logika (filter, modal buat/edit/reset, toggle status) TETAP SAMA.
 * Hanya menambahkan: donut chart distribusi role, bar chart per-org,
 * activity/summary section di atas tabel.
 */

// Flash messages (sama seperti aslinya)
$sa_ok  = urldecode($_GET['success'] ?? '');
$sa_err = urldecode($_GET['error']   ?? '');
if ($sa_ok && $tab === 'superadmin'): ?>
<div class="alert-ok"><i class="bi bi-check-circle-fill"></i> <?= e($sa_ok) ?></div>
<?php endif;
if ($sa_err && $tab === 'superadmin'): ?>
<div class="alert-err"><i class="bi bi-exclamation-triangle-fill"></i> <?= e($sa_err) ?></div>
<?php endif; ?>

<div class="section-header">
    <h2><i class="bi bi-shield-lock" style="color:var(--orange)"></i> Manajemen Akun</h2>
    <button class="btn-primary" onclick="document.getElementById('modalBuatAkun').classList.add('open')">
        <i class="bi bi-person-plus"></i> Buat Akun Baru
    </button>
</div>

<!-- Section: Buat Akun Baru (inline, tampil untuk Super Admin & Admin ORC) -->
<div class="panel" style="margin-bottom:18px">
    <div class="sa-bar-title" style="margin-bottom:14px"><i class="bi bi-person-plus-fill"></i> Buat Akun Baru</div>
    <form method="POST" action="<?= BASE_URL ?>proccess/superadmin_process.php">
        <input type="hidden" name="action" value="buat_akun">
        <div class="form-row">
            <div class="form-group"><label>Nama Lengkap *</label><input type="text" name="nama" required placeholder="Nama lengkap"></div>
            <div class="form-group"><label>NIM</label><input type="text" name="nim" placeholder="Nomor induk mahasiswa"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Email *</label><input type="email" name="email" required placeholder="user@email.com"></div>
            <div class="form-group"><label>Username</label><input type="text" name="username" placeholder="username_login"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>No. HP</label><input type="text" name="no_hp" placeholder="08xxxxxxxxxx"></div>
            <div class="form-group"><label>Angkatan</label><input type="text" name="angkatan" placeholder="2024"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Password Awal *</label><input type="password" name="password" required placeholder="Min. 6 karakter"></div>
            <div class="form-group"><label>Role *</label>
                <select name="jabatan" required>
                    <option value="Anggota">Anggota</option>
                    <option value="Pengurus">Pengurus</option>
                    <option value="Admin">Admin</option>
                    <option value="Super Admin">Super Admin</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Organisasi</label>
                <select name="organisasi">
                    <option value="">-- Tidak ada --</option>
                    <?php foreach ($org_options as $o): ?>
                    <option value="<?= e($o['slug']) ?>"><?= e($o['nama']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group"><label>Status Akun</label>
                <select name="status">
                    <option value="Aktif">Aktif</option>
                    <option value="Nonaktif">Nonaktif</option>
                </select>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn-primary"><i class="bi bi-check-lg"></i> Buat Akun</button>
        </div>
    </form>
</div>

<?php
// Hitung statistik
$total_users    = count($all_users_list);
$aktif_users    = count(array_filter($all_users_list, fn($u) => $u['status'] === 'Aktif'));
$nonaktif_users = $total_users - $aktif_users;

$roles = ['Super Admin', 'Admin', 'Pengurus', 'Anggota'];
$role_colors_hex = [
    'Super Admin' => '#4a148c',
    'Admin'       => '#1565c0',
    'Pengurus'    => '#e65100',
    'Anggota'     => '#2e7d32',
];
$role_counts = [];
foreach ($roles as $r) {
    $role_counts[$r] = count(array_filter($all_users_list, fn($u) => $u['jabatan'] === $r));
}

// Distribusi per organisasi
$org_user_dist = [];
foreach ($all_users_list as $u) {
    $org_key = $u['organisasi'] ?: '-';
    $org_user_dist[$org_key] = ($org_user_dist[$org_key] ?? 0) + 1;
}
arsort($org_user_dist);
$max_org_count = max($org_user_dist ?: [1]);

// Donut SVG calculation
$radius = 42; $cx = 54; $cy = 54; $circ = 2 * M_PI * $radius;
$donut_segments = [];
$offset = 0;
foreach ($role_counts as $role => $count) {
    $pct  = $total_users > 0 ? $count / $total_users : 0;
    $dash = $pct * $circ;
    $gap  = $circ - $dash;
    $donut_segments[] = [
        'role'   => $role,
        'count'  => $count,
        'pct'    => round($pct * 100),
        'dash'   => $dash,
        'gap'    => $gap,
        'offset' => $circ - $offset,
        'color'  => $role_colors_hex[$role] ?? '#999',
    ];
    $offset += $dash;
}
?>

<!-- Overview: 3 panel dalam satu baris -->
<div class="sa-overview">

    <!-- Donut chart distribusi role -->
    <div class="sa-donut-wrap">
        <svg class="donut-svg" width="108" height="108" viewBox="0 0 108 108">
            <!-- track -->
            <circle cx="<?=$cx?>" cy="<?=$cy?>" r="<?=$radius?>" fill="none" stroke="var(--cream)" stroke-width="14"/>
            <?php foreach ($donut_segments as $seg): ?>
            <?php if ($seg['count'] > 0): ?>
            <circle cx="<?=$cx?>" cy="<?=$cy?>" r="<?=$radius?>" fill="none"
                    stroke="<?= $seg['color'] ?>"
                    stroke-width="14"
                    stroke-dasharray="<?= round($seg['dash'], 2) ?> <?= round($seg['gap'], 2) ?>"
                    stroke-dashoffset="<?= round($seg['offset'], 2) ?>"
                    stroke-linecap="butt"
                    style="transition:stroke-dasharray .5s ease"/>
            <?php endif; ?>
            <?php endforeach; ?>
            <!-- center label -->
            <text x="54" y="50" text-anchor="middle" font-size="18" font-weight="800" fill="#2A1A0A" font-family="Plus Jakarta Sans,sans-serif"><?= $total_users ?></text>
            <text x="54" y="63" text-anchor="middle" font-size="9" fill="#9E7A5A" font-family="Plus Jakarta Sans,sans-serif" font-weight="600">Akun</text>
        </svg>

        <div class="donut-legend">
            <?php foreach ($donut_segments as $seg): ?>
            <div class="donut-legend-item">
                <div class="donut-dot" style="background:<?= $seg['color'] ?>"></div>
                <span class="donut-legend-label"><?= e($seg['role']) ?></span>
                <span class="donut-legend-count"><?= $seg['count'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Bar chart distribusi per organisasi -->
    <div class="sa-org-bars">
        <div class="sa-bar-title"><i class="bi bi-people"></i> Akun per Organisasi</div>
        <?php $shown = 0; foreach ($org_user_dist as $org_name => $cnt): if ($shown >= 6) break; $shown++; ?>
        <div class="sa-bar-row">
            <span class="sa-bar-label" title="<?= e($org_name) ?>"><?= e(mb_substr($org_name, 0, 10)) ?></span>
            <div class="sa-bar-track">
                <div class="sa-bar-fill" style="width:<?= round($cnt / $max_org_count * 100) ?>%"></div>
            </div>
            <span class="sa-bar-count"><?= $cnt ?></span>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Status summary -->
    <div class="sa-activity-panel">
        <div class="sa-activity-title"><i class="bi bi-info-circle"></i> Ringkasan Status</div>
        <div style="display:flex;flex-direction:column;gap:10px">
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:var(--cream);border-radius:var(--r-sm)">
                <span style="font-size:.78rem;font-weight:600;color:var(--text-mid)"><i class="bi bi-people" style="color:var(--orange)"></i> Total Akun</span>
                <span style="font-size:1.1rem;font-weight:800;color:var(--text-dark)"><?= $total_users ?></span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:#e8f5e9;border-radius:var(--r-sm);border:1px solid #a5d6a7">
                <span style="font-size:.78rem;font-weight:600;color:#2e7d32"><i class="bi bi-person-check"></i> Akun Aktif</span>
                <span style="font-size:1.1rem;font-weight:800;color:#2e7d32"><?= $aktif_users ?></span>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 12px;background:#fff0ee;border-radius:var(--r-sm);border:1px solid #fbbcb8">
                <span style="font-size:.78rem;font-weight:600;color:#c0392b"><i class="bi bi-person-x"></i> Nonaktif</span>
                <span style="font-size:1.1rem;font-weight:800;color:#c0392b"><?= $nonaktif_users ?></span>
            </div>
            <?php if ($total_users > 0): ?>
            <div style="font-size:.72rem;color:var(--text-muted);text-align:center;margin-top:2px">
                <i class="bi bi-activity"></i>
                <?= round($aktif_users / $total_users * 100) ?>% akun aktif dari total
            </div>
            <?php endif; ?>
        </div>
    </div>

</div>

<!-- Tabel akun -->
<div class="panel">
    <?php if (empty($all_users_list)): ?>
    <div class="empty-big">
        <div class="e-icon-big"><i class="bi bi-people"></i></div>
        <div class="e-title">Belum ada data akun</div>
    </div>
    <?php else: ?>

    <!-- Filter role (SAMA seperti aslinya) -->
    <div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:14px;align-items:center">
        <span style="font-size:.78rem;font-weight:700;color:var(--text-muted)">Filter:</span>
        <button class="sa-filter-btn active" data-filter="semua"       onclick="filterAkun(this,'semua')">Semua</button>
        <button class="sa-filter-btn"        data-filter="Super Admin" onclick="filterAkun(this,'Super Admin')">Super Admin</button>
        <button class="sa-filter-btn"        data-filter="Admin"       onclick="filterAkun(this,'Admin')">Admin</button>
        <button class="sa-filter-btn"        data-filter="Pengurus"    onclick="filterAkun(this,'Pengurus')">Pengurus</button>
        <button class="sa-filter-btn"        data-filter="Anggota"     onclick="filterAkun(this,'Anggota')">Anggota</button>
        <button class="sa-filter-btn"        data-filter="Nonaktif"    onclick="filterAkun(this,'Nonaktif')">Nonaktif</button>
        <!-- Search ringan -->
        <input type="text" id="searchAkun" placeholder="Cari nama / NIM..."
               oninput="searchAkunFn(this.value)"
               style="margin-left:auto;padding:5px 13px;border:1.5px solid var(--border);border-radius:999px;font-size:.74rem;font-family:var(--font);outline:none;min-width:160px">
    </div>
    <style>
    .sa-filter-btn{background:var(--cream);border:1.5px solid var(--border);color:var(--text-muted);font-size:.72rem;font-weight:700;padding:5px 13px;border-radius:999px;cursor:pointer;transition:.2s;font-family:var(--font)}
    .sa-filter-btn.active,.sa-filter-btn:hover{background:var(--orange);color:#fff;border-color:var(--orange)}
    #searchAkun:focus { border-color:var(--orange); }
    </style>

    <div class="table-wrap">
        <table id="tblAkun">
            <thead>
                <tr>
                    <th>#</th><th>Nama</th><th>NIM</th><th>Email</th>
                    <th>Role</th><th>Organisasi</th><th>Angkatan</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($all_users_list as $i => $u): ?>
            <?php
            $role_colors = ['Super Admin'=>'#4a148c','Admin'=>'#1565c0','Pengurus'=>'#e65100','Anggota'=>'#2e7d32'];
            $rc = $role_colors[$u['jabatan']] ?? '#555';
            ?>
            <tr data-role="<?= e($u['jabatan']) ?>" data-status="<?= e($u['status']) ?>"
                data-search="<?= strtolower(e($u['nama']) . ' ' . e($u['nim'] ?? '')) ?>">
                <td><?= $i + 1 ?></td>
                <td>
                    <div style="display:flex;align-items:center;gap:9px">
                        <div style="width:30px;height:30px;border-radius:50%;background:<?= $rc ?>22;border:1.5px solid <?= $rc ?>44;display:flex;align-items:center;justify-content:center;font-size:.72rem;font-weight:800;color:<?= $rc ?>;flex-shrink:0">
                            <?= mb_strtoupper(mb_substr($u['nama'], 0, 1)) ?>
                        </div>
                        <span style="font-weight:600"><?= e($u['nama']) ?></span>
                    </div>
                </td>
                <td style="font-size:.78rem;color:var(--text-muted)"><?= e($u['nim'] ?? '-') ?></td>
                <td style="font-size:.78rem"><?= e($u['email']) ?></td>
                <td>
                    <span style="background:<?= $rc ?>22;color:<?= $rc ?>;border:1px solid <?= $rc ?>44;padding:3px 10px;border-radius:999px;font-size:.68rem;font-weight:700">
                        <?= e($u['jabatan']) ?>
                    </span>
                </td>
                <td style="font-size:.78rem"><?= e($u['organisasi'] ?? '-') ?></td>
                <td style="font-size:.78rem;color:var(--text-muted)"><?= e($u['angkatan'] ?? '-') ?></td>
                <td>
                    <?php if ($u['status'] === 'Aktif'): ?>
                    <span class="badge-aktif">Aktif</span>
                    <?php else: ?>
                    <span class="badge-nonaktif">Nonaktif</span>
                    <?php endif; ?>
                </td>
                <td>
                    <div style="display:flex;gap:5px;flex-wrap:wrap">
                        <!-- Edit -->
                        <button class="btn-sm-outline" onclick="openEditAkun(<?= htmlspecialchars(json_encode($u), ENT_QUOTES) ?>)">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <!-- Reset PW -->
                        <button class="btn-sm-outline" style="color:#1565c0;border-color:#1565c0"
                                onclick="openResetPw(<?= $u['id'] ?>, '<?= e($u['nama']) ?>')">
                            <i class="bi bi-key"></i>
                        </button>
                        <!-- Toggle Status -->
                        <?php if ((int)$u['id'] !== $uid): ?>
                        <?php if ($u['status'] === 'Aktif'): ?>
                        <form method="POST" action="<?= BASE_URL ?>proccess/superadmin_process.php" style="display:inline"
                              onsubmit="return confirm('Nonaktifkan akun <?= e($u['nama']) ?>?')">
                            <input type="hidden" name="action" value="toggle_status_akun">
                            <input type="hidden" name="target_id" value="<?= $u['id'] ?>">
                            <input type="hidden" name="new_status" value="Nonaktif">
                            <button type="submit" class="btn-danger"><i class="bi bi-person-x"></i></button>
                        </form>
                        <?php else: ?>
                        <form method="POST" action="<?= BASE_URL ?>proccess/superadmin_process.php" style="display:inline"
                              onsubmit="return confirm('Aktifkan kembali akun <?= e($u['nama']) ?>?')">
                            <input type="hidden" name="action" value="toggle_status_akun">
                            <input type="hidden" name="target_id" value="<?= $u['id'] ?>">
                            <input type="hidden" name="new_status" value="Aktif">
                            <button type="submit" class="btn-success"><i class="bi bi-person-check"></i></button>
                        </form>
                        <?php endif; ?>
                        <?php else: ?>
                        <span style="font-size:.72rem;color:var(--text-muted);font-style:italic">Akun Anda</span>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- Row count -->
    <div style="text-align:right;font-size:.72rem;color:var(--text-muted);margin-top:10px;padding-top:10px;border-top:1px solid var(--border)">
        Menampilkan <span id="visibleCount"><?= count($all_users_list) ?></span> dari <?= count($all_users_list) ?> akun
    </div>
    <?php endif; ?>
</div>

<script>
// Search tambahan (non-breaking — tidak menghapus fungsi filterAkun asli)
function searchAkunFn(q) {
    q = q.toLowerCase().trim();
    document.querySelectorAll('#tblAkun tbody tr').forEach(tr => {
        const match = !q || tr.dataset.search.includes(q);
        if (!match) { tr.style.display = 'none'; return; }
        // Juga respect filter aktif
        const activeFilter = document.querySelector('.sa-filter-btn.active')?.dataset.filter ?? 'semua';
        if (activeFilter !== 'semua') {
            if (activeFilter === 'Nonaktif') {
                tr.style.display = tr.dataset.status === 'Nonaktif' ? '' : 'none';
            } else {
                tr.style.display = tr.dataset.role === activeFilter ? '' : 'none';
            }
        } else {
            tr.style.display = '';
        }
    });
    updateVisibleCount();
}

function updateVisibleCount() {
    const vis = Array.from(document.querySelectorAll('#tblAkun tbody tr')).filter(tr => tr.style.display !== 'none').length;
    const el  = document.getElementById('visibleCount');
    if (el) el.textContent = vis;
}

// Wrap filterAkun asli agar update count
const _origFilterAkun = window.filterAkun;
window.filterAkun = function(btn, filter) {
    // Reset search input
    const si = document.getElementById('searchAkun');
    if (si) si.value = '';
    if (typeof _origFilterAkun === 'function') _origFilterAkun(btn, filter);
    else {
        // fallback jika partial di-load sebelum main script
        document.querySelectorAll('.sa-filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('#tblAkun tbody tr').forEach(tr => {
            if (filter === 'semua') { tr.style.display = ''; return; }
            if (filter === 'Nonaktif') { tr.style.display = tr.dataset.status === 'Nonaktif' ? '' : 'none'; }
            else { tr.style.display = tr.dataset.role === filter ? '' : 'none'; }
        });
    }
    updateVisibleCount();
};
</script>
