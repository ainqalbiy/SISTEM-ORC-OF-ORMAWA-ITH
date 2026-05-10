<?php
require_once '../../config/connection.php';
$page_title   = 'Habibie Engineering Robotic of Organization (HERO) – ITH';
$page_css     = ['bem.css'];
$current_page = 'hero';
require_once '../../components/header.php';
require_once '../../components/navbar.php';
?>
<section class="hero" id="home" style="background:linear-gradient(135deg,#3d1a08,#9c4415);min-height:420px;display:flex;align-items:center;">
    <div class="hero-overlay"></div>
    <div class="hero-content" style="position:relative;z-index:2;max-width:1200px;margin:0 auto;padding:60px 24px;">
        <div class="hero-badge"><i class="bi bi-stars"></i> Organisasi ITH</div>
        <h1 class="hero-title" style="font-family:'Playfair Display',serif;font-size:3rem;color:#fff;">HERO<br><span style="color:#F4A55A;">ITH</span></h1>
        <p class="hero-subtitle" style="color:rgba(255,255,255,0.82);">Habibie Engineering Robotic of Organization (HERO)<br>Institut Teknologi Habibie</p>
        <div class="hero-actions" style="margin-top:24px;display:flex;gap:12px;">
            <a href="<?= BASE_URL ?>pages/homepage/homepage.php" class="btn-primary" style="background:#C85C1A;color:#fff;padding:12px 24px;border-radius:50px;font-weight:700;">← Kembali</a>
        </div>
    </div>
</section>
<section id="about" style="padding:60px 24px;max-width:1200px;margin:0 auto;">
    <h2 style="font-family:'Playfair Display',serif;font-size:2rem;margin-bottom:16px;">Tentang Habibie Engineering Robotic of Organization (HERO)</h2>
    <p style="color:#5a3e28;line-height:1.8;">Konten halaman ini sedang dalam pengembangan. Hubungi admin untuk informasi lebih lanjut.</p>
</section>
<?php require_once '../../components/footer.php'; ?>
