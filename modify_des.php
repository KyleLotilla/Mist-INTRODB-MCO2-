<?php
session_start();

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

$modifyQuery = $pdo->prepare("UPDATE accounts SET description = ? WHERE accountID = ?");
$modifyQuery->execute([$_POST['description'], $_SESSION['accountID']]);

echo "<a href = \"profile.php\">Description Saved. Go back to Profile</a>";

?>