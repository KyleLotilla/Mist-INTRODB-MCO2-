<?php
session_start();
?>
<html>
<head>
</head>
<body>

<?php
include 'top_menu.php';
include 'sqlcon.php';

$userQuery = $pdo->prepare("SELECT username, LENGTH(password) AS pass_len, email, description FROM accounts WHERE accountID = ?");
$userQuery->execute([$_SESSION["accountID"]]);
$user = $userQuery->fetch();

echo "<h1>". $user['username'] . "</h1><br>";
echo "<h2>". $_SESSION['account_type'] . "</h2><br>";
echo "Password: ";

for ($i = 0; $i < $user['pass_len']; $i++)
	echo "*";
echo "<br>Email Address: ". $user['email'] . "<br><br>";

if (!isset($_GET['sort']) || !isset($_GET['order'])) {
		$_GET['sort'] = "title";
		$_GET['order'] = "ASC";
}

if ($_SESSION['account_type'] == "Player") {
	$boughtQuery = $pdo->prepare("SELECT title, DATE_FORMAT(date_purchased, '%b %e, %Y') AS formatted_date
									 FROM transaction t INNER JOIN games g ON t.game_bought = g.gameID
									 WHERE playerID = ?
									 ORDER BY ". $_GET['sort']. " " .  $_GET['order']);
	$boughtQuery->execute([$_SESSION['accountID']]);

	if ($boughtQuery->rowCount() == 0)
		echo "No Games Purchased yet.";
	else {
		$gamesBought = $boughtQuery->fetchall();
		echo "<table> <tr> 
						<th> Owned Games </th> 
						<th> Date Purchased </th>
					 </tr> ";
					 
		foreach ($gamesBought as $g) {
			echo "<tr> <td>". $g['title'] . "</td> ";
			echo "<td>". $g['formatted_date'] ."</td> </tr>";
		}
		
		echo "</table>";
		
		if ($_GET['sort'] == "title")
			echo "<b> Title </b> | <a href = \"profile.php?sort=date_purchased&order=DESC\"> Date Purchased </a> <br>";
		else if ($_GET['sort'] == "date_purchased")
			echo "<a href = \"profile.php?sort=title&order=ASC\">  Title </a> | <b> Date Purchased </b> <br>";
		echo $boughtQuery->rowCount() ." Games Returned";
	}
}

else if ($_SESSION['account_type'] == "Developer") {
	
	$publishedQuery = $pdo->prepare("SELECT title, IFNULL(CAST(likeCount / ratingCount * 100 AS unsigned), 0) AS overall_rating, 
									DATE_FORMAT(date_published, '%b %e, %Y') AS formatted_date
									 FROM games g LEFT JOIN (SELECT gameID, COUNT(liked) AS likeCount
															 FROM rating
															 WHERE liked = 1
															 GROUP BY gameID) l ON l.gameID = g.gameID
												  LEFT JOIN (SELECT gameID, COUNT(gameID) AS ratingCount
															 FROM rating
															 GROUP BY gameID) r ON r.gameID = g.gameID
									 WHERE devID = ?
									 ORDER BY ". $_GET['sort'] ." ".  $_GET['order']);
	$publishedQuery->execute([$_SESSION['accountID']]);

	if ($publishedQuery->rowCount() == 0)
		echo "No Games Published yet.";
	else {
		$gamesPublished = $publishedQuery->fetchall();
		echo "<table> <tr> 
						<th> Published Games </th> 
						<th> Rating </th>
						<th> Date Published </th>
					 </tr> ";
					 
		foreach ($gamesPublished as $g) {
			echo "<tr> <td>". $g['title'] . "</td> ";
			echo "<td> ". $g['overall_rating'] ."%</td>";
			echo "<td>". $g['formatted_date'] ."</td> </tr>";
		}
		
		echo "</table>";
		
		if ($_GET['sort'] == "title")
			echo "<b> Title </b> | <a href = \"profile.php?sort=overall_rating&order=DESC\"> Rating </a> | <a href = \"profile.php?sort=date_published&order=DESC\"> Date Published </a> <br>";
		else if ($_GET['sort'] == "overall_rating")
			echo "<a href = \"profile.php?sort=title&order=ASC\"> Title </a> | <b> Rating </b> | <a href = \"profile.php?sort=date_published&order=DESC\"> Date Published </a> <br>";
		else if ($_GET['sort'] == "date_published")
			echo "<a href = \"profile.php?sort=title&order=ASC\"> Title </a> | <a href = \"profile.php?sort=overall_rating&order=DESC\"> Rating </a> | <b> Date Published </b> <br>";
		echo $publishedQuery->rowCount() ." Games Returned";
	}
}
									 
?>
</body>
</html>