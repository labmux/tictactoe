<!DOCTYPE html>
<html>
<head>
    <title>Tic Tac Toe</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>
<h1>Tic Tac Toe</h1>

<form action="tictactoe.php" method="post">
    <input type="text" name="grid[]"  value="<?php echo $grid[0];?>">
    <input type="text" name="grid[]" value="<?php echo $grid[1];?>">
    <input type="text" name="grid[]" value="<?php echo $grid[2] ?>">
    <br>
    <input type="text" name="grid[]" value="<?php echo $grid[3] ?>">
    <input type="text" name="grid[]" value="<?php echo $grid[4] ?>">
    <input type="text" name="grid[]" value="<?php echo $grid[5] ?>">
    <br>
    <input type="text" name="grid[]" value="<?php echo $grid[6] ?>">
    <input type="text" name="grid[]" value="<?php echo $grid[7] ?>">
    <input type="text" name="grid[]" value="<?php echo $grid[8] ?>">
    <br>
    <button type="submit">Submit</button>
    <button type="submit" name="quit">Quit</button>
</form>

<h1><?php $gameover ?></h1>
</body>
</html>