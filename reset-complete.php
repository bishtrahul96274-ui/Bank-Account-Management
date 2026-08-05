<?php

$mysqli = new mysqli('127.0.0.1', 'root', '1234');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

echo "Dropping banking2 database..." . PHP_EOL;
$mysqli->query("DROP DATABASE IF EXISTS banking2");

echo "Creating banking2 database..." . PHP_EOL;
$mysqli->query("CREATE DATABASE banking2");
$mysqli->select_db('banking2');

echo "✓ Database reset complete" . PHP_EOL;

$mysqli->close();
?>
