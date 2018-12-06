
<?php

include 'sqlcon.php';

$create_account = $pdo->prepare('INSERT INTO accounts (username, password, email, account_type) 
								 VALUES (?, ?, ?, ?)');

$create_account->execute([$_POST["username"], $_POST["password"], $_POST["email"], $_POST["account_type"]]);

echo "<a href=\"login.html\"> Account Created. Continue to Login </a>";

?>
