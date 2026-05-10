<?php
// pages/organisasi/bem.php
require_once '../../config/connection.php';

$page_title   = 'BEM ITH';
$page_css     = ['bem.css'];
$page_js      = ['bem.js'];
$current_page = 'bem';

require_once '../../components/header.php';
require_once '../../components/navbar.php';
?>

<section class="hero" id="home">
    <div class="hero-bg-overlay"></div>
    <div class="hero-particles" id="particles"></div>
    <div class="hero-content">
        <div class="hero-badge">
            <i class="bi bi-flower1"></i>
            Badan Eksekutif Mahasiswa
        </div>
        <h1 class="hero-title">BEM<br><span>ITH</span></h1>
        <p class="hero-subtitle">
            Badan Eksekutif Mahasiswa<br>Institut Teknologi Habibie
        </p>
        <div class="hero-actions">
            <a href="#about" class="btn-primary">View Our Pages</a>
            <a href="#programs" class="btn-ghost">Program Kami</a>
        </div>
    </div>
</section>

<!-- Konten BEM bisa ditambahkan di sini -->
<section id="about" style="padding:60px 24px;max-width:1200px;margin:0 auto;">
    <h2 style="font-family:'Playfair Display',serif;font-size:2rem;margin-bottom:16px;">Tentang BEM ITH</h2>
    <p style="color:#5a3e28;line-height:1.8;">
        Badan Eksekutif Mahasiswa (BEM) Institut Teknologi Habibie merupakan organisasi mahasiswa
        yang menjadi wadah aspirasi, koordinasi kegiatan kampus, serta pengembangan kepemimpinan mahasiswa ITH.
    </p>
</section>

<?php require_once '../../components/footer.php'; ?>
