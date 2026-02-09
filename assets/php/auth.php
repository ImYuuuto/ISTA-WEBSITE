<?php
require_once 'security_headers.php'; // Include security headers
session_start();
header('Content-Type: application/json');

require_once 'csrf.php';
$db = require_once 'db.php';

// Get input
$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = $_POST;
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

    // Check if email exists
    $stmt = $db->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        echo json_encode(['status' => 'error', 'message' => 'Email already registered.']);
        exit;
    }

    // Add new user
    $id = uniqid();
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $defaultGrades = json_encode([
        ['module' => 'HTML & CSS', 'note' => 17.5],
        ['module' => 'Python', 'note' => 16.0],
        ['module' => 'MySQL', 'note' => 18.0],
        ['module' => 'PHP', 'note' => 15.5],
        ['module' => 'JavaScript', 'note' => 16.5],
        ['module' => 'Anglais Technique', 'note' => 17.0]
    ]);

    $stmt = $db->prepare("INSERT INTO users (id, fullname, email, password, role, year, filiere, grades) VALUES (?, ?, ?, ?, 'Student', '1ère année', 'Développement Digital', ?)");
    $stmt->execute([
        $id,
        htmlspecialchars($fullname),
        filter_var($email, FILTER_SANITIZE_EMAIL),
        $hashedPassword,
        $defaultGrades
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Registration successful! Please login.']);
    exit;

} elseif ($action === 'login') {
    $username = trim($input['username'] ?? ''); // Can be email or name
    $password = $input['password'] ?? '';

    $stmt = $db->prepare("SELECT * FROM users WHERE email = ? OR fullname = ?");
    $stmt->execute([$username, $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Security: Regenerate session ID
        session_regenerate_id(true);

        // Decode grades for session
        $user['grades'] = json_decode($user['grades'], true);

        // Remove password from session
        unset($user['password']);

        $_SESSION['user'] = $user;
        echo json_encode(['status' => 'success', 'message' => 'Login successful', 'redirect' => 'user_page.php']);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Invalid credentials.']);
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
    echo json_encode(['status' => 'success', 'message' => 'Logged out', 'redirect' => 'inscrire.html']);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
?>