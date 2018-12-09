<?php
session_start();

include 'sqlcon.php';

$email_check = $pdo->prepare("SELECT accountID, username, password, account_type FROM accounts WHERE username = ?");
$email_check->execute([$_POST['username']]);
$user = $email_check->fetch();

if ($email_check->rowCount() == 0) {
	echo "Username not Found <br> <a href = \"login.html\"> Login <a/>";
	session_destroy();
}
else if ($user['password'] != $_POST['password']) {
	echo "Wrong Password <br> <a href = \"login.html\"> Login <a/>";
	sesssion_destroy();
}
else {
	$_SESSION['accountID'] = $user['accountID'];
	$-SESSION['account_type'] = $user['account_type'];
	echo "<a href=\"profile.php\">Hi " . $user['username'] . ". Click here to continue. </a>";
}	

?>