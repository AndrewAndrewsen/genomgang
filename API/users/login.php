<?php
    include("../db.php");
    include("User.php");

    $username = $_GET['username'];
    $password = $_GET['password'];
    

    $user = new User($pdo);
    $return = new stdClass();
    $return->token = $user->Login($username, $password);
    print_r(json_encode($return));
