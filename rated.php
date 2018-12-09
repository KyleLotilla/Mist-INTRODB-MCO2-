<?php
session_start();
include 'sqlcon.php';

if ($_POST['rating'] == "Like")
	$likedFlag = 1;
else if ($_POST['rating'] == "Dislike")
	$likedFlag = 0;

$ratingQuery = $pdo->prepare("INSERT INTO rating(accountID, gameID, liked) VALUES (?, ?, ?)");
$ratingQuery->execute([$_SESSION['accountID'], $_GET['id'], $likedFlag]);

if ($likedFlag)
	echo "Liked<br>";
else
	echo "Disliked<br>";

echo "<a href = \"view_game.php?id=". $_GET['id'] ."\"> Go Back  </a>";
?>

