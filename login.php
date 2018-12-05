<?php
session_start();

include 'sqlcon.php';

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