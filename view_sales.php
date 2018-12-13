<?php
session_start();
?>
<html>
<head>
</head>
<body>

<?php
include 'sqlcon.php';

if (!isset($_GET['sort']) || !isset($_GET['order']) || !isset($_GET['filter'])) {
	$_GET['sort'] = "title";
	$_GET['order'] = "ASC";
	$_GET['filter'] = "month";
}

$initialQuery = "
SELECT title, SUM(amount_paid) AS sales
FROM games g INNER JOIN transaction t ON  g.gameID = t.game_bought
			 INNER JOIN accounts a ON g.devID = a.accountID
WHERE devID = ? AND amount_paid > 0.0 ";

if ($_GET['filter'] == "month")
	$timeFilter = "AND DATEDIFF(CURDATE(), date_purchased) < 30";
else if ($_GET['filter'] == "year")
	$timeFilter = "AND DATEDIFF(CURDATE(), date_purchased) < 356";
else
	$timeFilter = "";

$salesQuery = $pdo->prepare($initialQuery.$timeFilter." GROUP BY gameID ORDER BY ". $_GET['sort'] ." ". $_GET['order']);
$salesQuery->execute([$_SESSION['accountID']]);

if ($salesQuery->rowCount() == 0)
	echo "No Sales Found";
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
		echo "<b> Title </b> | <a href = \"view_sales.php?sort=sales&order=DESC&filter=". $_GET['filter'] ."\"> Sales </a> <br>";
	else if ($_GET['sort'] == "sales")
		echo "<a href = \"view_sales.php?sort=title&order=ASC&filter=". $_GET['filter'] ."\"> Title </a> | <b> Sales </b> <br>";
	
	echo "Filter: ";
	if ($_GET['filter'] == "month")
		echo "<b> Last Month </b> | <a href = \"view_sales.php?sort=". $_GET['sort'] ."&order=". $_GET['order'] ."&filter=year\"> Last Year </a> | <a href = \"view_sales.php?sort=". $_GET['sort'] ."&order=". $_GET['order'] ."&filter=lifetime\"> Lifetime </a>";
	else if ($_GET['filter'] == "year")
		echo "<a href = \"view_sales.php?sort=". $_GET['sort'] ."&order=". $_GET['order'] ."&filter=month\"> Last Month </a> | <b> Last Year </b> | <a href = \"view_sales.php?sort=". $_GET['sort'] ."&order=". $_GET['order'] ."&filter=lifetime\"> Lifetime </a>";
	else
		echo "<a href = \"view_sales.php?sort=". $_GET['sort'] ."&order=". $_GET['order'] ."&filter=month\"> Last Month </a> | <a href = \"view_sales.php?sort=". $_GET['sort'] ."&order=". $_GET['order'] ."&filter=year\"> Last Year </a> | <b> Lifetime </b>";
}
?>
</body>
</html>
