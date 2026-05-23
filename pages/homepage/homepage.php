<?php
require_once '../../config/connection.php';

$page_title   = 'Beranda';
$page_css     = ['homepage.css'];
$page_js      = ['homepage.js'];
$current_page = 'home';

$organisasi = [
    [
        'nama'     => 'Badan Eksekutif Mahasiswa (BEM) – ITH',
        'deskripsi'=> 'Organisasi mahasiswa yang menjadi wadah aspirasi, koordinasi kegiatan kampus, serta pengembangan kepemimpinan mahasiswa ITH.',
        'logo'     => BASE_URL . 'assets/img/logo/logo-bem.jpeg',
        'slug'     => 'bem',
        'logo_alt' => 'Logo BEM ITH',
    ],
    [
        'nama'     => 'Habibie Engineering Robotic of Organization (HERO) – ITH',
        'deskripsi'=> 'Organisasi mahasiswa yang berfokus pada pengembangan teknologi robotika, IoT, dan inovasi di bidang engineering.',
        'logo'     => BASE_URL . 'assets/img/logo/logo-hero.png',
        'slug'     => 'hero',
        'logo_alt' => 'Logo HERO ITH',
    ],
    [
        'nama'     => 'Habibie Coding Club (HCC) – ITH',
        'deskripsi'=> 'Organisasi mahasiswa di bidang pemrograman dan teknologi yang mendukung pengembangan skill coding, software, dan digital creativity.',
        'logo'     => BASE_URL . 'assets/img/logo/logo-hcc.png',
        'slug'     => 'hcc',
        'logo_alt' => 'Logo HCC ITH',
    ],
    [
        'nama'     => 'UKM Seni Art & Talent (ARATTA) – ITH',
        'deskripsi'=> 'Unit kegiatan mahasiswa yang menjadi wadah pengembangan minat, kreativitas, dan bakat mahasiswa di bidang seni dan hiburan.',
        'logo'     => BASE_URL . 'assets/img/logo/logo-aratta.png',
        'slug'     => 'aratta',
        'logo_alt' => 'Logo ARATTA ITH',
    ],
    [
        'nama'     => 'Wirausaha (WITH) – ITH',
        'deskripsi'=> 'Organisasi mahasiswa yang berfokus pada pengembangan jiwa kewirausahaan, kreativitas bisnis, dan inovasi usaha mahasiswa.',
        'logo'     => BASE_URL . 'assets/img/logo/logo-with.png',
        'slug'     => 'wirausaha',
        'logo_alt' => 'Logo WITH ITH',
    ],
];

$testimoni = [
    [
        'isi'       => 'Selama 1,5 periode di organisasi HERO dan kepanitiaan Habibie Robotic Competition (HRC), saya berpartisipasi dalam pengelolaan keuangan, administrasi, logistik, dan registrasi sehingga mengasah kemampuan manajemen waktu, ketelitian, serta komunikasi.',
        'nama'      => 'Nurkhofifah',
        'jabatan'   => 'Pengurus HERO',
        'highlight' => true,
    ],
    [
        'isi'       => 'Dari anggota ke ITH, selama jadi member banyak kudapat ilmu yang tidak di dapatkan di kelas. Selama jadi pengurus banyak experience bru ku dapat, mulai harus ki bisa menyesuaikan waktu, belajar bekerja sama dengan tim, saling support demi kemajuan.',
        'nama'      => 'Muhammad Farid Ramadhan',
        'jabatan'   => 'Pengurus HCC',
        'highlight' => false,
    ],
];

$stats = [
    ['angka' => '5',  'suffix' => '+', 'label' => 'Organisasi Mahasiswa Aktif'],
    ['angka' => '20', 'suffix' => '+', 'label' => 'Program Kerja & Kegiatan Terlaksana dengan Baik'],
    ['angka' => '50', 'suffix' => '+', 'label' => 'Mahasiswa Aktif Ber-Organisasi'],
];

require_once '../../components/header.php';
require_once '../../components/navbar.php';
?>

<!-- ═══════════ HERO ═══════════ -->
<section class="hero">
    <div class="hero-bg"></div>
    <div class="hero-overlay"></div>

    <!-- Organic blob -->
    <svg class="hero-blob" viewBox="0 0 480 520" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M75,35 C20,8 -38,78 -48,168 C-58,258 -20,335 46,400
                 C112,465 210,502 305,488 C400,474 468,412 486,328
                 C504,244 478,148 418,82 C358,16 272,-20 182,6
                 C143,16 108,52 75,35 Z"
              fill="rgba(200,92,26,0.45)"/>
    </svg>

    <div class="hero-content">
        <div class="hero-badge">
            <span class="hero-badge-icon"><i class="bi bi-house-fill"></i></span>
            ORMAWA ITH — Parepare
        </div>
        <h1 class="hero-title">
            Kelola Sumber Daya<br>Organisasi dengan Mudah
        </h1>
        <p class="hero-subtitle">
            Satu platform terpusat untuk menyimpan, mengelola, dan mengakses
            seluruh dokumen dan arsip ORMAWA ITH.
        </p>
        <div class="hero-actions">
            <a href="#orgs-section" class="btn-hero-primary">
                Jelajahi Organisasi <i class="bi bi-play-fill"></i>
            </a>
            <a href="#contact" class="btn-hero-outline">
                Hubungi Kami <i class="bi bi-play-fill"></i>
            </a>
        </div>
    </div>
</section>

<!-- ═══════════ SEARCH ═══════════ -->
<section class="search-section">
    <form class="search-bar" id="searchForm" role="search"
          action="<?= BASE_URL ?>pages/organisasi/organisasi.php" method="GET">
        <div class="search-left">
            <i class="bi bi-search search-icon"></i>
            <input type="text" id="searchInput" name="q" class="search-input"
                   placeholder="Cari Organisasi" aria-label="Cari organisasi">
        </div>
        <div class="search-divider"></div>
        <div class="search-middle">
            <select name="kategori" id="categorySelect" class="search-select" aria-label="Pilih kategori">
                <option value="">Pilih Kategori Organisasi</option>
                <option value="bem">BEM</option>
                <option value="ukm">UKM</option>
                <option value="himpunan">Himpunan Mahasiswa</option>
            </select>
            <i class="bi bi-chevron-down select-arrow"></i>
        </div>
        <button type="submit" class="btn-search">Explore</button>
    </form>
</section>

<!-- ═══════════ DISCOVER / ABOUT ═══════════ -->
<section class="discover-section" id="about">
    <div class="discover-inner">
        <div class="discover-image" data-reveal>
            <img src="<?= BASE_URL ?>assets/img/banner/hero-bg.jpeg"
                 alt="Kegiatan organisasi kampus ITH" loading="lazy"
                 onerror="this.style.background='#e8956d';this.alt=''">
        </div>
        <div class="discover-text" data-reveal>
            <h2>Temukan <span>Organisasi Kampusmu !</span></h2>
            <p>
                Jelajahi berbagai organisasi mahasiswa di ITH, mulai dari BEM, UKM, hingga
                unit kegiatan mahasiswa. Dapatkan informasi program kerja, kegiatan, dan
                aktivitas terbaru dalam satu platform terintegrasi!
            </p>
            <a href="<?= BASE_URL ?>pages/signin.php" class="btn-discover">
                Yuk! Daftar dan Mulai Organisasimu di ITH.
                <i class="bi bi-arrow-right-circle-fill"></i>
            </a>
        </div>
    </div>
</section>

<!-- ═══════════ ORGANISATION CARDS ═══════════ -->
<section class="orgs-section" id="orgs-section">
    <div class="orgs-section-header" data-reveal>
        <h2>Mulai Perjalanan Organisasimu di- ITH</h2>
    </div>

    <div class="orgs-scroll-wrapper">
        <button class="scroll-btn left" id="scrollBtnLeft" aria-label="Geser ke kiri" disabled>
            <i class="bi bi-chevron-left"></i>
        </button>

        <div class="orgs-scroll-container" id="orgsScroll">
            <?php foreach ($organisasi as $org): ?>
            <div class="org-card">
                <div class="org-card-logo">
                    <img src="<?= htmlspecialchars($org['logo']) ?>"
                         alt="<?= htmlspecialchars($org['logo_alt']) ?>"
                         loading="lazy"
                         onerror="this.src='<?= BASE_URL ?>assets/img/logo/header-logo.jpeg'">
                </div>
                <div class="org-card-body">
                    <h3><?= htmlspecialchars($org['nama']) ?></h3>
                    <p><?= htmlspecialchars($org['deskripsi']) ?></p>
                </div>
                <a href="<?= BASE_URL ?>pages/organisasi/<?= urlencode($org['slug']) ?>.php"
                   class="btn-explore">Explore Organisasi</a>
            </div>
            <?php endforeach; ?>
        </div>

        <button class="scroll-btn right" id="scrollBtnRight" aria-label="Geser ke kanan">
            <i class="bi bi-chevron-right"></i>
        </button>
    </div>

    <div class="scroll-dots" id="scrollDots" role="tablist">
        <?php foreach ($organisasi as $i => $org): ?>
        <button class="scroll-dot <?= $i === 0 ? 'active' : '' ?>"
                aria-label="Ke organisasi <?= $i + 1 ?>" role="tab"></button>
        <?php endforeach; ?>
    </div>
</section>

<!-- ═══════════ TESTIMONI + STATS ═══════════ -->
<section class="testimoni-section" id="testimoni">
    <div class="testimoni-inner">

        <div class="testimoni-left" data-reveal>
            <h2>Apa Kata Mahasiswa(i) ITH ?</h2>
            <p>Pengalaman mereka bersama organisasi kampus</p>

            <div class="testimoni-cards">
                <?php foreach ($testimoni as $t): ?>
                <div class="testimoni-card <?= $t['highlight'] ? 'highlight' : '' ?>">
                    <blockquote>"<?= htmlspecialchars($t['isi']) ?>"</blockquote>
                    <div class="testimoni-author"><?= htmlspecialchars($t['nama']) ?></div>
                    <div class="testimoni-role">– <?= htmlspecialchars($t['jabatan']) ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="stats-right" data-reveal>
            <?php foreach ($stats as $stat): ?>
            <div class="stat-card">
                <div class="stat-number"
                     data-count="<?= htmlspecialchars($stat['angka']) ?>"
                     data-suffix="<?= htmlspecialchars($stat['suffix']) ?>">
                    0<?= htmlspecialchars($stat['suffix']) ?>
                </div>
                <div class="stat-label"><?= htmlspecialchars($stat['label']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- ═══════════ FOOTER / CONTACT ═══════════ -->
<footer class="footer" id="contact">
    <div class="footer-inner">

        <div class="footer-contact-info" data-reveal>
            <h3>Informasi Kontak</h3>
            <div class="footer-contact-items">
                <div class="footer-contact-item">
                    <div class="icon-box"><i class="bi bi-geo-alt-fill"></i></div>
                    <div class="detail">
                        <label>Alamat</label>
                        <p>Kampus Institut Teknologi B.J Habibie<br>Parepare, Sulawesi Selatan</p>
                    </div>
                </div>
                <div class="footer-contact-item">
                    <div class="icon-box"><i class="bi bi-envelope-fill"></i></div>
                    <div class="detail">
                        <label>Email</label>
                        <p>orcormawa@ith.ac.id</p>
                    </div>
                </div>
                <div class="footer-contact-item">
                    <div class="icon-box"><i class="bi bi-telephone-fill"></i></div>
                    <div class="detail">
                        <label>Telepon</label>
                        <p>+62 1234 5678 910</p>
                    </div>
                </div>
            </div>

            <div class="footer-socials">
                <a href="#" class="social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                <a href="#" class="social-btn" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                <a href="#" class="social-btn" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
            </div>
        </div>

        <div class="footer-right" data-reveal>
            <div class="footer-contacts-title">CONTACTS</div>
            <p>Memiliki pertanyaan atau membutuhkan informasi terkait organisasi mahasiswa? Hubungi kami melalui kontak berikut.</p>
        </div>

    </div>

    <div class="footer-divider">
        <div class="footer-brand-mini">
            <span class="footer-logo-badge">ORC</span>
            <span class="footer-brand-text">Organization Resource Center · ORMAWA ITH</span>
        </div>
        <p class="footer-copy">© <?= date('Y') ?> ORC ORMAWA ITH — Institut Teknologi B.J Habibie</p>
    </div>
</footer>

<?php require_once '../../components/footer_scripts.php'; ?>
