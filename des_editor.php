<?php
session_start();
?>
<html>
<head>
</head>
<body>

<form action = "modify_des.php" method = "post">
Description: 
<?php
include 'sqlcon.php';

$desQuery = $pdo->prepare("SELECT description FROM accounts WHERE accountID = ?");
$desQuery->execute([$_SESSION['accountID']]);
$des = $desQuery->fetch();

echo "<input type = \"text\" size = \"100\" name = \"description\" value = \"". $des['description'] . "\"> <br>";
?>
<input type = "submit" value = "Save">
</form>
</body>
</html>