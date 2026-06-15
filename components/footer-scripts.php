<?php
// components/footer-scripts.php — Alias of footer_scripts.php
$page_js = $page_js ?? [];
foreach ($page_js as $js): ?>
<script src="<?= BASE_URL ?>assets/js/<?= e($js) ?>"></script>
<?php endforeach;
