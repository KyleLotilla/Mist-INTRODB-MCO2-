<?php
session_start();
?>
<html>
<head>
</head>
<body>

<?php
include 'sqlcon.php';

$userQuery = $pdo->prepare("SELECT username, password, email, account_type, description FROM accounts WHERE accountID = ?");
$userQuery->execute([$_SESSION["accountID"]]);
$user = $userQuery->fetch();

echo "<h1>". $user['username'] . "</h1><br>";
echo "<h2>". $user['account_type'] . "<br>";
if ($user['account_type'] == "Player")	
	echo "Password: ". $user['password'] . "<br>";
echo "Email Address: ". $user['email'] . "<br><br>";
if ($_SESSION['account_type'] == "Developer")
	if ($user['description'] != null)
		echo $user['description']. "<a href=\"des_editor.php\">Edit Description</a>";
	else
		echo "<a href=\"des_editor.php\">Add Description</a>";
?>
</body>
</html>