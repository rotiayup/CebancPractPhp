<?php
include 'db.php';

try {
    // SQL to drop the users table if it exists
    $dropTableSQL = "DROP TABLE IF EXISTS users";
    $conn->exec($dropTableSQL);
    echo "Table users dropped successfully.<br>";

    // SQL to create the users table
    $createTableSQL = "
    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $conn->exec($createTableSQL);
    echo "Table users created successfully.<br>";
    header("Location: pag_princ.php"); // Redirect to menu.php after success
    exit; // Stop script execution after redirect
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
