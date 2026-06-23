<?php
// components/navbar.php — Shared navbar, uses navbar.css
$current_page = $current_page ?? '';
$is_logged_in = !empty($_SESSION['user_id']);
?>
<header class="site-header">

    <!-- TOP BAR -->
    <div class="top-bar">
        <div class="top-bar-inner">
            <div class="brand">
                <div class="brand-icon">
                    <i class="bi bi-journal-bookmark-fill"></i>
                </div>
                <span class="brand-name">Organization Resource Center</span>
            </div>

            <?php if ($is_logged_in): ?>
              <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;">
                <span style="font-size:.78rem;color:var(--nav-text-mid,#6B3E1A);font-weight:600;">
                  Halo, <?= e($_SESSION['nama'] ?? 'User') ?>
                </span>
                <a href="<?= BASE_URL ?>pages/dashboard/dashboard.php" class="btn-daftar outline">Dashboard</a>
                <a href="<?= BASE_URL ?>proccess/logout.php" class="btn-daftar">Keluar</a>
              </div>
            <?php else: ?>
              <div style="display:flex;gap:8px;">
                <a href="<?= BASE_URL ?>pages/login/login.php" class="btn-daftar outline">MASUK</a>
                <a href="<?= BASE_URL ?>pages/signup.php" class="btn-daftar">DAFTAR SEKARANG</a>
              </div>
            <?php endif; ?>
        </div>
    </div>

</header>
