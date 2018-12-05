<?php
session_start();

include 'sqlcon.php';

if (strlen($_POST['title'] > 32) ||  strlen($_POST['title'] < 3)
	echo "Title must between 3 to 32 characters long <br> <a href = \"publish_game.php\"> Go Back to Publish </a>";
else if (strlen($_POST['title'] > 255)
	echo "Description must equal or less than 255 characters <br> <a href = \"publish_game.php\"> Go Back to Publish </a>";
else if ($_POST['price'] == "paid" && $_POST['price_paid'] <= 0)
	echo "Set price must greater than 0. <br> <a href = \"publish_game.php\"> Go Back to Publish </a>";
else if (!isset($_POST['genre']))
	echo "Select at least one genre. <br> <a href = \"publish_game.php\"> Go Back to Publish </a>";
else if (!isset($_POST['genre']

?>