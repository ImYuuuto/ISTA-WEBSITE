<?php
/**
 * db.php
 * Database connection and initialization.
 */

$db_path = __DIR__ . '/../data/users.db';

try {
    $db = new PDO('sqlite:' . $db_path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create users table if not exists
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id TEXT PRIMARY KEY,
        fullname TEXT NOT NULL,
        email TEXT UNIQUE NOT NULL,
        password TEXT NOT NULL,
        role TEXT DEFAULT 'Student',
        year TEXT,
        filiere TEXT,
        grades TEXT -- JSON string
    )");

    // Migration logic from users.json if it exists and table is empty
    $json_file = __DIR__ . '/../data/users.json';
    $count = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();

    if ($count == 0 && file_exists($json_file)) {
        $json_data = file_get_contents($json_file);
        $users = json_decode($json_data, true);

        if (!empty($users)) {
            $stmt = $db->prepare("INSERT INTO users (id, fullname, email, password, role, year, filiere, grades) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            foreach ($users as $user) {
                $stmt->execute([
                    $user['id'],
                    $user['fullname'],
                    $user['email'],
                    $user['password'],
                    $user['role'] ?? 'Student',
                    $user['year'] ?? '',
                    $user['filiere'] ?? '',
                    json_encode($user['grades'] ?? [])
                ]);
            }
        }
    }

} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

return $db;
?>