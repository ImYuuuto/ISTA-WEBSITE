<?php
session_start();
$page_title = "Accueil | Établissement";
$current_page = "home";
$extra_css = ["index.css"];
require_once 'layout/header.php';
?>

<!-- CAROUSEL -->
<section class="main-banner">
    <div id="mainCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">

        <div class="carousel-indicators">
            <button data-bs-target="#mainCarousel" data-bs-slide-to="0" class="active"></button>
            <button data-bs-target="#mainCarousel" data-bs-slide-to="1"></button>
            <button data-bs-target="#mainCarousel" data-bs-slide-to="2"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="assets/images/indexmain/carou1.jpg" class="d-block w-100 carousel-img" alt="Établissement">
                <div class="carousel-caption">
                    <h2>Notre Établissement</h2>
                    <p>Un environnement moderne pour un apprentissage de qualité</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="assets/images/indexmain/carou2.jpeg" class="d-block w-100 carousel-img" alt="Événements">
                <div class="carousel-caption">
                    <h2>Événements Récents</h2>
                    <p>Conférences, ateliers et activités étudiantes</p>
                </div>
            </div>

            <div class="carousel-item">
                <img src="assets/images/indexmain/carou3.jpg" class="d-block w-100 carousel-img" alt="Vie étudiante">
                <div class="carousel-caption">
                    <h2>Vie Étudiante</h2>
                    <p>Un campus dynamique et innovant</p>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#mainCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#mainCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</section>

<section class="container my-5">
    <h2 class="text-center mb-5">Informations Générales</h2>

    <div class="row g-4">

        <!-- Card 1 -->
        <div class="col-md-4" data-aos="fade-up">
            <div class="card h-100 shadow-sm info-card">
                <div class="card-img-wrapper">
                    <img src="assets/images/mission.png" alt="Mission" class="card-img-top">
                    <div class="overlay"><i class="bi bi-bullseye icon-overlay"></i></div>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title">Mission</h5>
                    <p class="card-text">Former des professionnels compétents capables de répondre aux besoins du marché
                        du travail.</p>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card h-100 shadow-sm info-card">
                <div class="card-img-wrapper">
                    <img src="assets/images/valeur.png" alt="Valeurs" class="card-img-top">
                    <div class="overlay"><i class="bi bi-people-fill icon-overlay"></i></div>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title">Valeurs</h5>
                    <p class="card-text">Engagement, professionnalisme, innovation et solidarité pour un développement
                        durable.</p>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card h-100 shadow-sm info-card">
                <div class="card-img-wrapper">
                    <img src="assets/images/histoire.png" alt="Histoire" class="card-img-top">
                    <div class="overlay"><i class="bi bi-building icon-overlay"></i></div>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title">Histoire</h5>
                    <p class="card-text">L'OFPPT, fondé en 1972, est le leader de la formation professionnelle au Maroc.
                    </p>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-4" data-aos="fade-up">
            <div class="card h-100 shadow-sm info-card">
                <div class="card-img-wrapper">
                    <img src="assets/images/reseaux.png" alt="Réseau" class="card-img-top">
                    <div class="overlay"><i class="bi bi-globe2 icon-overlay"></i></div>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title">Réseau</h5>
                    <p class="card-text">Plus de 200 établissements et un réseau national et international de
                        partenaires.</p>
                </div>
            </div>
        </div>

        <!-- Card 5 -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card h-100 shadow-sm info-card">
                <div class="card-img-wrapper">
                    <img src="assets/images/chiffre.png" alt="Chiffres Clés" class="card-img-top">
                    <div class="overlay"><i class="bi bi-bar-chart-fill icon-overlay"></i></div>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title">Chiffres Clés</h5>
                    <p class="card-text">100 000 stagiaires par an, 2 000 formateurs et 300 métiers couverts.</p>
                </div>
            </div>
        </div>

        <!-- Card 6 -->
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card h-100 shadow-sm info-card">
                <div class="card-img-wrapper">
                    <img src="assets/images/coll.png" alt="Partenaires" class="card-img-top">
                    <div class="overlay"><i class="bi bi-award-fill icon-overlay"></i></div>
                </div>
                <div class="card-body text-center">
                    <h5 class="card-title">Partenaires</h5>
                    <p class="card-text">Collaboration avec entreprises nationales et internationales pour stages et
                        emploi.</p>
                </div>
            </div>
        </div>

    </div>
</section>


<!-- Hero Section Two Columns -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">

            <!-- Left Column: Text -->
            <div class="col-md-6" data-aos="fade-right">
                <h1 class="hero-title">Bienvenue à l'OFPPT</h1>
                <p class="hero-paragraph">
                    Vous êtes sur la bonne voie, pour devenir acteur du Maroc des Compétences !<br><br>
                    Bien choisir votre métier est votre premier pas sur le chemin de la réussite.
                </p>
                <a href="pages/formations.php" class="btn btn-hero">Découvrir les Formations</a>
            </div>

            <!-- Right Column: Video -->
            <div class="col-md-6 text-center" data-aos="fade-left">
                <video class="hero-video" autoplay muted loop playsinline>
                    <source src="assets/videos/ofppt.mp4" type="video/mp4">
                    Votre navigateur ne supporte pas la vidéo.
                </video>
            </div>

        </div>
    </div>
</section>

<?php require_once 'layout/footer.php'; ?>