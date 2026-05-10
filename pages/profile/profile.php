<?php

// ==========================
// DATA USER
// ==========================

$nama          = "MBPP";
$jabatan       = "Pengurus";
$kampus        = "Institut Teknologi Bacharuddin Jusuf Habibie";
$nim           = "241011005";
$email         = "user@gmail.com";
$nohp          = "08123456789";
$organisasi    = "HIMAKOM";
$angkatan      = "2024";
$status        = "Aktif";


// ==========================
// DATA DOKUMEN
// ==========================

$dokumen = [

    [
        "nama" => "Proposal Seminar",
        "kategori" => "Proposal",
        "tanggal" => "12 Mei 2025"
    ],

    [
        "nama" => "LPJ Kegiatan",
        "kategori" => "LPJ",
        "tanggal" => "10 Mei 2025"
    ],

    [
        "nama" => "Materi Workshop",
        "kategori" => "Materi",
        "tanggal" => "08 Mei 2025"
    ]

];


// ==========================
// DATA KEGIATAN
// ==========================

$kegiatan = [

    [
        "nama" => "Seminar Nasional",
        "peran" => "Panitia",
        "status" => "Selesai"
    ],

    [
        "nama" => "Workshop",
        "peran" => "Peserta",
        "status" => "Terjadwal"
    ],

    [
        "nama" => "Pelatihan",
        "peran" => "Panitia",
        "status" => "Selesai"
    ]

];

?>


<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profil Saya</title>

    <!-- CSS -->
    <link rel="stylesheet" href="profile.css">

    <!-- FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- ICON -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<div class="container">

    <!-- =========================
         SIDEBAR
    ========================== -->

    <aside class="sidebar">

        <div class="logo">

            <h1>ORC</h1>

            <p>
                Organization Resource Center
                of ORMAWA ITH
            </p>

        </div>

        <div class="menu active">
            <i class="fa-regular fa-circle-user"></i>
            <span>Profil Saya</span>
        </div>

        <div class="menu">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span>
        </div>

        <div class="menu">
            <i class="fa-solid fa-users"></i>
            <span>Organisasi</span>
        </div>

        <div class="menu">
            <i class="fa-regular fa-clipboard"></i>
            <span>Kegiatan</span>
        </div>

        <div class="menu">
            <i class="fa-solid fa-folder"></i>
            <span>Dokumen</span>
        </div>

        <div class="menu">
            <i class="fa-solid fa-gear"></i>
            <span>Pengaturan</span>
        </div>

        <button class="logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i>
        </button>

    </aside>


    <!-- =========================
         MAIN CONTENT
    ========================== -->

    <main class="main">

        <!-- TOPBAR -->

        <div class="topbar">

            <h2>Profil Saya</h2>

            <div class="top-right">

                <i class="fa-solid fa-bell"></i>

                <div class="mini-profile">

                    <img src="assets/profile.jpg">

                    <div>
                        <h4><?= $nama ?></h4>
                        <span><?= $jabatan ?></span>
                    </div>

                </div>

            </div>

        </div>


        <!-- =========================
             PROFILE CARD
        ========================== -->

        <div class="profile-card">

            <div class="profile-left">

                <div class="profile-image">

                    <img src="assets/profile.jpg">

                    <div class="camera-icon">
                        <i class="fa-solid fa-camera"></i>
                    </div>

                </div>

                <div class="profile-info">

                    <h1><?= $nama ?></h1>

                    <h3><?= $jabatan ?></h3>

                    <p>
                        <i class="fa-solid fa-graduation-cap"></i>
                        <?= $kampus ?>
                    </p>

                </div>

            </div>


            <div class="button-group">

                <button class="btn">
                    <i class="fa-regular fa-pen-to-square"></i>
                    Edit Profil
                </button>

                <button class="btn">
                    <i class="fa-solid fa-lock"></i>
                    Ganti Password
                </button>

            </div>

        </div>


        <!-- =========================
             GRID 4 LAYOUT
        ========================== -->

        <div class="grid">


            <!-- =====================
                 INFORMASI
            ====================== -->

            <div class="card">

                <div class="card-header">

                    <div class="title">
                        <i class="fa-regular fa-circle-user"></i>
                        <h3>Informasi Pribadi</h3>
                    </div>

                </div>

                <div class="info-list">

                    <div class="info-item">
                        <span>Nama Lengkap</span>
                        <p><?= $nama ?></p>
                    </div>

                    <div class="info-item">
                        <span>NIM</span>
                        <p><?= $nim ?></p>
                    </div>

                    <div class="info-item">
                        <span>Email</span>
                        <p><?= $email ?></p>
                    </div>

                    <div class="info-item">
                        <span>No HP</span>
                        <p><?= $nohp ?></p>
                    </div>

                    <div class="info-item">
                        <span>Jabatan</span>
                        <p><?= $jabatan ?></p>
                    </div>

                    <div class="info-item">
                        <span>Organisasi</span>
                        <p><?= $organisasi ?></p>
                    </div>

                    <div class="info-item">
                        <span>Angkatan</span>
                        <p><?= $angkatan ?></p>
                    </div>

                    <div class="info-item">
                        <span>Status</span>

                        <p class="status-active">
                            <?= $status ?>
                        </p>
                    </div>

                </div>

            </div>


            <!-- =====================
                 DOKUMEN
            ====================== -->

            <div class="card">

                <div class="card-header">

                    <div class="title">
                        <i class="fa-solid fa-folder"></i>
                        <h3>Dokumen Saya</h3>
                    </div>

                    <input type="text" placeholder="Cari Dokumen">

                </div>

                <table>

                    <thead>

                        <tr>
                            <th>Dokumen</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach($dokumen as $item): ?>

                        <tr>

                            <td><?= $item['nama'] ?></td>

                            <td>
                                <span class="badge">
                                    <?= $item['kategori'] ?>
                                </span>
                            </td>

                            <td><?= $item['tanggal'] ?></td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>


            <!-- =====================
                 KEGIATAN
            ====================== -->

            <div class="card">

                <div class="card-header">

                    <div class="title">
                        <i class="fa-regular fa-clipboard"></i>
                        <h3>Kegiatan Saya</h3>
                    </div>

                    <span class="lihat">
                        Lihat Semua
                    </span>

                </div>

                <table>

                    <thead>

                        <tr>
                            <th>Kegiatan</th>
                            <th>Peran</th>
                            <th>Status</th>
                        </tr>

                    </thead>

                    <tbody>

                    <?php foreach($kegiatan as $item): ?>

                        <tr>

                            <td><?= $item['nama'] ?></td>

                            <td><?= $item['peran'] ?></td>

                            <td>

                                <?php if($item['status'] == "Selesai"): ?>

                                    <span class="done">
                                        <?= $item['status'] ?>
                                    </span>

                                <?php else: ?>

                                    <span class="schedule">
                                        <?= $item['status'] ?>
                                    </span>

                                <?php endif; ?>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>


            <!-- =====================
                 PENGATURAN
            ====================== -->

            <div class="card">

                <div class="card-header">

                    <div class="title">
                        <i class="fa-solid fa-gear"></i>
                        <h3>Pengaturan Akun</h3>
                    </div>

                </div>


                <div class="setting-item">

                    <div>

                        <h4>Ubah Profil</h4>

                        <p>
                            Perbarui informasi profil
                        </p>

                    </div>

                    <i class="fa-solid fa-chevron-right"></i>

                </div>


                <div class="setting-item">

                    <div>

                        <h4>Ubah Password</h4>

                        <p>
                            Ganti password akun
                        </p>

                    </div>

                    <i class="fa-solid fa-chevron-right"></i>

                </div>


                <div class="setting-item logout-setting">

                    <div>

                        <h4>Keluar Akun</h4>

                        <p>
                            Logout dari sistem
                        </p>

                    </div>

                    <i class="fa-solid fa-chevron-right"></i>

                </div>

            </div>

        </div>

    </main>

</div>

<!-- JS -->
<script src="script.js"></script>

</body>
</html>