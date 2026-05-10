<?php
// navbar.php - Top navigation bar component
$current_page = $current_page ?? '';
?>
<header class="site-header">
    <!-- Top Bar -->
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

    <!-- Main Navigation -->
    <nav class="main-nav">
        <div class="nav-inner">
            <button class="hamburger" id="hamburgerBtn" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
            <ul class="nav-links" id="navLinks">
                <li>
                    <a href="<?= BASE_URL ?>pages/homepage/homepage.php"
                       class="<?= $current_page === 'home' ? 'active' : '' ?>">HOME</a>
                </li>
                <li>
                    <a href="#about"
                       class="<?= $current_page === 'about' ? 'active' : '' ?>">ABOUT US</a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>pages/organisasi/organisasi.php?org=bem"
                       class="<?= $current_page === 'bem' ? 'active' : '' ?>">BEM</a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>pages/organisasi/organisasi.php?org=hero"
                       class="<?= $current_page === 'hero' ? 'active' : '' ?>">HERO</a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>pages/organisasi/organisasi.php?org=hcc"
                       class="<?= $current_page === 'hcc' ? 'active' : '' ?>">HCC</a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>pages/organisasi/organisasi.php?org=aratta"
                       class="<?= $current_page === 'aratta' ? 'active' : '' ?>">ARATTA</a>
                </li>
                <li>
                    <a href="<?= BASE_URL ?>pages/organisasi/organisasi.php?org=wirausaha"
                       class="<?= $current_page === 'wirausaha' ? 'active' : '' ?>">WIRAUSAHA</a>
                </li>
            </ul>
        </div>
    </nav>
</header>