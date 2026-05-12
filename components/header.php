<?php
// components/header.php — Head HTML dinamis
// Variabel yang bisa di-set sebelum include:
//   $page_title  (string) — judul tab browser
//   $page_css    (array)  — nama-nama file CSS di assets/css/
// BASE_URL harus sudah terdefinisi (dari connection.php)

$page_title = $page_title ?? 'ORC – ORMAWA ITH';
$page_css   = $page_css   ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title><?= e($page_title) ?> – Organization Resource Center</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"/>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=Nunito:wght@400;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>

    <!-- CSS dinamis sesuai halaman -->
    <?php foreach ($page_css as $css): ?>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/<?= e($css) ?>"/>
    <?php endforeach; ?>
</head>
<body>
