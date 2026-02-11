<?php
/**
 * header.php
 * Common header for all pages.
 * Supports a recursive $base_path for asset linking.
 */
require_once __DIR__ . '/../assets/php/security_headers.php';
$base_path = $base_path ?? '';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title ?? 'Établissement'; ?></title>
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/libs/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/search_bar.css">
    <?php if (isset($extra_css)): ?>
        <?php foreach ($extra_css as $css): ?>
            <?php if (strpos($css, 'http') === 0): ?>
                <link rel="stylesheet" href="<?php echo $css; ?>">
            <?php else: ?>
                <link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/<?php echo $css; ?>">
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php echo $extra_head ?? ''; ?>
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
</head>

<body>
    <!--  NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="<?php echo $base_path; ?>index.php">
                <img src="<?php echo $base_path; ?>assets/images/indexmain/Logo_ofppt.png" width="50" alt="Logo OFPPT"
                    class="me-2 rounded-circle">
                <span>Établissement</span>
            </a>

            <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"
                aria-label="Menu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link <?php echo ($current_page == 'home') ? 'active' : ''; ?>"
                            href="<?php echo $base_path; ?>index.php">Accueil</a></li>
                    <li class="nav-item"><a
                            class="nav-link <?php echo ($current_page == 'activities') ? 'active' : ''; ?>"
                            href="<?php echo $base_path; ?>pages/activities.php">Vie Active</a></li>
                    <li class="nav-item"><a
                            class="nav-link <?php echo ($current_page == 'formateurs') ? 'active' : ''; ?>"
                            href="<?php echo $base_path; ?>pages/formateurs.php">Formateurs</a></li>
                    <?php if (isset($_SESSION['user'])): ?>
                        <?php if (in_array($_SESSION['user']['role'], ['Admin', 'CEO'])): ?>
                            <li class="nav-item"><a
                                    class="nav-link <?php echo ($current_page == 'admin_page') ? 'active' : ''; ?>"
                                    href="<?php echo $base_path; ?>pages/admin_page.php">Dashboard Admin</a></li>
                        <?php else: ?>
                            <li class="nav-item"><a
                                    class="nav-link <?php echo ($current_page == 'user_page') ? 'active' : ''; ?>"
                                    href="<?php echo $base_path; ?>pages/user_page.php">Mon Espace</a></li>
                        <?php endif; ?>
                    <?php else: ?>
                        <li class="nav-item"><a
                                class="nav-link <?php echo ($current_page == 'inscrire') ? 'active' : ''; ?>"
                                href="<?php echo $base_path; ?>pages/inscrire.php">M'inscrire</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a
                            class="nav-link <?php echo ($current_page == 'formations') ? 'active' : ''; ?>"
                            href="<?php echo $base_path; ?>pages/formations.php">Formations</a></li>
                    <li class="nav-item"><a class="nav-link <?php echo ($current_page == 'contact') ? 'active' : ''; ?>"
                            href="<?php echo $base_path; ?>pages/contact.php">Contact</a></li>
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