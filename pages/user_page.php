<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: inscrire.php');
    exit;
}

$user = $_SESSION['user'];
$grades = $user['grades'] ?? [];
$total = array_sum(array_column($grades, 'note'));
$count = count($grades);
$average = $count > 0 ? number_format($total / $count, 2) : 'N/A';

$page_title = "Espace Stagiaire - Tableau de Bord";
$current_page = "user_page";
$base_path = "../";
$extra_css = ["inscrire.css", "user_page.css"];
$extra_js = ["user_page.js"];
require_once '../assets/php/csrf.php';
$token = generate_csrf_token();


require_once '../layout/header.php';
?>

<!-- ================= MAIN CONTENT ================= -->
<main class="container my-5" style="max-width: 1100px;">
    <h1 class="text-center mb-5 fw-bold" style="color: #0a2540;">Bienvenue,
        <?php echo htmlspecialchars($user['fullname']); ?>
    </h1>

    <div class="row">
        <!-- Profile Section -->
        <div class="col-lg-4 mb-4">
            <div class="dashboard-card text-center">
                <?php
                $profileImg = '../assets/images/user_page/default-profile.png';
                if (!empty($user['profile_image'])) {
                    $profileImg = '../assets/php/' . $user['profile_image'];
                } else {
                    $firstName = strtolower(explode(' ', $user['fullname'])[0]);
                    if (file_exists('../assets/images/user_page/' . $firstName . '.png')) {
                        $profileImg = '../assets/images/user_page/' . $firstName . '.png';
                    } elseif (file_exists('../assets/images/user_page/' . $firstName . '.jpeg')) {
                        $profileImg = '../assets/images/user_page/' . $firstName . '.jpeg';
                    }
                }
                ?>
                <div class="position-relative d-inline-block">
                    <img id="profileImg" src="<?php echo $profileImg; ?>" alt="Photo de profil"
                        class="profile-img mb-3">
                    <button id="uploadPhotoBtn"
                        class="btn btn-sm btn-dark position-absolute bottom-0 end-0 rounded-circle"
                        style="margin-bottom: 20px;">
                        <i class="bi bi-camera-fill"></i>
                    </button>
                    <input type="file" id="photoInput" class="d-none" accept="image/*">
                </div>
                <h4 id="studentName" class="mb-3"><?php echo htmlspecialchars($user['fullname']); ?></h4>
                <p class="text-muted"><?php echo htmlspecialchars($user['role'] ?? 'Stagiaire'); ?></p>

                <ul class="list-unstyled mt-4 text-start ps-4">
                    <li class="mb-2"><span class="info-label fw-bold">Identifiant :</span> <span
                            class="info-value"><?php echo htmlspecialchars($user['id']); ?></span></li>
                    <li class="mb-2"><span class="info-label fw-bold">Filière :</span> <span
                            class="info-value"><?php echo htmlspecialchars($user['filiere'] ?? 'N/A'); ?></span></li>
                    <li class="mb-2"><span class="info-label fw-bold">Année :</span> <span
                            class="info-value"><?php echo htmlspecialchars($user['year'] ?? 'N/A'); ?></span></li>
                    <li class="mb-3"><span class="badge bg-success">Inscription validée</span></li>
                    <?php if ($user['role'] === 'Admin'): ?>
                        <li class="mt-4">
                            <a href="admin_page.php" class="btn btn-primary w-100 mb-2">
                                <i class="bi bi-shield-lock me-2"></i>Panel Admin
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>

        <!-- Grades Section -->
        <div class="col-lg-8">
            <div class="dashboard-card">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 style="color: #0a2540;" class="mb-0">Mes Notes</h5>
                    <button class="btn btn-outline-danger btn-sm" id="logoutBtn">Déconnexion</button>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Module</th>
                                <th>Note /20</th>
                                <th>Coefficient</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalPoints = 0;
                            $totalCoeff = 0;
                            if (count($grades) > 0):
                                foreach ($grades as $gradeInfo):
                                    $module = $gradeInfo['module'] ?? 'Unknown';
                                    $note = floatval($gradeInfo['note'] ?? 0);
                                    $coeff = floatval($gradeInfo['coeff'] ?? 1);
                                    $totalPoints += ($note * $coeff);
                                    $totalCoeff += $coeff;
                                    ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($module); ?></td>
                                        <td><span class="fw-bold"><?php echo htmlspecialchars($note); ?></span></td>
                                        <td><?php echo htmlspecialchars($coeff); ?></td>
                                        <td>
                                            <?php if ($note >= 10): ?>
                                                <span class="badge bg-success">Validé</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Non Validé</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">Aucune note disponible</td>
                                </tr>
                            <?php endif; ?>
                            <?php
                            $weightedAverage = $totalCoeff > 0 ? number_format($totalPoints / $totalCoeff, 2) : 'N/A';
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 text-end">
                    <p class="mb-0"><strong>Moyenne générale (pondérée) :</strong> <span id="averageGrade"
                            class="text-success fs-5"><?php echo $weightedAverage; ?></span>/20</p>
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

<?php require_once '../layout/footer.php'; ?>