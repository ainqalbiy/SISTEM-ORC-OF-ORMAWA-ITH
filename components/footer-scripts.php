<?php
$page_js = $page_js ?? [];
?>
<?php foreach ($page_js as $js): ?>
<script src="<?= BASE_URL ?>assets/js/<?= e($js) ?>"></script>
<?php endforeach; ?>
</body>
</html>
