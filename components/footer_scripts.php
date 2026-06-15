<?php
// components/footer_scripts.php — Hanya render <script> tag, TIDAK menutup body/html
// body/html ditutup oleh components/footer.php
$page_js = $page_js ?? [];
foreach ($page_js as $js): ?>
<script src="<?= BASE_URL ?>assets/js/<?= e($js) ?>"></script>
<?php endforeach;
