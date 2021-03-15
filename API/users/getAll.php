<?php
    include("../db.php");
    include("User.php");

    $user = new User($pdo);
    $users = $user->GetAllUsers();
    print_r(json_encode($users));


?>