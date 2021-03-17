<?php
    include("../db.php");
    include("User.php");

    $id = "";
    $username = "";
    $password = "";
    $email = "";
    $role = "";

    if(isset($_GET['id'])) {
        $id = $_GET['id'];
    } else {
        $error = new stdClass();
        $error->message = "id not specified";
        $error->code = "0004";
        echo json_encode($error);
        die();
    }

    if(isset($_GET['username'])) {
        $username = $_GET['username'];
    }

    if(isset($_GET['password'])) {
        $password = $_GET['password'];
    }

    if(isset($_GET['email'])) {
        $email = $_GET['email'];
    }

    if(isset($_GET['role'])) {
        $role = $_GET['role'];
    }

    $user = new User($pdo);
    echo json_encode($user->UpdateUser($id, $username, $password, $email, $role));