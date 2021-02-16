<?php
    $dsn = "mysql:host=localhost;dbname=community";
    $user = "root";
    $password = "";
    
    $pdo = new PDO($dsn, $user, $password);


    if(isset($_GET['action'])) {
        $action = $_GET['action'];
    } else {
        $acion = "";
    }

    if(isset($action) && $action == "update") {
        $sql = "UPDATE users SET name=:name_IN, email=:email_IN, password=:password_IN WHERE id=:id_IN";
        $stm = $pdo->prepare($sql);
        $stm->bindParam("name_IN", $_POST['name']);
        $stm->bindParam("email_IN", $_POST['email']);
        $stm->bindParam("password_IN", $_POST['password']);
        $stm->bindParam("id_IN", $_POST['id']);
    
        if($stm->execute()) {
            
            header("location:users.php");

        } else {
            echo "Något gick fel!";
            die();
        }

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
   <?php

    $stm = $pdo->prepare("SELECT id, name, email, password FROM users WHERE id=:id_IN");
    $stm->bindParam(":id_IN", $_GET['id']);

    $success = $stm->execute();
    
    if(!$success) {
        echo "<h3>Något gick fel!</h3>";
        die();
    }

    $userData = $stm->fetch();
   ?>

    <form method="post" action="editUser.php?action=update">
        <input type="hidden" name="id" value="<?=$_GET['id']?>" />
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?=$userData['name']?>" /><br />
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?=$userData['email']?>" /><br />
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" value="<?=$userData['password']?>" /><br />
        <input type="submit" value="Update info!" />
    </form>



</body>

</html>