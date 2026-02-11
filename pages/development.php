<?php
session_start();
$page_title = "Développement Digital | Établissement";
$current_page = "formations";
$base_path = "../";
$extra_css = ["dev.css"];
$extra_js = ["typewriter.js"];
$extra_head = '<script>const TYPEWRITER_TEXT = `
Le tronc commun en Développement Digital est une étape importante pour acquérir les bases nécessaires à létude, la conception, la construction, le développement, la mise au point, la maintenance et à l’amélioration des logiciels, des applications et des sites web.

Au cours de cette étape, qui dure une année de formation professionnelle, les stagiaires suivent une formation qui a la vocation de répondre à deux types de compétences :

- Compétences transversales : Les langues, lentrepreneuriat, les compétences comportementales et sociales, la culture et les techniques avancées du numérique.
- Compétences techniques : Acquérir les bases de lalgorithmique, programmer en orienté objet, développer des sites web statiques, programmer en JavaScript, développer des sites web dynamiques.
`;</script>';

require_once '../layout/header.php';
?>

<header class="video-header">
    <video autoplay muted loop playsinline>
        <source src="../assets/videos/dev.mp4" type="video/mp4">
        Votre navigateur ne supporte pas la vidéo.
    </video>

    <div class="header-overlay"></div>

    <div class="header-content text-center">
        <h1>Filière Développement Digital</h1>
        <p>Office de la Formation Professionnelle et de la Promotion du Travail</p>
        <a href="inscrire.php" class="btn btn-warning mt-3">S’inscrire maintenant</a>
    </div>
</header>

<div class="container my-5">
    <h2>Présentation du tronc commun</h2>
    <div id="typeText" class="p-3 bg-light rounded shadow-sm"></div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-5"> Développement Digital</h2>

    <div class="row g-4">

        <!-- Card 1 -->
        <div class="col-md-4" data-aos="fade-up">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">🎯 Objectifs</h5>
                    <p class="card-text">
                        Former des développeurs capables de concevoir, coder, tester et déployer
                        des solutions digitales professionnelles (web & mobile).
                    </p>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">🕒 Durée & Diplôme</h5>
                    <ul class="list-unstyled">
                        <li>✔ Durée : 2 ans</li>
                        <li>✔ 4 semestres</li>
                        <li>✔ Diplôme : Technicien Spécialisé</li>
                        <li>✔ Formation reconnue par l’État</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">🎓 Conditions d’accès</h5>
                    <ul class="list-unstyled">
                        <li>✔ Baccalauréat ou équivalent</li>
                        <li>✔ Orientation OFPPT</li>
                        <li>✔ Sélection selon le dossier</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-4" data-aos="fade-up">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">💻 Compétences acquises</h5>
                    <ul>
                        <li>Développement Web (HTML, CSS, JS)</li>
                        <li>Programmation Back-End</li>
                        <li>Gestion des bases de données</li>
                        <li>Frameworks & outils modernes</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">📚 Modules principaux</h5>
                    <ul>
                        <li>Initiation au métier</li>
                        <li>Développement Front-End</li>
                        <li>Développement Back-End</li>
                        <li>Développement Mobile</li>
                        <li>Gestion de projet digital</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Card 6 -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5 class="card-title">🚀 Débouchés professionnels</h5>
                    <ul>
                        <li>Développeur Web Junior</li>
                        <li>Développeur Mobile</li>
                        <li>Intégrateur Web</li>
                        <li>Assistant chef de projet digital</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once '../layout/footer.php'; ?>