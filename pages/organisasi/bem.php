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
      <div class="hero-badge">Filosoft &bull; #FA8943 &bull; #925630</div>
      <h1 class="hero-title">BEM<br/><span>ITH</span></h1>
      <p class="hero-subtitle">Badan Eksekutif Mahasiswa<br/>Institut Teknologi Habibie</p>
      <div class="hero-actions">
        <a href="#about" class="btn-primary">Tentang BEM</a>
        <a href="<?= BASE_URL ?>pages/homepage/homepage.php" class="btn-ghost">← Beranda</a>
      </div>
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
          <p class="about-text">Badan Eksekutif Mahasiswa (BEM) adalah organisasi intra-kampus tertinggi yang menjalankan fungsi eksekutif di dalam Universitas. BEM ITH berkomitmen menjadi wadah aspirasi, koordinasi kegiatan kampus, serta pengembangan kepemimpinan mahasiswa.</p>
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

<?php require_once '../../components/footer.php'; ?>
