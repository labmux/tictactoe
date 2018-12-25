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

function gameLost($arr) {
    if(xWon($arr) || oWon($arr) || isTie($arr))
        return true;
    else
        return false;
}

session_start();

if (!empty($_POST['grid'])) {
    //verify if input is valid
    if (isValidInput($_POST['grid'])) {
        $grid = $_POST['grid'];


        //verify if game has not yet been won
        if (!gameLost($grid))
            $grid[getAiTurn($grid)] = 'o';

        //if game is won
        else {
            if (xWon($grid))
            {
                $gameover = "Game Over! X Won the game!";

                if (isset($_SESSION['player_wins']))
                    $_SESSION['game_wins'] += 1;
                else
                    $_SESSION['game_wins'] = 1;
            }
            else if (oWon($grid))
            {
                $gameover = "Game Over! O Won the game!";

                if (isset($_SESSION['player_losses']))
                    $_SESSION['game_losses'] += 1;
                else
                    $_SESSION['game_losses'] = 1;
            }
            else if (isTie($grid))
            {
                $gameover = "Game Over! It's a Draw!";

                if (isset($_SESSION['player_ties']))
                    $_SESSION['game_ties'] += 1;
                else
                    $_SESSION['game_ties'] = 1;
            }

            $total_games = $_SESSION['game_wins'] + $_SESSION['game_losses'] + $_SESSION['game_ties'];

            //clear grid
            foreach ($grid as &$value) {
                $value = "";
            }
        }

        $score = "Wins: " . $_SESSION['game_wins'] . "<br>"
        . "Losses: " . $_SESSION['game_losses'] . "<br>"
        . "Ties: " . $_SESSION['game_ties'] . "<br>"
        . "-----------------------------" . "<br>"
        ."<b>Total: </b>" . $total_games;
    }
    else {
        echo "Invalid input";
    }


}





//header("Location: tttgame.php");

echo <<<_END
<html>
<head>
    <title>Tic Tac Toe</title>
</head>

<style>
    h1 {
        text-align: center;
    }
    form {
        text-align: center;
    }
    input {
        width: 80px;
        height: 80px;
        text-align: center;
        font-size: 30px;
    }
    button {
        text-align: center;
        margin-top: 30px;
        width: 80px;
        height: 40px;
    }
    .score {
        float: right;
    }
</style>
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
    <button type="submit">Submit</button>
</form>
<h3 class="score">Score</h3>
<h4 class="score">$score</h4>
<h1>$gameover</h1>


</body>
</html>
_END;


