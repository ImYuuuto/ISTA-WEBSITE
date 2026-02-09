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

// Simulate sending an email (In a real app, use mail() or PHPMailer)
// For now, we just return success
// file_put_contents('messages.txt', "From: $name ($email)\nMsg: $message\n\n", FILE_APPEND);

echo json_encode(['status' => 'success', 'message' => 'Message sent successfully!']);
?>