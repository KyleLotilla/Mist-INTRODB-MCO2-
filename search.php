<?php
session_start();

if (isset($_POST['title']))
	$_SESSION['title'] = $_POST['title'];
if (isset($_POST['dev']))
	$_SESSION['dev'] = $_POST['dev'];
if (isset($_POST['genre']))
	$_SESSION['genre'] = $_POST['genre'];


if (ctype_space($_SESSION['title']) || $_SESSION['title'] == '')
	$_SESSION['title'] = null;
if (ctype_space($_SESSION['dev']) || $_SESSION['dev'] == '')
	$_SESSION['dev'] = null;

if (!isset($_SESSION['title']) && !isset($_SESSION['dev']) && !isset($_SESSION['genre']))
	echo "No search parameter was entered. Please enter any search parameter.\n <a href = \"view_games_list.php\"> Go Back </a>";
else if ((strlen($_SESSION['title']) < 3 || strlen($_SESSION['title']) > 32) && isset($_SESSION['title']))
	echo "The Title should between 3 and 32 characters. \n <a href = \"view_games_list.php\"> Go Back </a>";
else if ((strlen($_SESSION['dev']) < 3 || strlen($_SESSION['dev']) > 32) && isset($_SESSION['dev']))
	echo "The Developer should between 3 and 32 characters. \n <a href = \"view_games_list.php\"> Go Back </a>"; 
else {
	include 'sqlcon.php';
	include 'top_menu.php';
	if (!isset($_GET['sort']))
		$_GET['sort'] = "title";
	if (!isset($_GET['order']))
		$_GET['order'] = "ASC";
	echo "
	<table>
	<tr>
		<th> Game </th>
		<th> Developer </th>
		<th> Rating </th>
		<th> Genre </th>
		<th> Price </th>
	</tr>";
	
	$intialQuery = "
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
	WHERE ";
	
	$addedParameterFlag = 0;
	if (isset($_SESSION['title'])) {
		$initialQuery = $intialQuery ."title LIKE \"%". $_SESSION['title']. "%\"";
		$addedParameterFlag = 1;
	}
	if (isset($_SESSION['dev'])) {
		if ($addedParameterFlag)
			$intialQuery = $intialQuery ."AND ";
		$initialQuery = $intialQuery ."dev LIKE \"%". $_SESSION['dev']. "%\"";
		$addedParameterFlag = 1;
	}
	if (isset($_SESSION['genre'])) {
		foreach($_SESSION['genre'] AS $g) {
			if ($addedParameterFlag)
				$initialQuery = $intialQuery ."AND ";
			$initialQuery = $intialQuery ."g.gameID IN (SELECT gameID FROM genres WHERE genre = \"". $g . "\")";
			$addedParameterFlag = 1;
		}
	}
	$finalQuery = $initialQuery ." GROUP BY gameID ORDER BY ". $_GET['sort'] ." ". $_GET['order'];
	$searchQuery = $pdo->prepare($finalQuery);
	$searchQuery->execute();
	$result = $searchQuery->fetchall();
	
	foreach($result as $r) {
		echo "<tr> <td> <a href = \"view_game.php?id=". $r['gameID'] ."\">". $r['title'] . "</td>";
		echo "<td>". $r['dev'] . "</td>";
		echo "<td>". $r['overall_rating'] ."%</td>";
		echo "<td>". $r['listedgenre'] ."</td>";
		echo "<td>";
		if ($r['price'] == 0)
			echo "Free</td>";
		else
			echo "Php ". $r['price'] ."</td>";
		echo "</tr>";
	}

	echo "</table>" .$searchQuery->rowCount(). " games Returned &#8195 Sort By: ";

	if ($_GET['sort'] == "title")
		echo "<b> Title </b> | <a href = \"search.php?sort=overall_rating&order=DESC\"> Rating </a> | <a href = \"search.php?sort=price&order=ASC\"> Price </a> <br>";
	else if ($_GET['sort'] == "overall_rating")
		echo "<a href = \"search.php?sort=title&order=ASC\"> Title </a> | <b> Rating </b> | <a href = \"search.php?sort=price&order=ASC\"> Price </a> <br>";
	else if ($_GET['sort'] == "price")
		echo "<a href = \"search.php?sort=title&order=ASC\"> Title </a> | <a href = \"search.php?sort=overall_rating&order=DESC\"> Rating </a> | <b> Price </b> <br>";
	echo "<a href = \"view_games_list.php\"> Go Back </a>"; 
}
	
?>
