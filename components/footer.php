<?php
// components/footer.php — Footer global + penutup </body></html>
// Variabel opsional: $page_js = ['homepage.js']
$page_js = $page_js ?? [];
?>
<footer class="site-footer" id="contact">
    <div class="footer-top">
        <div class="footer-grid">

            <!-- Alamat -->
            <div class="footer-col">
                <h4 class="footer-col-title">
                    <i class="bi bi-geo-alt-fill"></i> Alamat
                </h4>
                <p>Kampus Institut Teknologi B.J Habibie<br>Parepare, Sulawesi Selatan</p>
            </div>

            <!-- Email & Telepon -->
            <div class="footer-col">
                <h4 class="footer-col-title">
                    <i class="bi bi-envelope-fill"></i> Email
                </h4>
                <p><a href="mailto:orcormawa@ith.ac.id">orcormawa@ith.ac.id</a></p>

                <h4 class="footer-col-title mt-2">
                    <i class="bi bi-telephone-fill"></i> Telepon
                </h4>
                <p><a href="tel:+621234567890">+62 1234 5678 910</a></p>
            </div>

            <!-- Kontak CTA -->
            <div class="footer-col footer-contact">
                <p>Memiliki pertanyaan atau membutuhkan informasi terkait organisasi mahasiswa? Hubungi kami melalui kontak berikut.</p>
                <h4 class="footer-contacts-label">C O N T A C T S</h4>
            </div>

        </div>
    </div>

    <div class="footer-bottom">
        <p>© 2026 ORC ORMAWA ITH — Institut Teknologi B.J Habibie</p>
    </div>
</footer>

<!-- ── Scripts ── -->
<script src="<?= BASE_URL ?>assets/js/main.js"></script>
<?php foreach ($page_js as $js): ?>
    <script src="<?= BASE_URL ?>assets/js/<?= htmlspecialchars($js) ?>"></script>
<?php endforeach; ?>

</body>
</html>
