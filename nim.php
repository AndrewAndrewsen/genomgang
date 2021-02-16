<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nim</title>
</head>

<body>

    <h1>Nim!</h1>
    <?php

    $sticks = 21;
    $round = 0;

    if (isset($_POST['rounds'])) {
        $round = $_POST['rounds'];
    }
    $round++;


    if (isset($_POST['currentSticks'])) {
        $sticks = $_POST['currentSticks'];
    }

    if (isset($_POST['sticksToTake'])) {
        $sticks = $sticks - $_POST['sticksToTake'];
    }

    if (isset($_POST['playerOneName'])) {
        $playerOneName = $_POST['playerOneName'];
    } else {
        $playerOneName = "";
    }

    if (isset($_POST['playerTwoName'])) {
        $playerTwoName = $_POST['playerTwoName'];
    } else {
        $playerTwoName = "";
    }

    if ($sticks <= 0) {

        if ($round % 2 == 0) {
            echo "<h2>$playerTwoName vann!</h2>";
        } else {
            echo "<h2>$playerOneName vann!</h2>";
        }

    } else {
        echo "<h2>Sticks: $sticks</h2>";
    }

    if(!empty($playerOneName) && !empty($playerTwoName)) {

        if ($round % 2 == 0) {
            echo "<h2>$playerTwoName's tur!</h2>";
        } else {
            echo "<h2>$playerOneName's tur!</h2>";
        }

    }

?>


    <form method="post">
        <input type="text" value="<?= $playerOneName ?>" name="playerOneName" placeholder="Player one.." /><br />
        <input type="text" value="<?= $playerTwoName ?>" name="playerTwoName" placeholder="Player two.." /><br />
        <input type="range" name="sticksToTake" min="1" max="3" /><br />
        <input type="hidden" name="currentSticks" value="<?= $sticks ?>" />
        <input type="hidden" name="rounds" value="<?= $round ?>" />
        <input type="submit" value="Play" />

    </form>


</body>

</html>