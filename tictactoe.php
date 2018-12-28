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
function isValidInput(&$arr) {
    foreach ($arr as $key => $value) {
        if($value == "")
            continue;
        else if(strcasecmp("x", $value) == 0 || strcasecmp("o", $value) == 0)
        {
            if($_SESSION['playerstarts']) {
                echo "player starts";

                if(strcasecmp("x",$value) == 0 && $_SESSION['turn'] % 2 == 0 )
                    continue;
                else if(strcasecmp("o",$value) == 0 && $_SESSION['turn'] % 2 != 0)
                    continue;
                else {
                    $arr[$key] = "";
                    return false;
                }
            }
            else {
                echo "ai starts";
                if(strcasecmp("x",$value) == 0 && $_SESSION['turn'] % 2 != 0 )
                    continue;
                else if(strcasecmp("o",$value) == 0 && $_SESSION['turn'] % 2 == 0)
                    continue;
                else {
                    $arr[$key] = "";
                    return false;
                }
            }

        }
        else {
            echo "first else";
            $arr[$key] = "";
            return false;
        }
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

function setPlayerStarts() {
    $num = rand(0,1);

    if($num == 1) {
        return $_SESSION['playerstarts'] = true;
    }
    else {
        return $_SESSION['playerstarts'] = false;
    }
}


function getStartermsg() {
    if($_SESSION['game_type'] === "ai") {
        if($_SESSION['playerstarts'])
            return "Player starts! Player is X, AI is O";
        else
            return "AI starts! Player is X, AI is O";
    }
    else if($_SESSION['game_type'] === "human") {
        if($_SESSION['playerstarts'])
            return "Player 1 starts! Player 1 is X, and Player 2 is O";
        else
            return "Player 2 starts! Player 1 is X, and Player 2 is O";
    }
}

function incrementTurn($arr) {

    if(isset($_SESSION['turn']))
    {
        if(gameOver($arr))
            $turn = $_SESSION['turn'] =  0;

        $turn = $_SESSION['turn'] += 1;
    }
    else
        $turn = $_SESSION['turn'] = 0;

    return $turn;
}

function getTurnMsg() {
    if($_SESSION['game_type']) {
        if($_SESSION['playerstarts']) {
            if($_SESSION['turn'] % 2 == 0 )
                return "Player 1's turn (X)";
            else
                return "AI's turn";
        }
        else {
            if($_SESSION['turn'] % 2 == 0 )
                return "AI's turn (O)";
            else
                return "Player's turn (X)";
        }
    }
    else if($_SESSION['game_type'] == "human") {
        if($_SESSION['playerstarts']) {
            if($_SESSION['turn'] % 2 == 0 )
                return "Player 1's turn (X)";
            else
                return "Player 2's turn (O)";
        }
        else {
            if($_SESSION['turn'] % 2 == 0 )
                return "Player 2's turn (O)";
            else
                return "Player 1's turn (X)";
        }
    }



}

function setScore()
{
    return $score = $_SESSION['score'] = "Wins: " . $_SESSION['game_wins'] . "<br>"
        . "Losses: " . $_SESSION['game_losses'] . "<br>"
        . "Ties: " . $_SESSION['game_ties'] . "<br>"
        . "-----------------------------" . "<br>"
        ."<b>Total: </b>" . $_SESSION['total_games'];
}

function clearGrid(&$arr) {
    //clear grid
    foreach ($arr as &$value)
    {
        $value = "";
    }
}

//Start Session
session_start();

//Quit button
if(isset($_POST['quit']))
    header("Location: goodbye.php");

//Back to main menu button
else if (isset($_POST['back'])) {
    header("Location: index.php");
}

//Restart button
else if (isset($_POST['restart'])) {
    clearGrid($_POST['grid']);
    $turn = $_SESSION['turn'] = 0;
    setPlayerStarts();
    $starter = $_SESSION['starter'] = getStartermsg();
    $turnmsg = getTurnMsg();
}

//AI or Human button (start game)
else if(isset($_POST['ai']) || isset($_POST['human'])) {
    if(isset($_POST['ai']))
        $_SESSION['game_type'] = "ai";
    else
        $_SESSION['game_type'] = "human";

    //initializes sessions
    if(!isset($_SESSION['total_games'])) {
        $_SESSION['game_wins'] = 0;
        $_SESSION['game_losses'] = 0;
        $_SESSION['game_ties'] = 0;
        $_SESSION['total_games'] = 0;
    }

    $turn = $_SESSION['turn'] = 0;
    setPlayerStarts();
    $starter = $_SESSION['starter'] = getStartermsg();
    $turnmsg = getTurnMsg();
}

//Submit Button
else if(isset($_POST['submit'])) {
    if (!empty($_POST['grid'])) {
        //initialize grid
        $grid = $_POST['grid'];
        setScore();
        $turnmsg = getTurnMsg();

        if (!isValidInput($grid))
            $errormsg = "Invalid input: Must enter X or O";

        else {
           incrementTurn($grid);

            //verify that game isn't over
            if (!gameOver($grid)) {
                //if we are in the AI session, the generate AIs turn
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
                setScore($score);
                clearGrid($grid);
            }

        }
    }
}
echo <<<_END
<html>
<head>
    <title>Tic Tac Toe</title>
    
    <link rel="stylesheet" href="style.css"
</head>

<body>
<h1>Tic Tac Toe</h1>
<h1 class="gameover">$gameover</h1>

<h3>$starter</h3>
<h3>$turn</h3>
<p class="error">$errormsg</p>
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
    <input type="submit" name="submit"  value="Submit" class="gamebuttons">
    <input type="submit" name="back" value="Go back" class="gamebuttons">
    <br>
    <input type="submit" name="restart" value="Restart" class="gamebuttons">
    
</form>
<h3 class="score">Score</h3>
<h4 class="score">$score</h4>

</body>
</html>
_END;


