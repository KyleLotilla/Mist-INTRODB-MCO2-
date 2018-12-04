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

if (strlen($_POST['title'] > 32) ||  strlen($_POST['title'] < 3)
	echo "Title must between 3 to 32 characters long <br> <a href = \"publish_game.php\"> Go Back to Publish </a>";
else if (strlen($_POST['title'] > 255)
	echo "Description must equal or less than 255 characters <br> <a href = \"publish_game.php\"> Go Back to Publish </a>";
else if ($_POST['price'] == "paid" && $_POST['price_paid'] <= 0)
	echo "Set price must greater than 0. <br> <a href = \"publish_game.php\"> Go Back to Publish </a>";
else if (!isset($_POST['genre']))
	echo "Select at least one genre. <br> <a href = \"publish_game.php\"> Go Back to Publish </a>";
else if (

?>