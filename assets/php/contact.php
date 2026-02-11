session_start();
require_once 'csrf.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
http_response_code(405);
echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
exit;
http_response_code(405);
echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
exit;
}

// Get the raw POST data
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
// Fallback to standard $_POST if not JSON
$input = $_POST;
}

// CSRF Validation
$token = $input['csrf_token'] ?? '';
if (!validate_csrf_token($token)) {
http_response_code(403);
echo json_encode(['status' => 'error', 'message' => 'Invalid CSRF token.']);
exit;
}

// Basic validation
$name = $input['name'] ?? '';
$email = $input['email'] ?? '';
$phone = $input['phone'] ?? '';
$service = $input['service'] ?? '';
$message = $input['message'] ?? '';

if (empty($name) || empty($email) || empty($message)) {
http_response_code(400);
echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
exit;
}

// Save message to database
try {
$db = require_once 'db.php';
$stmt = $db->prepare("INSERT INTO messages (name, email, phone, service, message) VALUES (?, ?, ?, ?, ?)");
$stmt->execute([
htmlspecialchars($name),
filter_var($email, FILTER_SANITIZE_EMAIL),
htmlspecialchars($phone),
htmlspecialchars($service),
htmlspecialchars($message)
]);

echo json_encode(['status' => 'success', 'message' => 'Message sent successfully!']);
} catch (PDOException $e) {
http_response_code(500);
echo json_encode(['status' => 'error', 'message' => 'Failed to save message: ' . $e->getMessage()]);
}
?>