<?php
require_once 'security_headers.php'; // Include security headers
session_start();
header('Content-Type: application/json');

$usersFile = '../data/users.json';

// Helper to get users
function getUsers($file)
{
    if (!file_exists($file))
        return [];
    $json = file_get_contents($file);
    return json_decode($json, true) ?? [];
}

// Helper to save users
function saveUsers($file, $users)
{
    file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));
}

// Get input
$input = json_decode(file_get_contents('php://input'), true);
if (!$input)
    $input = $_POST;

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

    $users = getUsers($usersFile);

    // Check if email exists
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            echo json_encode(['status' => 'error', 'message' => 'Email already registered.']);
            exit;
        }
    }

    // Add new user
    $newUser = [
        'id' => uniqid(),
        'fullname' => htmlspecialchars($fullname), // Sanitize name
        'email' => filter_var($email, FILTER_SANITIZE_EMAIL),
        'password' => password_hash($password, PASSWORD_DEFAULT), // Hash password
        'role' => 'Student',
        'year' => '1ère année',
        'filiere' => 'Développement Digital',
        'grades' => [
            ['module' => 'HTML & CSS', 'note' => 17.5],
            ['module' => 'Python', 'note' => 16.0],
            ['module' => 'MySQL', 'note' => 18.0],
            ['module' => 'PHP', 'note' => 15.5],
            ['module' => 'JavaScript', 'note' => 16.5],
            ['module' => 'Anglais Technique', 'note' => 17.0]
        ]
    ];

    $users[] = $newUser;
    saveUsers($usersFile, $users);

    echo json_encode(['status' => 'success', 'message' => 'Registration successful! Please login.']);
    exit;

} elseif ($action === 'login') {
    $username = trim($input['username'] ?? ''); // Can be email or name
    $password = $input['password'] ?? '';

    $users = getUsers($usersFile);

    foreach ($users as $user) {
        // Check email or name
        if ($user['email'] === $username || $user['fullname'] === $username) {
            if (password_verify($password, $user['password'])) {

                // Security: Regenerate session ID to prevent session fixation
                session_regenerate_id(true);

                $_SESSION['user'] = $user;
                echo json_encode(['status' => 'success', 'message' => 'Login successful', 'redirect' => 'user_page.php']);
                exit;
            }
        }
    }

    // Artificial delay to prevent brute-force timing attacks (optional, but good practice)
    // usleep(100000); 

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