<?php


class User {

    private $database_connection; 
    private $user_id;
    private $username;
    private $user_email;
    private $user_token;
    private $password;
    

    function __construct($db) {
        $this->database_connection = $db;
    }

    function CreateUser($username_IN, $user_email_IN, $user_password_IN) {
       if(!empty($username_IN) && !empty($user_email_IN) && !empty($user_password_IN)) {
        
        $sql = "SELECT id FROM users WHERE username=:username_IN OR email=:email_IN";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":username_IN", $username_IN);
        $statement->bindParam(":email_IN", $user_email_IN);
        
        if( !$statement->execute() ) {
            echo "Could not execute query!";
            die();
        }

        $num_rows = $statement->rowCount();
        if($num_rows > 0) {
            echo "The user is already registered";
            die();
        }
        
        $sql = "INSERT INTO users (username, email, password, role) VALUES(:username_IN, :email_IN, :password_IN, 'user')";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":username_IN", $username_IN);
        $statement->bindParam(":email_IN", $user_email_IN);
        $statement->bindParam(":password_IN", $user_password_IN);

        if( !$statement->execute() ) {
            echo "Could not create user!";
            die();
        }

        $this->username = $username_IN;
        $this->user_email = $user_email_IN;

        echo "Username: $this->username Email: $this->user_email";
        die();
        

        
       } else {
            $error = new stdClass();
            $error->message = "All arguments need a value!";
            $error->code = "0001";
            print_r(json_encode($error));
            die();
       }

    }

    function GetAllUsers() {
        $sql = "SELECT username, email, password FROM users";
        $statement = $this->database_connection->prepare($sql);
        $statement->execute();
        echo json_encode($statement->fetchAll());
    }

    function GetUser($user_id) {
        $sql = "SELECT id, username, email, password FROM users WHERE id=:user_id_IN";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":user_id_IN", $user_id);
        
        if( !$statement->execute() || $statement->rowCount() < 1 ) {
            $error = new stdClass();
            $error->message = "User does not exist!";
            $error->code = "0003";
            print_r(json_encode($error));
            die();
        }

        $row = $statement->fetch();

        $this->username = $row['username'];
        $this->user_email = $row['email'];
        $this->password = $row['password'];
        $this->user_id = $row['id'];
        
        print_r(json_encode($row));

    }



}
