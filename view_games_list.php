<?php
session_start();
?>
<html>
<head>
</head>
<body>

<table>
<tr>
	<th> Game </th>
	<th> Developer </th>
	<th> Rating </th>
	<th> Genre </th>
	<th> Price </th>
</tr>

<?php
include 'sqlcon.php';

if (!isset($_GET['sort']))
	$_GET['sort'] = "title";
if (!isset($_GET['order']))
	$_GET['order'] = "ASC";

$_SESSION['title'] = null;
$_SEESION['dev'] = null;
$_SESSION['genre'] = null;

$gameQuery = $pdo->prepare("
SELECT g.gameID, title, username AS dev, IFNULL(CAST(likeCount / ratingCount * 100 AS unsigned), 0) AS overall_rating, 
	GROUP_CONCAT(ge.genre ORDER BY ge.genre SEPARATOR ', ') AS listedgenre, price 
FROM games g INNER JOIN accounts a ON g.devID = a.accountID
			 INNER JOIN genres ge ON g.gameID = ge.gameID
			 LEFT JOIN (SELECT gameID, COUNT(liked) AS likeCount
						FROM rating
						WHERE liked = 1
						GROUP BY gameID) l ON l.gameID = g.gameID
			 LEFT JOIN (SELECT gameID, COUNT(gameID) AS ratingCount
					    FROM rating
					    GROUP BY gameID) r ON r.gameID = g.gameID
GROUP BY gameID
ORDER BY ". $_GET['sort'] ." ". $_GET['order']);


$gameQuery->execute();
$games = $gameQuery->fetchall();
foreach($games as $g) {
	echo "<tr> <td> <a href = \"view_game.php?id=". $g['gameID'] ."\">". $g['title'] . "</td>";
	echo "<td>". $g['dev'] . "</td>";
	echo "<td>". $g['overall_rating'] ."%</td>";
	echo "<td>". $g['listedgenre'] ."</td>";
	echo "<td>";
	if ($g['price'] == 0)
		echo "Free</td>";
	else
		echo "$". $g['price'] ."</td>";
	echo "</tr>";
}

echo "</table>" .$gameQuery->rowCount(). " games Returned &#8195 Sort By: ";

if ($_GET['sort'] == "title")
	echo "<b> Title </b> | <a href = \"view_games_list.php?sort=overall_rating&order=DESC\"> Rating </a> <br>";
else if ($_GET['sort'] == "overall_rating")
	echo "<a href = \"view_games_list.php?sort=title&order=ASC\"> Title </a> | <b> Rating </b> <br>";
?>

<form action = "search.php" method = "post">
Title: <input type = "text" name = "title"> <br>
Developer: <input type = "text" name = "dev"> <br>
Genres: <br>
<input type = "checkbox" name = "genre[]" value = "Multiplayer"> Multiplayer 
<input type = "checkbox" name = "genre[]" value = "Singleplayer"> Single Player 
<input type = "checkbox" name = "genre[]" value = "MOBA"> MOBA <br>
<input type = "checkbox" name = "genre[]" value = "Shooter"> Shooter 
<input type = "checkbox" name = "genre[]" value = "RPG"> RPG 
<input type = "checkbox" name = "genre[]" value = "Visual Novel"> Visual Novel <br>
<input type = "checkbox" name = "genre[]" value = "Platformer"> Platformer 
<input type = "checkbox" name = "genre[]" value = "Strategy"> Strategy 
<input type = "checkbox" name = "genre[]" value = "Puzzle"> Puzzle <br>
<input type = "submit" value = "Search">
</form>
</body>
</html>