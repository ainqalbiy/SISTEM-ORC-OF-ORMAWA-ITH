<?php
// components/sidebar.php — Sidebar navigasi halaman profile/dashboard
// Gunakan: $sidebar_active = 'profil' | 'dashboard' | 'organisasi' | 'kegiatan' | 'dokumen' | 'pengaturan'
$sidebar_active = $sidebar_active ?? 'profil';

$menu_items = [
    ['key' => 'profil',      'icon' => 'fa-regular fa-circle-user', 'label' => 'Profil Saya',   'href' => BASE_URL . 'pages/profile/profile.php'],
    ['key' => 'dashboard',   'icon' => 'fa-solid fa-house',         'label' => 'Dashboard',     'href' => BASE_URL . 'pages/homepage/homepage.php'],
    ['key' => 'organisasi',  'icon' => 'fa-solid fa-users',         'label' => 'Organisasi',    'href' => BASE_URL . 'pages/organisasi/bem.php'],
    ['key' => 'kegiatan',    'icon' => 'fa-regular fa-clipboard',   'label' => 'Kegiatan',      'href' => '#'],
    ['key' => 'dokumen',     'icon' => 'fa-solid fa-folder',        'label' => 'Dokumen',       'href' => '#'],
    ['key' => 'pengaturan',  'icon' => 'fa-solid fa-gear',          'label' => 'Pengaturan',    'href' => '#'],
];
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<aside class="sidebar">
    <div class="logo">
        <h1>ORC</h1>
        <p>Organization Resource Center of ORMAWA ITH</p>
    </div>

    <?php foreach ($menu_items as $item): ?>
        <a href="<?= $item['href'] ?>"
           class="menu <?= $sidebar_active === $item['key'] ? 'active' : '' ?>">
            <i class="<?= $item['icon'] ?>"></i>
            <span><?= $item['label'] ?></span>
        </a>
    <?php endforeach; ?>

    <a href="<?= BASE_URL ?>proccess/logout.php" class="logout-btn" title="Keluar">
        <i class="fa-solid fa-right-from-bracket"></i>
    </a>
</aside>
