<?php
// pages/dashboard/dashboard.php — Full CRUD Dashboard
require_once '../../config/connection.php';
require_login();

$uid = (int)$_SESSION['user_id'];

// ── Ambil data user fresh dari DB ─────────────────────────────────
$pk_col = get_user_pk($conn);
$stmt = $conn->prepare("SELECT * FROM users WHERE `$pk_col` = ? LIMIT 1");
$stmt->bind_param('i', $uid);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$user) { session_destroy(); header('Location:'.BASE_URL.'pages/login/login.php'); exit; }

$_SESSION['nama']    = $user['nama'];
$_SESSION['jabatan'] = $user['jabatan'] ?? 'Anggota';

// ── Inisial & first name ──────────────────────────────────────────
$words      = preg_split('/\s+/', trim($user['nama']));
$initials   = mb_strtoupper(mb_substr($words[0],0,1)) . (count($words)>1 ? mb_strtoupper(mb_substr($words[1],0,1)) : '');
$first_name = $words[0];

// ── Active tab ─────────────────────────────────────────────────────
$tab = $_GET['tab'] ?? 'dashboard';
$allowed_tabs = ['dashboard','profil','kegiatan','anggota','dokumen','pengumuman'];
if (!in_array($tab, $allowed_tabs)) $tab = 'dashboard';

// ── Flash message ──────────────────────────────────────────────────
$flash_ok  = urldecode($_GET['success'] ?? '');
$flash_err = urldecode($_GET['error']   ?? '');

// ── Greeting type ──────────────────────────────────────────────────
$from = $_GET['from'] ?? 'login';

// ── Stats ─────────────────────────────────────────────────────────
$rK = $conn->query("SELECT COUNT(*) AS c FROM kegiatan"); $nK = $rK ? $rK->fetch_assoc()['c'] : 0;
$rD = $conn->query("SELECT COUNT(*) AS c FROM dokumen WHERE user_id=$uid"); $nD = $rD ? $rD->fetch_assoc()['c'] : 0;
$rA = $conn->query("SELECT COUNT(*) AS c FROM anggota"); $nA = $rA ? $rA->fetch_assoc()['c'] : 0;
$rP = $conn->query("SELECT COUNT(*) AS c FROM pengumuman"); $nP = $rP ? $rP->fetch_assoc()['c'] : 0;

// ── Data per tab ───────────────────────────────────────────────────
$kegiatan_list   = $conn->query("SELECT * FROM kegiatan ORDER BY tanggal DESC")?->fetch_all(MYSQLI_ASSOC) ?? [];
$dokumen_list    = $conn->query("SELECT * FROM dokumen WHERE user_id=$uid ORDER BY tanggal_upload DESC")?->fetch_all(MYSQLI_ASSOC) ?? [];
$anggota_list    = $conn->query("SELECT * FROM anggota ORDER BY tanggal_daftar DESC")?->fetch_all(MYSQLI_ASSOC) ?? [];
$pengumuman_list = $conn->query("SELECT p.*,u.nama AS penulis FROM pengumuman p LEFT JOIN users u ON p.user_id=u.`{$pk_col}` ORDER BY p.tanggal DESC")?->fetch_all(MYSQLI_ASSOC) ?? [];

$page_title = 'Dashboard';
$page_css   = ['dashboard.css'];
require_once '../../components/header.php';
?>
<style>
/* ── TAB & PAGE-SPECIFIC ─────────────────────────────── */
.tab-content { display:none; }
.tab-content.active { display:flex; flex-direction:column; gap:18px; animation:fadeUp .38s both; }
.section-header { display:flex; align-items:center; justify-content:space-between; margin-bottom:2px; }
.section-header h2 { font-size:1rem; font-weight:800; color:var(--text-dark); }
.btn-primary {
  display:inline-flex; align-items:center; gap:7px;
  background:var(--orange); color:#fff; font-size:.8rem; font-weight:700;
  padding:9px 18px; border-radius:999px; border:none; cursor:pointer;
  font-family:var(--font); box-shadow:0 3px 12px rgba(201,101,17,.30);
  transition:.2s; text-decoration:none;
}
.btn-primary:hover { background:#a85000; }
.btn-danger {
  display:inline-flex; align-items:center; gap:5px;
  background:#fff0ee; color:#c0392b; font-size:.74rem; font-weight:700;
  padding:6px 13px; border-radius:999px; border:1px solid #fbbcb8; cursor:pointer;
  font-family:var(--font); transition:.2s;
}
.btn-danger:hover { background:#fbbcb8; }
.btn-sm-outline {
  display:inline-flex; align-items:center; gap:5px;
  background:#fff; color:var(--orange); font-size:.74rem; font-weight:700;
  padding:6px 12px; border-radius:999px; border:1.5px solid var(--orange); cursor:pointer;
  font-family:var(--font); transition:.2s; text-decoration:none;
}
.btn-sm-outline:hover { background:var(--orange); color:#fff; }

/* TABLE */
.table-wrap { overflow-x:auto; }
table { width:100%; border-collapse:collapse; font-size:.82rem; }
thead th { padding:11px 14px; text-align:left; font-size:.72rem; font-weight:700; letter-spacing:.06em; text-transform:uppercase; color:var(--text-muted); background:var(--cream); border-bottom:1.5px solid var(--border); }
tbody tr { border-bottom:1px solid var(--border); transition:background .15s; }
tbody tr:hover { background:var(--cream); }
tbody td { padding:11px 14px; color:var(--text-dark); vertical-align:middle; }
.badge-status { display:inline-block; font-size:.68rem; font-weight:700; padding:3px 10px; border-radius:999px; }
.badge-status.terjadwal  { background:#fff7e0; color:#b58900; border:1px solid #f0d060; }
.badge-status.berlangsung{ background:#e0f7fa; color:#0077a8; border:1px solid #b2ebf2; }
.badge-status.selesai    { background:#e8f5e9; color:#2e7d32; border:1px solid #a5d6a7; }
.badge-status.dibatalkan { background:#fce4ec; color:#c62828; border:1px solid #f48fb1; }

/* MODAL */
.modal-backdrop {
  display:none; position:fixed; inset:0; background:rgba(0,0,0,.45);
  z-index:500; align-items:center; justify-content:center; padding:20px;
}
.modal-backdrop.open { display:flex; }
.modal-box {
  background:#fff; border-radius:22px; padding:28px 28px 24px;
  width:100%; max-width:520px; box-shadow:0 20px 60px rgba(0,0,0,.22);
  position:relative; animation:fadeUp .3s both;
}
.modal-title { font-size:1.05rem; font-weight:800; color:var(--text-dark); margin-bottom:20px; display:flex; align-items:center; gap:10px; }
.modal-title i { color:var(--orange); }
.modal-close { position:absolute; top:18px; right:18px; background:var(--cream); border:none; width:30px; height:30px; border-radius:50%; cursor:pointer; color:var(--text-muted); font-size:.85rem; display:flex; align-items:center; justify-content:center; }
.modal-close:hover { background:var(--beige); }
.form-group { margin-bottom:14px; }
.form-group label { display:block; font-size:.76rem; font-weight:700; color:var(--text-mid); margin-bottom:5px; }
.form-group input, .form-group select, .form-group textarea {
  width:100%; padding:10px 14px; border:1.5px solid var(--border);
  border-radius:var(--r-sm); font-size:.84rem; font-family:var(--font);
  color:var(--text-dark); background:#fff; transition:border-color .2s;
  outline:none;
}
.form-group input:focus, .form-group select:focus, .form-group textarea:focus {
  border-color:var(--orange);
}
.form-group textarea { resize:vertical; min-height:90px; }
.form-group input[type=file] { padding:8px; }
.form-row { display:grid; grid-template-columns:1fr 1fr; gap:12px; }
.form-actions { display:flex; gap:10px; justify-content:flex-end; margin-top:18px; padding-top:16px; border-top:1px solid var(--border); }
.btn-cancel { background:var(--cream); color:var(--text-mid); border:1px solid var(--border); padding:9px 18px; border-radius:999px; font-weight:600; font-size:.8rem; cursor:pointer; font-family:var(--font); }
.btn-cancel:hover { background:var(--beige); }

/* FLASH */
.flash { padding:12px 16px; border-radius:var(--r-sm); font-size:.82rem; font-weight:600; display:flex; align-items:center; gap:10px; }
.flash.ok  { background:#e8f5e9; color:#2e7d32; border:1px solid #a5d6a7; }
.flash.err { background:#fce4ec; color:#c62828; border:1px solid #f48fb1; }

/* PROFILE FORM */
.profile-card { background:#fff; border:1px solid var(--border); border-radius:var(--r-lg); padding:28px; }
.profile-avatar-big { width:72px; height:72px; border-radius:50%; background:linear-gradient(135deg,var(--orange),var(--brown)); display:flex; align-items:center; justify-content:center; font-weight:800; font-size:1.6rem; color:#fff; margin-bottom:16px; }
.profile-info-label { font-size:.72rem; font-weight:700; color:var(--text-muted); text-transform:uppercase; letter-spacing:.08em; }

/* Empty state */
.empty-big { display:flex; flex-direction:column; align-items:center; justify-content:center; padding:48px 20px; text-align:center; }
.empty-big .e-icon-big { width:64px; height:64px; border-radius:18px; background:var(--cream); display:flex; align-items:center; justify-content:center; color:var(--beige-dk,#D9C4AD); font-size:1.8rem; margin-bottom:14px; box-shadow:inset 0 0 0 1.5px var(--border); }
.empty-big .e-title { font-size:.95rem; font-weight:700; color:var(--text-mid); margin-bottom:5px; }
.empty-big .e-sub { font-size:.8rem; color:var(--text-muted); line-height:1.6; max-width:240px; margin-bottom:20px; }
</style>

<!-- Overlay mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ══ SIDEBAR ══ -->
<aside class="sidebar" id="sidebar">
    <div class="sidebar-logo">
        <div class="sidebar-logo-icon"><i class="bi bi-journal-bookmark-fill"></i></div>
        <div class="sidebar-logo-text">
            <div class="orc">ORC</div>
            <div class="sub">Organization Resource Center<br>of ORMAWA ITH</div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-label">Menu Utama</div>
        <a href="?tab=dashboard" class="nav-item <?= $tab==='dashboard'?'active':'' ?>"><i class="bi bi-grid-1x2"></i><span>Dashboard</span></a>
        <a href="?tab=profil"    class="nav-item <?= $tab==='profil'?'active':'' ?>"><i class="bi bi-person-circle"></i><span>Profil Saya</span></a>
        <a href="<?= BASE_URL ?>pages/organisasi/organisasi.php" class="nav-item"><i class="bi bi-people"></i><span>Organisasi</span></a>
        <div class="nav-label">Pengelolaan</div>
        <a href="?tab=kegiatan"   class="nav-item <?= $tab==='kegiatan'?'active':'' ?>"><i class="bi bi-calendar-event"></i><span>Kegiatan</span><?php if($nK>0):?><span class="badge"><?=$nK?></span><?php endif;?></a>
        <a href="?tab=anggota"    class="nav-item <?= $tab==='anggota'?'active':'' ?>"><i class="bi bi-person-badge"></i><span>Anggota</span><?php if($nA>0):?><span class="badge"><?=$nA?></span><?php endif;?></a>
        <a href="?tab=dokumen"    class="nav-item <?= $tab==='dokumen'?'active':'' ?>"><i class="bi bi-folder2-open"></i><span>Dokumen</span><?php if($nD>0):?><span class="badge"><?=$nD?></span><?php endif;?></a>
        <a href="?tab=pengumuman" class="nav-item <?= $tab==='pengumuman'?'active':'' ?>"><i class="bi bi-megaphone"></i><span>Pengumuman</span><?php if($nP>0):?><span class="badge"><?=$nP?></span><?php endif;?></a>
        <div class="nav-label">Akun</div>
        <a href="?tab=profil" class="nav-item"><i class="bi bi-gear"></i><span>Pengaturan</span></a>
    </nav>
    <div class="sidebar-footer">
        <div class="sidebar-user-mini">
            <div class="sidebar-avatar"><?=e($initials)?></div>
            <div>
                <div class="sidebar-user-name"><?=e($user['nama'])?></div>
                <div class="sidebar-user-role"><?=e($user['jabatan']??'Anggota')?></div>
            </div>
        </div>
        <a href="<?=BASE_URL?>proccess/logout.php" class="btn-logout" onclick="return confirm('Yakin ingin keluar?')">
            <i class="bi bi-box-arrow-right"></i> Keluar Akun
        </a>
    </div>
</aside>

<!-- ══ MAIN ══ -->
<div class="main-wrapper">
    <header class="topbar">
        <button class="hamburger" id="hamburgerBtn"><i class="bi bi-list"></i></button>
        <h1 class="topbar-title"><?= ucfirst($tab) === 'Dashboard' ? 'Dashboard' : ucfirst($tab) ?></h1>
        <div class="topbar-right">
            <div class="topbar-icon-btn"><i class="bi bi-bell"></i><?php if($nP>0):?><div class="notif-badge"></div><?php endif;?></div>
            <div class="topbar-profile">
                <div class="topbar-avatar"><?=e($initials)?></div>
                <div>
                    <div class="topbar-name"><?=e($user['nama'])?></div>
                    <div class="topbar-role"><?=e($user['jabatan']??'Anggota')?></div>
                </div>
                <i class="bi bi-chevron-down topbar-chevron"></i>
            </div>
        </div>
    </header>

    <main class="content">

        <!-- ── FLASH ── -->
        <?php if($flash_ok):?><div class="flash ok"><i class="bi bi-check-circle-fill"></i> <?=e($flash_ok)?></div><?php endif;?>
        <?php if($flash_err):?><div class="flash err"><i class="bi bi-exclamation-circle-fill"></i> <?=e($flash_err)?></div><?php endif;?>

        <!-- ══════════════════════════
             TAB: DASHBOARD
        ══════════════════════════ -->
        <div class="tab-content <?=$tab==='dashboard'?'active':''?>">

            <!-- Welcome Card -->
            <div class="welcome-card">
                <div class="welcome-left">
                    <div class="welcome-tag">
                        <?php if($from==='signin'):?><i class="bi bi-stars"></i> Selamat datang di ORC!
                        <?php else:?><i class="bi bi-hand-wave"></i> Selamat datang kembali<?php endif;?>
                    </div>
                    <div class="welcome-name">
                        <?php if($from==='signin'):?>Halo, <?=e($first_name)?>! 👋
                        <?php else:?>Selamat Datang Kembali, <?=e($first_name)?>!<?php endif;?>
                    </div>
                    <div class="welcome-sub">Mulai kelola organisasimu dari sini</div>
                </div>
                <div class="welcome-right">
                    <a href="?tab=profil" class="btn-active"><i class="bi bi-check-circle-fill"></i> Akun aktif</a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card" onclick="location='?tab=kegiatan'" style="cursor:pointer">
                    <div class="stat-icon"><i class="bi bi-calendar-event"></i></div>
                    <div class="stat-title">Kegiatan</div>
                    <div class="stat-divider"></div>
                    <?php if($nK>0):?><div class="stat-number"><?=$nK?></div>
                    <?php else:?><div class="stat-value">Belum ada kegiatan</div><?php endif;?>
                </div>
                <div class="stat-card" onclick="location='?tab=dokumen'" style="cursor:pointer">
                    <div class="stat-icon"><i class="bi bi-folder2-open"></i></div>
                    <div class="stat-title">Dokumen</div>
                    <div class="stat-divider"></div>
                    <?php if($nD>0):?><div class="stat-number"><?=$nD?></div>
                    <?php else:?><div class="stat-value">Belum ada dokumen</div><?php endif;?>
                </div>
                <div class="stat-card" onclick="location='?tab=anggota'" style="cursor:pointer">
                    <div class="stat-icon"><i class="bi bi-people"></i></div>
                    <div class="stat-title">Anggota</div>
                    <div class="stat-divider"></div>
                    <?php if($nA>0):?><div class="stat-number"><?=$nA?></div>
                    <?php else:?><div class="stat-value">Belum ada anggota</div><?php endif;?>
                </div>
                <div class="stat-card" onclick="location='?tab=pengumuman'" style="cursor:pointer">
                    <div class="stat-icon"><i class="bi bi-megaphone"></i></div>
                    <div class="stat-title">Pengumuman</div>
                    <div class="stat-divider"></div>
                    <?php if($nP>0):?><div class="stat-number"><?=$nP?></div>
                    <?php else:?><div class="stat-value">Belum ada info</div><?php endif;?>
                </div>
            </div>

            <!-- 2 Col Panels -->
            <div class="two-col">
                <div class="panel">
                    <div class="panel-header">
                        <div class="panel-icon"><i class="bi bi-calendar-event"></i></div>
                        <span class="panel-title">Kegiatan Terkini</span>
                        <span class="panel-count"><?=$nK?> kegiatan</span>
                    </div>
                    <div class="panel-body">
                        <?php if(empty($kegiatan_list)):?>
                        <div class="empty-state">
                            <div class="empty-icon-wrap"><i class="bi bi-calendar-x"></i></div>
                            <div class="empty-title">Belum ada kegiatan</div>
                            <div class="empty-sub">Kegiatan yang kamu ikuti atau kelola akan muncul di sini</div>
                        </div>
                        <div class="skeleton-row medium"></div><div class="skeleton-row short"></div><div class="skeleton-row medium"></div>
                        <?php else: foreach(array_slice($kegiatan_list,0,4) as $k):?>
                        <div style="padding:10px 12px;background:var(--cream);border-radius:var(--r-sm);border:1px solid var(--border)">
                            <div style="font-size:.83rem;font-weight:700;color:var(--text-dark)"><?=e($k['nama_kegiatan'])?></div>
                            <div style="font-size:.72rem;color:var(--text-muted);margin-top:2px"><?=date('d M Y',strtotime($k['tanggal']))?> · <?=e($k['tempat'])?></div>
                            <span class="badge-status <?=strtolower($k['status'])?>" style="margin-top:5px"><?=e($k['status'])?></span>
                        </div>
                        <?php endforeach; endif;?>
                    </div>
                </div>
                <div class="panel">
                    <div class="panel-header">
                        <div class="panel-icon"><i class="bi bi-megaphone"></i></div>
                        <span class="panel-title">Pengumuman</span>
                        <span class="panel-count"><?=$nP?> baru</span>
                    </div>
                    <div class="panel-body">
                        <?php if(empty($pengumuman_list)):?>
                        <div class="skeleton-announcement"><div class="skeleton-dot"></div><div class="skeleton-lines"><div class="skeleton-row"></div><div class="skeleton-row short"></div></div></div>
                        <div class="skeleton-announcement"><div class="skeleton-dot"></div><div class="skeleton-lines"><div class="skeleton-row medium"></div><div class="skeleton-row short"></div></div></div>
                        <div style="text-align:center;padding:14px 0;font-size:.78rem;color:var(--text-muted)">Pengumuman akan tampil di sini</div>
                        <?php else: foreach(array_slice($pengumuman_list,0,3) as $p):?>
                        <div style="padding:10px 12px;background:var(--cream);border-radius:var(--r-sm);border:1px solid var(--border);border-left:3px solid var(--orange)">
                            <div style="font-size:.83rem;font-weight:700;color:var(--text-dark)"><?=e($p['judul'])?></div>
                            <div style="font-size:.72rem;color:var(--text-muted);margin-top:2px"><?=e($p['penulis']??'ORC')?> · <?=date('d M Y',strtotime($p['tanggal']))?></div>
                            <div style="font-size:.77rem;color:var(--text-mid);margin-top:4px;line-height:1.5"><?=e(mb_substr($p['konten'],0,80))?><?=mb_strlen($p['konten'])>80?'...':''?></div>
                        </div>
                        <?php endforeach; endif;?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ══════════════════════════
             TAB: PROFIL
        ══════════════════════════ -->
        <div class="tab-content <?=$tab==='profil'?'active':''?>">
            <div class="section-header"><h2>Profil & Pengaturan Akun</h2></div>
            <div class="profile-card">
                <div class="profile-avatar-big"><?=e($initials)?></div>
                <div style="margin-bottom:20px">
                    <div style="font-size:1.2rem;font-weight:800;color:var(--text-dark)"><?=e($user['nama'])?></div>
                    <div style="font-size:.82rem;color:var(--text-muted)"><?=e($user['email'])?> · <?=e($user['jabatan']??'Anggota')?></div>
                </div>
                <form action="<?=BASE_URL?>proccess/update_profile.php" method="POST">
                    <div class="form-row">
                        <div class="form-group">
                            <label>Nama Lengkap *</label>
                            <input type="text" name="nama" value="<?=e($user['nama'])?>" required>
                        </div>
                        <div class="form-group">
                            <label>NIM</label>
                            <input type="text" value="<?=e($user['nim']??'')?>" disabled style="background:var(--cream);color:var(--text-muted)">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" value="<?=e($user['email'])?>" disabled style="background:var(--cream);color:var(--text-muted)">
                        </div>
                        <div class="form-group">
                            <label>No. HP</label>
                            <input type="text" name="no_hp" value="<?=e($user['no_hp']??'')?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Jabatan</label>
                            <input type="text" name="jabatan" value="<?=e($user['jabatan']??'')?>">
                        </div>
                        <div class="form-group">
                            <label>Organisasi</label>
                            <input type="text" name="organisasi" value="<?=e($user['organisasi']??'')?>">
                        </div>
                    </div>
                    <div class="form-group" style="max-width:200px">
                        <label>Angkatan</label>
                        <input type="text" name="angkatan" value="<?=e($user['angkatan']??'')?>">
                    </div>
                    <div style="display:flex;gap:10px;margin-top:6px">
                        <button type="submit" class="btn-primary"><i class="bi bi-floppy"></i> Simpan Perubahan</button>
                        <button type="button" class="btn-sm-outline" onclick="document.getElementById('modalPassword').classList.add('open')"><i class="bi bi-lock"></i> Ganti Password</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ══════════════════════════
             TAB: KEGIATAN
        ══════════════════════════ -->
        <div class="tab-content <?=$tab==='kegiatan'?'active':''?>">
            <div class="section-header">
                <h2>Manajemen Kegiatan</h2>
                <button class="btn-primary" onclick="document.getElementById('modalKegiatan').classList.add('open')"><i class="bi bi-plus-lg"></i> Tambah Kegiatan</button>
            </div>
            <div class="panel">
                <?php if(empty($kegiatan_list)):?>
                <div class="empty-big">
                    <div class="e-icon-big"><i class="bi bi-calendar-x"></i></div>
                    <div class="e-title">Belum ada kegiatan</div>
                    <div class="e-sub">Tambahkan kegiatan pertama organisasimu sekarang!</div>
                    <button class="btn-primary" onclick="document.getElementById('modalKegiatan').classList.add('open')"><i class="bi bi-plus-lg"></i> Tambah Kegiatan</button>
                </div>
                <?php else:?>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>#</th><th>Nama Kegiatan</th><th>Jenis</th><th>Tanggal</th><th>Tempat</th><th>PJ</th><th>Status</th><th>Aksi</th></tr></thead>
                        <tbody>
                        <?php foreach($kegiatan_list as $i=>$k):?>
                        <tr>
                            <td><?=$i+1?></td>
                            <td style="font-weight:600"><?=e($k['nama_kegiatan'])?></td>
                            <td><?=e($k['jenis_kegiatan'])?></td>
                            <td><?=date('d M Y',strtotime($k['tanggal']))?></td>
                            <td><?=e($k['tempat'])?></td>
                            <td><?=e($k['penanggung_jawab'])?></td>
                            <td><span class="badge-status <?=strtolower($k['status'])?>"><?=e($k['status'])?></span></td>
                            <td>
                                <form method="POST" action="<?=BASE_URL?>proccess/kegiatan_process.php" style="display:inline">
                                    <input type="hidden" name="action" value="hapus">
                                    <input type="hidden" name="id" value="<?=$k['id_kegiatan']?>">
                                    <button type="submit" class="btn-danger" onclick="return confirm('Hapus kegiatan ini?')"><i class="bi bi-trash3"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <?php endif;?>
            </div>
        </div>

        <!-- ══════════════════════════
             TAB: ANGGOTA
        ══════════════════════════ -->
        <div class="tab-content <?=$tab==='anggota'?'active':''?>">
            <div class="section-header">
                <h2>Manajemen Anggota</h2>
                <button class="btn-primary" onclick="document.getElementById('modalAnggota').classList.add('open')"><i class="bi bi-person-plus"></i> Tambah Anggota</button>
            </div>
            <div class="panel">
                <?php if(empty($anggota_list)):?>
                <div class="empty-big">
                    <div class="e-icon-big"><i class="bi bi-person-slash"></i></div>
                    <div class="e-title">Belum ada anggota</div>
                    <div class="e-sub">Daftarkan anggota organisasimu sekarang.</div>
                    <button class="btn-primary" onclick="document.getElementById('modalAnggota').classList.add('open')"><i class="bi bi-person-plus"></i> Tambah Anggota</button>
                </div>
                <?php else:?>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>#</th><th>Nama</th><th>No. HP</th><th>Alamat</th><th>Tgl Daftar</th><th>Aksi</th></tr></thead>
                        <tbody>
                        <?php foreach($anggota_list as $i=>$a):?>
                        <tr>
                            <td><?=$i+1?></td>
                            <td style="font-weight:600"><?=e($a['nama'])?></td>
                            <td><?=e($a['no_hp'])?></td>
                            <td><?=e($a['alamat'])?></td>
                            <td><?=date('d M Y',strtotime($a['tanggal_daftar']))?></td>
                            <td>
                                <form method="POST" action="<?=BASE_URL?>proccess/anggota_process.php" style="display:inline">
                                    <input type="hidden" name="action" value="hapus">
                                    <input type="hidden" name="id" value="<?=$a['id_anggota']?>">
                                    <button type="submit" class="btn-danger" onclick="return confirm('Hapus anggota ini?')"><i class="bi bi-trash3"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <?php endif;?>
            </div>
        </div>

        <!-- ══════════════════════════
             TAB: DOKUMEN
        ══════════════════════════ -->
        <div class="tab-content <?=$tab==='dokumen'?'active':''?>">
            <div class="section-header">
                <h2>Manajemen Dokumen</h2>
                <button class="btn-primary" onclick="document.getElementById('modalDokumen').classList.add('open')"><i class="bi bi-upload"></i> Upload Dokumen</button>
            </div>
            <div class="panel">
                <?php if(empty($dokumen_list)):?>
                <div class="empty-big">
                    <div class="e-icon-big"><i class="bi bi-file-earmark-x"></i></div>
                    <div class="e-title">Belum ada dokumen</div>
                    <div class="e-sub">Upload dokumen organisasimu — PDF, Word, Excel, dan lainnya.</div>
                    <button class="btn-primary" onclick="document.getElementById('modalDokumen').classList.add('open')"><i class="bi bi-upload"></i> Upload Dokumen</button>
                </div>
                <?php else:?>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>#</th><th>Judul</th><th>Jenis</th><th>Tanggal Upload</th><th>Aksi</th></tr></thead>
                        <tbody>
                        <?php foreach($dokumen_list as $i=>$d):?>
                        <tr>
                            <td><?=$i+1?></td>
                            <td style="font-weight:600"><?=e($d['judul'])?></td>
                            <td><?=e($d['jenis'])?></td>
                            <td><?=date('d M Y',strtotime($d['tanggal_upload']))?></td>
                            <td style="display:flex;gap:6px;align-items:center">
                                <a href="<?=BASE_URL.e($d['file'])?>" download class="btn-sm-outline"><i class="bi bi-download"></i></a>
                                <form method="POST" action="<?=BASE_URL?>proccess/dokumen_process.php" style="display:inline">
                                    <input type="hidden" name="action" value="hapus">
                                    <input type="hidden" name="id" value="<?=$d['id_dokumen']?>">
                                    <button type="submit" class="btn-danger" onclick="return confirm('Hapus dokumen ini?')"><i class="bi bi-trash3"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <?php endif;?>
            </div>
        </div>

        <!-- ══════════════════════════
             TAB: PENGUMUMAN
        ══════════════════════════ -->
        <div class="tab-content <?=$tab==='pengumuman'?'active':''?>">
            <div class="section-header">
                <h2>Manajemen Pengumuman</h2>
                <button class="btn-primary" onclick="document.getElementById('modalPengumuman').classList.add('open')"><i class="bi bi-megaphone"></i> Buat Pengumuman</button>
            </div>
            <div class="panel">
                <?php if(empty($pengumuman_list)):?>
                <div class="empty-big">
                    <div class="e-icon-big"><i class="bi bi-megaphone"></i></div>
                    <div class="e-title">Belum ada pengumuman</div>
                    <div class="e-sub">Buat pengumuman untuk anggota organisasimu.</div>
                    <button class="btn-primary" onclick="document.getElementById('modalPengumuman').classList.add('open')"><i class="bi bi-megaphone"></i> Buat Pengumuman</button>
                </div>
                <?php else:?>
                <div class="table-wrap">
                    <table>
                        <thead><tr><th>#</th><th>Judul</th><th>Konten</th><th>Target</th><th>Oleh</th><th>Tanggal</th><th>Aksi</th></tr></thead>
                        <tbody>
                        <?php foreach($pengumuman_list as $i=>$p):?>
                        <tr>
                            <td><?=$i+1?></td>
                            <td style="font-weight:600"><?=e($p['judul'])?></td>
                            <td style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?=e($p['konten'])?></td>
                            <td><?=e($p['target_role']??'semua')?></td>
                            <td><?=e($p['penulis']??'—')?></td>
                            <td><?=date('d M Y',strtotime($p['tanggal']))?></td>
                            <td>
                                <?php if((int)$p['user_id']===$uid):?>
                                <form method="POST" action="<?=BASE_URL?>proccess/pengumuman_process.php" style="display:inline">
                                    <input type="hidden" name="action" value="hapus">
                                    <input type="hidden" name="id" value="<?=$p['pengumuman_id']?>">
                                    <button type="submit" class="btn-danger" onclick="return confirm('Hapus pengumuman ini?')"><i class="bi bi-trash3"></i></button>
                                </form>
                                <?php else:?><span style="font-size:.72rem;color:var(--text-muted)">—</span><?php endif;?>
                            </td>
                        </tr>
                        <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <?php endif;?>
            </div>
        </div>

    </main>
</div>

<!-- ══════════════════════════════
     MODALS
══════════════════════════════ -->

<!-- Modal: Tambah Kegiatan -->
<div class="modal-backdrop" id="modalKegiatan">
<div class="modal-box">
    <div class="modal-title"><i class="bi bi-calendar-plus"></i> Tambah Kegiatan</div>
    <button class="modal-close" onclick="closeModal('modalKegiatan')"><i class="bi bi-x"></i></button>
    <form method="POST" action="<?=BASE_URL?>proccess/kegiatan_process.php">
        <input type="hidden" name="action" value="tambah">
        <div class="form-row">
            <div class="form-group"><label>Nama Kegiatan *</label><input type="text" name="nama_kegiatan" required placeholder="Contoh: Rapat Bulanan BEM"></div>
            <div class="form-group"><label>Organisasi *</label>
                <select name="organisasi" required>
                    <option value="BEM" <?= ($_SESSION['organisasi']??'')==='BEM'?'selected':'' ?>>BEM</option>
                    <option value="HERO" <?= ($_SESSION['organisasi']??'')==='HERO'?'selected':'' ?>>HERO</option>
                    <option value="HCC" <?= ($_SESSION['organisasi']??'')==='HCC'?'selected':'' ?>>HCC</option>
                    <option value="ARATTA" <?= ($_SESSION['organisasi']??'')==='ARATTA'?'selected':'' ?>>ARATTA</option>
                    <option value="Wirausaha">Wirausaha</option>
                    <option value="Umum">Umum</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Jenis Kegiatan *</label>
                <select name="jenis_kegiatan" required>
                    <option value="">Pilih jenis...</option>
                    <option>Rapat</option><option>Lomba</option><option>Seminar</option>
                    <option>Workshop</option><option>Bakti Sosial</option><option>Lainnya</option>
                </select>
            </div>
            <div class="form-group"><label>Tanggal *</label><input type="date" name="tanggal" required value="<?=date('Y-m-d')?>"></div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Waktu</label><input type="time" name="waktu" value="08:00"></div>
            <div class="form-group"><label>Tempat *</label><input type="text" name="tempat" required placeholder="Gedung A / Online"></div>
        </div>
        <div class="form-group"><label>Penanggung Jawab</label><input type="text" name="penanggung_jawab" value="<?=e($user['nama'])?>"></div>
        <div class="form-group"><label>Deskripsi</label><textarea name="deskripsi" placeholder="Keterangan singkat kegiatan..."></textarea></div>
        <div class="form-actions">
            <button type="button" class="btn-cancel" onclick="closeModal('modalKegiatan')">Batal</button>
            <button type="submit" class="btn-primary"><i class="bi bi-check-lg"></i> Simpan Kegiatan</button>
        </div>
    </form>
</div>
</div>

<!-- Modal: Tambah Anggota -->
<div class="modal-backdrop" id="modalAnggota">
<div class="modal-box">
    <div class="modal-title"><i class="bi bi-person-plus"></i> Tambah Anggota</div>
    <button class="modal-close" onclick="closeModal('modalAnggota')"><i class="bi bi-x"></i></button>
    <form method="POST" action="<?=BASE_URL?>proccess/anggota_process.php">
        <input type="hidden" name="action" value="tambah">
        <div class="form-group"><label>Nama Lengkap *</label><input type="text" name="nama" required placeholder="Nama anggota"></div>
        <div class="form-row">
            <div class="form-group"><label>Organisasi *</label>
                <select name="organisasi" required>
                    <option value="BEM" <?= ($_SESSION['organisasi']??'')==='BEM'?'selected':'' ?>>BEM</option>
                    <option value="HERO" <?= ($_SESSION['organisasi']??'')==='HERO'?'selected':'' ?>>HERO</option>
                    <option value="HCC" <?= ($_SESSION['organisasi']??'')==='HCC'?'selected':'' ?>>HCC</option>
                    <option value="ARATTA" <?= ($_SESSION['organisasi']??'')==='ARATTA'?'selected':'' ?>>ARATTA</option>
                    <option value="Wirausaha">Wirausaha</option>
                    <option value="Umum">Umum</option>
                </select>
            </div>
            <div class="form-group"><label>Jabatan</label>
                <select name="jabatan">
                    <option value="Anggota">Anggota</option>
                    <option value="Pengurus">Pengurus</option>
                    <option value="Ketua">Ketua</option>
                    <option value="Wakil Ketua">Wakil Ketua</option>
                    <option value="Sekretaris">Sekretaris</option>
                    <option value="Bendahara">Bendahara</option>
                </select>
            </div>
        </div>
        <div class="form-group"><label>No. HP *</label><input type="text" name="no_hp" required placeholder="08xx-xxxx-xxxx"></div>
        <div class="form-group"><label>Alamat *</label><textarea name="alamat" required placeholder="Alamat lengkap anggota"></textarea></div>
        <div class="form-group"><label>Tanggal Daftar</label><input type="date" name="tanggal_daftar" value="<?=date('Y-m-d')?>"></div>
        <div class="form-actions">
            <button type="button" class="btn-cancel" onclick="closeModal('modalAnggota')">Batal</button>
            <button type="submit" class="btn-primary"><i class="bi bi-check-lg"></i> Simpan Anggota</button>
        </div>
    </form>
</div>
</div>

<!-- Modal: Upload Dokumen -->
<div class="modal-backdrop" id="modalDokumen">
<div class="modal-box">
    <div class="modal-title"><i class="bi bi-file-earmark-arrow-up"></i> Upload Dokumen</div>
    <button class="modal-close" onclick="closeModal('modalDokumen')"><i class="bi bi-x"></i></button>
    <form method="POST" action="<?=BASE_URL?>proccess/dokumen_process.php" enctype="multipart/form-data">
        <input type="hidden" name="action" value="upload">
        <div class="form-group"><label>Judul Dokumen *</label><input type="text" name="judul" required placeholder="Contoh: LPJ Semester Ganjil 2025"></div>
        <div class="form-group"><label>Jenis Dokumen *</label>
            <select name="jenis" required>
                <option value="">Pilih jenis...</option>
                <option>LPJ</option><option>Proposal</option><option>Notulensi</option>
                <option>Surat</option><option>Anggaran</option><option>Lainnya</option>
            </select>
        </div>
        <div class="form-group">
            <label>File * <span style="color:var(--text-muted);font-weight:400">(PDF, DOC, XLS, PPT, JPG, ZIP — maks 10MB)</span></label>
            <input type="file" name="file" required accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.zip">
        </div>
        <div class="form-actions">
            <button type="button" class="btn-cancel" onclick="closeModal('modalDokumen')">Batal</button>
            <button type="submit" class="btn-primary"><i class="bi bi-upload"></i> Upload Dokumen</button>
        </div>
    </form>
</div>
</div>

<!-- Modal: Buat Pengumuman -->
<div class="modal-backdrop" id="modalPengumuman">
<div class="modal-box">
    <div class="modal-title"><i class="bi bi-megaphone"></i> Buat Pengumuman</div>
    <button class="modal-close" onclick="closeModal('modalPengumuman')"><i class="bi bi-x"></i></button>
    <form method="POST" action="<?=BASE_URL?>proccess/pengumuman_process.php">
        <input type="hidden" name="action" value="tambah">
        <div class="form-group"><label>Judul *</label><input type="text" name="judul" required placeholder="Judul pengumuman"></div>
        <div class="form-group"><label>Konten Pengumuman *</label><textarea name="konten" required placeholder="Tulis isi pengumuman di sini..." style="min-height:120px"></textarea></div>
        <div class="form-group"><label>Target Penerima</label>
            <select name="target_role">
                <option value="semua">Semua</option>
                <option value="anggota">Anggota</option>
                <option value="pengurus">Pengurus</option>
                <option value="pembina">Pembina</option>
            </select>
        </div>
        <div class="form-actions">
            <button type="button" class="btn-cancel" onclick="closeModal('modalPengumuman')">Batal</button>
            <button type="submit" class="btn-primary"><i class="bi bi-send"></i> Publikasikan</button>
        </div>
    </form>
</div>
</div>

<!-- Modal: Ganti Password -->
<div class="modal-backdrop" id="modalPassword">
<div class="modal-box">
    <div class="modal-title"><i class="bi bi-lock"></i> Ganti Password</div>
    <button class="modal-close" onclick="closeModal('modalPassword')"><i class="bi bi-x"></i></button>
    <form method="POST" action="<?=BASE_URL?>proccess/update_password.php">
        <div class="form-group"><label>Password Lama *</label><input type="password" name="old_password" required placeholder="••••••••"></div>
        <div class="form-group"><label>Password Baru * <span style="font-weight:400;color:var(--text-muted)">(min. 6 karakter)</span></label><input type="password" name="new_password" required placeholder="••••••••"></div>
        <div class="form-group"><label>Konfirmasi Password Baru *</label><input type="password" name="confirm_password" required placeholder="••••••••"></div>
        <div class="form-actions">
            <button type="button" class="btn-cancel" onclick="closeModal('modalPassword')">Batal</button>
            <button type="submit" class="btn-primary"><i class="bi bi-floppy"></i> Simpan Password</button>
        </div>
    </form>
</div>
</div>

<!-- ══ TOAST ══ -->
<?php
$is_signin   = ($from==='signin');
$toast_title = $is_signin ? 'Pendaftaran berhasil! 🎉' : 'Login berhasil!';
$toast_msg   = $is_signin
    ? 'Selamat datang di ORC, '.e($user['nama']).'! Akun Anda sudah aktif.'
    : 'Selamat datang kembali, '.e($first_name).'! Semangat berorganisasi!';
$show_toast  = in_array($from, ['signin','login']);
?>
<?php if($show_toast):?>
<div class="toast <?=$is_signin?'signin-toast':''?>" id="toastNotif">
    <div class="toast-icon"><i class="bi <?=$is_signin?'bi-stars':'bi-emoji-smile'?>"></i></div>
    <div class="toast-content">
        <div class="toast-title"><?=$toast_title?></div>
        <div class="toast-msg"><?=$toast_msg?></div>
    </div>
    <span class="toast-close" id="toastClose"><i class="bi bi-x-lg"></i></span>
</div>
<?php endif;?>

<script>
// Modal helpers
function closeModal(id) { document.getElementById(id).classList.remove('open'); }
document.querySelectorAll('.modal-backdrop').forEach(m => {
    m.addEventListener('click', e => { if (e.target === m) m.classList.remove('open'); });
});

// Toast
const toast = document.getElementById('toastNotif');
const tClose = document.getElementById('toastClose');
if (toast) {
    let t = setTimeout(() => dismissToast(), 5000);
    function dismissToast() {
        toast.style.animation = 'toastOut .32s ease forwards';
        setTimeout(() => toast.remove(), 340);
    }
    tClose?.addEventListener('click', dismissToast);
    toast.addEventListener('click', dismissToast);
}

// Sidebar toggle (mobile)
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebarOverlay');
const hamBtn  = document.getElementById('hamburgerBtn');
hamBtn?.addEventListener('click', () => { sidebar.classList.toggle('open'); overlay.classList.toggle('open'); });
overlay?.addEventListener('click', () => { sidebar.classList.remove('open'); overlay.classList.remove('open'); });

// Flash auto-remove
setTimeout(() => document.querySelectorAll('.flash').forEach(f => { f.style.opacity=0; setTimeout(()=>f.remove(),400); }), 4000);
</script>

<?php $page_js = []; require_once '../../components/footer_scripts.php'; ?>
</body>
</html>
