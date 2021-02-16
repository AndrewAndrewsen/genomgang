<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

        print_r($_POST);

        $sticks = 21;
        $playerTurn = 0;
        

        if(!empty($_POST['numSticks'])) {
            $sticks = $_POST['numSticks'];
        }

        if(isset($_POST['turn'])) {
            $playerTurn = $_POST['turn'];
            $playerTurn++;
        }
       

        $sticks = $sticks - $_POST['sticksToDraw'];
    ?>

    <h2>Sticks: <?=$sticks?></h2>
    <h3>Round: <?=$playerTurn?>!</h3>

    <form method="POST" action="form.php">

        <select name="sticksToDraw">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>    
        </select>

        <input type="submit" value="Take" />

        <input type="hidden" name="numSticks" value="<?php echo $sticks; ?>" />
        
        <input type="hidden" name="turn" value="<?php echo $playerTurn; ?>" />

    </form>


</body>

</html>