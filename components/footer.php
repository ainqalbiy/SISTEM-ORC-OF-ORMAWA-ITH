<?php
// components/footer.php — Footer HTML + script loader + tutup </body></html>
$page_js = $page_js ?? [];
?>
<footer class="footer" id="contact">
    <div class="footer-inner">
        <div class="footer-brand">
            <span class="footer-logo">ORC</span>
            <p>Organization Resource Center<br>ORMAWA ITH – Parepare</p>
        </div>
        <div class="footer-socials">
            <a href="#" class="social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="#" class="social-btn" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
            <a href="#" class="social-btn" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
        </div>
        <p class="footer-handles">@orcormawaith</p>
        <p class="footer-copy">&copy; <?= date('Y') ?> ORC ORMAWA ITH. All rights reserved.</p>
    </div>
</footer>

<?php foreach ($page_js as $js): ?>
<script src="<?= BASE_URL ?>assets/js/<?= e($js) ?>"></script>
<?php endforeach; ?>
</body>
</html>
