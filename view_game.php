<?php
session_start();
?>
<html>
<head>
</head>
<body>

<?php
$_SESSION['account_type'] = "Player";
if (!isset($_GET['id']))
	echo "Select a game to view. \n <a href = \"view_games_list.php\"> View Game List. </a>";
else {
	include 'sqlcon.php';
	
	$gameQuery = $pdo->prepare("SELECT title, username AS dev, date_published, 
									GROUP_CONCAT(ge.genre ORDER BY ge.genre SEPARATOR ', ') AS listed_genre, 
									IFNULL(likeCount, 0) AS likes, IFNULL(dislikeCount, 0) AS dislikes, price, image
								FROM games g INNER JOIN accounts a ON g.devID = a.accountID
											 INNER JOIN genres ge ON g.gameID = ge.gameID
											 LEFT JOIN (SELECT gameID, COUNT(liked) AS likeCount
														 FROM rating
														 WHERE liked = 1 AND gameID = ?) l ON g.gameID = l.gameID
											 LEFT JOIN (SELECT gameID, COUNT(liked) AS dislikeCount
														 FROM rating
														 WHERE disliked = 1 AND gameID = ?) d ON g.gameID = d.gameID
								WHERE g.gameID = ?");
	$gameQuery->execute([$_GET['id'], $_GET['id'], $_GET['id']]);
	
	if ($gameQuery->rowCount() == 0)
		echo "Game not found. <a href = \"view_games_list.php\"> View Games List </a>";
	else {
		$game = $gameQuery->fetch();
		echo "<b>" .$game['title'] ."</b><br>";
		echo "<img src = \"". $game['image'] ."\" height = \"800\" width = \"800\"> <br>";
		echo "Developer: ". $game['dev'] ."<br>";
		echo "Genre: ". $game['listed_genre'] ."<br>";
		echo "Likes/Dislikes: ". $game['likes'] . "/". $game['dislikes'] ."<br>";
		echo "Price: $". $game['price'] . "<br>";
		
		if ($_SESSION['account_type'] == "Player") {
			echo "<form action = \"buy_game.php?id=". $_GET['id']. "\" method = \"post\">";
			echo "<input type = \"submit\" value = \"Buy\"></form>";
		}
	}
}
?>
</body>
</html>
	