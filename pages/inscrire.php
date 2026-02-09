<?php
session_start();
$page_title = "Connexion & Inscription | Établissement";
$current_page = "inscrire";
$base_path = "../";
$extra_css = ["inscrire.css"];
$extra_js = ["inscrire.js"];
require_once '../layout/header.php';
?>

<!-- ================= HERO ================= -->
<section class="auth-hero d-flex align-items-center">
    <div class="container text-center text-white">
        <h1 class="fw-bold">Espace Stagiaire</h1>
        <p class="lead">Connexion, inscription et réinscription en ligne</p>
    </div>
</section>

<!-- ================= MAIN ================= -->
<main class="container my-5" style="max-width: 900px;">

    <!-- Choice Buttons -->
    <div class="text-center mb-4">
        <h3 class="section-title mb-3">Choisissez une option</h3>
        <button type="button" class="btn btn-outline-success choice-btn me-2 active" data-form="login"
            onclick="showForm('login')">Connexion</button>
        <button type="button" class="btn btn-outline-success choice-btn me-2" data-form="inscription"
            onclick="showForm('inscription')">Nouvelle Inscription</button>
        <button type="button" class="btn btn-outline-success choice-btn" data-form="reinscription"
            onclick="showForm('reinscription')">Réinscription</button>
    </div>

    <hr class="my-5">

    <!-- LOGIN -->
    <div id="login" class="card card-custom show" data-aos="fade-up">
        <div class="card-body">
            <h3 class="section-title mb-4">Connexion</h3>
            <form id="loginForm">
                <div class="form-floating mb-3">
                    <input type="text" id="login-username" class="form-control" name="username"
                        placeholder="Identifiant" required autocomplete="username">
                    <label for="login-username">Identifiant</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" id="login-password" class="form-control" name="password"
                        placeholder="Mot de passe" required autocomplete="current-password">
                    <label for="login-password">Mot de passe</label>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a class="forgot-link-icon" href="#"><i class="bi bi-lock-fill me-1"></i> Oublié ?</a>
                </div>

                <div id="loginError" class="alert alert-danger mb-3" style="display: none;">
                    Identifiant ou mot de passe incorrect.
                </div>

                <button type="submit" class="btn btn-custom w-100 py-2">Se connecter</button>
            </form>
        </div>
    </div>

    <!-- INSCRIPTION -->
    <div id="inscription" class="card card-custom" data-aos="fade-up">
        <div class="card-body">
            <h3 class="section-title mb-4">Inscription - Nouveaux Stagiaires</h3>
            <form class="row needs-validation" action="inscription.php" method="POST" novalidate id="inscriptionForm">

                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <input id="ins-name" class="form-control" name="fullname" placeholder="Nom et Prénom" required>
                        <label for="ins-name">Nom et Prénom</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <input type="date" id="ins-birthdate" class="form-control" name="birthdate"
                            placeholder="Date de naissance" required>
                        <label for="ins-birthdate">Date de naissance</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <input type="email" id="ins-email" class="form-control" name="email" placeholder="Email"
                            required autocomplete="email">
                        <label for="ins-email">Email</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <input id="ins-phone" class="form-control" name="phone" placeholder="Téléphone" required>
                        <label for="ins-phone">Téléphone</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <input id="ins-level" class="form-control" name="education_level" placeholder="Niveau d’études"
                            required>
                        <label for="ins-level">Niveau d’études</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <select id="ins-filiere" class="form-select" name="filiere" required>
                            <option selected disabled value="">Filière souhaitée</option>
                            <option>Développement Web</option>
                            <option>Réseaux</option>
                            <option>Gestion d'entreprises</option>
                        </select>
                        <label for="ins-filiere">Filière souhaitée</label>
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="form-floating">
                        <input type="password" id="ins-password" class="form-control" name="password"
                            placeholder="Mot de passe" required>
                        <label for="ins-password">Mot de passe</label>
                    </div>
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-custom w-100 py-3">S'inscrire</button>
                </div>
            </form>
        </div>
    </div>

    <!-- REINSCRIPTION -->
    <div id="reinscription" class="card card-custom">
        <div class="card-body">
            <h3 class="section-title mb-4">Réinscription – Anciens Stagiaires</h3>
            <form class="row" action="reinscription.php" method="POST">
                <div class="col-md-6 mb-3">
                    <label for="re-id">Identifiant stagiaire</label>
                    <input id="re-id" class="form-control" name="student_id" placeholder="Identifiant stagiaire"
                        required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="re-name">Nom et Prénom</label>
                    <input id="re-name" class="form-control" name="fullname" placeholder="Nom et Prénom" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="re-filiere">Filière actuelle</label>
                    <select id="re-filiere" class="form-select" name="filiere" required>
                        <option disabled selected>Filière actuelle</option>
                        <option>Développement Web</option>
                        <option>Réseaux</option>
                        <option>Gestion d'entreprises</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="re-year">Année précédente</label>
                    <input type="number" id="re-year" class="form-control" name="previous_year"
                        placeholder="Année précédente" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="re-email">Email</label>
                    <input type="email" id="re-email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-custom">Se réinscrire</button>
                </div>
            </form>
        </div>
    </div>

</main>

<?php require_once '../layout/footer.php'; ?>