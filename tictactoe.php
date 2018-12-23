<?php
/**
 * Created by PhpStorm.
 * User: eliranassaraf
 * Date: 2018-12-16
 * Time: 2:28 PM
 */

/**
 * Verifies that user inputed valid input ie. X or O
 * @param $arr
 * @return bool
 */
function isValidInput($arr) {
    foreach ($arr as $value) {
        if(strcasecmp("x", $value) == 0 || strcasecmp("o", $value) == 0 || $value == "")
        {
            continue;
        }
        else
            echo "<h1>Invalid input: Must enter X or Y</h1>";
            return false;
    }
    return true;
}

function getAiTurn($arr) {
    while (true) {
        //ai turn
        $randomNum =  rand(1,9) - 1;

        if(empty($arr[$randomNum]))
            return $randomNum;
        else
            continue;
    }
}

/**
 * Returns true if the array is full
 * @param $arr
 * @return bool
 */
function fullGrid($arr) {
    foreach ($arr as $v) {
        if(empty($v)) return false;
    }
    return true;
}

function xWon ($arr) {
    //Horizontal
    if(strcasecmp($arr[0], 'x') == 0 && strcasecmp($arr[1],'x') == 0 && strcasecmp($arr[2],'x') == 0)
        return true;
    else if(strcasecmp($arr[3], 'x') == 0 && strcasecmp($arr[4],'x') == 0 && strcasecmp($arr[5],'x') == 0)
        return true;
    else if(strcasecmp($arr[6], 'x') == 0 && strcasecmp($arr[7],'x') == 0 && strcasecmp($arr[8],'x') == 0)
        return true;

    //Vertical
    if(strcasecmp($arr[0], 'x') == 0 && strcasecmp($arr[3],'x') == 0 && strcasecmp($arr[6],'x') == 0)
        return true;
    else if(strcasecmp($arr[1], 'x') == 0 && strcasecmp($arr[4],'x') == 0 && strcasecmp($arr[7],'x') == 0)
        return true;
    else if(strcasecmp($arr[2], 'x') == 0 && strcasecmp($arr[5],'x') == 0 && strcasecmp($arr[8],'x') == 0)
        return true;

    //Diagonal
    if(strcasecmp($arr[0], 'x') == 0 && strcasecmp($arr[4],'x') == 0 && strcasecmp($arr[8],'x') == 0)
        return true;
    else if(strcasecmp($arr[3], 'x') == 0 && strcasecmp($arr[4],'x') == 5 && strcasecmp($arr[6],'x') == 0)
        return true;

    //Not Equal
    else
        return false;
}

function oWon ($arr) {

    //Horizontal
    if(strcasecmp($arr[0], 'o') == 0 && strcasecmp($arr[1],'o') == 0 && strcasecmp($arr[2],'o') == 0)
        return true;
    else if(strcasecmp($arr[3], 'o') == 0 && strcasecmp($arr[4],'o') == 0 && strcasecmp($arr[5],'o') == 0)
        return true;
    else if(strcasecmp($arr[6], 'o') == 0 && strcasecmp($arr[7],'o') == 0 && strcasecmp($arr[8],'o') == 0)
        return true;

    //Vertical
    if(strcasecmp($arr[0], 'o') == 0 && strcasecmp($arr[3],'o') == 0 && strcasecmp($arr[6],'o') == 0)
        return true;
    else if(strcasecmp($arr[1], 'o') == 0 && strcasecmp($arr[4],'o') == 0 && strcasecmp($arr[7],'o') == 0)
        return true;
    else if(strcasecmp($arr[2], 'o') == 0 && strcasecmp($arr[5],'o') == 0 && strcasecmp($arr[8],'o') == 0)
        return true;

    //Diagonal
    if(strcasecmp($arr[0], 'o') == 0 && strcasecmp($arr[4],'o') == 0 && strcasecmp($arr[8],'o') == 0)
        return true;
    else if(strcasecmp($arr[3], 'o') == 0 && strcasecmp($arr[4],'o') == 5 && strcasecmp($arr[6],'o') == 0)
        return true;

    //Not Equal
    else
        return false;
}

function isTie($arr) {
    if(fullGrid($arr)) {
        if(!xWon($arr) && !oWon($arr))
            return true;
    }
    else
        return false;
}

if(!empty($_POST['grid'])) {
    session_start();

    //verify if input is valid
    if(isValidInput($_POST['grid'])) {
        $grid = $_POST['grid'];

        if(!xWon($grid) && !oWon($grid) && !isTie($grid)) {
            $grid[getAiTurn($grid)] = 'o';

        }
        else {
            if(xWon($grid))
            {
                $gameover = "Game Over! X Won the game!";

                if(isset($_SESSION['player_wins']))
                    $_SESSION['player_wins'] += 1;
                else
                    $_SESSION['player_wins'] = 1;
            }
            else if(oWon($grid))
            {
                $gameover = "Game Over! O Won the game!";

                if(isset($_SESSION['player_losses']))
                    $_SESSION['player_losses'] += 1;
                else
                    $_SESSION['player_losses'] = 1;
            }
            else if(isTie($grid))
            {
                $gameover = "Game Over! It's a Draw!";

                if(isset($_SESSION['player_ties']))
                    $_SESSION['player_ties'] += 1;
                else
                    $_SESSION['player_ties'] = 1;
            }
        }
    }
    else {
        echo "Invalid input";
    }

}
echo <<<_END
<html>
<body>

</body>
</html>
_END;


echo <<<_END
<h1>Tic Tac Toe</h1>
<form action="tictactoe.php" method="post">
    <input type="text" name="grid[]"  value="$grid[0]">
    <input type="text" name="grid[]" value="$grid[1]">
    <input type="text" name="grid[]" value="$grid[2]">
    <br>
    <input type="text" name="grid[]" value="$grid[3]">
    <input type="text" name="grid[]" value="$grid[4]">
    <input type="text" name="grid[]" value="$grid[5]">
    <br>
    <input type="text" name="grid[]" value="$grid[6]">
    <input type="text" name="grid[]" value="$grid[7]">
    <input type="text" name="grid[]" value="$grid[8]">
    <br>
    <button type="submit">Submit</button>
</form>
<h1>$gameover</h1>
_END;


