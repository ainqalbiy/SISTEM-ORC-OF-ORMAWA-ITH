<?php
$org_label = $org_label ?? 'Organisasi';
$org_email = $org_email ?? 'info@ith.ac.id';
?>

<section class="live-section" id="kegiatan-db">
    <div class="container">
        <div class="live-header" data-reveal>
            <div>
                <div class="eyebrow">Data Real · Database</div>
                <h2 class="live-title">Kegiatan <?= e($org_label) ?></h2>
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
                    Tambahkan melalui <a href="<?= BASE_URL ?>pages/dashboard/dashboard.php?tab=kegiatan">Dashboard</a>.
                <?php else: ?>
                    <a href="<?= BASE_URL ?>pages/Sign In/Sign In.php">Sign In</a> untuk menambahkan kegiatan.
                <?php endif; ?>
            </p>
        </div>
        <?php else: ?>
        <div class="live-grid" data-reveal>
            <?php foreach ($kegiatan_db as $k):
                $sc = strtolower(str_replace(' ', '-', $k['status'] ?? 'terjadwal')); ?>
            <div class="live-card">
                <div class="live-card-top">
                    <span class="live-status <?= e($sc) ?>"><?= e($k['status'] ?? 'Terjadwal') ?></span>
                    <span class="live-date"><i class="bi bi-calendar3"></i> <?= date('d M Y', strtotime($k['tanggal'])) ?></span>
                </div>
                <div class="live-card-body">
                    <div class="live-card-jenis"><?= e($k['jenis_kegiatan']) ?></div>
                    <h4 class="live-card-nama"><?= e($k['nama_kegiatan']) ?></h4>
                    <?php if (!empty($k['deskripsi'])): ?>
                    <p class="live-card-desc"><?= e(mb_substr($k['deskripsi'], 0, 80)) ?><?= mb_strlen($k['deskripsi']) > 80 ? '...' : '' ?></p>
                    <?php endif; ?>
                </div>
                <div class="live-card-foot"><i class="bi bi-geo-alt"></i> <?= e($k['tempat']) ?></div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ANGGOTA LIVE -->
<section class="live-section live-section-alt" id="anggota-db">
    <div class="container">
        <div class="live-header" data-reveal>
            <div>
                <div class="eyebrow">Data Real · Database</div>
                <h2 class="live-title">Anggota <?= e($org_label) ?></h2>
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
                    Daftarkan melalui <a href="<?= BASE_URL ?>pages/dashboard/dashboard.php?tab=anggota">Dashboard</a>.
                <?php else: ?>
                    <a href="<?= BASE_URL ?>pages/Sign In/Sign In.php">Sign In</a> untuk menambahkan anggota.
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

<!-- CONTACT -->
<section class="contact-section" id="contact">
    <div class="container">
        <div class="contact-inner" data-reveal>
            <div class="contact-eyebrow">Get In Touch</div>
            <h2 class="contact-title">Write a Message</h2>
            <form class="contact-form" method="POST" action="#" onsubmit="handleContact(event)">
                <div class="form-row-2">
                    <div class="form-field"><label>Name</label><input type="text" name="cn" placeholder="Nama lengkap" required></div>
                    <div class="form-field"><label>Email Address</label><input type="email" name="ce" placeholder="email@example.com" required></div>
                </div>
                <div class="form-row-2">
                    <div class="form-field"><label>Phone</label><input type="tel" name="cp" placeholder="08xx-xxxx-xxxx"></div>
                    <div class="form-field"><label>Subject</label><input type="text" name="cs" placeholder="Perihal pesan..." required></div>
                </div>
                <div class="form-field"><label>Message</label><textarea name="cm" placeholder="Tulis pesanmu di sini..." required></textarea></div>
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
        <a href="mailto:<?= e($org_email) ?>" class="footer-social-btn" aria-label="Email"><i class="bi bi-envelope-fill"></i></a>
    </div>
    <p class="footer-copy">© <?= date('Y') ?> <?= e($org_label) ?> Website | Organization Resource Center</p>
</footer>

<script>
(function(){
    const reveals = document.querySelectorAll('[data-reveal],[data-reveal-left],[data-reveal-right]');
    const io = new IntersectionObserver(entries => {
        entries.forEach(e => {
            if (e.isIntersecting) {
                const d = parseFloat(e.target.style.animationDelay||'0')*1000;
                setTimeout(() => e.target.classList.add('revealed'), d);
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.12 });
    reveals.forEach(el => io.observe(el));

    function handleContact(e) {
        e.preventDefault();
        const fb = document.getElementById('contactFeedback');
        fb.style.display='block';
        fb.textContent='✓ Pesan berhasil dikirim! Kami akan segera menghubungi kamu.';
        e.target.reset();
        setTimeout(()=>{ fb.style.display='none'; }, 5000);
    }
    window.handleContact = handleContact;

    document.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', ev => {
            const t = document.getElementById(a.getAttribute('href').slice(1));
            if (t) { ev.preventDefault(); t.scrollIntoView({behavior:'smooth',block:'start'}); }
        });
    });
})();
</script>
