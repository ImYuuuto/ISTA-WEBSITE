<?php
session_start();
$page_title = "Connexion Admin | Établissement";
$current_page = "admin_login";
$base_path = "../";
$extra_css = ["inscrire.css"]; // Reusing student styles for consistency or can create new ones
$extra_js = ["admin_login.js"];
require_once '../layout/header.php';

// If already logged in as Admin, redirect
if (isset($_SESSION['user']) && $_SESSION['user']['role'] === 'Admin') {
    header("Location: admin_page.php");
    exit;
}
?>

<section class="auth-hero d-flex align-items-center bg-dark">
    <div class="container text-center text-white">
        <h1 class="fw-bold">Portail Administration</h1>
        <p class="lead">Accès réservé au personnel administratif</p>
    </div>
</section>

<main class="container my-5" style="max-width: 500px;">
    <div class="card shadow-sm border-0 rounded-4" data-aos="fade-up">
        <div class="card-body p-4 p-md-5">
            <h3 class="text-center mb-4 fw-bold">Identification</h3>
            <form id="adminLoginForm">
                <div class="form-floating mb-3">
                    <input type="text" id="admin-username" class="form-control" name="username"
                        placeholder="Identifiant Admin" required autocomplete="username">
                    <label for="admin-username">Identifiant Admin</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" id="admin-password" class="form-control" name="password"
                        placeholder="Mot de passe" required autocomplete="current-password">
                    <label for="admin-password">Mot de passe</label>
                </div>

                <div id="loginError" class="alert alert-danger mb-3" style="display: none;">
                    Identifiants incorrects ou accès refusé.
                </div>

                <button type="submit" class="btn btn-dark w-100 py-3 rounded-3 shadow-sm fw-bold">
                    Se connecter <i class="bi bi-box-arrow-in-right ms-2"></i>
                </button>
            </form>

            <div class="text-center mt-4">
                <a href="inscrire.php" class="text-muted text-decoration-none small">
                    <i class="bi bi-arrow-left me-1"></i> Retour à l'espace stagiaire
                </a>
            </div>
        </div>
    </div>
</main>

<?php require_once '../layout/footer.php'; ?>