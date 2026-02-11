<?php
session_start();
require_once 'db.php';
require_once 'csrf.php';

header('Content-Type: application/json');

// Access Control: Admin only
if (!isset($_SESSION['user']) || !in_array($_SESSION['user']['role'], ['Admin', 'CEO'])) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access.']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input)
    $input = $_POST;

$action = $input['action'] ?? '';

if ($action === 'get_students') {
    try {
        $stmt = $db->query("SELECT id, fullname, email, filiere, year, grades, profile_image FROM students");
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Decode JSON grades for each student
        foreach ($students as &$student) {
            $student['grades'] = json_decode($student['grades'], true) ?: [];
        }

        echo json_encode(['status' => 'success', 'students' => $students]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;

} elseif ($action === 'update_grades') {
    // CSRF check for mutations
    if (!validate_csrf_token($input['csrf_token'] ?? '')) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token.']);
        exit;
    }

    $student_id = $input['student_id'] ?? '';
    $grades = $input['grades'] ?? []; // Expected to be an array of {module, note}

    if (empty($student_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Student ID is required.']);
        exit;
    }

    try {
        $stmt = $db->prepare("UPDATE students SET grades = ? WHERE id = ?");
        $stmt->execute([json_encode($grades), $student_id]);

        echo json_encode(['status' => 'success', 'message' => 'Grades updated successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;

} elseif ($action === 'delete_student') {
    // CSRF check
    if (!validate_csrf_token($input['csrf_token'] ?? '')) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token.']);
        exit;
    }

    $student_id = $input['student_id'] ?? '';
    if (empty($student_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Student ID is required.']);
        exit;
    }

    try {
        // PERMISSION CHECK: Only CEO can delete students
        if ($_SESSION['user']['role'] !== 'CEO') {
            echo json_encode(['status' => 'error', 'message' => 'Permission denied. Only CEO can delete students.']);
            exit;
        }

        // First, check for profile image to delete it
        $stmt = $db->prepare("SELECT profile_image FROM students WHERE id = ?");
        $stmt->execute([$student_id]);
        $student = $stmt->fetch();

        if ($student && !empty($student['profile_image'])) {
            $image_path = __DIR__ . '/../' . $student['profile_image'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }
        }

        // Delete the student record
        $stmt = $db->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$student_id]);

        echo json_encode(['status' => 'success', 'message' => 'Student deleted successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;

} elseif ($action === 'get_admins') {
    // Only CEO can see other admins
    if ($_SESSION['user']['role'] !== 'CEO') {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized.']);
        exit;
    }

    try {
        $stmt = $db->query("SELECT id, fullname, email, role FROM admins");
        $admins = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['status' => 'success', 'admins' => $admins]);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;

} elseif ($action === 'add_admin') {
    if ($_SESSION['user']['role'] !== 'CEO' || !validate_csrf_token($input['csrf_token'] ?? '')) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized or invalid CSRF.']);
        exit;
    }

    $fullname = trim($input['fullname'] ?? '');
    $email = trim($input['email'] ?? '');
    $password = $input['password'] ?? '';

    if (empty($fullname) || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data provided.']);
        exit;
    }

    try {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $db->prepare("INSERT INTO admins (id, fullname, email, password, role) VALUES (?, ?, ?, ?, 'Admin')");
        $stmt->execute([uniqid(), htmlspecialchars($fullname), $email, $hashed]);
        echo json_encode(['status' => 'success', 'message' => 'Admin added successfully.']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Email might already be in use.']);
    }
    exit;

} elseif ($action === 'delete_admin') {
    if ($_SESSION['user']['role'] !== 'CEO' || !validate_csrf_token($input['csrf_token'] ?? '')) {
        echo json_encode(['status' => 'error', 'message' => 'Unauthorized.']);
        exit;
    }

    $admin_id = $input['admin_id'] ?? '';
    if ($admin_id === $_SESSION['user']['id']) {
        echo json_encode(['status' => 'error', 'message' => 'You cannot delete yourself.']);
        exit;
    }

    try {
        $stmt = $db->prepare("DELETE FROM admins WHERE id = ?");
        $stmt->execute([$admin_id]);
        echo json_encode(['status' => 'success', 'message' => 'Admin deleted.']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action.']);
?>