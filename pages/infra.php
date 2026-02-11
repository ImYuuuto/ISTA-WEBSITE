<?php
session_start();
$page_title = "Infrastructure Digitale | OFPPT";
$current_page = "formations";
$base_path = "../";
$extra_css = ["infra.css"];
$extra_js = ["typewriter.js"];
$extra_head = '<script>const TYPEWRITER_TEXT = `
Le tronc commun en infrastructure digitale permet aux stagiaires de concevoir, administrer, optimiser, et sécuriser des architectures et infrastructures IT.
Au cours de cette étape, qui dure une année de formation professionnelle, les stagiaires suivent une formation qui a la vocation de répondre à deux types de compétences :
- compétences transversales :Les langues , lentreprenuriat, Compétences comportementales et sociales, Culture et techniques avancées du numérique.
- compétences techniques : Comprendre les enjeux dun système dinformation , Concevoir un réseau informatique  , Maîtriser le fonctionnement dun système dexploitation  , Gérer une infrastructure virtualisée ,,, etc
`;</script>';

require_once '../layout/header.php';
?>

<!-- ================= HEADER VIDEO ================= -->
<header class="video-header">
    <video autoplay muted loop playsinline>
        <source src="../assets/videos/infras.mp4" type="video/mp4">
    </video>

    <div class="header-content text-center">
        <h1 class="header-title">Infrastructure Digitale</h1>
        <p>Technicien Spécialisé – OFPPT</p>
        <a href="inscrire.php" class="btn btn-warning mt-3">S’inscrire</a>
    </div>
</header>

<!-- ================= PRESENTATION ================= -->
<div class="container my-5">
    <h2>Présentation de la filière</h2>
    <p>
        La filière <strong>Infrastructure Digitale</strong> forme des techniciens spécialisés capables
        d’installer, configurer, sécuriser et maintenir les infrastructures informatiques,
        réseaux et systèmes au sein des entreprises.
    </p>
    <h2>Présentation du tronc commun</h2>
    <div id="typeText" class="p-3 bg-light rounded shadow-sm"></div>
</div>

<!-- ================= CARDS ================= -->
<div class="container my-5">
    <div class="row g-4">

        <div class="col-md-4" data-aos="fade-up">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5>🎯 Objectifs</h5>
                    <p>
                        Maîtriser l’installation et l’administration des réseaux,
                        serveurs, systèmes et services cloud.
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5>🕒 Durée & Diplôme</h5>
                    <ul class="list-unstyled">
                        <li>✔ Durée : 2 ans</li>
                        <li>✔ 4 semestres</li>
                        <li>✔ Diplôme : Technicien Spécialisé</li>
                        <li>✔ Reconnu par l’État</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5>🎓 Conditions d’accès</h5>
                    <ul class="list-unstyled">
                        <li>✔ Baccalauréat scientifique ou technique</li>
                        <li>✔ Orientation OFPPT</li>
                        <li>✔ Sélection sur dossier</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4" data-aos="fade-up">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5>🖧 Compétences acquises</h5>
                    <ul>
                        <li>Administration systèmes (Windows / Linux)</li>
                        <li>Réseaux informatiques & sécurité</li>
                        <li>Virtualisation & Cloud</li>
                        <li>Maintenance des infrastructures</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5>📚 Modules principaux</h5>
                    <ul>
                        <li>Architecture des réseaux</li>
                        <li>Systèmes d’exploitation</li>
                        <li>Sécurité informatique</li>
                        <li>Virtualisation & Cloud</li>
                        <li>Supervision & support IT</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card h-100 shadow">
                <div class="card-body">
                    <h5>🚀 Débouchés professionnels</h5>
                    <ul>
                        <li>Technicien réseaux</li>
                        <li>Administrateur systèmes junior</li>
                        <li>Technicien support IT</li>
                        <li>Opérateur Cloud</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once '../layout/footer.php'; ?>