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
    else if(strcasecmp($arr[0], 'x') == 0 && strcasecmp($arr[3],'x') == 0 && strcasecmp($arr[6],'x') == 0)
        return true;
    else if(strcasecmp($arr[1], 'x') == 0 && strcasecmp($arr[4],'x') == 0 && strcasecmp($arr[7],'x') == 0)
        return true;
    else if(strcasecmp($arr[2], 'x') == 0 && strcasecmp($arr[5],'x') == 0 && strcasecmp($arr[8],'x') == 0)
        return true;

    //Diagonal
    else if(strcasecmp($arr[0], 'x') == 0 && strcasecmp($arr[4],'x') == 0 && strcasecmp($arr[8],'x') == 0)
        return true;
    else if(strcasecmp($arr[2], 'x') == 0 && strcasecmp($arr[4],'x') == 0 && strcasecmp($arr[6],'x') == 0)
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
    else if(strcasecmp($arr[0], 'o') == 0 && strcasecmp($arr[3],'o') == 0 && strcasecmp($arr[6],'o') == 0)
        return true;
    else if(strcasecmp($arr[1], 'o') == 0 && strcasecmp($arr[4],'o') == 0 && strcasecmp($arr[7],'o') == 0)
        return true;
    else if(strcasecmp($arr[2], 'o') == 0 && strcasecmp($arr[5],'o') == 0 && strcasecmp($arr[8],'o') == 0)
        return true;

    //Diagonal
    else if(strcasecmp($arr[0], 'o') == 0 && strcasecmp($arr[4],'o') == 0 && strcasecmp($arr[8],'o') == 0)
        return true;
    else if(strcasecmp($arr[2], 'o') == 0 && strcasecmp($arr[4],'o') == 0 && strcasecmp($arr[6],'o') == 0)
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

function gameOver($arr) {
    if(xWon($arr) || oWon($arr) || isTie($arr))
        return true;
    else
        return false;
}
session_start();

if(isset($_POST['quit']))
    header("Location: goodbye.php");

else if (isset($_POST['back'])) {
    header("Location: index.php");
}

else if(isset($_POST['ai']))
    $_SESSION['player'] = "ai";

else if(isset($_POST['submit'])) {

    //initializes sessions is not set
    if(!isset($_SESSION['total_games'])) {

        echo "sess";
        $_SESSION['game_wins'] = 0;
        $_SESSION['game_losses'] = 0;
        $_SESSION['game_ties'] = 0;
        $_SESSION['total_games'] = 0;
    }
    else {

        if (!empty($_POST['grid'])) {
            $grid = $_POST['grid'];

            if (!isValidInput($grid))
                echo "Invalid input";

            //verify if input is valid
            else {

                //verify if game has not yet been won
                if (!gameOver($grid)) {
                    if ($_SESSION['player'] === "ai") {
                        $grid[getAiTurn($grid)] = 'o';
                    }
                }
                //if game is over
                else if (gameOver($grid)) {
                    if (xWon($grid)) {
                        $gameover = "Game Over! X Won the game!";
                        $_SESSION['game_wins'] += 1;
                    }
                    else if (oWon($grid)) {
                        $gameover = "Game Over! O Won the game!";
                        $_SESSION['game_losses'] += 1;
                    }
                    else if (isTie($grid)) {
                        $gameover = "Game Over! It's a Draw!";
                        $_SESSION['game_ties'] += 1;
                    }

                    $total_games = $_SESSION['total_games'] = $_SESSION['game_wins'] + $_SESSION['game_losses'] + $_SESSION['game_ties'];

                    echo "<script type='text/javascript'>alert($gameover)</script>";

                    //clear grid
                    foreach ($grid as &$value) {
                        $value = "";
                    }
                }
            }
        }


    }
    $score = "Wins: " . $_SESSION['game_wins'] . "<br>"
        . "Losses: " . $_SESSION['game_losses'] . "<br>"
        . "Ties: " . $_SESSION['game_ties'] . "<br>"
        . "-----------------------------" . "<br>"
        ."<b>Total: </b>" . $_SESSION['total_games'];
}
echo <<<_END
<html>
<head>
    <title>Tic Tac Toe</title>
    
    <link rel="stylesheet" href="style.css"
</head>

<body>
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
    <input type="submit" name="submit"  value="Submit" class="ttt">
    <input type="submit" name="back" value="Go back" class="ttt">
    
</form>
<h3 class="score">Score</h3>
<h4 class="score">$score</h4>
<h1>$gameover</h1>


</body>
</html>
_END;


