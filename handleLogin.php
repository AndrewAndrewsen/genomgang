<?php
    $username = $_POST['username'];
    $userPassword = $_POST['password'];

    $dsn = "mysql:host=localhost;dbname=community";
    $user = "root";
    $password = "";
    
    $pdo = new PDO($dsn, $user, $password);

    $stm = $pdo->prepare("SELECT count(id) FROM users WHERE email=:username_IN AND password=:password_IN");
    $stm->bindParam(":username_IN", $username);
    $stm->bindParam(":password_IN", $userPassword);
    $stm->execute();
    $return = $stm->fetch();

    if($return[0] > 0) {
       session_start();
       $_SESSION['username'] = $username;
       $_SESSION['password'] = $password;

       header("location:users.php");


    } else {
        echo "Fel uppgifter";
    }
    


?>