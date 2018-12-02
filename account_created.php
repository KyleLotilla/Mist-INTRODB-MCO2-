
<?php

$host = '127.0.0.1';
$db = 'mistdb';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

$schema = $pdo->prepare('SELECT * FROM accounts');
$schema->execute();


$create_account = $pdo->prepare('INSERT INTO accounts (username, password, email_address, account_type) 
								 VALUES (?, ?, ?, ?)');

$create_account->execute([$_POST["username"], $_POST["password"], $_POST["email"], $_POST["account_type"]]);

echo "hi";

?>
