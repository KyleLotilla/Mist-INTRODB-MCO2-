<?php
session_start();

if (!isset($_GET['id']) || !isset($_POST['payment_method']) || 
	!isset($_POST['credit_number']) || !isset($_POST['csv']) || 
	!isset($_POST['expiration_month']) || !isset($_POST['expiration_year']))
	echo "Select a game to buy.<br><a href =\"view_games_list.php\">View Game List </a>";
else {
	$correctCreditFlag = 1;
	foreach ($_POST['credit_number'] as $c)
		if (!ctype_digit($c) || strlen($c) != 4)
			$correctCreditFlag = 0;
	if (!$correctCreditFlag)
		echo "Please enter credit card number in correct format<br><a href = \"buy_game.php?id=". $_GET['id']. "\"> Go Back </a>";
	else if (!ctype_digit($_POST['csv']) || strlen($_POST['csv']) != 3)
		echo "Please enter CSV in correct format<br><a href = \"buy_game.php?id=". $_GET['id']. "\"> Go Back </a>";
	else if ((!ctype_digit($_POST['expiration_month']) || strlen($_POST['expiration_month']) != 2) ||
			 (!ctype_digit($_POST['expiration_year']) || strlen($_POST['expiration_year']) != 2) ||
			 (intval($_POST['expiration_month']) < 1 || intval($_POST['expiration_month']) > 12)) 
		echo "Please expiration date in correct format<br><a href = \"buy_game.php?id=". $_GET['id']. "\"> Go Back </a>";
	else if (intval($_POST['expiration_month']) < intval(date("m")) || 
			 intval($_POST['expiration_year']) < intval(date("y")))
		echo "Credit card has expired<br><a href = \"buy_game.php?id=". $_GET['id']. "\"> Go Back </a>";
	else {
		include 'sqlcon.php';
		$credit_number = implode("-", $_POST['credit_number']);
		$validationQuery = $pdo->prepare("SELECT * 
										 FROM valid_credit_card 
										 WHERE credit_number = ?
										 AND csv = ?
										 AND MONTH(expiration) = ?
										 AND YEAR(expiration) % 100 = ?
										 AND payment_method = ?");
		$validationQuery->execute([$credit_number, $_POST['csv'], $_POST['expiration_month'], 
								  intval($_POST['expiration_year']), $_POST['payment_method']]);
		if ($validationQuery->rowCount() == 0)
			echo "Invalid credit card details<br><a href = \"buy_game.php?id=". $_GET['id']. "\"> Go Back </a>";
		else {
			include 'top_menu.php';
			$gameQuery = $pdo->prepare("SELECT title, price
										FROM games
										WHERE gameID = ?");
			$gameQuery->execute([$_GET['id']]);
			$game = $gameQuery->fetch();
			
			$transQuery = $pdo->prepare("INSERT INTO transaction (date_purchased, playerID, game_bought, amount_paid, payment_method, credit_number)
										 VALUES (CURDATE(), ?, ?, ?, ?, ?)");
			$transQuery->execute([$_SESSION['accountID'], $_GET['id'], $game['price'], $_POST['payment_method'], $credit_number]);
			$idQuery = $pdo->prepare("SELECT LAST_INSERT_ID() AS id");
			$idQuery->execute();
			$trans = $idQuery->fetch();
			echo "Purchase Successful!<br>Receipt:<br><br>";
			echo "Transaction ID: ". $trans['id'] ."<br>";
			echo "Game Bought: ". $game['title'] ."<br>";
			echo "Amount Paid: $". $game['price'] ."<br>";
		}
	}
}
?>