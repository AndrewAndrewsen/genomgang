<?php
    include("../db.php");
    include("User.php");

        $user = new User($pdo);
        
        if(!empty($_GET['id'])) {
            echo json_encode($user->DeleteUser($_GET['id']));

        } else {
            $error = new stdClass();
            $error->message = "id not specified";
            $error->code = "0004";
            echo json_encode($error);


        }

    ?>