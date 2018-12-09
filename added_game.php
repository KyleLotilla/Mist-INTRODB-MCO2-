<?php
session_start();

include 'sqlcon.php';
include 'top_menu.php';
$gameQuery = $pdo->prepare("SELECT title, price
							FROM games
							WHERE gameID = ?");
$gameQuery->execute([$_GET['id']]);
$game = $gameQuery->fetch();
			
$transQuery = $pdo->prepare("INSERT INTO transaction (date_purchased, playerID, game_bought, amount_paid, payment_method)
								VALUES (CURDATE(), ?, ?, ?, \"Added to Library\")");
$transQuery->execute([$_SESSION['accountID'], $_GET['id'], $game['price']]);
$idQuery = $pdo->prepare("SELECT LAST_INSERT_ID() AS id");
$idQuery->execute();
$trans = $idQuery->fetch();
echo "Game Added Successful!<br>Receipt:<br><br>";
echo "Transaction ID: ". $trans['id'] ."<br>";
echo "Game Added: ". $game['title'] ."<br>";

?>
