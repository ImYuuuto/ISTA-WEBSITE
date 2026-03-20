<?php
session_start();
$page_title = "Réinitialiser le mot de passe | Établissement";
$current_page = "inscrire";
$base_path = "../";
$extra_css = ["inscrire.css"];
$extra_js = ["reset_password.js"];
require_once '../layout/header.php';

$token = $_GET['token'] ?? '';
$validToken = !empty($token);
?>

<!-- ================= HERO ================= -->
<section class="auth-hero d-flex align-items-center">
    <div class="container text-center text-white">
        <h1 class="fw-bold">Réinitialisation du mot de passe</h1>
        <p class="lead">Définissez un nouveau mot de passe pour votre compte</p>
    </div>
</section>

<!-- ================= MAIN ================= -->
<main class="container my-5" style="max-width: 500px;">
    <div class="card card-custom show" data-aos="fade-up" style="max-height: none;">
        <div class="card-body">
            <?php if ($validToken): ?>
                <h3 class="section-title mb-4">Nouveau mot de passe</h3>
                <form id="resetPasswordForm">
                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                    <div class="form-floating mb-3">
                        <input type="password" id="new-password" class="form-control" name="password"
                            placeholder="Nouveau mot de passe" required minlength="8" autocomplete="new-password">
                        <label for="new-password">Nouveau mot de passe</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" id="confirm-password" class="form-control" name="password_confirm"
                            placeholder="Confirmer le mot de passe" required minlength="8" autocomplete="new-password">
                        <label for="confirm-password">Confirmer le mot de passe</label>
                    </div>
                    <div id="resetError" class="alert alert-danger mb-3" style="display: none;"></div>
                    <div id="resetSuccess" class="alert alert-success mb-3" style="display: none;"></div>
                    <button type="submit" class="btn btn-custom w-100 py-2">Réinitialiser le mot de passe</button>
                </form>
            <?php else: ?>
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    Lien invalide ou expiré. <a href="inscrire.php">Demandez une nouvelle réinitialisation</a>.
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php require_once '../layout/footer.php'; ?>
