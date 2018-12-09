<?php
session_start();
?>
<html>
<head>
</head>
<body>

<?php
include 'top_menu.php';
include 'sqlcon.php';

$userQuery = $pdo->prepare("SELECT username, LENGTH(password) AS pass_len, email, description FROM accounts WHERE accountID = ?");
$userQuery->execute([$_SESSION["accountID"]]);
$user = $userQuery->fetch();

echo "<h1>". $user['username'] . "</h1><br>";
echo "<h2>". $_SESSION['account_type'] . "<br>";
echo "Password: ";

for ($i = 0; $i < $user['pass_len']; $i++)
	echo "*";
echo "<br>Email Address: ". $user['email'] . "<br><br>";
if ($_SESSION['account_type'] == "Developer")
	if ($user['description'] != null)
		echo $user['description']. "<a href=\"des_editor.php\">Edit Description</a>";
	else
		echo "<a href=\"des_editor.php\">Add Description</a>";
?>
</body>
</html>