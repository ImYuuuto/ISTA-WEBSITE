<?php
session_start();
$page_title = "Formations | Établissement";
$current_page = "formations";
$base_path = "../";
$extra_css = [
    "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css",
    "formations.css"
];
require_once '../layout/header.php';
?>

<!-- VIDEO BACKGROUND FAIBLE HEIGHT (HEADER ONLY) -->
<div class="video-bg">
    <video autoplay muted loop playsinline preload="auto">
        <source src="../assets/videos/bg.mp4" type="video/mp4" />
    </video>

    <!-- CONTENT OVER VIDEO -->
    <div class="video-content text-center">
        <h1 class="animate-text">Bienvenue à MyWay (L510)</h1>
        <p class="animate-text1">
            Centre de formation professionnelle orienté métier
        </p>
    </div>
</div>

<section class="orientation-section py-5">
    <div class="container text-center">
        <h2 class="section-title mb-5 fade-up">
            Une orientation personnalisée <br />
            <span>pour réussir votre projet professionnel</span>
        </h2>

        <div class="row g-4">
            <!-- Card 1 -->
            <div class="col-md-4">
                <div class="orientation-card fade-up delay-1 text-center" data-aos="fade-up" data-aos-delay="0">
                    <i class="fa-solid fa-compass orientation-icon"></i>
                    <h5>Une orientation complète et adaptée</h5>
                    <p>
                        Une plateforme ludique mise à votre disposition pour explorer
                        vos possibilités de carrière et tracer le parcours qui vous
                        convient.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="orientation-card fade-up delay-2 text-center" data-aos="fade-up" data-aos-delay="100">
                    <i class="fa-solid fa-user-graduate orientation-icon"></i>
                    <h5>Un accompagnement personnalisé</h5>
                    <p>
                        Faites confiance à nos conseillers pour vous accompagner dans
                        votre réflexion et vous appuyer dans vos démarches.
                    </p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="orientation-card fade-up delay-3 text-center" data-aos="fade-up" data-aos-delay="200">
                    <i class="fa-solid fa-id-card orientation-icon"></i>
                    <h5>Un compte unique pour votre parcours</h5>
                    <p>
                        Connectez-vous à votre espace My Way et accédez à une panoplie
                        de services pour piloter votre projet professionnel.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container">
    <h1 class="text-center filier">
        Votre avenir commence avec nos filières
    </h1>
</div>

<div class="container my-5">
    <div class="row g-4 justify-content-center">
        <!-- CARD 1 -->
        <div class="col-md-4 reveal" id="dev-digital" data-aos="fade-up">
            <div class="card h-100 shadow">
                <img src="../assets/images/image.png" class="card-img-top" alt="" />
                <div class="card-body">
                    <h5 class="card-title">Développement Digital</h5>
                    <p class="card-text">
                        Développement web, applications et programmation. Cette
                        formation vous prépare aux métiers du numérique en vous offrant
                        des compétences solides en développement web, développement
                        d’applications et programmation...
                    </p>
                    <div class="action-buttons">
                        <a class="btn btn-pro" href="development.php"> Voir plus </a>
                        <a class="btn btn-pro-outline" data-bs-toggle="collapse" href="#dev">Voir le programme</a>
                    </div>
                    <div class="collapse mt-2" id="dev">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">HTML, CSS, JavaScript</li>
                            <li class="list-group-item">React, Angular</li>
                            <li class="list-group-item">Node.js, PHP</li>
                            <li class="list-group-item">MySQL, MongoDB</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 2 -->
        <div class="col-md-4 reveal" id="infra-systemes" data-aos="fade-up" data-aos-delay="100">
            <div class="card h-100 shadow">
                <img src="../assets/images/image2.png" class="card-img-top" alt="" />
                <div class="card-body">
                    <h5 class="card-title">Infrastructure & Systèmes</h5>
                    <p class="card-text">
                        Réseaux, sécurité et cloud.Le tronc commun en infrastructure
                        digitale permet aux stagiaires de concevoir, administrer,
                        optimiser, et sécuriser des architectures et infrastructures IT.
                        Au cours de cette étape, qui dure une année de...
                    </p>

                    <div class="action-buttons">
                        <a class="btn btn-pro" href="infra.php"> Voir plus </a>
                        <a class="btn btn-pro-outline" data-bs-toggle="collapse" href="#infra">Voir le programme</a>
                    </div>

                    <div class="collapse mt-2" id="infra">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Administration systèmes</li>
                            <li class="list-group-item">Sécurité réseau</li>
                            <li class="list-group-item">Virtualisation</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 3 -->
        <div class="col-md-4 reveal" id="gestion" data-aos="fade-up" data-aos-delay="200">
            <div class="card h-100 shadow">
                <img src="../assets/images/image3.png" class="card-img-top" alt="" />
                <div class="card-body">
                    <h5 class="card-title">Gestion des Entreprises</h5>
                    <p class="card-text">
                        Management, finance et marketing.Cette formation vous prépare
                        aux métiers de la gestion et du management en vous apportant des
                        compétences solides en management, finance et marketing. V
                        efficacement les activités d’une entreprise...
                    </p>

                    <div class="action-buttons">
                        <a class="btn btn-pro" href="development.php"> Voir plus </a>

                        <a class="btn btn-pro-outline" data-bs-toggle="collapse" href="#gestion-prog">
                            Voir le programme
                        </a>
                    </div>
                    <div class="collapse mt-2" id="gestion-prog">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Management</li>
                            <li class="list-group-item">Comptabilité</li>
                            <li class="list-group-item">Marketing</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 4 -->
        <div class="col-md-4 reveal" data-aos="fade-up">
            <div class="card h-100 shadow">
                <img src="../assets/images/image4.png" class="card-img-top" alt="" />
                <div class="card-body">
                    <h5 class="card-title">Marketing Digital</h5>
                    <p class="card-text">
                        Réseaux sociaux, publicité en ligne et branding.Cette formation
                        vous permet d’acquérir les compétences essentielles en marketing
                        digital, notamment la gestion des réseaux sociaux, la publicité
                        en ligne et...
                    </p>

                    <div class="action-buttons">
                        <a class="btn btn-pro" href="development.php"> Voir plus </a>

                        <a class="btn btn-pro-outline" data-bs-toggle="collapse" href="#marketing">
                            Voir le programme
                        </a>
                    </div>

                    <div class="collapse mt-2" id="marketing">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">SEO & SEM</li>
                            <li class="list-group-item">Publicité Facebook & Google</li>
                            <li class="list-group-item">Email marketing</li>
                            <li class="list-group-item">Stratégie digitale</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 5 -->
        <div class="col-md-4 reveal" data-aos="fade-up" data-aos-delay="100">
            <div class="card h-100 shadow">
                <img src="../assets/images/image5.png" class="card-img-top" alt="" />
                <div class="card-body">
                    <h5 class="card-title">Ressources Humaines</h5>
                    <p class="card-text">
                        Gestion du personnel et administration RH.Cette formation vous
                        prépare aux fonctions clés des ressources humaines, notamment la
                        gestion du personnel et l’administration RH. Vous apprendrez à
                        ...
                    </p>

                    <div class="action-buttons">
                        <a class="btn btn-pro" href="development.php"> Voir plus </a>

                        <a class="btn btn-pro-outline" data-bs-toggle="collapse" href="#rh">
                            Voir le programme
                        </a>
                    </div>

                    <div class="collapse mt-2" id="rh">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Recrutement</li>
                            <li class="list-group-item">Gestion de la paie</li>
                            <li class="list-group-item">Formation du personnel</li>
                            <li class="list-group-item">Relations sociales</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- CARD 6 -->
        <div class="col-md-4 reveal" data-aos="fade-up" data-aos-delay="200">
            <div class="card h-100 shadow">
                <img src="../assets/images/image6.png" class="card-img-top" alt="" />
                <div class="card-body">
                    <h5 class="card-title">Finance & Comptabilité</h5>
                    <p class="card-text">
                        Comptabilité, fiscalité et analyse financière.Cette formation
                        vous apporte des compétences solides en comptabilité, fiscalité
                        et analyse financière. Vous apprendrez à enregistrer et analyser
                        ...
                    </p>

                    <div class="action-buttons">
                        <a class="btn btn-pro" href="development.php"> Voir plus </a>

                        <a class="btn btn-pro-outline" data-bs-toggle="collapse" href="#finance">
                            Voir le programme
                        </a>
                    </div>

                    <div class="collapse mt-2" id="finance">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Comptabilité générale</li>
                            <li class="list-group-item">Analyse financière</li>
                            <li class="list-group-item">Fiscalité</li>
                            <li class="list-group-item">Gestion de trésorerie</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php require_once '../layout/footer.php'; ?>