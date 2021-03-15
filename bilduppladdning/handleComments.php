<?php
include("db.php");
session_start();

$stm = $pdo->prepare("INSERT INTO comments (image_id, comment, user) VALUES(:image_id_IN, :comment_IN, :user_IN)");

$stm->bindParam(":image_id_IN", $_GET['id']);
$stm->bindParam(":comment_IN", $_POST['comment']);
$stm->bindParam(":user_IN", $_SESSION['username']);

if($stm->execute()) {
    header("location:images.php");
}

