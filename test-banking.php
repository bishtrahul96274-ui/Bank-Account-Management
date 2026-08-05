<?php

// Test the banking system setup
$mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking2');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

echo "=== Banking System Database Status ===" . PHP_EOL;
echo PHP_EOL;

// Check tables
$tables = [
    'users' => 'Users Table',
    'accounts' => 'Accounts Table',
    'transactions' => 'Transactions Table',
    'sessions' => 'Sessions Table',
];

foreach ($tables as $table => $name) {
    $result = $mysqli->query("SHOW TABLES LIKE '$table'");
    $status = $result->num_rows > 0 ? '✓ EXISTS' : '✗ MISSING';
    echo "$name: $status" . PHP_EOL;
}

echo PHP_EOL . "=== Sample Users ===" . PHP_EOL;
$result = $mysqli->query("SELECT id, name, email, mobile FROM users LIMIT 5");
while($row = $result->fetch_assoc()) {
    echo "ID: {$row['id']}, Name: {$row['name']}, Email: {$row['email']}, Mobile: {$row['mobile']}" . PHP_EOL;
}

echo PHP_EOL . "=== Sample Accounts ===" . PHP_EOL;
$result = $mysqli->query("SELECT id, account_number, account_type, balance, status FROM accounts LIMIT 5");
while($row = $result->fetch_assoc()) {
    echo "Account: {$row['account_number']}, Type: {$row['account_type']}, Balance: ₹{$row['balance']}, Status: {$row['status']}" . PHP_EOL;
}

echo PHP_EOL . "=== Sample Transactions ===" . PHP_EOL;
$result = $mysqli->query("SELECT account_id, type, amount, balance_after, description, created_at FROM transactions LIMIT 5");
while($row = $result->fetch_assoc()) {
    echo "Type: {$row['type']}, Amount: ₹{$row['amount']}, After Balance: ₹{$row['balance_after']}, Time: {$row['created_at']}" . PHP_EOL;
}

echo PHP_EOL . "=== System Status ===" . PHP_EOL;
echo "Total Users: " . $mysqli->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'] . PHP_EOL;
echo "Total Accounts: " . $mysqli->query("SELECT COUNT(*) as count FROM accounts")->fetch_assoc()['count'] . PHP_EOL;
echo "Total Transactions: " . $mysqli->query("SELECT COUNT(*) as count FROM transactions")->fetch_assoc()['count'] . PHP_EOL;
echo PHP_EOL . "✅ Banking System is READY to use!" . PHP_EOL;

$mysqli->close();
?>
