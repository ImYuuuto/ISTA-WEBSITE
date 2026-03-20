<?php
/**
 * db.php
 * Database connection using MySQL (MariaDB).
 */

$host = 'localhost';
$dbname = 'istaweb';
$username = 'root'; // User name (default for XAMPP)
$password = '';     // Password (default for XAMPP)

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

    // Set PDO to throw exceptions on error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Ensure tables exist
    $tables = $db->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    if (!in_array('students', $tables) && !in_array('admins', $tables)) {
        $sql = file_get_contents(__DIR__ . '/../sql/setup_db.sql');
        if ($sql) {
            $sql = preg_replace('/CREATE DATABASE IF NOT EXISTS `?istaweb`?;/i', '', $sql);
            $sql = preg_replace('/USE `?istaweb`?;/i', '', $sql);
            $db->exec($sql);
        }
    } else {
        // Check if profile_image column exists in students, if not add it
        if (in_array('students', $tables)) {
            $stmt = $db->query("SHOW COLUMNS FROM students LIKE 'profile_image'");
            if (!$stmt->fetch()) {
                $db->exec("ALTER TABLE students ADD COLUMN profile_image VARCHAR(255) DEFAULT NULL");
            }
        }
        // Create password_reset_tokens table if missing (for forgot password)
        if (!in_array('password_reset_tokens', $tables)) {
            $db->exec("CREATE TABLE password_reset_tokens (
                id INT AUTO_INCREMENT PRIMARY KEY,
                email VARCHAR(255) NOT NULL,
                token VARCHAR(64) NOT NULL UNIQUE,
                expires_at DATETIME NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                INDEX idx_token (token),
                INDEX idx_email (email)
            ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci");
        }
    }

} catch (PDOException $e) {
    // If connection fails because database doesn't exist, try to connect without db and create it
    if ($e->getCode() === 1049 || strpos($e->getMessage(), 'Unknown database') !== false) {
        try {
            $temp_db = new PDO("mysql:host=$host;charset=utf8mb4", $username, $password);
            $temp_db->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

            // Reconnect with dbname
            $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Initialize tables
            $sql = file_get_contents(__DIR__ . '/../sql/setup_db.sql');
            if ($sql) {
                // Remove USE statement if it causes issues with some PDO versions inside multi-query
                $sql = preg_replace('/USE `?istaweb`?;/i', '', $sql);
                $db->exec($sql);
            }
        } catch (PDOException $inner_e) {
            die("Database initialization failed: " . $inner_e->getMessage());
        }
    } else {
        die("Database connection failed: " . $e->getMessage());
    }
}

return $db;
?>