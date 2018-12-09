<?php
session_start();
?>
<html>
<head>
</head>
<body>
<?php include 'top_menu.php'; ?>
<br>
<form action = "published.php" method = "post" enctype="multipart/form-data">
Title: <input type = "text" name = "title"> <br>
Description: <input type = "text" name = "description"> <br>
Price: <input type = "radio" name = "price" value = "free" checked> Free
<input type = "radio" name = "price" value = "paid"> Set Price <input type = "text" name = "price_set"> <br>
Genres: <br>
<input type = "checkbox" name = "genre[]" value = "Multiplayer"> Multiplayer 
<input type = "checkbox" name = "genre[]" value = "Singleplayer"> Single Player 
<input type = "checkbox" name = "genre[]" value = "MOBA"> MOBA <br>
<input type = "checkbox" name = "genre[]" value = "Shooter"> Shooter 
<input type = "checkbox" name = "genre[]" value = "RPG"> RPG 
<input type = "checkbox" name = "genre[]" value = "Visual Novel"> Visual Novel <br>
<input type = "checkbox" name = "genre[]" value = "Platformer"> Platformer 
<input type = "checkbox" name = "genre[]" value = "Strategy"> Strategy 
<input type = "checkbox" name = "genre[]" value = "Puzzle"> Puzzle <br>
Image: <input type = "file" name = "img"> <br>
<input type = "submit" value = "Submit">

</body>
</html>