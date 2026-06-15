<?php
// pages/organisasi/bem.php — BEM ITH 2026 Landing Page
require_once '../../config/connection.php';

$page_title   = 'BEM ITH 2026 — Organization Resource Center';
$page_css     = ['bem.css'];
$page_js      = ['bem.js'];
$current_page = 'bem';

$BASE = BASE_URL;
$org_slug = 'BEM'; // identifier untuk filter query

// ── Cek apakah kolom organisasi sudah ada di tabel kegiatan ──────
$has_org_col = user_col_exists($conn, 'organisasi'); // reuse helper dari connection.php

// Helper: cek kolom di tabel selain users
function bem_col_check(mysqli $conn, string $table, string $col): bool {
    $t = $conn->real_escape_string($table);
    $c = $conn->real_escape_string($col);
    $r = $conn->query("SELECT COUNT(*) AS n FROM information_schema.COLUMNS
                       WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='$t' AND COLUMN_NAME='$c'");
    return $r && $r->fetch_assoc()['n'] > 0;
}

// ── Query kegiatan BEM dari DB ────────────────────────────────────
$kegiatan_db = [];
if (bem_col_check($conn, 'kegiatan', 'organisasi')) {
    // Filter berdasarkan kolom organisasi
    $stmt = $conn->prepare(
        "SELECT * FROM kegiatan WHERE organisasi LIKE ? ORDER BY tanggal DESC LIMIT 6"
    );
    $like = '%BEM%';
    $stmt->bind_param('s', $like);
    $stmt->execute();
    $kegiatan_db = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    // Kolom belum ada → ambil semua kegiatan terbaru (fallback)
    $r = $conn->query("SELECT * FROM kegiatan ORDER BY tanggal DESC LIMIT 6");
    if ($r) $kegiatan_db = $r->fetch_all(MYSQLI_ASSOC);
}

// ── Query anggota BEM dari DB ─────────────────────────────────────
$anggota_db = [];
if (bem_col_check($conn, 'anggota', 'organisasi')) {
    $stmt = $conn->prepare(
        "SELECT a.*, u.nama AS nama_user, u.jabatan AS jabatan_user
         FROM anggota a
         LEFT JOIN users u ON a.user_id = u.id
         WHERE a.organisasi LIKE ?
         ORDER BY a.tanggal_daftar DESC LIMIT 8"
    );
    $like = '%BEM%';
    $stmt->bind_param('s', $like);
    $stmt->execute();
    $anggota_db = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    // Fallback: ambil dari tabel users yang punya organisasi BEM
    $stmt = $conn->prepare(
        "SELECT id, nama, jabatan, organisasi, angkatan FROM users
         WHERE organisasi LIKE ? AND status='Aktif' ORDER BY nama LIMIT 8"
    );
    $like = '%BEM%';
    $stmt->bind_param('s', $like);
    $stmt->execute();
    $anggota_db = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
}

// ── Hitung stats ──────────────────────────────────────────────────
$total_kegiatan = count($kegiatan_db);
$total_anggota  = count($anggota_db);

$programs = [
    [
        'cat'   => 'Olahraga & Seni',
        'title' => 'PORSENI ITH',
        'desc'  => 'Pekan Olahraga dan Seni ITH — ajang kompetisi antar mahasiswa dalam bidang olahraga, seni, dan kreativitas kampus.',
        'icon'  => '🏆',
        'color' => 'linear-gradient(135deg,#D8893D,#8C5A32)',
    ],
    [
        'cat'   => 'Budaya & Kreativitas',
        'title' => 'Festival Seni ITH 2026',
        'desc'  => 'Festival seni tahunan yang menampilkan pertunjukan teater, musik, pameran karya, dan ekspresi kreatif mahasiswa ITH.',
        'icon'  => '🎨',
        'color' => 'linear-gradient(135deg,#E6B07B,#D8893D)',
    ],
    [
        'cat'   => 'Akademik & Kompetisi',
        'title' => 'Habibie Competition',
        'desc'  => 'Kompetisi ilmiah dan teknologi bergengsi tingkat nasional yang diselenggarakan oleh BEM ITH setiap tahunnya.',
        'icon'  => '🚀',
        'color' => 'linear-gradient(135deg,#5C3518,#8C5A32)',
    ],
];

require_once '../../components/header.php';
require_once '../../components/navbar.php';
?>

<!-- ═══════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════ -->
<section class="bem-hero" id="home">
    <div class="bem-hero-bg"></div>
    <div class="bem-hero-grain"></div>

    <!-- Left Poster -->
    <div class="hero-poster-left">
        <div class="poster-placeholder" style="height:300px;background:linear-gradient(160deg,#D8893D,#5C3518)">
            <div class="logo-big">BEM</div>
            <div class="event-title">FILOSOFT FESTIVAL<br>2026</div>
        </div>
        <div class="poster-label">Filosoft · Event Kampus</div>
    </div>

    <!-- Right Poster -->
    <div class="hero-poster-right">
        <div class="poster-placeholder" style="height:260px;background:linear-gradient(160deg,#8C5A32,#2A1A08)">
            <div class="logo-big" style="font-size:1.8rem">#FA8943</div>
            <div class="event-title" style="font-size:.72rem">#925630</div>
        </div>
        <div class="poster-code">#BEM ITH 2026</div>
    </div>

    <!-- Center -->
    <div class="bem-hero-center">
        <div class="bem-hero-tag">BEM ITH 2026</div>
        <div class="bem-hero-logo-wrap">
            <img src="<?= $BASE ?>assets/img/logo/logo-bem.jpeg" alt="BEM ITH"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
            <div class="bem-hero-logo-fallback" style="display:none">BEM<br>ITH</div>
        </div>
        <h1 class="bem-hero-title">BEM<span>ITH</span></h1>
        <p class="bem-hero-subtitle">Badan Eksekutif Mahasiswa &nbsp;·&nbsp; Institut Teknologi Habibie</p>
        <a href="#programs" class="btn-hero-cta">View Our Programs ↓</a>
    </div>

    <div class="hero-scroll-hint">
        <span>Scroll</span>
        <div class="scroll-line"></div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     ABOUT SECTION
═══════════════════════════════════════ -->
<section class="about-section" id="about">
    <div class="container">
        <div class="about-grid">

            <!-- Left: Logo + Text -->
            <div class="about-left" data-reveal-left>
                <div class="about-logo-box">
                    <img src="<?= $BASE ?>assets/img/logo/logo-bem.jpeg" alt="Logo BEM ITH"
                         class="about-logo-img"
                         onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
                    <div class="about-logo-fallback" style="display:none">BEM</div>
                    <div>
                        <div class="about-org-name">BEM ITH<br>2026</div>
                        <div class="about-org-year">Badan Eksekutif Mahasiswa</div>
                    </div>
                </div>

                <div>
                    <div class="eyebrow">Tentang Kami</div>
                    <h2 class="about-title">Wadah Aspirasi<br>Mahasiswa ITH</h2>
                </div>

                <p class="about-body">
                    Badan Eksekutif Mahasiswa (BEM) adalah organisasi intra-kampus mahasiswa tertinggi yang menjalankan fungsi eksekutif di lingkungan Institut Teknologi Habibie. BEM ITH berkomitmen menjadi wadah aspirasi, pengembangan diri mahasiswa, serta koordinasi kegiatan kampus secara menyeluruh.
                </p>
                <p class="about-body">
                    BEM ITH harapan sebagai wadah aspirasi dan perjuangan, untuk mengawal setiap langkah, kejadian, serta masalah yang ada di lingkungan kampus maupun diluar kampus.
                </p>

                <div class="about-tags">
                    <span class="tag">Aspirasi Mahasiswa</span>
                    <span class="tag">Pengembangan Diri</span>
                    <span class="tag">Koordinasi Kampus</span>
                    <span class="tag">Kepemimpinan</span>
                    <span class="tag">Inovasi</span>
                </div>
            </div>

            <!-- Right: Photo Collage -->
            <div class="about-right" data-reveal-right>
                <div class="photo-collage">
                    <!-- Card 1 — tall left -->
                    <div class="photo-card tall">
                        <div class="photo-placeholder" style="background:linear-gradient(160deg,#E6B07B,#D8893D)">
                            <span>🏆</span>
                            <span>Habibie Competition</span>
                        </div>
                    </div>
                    <!-- Card 2 — top right -->
                    <div class="photo-card">
                        <div class="photo-placeholder" style="background:linear-gradient(160deg,#D8893D,#8C5A32)">
                            <span>🎓</span>
                            <span>Seminar Nasional</span>
                        </div>
                    </div>
                    <!-- Card 3 — bottom right -->
                    <div class="photo-card">
                        <div class="photo-placeholder" style="background:linear-gradient(160deg,#8C5A32,#5C3518)">
                            <span>📋</span>
                            <span>Kepanitiaan</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     VISION SECTION
═══════════════════════════════════════ -->
<section class="vision-section" id="vision">
    <div data-reveal>
        <div class="vision-eyebrow">Visi & Semangat</div>
        <blockquote class="vision-text">
            "BEM ITH adalah <em>garda terdepan</em> dalam mewujudkan mahasiswa yang berdaya, berkarakter, dan mampu memberikan kontribusi nyata bagi kampus serta masyarakat sekitarnya."
        </blockquote>
        <div class="vision-author">— BEM ITH 2026, Institut Teknologi Bacharuddin Jusuf Habibie</div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     GALLERY / POSTER SECTION
═══════════════════════════════════════ -->
<section class="gallery-section" id="gallery">
    <div class="gallery-header" data-reveal>
        <div class="eyebrow" style="text-align:center">Galeri Kegiatan</div>
        <h2>Momen &amp; Poster</h2>
    </div>
    <div class="poster-row">
        <div class="poster-card" data-reveal>
            <div class="poster-card-inner">
                <div class="poster-placeholder" style="width:100%;height:100%">
                    <div class="logo-big">BEM</div>
                    <div class="event-title">FILOSOFT<br>FESTIVAL</div>
                </div>
                <div class="poster-content">
                    <div class="p-tag">Event Kampus</div>
                    <div class="p-title">Filosoft Festival 2026</div>
                </div>
            </div>
        </div>
        <div class="poster-card" data-reveal>
            <div class="poster-card-inner">
                <div class="poster-placeholder" style="width:100%;height:100%;background:linear-gradient(160deg,#8C5A32,#2A1A08)">
                    <div class="logo-big">🏆</div>
                    <div class="event-title">HABIBIE<br>COMPETITION</div>
                </div>
                <div class="poster-content">
                    <div class="p-tag">Kompetisi Nasional</div>
                    <div class="p-title">Habibie Competition 2025</div>
                </div>
            </div>
        </div>
        <div class="poster-card" data-reveal>
            <div class="poster-card-inner">
                <div class="poster-placeholder" style="width:100%;height:100%;background:linear-gradient(160deg,#E6B07B,#8C5A32)">
                    <div class="logo-big">🎯</div>
                    <div class="event-title">OPEN<br>RECRUITMENT</div>
                </div>
                <div class="poster-content">
                    <div class="p-tag">Rekrutmen Anggota</div>
                    <div class="p-title">Open Recruitment BEM ITH</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     PROGRAMS SECTION
═══════════════════════════════════════ -->
<section class="programs-section" id="programs">
    <div class="container">
        <div class="programs-header" data-reveal>
            <div class="section-eyebrow">Program Kerja</div>
            <h2>Our <em>Programs</em> -</h2>
        </div>
        <div class="programs-grid">
            <?php foreach ($programs as $i => $p): ?>
            <div class="program-card" data-reveal style="animation-delay: <?= $i * .12 ?>s">
                <div class="program-img">
                    <div class="program-img-placeholder" style="background: <?= $p['color'] ?>">
                        <span style="font-size:2.5rem"><?= $p['icon'] ?></span>
                        <span><?= htmlspecialchars($p['cat']) ?></span>
                    </div>
                </div>
                <div class="program-body">
                    <div class="program-cat"><?= htmlspecialchars($p['cat']) ?></div>
                    <div class="program-title"><?= htmlspecialchars($p['title']) ?></div>
                    <div class="program-desc"><?= htmlspecialchars($p['desc']) ?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     KEGIATAN LIVE (dari database)
═══════════════════════════════════════ -->
<section class="live-section" id="kegiatan-db">
    <div class="container">
        <div class="live-header" data-reveal>
            <div>
                <div class="eyebrow">Data Real · Database</div>
                <h2 class="live-title">Kegiatan BEM ITH</h2>
            </div>
            <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="<?= BASE_URL ?>pages/dashboard/dashboard.php?tab=kegiatan" class="btn-live-add">
                <i class="bi bi-plus-lg"></i> Tambah Kegiatan
            </a>
            <?php endif; ?>
        </div>

        <?php if (empty($kegiatan_db)): ?>
        <div class="live-empty" data-reveal>
            <div class="live-empty-icon"><i class="bi bi-calendar-x"></i></div>
            <p class="live-empty-title">Belum ada kegiatan tercatat</p>
            <p class="live-empty-sub">
                <?php if (!empty($_SESSION['user_id'])): ?>
                    Tambahkan kegiatan BEM melalui <a href="<?= BASE_URL ?>pages/dashboard/dashboard.php?tab=kegiatan">Dashboard</a>.
                <?php else: ?>
                    <a href="<?= BASE_URL ?>pages/login/login.php">Login</a> untuk menambahkan kegiatan.
                <?php endif; ?>
            </p>
        </div>
        <?php else: ?>
        <div class="live-grid" data-reveal>
            <?php foreach ($kegiatan_db as $k):
                $status_class = strtolower(str_replace(' ', '-', $k['status'] ?? 'terjadwal'));
            ?>
            <div class="live-card">
                <div class="live-card-top">
                    <span class="live-status <?= e($status_class) ?>"><?= e($k['status'] ?? 'Terjadwal') ?></span>
                    <span class="live-date"><i class="bi bi-calendar3"></i> <?= date('d M Y', strtotime($k['tanggal'])) ?></span>
                </div>
                <div class="live-card-body">
                    <div class="live-card-jenis"><?= e($k['jenis_kegiatan']) ?></div>
                    <h4 class="live-card-nama"><?= e($k['nama_kegiatan']) ?></h4>
                    <?php if (!empty($k['deskripsi'])): ?>
                    <p class="live-card-desc"><?= e(mb_substr($k['deskripsi'], 0, 80)) ?><?= mb_strlen($k['deskripsi']) > 80 ? '...' : '' ?></p>
                    <?php endif; ?>
                </div>
                <div class="live-card-foot">
                    <i class="bi bi-geo-alt"></i> <?= e($k['tempat']) ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ═══════════════════════════════════════
     ANGGOTA LIVE (dari database)
═══════════════════════════════════════ -->
<section class="live-section live-section-alt" id="anggota-db">
    <div class="container">
        <div class="live-header" data-reveal>
            <div>
                <div class="eyebrow">Data Real · Database</div>
                <h2 class="live-title">Anggota BEM ITH</h2>
            </div>
            <?php if (!empty($_SESSION['user_id'])): ?>
            <a href="<?= BASE_URL ?>pages/dashboard/dashboard.php?tab=anggota" class="btn-live-add">
                <i class="bi bi-person-plus"></i> Tambah Anggota
            </a>
            <?php endif; ?>
        </div>

        <?php if (empty($anggota_db)): ?>
        <div class="live-empty" data-reveal>
            <div class="live-empty-icon"><i class="bi bi-person-slash"></i></div>
            <p class="live-empty-title">Belum ada anggota terdaftar</p>
            <p class="live-empty-sub">
                <?php if (!empty($_SESSION['user_id'])): ?>
                    Daftarkan anggota melalui <a href="<?= BASE_URL ?>pages/dashboard/dashboard.php?tab=anggota">Dashboard</a>.
                <?php else: ?>
                    <a href="<?= BASE_URL ?>pages/login/login.php">Login</a> untuk menambahkan anggota.
                <?php endif; ?>
            </p>
        </div>
        <?php else: ?>
        <div class="anggota-grid" data-reveal>
            <?php foreach ($anggota_db as $a):
                $nm    = $a['nama'] ?? $a['nama_user'] ?? 'Anggota';
                $jab   = $a['jabatan'] ?? $a['jabatan_user'] ?? 'Anggota';
                $words = preg_split('/\s+/', trim($nm));
                $init  = mb_strtoupper(mb_substr($words[0], 0, 1));
                if (count($words) > 1) $init .= mb_strtoupper(mb_substr($words[1], 0, 1));
            ?>
            <div class="anggota-card">
                <div class="anggota-avatar"><?= e($init) ?></div>
                <div class="anggota-info">
                    <div class="anggota-nama"><?= e($nm) ?></div>
                    <div class="anggota-jabatan"><?= e($jab) ?></div>
                    <?php if (!empty($a['angkatan'])): ?>
                    <div class="anggota-angkatan">Angkatan <?= e($a['angkatan']) ?></div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ═══════════════════════════════════════
     CONTACT SECTION
═══════════════════════════════════════ -->
<section class="contact-section" id="contact">
    <div class="container">
        <div class="contact-inner" data-reveal>
            <div class="contact-eyebrow">Get In Touch</div>
            <h2 class="contact-title">Write a Message</h2>

            <form class="contact-form" method="POST" action="#" onsubmit="handleContact(event)">
                <div class="form-row-2">
                    <div class="form-field">
                        <label>Name</label>
                        <input type="text" name="contact_name" placeholder="Nama lengkap" required>
                    </div>
                    <div class="form-field">
                        <label>Email Address</label>
                        <input type="email" name="contact_email" placeholder="email@example.com" required>
                    </div>
                </div>
                <div class="form-row-2">
                    <div class="form-field">
                        <label>Phone</label>
                        <input type="tel" name="contact_phone" placeholder="08xx-xxxx-xxxx">
                    </div>
                    <div class="form-field">
                        <label>Subject</label>
                        <input type="text" name="contact_subject" placeholder="Perihal pesan..." required>
                    </div>
                </div>
                <div class="form-field">
                    <label>Message</label>
                    <textarea name="contact_message" placeholder="Tulis pesanmu di sini..." required></textarea>
                </div>
                <button type="submit" class="btn-send">
                    <i class="bi bi-send-fill"></i> Send Message
                </button>
                <div id="contactFeedback" style="display:none;margin-top:10px;font-size:.82rem;color:var(--brown);font-weight:600"></div>
            </form>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════
     FOOTER
═══════════════════════════════════════ -->
<footer class="bem-footer">
    <div class="footer-socials">
        <a href="#" class="footer-social-btn" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="footer-social-btn" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
        <a href="#" class="footer-social-btn" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
        <a href="mailto:bem@ith.ac.id" class="footer-social-btn" aria-label="Email"><i class="bi bi-envelope-fill"></i></a>
    </div>
    <p class="footer-copy">© <?= date('Y') ?> BEM ITH Website | Organization Resource Center</p>
</footer>

<script>
// ── Scroll Reveal ────────────────────────────────────────
const reveals = document.querySelectorAll('[data-reveal],[data-reveal-left],[data-reveal-right]');
const io = new IntersectionObserver(entries => {
    entries.forEach((e, i) => {
        if (e.isIntersecting) {
            const delay = parseFloat(e.target.style.animationDelay || '0') * 1000;
            setTimeout(() => e.target.classList.add('revealed'), delay);
            io.unobserve(e.target);
        }
    });
}, { threshold: 0.12 });
reveals.forEach(el => io.observe(el));

// ── Contact form feedback ────────────────────────────────
function handleContact(e) {
    e.preventDefault();
    const fb = document.getElementById('contactFeedback');
    fb.style.display = 'block';
    fb.textContent = '✓ Pesan berhasil dikirim! Kami akan segera menghubungi kamu.';
    e.target.reset();
    setTimeout(() => { fb.style.display = 'none'; }, 5000);
}

// ── Smooth scrolling ─────────────────────────────────────
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const target = document.getElementById(a.getAttribute('href').slice(1));
        if (target) { e.preventDefault(); target.scrollIntoView({ behavior: 'smooth', block: 'start' }); }
    });
});
</script>

<?php
$page_js = [];
require_once '../../components/footer_scripts.php';
?>
</body>
</html>
