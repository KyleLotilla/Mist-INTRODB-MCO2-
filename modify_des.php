<?php
session_start();

include 'sqlcon.php';

$modifyQuery = $pdo->prepare("UPDATE accounts SET description = ? WHERE accountID = ?");
$modifyQuery->execute([$_POST['description'], $_SESSION['accountID']]);

echo "<a href = \"profile.php\">Description Saved. Go back to Profile</a>";

?>