<?php
require_once 'security_headers.php'; // Include security headers
session_start();
header('Content-Type: application/json');

require_once 'csrf.php';
$db = require_once 'db.php';

// Get input
$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = array_merge($_POST, $_GET);
}

// CSRF check for POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $input['csrf_token'] ?? '';
    if (!validate_csrf_token($token)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token.']);
        exit;
    }
}

$action = $input['action'] ?? '';

if ($action === 'register') {
    $fullname = trim($input['fullname'] ?? '');
    $email = trim($input['email'] ?? '');
    $password = $input['password'] ?? '';

    // Basic Validation
    if (empty($fullname) || empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
        exit;
    }

    // Email Validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format.']);
        exit;
    }

    // Password Strength
    if (strlen($password) < 8) {
        echo json_encode(['status' => 'error', 'message' => 'Password must be at least 8 characters.']);
        exit;
    }

    // Check if email exists in students table
    $stmt = $db->prepare("SELECT id FROM students WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode(['status' => 'error', 'message' => 'Email already registered.']);
        exit;
    }

    // Handle profile image upload if present
    $profile_image = null;
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['profile_image'];
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        $max_size = 2 * 1024 * 1024; // 2MB

        if (in_array($file['type'], $allowed_types) && $file['size'] <= $max_size) {
            $user_id_temp = uniqid(); // Use temp ID for filename if ID not yet generated
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
            $filename = $user_id_temp . '_' . time() . '.' . $extension;
            $upload_path = '../images/profiles/' . $filename;
            $absolute_path = __DIR__ . '/' . $upload_path;

            if (move_uploaded_file($file['tmp_name'], $absolute_path)) {
                $profile_image = $upload_path;
            }
        }
    }

    // Add new student
    $id = isset($user_id_temp) ? $user_id_temp : uniqid();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Default modules for "Développement Digital"
    $defaultGrades = [];
    $filiere = "Développement Digital";

    if ($filiere === "Développement Digital") {
        $modules = [
            'site web statique' => 3,
            'algorithme' => 2,
            'Poo' => 2,
            'site web dynamique' => 3,
            'JavaScript' => 3,
            'PIE' => 1,
            'CTN' => 1,
            'metier et formation' => 1,
            'anglais' => 1,
            'francais' => 2,
            'arabe' => 1,
            'security' => 1,
            'base de donne' => 2
        ];
        foreach ($modules as $m => $c) {
            $defaultGrades[] = ['module' => $m, 'note' => 0, 'coeff' => $c];
        }
    }

    $gradesJson = json_encode($defaultGrades);

    $stmt = $db->prepare("INSERT INTO students (id, fullname, email, password, year, filiere, grades, profile_image) VALUES (?, ?, ?, ?, '1ère année', ?, ?, ?)");
    $stmt->execute([
        $id,
        htmlspecialchars($fullname),
        $email,
        $hashedPassword,
        $filiere,
        $gradesJson,
        $profile_image
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Registration successful! Please login.']);
    exit;

} elseif ($action === 'login') {
    $username = trim($input['username'] ?? '');
    $password = $input['password'] ?? '';
    $userType = $input['user_type'] ?? 'Student'; // Default to student

    $table = ($userType === 'Admin') ? 'admins' : 'students';

    $stmt = $db->prepare("SELECT * FROM $table WHERE email = ? OR fullname = ?");
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);

        if ($userType === 'Admin') {
            $user['role'] = $user['role'] ?? 'Admin';
        } else {
            $user['role'] = 'Student';
            $user['grades'] = json_decode($user['grades'], true);
        }

        unset($user['password']);
        $_SESSION['user'] = $user;

        $redirect = ($userType === 'Admin') ? 'admin_page.php' : 'user_page.php';
        echo json_encode(['status' => 'success', 'message' => 'Login successful', 'redirect' => $redirect]);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Invalid credentials.']);
    exit;

} elseif ($action === 'forgot_password') {
    $email = trim($input['email'] ?? '');

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Veuillez entrer une adresse email valide.']);
        exit;
    }

    // Check if email exists in students (students can reset; admins would need separate flow)
    $stmt = $db->prepare("SELECT id FROM students WHERE email = ?");
    $stmt->execute([$email]);
    if (!$stmt->fetch()) {
        // Don't reveal if email exists - same message for security
        echo json_encode(['status' => 'success', 'message' => 'Si cet email est enregistré, vous recevrez un lien de réinitialisation.']);
        exit;
    }

    // Delete any existing tokens for this email
    $stmt = $db->prepare("DELETE FROM password_reset_tokens WHERE email = ?");
    $stmt->execute([$email]);

    $token = bin2hex(random_bytes(32));
    $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

    $stmt = $db->prepare("INSERT INTO password_reset_tokens (email, token, expires_at) VALUES (?, ?, ?)");
    $stmt->execute([$email, $token, $expiresAt]);

    $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . ($_SERVER['HTTP_HOST'] ?? 'localhost');
    $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME'] ?? '', 3), '/');
    $resetLink = $baseUrl . $basePath . '/pages/reset_password.php?token=' . $token;

    require_once __DIR__ . '/mail_helper.php';
    if (sendPasswordResetEmail($email, $resetLink)) {
        echo json_encode(['status' => 'success', 'message' => 'Un email de réinitialisation a été envoyé à votre adresse.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Impossible d\'envoyer l\'email. Vérifiez la configuration du serveur.']);
    }
    exit;

} elseif ($action === 'reset_password') {
    $token = trim($input['token'] ?? '');
    $newPassword = $input['password'] ?? '';

    if (empty($token) || empty($newPassword)) {
        echo json_encode(['status' => 'error', 'message' => 'Token ou mot de passe manquant.']);
        exit;
    }

    if (strlen($newPassword) < 8) {
        echo json_encode(['status' => 'error', 'message' => 'Le mot de passe doit contenir au moins 8 caractères.']);
        exit;
    }

    $stmt = $db->prepare("SELECT email FROM password_reset_tokens WHERE token = ? AND expires_at > NOW()");
    $stmt->execute([$token]);
    $row = $stmt->fetch();

    if (!$row) {
        echo json_encode(['status' => 'error', 'message' => 'Lien invalide ou expiré. Demandez une nouvelle réinitialisation.']);
        exit;
    }

    $email = $row['email'];
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $stmt = $db->prepare("UPDATE students SET password = ? WHERE email = ?");
    $stmt->execute([$hashedPassword, $email]);

    $stmt = $db->prepare("DELETE FROM password_reset_tokens WHERE token = ?");
    $stmt->execute([$token]);

    echo json_encode(['status' => 'success', 'message' => 'Mot de passe mis à jour. Vous pouvez vous connecter.', 'redirect' => 'inscrire.php']);
    exit;

} elseif ($action === 'logout') {
    // Unset all session values
    $_SESSION = [];

    // Destroy session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        header('Location: ../../pages/inscrire.php');
        exit;
    }

    echo json_encode(['status' => 'success', 'message' => 'Logged out', 'redirect' => 'inscrire.php']);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
?>