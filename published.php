<?php
session_start();

include 'sqlcon.php';

if (strlen($_POST['title']) < 3)
	echo "Title must between 3 to 32 characters long <br> <a href = \"publish_game.php\"> Go Back to Publish </a>";
else if (strlen($_POST['title']) > 255)
	echo "Description must equal or less than 255 characters <br> <a href = \"publish_game.php\"> Go Back to Publish </a>";
else if ($_POST['price'] == "paid" && $_POST['price_set'] <= 0)
	echo "Set price must greater than 0. <br> <a href = \"publish_game.php\"> Go Back to Publish </a>";
else if (!isset($_POST['genre']))
	echo "Select at least one genre. <br> <a href = \"publish_game.php\"> Go Back to Publish </a>";
else if (!exif_imagetype($_FILES['img']['tmp_name']))
	echo "Please upload a valid image file. <br> <a href = \"publish_game.php\"> Go Back to Publish </a>";
else if ($_FILES['img']['size'] >= 1024000)
	echo "Image files must be less than 1024KB. <br> <a href = \"publish_game.php\"> Go Back to Publish </a>";
else {
	
	if ($_POST['price'] == "free")
		$gamePrice = 0.0;
	else
		$gamePrice = $_POST['price_set'];
	
	$titleQuery = $pdo->prepare("SELECT title
							FROM games
							WHERE title = ?");
	$titleQuery->execute([$_POST['title']]);
	
	if ($titleQuery->rowCount() > 0)
		echo "Title taken <br> <a href = \"publish_game.php\"> Go Back to Publish </a>";
	else {
		include 'top_menu.php';
		$initalQuery = $pdo->prepare("INSERT INTO games (title, devID, price, date_published, description) values (?, ?, ?, curdate(), ?)");
		$initalQuery->execute([$_POST['title'], $_SESSION['accountID'], $gamePrice, $_POST['description']]);
		$idQuery = $pdo->prepare("SELECT LAST_INSERT_ID()");
		$idQuery->execute();
		$id = $idQuery->fetchColumn();
		
		$uploadedName = $_FILES['img']['name'];
		$finalFileName = $id.$uploadedName;
		$uploadDir = "GameImg/";
		$img_path = $uploadDir.$finalFileName;
		if (move_uploaded_file($_FILES['img']['tmp_name'], $img_path)) {
			$imgQuery = $pdo->prepare("UPDATE games SET image = ? WHERE gameID = ?");
			$imgQuery->execute([$img_path, $id]);
		}
		
		$genreQuery = $pdo->prepare("INSERT INTO genres (gameID, genre) VALUES (?, ?)");
		foreach ($_POST['genre'] as $g)
			$genreQuery->execute([$id, $g]);
		
		echo "Published Successful";
	}
}
?>