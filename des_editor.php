<?php
session_start();
?>
<html>
<head>
</head>
<body>

<form action = "modify_des.php" method = "post">
Description: 
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

$desQuery = $pdo->prepare("SELECT description FROM accounts WHERE accountID = ?");
$desQuery->execute([$_SESSION['accountID']]);
$des = $desQuery->fetch();

echo "<input type = \"text\" size = \"100\" name = \"description\" value = \"". $des['description'] . "\"> <br>";
?>
<input type = "submit" value = "Save">
</form>
</body>
</html>