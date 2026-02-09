<?php
require_once '../assets/php/security_headers.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: inscrire.html');
    exit;
}

$user = $_SESSION['user'];
?>
<?php
// Calculate logic
$grades = $user['grades'] ?? [];
$total = 0;
$count = count($grades);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Espace Stagiaire - Tableau de Bord</title>
    <link rel="stylesheet" href="../assets/libs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../assets/css/Inscrire.css">
    <link rel="stylesheet" href="../assets/css/user_page.css">
    <link rel="stylesheet" href="../assets/css/search_bar.css">
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body>

    <!-- ================= NAVBAR ================= -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">

            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="../assets/images/indexmain/Logo_ofppt.png" width="50" alt="Logo OFPPT"
                    class="me-2 rounded-circle">
                <span>Établissement</span>
            </a>

            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
                aria-label="Menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="../index.html">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="activities.html">Vie Active</a></li>
                    <li class="nav-item"><a class="nav-link" href="formateurs.html">Formateurs</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Mon Espace</a></li>
                    <li class="nav-item"><a class="nav-link" href="formations.html">Formations</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html">Contact</a></li>
                </ul>

                <form class="d-flex position-relative" role="search" autocomplete="off">
                    <input id="searchInput" class="form-control me-2 search-input" type="search"
                        placeholder="Rechercher une filière" />
                    <button class="btn btn-search" type="submit">Search</button>
                    <!-- Suggestions -->
                    <ul id="searchSuggestions" class="list-group position-absolute w-100"></ul>
                </form>
            </div>
        </div>
    </nav>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="container my-5" style="max-width: 1100px;">
        <h1 class="text-center mb-5 fw-bold" style="color: #0a2540;">Bienvenue,
            <?php echo htmlspecialchars($user['fullname']); ?>
        </h1>

        <div class="row">
            <!-- Profile Section -->
            <div class="col-lg-4 mb-4">
                <div class="dashboard-card text-center">
                    <!-- Dynamic Profile Image Logic -->
                    <?php
                    $profileImg = '../assets/images/user_page/default-profile.png';
                    // Simple check if user specific image exists based on name (mock logic)
                    if (file_exists('../assets/images/user_page/' . strtolower(explode(' ', $user['fullname'])[0]) . '.png')) {
                        $profileImg = '../assets/images/user_page/' . strtolower(explode(' ', $user['fullname'])[0]) . '.png';
                    } elseif (file_exists('../assets/images/user_page/' . strtolower(explode(' ', $user['fullname'])[0]) . '.jpeg')) {
                        $profileImg = '../assets/images/user_page/' . strtolower(explode(' ', $user['fullname'])[0]) . '.jpeg';
                    }
                    ?>
                    <img id="profileImg" src="<?php echo $profileImg; ?>" alt="Photo de profil"
                        class="profile-img mb-3">
                    <h4 id="studentName" class="mb-3"><?php echo htmlspecialchars($user['fullname']); ?></h4>
                    <p class="text-muted"><?php echo htmlspecialchars($user['role'] ?? 'Stagiaire'); ?></p>

                    <ul class="list-unstyled mt-4">
                        <li class="mb-2"><span class="info-label">Identifiant :</span> <span
                                class="info-value"><?php echo htmlspecialchars($user['id']); ?></span></li>
                        <li class="mb-2"><span class="info-label">Filière :</span> <span
                                class="info-value"><?php echo htmlspecialchars($user['filiere'] ?? 'N/A'); ?></span>
                        </li>
                        <li class="mb-2"><span class="info-label">Année :</span> <span
                                class="info-value"><?php echo htmlspecialchars($user['year'] ?? 'N/A'); ?></span></li>
                        <li class="mb-3"><span class="status-badge">Inscription validée</span></li>
                    </ul>

                    <div class="col-lg-8">
                        <div class="dashboard-card">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h5 style="color: #0a2540;">Mes Notes</h5>
                                <button class="btn btn-outline-danger btn-sm" id="logoutBtn">Déconnexion</button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Module</th>
                                            <th>Note /20</th>
                                            <th>Statut</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (count($grades) > 0): ?>
                                            <?php foreach ($grades as $module => $grade): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($module); ?></td>
                                                    <td><span class="fw-bold"><?php echo htmlspecialchars($grade); ?></span>
                                                    </td>
                                                    <td>
                                                        <?php if ($grade >= 10): ?>
                                                            <span class="badge bg-success">Validé</span>
                                                        <?php else: ?>
                                                            <span class="badge bg-danger">Non Validé</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="3" class="text-center">Aucune note disponible</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-4 text-end">
                                <p><strong>Moyenne générale :</strong> <span id="averageGrade"
                                        class="text-success fs-5"><?php echo $count > 0 ? number_format(array_sum($grades) / $count, 2) : 'N/A'; ?></span>/20
                                </p>
                            </div>
                        </div>

                        <div class="dashboard-card mt-4" data-aos="fade-up" data-aos-delay="100">
                            <h5 style="color: #0a2540;">Informations importantes</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Date de rentrée : 15 Septembre 2025</li>
                                <li class="list-group-item">Horaires : Lundi à Vendredi, 8h30 - 16h30</li>
                                <li class="list-group-item">Contact formateur : formateur.dev@ofppt.ma</li>
                                <li class="list-group-item">Plateforme e-learning disponible</li>
                            </ul>
                        </div>
                    </div>
                </div>
    </main>

    <!-- ================= FOOTER ================= -->
    <footer class="footer-custom text-white pt-4">
        <div class="container">
            <div class="row">

                <div class="col-md-6 mb-3">
                    <h5 class="footer-title">Coordonnées</h5>
                    <p>📍 Avenue Brahim Roudani, El Jadida</p>
                    <p>📞 05233-41269</p>
                    <p>✉️ ofppt@etablissement.ma</p>
                </div>

                <div class="col-md-6 mb-3">
                    <h5 class="footer-title">Suivez-nous</h5>
                    <a href="https://web.facebook.com/ofppt.page.officielle/?_rdc=1&_rdr#"
                        class="social-link me-3">Facebook</a>
                    <a href="https://x.com/OFPPT_Officiel" class="social-link me-3">X</a>
                    <a href="https://www.instagram.com/ofppt.officiel/" class="social-link me-3">Instagram</a>
                    <a href="https://www.linkedin.com/company/ofpptpageofficielle/" class="social-link">LinkedIn</a>
                </div>
            </div>

            <hr class="footer-line">
            <p class="text-center mb-0">© 2026 OFPPT. Tous droits réservés</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="../assets/libs/bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/search_bar.js"></script>
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });

        document.getElementById('logoutBtn').addEventListener('click', () => {
            fetch('../assets/php/auth.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ action: 'logout' })
            })
                .then(response => response.json())
                .then(result => {
                    if (result.status === 'success') {
                        window.location.href = 'inscrire.html';
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    </script>
</body>

</html>