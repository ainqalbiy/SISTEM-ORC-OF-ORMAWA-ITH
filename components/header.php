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
