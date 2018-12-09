<?php
echo "<a href = \"profile.php\"> <b> Profile </b> </a> &#8195 &#8195 &#8195";
echo "<a href = \"view_games_list.php\"> <b> View Games </b> </a> &#8195 &#8195 &#8195";
if ($_SESSION['account_type'] == "Player")
	echo "<a href = \"purchase_transactions.php\"> <b> Purchases </b> </a> &#8195 &#8195 &#8195";
else if ($_SESSION['account_type'] == "Developer") {
	echo "<a href = \"publish_game.php\"> <b> Publish </b> </a> &#8195 &#8195 &#8195";
	echo "<a href = \"view_sales.php\"> <b> Sales </b> </a> &#8195 &#8195 &#8195";
}
echo "<a href = \"logout.php\"> <b> Logout </b> </a> <br>";
?>