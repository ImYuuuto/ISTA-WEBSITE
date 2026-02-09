<?php
session_start();
$page_title = "Vie à l'Etablissement | OFPPT";
$current_page = "activities";
$base_path = "../";
$extra_css = [
    "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css",
    "activities.css"
];
require_once '../layout/header.php';
?>

<!-- HEADER -->
<header class="video-header">
    <video autoplay muted loop playsinline>
        <source src="../assets/videos/bg.mp4" type="video/mp4">
    </video>
    <div class="header-content">
        <h1 class="header-title">Vie à l'Etablissement</h1>
        <p class="header-subtitle">Un épanouissement au-delà de la formation</p>
    </div>
</header>

<!-- INTRO SECTION -->
<section class="container my-5 text-center">
    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="fade-up">
            <h2 class="section-title">Une vie estudiantine riche et dynamique</h2>
            <p class="lead text-muted">
                L'OFPPT ne se limite pas aux cours. Nous encourageons nos stagiaires à s'engager dans des activités
                parascolaires pour développer leur créativité, leur esprit d'équipe et leur leadership.
            </p>
        </div>
    </div>
</section>

<!-- ACTIVITIES CARDS -->
<section class="container mb-5">
    <div class="row g-4">

        <!-- Card 1 -->
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
            <div class="activity-card h-100">
                <img src="../assets/images/image.png" class="card-img-top" alt="Clubs">
                <div class="card-body text-center">
                    <i class="fa-solid fa-microchip card-icon"></i>
                    <h5 class="card-title">Clubs Scientifiques</h5>
                    <p class="card-text">Rejoignez le club de robotique, de coding ou d'IA et participez à des
                        hackathons nationaux.</p>
                </div>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
            <div class="activity-card h-100">
                <img src="../assets/images/image3.png" class="card-img-top" alt="Sport">
                <div class="card-body text-center">
                    <i class="fa-solid fa-basketball card-icon"></i>
                    <h5 class="card-title">Sport & Détente</h5>
                    <p class="card-text">Terrains de football, basketball et salles de sport pour garder la forme et
                        l'esprit d'équipe.</p>
                </div>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
            <div class="activity-card h-100">
                <img src="../assets/images/image4.png" class="card-img-top" alt="Events">
                <div class="card-body text-center">
                    <i class="fa-solid fa-calendar-star card-icon"></i>
                    <h5 class="card-title">Événements & Culture</h5>
                    <p class="card-text">Journées portes ouvertes, compétitions culturelles et rencontres avec des
                        professionnels.</p>
                </div>
            </div>
        </div>

        <!-- Card 4 -->
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
            <div class="activity-card h-100">
                <img src="../assets/images/image5.png" class="card-img-top" alt="Coworking">
                <div class="card-body text-center">
                    <i class="fa-solid fa-users-rectangle card-icon"></i>
                    <h5 class="card-title">Espaces Coworking</h5>
                    <p class="card-text">Des espaces modernes et connectés pour travailler en groupe sur vos projets
                        innovants.</p>
                </div>
            </div>
        </div>

    </div>
</section>

<?php require_once '../layout/footer.php'; ?>