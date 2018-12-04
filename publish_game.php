<?php
session_start();
?>
<html>
<head>
</head>
<body>

<form action = "published.php" method = "post">
Title: <input type = "text" name = "title"> <br>
Description: <input type = "text" name = "description"> <br>
Price: <input type = "radio" name = "price" value = "free"> Free 
<input type = "radio" name = "price" value = "paid"> <input type = "text" name = "price_set"> <br>
Genres: <br>
<input type = "checkbox" name = "genre[]" value = "multiplayer"> Multiplayer 
<input type = "checkbox" name = "genre[]" value = "singleplayer"> Single Player 
<input type = "checkbox" name = "genre[]" value = "moba"> MOBA <br>
<input type = "checkbox" name = "genre[]" value = "shooter"> Shooter 
<input type = "checkbox" name = "genre[]" value = "rpg"> RPG 
<input type = "checkbox" name = "genre[]" value = "visual_novel"> Visual Novel <br>
<input type = "checkbox" name = "genre[]" value = "platformer"> Platformer 
<input type = "checkbox" name = "genre[]" value = "strategy"> Strategy 
<input type = "checkbox" name = "genre[]" value = "puzzle"> Puzzle <br>
Image: <input type = "file" name = "img"> <br>
<input type = "submit" value = "Submit">

</body>
</html>