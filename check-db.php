<?php

$mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking2');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

echo "=== Available Tables ===" . PHP_EOL;
$result = $mysqli->query("SHOW TABLES");
while($row = $result->fetch_row()) {
    echo "- " . $row[0] . PHP_EOL;
}

echo PHP_EOL . "=== Users Table Structure ===" . PHP_EOL;
$result = $mysqli->query("DESCRIBE users");
while($row = $result->fetch_assoc()) {
    echo $row['Field'] . " (" . $row['Type'] . ")" . PHP_EOL;
}

echo PHP_EOL . "=== Accounts Table Structure ===" . PHP_EOL;
$result = $mysqli->query("DESCRIBE accounts");
if($result) {
    while($row = $result->fetch_assoc()) {
        echo $row['Field'] . " (" . $row['Type'] . ")" . PHP_EOL;
    }
} else {
    echo "Table does not exist" . PHP_EOL;
}

$mysqli->close();
?>
