<?php
session_start();
$page_title = "Nos Formateurs | Établissement";
$current_page = "formateurs";
$base_path = "../";
$extra_css = [
    "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css",
    "formateurs.css"
];
require_once '../layout/header.php';
?>

<!-- HEADER -->
<header class="header-section">
    <div class="header-content">
        <h1 class="header-title">Nos Formateurs</h1>
        <p class="header-subtitle">L'excellence pédagogique au service de votre avenir</p>
    </div>
</header>

<!-- INTRO SECTION -->
<section class="container my-5 text-center">
    <div class="row justify-content-center">
        <div class="col-lg-8" data-aos="fade-up">
            <h2 class="section-title">Une Équipe d'Experts</h2>
            <p class="lead text-muted">
                Nos formateurs sont des professionnels du secteur, alliant expertise technique et passion pour
                l'enseignement.
                Ils vous accompagnent tout au long de votre parcours pour maîtriser les technologies de demain.
            </p>
        </div>
    </div>
</section>

<!-- TEAM GRID -->
<section class="container mb-5">
    <div class="row g-4 justify-content-center">

        <!-- Ilham Benmalouk -->
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="0">
            <div class="team-card h-100">
                <div class="team-img-wrapper">
                    <img src="../assets/images/user_page/default-profile.png" class="team-img" alt="Ilham Benmalouk"
                        onerror="this.src='https://ui-avatars.com/api/?name=Ilham+Benmalouk&background=0D8ABC&color=fff'">
                </div>
                <div class="card-body">
                    <h5 class="team-name">Ilham Benmalouk</h5>
                    <p class="team-role">Formatrice Experte</p>
                    <div class="team-specialties">
                        <span>Data Science</span>
                        <span>Big Data</span>
                        <span>Python</span>
                    </div>
                    <div class="social-links">
                        <a href="https://www.linkedin.com/in/ilham-benmalouk-65a301240/" target="_blank"><i
                                class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rkia Zohari -->
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
            <div class="team-card h-100">
                <div class="team-img-wrapper">
                    <img src="../assets/images/user_page/default-profile.png" class="team-img" alt="Rkia Zohari"
                        onerror="this.src='https://ui-avatars.com/api/?name=Rkia+Zohari&background=e91e63&color=fff'">
                </div>
                <div class="card-body">
                    <h5 class="team-name">Rkia Zohari</h5>
                    <p class="team-role">Formatrice IA</p>
                    <div class="team-specialties">
                        <span>Artificial Intelligence</span>
                        <span>Machine Learning</span>
                        <span>Deep Learning</span>
                    </div>
                    <div class="social-links">
                        <a href="https://www.linkedin.com/in/zohari-rkia-5362a5212/" target="_blank"><i
                                class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Oussama Elhousni -->
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
            <div class="team-card h-100">
                <div class="team-img-wrapper">
                    <img src="../assets/images/user_page/default-profile.png" class="team-img" alt="Oussama Elhousni"
                        onerror="this.src='https://ui-avatars.com/api/?name=Oussama+Elhousni&background=1fa67a&color=fff'">
                </div>
                <div class="card-body">
                    <h5 class="team-name">Oussama Elhousni</h5>
                    <p class="team-role">Fullstack Engineer</p>
                    <div class="team-specialties">
                        <span>Fullstack Dev</span>
                        <span>React / Node.js</span>
                        <span>DevOps</span>
                    </div>
                    <div class="social-links">
                        <a href="https://www.linkedin.com/in/oussamaelhousni/" target="_blank"><i
                                class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fas fa-envelope"></i></a>
                        <a href="#"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Saad Saoud -->
        <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
            <div class="team-card h-100">
                <div class="team-img-wrapper">
                    <img src="../assets/images/user_page/default-profile.png" class="team-img" alt="Saad Saoud"
                        onerror="this.src='https://ui-avatars.com/api/?name=Saad+Saoud&background=ffc107&color=fff'">
                </div>
                <div class="card-body">
                    <h5 class="team-name">Saad Saoud</h5>
                    <p class="team-role">Expert Data & IA</p>
                    <div class="team-specialties">
                        <span>Data Science</span>
                        <span>Artificial Intelligence</span>
                    </div>
                    <div class="social-links">
                        <a href="https://www.linkedin.com/in/saad-saoud-4a3ba416b/" target="_blank"><i
                                class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fas fa-envelope"></i></a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<?php require_once '../layout/footer.php'; ?>