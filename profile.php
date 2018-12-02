<?php
session_start();
?>
<html>
<head>
</head>
<body>

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

$userQuery = $pdo->prepare("SELECT username, password, email_address, account_type, description FROM accounts WHERE accountID = ?");
$userQuery->execute([$_SESSION["accountID"]]);
$user = $userQuery->fetch();

echo "<h1>". $user['username'] . "</h1><br>";
echo "<h2>". $user['account_type'] . "<br>";
if ($user['account_type'] == "Player")	
	echo "Password: ". $user['password'] . "<br>";
echo "Email Address: ". $user['email_address'] . "<br><br>";
if ($user['account_type'] == "Developer")
	if ($user['description'] != null)
		echo $user['description']. "<a href=\"des_editor.php\">Edit Description</a>";
	else
		echo "<a href=\"des_editor.php\">Add Description</a>";
?>
</body>
</html>