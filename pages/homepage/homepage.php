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

// ── Event Organisasi (publik) ──────────────────────────────────────
$hp_event_list = [];
$ev_tbl_check  = $conn->query("SHOW TABLES LIKE 'event_organisasi'");
if ($ev_tbl_check && $ev_tbl_check->num_rows > 0) {
    // Cek kolom nama_organisasi — tambahkan jika belum ada
    $cols = $conn->query("SHOW COLUMNS FROM event_organisasi LIKE 'nama_organisasi'");
    if ($cols && $cols->num_rows === 0) {
        $conn->query("ALTER TABLE event_organisasi ADD COLUMN nama_organisasi VARCHAR(150) DEFAULT 'ORMAWA ITH' AFTER organisasi_slug");
    }
    $hp_event_list = $conn->query(
        "SELECT * FROM event_organisasi ORDER BY tanggal DESC LIMIT 10"
    )?->fetch_all(MYSQLI_ASSOC) ?? [];
}

// Dummy fallback — tampil hanya jika DB kosong atau tabel belum ada
if (empty($hp_event_list)) {
    $hp_event_list = [
        [
            'judul'           => 'Habibie Robotic Competition 2026',
            'nama_organisasi' => 'HERO – ITH',
            'tanggal'         => '2026-08-05',
            'lokasi'          => 'Lapangan Kampus ITH',
            'deskripsi'       => 'Kompetisi robotika antar kampus tingkat nasional yang diselenggarakan oleh HERO ITH.',
            'banner'          => null,
        ],
        [
            'judul'           => 'HCC Coding Bootcamp 2026',
            'nama_organisasi' => 'HCC – ITH',
            'tanggal'         => '2026-07-20',
            'lokasi'          => 'Lab Komputer Lantai 3',
            'deskripsi'       => 'Bootcamp intensif pemrograman web dan mobile selama 3 hari untuk mahasiswa ITH.',
            'banner'          => null,
        ],
        [
            'judul'           => 'Seminar Nasional Teknologi & Inovasi',
            'nama_organisasi' => 'BEM – ITH',
            'tanggal'         => '2026-07-15',
            'lokasi'          => 'Aula Utama ITH Parepare',
            'deskripsi'       => 'Seminar nasional membahas perkembangan teknologi dan inovasi terkini di era digital.',
            'banner'          => null,
        ],
        [
            'judul'           => 'Pameran Seni ARATTA 2026',
            'nama_organisasi' => 'ARATTA – ITH',
            'tanggal'         => '2026-07-10',
            'lokasi'          => 'Gedung Serbaguna ITH',
            'deskripsi'       => 'Pameran karya seni mahasiswa ITH: lukisan, fotografi, dan pertunjukan musik live.',
            'banner'          => null,
        ],
        [
            'judul'           => 'Workshop Kewirausahaan Digital',
            'nama_organisasi' => 'Wirausaha (WITH) – ITH',
            'tanggal'         => '2026-07-05',
            'lokasi'          => 'Ruang Seminar Kampus ITH',
            'deskripsi'       => 'Workshop praktis membangun bisnis digital dari nol bersama mentor berpengalaman.',
            'banner'          => null,
        ],
        [
            'judul'           => 'Malam Keakraban BEM ITH 2026',
            'nama_organisasi' => 'BEM – ITH',
            'tanggal'         => '2026-06-28',
            'lokasi'          => 'Lapangan Olahraga ITH',
            'deskripsi'       => 'Malam keakraban dan pelantikan pengurus BEM ITH periode 2026/2027.',
            'banner'          => null,
        ],
    ];
}

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
        <!-- Cari Organisasi -->
        <div class="search-left">
            <i class="bi bi-search search-icon"></i>
            <input type="text" id="searchInput" name="q" class="search-input"
                   placeholder="Cari Organisasi" aria-label="Cari organisasi">
        </div>
        <div class="search-divider"></div>
        <!-- Pilih Organisasi -->
        <div class="search-middle">
            <select name="org" id="orgSelect" class="search-select" aria-label="Pilih organisasi"
                    onchange="handleOrgSelect(this)">
                <option value="">Pilih Organisasi</option>
                <?php foreach ($organisasi as $org): ?>
                <option value="<?= htmlspecialchars($org['slug']) ?>">
                    <?= htmlspecialchars($org['nama']) ?>
                </option>
                <?php endforeach; ?>
            </select>
            <i class="bi bi-chevron-down select-arrow"></i>
        </div>
        <div class="search-divider"></div>
        <!-- Pilih Kategori Organisasi -->
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

<script>
// Saat organisasi dipilih dari dropdown, langsung arahkan ke halaman organisasi tersebut
function handleOrgSelect(sel) {
    const slug = sel.value;
    if (slug) {
        window.location.href = '<?= BASE_URL ?>pages/organisasi/' + slug + '.php';
    }
}
</script>

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
                <!-- Foto/logo organisasi — ganti nilai src untuk mengubah gambar -->
                <div class="org-card-logo">
                    <img src="<?= htmlspecialchars($org['logo']) ?>"
                         alt="<?= htmlspecialchars($org['logo_alt'] ?? $org['nama']) ?>"
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

<!-- ═══════════ EVENT ORGANISASI ═══════════ -->
<section class="orgs-section" id="events-section">
    <div class="orgs-section-header" data-reveal>
        <h2>Event Organisasi Terbaru</h2>
        <p style="font-size:.9rem;color:#7a5a3a;margin-top:6px">Temukan kegiatan dan event terkini dari ORMAWA ITH</p>
    </div>

    <div class="ev-scroll-wrap">
        <?php
        $ev_colors = [
            'hero'     => ['#6B3A00','#C47A27'],
            'hcc'      => ['#1A3A5C','#2E6DA4'],
            'bem'      => ['#5C1A1A','#A43A2E'],
            'aratta'   => ['#2D4A1E','#5A8C3B'],
            'wirausaha'=> ['#3A2D5C','#6B4EA4'],
            'default'  => ['#8B4513','#C95611'],
        ];
        $ev_icons = [
            'hero'     => 'bi-gear-wide-connected',
            'hcc'      => 'bi-code-slash',
            'bem'      => 'bi-people-fill',
            'aratta'   => 'bi-palette2',
            'wirausaha'=> 'bi-briefcase',
            'default'  => 'bi-calendar-star',
        ];
        foreach ($hp_event_list as $hpev):
            $slug  = $hpev['organisasi_slug'] ?? 'default';
            $clr   = $ev_colors[$slug]  ?? $ev_colors['default'];
            $icon  = $ev_icons[$slug]   ?? $ev_icons['default'];
            $org   = htmlspecialchars($hpev['nama_organisasi'] ?? 'ORMAWA ITH');
            $judul = htmlspecialchars($hpev['judul']);
            $tgl   = date('d M Y', strtotime($hpev['tanggal']));
            $lok   = htmlspecialchars($hpev['lokasi']);
            $raw_d = $hpev['deskripsi'] ?? '';
            $desc  = htmlspecialchars(mb_substr($raw_d, 0, 110));
            $more  = mb_strlen($raw_d) > 110;
        ?>
        <div class="ev-card">
            <div class="ev-card-banner" style="background:linear-gradient(140deg,<?= $clr[0] ?>,<?= $clr[1] ?>)">
                <?php if (!empty($hpev['banner'])): ?>
                <img src="<?= BASE_URL . htmlspecialchars($hpev['banner']) ?>"
                     alt="Banner <?= $judul ?>">
                <?php else: ?>
                <div class="ev-banner-placeholder"><i class="bi <?= $icon ?>"></i></div>
                <?php endif; ?>
            </div>
            <div class="ev-card-body">
                <span class="ev-org-badge"><i class="bi bi-people-fill"></i> <?= $org ?></span>
                <h3 class="ev-title"><?= $judul ?></h3>
                <div class="ev-meta">
                    <span><i class="bi bi-calendar3"></i> <?= $tgl ?></span>
                    <span><i class="bi bi-geo-alt"></i> <?= $lok ?></span>
                </div>
                <?php if ($desc): ?><p class="ev-desc"><?= $desc ?><?= $more ? '...' : '' ?></p><?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <style>
    .ev-scroll-wrap {
        display:flex; gap:20px; overflow-x:auto;
        padding:8px 40px 24px;
        scroll-snap-type:x mandatory;
        -webkit-overflow-scrolling:touch;
        scrollbar-width:thin;
        scrollbar-color:var(--orange,#c95611) transparent;
    }
    .ev-scroll-wrap::-webkit-scrollbar       { height:5px; }
    .ev-scroll-wrap::-webkit-scrollbar-track { background:transparent; }
    .ev-scroll-wrap::-webkit-scrollbar-thumb { background:var(--orange,#c95611); border-radius:99px; }
    .ev-card {
        flex:0 0 270px; background:#fff; border:1px solid #e8d8c8;
        border-radius:20px; overflow:hidden;
        box-shadow:0 4px 18px rgba(100,50,20,.09);
        display:flex; flex-direction:column;
        scroll-snap-align:start;
        transition:transform .22s, box-shadow .22s;
    }
    .ev-card:hover { transform:translateY(-4px); box-shadow:0 12px 36px rgba(100,50,20,.17); }
    .ev-card-banner { position:relative; width:100%; height:148px; overflow:hidden; flex-shrink:0; }
    .ev-card-banner img { width:100%; height:100%; object-fit:cover; display:block; }
    .ev-banner-placeholder {
        width:100%; height:100%;
        display:flex; align-items:center; justify-content:center;
        font-size:2.6rem; color:rgba(255,255,255,.38);
    }
    .ev-card-body { padding:16px 18px 18px; display:flex; flex-direction:column; gap:6px; flex:1; }
    .ev-org-badge {
        display:inline-flex; align-items:center; gap:5px;
        font-size:.68rem; font-weight:700; color:var(--orange,#c95611);
        background:#fff4ec; border:1px solid #f0d4b8;
        border-radius:99px; padding:3px 10px; width:fit-content;
    }
    .ev-title { font-size:.92rem; font-weight:800; color:#2c1a0e; line-height:1.35; margin:2px 0 0; }
    .ev-meta  { display:flex; flex-direction:column; gap:3px; margin-top:2px; }
    .ev-meta span { display:flex; align-items:center; gap:6px; font-size:.72rem; color:#7a5a3a; }
    .ev-meta i { color:var(--orange,#c95611); font-size:.75rem; }
    .ev-desc  { font-size:.76rem; color:#5a4030; line-height:1.55; margin-top:4px; }
    @media (max-width:640px) {
        .ev-scroll-wrap { padding:8px 20px 16px; gap:14px; }
        .ev-card { flex:0 0 240px; }
    }
    </style>
</section>

<!-- ═══════════ TESTIMONI + STATS ═══════════ -->
<section class="testimoni-section" id="testimoni">
    <div class="testimoni-inner">

        <!-- KIRI: Bubble Chat Testimonial -->
        <div class="testimoni-left" data-reveal>
            <h2 class="testimoni-heading">Apa Kata Mahasiswa(i) ITH ?</h2>
            <p class="testimoni-sub">Pengalaman mereka bersama organisasi kampus</p>

            <div class="testimoni-bubbles">
                <?php foreach ($testimoni as $idx => $t): ?>
                <div class="bubble-wrap">
                    <div class="bubble <?= $idx === 0 ? 'bubble-sm' : 'bubble-lg' ?>">
                        <p>"<?= htmlspecialchars($t['isi']) ?>"</p>
                        <div class="bubble-tail"></div>
                    </div>
                    <div class="bubble-author">
                        <span class="bubble-name"><?= htmlspecialchars($t['nama']) ?></span>
                        <span class="bubble-role">–<?= htmlspecialchars($t['jabatan']) ?></span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- KANAN: Stat Cards -->
        <div class="stats-right" data-reveal>
            <?php foreach ($stats as $stat): ?>
            <div class="stat-ribbon-card">
                <div class="stat-ribbon-accent"></div>
                <div class="stat-num-box">
                    <span class="stat-num"
                          data-count="<?= htmlspecialchars($stat['angka']) ?>"
                          data-suffix="<?= htmlspecialchars($stat['suffix']) ?>">
                        0<?= htmlspecialchars($stat['suffix']) ?>
                    </span>
                </div>
                <div class="stat-ribbon-label"><?= htmlspecialchars($stat['label']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>

<!-- ═══════════ CONTACT SECTION ═══════════ -->
<section class="contact-section-wrap" id="contact">
    <div class="contact-container">

        <!-- KIRI + TENGAH: Contact Cards + Desc Box sejajar -->
        <div class="contact-left-area">
            <!-- Dua contact info card -->
            <div class="contact-cards-area">
                <div class="contact-info-card">
                    <div class="cic-label">Alamat:</div>
                    <div class="cic-val">Kampus Institut Teknologi B.J Habibie<br>Parepare, Sulawesi Selatan</div>
                </div>
                <div class="contact-info-card">
                    <div class="cic-label">Email:</div>
                    <a href="mailto:orcormawa@ith.ac.id" class="cic-val cic-link">orcormawa@ith.ac.id</a>
                    <div class="cic-label" style="margin-top:12px">Telepon:</div>
                    <div class="cic-val">+62 1234 5678 910</div>
                </div>
                <!-- Box putih deskripsi — melebar dari tengah ke kanan card -->
                <div class="contact-info-card contact-desc-card">
                    <p class="contact-desc-text">Memiliki pertanyaan atau membutuhkan informasi terkait organisasi mahasiswa? Hubungi kami melalui kontak berikut.</p>
                </div>
            </div>
        </div>

        <!-- KANAN: CONTACTS heading -->
        <div class="contact-text-area">
            <div class="contacts-big-heading">C O N T A C T S</div>
        </div>

    </div>
</section>

<!-- ═══════════ FOOTER ═══════════ -->
<footer class="orc-footer">
    <p class="orc-footer-copy">© <?= date('Y') ?> ORC ORMAWA ITH — Institut Teknologi B.J Habibie</p>
</footer>

<?php require_once '../../components/footer_scripts.php'; ?>
</body>
</html>
