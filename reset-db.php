<?php

$mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking2');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Drop all tables to start fresh
echo "Dropping all existing tables..." . PHP_EOL;
$mysqli->query("DROP TABLE IF EXISTS migrations");
$mysqli->query("DROP TABLE IF EXISTS transactions");
$mysqli->query("DROP TABLE IF EXISTS accounts");
$mysqli->query("DROP TABLE IF EXISTS password_reset_tokens");
$mysqli->query("DROP TABLE IF EXISTS sessions");
$mysqli->query("DROP TABLE IF EXISTS cache_locks");
$mysqli->query("DROP TABLE IF EXISTS cache");
$mysqli->query("DROP TABLE IF EXISTS jobs");
$mysqli->query("DROP TABLE IF EXISTS users");

echo "✓ All tables dropped" . PHP_EOL;

$mysqli->close();
?>
