<?php
session_start();

// Data user sementara
$user = [
    "nama" => "MPBB",
    "role" => "Pengurus",
    "kampus" => "Institut Teknologi Bacharuddin Jusuf Habibie",
    "nim" => "241011005",
    "email" => "aprilianti.saputri@gmail.com",
    "hp" => "0812 3456 7890",
    "jabatan" => "Sekretaris",
    "organisasi" => "HIMAKOM",
    "angkatan" => "2024",
    "status" => "Aktif",
    "foto" => "https://i.pravatar.cc/300"
];

$dokumen = [
    ["Proposal Seminar Nasional","Proposal","12 MEI 2025"],
    ["LPJ Kegiatan Pelatihan","LPJ","10 MEI 2025"],
    ["Materi Rapat Kerja","Materi","8 MEI 2025"],
    ["Tor Workshop","Dokumen","5 MEI 2025"]
];

$kegiatan = [
    ["Seminar Nasional","Panitia","12 MEI 2025","Selesai"],
    ["Pelatihan","Panitia","10 MEI 2025","Selesai"],
    ["Rapat Kerja","Peserta","8 MEI 2025","Selesai"],
    ["Workshop","Panitia","5 MEI 2025","Terjadwal"]
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile ORC</title>

    <link rel="stylesheet" href="/SISTEM-ORC-OF-ORMAWA-ITH/assets/css/profile.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
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

            <li class="active">
                <i class="fa-regular fa-circle-user"></i>
                <span>Profil Saya</span>
            </li>

            <li>
                <i class="fa-solid fa-house"></i>
                <span>Dashboard</span>
            </li>

            <li>
                <i class="fa-solid fa-users"></i>
                <span>Organisasi</span>
            </li>

            <li>
                <i class="fa-regular fa-clipboard"></i>
                <span>Kegiatan</span>
            </li>

            <li>
                <i class="fa-solid fa-user-group"></i>
                <span>Anggota</span>
            </li>

            <li>
                <i class="fa-solid fa-folder"></i>
                <span>Dokumen</span>
            </li>

            <li>
                <i class="fa-solid fa-bullhorn"></i>
                <span>Pengumuman</span>
            </li>

            <li>
                <i class="fa-solid fa-gear"></i>
                <span>Pengaturan</span>
            </li>

        </ul>

        <button class="logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i>
        </button>

    </aside>

    <!-- MAIN -->
    <main class="main-content">

        <!-- HEADER -->
        <header class="topbar">

            <h2>Profil Saya</h2>

            <div class="top-right">

                <i class="fa-solid fa-bell"></i>

                <div class="profile-mini">
                    <img src="<?= $user['foto']; ?>" alt="">
                    <div>
                        <h4><?= $user['nama']; ?></h4>
                        <p><?= $user['role']; ?></p>
                    </div>
                </div>

                <i class="fa-solid fa-angle-down"></i>

            </div>

        </header>

        <!-- PROFILE CARD -->
        <section class="profile-card">

            <div class="profile-left">

                <div class="img-box">
                    <img src="<?= $user['foto']; ?>" alt="">
                    <div class="camera">
                        <i class="fa-solid fa-camera"></i>
                    </div>
                </div>

                <div class="profile-info">
                    <h1><?= $user['nama']; ?></h1>
                    <h2><?= $user['role']; ?></h2>

                    <p>
                        <i class="fa-solid fa-graduation-cap"></i>
                        <?= $user['kampus']; ?>
                    </p>
                </div>

            </div>

            <div class="profile-actions">

                <button class="edit-btn">
                    <i class="fa-regular fa-pen-to-square"></i>
                    Edit Profil
                </button>

                <button class="pass-btn">
                    <i class="fa-solid fa-lock"></i>
                    Ganti Password
                </button>

            </div>

        </section>

        <!-- GRID -->
        <section class="grid-layout">

            <!-- INFORMASI -->
            <div class="card">

                <div class="card-header">
                    <h3>
                        <i class="fa-regular fa-circle-user"></i>
                        Informasi Pribadi
                    </h3>
                </div>

                <div class="info-list">

                    <div class="info-item">
                        <span>Nama Lengkap</span>
                        <p><?= $user['nama']; ?></p>
                    </div>

                    <div class="info-item">
                        <span>NIM</span>
                        <p><?= $user['nim']; ?></p>
                    </div>

                    <div class="info-item">
                        <span>Email</span>
                        <p><?= $user['email']; ?></p>
                    </div>

                    <div class="info-item">
                        <span>No. HP</span>
                        <p><?= $user['hp']; ?></p>
                    </div>

                    <div class="info-item">
                        <span>Jabatan</span>
                        <p><?= $user['jabatan']; ?></p>
                    </div>

                    <div class="info-item">
                        <span>Organisasi</span>
                        <p><?= $user['organisasi']; ?></p>
                    </div>

                    <div class="info-item">
                        <span>Angkatan</span>
                        <p><?= $user['angkatan']; ?></p>
                    </div>

                    <div class="info-item">
                        <span>Status</span>
                        <p class="aktif"><?= $user['status']; ?></p>
                    </div>

                </div>

            </div>

            <!-- DOKUMEN -->
            <div class="card">

                <div class="card-header between">
                    <h3>
                        <i class="fa-solid fa-folder-open"></i>
                        Dokumen Saya
                    </h3>

                    <input type="text" placeholder="Cari Dokumen...">
                </div>

                <table>

                    <tr>
                        <th>Nama Dokumen</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>

                    <?php foreach($dokumen as $d): ?>

                    <tr>
                        <td><?= $d[0]; ?></td>
                        <td><span class="badge"><?= $d[1]; ?></span></td>
                        <td><?= $d[2]; ?></td>
                        <td>
                            <i class="fa-solid fa-download"></i>
                        </td>
                    </tr>

                    <?php endforeach; ?>

                </table>

                <div class="lihat">
                    Lihat Semua Dokumen
                </div>

            </div>

            <!-- KEGIATAN -->
            <div class="card">

                <div class="card-header between">
                    <h3>
                        <i class="fa-regular fa-clipboard"></i>
                        Kegiatan Saya
                    </h3>

                    <a href="#">Lihat Semua</a>
                </div>

                <table>

                    <tr>
                        <th>Nama Kegiatan</th>
                        <th>Peran</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>

                    <?php foreach($kegiatan as $k): ?>

                    <tr>
                        <td><?= $k[0]; ?></td>
                        <td><?= $k[1]; ?></td>
                        <td><?= $k[2]; ?></td>
                        <td>
                            <span class="status">
                                <?= $k[3]; ?>
                            </span>
                        </td>
                    </tr>

                    <?php endforeach; ?>

                </table>

            </div>

            <!-- PENGATURAN -->
            <div class="card setting-card">

                <div class="card-header">
                    <h3>
                        <i class="fa-solid fa-gear"></i>
                        Pengaturan Akun
                    </h3>
                </div>

                <div class="setting-item">
                    <div>
                        <h4>Ubah Profil</h4>
                        <p>Perbarui informasi profil Anda</p>
                    </div>
                    <i class="fa-solid fa-angle-right"></i>
                </div>

                <div class="setting-item">
                    <div>
                        <h4>Ubah Password</h4>
                        <p>Ganti password akun Anda</p>
                    </div>
                    <i class="fa-solid fa-angle-right"></i>
                </div>

                <div class="setting-item logout-text">
                    <div>
                        <h4>Keluar Akun</h4>
                        <p>Logout dari sistem</p>
                    </div>
                    <i class="fa-solid fa-angle-right"></i>
                </div>

            </div>

        </section>

    </main>

</div>

<script src="/SISTEM-ORC-OF-ORMAWA-ITH/assets/js/profile.js"></script>

</body>
</html>