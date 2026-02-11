<?php
/**
 * footer.php
 * Common footer for all pages.
 */
$base_path = $base_path ?? '';
?>
<!-- ================= FOOTER ================= -->
<footer class="footer-custom text-white pt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5 class="footer-title">Coordonnées</h5>
                <p>📍 Avenue Brahim Roudani, El Jadida</p>
                <p>📞 05233-41269</p>
                <p>✉️ ofppt@etablissement.ma</p>
            </div>

            <div class="col-md-4 mb-4">
                <h5 class="fw-bold mb-3">Liens rapides</h5>
                <ul class="list-unstyled">
                    <li><a href="<?php echo $base_path; ?>index.php"
                            class="text-white-50 text-decoration-none">Accueil</a>
                    </li>
                    <li><a href="<?php echo $base_path; ?>pages/formations.php"
                            class="text-white-50 text-decoration-none">Nos Formations</a></li>
                    <li><a href="<?php echo $base_path; ?>pages/contact.php"
                            class="text-white-50 text-decoration-none">Contactez-nous</a></li>
                    <hr class="border-secondary mt-3 mb-2" style="max-width: 50px;">
                    <li><a href="<?php echo $base_path; ?>pages/admin_login.php"
                            class="text-white-50 text-decoration-none small">Espace Administration</a></li>
                </ul>
            </div>

            <div class="col-md-4 mb-3">
                <h5 class="footer-title">Suivez-nous</h5>
                <a href="https://web.facebook.com/ofppt.page.officielle/?_rdc=1&_rdr#"
                    class="social-link me-3">Facebook</a>
                <a href="https://x.com/OFPPT_Officiel" class="social-link me-3">X</a>
                <a href="https://www.instagram.com/ofppt.officiel/" class="social-link me-3">Instagram</a>
                <a href="https://www.linkedin.com/company/ofpptpageofficielle/" class="social-link">LinkedIn</a>
            </div>

            <hr class="footer-line">
            <p class="text-center mb-0">© 2026 OFPPT. Tous droits réservés</p>
        </div>
</footer>

<!-- CSRF Token for JS -->
<script>
    const CSRF_TOKEN = "<?php require_once __DIR__ . '/../assets/php/csrf.php';
    echo generate_csrf_token(); ?>";
</script>

<script src="<?php echo $base_path; ?>assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
<script src="<?php echo $base_path; ?>assets/js/search_bar.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script src="<?php echo $base_path; ?>assets/js/main.js"></script>


<?php if (isset($extra_js)): ?>
    <?php foreach ($extra_js as $js): ?>
        <script src="<?php echo $base_path; ?>assets/js/<?php echo $js; ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>
</body>

</html>