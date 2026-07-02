<?php
require_once '../../config/connection.php';

$page_title   = 'BEM ITH 2026 — Organization Resource Center';
$page_css     = ['bem.css'];
$page_js      = ['bem.js'];
$current_page = 'bem';

$BASE = BASE_URL;
$org_slug = 'BEM'; 

$programs = [
    [
        'cat'   => 'Olahraga & Seni',
        'title' => 'PORSENI ITH',
        'desc'  => 'Pekan Olahraga dan Seni ITH — ajang kompetisi antar mahasiswa dalam bidang olahraga, seni, dan kreativitas kampus.',
        'icon'  => '🏆',
        'color' => 'linear-gradient(135deg,#D8893D,#8C5A32)',
        'img'   => $BASE . 'assets/img/bem/PORSENI_ITH.jpeg',
    ],
    [
        'cat'   => 'Budaya & Kreativitas',
        'title' => 'Festival Seni ITH 2026',
        'desc'  => 'Festival seni tahunan yang menampilkan pertunjukan teater, musik, pameran karya, dan ekspresi kreatif mahasiswa ITH.',
        'icon'  => '🎨',
        'color' => 'linear-gradient(135deg,#E6B07B,#D8893D)',
        'img'   => $BASE . 'assets/img/bem/FESTIVAL_SENI_ITH.jpeg',
    ],
    [
        'cat'   => 'Akademik & Kompetisi',
        'title' => 'Habibie Competition',
        'desc'  => 'Kompetisi ilmiah dan teknologi bergengsi tingkat nasional yang diselenggarakan oleh BEM ITH setiap tahunnya.',
        'icon'  => '🚀',
        'color' => 'linear-gradient(135deg,#5C3518,#8C5A32)',
        'img'   => $BASE . 'assets/img/bem/HABIBIE_COMPETITION.jpeg',
    ],
];

require_once '../../components/header.php';
require_once '../../components/navbar.php';
?>


<section class="bem-hero" id="home">
    <div class="bem-hero-bg"></div>
    <div class="bem-hero-grain"></div>

    <div class="hero-poster-left">
            <img src="<?= $BASE ?>assets/img/bem/POSTER_FILOSOFI.jpeg" 
                alt="Filosoft Festival 2026"
                style="width:100%;height:100%;object-fit:cover;border-radius:inherit;"
                onerror="this.style.display='none'">
            <div class="logo-big" style="font-family:'DM Sans',sans-serif; font-size:1.1rem; font-weight:700; color:#fff; text-align:center; letter-spacing:.04em;">BEM</div>
<div class="event-title" style="font-family:'DM Sans',sans-serif; font-size:.82rem; font-weight:700; color:rgba(255,255,255,.9); text-align:center; letter-spacing:.04em; line-height:1.5;">FILOSOFT FESTIVAL<br>2026</div>
        </div>
    </div>

    <div class="hero-poster-right">
            <img src="<?= $BASE ?>assets/img/bem/POSTER_WARNA.jpeg" 
                alt="FA8943"
                style="width:100%;height:100%;object-fit:cover;border-radius:inherit;"
                onerror="this.style.display='none'">   
           <div class="logo-big" style="font-family:'DM Sans',sans-serif; font-size:1.1rem; font-weight:700; color:#fff; text-align:center; letter-spacing:.04em;">#FA8943</div>
            <div class="event-title" style="font-family:'DM Sans',sans-serif; font-size:.82rem; font-weight:700; color:rgba(255,255,255,.9); text-align:center; letter-spacing:.04em;">#925630</div>
        </div>
    </div>

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

<section class="about-section" id="about">
    <div class="container">
        <div class="about-grid">

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

            <div class="about-right" data-reveal-right>
                <div class="photo-collage">
                    <div class="photo-card tall">
                        <img src="<?= $BASE ?>assets/img/bem/BEM 2.jpeg" alt="LKKM-TD 2025"
                            style="width:100%;height:100%;object-fit:cover;border-radius:inherit;">
                    </div>
                    <div class="photo-card">
                        <img src="<?= $BASE ?>assets/img/bem/BEM 3.jpeg" alt="Pelatihan KTI"
                            style="width:100%;height:100%;object-fit:cover;border-radius:inherit;">
                    </div>
                    <div class="photo-card">
                        <img src="<?= $BASE ?>assets/img/bem/BEM 4.jpeg" alt="Festival Seni ITH"
                            style="width:100%;height:100%;object-fit:cover;border-radius:inherit;">
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="vision-section" id="vision">
    <div data-reveal>
        <div class="vision-eyebrow">Visi & Semangat</div>
        <blockquote class="vision-text">
            "BEM ITH adalah <em>garda terdepan</em> dalam mewujudkan mahasiswa yang berdaya, berkarakter, dan mampu memberikan kontribusi nyata bagi kampus serta masyarakat sekitarnya."
        </blockquote>
        <div class="vision-author">— BEM ITH 2026, Institut Teknologi Bacharuddin Jusuf Habibie</div>
    </div>
</section>

<section class="gallery-section" id="gallery">
    <div class="gallery-header" data-reveal>
        <div class="eyebrow" style="text-align:center">Galeri Kegiatan</div>
        <h2>Momen &amp; Poster</h2>
    </div>
    <div class="poster-row">
            <div class="poster-card" data-reveal>
            <div class="poster-card-inner">
                <img src="<?= $BASE ?>assets/img/bem/Filosoft festival.jpeg" alt="Filosoft Festival"
                    style="width:100%;height:100%;object-fit:cover;border-radius:inherit;">
                <div class="poster-content">
                    <div class="p-tag">Event Kampus</div>
                    <div class="p-title">Filosoft Festival 2026</div>
                </div>
            </div>
        </div>
        <div class="poster-card" data-reveal>
            <div class="poster-card-inner">
                <img src="<?= $BASE ?>assets/img/bem/Habibie Competition.jpeg" alt="Habibie Competition"
                    style="width:100%;height:100%;object-fit:cover;border-radius:inherit;">
                <div class="poster-content">
                    <div class="p-tag">Kompetisi Nasional</div>
                    <div class="p-title">Habibie Competition 2025</div>
                </div>
            </div>
        </div>
        <div class="poster-card" data-reveal>
            <div class="poster-card-inner">
                <img src="<?= $BASE ?>assets/img/bem/open recruitment BEM ITH.jpeg" alt="Open Recruitment"
                    style="width:100%;height:100%;object-fit:cover;border-radius:inherit;">
                <div class="poster-content">
                    <div class="p-tag">Rekrutmen Anggota</div>
                    <div class="p-title">Open Recruitment BEM ITH</div>
                </div>
            </div>
        </div>
    </div>
</section>

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
                <img
                    src="<?= htmlspecialchars($p['img']) ?>"
                    alt="<?= htmlspecialchars($p['title']) ?>"
                    class="program-image"
                    onerror="this.src='<?= $BASE ?>assets/img/default-event.jpg';">
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

function handleContact(e) {
    e.preventDefault();
    const fb = document.getElementById('contactFeedback');
    fb.style.display = 'block';
    fb.textContent = '✓ Pesan berhasil dikirim! Kami akan segera menghubungi kamu.';
    e.target.reset();
    setTimeout(() => { fb.style.display = 'none'; }, 5000);
}

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
