<?php
/**
 * migrate_tables.php
 * One-time script to migrate users into separate tables.
 */
require_once 'db.php';

try {
    // 1. Create new tables if they don't exist
    $db->exec("CREATE TABLE IF NOT EXISTS students (
        id VARCHAR(50) PRIMARY KEY,
        fullname VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        year VARCHAR(50),
        filiere VARCHAR(100),
        grades JSON,
        profile_image VARCHAR(255) DEFAULT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;");

    $db->exec("CREATE TABLE IF NOT EXISTS admins (
        id VARCHAR(50) PRIMARY KEY,
        fullname VARCHAR(255) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL
    ) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;");

    // 2. Check if old 'users' table exists
    $stmt = $db->query("SHOW TABLES LIKE 'users'");
    if ($stmt->fetch()) {
        echo "Migrating data from 'users' table...<br>";

        // Migrate Students
        $stmt = $db->query("SELECT * FROM users WHERE role = 'Student'");
        while ($row = $stmt->fetch()) {
            $insert = $db->prepare("INSERT IGNORE INTO students (id, fullname, email, password, year, filiere, grades, profile_image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $insert->execute([$row['id'], $row['fullname'], $row['email'], $row['password'], $row['year'], $row['filiere'], $row['grades'], $row['profile_image']]);
        }
        echo "Students migrated.<br>";

        // Migrate Admins
        $stmt = $db->query("SELECT * FROM users WHERE role = 'Admin'");
        while ($row = $stmt->fetch()) {
            $insert = $db->prepare("INSERT IGNORE INTO admins (id, fullname, email, password) VALUES (?, ?, ?, ?)");
            $insert->execute([$row['id'], $row['fullname'], $row['email'], $row['password']]);
        }
        echo "Admins migrated.<br>";

        // 3. Drop old table
        // $db->exec("DROP TABLE users"); // Uncomment after manual verification if desired
        echo "Migration complete. You can now drop the 'users' table manually.";
    } else {
        echo "'users' table not found. Already migrated?";
    }

} catch (PDOException $e) {
    die("Migration failed: " . $e->getMessage());
}
?>