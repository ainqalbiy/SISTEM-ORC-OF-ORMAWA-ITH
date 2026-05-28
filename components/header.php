<?php
// components/header.php — Global HTML head, always loads navbar.css
$page_title = $page_title ?? 'ORC – ORMAWA ITH';
$page_css   = $page_css   ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= e($page_title) ?> – ORC ORMAWA ITH</title>

    <!-- Icons & Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <!-- ★ SHARED NAVBAR CSS — always loaded on every page ★ -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/navbar.css"/>

    <!-- Page-specific CSS -->
    <?php foreach ($page_css as $css): ?>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/<?= e($css) ?>"/>
    <?php endforeach; ?>
</head>
<body>
