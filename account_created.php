<?php

if (strlen($_POST['username']) < 3)
	echo "Username must be between 3 to 32 characters.<br><a href = \"register.html\"> Go Back </a>";
else if (strlen($_POST['password']) < 3)
	echo "Password must be between 3 to 32 characters.<br><a href = \"register.html\"> Go Back </a>";
else if ($_POST['password'] != $_POST['confirm_password'])
	echo "Password and Confirm Password did not match<br><a href = \"register.html\"> Go Back </a>";
else if (!preg_match("/\d/", $_POST['password']))
	echo "Password must contain at least one number<br><a href = \"register.html\"> Go Back </a>";
else if (!preg_match("/[A-Z]/", $_POST['password']))
	echo "Password must contain at least one uppercase letter<br><a href = \"register.html\"> Go Back </a>";
else if (!preg_match("/[a-z]/", $_POST['password']))
	echo "Password must contain at least one lowercase letter<br><a href = \"register.html\"> Go Back </a>";
else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
	echo "Enter a valid email. <br> <a href = \"register.html\"> Go Back </a>";
else {
	include 'sqlcon.php';
	$usernameValidationQuery = $pdo->prepare("SELECT username 
											  FROM accounts
											  WHERE username = ?");
	$usernameValidationQuery->execute([$_POST['username']]);
	if ($usernameValidationQuery->rowCount() > 0)
		echo "Username taken. <br> <a href = \"register.html\"> Go Back </a>";
	else {
		$emailValidationQuery = $pdo->prepare("SELECT account_type 
										       FROM accounts
										       WHERE email = ?");
		$emailValidationQuery->execute([$_POST['email']]);
		$foundEmails = $emailValidationQuery->fetchall();
		$validEmailFlag = 1;
		foreach($foundEmails AS $e)
			if (strtoupper($e['account_type']) == strtoupper($_POST['account_type']))
				$validEmailFlag = 0;
			
		if (!$validEmailFlag)
			echo "Emails can only have one Player account and one Developer account. <a href = \"register.html\"> Go Back </a>";
		else {
			$create_account = $pdo->prepare('INSERT INTO accounts (username, password, email, account_type) 
									 VALUES (?, ?, ?, ?)');
			$create_account->execute([$_POST['username'], $_POST['password'], $_POST['email'], $_POST['account_type']]);
			echo "<a href=\"login.html\"> Account Created. Continue to Login </a>";
		}
	}
}
?>
