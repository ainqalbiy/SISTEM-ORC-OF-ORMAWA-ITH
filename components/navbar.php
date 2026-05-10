<?php
// components/navbar.php — Topbar + Navigasi utama
// Set $current_page sebelum include untuk highlight menu aktif.
$current_page = $current_page ?? '';
?>
<header class="site-header">

    <!-- ── TOP BAR ── -->
    <div class="top-bar">
        <div class="top-bar-inner">
            <div class="brand">
                <div class="brand-icon">
                    <i class="bi bi-journal-bookmark-fill"></i>
                </div>
                <span class="brand-name">Organization Resource Center</span>
            </div>
            <a href="<?= BASE_URL ?>pages/signin/signin.php" class="btn-daftar">
                DAFTAR SEKARANG
            </a>
        </div>
    </div>

    <!-- ── MAIN NAV ── -->
    <nav class="main-nav">
        <div class="nav-inner">
            <!-- Hamburger (mobile) -->
            <button class="hamburger" id="hamburgerBtn" aria-label="Toggle menu" aria-expanded="false">
                <span></span><span></span><span></span>
            </button>

            <ul class="nav-links" id="navLinks">
                <li>
                    <a href="<?= BASE_URL ?>pages/homepage/homepage.php"
                       class="<?= $current_page === 'home' ? 'active' : '' ?>">HOME</a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>pages/homepage/homepage.php#about"
                       class="<?= $current_page === 'about' ? 'active' : '' ?>">ABOUT US</a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>pages/organisasi/bem.php"
                       class="<?= $current_page === 'bem' ? 'active' : '' ?>">BEM</a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>pages/organisasi/hero.php"
                       class="<?= $current_page === 'hero' ? 'active' : '' ?>">HERO</a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>pages/organisasi/hcc.php"
                       class="<?= $current_page === 'hcc' ? 'active' : '' ?>">HCC</a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>pages/organisasi/aratta.php"
                       class="<?= $current_page === 'aratta' ? 'active' : '' ?>">ARATTA</a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>pages/organisasi/wirausaha.php"
                       class="<?= $current_page === 'wirausaha' ? 'active' : '' ?>">WIRAUSAHA</a>
                </li>
            </ul>
        </div>
    </nav>

</header>
