<?php
// pages/homepage/homepage.php
require_once '../../config/connection.php';

$page_title  = 'Beranda';
$page_css    = ['homepage.css'];
$page_js     = ['homepage.js'];
$current_page = 'home';

// Data Organisasi (bisa diganti dari database nantinya)
$organisasi = [
    [
        'nama'        => 'Badan Eksekutif Mahasiswa (BEM) – ITH',
        'deskripsi'   => 'Organisasi mahasiswa yang menjadi wadah aspirasi, koordinasi kegiatan kampus, serta pengembangan kepemimpinan mahasiswa ITH.',
        'logo'        => BASE_URL . 'assets/img/logo/logo-bem.png',
        'slug'        => 'bem',
        'logo_alt'    => 'Logo BEM ITH',
    ],
    [
        'nama'        => 'Habibie Engineering Robotic of Organization (HERO) – ITH',
        'deskripsi'   => 'Organisasi mahasiswa yang berfokus pada pengembangan teknologi robotika, IoT, dan inovasi di bidang engineering.',
        'logo'        => BASE_URL . 'assets/img/logo/logo-hero.png',
        'slug'        => 'hero',
        'logo_alt'    => 'Logo HERO ITH',
    ],
    [
        'nama'        => 'Habibie Coding Club (HCC) – ITH',
        'deskripsi'   => 'Organisasi mahasiswa di bidang pemrograman dan teknologi yang mendukung pengembangan skill coding, software, dan digital creativity.',
        'logo'        => BASE_URL . 'assets/img/logo/logo-hcc.png',
        'slug'        => 'hcc',
        'logo_alt'    => 'Logo HCC ITH',
    ],
    [
        'nama'        => 'UKM Seni Art & Talent (ARATTA) – ITH',
        'deskripsi'   => 'Unit kegiatan mahasiswa yang menjadi wadah pengembangan minat, kreativitas, dan bakat mahasiswa di bidang seni dan hiburan.',
        'logo'        => BASE_URL . 'assets/img/logo/logo-aratta.png',
        'slug'        => 'aratta',
        'logo_alt'    => 'Logo ARATTA ITH',
    ],
    [
        'nama'        => 'Wirausaha (WITH) – ITH',
        'deskripsi'   => 'Organisasi mahasiswa yang berfokus pada pengembangan jiwa kewirausahaan, kreativitas bisnis, dan inovasi usaha mahasiswa.',
        'logo'        => BASE_URL . 'assets/img/logo/logo-with.png',
        'slug'        => 'wirausaha',
        'logo_alt'    => 'Logo WITH ITH',
    ],
];

// Testimoni
$testimoni = [
    [
        'isi'    => '"Selama 1,5 periode di organisasi HERO dan kepanitiaan Habibie Robotic Competition (HRC), saya berpartisipasi dalam pengelolaan keuangan, administrasi, logistik, dan registrasi sehingga mengasah kemampuan manajemen waktu, ketelitian, serta komunikasi."',
        'nama'   => 'Nurkhofifah',
        'jabatan'=> 'Pengurus HERO',
        'highlight' => true,
    ],
    [
        'isi'    => '"Dari anggota ke ITH, selama jadi member banyak kudapat ilmu yang tidak di dapatkan di kelas atau kuliah. Di organisasi di ITH, bru di ajari di kelas, tdk cuma belajar tapi naik ke jadi pengurus, selama jadi pengurus banyak experience bru ku dapat, maka harus ki terus menyesuaikan waktu, belajar bekerja sama dengan tim, saling support tak demi kemajuan."',
        'nama'   => 'Muhammad Farid Ramadhan',
        'jabatan'=> 'Pengurus HCC',
        'highlight' => false,
    ],
];

// Stats
$stats = [
    ['angka' => '5',  'suffix' => '+', 'label' => 'Organisasi Mahasiswa Aktif'],
    ['angka' => '20', 'suffix' => '+', 'label' => 'Program Kerja & Kegiatan Terlaksana dengan Baik'],
    ['angka' => '50', 'suffix' => '+', 'label' => 'Mahasiswa Aktif Ber-Organisasi'],
];

require_once '../../components/header.php';
require_once '../../components/navbar.php';
?>

<!-- ========================================
     HERO SECTION
======================================== -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <div class="hero-badge">
            <i class="bi bi-house-fill"></i>
            ORMAWA ITH — Parepare
        </div>
        <h1 class="hero-title">
            Kelola Sumber Daya<br>Organisasi dengan Mudah
        </h1>
        <p class="hero-subtitle">
            Satu platform terpusat untuk menyimpan, mengelola, dan mengakses seluruh dokumen dan arsip ORMAWA ITH.
        </p>
        <div class="hero-actions">
            <a href="<?= BASE_URL ?>pages/organisasi/organisasi.php" class="btn btn-hero-primary">
                Jelajahi Organisasi <i class="bi bi-arrow-right"></i>
            </a>
            <a href="#contact" class="btn btn-hero-outline">
                Hubungi Kami <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- ========================================
     SEARCH SECTION
======================================== -->
<section class="search-section">
    <form class="search-bar" id="searchForm" role="search">
        <i class="bi bi-search"></i>
        <input
            type="text"
            id="searchInput"
            class="search-input"
            placeholder="Cari Organisasi"
            aria-label="Cari organisasi"
        >
        <div class="search-divider"></div>
        <select id="categorySelect" class="search-select" aria-label="Pilih kategori organisasi">
            <option value="">Pilih Kategori Organisasi</option>
            <option value="bem">BEM</option>
            <option value="ukm">UKM</option>
            <option value="himpunan">Himpunan Mahasiswa</option>
        </select>
        <button type="submit" class="btn-search">Explore</button>
    </form>
</section>

<!-- ========================================
     DISCOVER / TEMUKAN ORGANISASI SECTION
======================================== -->
<section class="discover-section" id="about">
    <div class="discover-inner">
        <div class="discover-image" data-reveal>
            <img
                src="<?= BASE_URL ?>assets/img/banner/discover-org.jpg"
                alt="Kegiatan organisasi kampus ITH"
                loading="lazy"
            >
        </div>
        <div class="discover-text" data-reveal>
            <h2>Temukan <span>Organisasi Kampusmu !</span></h2>
            <p>
                Jelajahi berbagai organisasi mahasiswa di ITH, mulai dari BEM, UKM, hingga unit kegiatan mahasiswa. Dapatkan informasi program kerja, kegiatan, dan aktivitas terbaru dalam satu platform terintegrasi!
            </p>
            <a href="<?= BASE_URL ?>pages/signin/signin.php" class="btn-discover">
                Yuk! Daftar dan Mulai Organisasimu di ITH.
                <i class="bi bi-arrow-right-circle-fill"></i>
            </a>
        </div>
    </div>
</section>

<!-- ========================================
     ORGANISASI CARDS SECTION (Horizontal Scroll)
======================================== -->
<section class="orgs-section">
    <div class="orgs-section-header" data-reveal>
        <h2>Mulai Perjalanan Organisasimu di- ITH</h2>
    </div>

    <div class="orgs-scroll-wrapper">
        <!-- Scroll Left Button -->
        <button class="scroll-btn left" aria-label="Geser ke kiri" disabled>
            <i class="bi bi-chevron-left"></i>
        </button>

        <!-- Cards Container -->
        <div class="orgs-scroll-container" id="orgsScroll">
            <?php foreach ($organisasi as $org): ?>
            <div class="org-card">
                <div class="org-card-logo">
                    <img
                        src="<?= htmlspecialchars($org['logo']) ?>"
                        alt="<?= htmlspecialchars($org['logo_alt']) ?>"
                        loading="lazy"
                        onerror="this.src='<?= BASE_URL ?>assets/img/logo/default-org.png'"
                    >
                </div>
                <div class="org-card-body">
                    <h3><?= htmlspecialchars($org['nama']) ?></h3>
                    <p><?= htmlspecialchars($org['deskripsi']) ?></p>
                </div>
                <a
                    href="<?= BASE_URL ?>pages/organisasi/organisasi.php?org=<?= urlencode($org['slug']) ?>"
                    class="btn-explore"
                >
                    Explore Organisasi
                </a>
            </div>
            <?php endforeach; ?>
        </div>

        <!-- Scroll Right Button -->
        <button class="scroll-btn right" aria-label="Geser ke kanan">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>

    <!-- Scroll Dots -->
    <div class="scroll-dots" role="tablist">
        <?php foreach ($organisasi as $i => $org): ?>
        <button
            class="scroll-dot <?= $i === 0 ? 'active' : '' ?>"
            aria-label="Ke organisasi <?= $i + 1 ?>"
            role="tab"
        ></button>
        <?php endforeach; ?>
    </div>
</section>

<!-- ========================================
     TESTIMONI + STATS SECTION
======================================== -->
<section class="testimoni-section" id="testimoni">
    <div class="testimoni-inner">

        <!-- Left: Testimoni -->
        <div class="testimoni-left" data-reveal>
            <h2>Apa Kata Mahasiswa(i) ITH ?</h2>
            <p>Pengalaman mereka bersama organisasi kampus</p>

            <div class="testimoni-cards">
                <?php foreach ($testimoni as $t): ?>
                <div class="testimoni-card <?= $t['highlight'] ? 'highlight' : '' ?>">
                    <blockquote><?= htmlspecialchars($t['isi']) ?></blockquote>
                    <div class="testimoni-author"><?= htmlspecialchars($t['nama']) ?></div>
                    <div class="testimoni-role"><?= htmlspecialchars($t['jabatan']) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Right: Stats -->
        <div class="stats-right" data-reveal>
            <?php foreach ($stats as $stat): ?>
            <div class="stat-card">
                <div
                    class="stat-number"
                    data-count="<?= htmlspecialchars($stat['angka']) ?>"
                    data-suffix="<?= htmlspecialchars($stat['suffix']) ?>"
                >
                    0<?= htmlspecialchars($stat['suffix']) ?>
                </div>
                <div class="stat-label"><?= htmlspecialchars($stat['label']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- ========================================
     CONTACT SECTION (anchor #contact)
======================================== -->
<div id="contact"></div>

<?php require_once '../../components/footer.php'; ?>