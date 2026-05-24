<?php
// pages/dashboard/dashboard.php
require_once '../../config/connection.php';
require_login();

// ── Ambil data user terbaru dari DB ───────────────────────────────
$uid  = (int)$_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
$stmt->bind_param('i', $uid);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    session_destroy();
    header('Location: ' . BASE_URL . 'pages/login/login.php');
    exit;
}

// Update session dengan data terbaru
$_SESSION['nama']    = $user['nama'];
$_SESSION['jabatan'] = $user['jabatan'] ?? 'Anggota';

// ── Cek dari mana user datang (signin baru atau login kembali) ────
$greeting_type = $_GET['from'] ?? 'login';  // 'signin' | 'login'

// ── Inisial nama user (maks 2 huruf) ─────────────────────────────
$words    = preg_split('/\s+/', trim($user['nama']));
$initials = mb_strtoupper(mb_substr($words[0], 0, 1));
if (count($words) > 1) $initials .= mb_strtoupper(mb_substr($words[1], 0, 1));

// ── First-name saja untuk greeting ───────────────────────────────
$first_name = $words[0];

// ── Statistik (data nyata dari DB, default 0 jika tabel kosong) ──
$stats = ['kegiatan' => 0, 'dokumen' => 0, 'anggota' => 0, 'pengumuman' => 0];

$rK = $conn->query("SELECT COUNT(*) AS c FROM kegiatan");
if ($rK) $stats['kegiatan'] = $rK->fetch_assoc()['c'];

$rD = $conn->query("SELECT COUNT(*) AS c FROM dokumen WHERE user_id = $uid");
if ($rD) $stats['dokumen'] = $rD->fetch_assoc()['c'];

$rA = $conn->query("SELECT COUNT(*) AS c FROM anggota");
if ($rA) $stats['anggota'] = $rA->fetch_assoc()['c'];

$rP = $conn->query("SELECT COUNT(*) AS c FROM pengumuman");
if ($rP) $stats['pengumuman'] = $rP->fetch_assoc()['c'];

// ── Kegiatan terkini (maks 5) ─────────────────────────────────────
$kegiatan_list = [];
$rKL = $conn->query("SELECT * FROM kegiatan ORDER BY tanggal DESC LIMIT 5");
if ($rKL) $kegiatan_list = $rKL->fetch_all(MYSQLI_ASSOC);

// ── Pengumuman terbaru (maks 5) ───────────────────────────────────
$pengumuman_list = [];
$rPL = $conn->query("SELECT p.*, u.nama AS penulis FROM pengumuman p
                     LEFT JOIN users u ON p.user_id = u.id
                     ORDER BY p.tanggal DESC LIMIT 5");
if ($rPL) $pengumuman_list = $rPL->fetch_all(MYSQLI_ASSOC);

// ── Header variables ──────────────────────────────────────────────
$page_title = 'Dashboard';
$page_css   = ['dashboard.css'];
require_once '../../components/header.php';
?>

<!-- ══════════════════════════════════════════════════
     LAYOUT: SIDEBAR + MAIN
══════════════════════════════════════════════════ -->

<!-- Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ── SIDEBAR ── -->
<aside class="sidebar" id="sidebar">

    <!-- Logo -->
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon">
            <i class="bi bi-journal-bookmark-fill"></i>
        </div>
        <div class="sidebar-logo-text">
            <div class="orc">ORC</div>
            <div class="sub">Organization Resource Center<br>of ORMAWA ITH</div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>

        <a href="<?= BASE_URL ?>pages/dashboard/dashboard.php" class="nav-item active">
            <i class="bi bi-grid-1x2"></i>
            <span>Dashboard</span>
        </a>
        <a href="<?= BASE_URL ?>pages/profile/profile.php" class="nav-item">
            <i class="bi bi-person-circle"></i>
            <span>Profil Saya</span>
        </a>
        <a href="<?= BASE_URL ?>pages/organisasi/organisasi.php" class="nav-item">
            <i class="bi bi-people"></i>
            <span>Organisasi</span>
        </a>

        <div class="nav-label">Pengelolaan</div>

        <a href="#" class="nav-item">
            <i class="bi bi-calendar-event"></i>
            <span>Kegiatan</span>
            <?php if ($stats['kegiatan'] > 0): ?>
            <span class="badge"><?= $stats['kegiatan'] ?></span>
            <?php endif; ?>
        </a>
        <a href="#" class="nav-item">
            <i class="bi bi-person-badge"></i>
            <span>Anggota</span>
        </a>
        <a href="#" class="nav-item">
            <i class="bi bi-folder2-open"></i>
            <span>Dokumen</span>
            <?php if ($stats['dokumen'] > 0): ?>
            <span class="badge"><?= $stats['dokumen'] ?></span>
            <?php endif; ?>
        </a>
        <a href="#" class="nav-item">
            <i class="bi bi-megaphone"></i>
            <span>Pengumuman</span>
            <?php if ($stats['pengumuman'] > 0): ?>
            <span class="badge"><?= $stats['pengumuman'] ?></span>
            <?php endif; ?>
        </a>

        <div class="nav-label">Akun</div>

        <a href="<?= BASE_URL ?>pages/profile/profile.php" class="nav-item">
            <i class="bi bi-gear"></i>
            <span>Pengaturan</span>
        </a>
    </nav>

    <!-- Footer sidebar -->
    <div class="sidebar-footer">
        <div class="sidebar-user-mini">
            <div class="sidebar-avatar"><?= e($initials) ?></div>
            <div>
                <div class="sidebar-user-name"><?= e($user['nama']) ?></div>
                <div class="sidebar-user-role"><?= e($user['jabatan'] ?? 'Anggota') ?></div>
            </div>
        </div>
        <a href="<?= BASE_URL ?>proccess/logout.php" class="btn-logout"
           onclick="return confirm('Yakin ingin keluar dari ORC?')">
            <i class="bi bi-box-arrow-right"></i>
            Keluar Akun
        </a>
    </div>

</aside>

<!-- ── MAIN WRAPPER ── -->
<div class="main-wrapper">

    <!-- TOPBAR -->
    <header class="topbar">
        <button class="hamburger" id="hamburgerBtn" aria-label="Toggle sidebar">
            <i class="bi bi-list"></i>
        </button>
        <h1 class="topbar-title">Dashboard</h1>
        <div class="topbar-right">
            <div class="topbar-icon-btn" aria-label="Notifikasi">
                <i class="bi bi-bell"></i>
                <?php if ($stats['pengumuman'] > 0): ?>
                <div class="notif-badge"></div>
                <?php endif; ?>
            </div>
            <div class="topbar-profile" id="profileDropdown">
                <div class="topbar-avatar"><?= e($initials) ?></div>
                <div>
                    <div class="topbar-name"><?= e($initials) ?></div>
                    <div class="topbar-role"><?= e($user['jabatan'] ?? 'Anggota') ?></div>
                </div>
                <i class="bi bi-chevron-down topbar-chevron"></i>
            </div>
        </div>
    </header>

    <!-- CONTENT -->
    <main class="content">

        <!-- ── WELCOME CARD ── -->
        <div class="welcome-card">
            <div class="welcome-left">
                <div class="welcome-tag">
                    <?php if ($greeting_type === 'signin'): ?>
                        <i class="bi bi-stars"></i> Selamat datang di ORC!
                    <?php else: ?>
                        <i class="bi bi-hand-wave"></i> Selamat datang kembali
                    <?php endif; ?>
                </div>
                <div class="welcome-name">
                    <?php if ($greeting_type === 'signin'): ?>
                        Halo, <?= e($first_name) ?>! 👋
                    <?php else: ?>
                        Selamat Datang Kembali, <?= e($first_name) ?>!
                    <?php endif; ?>
                </div>
                <div class="welcome-sub">Mulai kelola organisasimu dari sini</div>
            </div>
            <div class="welcome-right">
                <a href="<?= BASE_URL ?>pages/profile/profile.php" class="btn-active">
                    <i class="bi bi-check-circle-fill"></i>
                    Akun aktif
                </a>
            </div>
        </div>

        <!-- ── QUICK STATS ── -->
        <div class="stats-grid">

            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-calendar-event"></i></div>
                <div class="stat-title">Kegiatan</div>
                <div class="stat-divider"></div>
                <?php if ($stats['kegiatan'] > 0): ?>
                    <div class="stat-number"><?= $stats['kegiatan'] ?></div>
                <?php else: ?>
                    <div class="stat-value">Belum ada kegiatan</div>
                <?php endif; ?>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-folder2-open"></i></div>
                <div class="stat-title">Dokumen</div>
                <div class="stat-divider"></div>
                <?php if ($stats['dokumen'] > 0): ?>
                    <div class="stat-number"><?= $stats['dokumen'] ?></div>
                <?php else: ?>
                    <div class="stat-value">Belum ada dokumen</div>
                <?php endif; ?>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-people"></i></div>
                <div class="stat-title">Anggota</div>
                <div class="stat-divider"></div>
                <?php if ($stats['anggota'] > 0): ?>
                    <div class="stat-number"><?= $stats['anggota'] ?></div>
                <?php else: ?>
                    <div class="stat-value">Belum ada anggota</div>
                <?php endif; ?>
            </div>

            <div class="stat-card">
                <div class="stat-icon"><i class="bi bi-megaphone"></i></div>
                <div class="stat-title">Pengumuman</div>
                <div class="stat-divider"></div>
                <?php if ($stats['pengumuman'] > 0): ?>
                    <div class="stat-number"><?= $stats['pengumuman'] ?></div>
                <?php else: ?>
                    <div class="stat-value">Belum ada info</div>
                <?php endif; ?>
            </div>

        </div>

        <!-- ── TWO COLUMN ── -->
        <div class="two-col">

            <!-- Kegiatan Terkini -->
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-icon"><i class="bi bi-calendar-event"></i></div>
                    <span class="panel-title">Kegiatan Terkini</span>
                    <span class="panel-count"><?= $stats['kegiatan'] ?> kegiatan</span>
                </div>
                <div class="panel-body">
                    <?php if (empty($kegiatan_list)): ?>
                    <div class="empty-state">
                        <div class="empty-icon-wrap"><i class="bi bi-calendar-x"></i></div>
                        <div class="empty-title">Belum ada kegiatan</div>
                        <div class="empty-sub">Kegiatan yang kamu ikuti atau kelola akan muncul di sini</div>
                    </div>
                    <div class="skeleton-row medium"></div>
                    <div class="skeleton-row short"></div>
                    <div class="skeleton-row medium"></div>
                    <?php else: ?>
                        <?php foreach ($kegiatan_list as $k): ?>
                        <div style="padding:12px;background:var(--cream);border-radius:var(--r-sm);border:1px solid var(--border);">
                            <div style="font-size:.85rem;font-weight:700;color:var(--text-dark);"><?= e($k['nama_kegiatan']) ?></div>
                            <div style="font-size:.74rem;color:var(--text-muted);margin-top:3px;">
                                <?= date('d M Y', strtotime($k['tanggal'])) ?> · <?= e($k['tempat']) ?>
                            </div>
                            <div style="margin-top:5px;">
                                <span style="font-size:.68rem;font-weight:600;padding:2px 8px;background:var(--orange-glow);color:var(--orange);border-radius:999px;">
                                    <?= e($k['status']) ?>
                                </span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Pengumuman -->
            <div class="panel">
                <div class="panel-header">
                    <div class="panel-icon"><i class="bi bi-megaphone"></i></div>
                    <span class="panel-title">Pengumuman</span>
                    <span class="panel-count"><?= $stats['pengumuman'] ?> baru</span>
                </div>
                <div class="panel-body">
                    <?php if (empty($pengumuman_list)): ?>
                    <div class="skeleton-announcement">
                        <div class="skeleton-dot"></div>
                        <div class="skeleton-lines">
                            <div class="skeleton-row"></div>
                            <div class="skeleton-row short"></div>
                        </div>
                    </div>
                    <div class="skeleton-announcement">
                        <div class="skeleton-dot"></div>
                        <div class="skeleton-lines">
                            <div class="skeleton-row medium"></div>
                            <div class="skeleton-row short"></div>
                        </div>
                    </div>
                    <div class="skeleton-announcement">
                        <div class="skeleton-dot"></div>
                        <div class="skeleton-lines">
                            <div class="skeleton-row"></div>
                            <div class="skeleton-row short"></div>
                        </div>
                    </div>
                    <div style="text-align:center;padding:18px 0 8px;">
                        <div style="font-size:.8rem;color:var(--text-muted);">Pengumuman akan tampil di sini</div>
                    </div>
                    <?php else: ?>
                        <?php foreach ($pengumuman_list as $p): ?>
                        <div style="padding:12px;background:var(--cream);border-radius:var(--r-sm);border:1px solid var(--border);border-left:3px solid var(--orange);">
                            <div style="font-size:.85rem;font-weight:700;color:var(--text-dark);"><?= e($p['judul']) ?></div>
                            <div style="font-size:.74rem;color:var(--text-muted);margin-top:3px;">
                                <?= e($p['penulis'] ?? 'ORC') ?> · <?= date('d M Y', strtotime($p['tanggal'])) ?>
                            </div>
                            <div style="font-size:.78rem;color:var(--text-mid);margin-top:5px;line-height:1.5;">
                                <?= e(mb_substr($p['konten'], 0, 90)) ?><?= mb_strlen($p['konten']) > 90 ? '...' : '' ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div><!-- /two-col -->

    </main><!-- /content -->

</div><!-- /main-wrapper -->

<!-- ══════════════════════════════════════════════════
     TOAST NOTIFICATION (Greeting)
══════════════════════════════════════════════════ -->
<?php
$is_signin = ($greeting_type === 'signin');
$toast_title = $is_signin
    ? "Pendaftaran berhasil! 🎉"
    : "Login berhasil!";
$toast_msg = $is_signin
    ? "Selamat datang di ORC, " . htmlspecialchars($user['nama'], ENT_QUOTES, 'UTF-8') . "! Akun Anda sudah aktif."
    : "Selamat datang kembali, " . htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8') . "! Semangat berorganisasi!";
$toast_icon = $is_signin ? "bi-stars" : "bi-emoji-smile";
$toast_class = $is_signin ? "signin-toast" : "";
?>
<div class="toast <?= $toast_class ?>" id="toastNotif" role="alert" aria-live="polite">
    <div class="toast-icon"><i class="bi <?= $toast_icon ?>"></i></div>
    <div class="toast-content">
        <div class="toast-title"><?= $toast_title ?></div>
        <div class="toast-msg"><?= $toast_msg ?></div>
    </div>
    <span class="toast-close" id="toastClose" aria-label="Tutup"><i class="bi bi-x-lg"></i></span>
</div>

<script>
(function() {
    // ── Toast auto-dismiss ────────────────────────────────────
    const toast = document.getElementById('toastNotif');
    const closeBtn = document.getElementById('toastClose');
    function dismissToast() {
        toast.style.animation = 'toastOut .35s ease forwards';
        setTimeout(() => toast.remove(), 360);
    }
    if (toast) {
        setTimeout(dismissToast, 5200);
        closeBtn.addEventListener('click', dismissToast);
        toast.addEventListener('click', dismissToast);
    }

    // ── Sidebar toggle ────────────────────────────────────────
    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('sidebarOverlay');
    const hamBtn    = document.getElementById('hamburgerBtn');
    function openSidebar()  { sidebar.classList.add('open');  overlay.classList.add('open'); }
    function closeSidebar() { sidebar.classList.remove('open'); overlay.classList.remove('open'); }
    if (hamBtn) hamBtn.addEventListener('click', () => sidebar.classList.contains('open') ? closeSidebar() : openSidebar());
    if (overlay) overlay.addEventListener('click', closeSidebar);

    // ── Profile dropdown placeholder ─────────────────────────
    document.getElementById('profileDropdown')?.addEventListener('click', function() {
        const menu = this.nextElementSibling;
        if (!menu) {
            window.location = '<?= BASE_URL ?>pages/profile/profile.php';
        }
    });
})();
</script>

<?php
// Tutup body/html
$page_js = [];
require_once '../../components/footer_scripts.php';
?>
