<?php
/**
 * _org_template.php — Shared template generator untuk halaman organisasi
 * Dipanggil oleh hero.php, hcc.php, aratta.php, wirausaha.php
 * Variabel yang harus di-set sebelum include file ini:
 *   $org_slug, $org_name, $org_full, $org_year, $org_tagline,
 *   $org_about_1, $org_about_2, $org_tags, $org_vision,
 *   $org_logo_file, $org_logo_fallback,
 *   $org_collage, $org_posters, $programs,
 *   $hero_grad_l, $hero_grad_r,
 *   $poster_l_grad, $poster_l_label, $poster_r_grad, $poster_r_label,
 *   $contact_email, $current_page
 */
require_once '../../config/connection.php';

// ── DB Query helper ─────────────────────────────────────────────────
if (!function_exists('tbl_col_exists')) {
    function tbl_col_exists(mysqli $conn, string $table, string $col): bool {
        $t = $conn->real_escape_string($table);
        $c = $conn->real_escape_string($col);
        $r = $conn->query("SELECT COUNT(*) AS n FROM information_schema.COLUMNS
                           WHERE TABLE_SCHEMA=DATABASE() AND TABLE_NAME='$t' AND COLUMN_NAME='$c'");
        return $r && $r->fetch_assoc()['n'] > 0;
    }
}

$page_css = ['bem.css'];
$page_js  = ['bem.js'];
$BASE     = BASE_URL;

require_once '../../components/header.php';
require_once '../../components/navbar.php';
?>

<section class="bem-hero" id="home"
  style="background:linear-gradient(160deg,<?= $hero_grad_l ?> 0%,<?= $hero_grad_r ?> 100%)">
    <div class="bem-hero-grain"></div>

    <div class="hero-poster-left">
        <?php if (!empty($poster_l_img)): ?>
         <div style="height:300px;padding:0;overflow:hidden">
           <img src="<?= $BASE . e($poster_l_img) ?>" alt="<?= e($org_name) ?>"
            style="width:100%;height:100%;object-fit:cover;border-radius:inherit;filter:none !important;opacity:1 !important;mix-blend-mode:normal !important;"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
            <div class="logo-big" style="display:none"><?= $org_logo_fallback ?></div>
        </div>
        <?php else: ?>
        <div class="poster-placeholder" style="height:300px;background:<?= $poster_l_grad ?>">
            <div class="logo-big"><?= $org_logo_fallback ?></div>
            <div class="event-title"><?= $poster_l_label ?></div>
        </div>
        <?php endif; ?>
        <div class="poster-label"><?= e($org_slug) ?> · Event Kampus</div>
    </div>

    <div class="hero-poster-right">
        <?php if (!empty($poster_r_img)): ?>
         <div style="height:260px;padding:0;overflow:hidden">
            <img src="<?= $BASE . e($poster_r_img) ?>" alt="<?= e($org_name) ?>"
                style="width:100%;height:100%;object-fit:cover;border-radius:inherit;filter:brightness(1.5);"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
            <div class="logo-big" style="display:none;font-size:1.5rem"><?= $org_logo_fallback ?></div>
        </div>
        <?php else: ?>
        <div class="poster-placeholder" style="height:260px;background:<?= $poster_r_grad ?>">
            <div class="logo-big" style="font-size:1.5rem"><?= $org_logo_fallback ?></div>
            <div class="event-title" style="font-size:.75rem"><?= e($org_year) ?></div>
        </div>
        <?php endif; ?>
        <div class="poster-code">#<?= e($org_slug) ?> ITH <?= e($org_year) ?></div>
    </div>

    <div class="bem-hero-center">
        <div class="bem-hero-tag"><?= e($org_slug) ?> ITH <?= e($org_year) ?></div>
        <div class="bem-hero-logo-wrap">
            <img src="<?= $BASE ?>assets/img/logo/logo-<?= strtolower(e($org_slug)) ?>.png" alt="<?= e($org_name) ?>"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
            <div class="bem-hero-logo-fallback" style="display:none"><?= $org_logo_fallback ?></div>
        </div>
        <h1 class="bem-hero-title"><?= $org_logo_fallback ?><span>ITH</span></h1>
        <p class="bem-hero-subtitle"><?= e($org_full) ?> &nbsp;·&nbsp; Institut Teknologi Habibie</p>
        <a href="#programs" class="btn-hero-cta">View Our Programs ↓</a>
    </div>

    <div class="hero-scroll-hint"><span>Scroll</span><div class="scroll-line"></div></div>
</section>

<!-- ABOUT -->
<section class="about-section" id="about">
<div class="container"><div class="about-grid">
    <div class="about-left" data-reveal-left>
        <div class="about-logo-box">
            <img src="<?= $BASE ?>assets/img/logo/logo-<?= strtolower(e($org_slug)) ?>.png"
                 alt="Logo <?= e($org_name) ?>" class="about-logo-img"
                 onerror="this.style.display='none';this.nextElementSibling.style.display='flex'">
            <div class="about-logo-fallback" style="display:none"><?= $org_logo_fallback ?></div>
            <div>
                <div class="about-org-name"><?= e($org_name) ?><br><?= e($org_year) ?></div>
                <div class="about-org-year"><?= e($org_full) ?></div>
            </div>
        </div>
        <div>
            <div class="eyebrow">Tentang Kami</div>
            <h2 class="about-title"><?= $org_tagline ?></h2>
        </div>
        <p class="about-body"><?= e($org_about_1) ?></p>
        <p class="about-body"><?= e($org_about_2) ?></p>
        <div class="about-tags">
            <?php foreach ($org_tags as $t): ?>
            <span class="tag"><?= e($t) ?></span>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="about-right" data-reveal-right>
        <div class="photo-collage">
            <?php foreach ($org_collage as $c): ?>
           <div class="photo-card <?= $c['class'] ?? '' ?>">
    <?php if (!empty($c['img'])): ?>
    <img src="<?= $BASE . e($c['img']) ?>" alt="<?= e($c['label']) ?>"
         style="width:100%;height:100%;object-fit:cover;border-radius:inherit;">
    <?php else: ?>
            <div class="photo-placeholder" style="background:<?= $c['grad'] ?>">
                <span><?= $c['icon'] ?></span>
                <span><?= e($c['label']) ?></span>
            </div>
            <?php endif; ?>
        </div>
            <?php endforeach; ?>
        </div>
    </div>
</div></div>
</section>

<!-- VISION -->
<section class="vision-section" id="vision">
<div data-reveal>
    <div class="vision-eyebrow">Visi &amp; Semangat</div>
    <blockquote class="vision-text"><?= $org_vision ?></blockquote>
    <div class="vision-author">— <?= e($org_name) ?> <?= e($org_year) ?>, Institut Teknologi Bacharuddin Jusuf Habibie</div>
</div>
</section>

<!-- POSTER GALLERY -->
<section class="gallery-section" id="gallery">
<div class="gallery-header" data-reveal>
    <div class="eyebrow" style="text-align:center">Galeri Kegiatan</div>
    <h2>Momen &amp; Poster</h2>
</div>
<div class="poster-row">
    <?php foreach ($org_posters as $p): ?>
    <div class="poster-card" data-reveal>
        <div class="poster-card-inner">
            <?php if (!empty($p['img'])): ?>
            <div class="poster-placeholder" style="width:100%;height:100%;background:<?= $p['grad'] ?>;padding:0;overflow:hidden">
                <img src="<?= $BASE . e($p['img']) ?>" alt="<?= e($p['title']) ?>"
                     style="width:100%;height:100%;object-fit:cover;border-radius:inherit;"
                     onerror="this.style.display='none';this.parentElement.style.display='flex'">
            </div>
            <?php else: ?>
            <div class="poster-placeholder" style="width:100%;height:100%;background:<?= $p['grad'] ?>">
                <div class="logo-big"><?= $p['icon'] ?></div>
                <div class="event-title"><?= e($p['title']) ?></div>
            </div>
            <?php endif; ?>
            <div class="poster-content">
                <div class="p-tag"><?= e($p['tag']) ?></div>
                <div class="p-title"><?= e($p['subtitle']) ?></div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
</section>

<!-- PROGRAMS -->
<section class="programs-section" id="programs">
<div class="container">
    <div class="programs-header" data-reveal>
        <div class="section-eyebrow">Program Kerja</div>
        <h2>Our <em>Programs</em> -</h2>
    </div>
    <div class="programs-grid">
        <?php foreach ($programs as $i => $p): ?>
        <div class="program-card" data-reveal style="animation-delay:<?= $i*.12 ?>s">
            <div class="program-img">
                <?php if (!empty($p['img'])): ?>
                <img src="<?= $BASE . e($p['img']) ?>" alt="<?= htmlspecialchars($p['title']) ?>"
                     style="width:100%;height:100%;object-fit:cover;">
                <?php else: ?>
                <div class="program-img-placeholder" style="background:<?= $p['color'] ?>">
                    <span style="font-size:2.5rem"><?= $p['icon'] ?></span>
                    <span><?= htmlspecialchars($p['cat']) ?></span>
                </div>
                <?php endif; ?>
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

<!-- CONTACT -->
<section class="contact-section" id="contact">
<div class="container">
    <div class="contact-inner" data-reveal>
        <div class="contact-eyebrow">Get In Touch</div>
        <h2 class="contact-title">Write a Message</h2>
        <form class="contact-form" method="POST" action="#" onsubmit="handleContact(event)">
            <div class="form-row-2">
                <div class="form-field"><label>Name</label><input type="text" name="contact_name" placeholder="Nama lengkap" required></div>
                <div class="form-field"><label>Email Address</label><input type="email" name="contact_email" placeholder="email@example.com" required></div>
            </div>
            <div class="form-row-2">
                <div class="form-field"><label>Phone</label><input type="tel" name="contact_phone" placeholder="08xx-xxxx-xxxx"></div>
                <div class="form-field"><label>Subject</label><input type="text" name="contact_subject" placeholder="Perihal pesan..." required></div>
            </div>
            <div class="form-field"><label>Message</label><textarea name="contact_message" placeholder="Tulis pesanmu di sini..." required></textarea></div>
            <button type="submit" class="btn-send"><i class="bi bi-send-fill"></i> Send Message</button>
            <div id="contactFeedback" style="display:none;margin-top:10px;font-size:.82rem;color:var(--brown);font-weight:600"></div>
        </form>
    </div>
</div>
</section>

<!-- FOOTER -->
<footer class="bem-footer">
    <div class="footer-socials">
        <a href="#" class="footer-social-btn" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
        <a href="#" class="footer-social-btn" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
        <a href="#" class="footer-social-btn" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
        <a href="mailto:<?= e($contact_email) ?>" class="footer-social-btn" aria-label="Email"><i class="bi bi-envelope-fill"></i></a>
    </div>
    <p class="footer-copy">© <?= date('Y') ?> <?= e($org_name) ?> Website | Organization Resource Center</p>
</footer>

<script>
const reveals = document.querySelectorAll('[data-reveal],[data-reveal-left],[data-reveal-right]');
const io = new IntersectionObserver(entries => {
    entries.forEach(e => {
        if (e.isIntersecting) {
            const d = parseFloat(e.target.style.animationDelay||'0')*1000;
            setTimeout(()=>e.target.classList.add('revealed'), d);
            io.unobserve(e.target);
        }
    });
}, {threshold:.12});
reveals.forEach(el => io.observe(el));

function handleContact(e) {
    e.preventDefault();
    const fb = document.getElementById('contactFeedback');
    fb.style.display='block';
    fb.textContent='✓ Pesan berhasil dikirim! Kami akan segera menghubungi kamu.';
    e.target.reset();
    setTimeout(()=>{fb.style.display='none';},5000);
}
document.querySelectorAll('a[href^="#"]').forEach(a=>{
    a.addEventListener('click',e=>{
        const t=document.getElementById(a.getAttribute('href').slice(1));
        if(t){e.preventDefault();t.scrollIntoView({behavior:'smooth',block:'start'});}
    });
});
</script>
<?php $page_js=[]; require_once '../../components/footer_scripts.php'; ?>
</body>
</html>