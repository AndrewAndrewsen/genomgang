<?php
    include("../db.php");
    include("User.php");

    $token = "";
    if(isset($_GET['token'])) {
        $token = $_GET['token'];
    } else {
        $error = new stdClass();
        $error->message = "No token specified!";
        $error->code = "0009";
        print_r(json_encode($error));
        die();
    }

    $user = new User($pdo);

    if($user->isTokenValid($token)) {
        $users = $user->GetAllUsers();
        print_r(json_encode($users));
    
    } else {
        $error = new stdClass();
        $error->message = "Invalid token! Login to create a new token.";
        $error->code = "0010";
        print_r(json_encode($error));
    }
