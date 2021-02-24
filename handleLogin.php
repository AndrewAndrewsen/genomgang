<?php
    $username = $_POST['username'];
    $userPassword = $_POST['password'];

    $dsn = "mysql:host=localhost;dbname=community";
    $user = "root";
    $password = "";
    
    $pdo = new PDO($dsn, $user, $password);


    $salt = "asdkmpäöl8234-23439*¨¨^?#=)€++98";
    $userPassword = md5($userPassword.$salt);

    $stm = $pdo->prepare("SELECT count(id), role FROM users WHERE email=:username_IN AND password=:password_IN");
    $stm->bindParam(":username_IN", $username);
    $stm->bindParam(":password_IN", $userPassword);
    $stm->execute();
    $return = $stm->fetch();


    if($return[0] > 0) {
       session_start();
       $_SESSION['username'] = $username;
       $_SESSION['password'] = $userPassword;
       $_SESSION['role'] = $return['role'];

       header("location:users.php");


    } else {
        echo "Fel uppgifter";
    }
    


?>