<?php

if(isset($_POST['yes']))
    header("Location: tictactoe.php");

else if(isset($_POST['no']))
        header("Location: goodbye.php");

?>

<html>
<head>

</head>

<body>
<h1>Welcome to Tic Tac Toe</h1>
<h3>Would you like to play a game?</h3>
<form action="index.php" method="post">
    <input type="submit" name="yes" value="Yes">
    <input type="submit" name="no" value="No">
</form>
</body>
</html>