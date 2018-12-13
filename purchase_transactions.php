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
	$_GET['sort'] = "date_purchased";
	$_GET['order'] = "DESC";
}

$transQuery = $pdo->prepare("
SELECT DATE_FORMAT(date_purchased, '%b %e, %Y') AS formatted_date, title, amount_paid,
					IFNULL(CONCAT(payment_method, \" ending with \", SUBSTR(credit_number, 18)), payment_method) AS formatted_payment_method
FROM transaction t INNER JOIN games g ON t.game_bought = g.gameID
				   INNER JOIN accounts a ON t.playerID = a.accountID
WHERE t.playerID = ?
ORDER BY ". $_GET['sort'] ." ". $_GET['order']);
$transQuery->execute([$_SESSION['accountID']]);

if ($transQuery->rowCount() == 0)
	echo "No Purchases Found";
else {
	include 'top_menu.php';
	$playerTrans = $transQuery->fetchall();
	echo "<table>
		  <tr>
			 <th> Date </th>
			 <th> Game Bought </th>
		     <th> Amount Paid </th>
		  <th> Payment Method </th>
		  </tr>";
	
	foreach($playerTrans AS $t) {
		echo  "<tr> <td>". $t['formatted_date'] ."</td>";
		echo "<td>". $t['title'], "</td>";
		if ($t['amount_paid'] == 0.0)
			echo "<td>Free</td>";
		else
			echo "<td>Php ". $t['amount_paid'] . "</td>";
		echo "<td> ". $t['formatted_payment_method']. "</td>";
		echo "</tr>";
	}
	echo "</table> <br>";
	echo $transQuery->rowCount() ." Purchases Found &#8195 Sort By:";
	
	if ($_GET['sort'] == "date_purchased")
		echo "<b> Date Purchased </b> | <a href = \"purchase_transactions.php?sort=title&order=ASC\"> Game Bought </a> | <a href = \"purchase_transactions.php?sort=amount_paid&order=DESC\"> Amount Paid </a>";
	else if ($_GET['sort'] == "title")
		echo "<a href = \"purchase_transactions.php?sort=date_purchased&order=DESC\"> Date Purchased </a> | <b> Game Bought </b> | <a href = \"purchase_transactions.php?sort=amount_paid&order=DESC\"> Amount Paid </a>";
	else if ($_GET['sort'] == "amount_paid")
		echo "<a href = \"purchase_transactions.php?sort=date_purchased&order=DESC\"> Date Purchased </a>  | <a href = \"purchase_transactions.php?sort=title&order=ASC\"> Game Bought </a> | <b> Amount Paid </b>";
}
?>
</body>
</html>
