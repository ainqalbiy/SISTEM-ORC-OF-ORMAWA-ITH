<<<<<<< HEAD
<?php
// pages/organisasi/bem.php
require_once '../../config/connection.php';

$page_title   = 'BEM ITH';
$page_css     = ['bem.css'];
$page_js      = ['bem.js'];
$current_page = 'bem';

require_once '../../components/header.php';
require_once '../../components/navbar.php';
=======
<?php 
include '../../components/header.php'; 
>>>>>>> 0ed97d5 (update konten halaman BEM.php)
?>

  <section class="hero" id="home">
    <div class="hero-bg-overlay"></div>
    <div class="hero-particles" id="particles"></div>
    <div class="hero-content">
<<<<<<< HEAD
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
=======
      <div class="hero-badge">Filosoft &bull; #FA8943 &bull; #925630</div>
      <h1 class="hero-title">BEM<br/><span>ITH</span></h1>
      <p class="hero-subtitle">Badan Eksekutif Mahasiswa<br/>Institut Teknologi Habibie</p>
      <div class="hero-actions">
        <a href="#about" class="btn-primary">View Our Pages</a>
        <a href="#programs" class="btn-ghost">Program Kami</a>
      </div>
>>>>>>> 0ed97d5 (update konten halaman BEM.php)
    </div>
    <div class="hero-scroll-hint">
      <span>Scroll</span>
      <div class="scroll-line"></div>
    </div>
  </section>

  <section class="about-section" id="about">
    <div class="container">
      <div class="about-grid">
        <div class="about-left" data-animate="fade-left">
          <div class="section-eyebrow">BEM ITH 2026</div>
          <h2 class="about-title">Tentang BEM ITH</h2>
          <p class="about-text">Badan Eksekutif Mahasiswa (BEM) adalah organisasi intra-kampus tertinggi yang menjalankan fungsi eksekutif di dalam Universitas atau Fakultas.</p>
          <div class="about-tags">
            <span class="tag">Aspirasi</span>
            <span class="tag">Perubahan</span>
            <span class="tag">Kolaborasi</span>
          </div>
        </div>
        <div class="about-right" data-animate="fade-right">
          <div class="about-cards">
            <div class="event-card big">
              <div class="card-img-placeholder gradient-1">
                <div class="card-overlay-text">HABIBIE<br/><span>COMPETITION</span><br/>VOL.1</div>
              </div>
            </div>
            <div class="event-card small">
              <div class="card-img-placeholder gradient-2">
                <p class="card-caption">Rapat Kerja ORMAWA Bachtiar Habibie Periode 2025</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="filosoft-banner" id="bem">
    <div class="filosoft-inner">
      <div class="filosoft-card" data-animate="fade-up">
        <div class="filosoft-circle"><span>Filosoft</span></div>
        <div class="filosoft-info">
          <div class="filosoft-hash">#FA8943</div>
          <p>Oranye — Semangat, kepemimpinan, harapan, dan antusiasme</p>
          <div class="filosoft-hash">#925630</div>
          <p>Coklat — Akar kemanusiaan, nilai organisasi yang kuat</p>
        </div>
      </div>
    </div>
  </section>

  <section class="programs-section" id="programs">
    <div class="container">
      <div class="section-header" data-animate="fade-up">
        <h2 class="section-title">Our Programs <span class="title-dash">-</span></h2>
      </div>
      <div class="programs-grid">
        <div class="program-card" data-animate="fade-up">
          <div class="program-info">
            <h3>LKMM - TD</h3>
            <p>Pengembangan kepemimpinan dan manajemen mahasiswa tingkat dasar.</p>
          </div>
        </div>
        <div class="program-card" data-animate="fade-up">
          <div class="program-info">
            <h3>Festival Seni</h3>
            <p>Wadah kreativitas mahasiswa dalam seni, budaya, dan inovasi.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="contact-section" id="contact">
    <div class="container">
      <div class="contact-box" data-animate="fade-up">
        <div class="contact-header">
          <h2>Write a Message</h2>
        </div>
        <div class="contact-form">
            <input type="text" placeholder="Full Name" class="form-input"/>
            <textarea placeholder="Write a message..." class="form-textarea" rows="5"></textarea>
            <button class="btn-send">SEND A MESSAGE</button>
        </div>
      </div>
    </div>
  </section>

<<<<<<< HEAD
<!-- Konten BEM bisa ditambahkan di sini -->
<section id="about" style="padding:60px 24px;max-width:1200px;margin:0 auto;">
    <h2 style="font-family:'Playfair Display',serif;font-size:2rem;margin-bottom:16px;">Tentang BEM ITH</h2>
    <p style="color:#5a3e28;line-height:1.8;">
        Badan Eksekutif Mahasiswa (BEM) Institut Teknologi Habibie merupakan organisasi mahasiswa
        yang menjadi wadah aspirasi, koordinasi kegiatan kampus, serta pengembangan kepemimpinan mahasiswa ITH.
    </p>
</section>

<?php require_once '../../components/footer.php'; ?>
=======
<?php 
include '../../components/footer.php'; 
?>
>>>>>>> 0ed97d5 (update konten halaman BEM.php)
