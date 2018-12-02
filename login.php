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

$email_check = $pdo->prepare("SELECT accountID, username, password FROM accounts WHERE email_address = ?");
$email_check->execute([$_POST["email"]]);
$user = $email_check->fetch();

if ($email_check->rowCount() == 0) {
	echo "Email not Found";
	session_destroy();
}
else if ($user['password'] != $_POST["password"]) {
	echo "Wrong Password";
	sesssion_destroy();
}
else {
	$_SESSION["accountID"] = $user['accountID'];
	echo "<a href=\"profile.php\">Hi " . $user['username'] . ". Click here to continue. </a>";
}	

?>