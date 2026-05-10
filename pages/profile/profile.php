<?php
// pages/profile/profile.php
require_once '../../config/connection.php';

// Data user (nantinya dari session/database)
$nama       = $_SESSION['nama']      ?? 'MBPP';
$jabatan    = $_SESSION['jabatan']   ?? 'Pengurus';
$kampus     = 'Institut Teknologi Bacharuddin Jusuf Habibie';
$nim        = $_SESSION['nim']       ?? '241011005';
$email      = $_SESSION['email']     ?? 'user@gmail.com';
$nohp       = '08123456789';
$organisasi = 'HIMAKOM';
$angkatan   = '2024';
$status     = 'Aktif';

$dokumen = [
    ['nama' => 'Proposal Seminar', 'kategori' => 'Proposal', 'tanggal' => '12 Mei 2025'],
    ['nama' => 'LPJ Kegiatan',    'kategori' => 'LPJ',      'tanggal' => '10 Mei 2025'],
    ['nama' => 'Materi Workshop',  'kategori' => 'Materi',   'tanggal' => '08 Mei 2025'],
];

$kegiatan = [
    ['nama' => 'Seminar Nasional', 'peran' => 'Panitia',  'status' => 'Selesai'],
    ['nama' => 'Workshop',         'peran' => 'Peserta',  'status' => 'Terjadwal'],
    ['nama' => 'Pelatihan',        'peran' => 'Panitia',  'status' => 'Selesai'],
];

$sidebar_active = 'profil';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya — ORC ORMAWA ITH</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/profile.css">
</head>
<body>

<div class="container">

    <!-- ═══════════════════════
         SIDEBAR
    ═══════════════════════ -->
    <?php require_once '../../components/sidebar.php'; ?>

    <!-- ═══════════════════════
         MAIN CONTENT
    ═══════════════════════ -->
    <main class="main">

        <!-- TOPBAR -->
        <div class="topbar">
            <h2>Profil Saya</h2>
            <div class="top-right">
                <i class="fa-solid fa-bell"></i>
                <div class="mini-profile">
                    <img
                        src="<?= BASE_URL ?>assets/img/profile/default.png"
                        alt="Foto profil"
                        onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($nama) ?>&background=C85C1A&color=fff&size=60'"
                    >
                    <div>
                        <h4><?= htmlspecialchars($nama) ?></h4>
                        <span><?= htmlspecialchars($jabatan) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- PROFILE CARD -->
        <div class="profile-card">
            <div class="profile-left">
                <div class="profile-image">
                    <img
                        src="<?= BASE_URL ?>assets/img/profile/default.png"
                        alt="Foto profil"
                        onerror="this.src='https://ui-avatars.com/api/?name=<?= urlencode($nama) ?>&background=C85C1A&color=fff&size=180'"
                    >
                    <div class="camera-icon">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                </div>
                <div class="profile-info">
                    <h1><?= htmlspecialchars($nama) ?></h1>
                    <h3><?= htmlspecialchars($jabatan) ?></h3>
                    <p><i class="fa-solid fa-graduation-cap"></i> <?= htmlspecialchars($kampus) ?></p>
                </div>
            </div>
            <div class="button-group">
                <button class="btn"><i class="fa-regular fa-pen-to-square"></i> Edit Profil</button>
                <button class="btn"><i class="fa-solid fa-lock"></i> Ganti Password</button>
            </div>
        </div>

        <!-- GRID 4 KARTU -->
        <div class="grid">

            <!-- Informasi Pribadi -->
            <div class="card">
                <div class="card-header">
                    <div class="title">
                        <i class="fa-regular fa-circle-user"></i>
                        <h3>Informasi Pribadi</h3>
                    </div>
                </div>
                <div class="info-list">
                    <?php
                    $info = [
                        'Nama Lengkap' => $nama,
                        'NIM'          => $nim,
                        'Email'        => $email,
                        'No HP'        => $nohp,
                        'Jabatan'      => $jabatan,
                        'Organisasi'   => $organisasi,
                        'Angkatan'     => $angkatan,
                    ];
                    foreach ($info as $label => $val): ?>
                    <div class="info-item">
                        <span><?= $label ?></span>
                        <p><?= htmlspecialchars($val) ?></p>
                    </div>
                    <?php endforeach; ?>
                    <div class="info-item">
                        <span>Status</span>
                        <p class="status-active"><?= htmlspecialchars($status) ?></p>
                    </div>
                </div>
            </div>

            <!-- Dokumen -->
            <div class="card">
                <div class="card-header">
                    <div class="title">
                        <i class="fa-solid fa-folder"></i>
                        <h3>Dokumen Saya</h3>
                    </div>
                    <input type="text" placeholder="Cari Dokumen" id="searchDokumen">
                </div>
                <table>
                    <thead>
                        <tr><th>Dokumen</th><th>Kategori</th><th>Tanggal</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dokumen as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nama']) ?></td>
                            <td><span class="badge"><?= htmlspecialchars($item['kategori']) ?></span></td>
                            <td><?= htmlspecialchars($item['tanggal']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Kegiatan -->
            <div class="card">
                <div class="card-header">
                    <div class="title">
                        <i class="fa-regular fa-clipboard"></i>
                        <h3>Kegiatan Saya</h3>
                    </div>
                    <span class="lihat">Lihat Semua</span>
                </div>
                <table>
                    <thead>
                        <tr><th>Kegiatan</th><th>Peran</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($kegiatan as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['nama']) ?></td>
                            <td><?= htmlspecialchars($item['peran']) ?></td>
                            <td>
                                <span class="<?= $item['status'] === 'Selesai' ? 'done' : 'schedule' ?>">
                                    <?= htmlspecialchars($item['status']) ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pengaturan -->
            <div class="card">
                <div class="card-header">
                    <div class="title">
                        <i class="fa-solid fa-gear"></i>
                        <h3>Pengaturan Akun</h3>
                    </div>
                </div>
                <div class="setting-item">
                    <div><h4>Ubah Profil</h4><p>Perbarui informasi profil</p></div>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
                <div class="setting-item">
                    <div><h4>Ubah Password</h4><p>Ganti password akun</p></div>
                    <i class="fa-solid fa-chevron-right"></i>
                </div>
                <a href="<?= BASE_URL ?>proccess/logout.php" class="setting-item logout-setting" style="text-decoration:none;display:flex;justify-content:space-between;align-items:center;padding:22px;border-top:1px solid #eee;">
                    <div><h4>Keluar Akun</h4><p>Logout dari sistem</p></div>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </div>

        </div><!-- /.grid -->

    </main>
</div>

<script src="<?= BASE_URL ?>assets/js/profile.js"></script>
</body>
</html>
