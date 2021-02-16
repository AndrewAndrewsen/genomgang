<?php
$dsn = "mysql:host=localhost;dbname=community";
$user = "root";
$password = "";

$pdo = new PDO($dsn, $user, $password);


$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];

$sql = "INSERT INTO users (name, email, password) VALUES(:name_IN, :email_IN, :password_IN)";
$stm = $pdo->prepare($sql);
$stm->bindParam(':name_IN', $name);
$stm->bindParam(':email_IN', $email);
$stm->bindParam(':password_IN', $password);

if($stm->execute()) { // <- Här kör vi queryn
    header("location:users.php");
} else {
    echo "Något gick fel!";
}

