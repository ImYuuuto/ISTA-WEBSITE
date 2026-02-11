<?php
session_start();
require_once 'db.php';
require_once 'csrf.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}

// CSRF check
$token = $_POST['csrf_token'] ?? '';
if (!validate_csrf_token($token)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token']);
    exit;
}

if (!isset($_FILES['profile_image'])) {
    echo json_encode(['status' => 'error', 'message' => 'No file uploaded']);
    exit;
}

$file = $_FILES['profile_image'];
$allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
$max_size = 2 * 1024 * 1024; // 2MB

if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['status' => 'error', 'message' => 'Upload error: ' . $file['error']]);
    exit;
}

if (!in_array($file['type'], $allowed_types)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only JPG, PNG, and GIF allowed.']);
    exit;
}

if ($file['size'] > $max_size) {
    echo json_encode(['status' => 'error', 'message' => 'File too large. Max size is 2MB.']);
    exit;
}

$user_id = $_SESSION['user']['id'];
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$filename = $user_id . '_' . time() . '.' . $extension;
$upload_path = '../images/profiles/' . $filename;
$absolute_path = __DIR__ . '/' . $upload_path;

if (move_uploaded_file($file['tmp_name'], $absolute_path)) {
    try {
        $stmt = $db->prepare("UPDATE users SET profile_image = ? WHERE id = ?");
        $stmt->execute([$upload_path, $user_id]);

        // Update session
        $_SESSION['user']['profile_image'] = $upload_path;

        echo json_encode(['status' => 'success', 'message' => 'Photo updated successfully', 'path' => $upload_path]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file']);
}
?>