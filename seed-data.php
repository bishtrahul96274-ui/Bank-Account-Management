<?php

$mysqli = new mysqli('127.0.0.1', 'root', '1234', 'banking2');

if ($mysqli->connect_error) {
    die('Connection failed: ' . $mysqli->connect_error);
}

// Insert test user
$sql = "INSERT INTO users (name, email, mobile, password, created_at, updated_at) 
        VALUES ('Rahul Kumar', 'rahul@example.com', '9876543210', '" . password_hash('password123', PASSWORD_BCRYPT) . "', NOW(), NOW())";
$mysqli->query($sql);
$user_id = $mysqli->insert_id;
echo "✓ User created (ID: $user_id)" . PHP_EOL;

// Insert test account
$sql = "INSERT INTO accounts (user_id, account_number, account_type, balance, status, pin, created_at, updated_at)
        VALUES ($user_id, 'ACC00000101', 'savings', 50000, 'active', '" . password_hash('1234', PASSWORD_BCRYPT) . "', NOW(), NOW())";
$mysqli->query($sql);
$account_id = $mysqli->insert_id;
echo "✓ Account created (ID: $account_id, Account #: ACC00000101)" . PHP_EOL;

// Insert transaction
$sql = "INSERT INTO transactions (account_id, type, amount, balance_before, balance_after, description, status, created_at, updated_at)
        VALUES ($account_id, 'deposit', 50000, 0, 50000, 'Account opening deposit', 'completed', NOW(), NOW())";
$mysqli->query($sql);
echo "✓ Transaction recorded" . PHP_EOL;

// Display what was stored
echo PHP_EOL . "=== Data Stored in MySQL ===" . PHP_EOL;
$result = $mysqli->query("SELECT * FROM users WHERE id = $user_id");
$user = $result->fetch_assoc();
echo "User: {$user['name']} ({$user['email']})" . PHP_EOL;

$result = $mysqli->query("SELECT * FROM accounts WHERE id = $account_id");
$account = $result->fetch_assoc();
echo "Account: {$account['account_number']} - Balance: ₹{$account['balance']}" . PHP_EOL;

$result = $mysqli->query("SELECT * FROM transactions WHERE account_id = $account_id");
echo "Transactions: " . $result->num_rows . PHP_EOL;

$mysqli->close();
echo PHP_EOL . "✅ Data successfully stored in MySQL!" . PHP_EOL;
?>
