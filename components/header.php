<<<<<<< HEAD
<?php
// components/header.php — HTML <head> + buka <body>
// Variabel yang bisa diset sebelum include:
//   $page_title   = 'Judul Halaman'
//   $page_css     = ['homepage.css', 'profile.css']   // nama file saja
//   $current_page = 'home'   // untuk highlight nav aktif

$page_title   = $page_title   ?? 'ORC ORMAWA ITH';
$page_css     = $page_css     ?? [];
$current_page = $current_page ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Organization Resource Center – Platform terpusat ORMAWA Institut Teknologi B.J. Habibie Parepare.">
    <title><?= htmlspecialchars($page_title) ?> — ORC ORMAWA ITH</title>

    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="<?= BASE_URL ?>assets/img/logo/header-logo.jpeg">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Playfair+Display:wght@700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Global CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">

    <!-- Page-specific CSS -->
    <?php foreach ($page_css as $css): ?>
        <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/<?= htmlspecialchars($css) ?>">
    <?php endforeach; ?>
</head>
<body>
=======
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>BEM ITH – Organization Resource Center</title>
  
  <link rel="stylesheet" href="../../assets/css/bem.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
</head>
<body>

  <nav class="navbar" id="navbar">
    <div class="nav-logo">
      <div class="logo-icon">
        <svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M25 5 L30 18 L44 18 L33 27 L37 40 L25 32 L13 40 L17 27 L6 18 L20 18 Z" fill="#E8834A" stroke="#D4933A" stroke-width="1"/>
        </svg>
      </div>
      <span class="logo-text">BEM<span>ITH</span></span>
    </div>
    <ul class="nav-links" id="navLinks">
      <li><a href="#home" class="nav-link active">Home</a></li>
      <li><a href="#about" class="nav-link">About Us</a></li>
      <li><a href="#bem" class="nav-link">BEM</a></li>
      <li><a href="#hero" class="nav-link">HERO</a></li>
      <li><a href="#hcc" class="nav-link">HCC</a></li>
      <li><a href="#aratta" class="nav-link">ARATTA</a></li>
      <li><a href="#wirausaha" class="nav-link">Wirausaha</a></li>
    </ul>
    <a href="#contact" class="btn-register">DAFTAR SEKARANG</a>
    <button class="hamburger" id="hamburger" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </nav>
>>>>>>> 0ed97d5 (update konten halaman BEM.php)
