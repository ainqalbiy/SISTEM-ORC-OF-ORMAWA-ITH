<?php
// pages/profile/profile.php
require_once '../../config/connection.php';
require_login(); // Redirect ke login jika belum masuk

// Ambil data user terbaru dari database
$uid  = (int)$_SESSION['user_id'];
$pk_col = get_user_pk($conn);
$stmt = $conn->prepare("SELECT * FROM users WHERE `$pk_col` = ? LIMIT 1");
$stmt->bind_param('i', $uid);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$user) {
    // User tidak ditemukan — hapus session dan redirect
    session_destroy();
    header('Location: ' . BASE_URL . 'pages/login/login.php');
    exit;
}

// Dokumen milik user (dari DB, atau contoh jika kosong)
$stmt_dok = $conn->prepare("SELECT * FROM dokumen WHERE user_id = ? ORDER BY tanggal_upload DESC LIMIT 10");
$stmt_dok->bind_param('i', $uid);
$stmt_dok->execute();
$dokumen_rows = $stmt_dok->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt_dok->close();

// Kegiatan (tampilkan 4 terbaru — karena kegiatan global, tidak per-user di versi ini)
$stmt_keg = $conn->query("SELECT * FROM kegiatan ORDER BY tanggal DESC LIMIT 4");
$kegiatan_rows = $stmt_keg ? $stmt_keg->fetch_all(MYSQLI_ASSOC) : [];

// Pesan sukses update profil
$success_msg = '';
if (isset($_GET['updated']) && $_GET['updated'] === '1') {
    $success_msg = 'Profil berhasil diperbarui!';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya – ORC</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/profile.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .modal-overlay { display:none; position:fixed; inset:0; background:rgba(0,0,0,.5); z-index:1000; align-items:center; justify-content:center; }
        .modal-overlay.open { display:flex; }
        .modal-box { background:#fff; border-radius:1.5rem; padding:2rem; width:90%; max-width:480px; box-shadow:0 20px 60px rgba(0,0,0,.2); }
        .modal-box h3 { font-size:1.25rem; font-weight:700; margin-bottom:1rem; color:#7c3aed; }
        .modal-box label { font-size:.85rem; color:#555; margin-bottom:.3rem; display:block; }
        .modal-box input, .modal-box select { width:100%; padding:.7rem 1rem; border:1px solid #ddd; border-radius:.75rem; font-size:.9rem; margin-bottom:.9rem; }
        .modal-box input:focus, .modal-box select:focus { outline:none; border-color:#f97316; }
        .btn-save { background:#f97316; color:#fff; border:none; padding:.75rem 2rem; border-radius:999px; font-weight:600; cursor:pointer; }
        .btn-save:hover { background:#ea6b0a; }
        .btn-cancel { background:#e5e7eb; color:#374151; border:none; padding:.75rem 1.5rem; border-radius:999px; font-weight:600; cursor:pointer; margin-left:.5rem; }
        .alert-success { background:#d1fae5; border:1px solid #6ee7b7; color:#065f46; padding:.75rem 1rem; border-radius:.75rem; margin-bottom:1rem; font-size:.875rem; }
    </style>
</head>
<body>

<div class="container">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="logo">
            <h1>ORC</h1>
            <p>Organization Resource Center<br>of ORMAWA ITH</p>
        </div>
        <ul class="menu">
            <li class="active"><i class="fa-regular fa-circle-user"></i><span>Profil Saya</span></li>
            <li><a href="<?= BASE_URL ?>pages/homepage/homepage.php" style="display:flex;align-items:center;gap:.75rem;color:inherit;text-decoration:none"><i class="fa-solid fa-house"></i><span>Beranda</span></a></li>
            <li><a href="<?= BASE_URL ?>pages/organisasi/organisasi.php" style="display:flex;align-items:center;gap:.75rem;color:inherit;text-decoration:none"><i class="fa-solid fa-users"></i><span>Organisasi</span></a></li>
            <li><i class="fa-regular fa-clipboard"></i><span>Kegiatan</span></li>
            <li><i class="fa-solid fa-folder"></i><span>Dokumen</span></li>
        </ul>
        <a href="<?= BASE_URL ?>proccess/logout.php" class="logout-btn" title="Keluar">
            <i class="fa-solid fa-right-from-bracket"></i>
        </a>
    </aside>

    <!-- MAIN -->
    <main class="main-content">

        <!-- HEADER -->
        <header class="topbar">
            <h2>Profil Saya</h2>
            <div class="top-right">
                <i class="fa-solid fa-bell"></i>
                <div class="profile-mini">
                    <?php if (!empty($user['foto'])): ?>
                      <img src="<?= e($user['foto']) ?>" alt="">
                    <?php else: ?>
                      <div style="width:36px;height:36px;border-radius:50%;background:#f97316;display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:.9rem;">
                        <?= mb_strtoupper(mb_substr($user['nama'], 0, 1)) ?>
                      </div>
                    <?php endif; ?>
                    <div>
                        <h4><?= e($user['nama']) ?></h4>
                        <p><?= e($user['jabatan'] ?? 'Anggota') ?></p>
                    </div>
                </div>
                <i class="fa-solid fa-angle-down"></i>
            </div>
        </header>

        <?php if ($success_msg): ?>
          <div class="alert-success" style="margin:0 0 1rem;">
            <i class="fas fa-check-circle"></i> <?= e($success_msg) ?>
          </div>
        <?php endif; ?>

        <!-- PROFILE CARD -->
        <section class="profile-card">
            <div class="profile-left">
                <div class="img-box">
                    <?php if (!empty($user['foto'])): ?>
                      <img src="<?= e($user['foto']) ?>" alt="Foto Profil">
                    <?php else: ?>
                      <div style="width:100%;height:100%;background:linear-gradient(135deg,#f97316,#ea580c);display:flex;align-items:center;justify-content:center;color:#fff;font-size:2.5rem;font-weight:700;border-radius:50%;">
                        <?= mb_strtoupper(mb_substr($user['nama'], 0, 1)) ?>
                      </div>
                    <?php endif; ?>
                    <div class="camera" onclick="document.getElementById('modalEditProfil').classList.add('open')">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                </div>
                <div class="profile-info">
                    <h1><?= e($user['nama']) ?></h1>
                    <h2><?= e($user['jabatan'] ?? 'Anggota') ?></h2>
                    <p><i class="fa-solid fa-graduation-cap"></i> Institut Teknologi Bacharuddin Jusuf Habibie</p>
                </div>
            </div>
            <div class="profile-actions">
                <button class="edit-btn" onclick="document.getElementById('modalEditProfil').classList.add('open')">
                    <i class="fa-regular fa-pen-to-square"></i> Edit Profil
                </button>
                <button class="pass-btn" onclick="document.getElementById('modalUbahPassword').classList.add('open')">
                    <i class="fa-solid fa-lock"></i> Ganti Password
                </button>
            </div>
        </section>

        <!-- GRID -->
        <section class="grid-layout">

            <!-- INFORMASI PRIBADI -->
            <div class="card">
                <div class="card-header">
                    <h3><i class="fa-regular fa-circle-user"></i> Informasi Pribadi</h3>
                </div>
                <div class="info-list">
                    <div class="info-item"><span>Nama Lengkap</span><p><?= e($user['nama']) ?></p></div>
                    <div class="info-item"><span>NIM</span><p><?= e($user['nim'] ?? '-') ?></p></div>
                    <div class="info-item"><span>Email</span><p><?= e($user['email']) ?></p></div>
                    <div class="info-item"><span>No. HP</span><p><?= e($user['no_hp'] ?? '-') ?></p></div>
                    <div class="info-item"><span>Jabatan</span><p><?= e($user['jabatan'] ?? 'Anggota') ?></p></div>
                    <div class="info-item"><span>Organisasi</span><p><?= e($user['organisasi'] ?? '-') ?></p></div>
                    <div class="info-item"><span>Angkatan</span><p><?= e($user['angkatan'] ?? '-') ?></p></div>
                    <div class="info-item"><span>Status</span><p class="aktif"><?= e($user['status'] ?? 'Aktif') ?></p></div>
                </div>
            </div>

            <!-- DOKUMEN -->
            <div class="card">
                <div class="card-header between">
                    <h3><i class="fa-solid fa-folder-open"></i> Dokumen Saya</h3>
                    <input type="text" id="searchDok" placeholder="Cari Dokumen..." oninput="filterDokumen(this.value)">
                </div>
                <table id="tabelDokumen">
                    <tr><th>Nama Dokumen</th><th>Kategori</th><th>Tanggal</th><th>Aksi</th></tr>
                    <?php if (empty($dokumen_rows)): ?>
                    <tr><td colspan="4" style="text-align:center;color:#999;padding:1rem;">Belum ada dokumen</td></tr>
                    <?php else: ?>
                    <?php foreach ($dokumen_rows as $d): ?>
                    <tr>
                        <td><?= e($d['judul']) ?></td>
                        <td><span class="badge"><?= e($d['jenis']) ?></span></td>
                        <td><?= date('d M Y', strtotime($d['tanggal_upload'])) ?></td>
                        <td><a href="<?= BASE_URL . e($d['file']) ?>" download><i class="fa-solid fa-download"></i></a></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </div>

            <!-- KEGIATAN -->
            <div class="card">
                <div class="card-header between">
                    <h3><i class="fa-regular fa-clipboard"></i> Kegiatan Terbaru</h3>
                    <a href="#">Lihat Semua</a>
                </div>
                <table>
                    <tr><th>Nama Kegiatan</th><th>Jenis</th><th>Tanggal</th><th>Status</th></tr>
                    <?php if (empty($kegiatan_rows)): ?>
                    <tr><td colspan="4" style="text-align:center;color:#999;padding:1rem;">Belum ada kegiatan</td></tr>
                    <?php else: ?>
                    <?php foreach ($kegiatan_rows as $k): ?>
                    <tr>
                        <td><?= e($k['nama_kegiatan']) ?></td>
                        <td><?= e($k['jenis_kegiatan']) ?></td>
                        <td><?= date('d M Y', strtotime($k['tanggal'])) ?></td>
                        <td><span class="status"><?= e($k['status']) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </table>
            </div>

            <!-- PENGATURAN -->
            <div class="card setting-card">
                <div class="card-header">
                    <h3><i class="fa-solid fa-gear"></i> Pengaturan Akun</h3>
                </div>
                <div class="setting-item" onclick="document.getElementById('modalEditProfil').classList.add('open')" style="cursor:pointer;">
                    <div><h4>Ubah Profil</h4><p>Perbarui informasi profil Anda</p></div>
                    <i class="fa-solid fa-angle-right"></i>
                </div>
                <div class="setting-item" onclick="document.getElementById('modalUbahPassword').classList.add('open')" style="cursor:pointer;">
                    <div><h4>Ubah Password</h4><p>Ganti password akun Anda</p></div>
                    <i class="fa-solid fa-angle-right"></i>
                </div>
                <div class="setting-item logout-text" style="cursor:pointer;"
                     onclick="if(confirm('Yakin ingin keluar?')) window.location='<?= BASE_URL ?>proccess/logout.php'">
                    <div><h4>Keluar Akun</h4><p>Logout dari sistem ORC</p></div>
                    <i class="fa-solid fa-angle-right"></i>
                </div>
            </div>

        </section>
    </main>
</div>

<!-- ===== MODAL: Edit Profil ===== -->
<div class="modal-overlay" id="modalEditProfil">
  <div class="modal-box">
    <h3><i class="fas fa-user-edit" style="color:#f97316"></i> Edit Profil</h3>
    <form action="<?= BASE_URL ?>proccess/update_profile.php" method="POST">
      <label>Nama Lengkap</label>
      <input type="text" name="nama" value="<?= e($user['nama']) ?>" required>
      <label>No. HP</label>
      <input type="text" name="no_hp" value="<?= e($user['no_hp'] ?? '') ?>" placeholder="0812 xxxx xxxx">
      <label>Jabatan</label>
      <input type="text" name="jabatan" value="<?= e($user['jabatan'] ?? '') ?>">
      <label>Organisasi</label>
      <input type="text" name="organisasi" value="<?= e($user['organisasi'] ?? '') ?>" placeholder="Nama organisasi">
      <label>Angkatan</label>
      <input type="text" name="angkatan" value="<?= e($user['angkatan'] ?? '') ?>" placeholder="Contoh: 2024">
      <div style="display:flex;gap:.5rem;justify-content:flex-end;margin-top:.5rem;">
        <button type="button" class="btn-cancel" onclick="document.getElementById('modalEditProfil').classList.remove('open')">Batal</button>
        <button type="submit" class="btn-save">Simpan</button>
      </div>
    </form>
  </div>
</div>

<!-- ===== MODAL: Ubah Password ===== -->
<div class="modal-overlay" id="modalUbahPassword">
  <div class="modal-box">
    <h3><i class="fas fa-lock" style="color:#f97316"></i> Ubah Password</h3>
    <form action="<?= BASE_URL ?>proccess/update_password.php" method="POST">
      <label>Password Lama</label>
      <input type="password" name="old_password" required placeholder="Masukkan password lama">
      <label>Password Baru</label>
      <input type="password" name="new_password" required placeholder="Min. 6 karakter">
      <label>Konfirmasi Password Baru</label>
      <input type="password" name="confirm_password" required placeholder="Ulangi password baru">
      <div style="display:flex;gap:.5rem;justify-content:flex-end;margin-top:.5rem;">
        <button type="button" class="btn-cancel" onclick="document.getElementById('modalUbahPassword').classList.remove('open')">Batal</button>
        <button type="submit" class="btn-save">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
  // Tutup modal jika klik di luar
  document.querySelectorAll('.modal-overlay').forEach(m => {
    m.addEventListener('click', function(e) {
      if (e.target === this) this.classList.remove('open');
    });
  });

  // Filter dokumen
  function filterDokumen(q) {
    const rows = document.querySelectorAll('#tabelDokumen tr:not(:first-child)');
    rows.forEach(r => {
      r.style.display = r.textContent.toLowerCase().includes(q.toLowerCase()) ? '' : 'none';
    });
  }
</script>

<script src="<?= BASE_URL ?>assets/js/profile.js"></script>
</body>
</html>
