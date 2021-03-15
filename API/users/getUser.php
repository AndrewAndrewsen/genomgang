<?php
    include("../db.php");
    include("User.php");

    $user = new User($pdo);

    if( !empty($_GET['id'])) { 
        $userData = $user->GetUser($_GET['id']);
        print_r(json_encode($userData));
        
    } else {
        $error = new stdClass();
        $error->message = "No ID specified!";
        $error->code = "0002";
        print_r(json_encode($error));
        die();
    }
