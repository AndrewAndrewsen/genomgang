<?php
    $username = $_POST['username'];
    $userPassword = $_POST['password'];

    include("database.php");



    $salt = "asdkmpäöl8234-23439*¨¨^?#=)€++98";
    $userPassword = md5($userPassword.$salt);

    $stm = $pdo->prepare("SELECT count(id) FROM users WHERE email=:username_IN AND password=:password_IN");
    $stm->bindParam(":username_IN", $username);
    $stm->bindParam(":password_IN", $userPassword);
    $stm->execute();
    $return = $stm->fetch();

    if($return[0] > 0) {
       session_start();
       $_SESSION['username'] = $username;
       $_SESSION['password'] = $userPassword;

       header("location:users.php");


    } else {
        echo "Fel uppgifter";
    }
    


?>