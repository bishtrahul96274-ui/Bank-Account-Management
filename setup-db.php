<?php

$mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking2');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Create sessions table
$sql1 = 'CREATE TABLE IF NOT EXISTS sessions (id VARCHAR(255) NOT NULL PRIMARY KEY, user_id BIGINT UNSIGNED NULL, ip_address VARCHAR(45) NULL, user_agent TEXT NULL, payload LONGTEXT NOT NULL, last_activity INT NOT NULL)';
$mysqli->query($sql1);
echo 'Sessions table created/verified' . PHP_EOL;

// Create users table
$sql2 = 'CREATE TABLE IF NOT EXISTS users (id INT PRIMARY KEY AUTO_INCREMENT, username VARCHAR(100), password VARCHAR(255))';
$mysqli->query($sql2);
echo 'Users table created/verified' . PHP_EOL;

// Insert admin user
$sql3 = "INSERT IGNORE INTO users(username, password) VALUES('admin', '12345')";
if ($mysqli->query($sql3)) {
    echo 'Admin user inserted' . PHP_EOL;
} else {
    echo 'Admin user already exists or error: ' . $mysqli->error . PHP_EOL;
}

// Select from users
$result = $mysqli->query('SELECT * FROM users');
echo 'Users in database:' . PHP_EOL;
while($row = $result->fetch_assoc()) {
    echo 'ID: ' . $row['id'] . ', Username: ' . $row['username'] . ', Password: ' . $row['password'] . PHP_EOL;
}

$mysqli->close();
?>
