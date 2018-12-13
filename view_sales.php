<?php
session_start();
?>
<html>
<head>
</head>
<body>

<?php
include 'sqlcon.php';

if (!isset($_GET['sort']) || !isset($_GET['order'])) {
	$_GET['sort'] = "title";
	$_GET['order'] = "ASC";
}

$salesQuery = $pdo->prepare("
SELECT title, SUM(amount_paid) AS sales
FROM games g INNER JOIN transaction t ON  g.gameID = t.game_bought
			 INNER JOIN accounts a ON g.devID = a.accountID
WHERE devID = ? AND amount_paid > 0.0
GROUP BY gameID
ORDER BY ". $_GET['sort'] ." ". $_GET['order']);
$salesQuery->execute([$_SESSION['accountID']]);

if ($salesQuery->rowCount() == 0)
	echo "Publish a Game with a price first";
else {
	include 'top_menu.php';
	$sales = $salesQuery->fetchall();
	echo "<table>
		  <tr>
			 <th> Game </th>
			 <th> Sales </th>
		  </tr>";
	
	foreach($sales AS $s) {
		echo "<td>". $s['title'], "</td>";
		echo "<td>Php ". $s['sales'] . "</td>";
		echo "</tr>";
	}
	echo "</table> <br>";
	echo $salesQuery->rowCount(). " Sales Returned &#8195 Sort By: ";
	
	if ($_GET['sort'] == "title")
		echo "<b> Title </b> | <a href = \"view_sales.php?sort=sales&order=DESC\"> Sales </a>";
	else if ($_GET['sort'] == "sales")
		echo "<a href = \"view_sales.php?sort=title&order=ASC\"> Title </a> | <b> Sales </b>";
}
?>
</body>
</html>
