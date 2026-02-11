<?php
session_start();
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['Admin', 'CEO'])) {
    header('Location: inscrire.php');
    exit;
}

$page_title = "Espace Admin - Gestion des Stagiaires";
$extra_css = ["admin.css"];
$extra_js = ["admin.js"];
$base_path = "../";
require_once '../assets/php/csrf.php';
$token = generate_csrf_token();

require_once '../layout/header.php';

echo "<script>const USER_ROLE = '" . ($_SESSION['user']['role'] ?? 'Admin') . "';</script>";
?>

<main class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-5">
        <h1 class="fw-bold" style="color: #0a2540;">Tableau de Bord Admin</h1>
        <button class="btn btn-outline-danger"
            onclick="window.location.href='../assets/php/auth.php?action=logout'">Déconnexion</button>
    </div>

    <div class="dashboard-card mb-4 p-4 shadow-sm border-0">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h5 class="mb-0">Liste des Stagiaires</h5>
            </div>
            <div class="col-md-6 text-end">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="studentSearch" class="form-control border-start-0"
                        placeholder="Rechercher par nom ou email...">
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-card p-0 shadow-sm border-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Stagiaire</th>
                        <th>Email</th>
                        <th>Filière</th>
                        <th>Année</th>
                        <th>Moyenne</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody id="studentTableBody">
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="spinner-border text-primary" role="status"></div>
                            <p class="mt-2 mb-0 text-muted">Chargement des données...</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <?php if ($_SESSION['user']['role'] === 'CEO'): ?>
        <!-- Admin Management Section (CEO Only) -->
        <div class="dashboard-card mb-4 p-4 shadow-sm border-0 mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0 fw-bold"><i class="bi bi-shield-lock me-2"></i>Gestion des Administrateurs</h5>
                <button class="btn btn-primary" onclick="openAddAdminModal()">
                    <i class="bi bi-plus-lg me-1"></i> Ajouter un Admin
                </button>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nom Complet</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="adminTableBody">
                        <!-- Dynamic admins here -->
                    </tbody>
                </table>
            </div>
        </div>
    <?php endif; ?>
</main>

<!-- Add Admin Modal (CEO Only) -->
<?php if ($_SESSION['user']['role'] === 'CEO'): ?>
    <div class="modal fade" id="adminModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ajouter un Administrateur</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addAdminForm">
                        <div class="mb-3">
                            <label class="form-label">Nom Complet</label>
                            <input type="text" id="adminFullname" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" id="adminEmail" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mot de passe</label>
                            <input type="password" id="adminPassword" class="form-control" required minlength="8">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" onclick="submitAddAdmin()">Créer le compte</button>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Grade Edit Modal -->
<div class="modal fade" id="gradeModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Gérer les Notes - <span id="modalStudentName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="gradesList" class="mb-4">
                    <!-- Dynamic grades here -->
                </div>

                <hr>
                <h6>Ajouter un Module</h6>
                <div class="row g-2 align-items-end">
                    <div class="col-md-6">
                        <label class="form-label small">Nom du Module</label>
                        <input type="text" id="newModule" class="form-control" placeholder="ex: PHP Avancé">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Note /20</label>
                        <input type="number" id="newNote" class="form-control" step="0.25" min="0" max="20"
                            placeholder="18.5">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small">Coeff</label>
                        <input type="number" id="newCoeff" class="form-control" step="0.5" min="1" value="1">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100" onclick="addNewGrade()"><i
                                class="bi bi-plus-lg"></i></button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-success" id="saveGradesBtn">Enregistrer les Modifications</button>
            </div>
        </div>
    </div>
</div>



<?php require_once '../layout/footer.php'; ?>