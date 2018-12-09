<?php
session_start();
?>
<html>
<head>
</head>
<body>

<?php
include 'sqlcon.php';

$transQuery = $pdo->prepare("
SELECT DATE_FORMAT(date_purchased, '%b %e, %Y') AS formatted_date, title, amount_paid,
					IFNULL(CONCAT(payment_method, \" ending with \", SUBSTR(credit_number, 18)), payment_method) AS formatted_payment_method
FROM transaction t INNER JOIN games g ON t.game_bought = g.gameID
				   INNER JOIN accounts a ON t.playerID = a.accountID
WHERE t.playerID = ?");
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
			echo "<td>$". $t['amount_paid'] . "</td>";
		echo "<td> ". $t['formatted_payment_method']. "</td>";
		echo "</tr>";
	}
	echo "</table>";
}
?>
</body>
</html>
