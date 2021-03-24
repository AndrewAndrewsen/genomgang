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
        return $statement->fetchAll();
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
        
        return $row;

    }

    function DeleteUser($user_id) {
        $sql = "DELETE FROM users WHERE id=:user_id_IN";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":user_id_IN", $user_id);
        $statement->execute();

        $message = new stdClass();
        if($statement->rowCount() > 0) {
            $message->text = "User with id $user_id removed!";
            return $message;
        }

        $message->text = "No user with id=$user_id was found!";
        return $message;

    }

    function UpdateUser($id, $username = "", $password = "", $email = "", $role = "") {
        $error = new stdClass();

        if(!empty($username)) {
            $error->message = $this->UpdateUsername($id, $username);
        }
        if(!empty($password)) {
            $error->message = $this->UpdatePassword($id, $password);
        }
        if(!empty($email)) {
            $error->message = $this->UpdateEmail($id, $email);
        }
        if(!empty($role)) {
            $error->message = $this->UpdateRole($id, $role);
        }
        
       return $error;

    }

    function UpdateUsername($id, $username) {
        $sql = "UPDATE users SET username=:username_IN WHERE id=:user_id_IN";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":username_IN", $username);
        $statement->bindParam(":user_id_IN", $id);
        $statement->execute();

       
        if($statement->rowCount() < 1) {
            return "No user with id=$id was found!";
            
        }
    }
    function UpdatePassword($id, $password) {
        $sql = "UPDATE users SET password=:password_IN WHERE id=:user_id_IN";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":password_IN", $password);
        $statement->bindParam(":user_id_IN", $id);
        $statement->execute();

        if($statement->rowCount() < 1) {
            return "No user with id=$id was found!";
        }
    }
    function UpdateEmail($id, $email) {
        $sql = "UPDATE users SET email=:email_IN WHERE id=:user_id_IN";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":email_IN", $email);
        $statement->bindParam(":user_id_IN", $id);
        $statement->execute();

        if($statement->rowCount() < 1) {
            return "No user with id=$id was found!";
        }
    }
    function UpdateRole($id, $role) {
        $sql = "UPDATE users SET role=:role_IN WHERE id=:user_id_IN";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":role_IN", $role);
        $statement->bindParam(":user_id_IN", $id);
        $statement->execute();


        if($statement->rowCount() < 1) {
            return "No user with id=$id was found!";
        }
    }

    function Login($username_IN, $password_IN) {
        $sql = "SELECT id, username, email, role FROM users WHERE username=:username_IN AND password=:password_IN";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":username_IN", $username_IN);
        $statement->bindParam(":password_IN", $password_IN);

        $statement->execute();

        if($statement->rowCount() == 1) {// Om användaren skrivit rätt username & password
            $row = $statement->fetch();
            return $this->CreateToken($row['id'], $row['username']);


        }

    }

    function CreateToken($id, $username) {

        $checked_token = $this->CheckToken($id);

        if($checked_token != false) {
            return $checked_token;
        }

        $token = md5(time() . $id . $username);
        
        $sql = "INSERT INTO sessions (user_id, token, last_used) VALUES(:user_id_IN, :token_IN, :last_used_IN)";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":user_id_IN", $id);
        $statement->bindParam(":token_IN", $token);
        $time = time();
        $statement->bindParam(":last_used_IN", $time);

        $statement->execute();

        return $token;
        
    }

    function CheckToken($id) {
        $sql = "SELECT token, last_used FROM sessions WHERE user_id=:user_id_IN AND last_used > :active_time_IN LIMIT 1";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":user_id_IN", $id);
        $active_time = time() - (60*60);

        $statement->bindParam(":active_time_IN", $active_time);

        
        $statement->execute();
        
        $return = $statement->fetch();

        if(isset($return['token'])) {
            return $return['token'];
        } else {
            return false;
        }

    }

    function isTokenValid($token) {
        $sql = "SELECT token, last_used FROM sessions WHERE token=:token_IN AND last_used > :active_time_IN LIMIT 1";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":token_IN", $token);
        $active_time = time() - (60*60);

        $statement->bindParam(":active_time_IN", $active_time);

        
        $statement->execute();
        
        $return = $statement->fetch();

        if(isset($return['token'])) {

            $this->UpdateToken($return['token']);

            return true;
            
        } else {
            return false;
        }
    }

    function UpdateToken($token) {
        $sql = "UPDATE sessions SET last_used=:last_used_IN WHERE token=:token_IN";
        $statement = $this->database_connection->prepare($sql);
        $time = time();
        $statement->bindParam(":last_used_IN", $time);
        $statement->bindParam(":token_IN", $token);
        $statement->execute();
    }

   
}
