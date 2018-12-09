<?php
session_start();
?>
<html>
<head>
</head>
<body>

<?php

if (!isset($_GET['id']))
	echo "Select a game to buy.<br><a href =\"view_games_list.php\">View Game List </a>";
else {
	include 'sqlcon.php';
	include 'top_menu.php';
	$gameQuery = $pdo->prepare("SELECT title, price FROM games WHERE gameID = ?");
	$gameQuery->execute([$_GET['id']]);
	$game = $gameQuery->fetch();
	
	echo "<b> Buying: ". $game['title'] . "</b><br>";
	echo "Total Amount: $". $game['price'] . "<br>";
	echo "<form action = \"receipt.php?id=". $_GET['id'] ."\" method = \"post\">";
	echo "Payment Method: <br>";
	echo "<input type = \"radio\" name = \"payment_method\" value = \"Visa\" checked> Visa";
	echo "<input type = \"radio\" name = \"payment_method\" value = \"Mastercard\"> Mastercard <br>";
	echo "Credit Credit Number: <br>"; 
	echo "<input type = \"text\" name = \"credit_number[]\" maxlength = \"4\" size = \"4\"> - ";
	echo "<input type = \"text\" name = \"credit_number[]\" maxlength = \"4\" size = \"4\"> - ";
	echo "<input type = \"text\" name = \"credit_number[]\" maxlength = \"4\" size = \"4\"> - ";
	echo "<input type = \"text\" name = \"credit_number[]\" maxlength = \"4\" size = \"4\"> <br>";
	echo "CSV: <input type = \"text\" name = \"csv\" maxlength = \"3\"> <br>";
	echo "Expiration Date: <input type = \"text\" name = \"expiration_month\" placeholder = \"mm\" maxlength = \"2\">";
	echo "<input type = \"text\" name = \"expiration_year\" placeholder = \"yy\" maxlength = \"2\"> <br>";
	echo "<input type = \"submit\" value = \"Submit\"> </form>";
}
?>
</body>
</html>