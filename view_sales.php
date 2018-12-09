<?php
session_start();
?>
<html>
<head>
</head>
<body>

<?php
include 'sqlcon.php';

$salesQuery = $pdo->prepare("
SELECT title, SUM(amount_paid) AS sales
FROM games g INNER JOIN transaction t ON  g.gameID = t.game_bought
			 INNER JOIN accounts a ON g.devID = a.accountID
WHERE devID = ?
GROUP BY gameID");
$salesQuery->execute([$_SESSION['accountID']]);

if ($salesQuery->rowCount() == 0)
	echo "Publish a Game First.";
else {
	$sales = $salesQuery->fetchall();
	echo "<table>
		  <tr>
			 <th> Game </th>
			 <th> Sales </th>
		  </tr>";
	
	foreach($sales AS $s) {
		echo "<td>". $s['title'], "</td>";
		echo "<td>$". $s['sales'] . "</td>";
		echo "</tr>";
	}
	echo "</table>";
}
?>
</body>
</html>
