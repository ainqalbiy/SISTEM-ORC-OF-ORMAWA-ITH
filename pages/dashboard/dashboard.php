<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>ORC ORMAWA ITH - Organization Resource Center</title>
  <link rel="stylesheet" href="css/dashboard.css" />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Merriweather:wght@700&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>

  <!-- ===== NAVBAR ===== -->
  <header class="navbar">
    <div class="nav-brand">
      <div class="nav-logo">
        <img src="https://img.icons8.com/color/48/open-book--v1.png" alt="logo" width="36"/>
      </div>
      <span class="nav-title">Organization Resource Center</span>
    </div>
    <nav class="nav-links">
      <a href="#" class="nav-link active">HOME</a>
      <a href="#" class="nav-link">ABOUT US</a>
      <a href="#" class="nav-link">BEM</a>
      <a href="#" class="nav-link">HERO</a>
      <a href="#" class="nav-link">HCC</a>
      <a href="#" class="nav-link">ARATTA</a>
      <a href="#" class="nav-link">WIRAUSAHA</a>
    </nav>
    <a href="#" class="btn-daftar">DAFTAR SEKARANG</a>
    <button class="hamburger" id="hamburger" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </header>

  <!-- Mobile nav -->
  <div class="mobile-nav" id="mobileNav">
    <a href="#">HOME</a>
    <a href="#">ABOUT US</a>
    <a href="#">BEM</a>
    <a href="#">HERO</a>
    <a href="#">HCC</a>
    <a href="#">ARATTA</a>
    <a href="#">WIRAUSAHA</a>
    <a href="#" class="btn-daftar" style="margin-top:12px;display:inline-block;">DAFTAR SEKARANG</a>
  </div>

  <!-- ===== HERO SECTION ===== -->
  <section class="hero-section">
    <div class="hero-overlay"></div>
    <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?w=1200&q=80" alt="Hero Background" class="hero-bg"/>
    <div class="hero-content">
      <div class="hero-badge">
        <i class="fa fa-home"></i> ORMAWA ITH — Parepare
      </div>
      <h1 class="hero-title">Kelola Sumber Daya<br/>Organisasi dengan Mudah</h1>
      <p class="hero-desc">Satu platform terpusat untuk menyimpan, mengelola, dan mengakses seluruh dokumen dan arsip ORMAWA ITH.</p>
      <div class="hero-buttons">
        <a href="#" class="btn-primary">Jelajahi Organisasi <i class="fa fa-arrow-right"></i></a>
        <a href="#" class="btn-secondary">Hubungi Kami <i class="fa fa-arrow-right"></i></a>
      </div>
    </div>
  </section>

  <!-- ===== SEARCH BAR ===== -->
  <section class="search-section">
    <div class="search-container">
      <div class="search-bar">
        <input type="text" placeholder="Cari Organisasi" class="search-input"/>
        <div class="search-divider"></div>
        <select class="search-select">
          <option value="">Pilih Kategori Organisasi</option>
          <option value="bem">BEM</option>
          <option value="ukm">UKM</option>
          <option value="himpunan">Himpunan</option>
        </select>
      </div>
      <button class="btn-explore">Explore</button>
    </div>
  </section>

  <!-- ===== TEMUKAN SECTION ===== -->
  <section class="temukan-section">
    <div class="temukan-container">
      <div class="temukan-image">
        <img src="https://images.unsplash.com/photo-1581092921461-7d65ca45393a?w=600&q=80" alt="Robot Competition"/>
        <div class="temukan-img-badge">HABIBIE ROBOTIC COMPETITION 2025</div>
      </div>
      <div class="temukan-content">
        <h2>Temukan Organisasi Kampusmu !</h2>
        <p>Jelajahi berbagai organisasi mahasiswa di ITH, mulai dari BEM, UKM, hingga unit kegiatan mahasiswa. Dapatkan informasi program kerja, kegiatan, dan aktivitas terbaru dalam satu platform terintegrasi !</p>
        <a href="#" class="btn-cta">Yuk! Daftar dan Mulai Organisasimu di ITH. <i class="fa fa-arrow-right"></i></a>
      </div>
    </div>
  </section>

  <!-- ===== ORGANISASI SLIDER SECTION ===== -->
  <section class="orgs-section">
    <h2 class="orgs-title">Mulai Perjalanan Organisasimu di- ITH</h2>
    <div class="slider-wrapper">
      <button class="slider-btn prev" id="prevBtn" aria-label="Previous">
        <i class="fa fa-chevron-left"></i>
      </button>
      <div class="slider-track-container">
        <div class="slider-track" id="sliderTrack">

          <!-- Card 1: BEM -->
          <div class="org-card">
            <div class="org-card-logo">
              <img src="https://img.icons8.com/color/96/lotus.png" alt="BEM ITH" class="org-logo-img"/>
              <p class="org-logo-label">BEMITH<br/><strong>2026</strong></p>
            </div>
            <h3>Badan Eksekutif Mahasiswa (BEM) - ITH</h3>
            <p>Organisasi mahasiswa yang menjadi wadah aspirasi, koordinasi kegiatan kampus, serta pengembangan kepemimpinan mahasiswa ITH.</p>
            <a href="#" class="btn-explore-org">Explore Organisasi</a>
          </div>

          <!-- Card 2: HERO -->
          <div class="org-card">
            <div class="org-card-logo dark">
              <div class="org-logo-circle">
                <img src="https://img.icons8.com/external-flat-icons-maxicons/96/external-robot-robotics-flat-icons-maxicons.png" alt="HERO ITH"/>
                <span>HERO</span>
              </div>
            </div>
            <h3>Habibie Engineering Robotic of Organization (HERO) - ITH</h3>
            <p>Organisasi mahasiswa yang berfokus pada pengembangan teknologi robotika, IoT, dan inovasi di bidang engineering.</p>
            <a href="#" class="btn-explore-org">Explore Organisasi</a>
          </div>

          <!-- Card 3: HCC -->
          <div class="org-card">
            <div class="org-card-logo dark-blue">
              <div class="org-logo-circle">
                <img src="https://img.icons8.com/color/96/source-code.png" alt="HCC ITH"/>
                <span>HABIBIE CODING CLUB</span>
              </div>
            </div>
            <h3>Habibie Coding Club (HCC) - ITH</h3>
            <p>Organisasi mahasiswa di bidang pemrograman dan teknologi yang mendukung pengembangan skill coding, software, dan digital creativity.</p>
            <a href="#" class="btn-explore-org">Explore Organisasi</a>
          </div>

          <!-- Card 4: ARATTA -->
          <div class="org-card">
            <div class="org-card-logo gold">
              <div class="org-logo-circle">
                <img src="https://img.icons8.com/color/96/art.png" alt="ARATTA ITH"/>
                <span style="font-size:10px;letter-spacing:1px;">ARATTA</span>
              </div>
            </div>
            <h3>UKM Seni Art & Talent (ARATTA)-ITH</h3>
            <p>Unit kegiatan mahasiswa yang menjadi wadah pengembangan minat, kreativitas, dan bakat mahasiswa di bidang seni dan hiburan.</p>
            <a href="#" class="btn-explore-org">Explore Organisasi</a>
          </div>

          <!-- Card 5: WITH -->
          <div class="org-card">
            <div class="org-card-logo red-grad">
              <div class="org-logo-circle">
                <img src="https://img.icons8.com/color/96/business.png" alt="WITH ITH"/>
                <span>WITH</span>
              </div>
            </div>
            <h3>Wirausaha (WITH) - ITH</h3>
            <p>Organisasi mahasiswa yang berfokus pada pengembangan jiwa kewirausahaan, kreativitas bisnis, dan inovasi usaha mahasiswa.</p>
            <a href="#" class="btn-explore-org">Explore Organisasi</a>
          </div>

        </div>
      </div>
      <button class="slider-btn next" id="nextBtn" aria-label="Next">
        <i class="fa fa-chevron-right"></i>
      </button>
    </div>

    <!-- Dots -->
    <div class="slider-dots" id="sliderDots"></div>
  </section>

  <!-- ===== TESTIMONIAL SECTION ===== -->
  <section class="testimonial-section">
    <div class="testi-left">
      <h2>Apa Kata Mahasiswa(i) ITH ?</h2>
      <p class="testi-sub">Pengalaman mereka bersama organisasi kampus</p>

      <div class="testi-card brown">
        <p>"Selama 1,5 periode di organisasi HERO dan kepanitiaan Habibie Robotic Competition (HRC), saya berperan aktif dalam pengelolaan keuangan, administrasi, logistik, dan registrasi sehingga mengasah kemampuan manajemen waktu, ketelitian, serta komunikasi."</p>
        <div class="testi-author">
          <strong>Nurkhofifah</strong>
          <span>-Pengurus HERO</span>
        </div>
      </div>

      <div class="testi-card light">
        <p>"Dan itu member itu lho, selama jadi member banyak kudapat ilmu yang tidak di ajarkan di kelas atau lebih dki di ajarkan di hal, bra di ajarkan di kelas, tdk cuma bersikap naik tp jadi pengurus, selama jadi pengurus banyak experience baru ku dapat, mhst harus ki bisa menyesuaikan waktu, belajar bekerja sama dalam tim, saling support satu demi kemajuan 🙂"</p>
        <div class="testi-author">
          <strong>Muhammad Farid Ramadhan</strong>
          <span>-Pengurus HCC</span>
        </div>
      </div>
    </div>

    <div class="testi-right">
      <div class="stat-card orange">
        <span class="stat-num">5+</span>
        <span class="stat-label">Organisasi Mahasiswa Aktif</span>
      </div>
      <div class="stat-card brown-stat">
        <span class="stat-num">20+</span>
        <span class="stat-label">Program Kerja & Kegiatan Terlaksana dengan Baik</span>
      </div>
      <div class="stat-card dark-stat">
        <span class="stat-num">50+</span>
        <span class="stat-label">Mahasiswa Aktif Ber-Organisasi</span>
      </div>
    </div>
  </section>

  <!-- ===== FOOTER ===== -->
  <footer class="footer">
    <div class="footer-left">
      <div class="footer-info">
        <p class="footer-label">Alamat:</p>
        <p>Kampus Institut Teknologi B.J Habibie Parepare, Sulawesi Selatan</p>
      </div>
      <div class="footer-info">
        <p class="footer-label">Email:</p>
        <p>orcormawa@ith.ac.id</p>
      </div>
      <div class="footer-info">
        <p class="footer-label">Telepon:</p>
        <p>+62 1234 5678 910</p>
      </div>
    </div>
    <div class="footer-right">
      <p>Memiliki pertanyaan atau membutuhkan informasi terkait organisasi mahasiswa? Hubungi kami melalui kontak berikut.</p>
      <h3 class="footer-contacts-title">C O N T A C T S</h3>
    </div>
    <div class="footer-bottom">
      <p>© 2026 ORC ORMAWA ITH — Institut Teknologi B.J Habibie</p>
    </div>
  </footer>

  <script src="js/dashboard.js"></script>
</body>
</html>