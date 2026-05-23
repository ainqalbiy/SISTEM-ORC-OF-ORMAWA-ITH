<?php
$page_title = $page_title ?? 'ORC – ORMAWA ITH';
$page_css   = $page_css   ?? [];
// Ensure style.css is always loaded
if (!in_array('style.css', $page_css)) {
    array_unshift($page_css, 'style.css');
}
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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet"/>

    <!-- CSS sesuai halaman -->
    <?php foreach ($page_css as $css): ?>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/<?= e($css) ?>"/>
    <?php endforeach; ?>
</head>
<body>
