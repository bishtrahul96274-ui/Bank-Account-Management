<?php

$mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking2');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

echo "=== Tables in banking2 database ===" . PHP_EOL;
$result = $mysqli->query("SHOW TABLES");
while($row = $result->fetch_row()) {
    echo "- " . $row[0] . PHP_EOL;
}

$mysqli->close();
?>
