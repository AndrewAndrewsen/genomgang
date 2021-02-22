<html>
<head>
<link href="css/main.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php

include("database.php");


class User {
    private $id;
    private $name;
    private $email;
    private $password;

    function __construct($id_IN, $name_IN, $email_IN, $password_IN) {
        $this->id = $id_IN;
        $this->name = $name_IN;
        $this->email = $email_IN;
        $this->password = $password_IN;
    }

    function getId() {
        return $this->id;
    }
    function getName() {
        return $this->name;
    }
    function getEmail() {
        return $this->email;
    }
    function getPassword() {
        return $this->password;
    }

    function getAll() {
        return array($this->id, $this->name, $this->email, $this->password);
    }
}

$users = []; 
echo "<h2>Users!</h2>";
$stm = $pdo->query("SELECT id, name, email, password FROM users");


while ($row = $stm->fetch()) {
$user = new User($row['id'], $row['name'], $row['email'], $row['password']);
   array_push($users, $user);
   
    echo '<a href="editUser.php?id='. $user->getId() .'">'. $user->getId() .' '. $user->getName() . ' ' . $user->getEmail() . ' ' . $user->getPassword() .'</a><br />';

}   

echo "<h2>Sign up!</h2>";

?>
<form method="post" action="handleSignup.php">
    <input type="text" placeholder="Insert name..." name="name" /><br />
    <input type="text" placeholder="Insert email..." name="email" /><br />
    <input type="password" placeholder="password" name="password" /><br />
    <input type="submit" value="Sign up!" />
</form>


<?php 
    session_start();
    if(isset($_SESSION['username']) && isset($_SESSION['password'])) {

        echo "<h1>Väkommen ". $_SESSION['username'] ."</h1>";
        echo '<a href="logout.php">Logga ut!</a>';
        die();
    }

?>

<h2>Login!</h2>
<form method="post" action="handleLogin.php">
    <input type="text" name="username" /><br />
    <input type="password" name="password" /><br />
    <input type="submit" value="logga in" /><br />
</form>



</body>
</html>