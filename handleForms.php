<?php
    $name = $_POST['name'];
    $message = $_POST['message'];

    $dsn = "mysql:host=localhost;dbname=community";
    $user = "root";
    $password = "";

    $pdo = new PDO($dsn, $user, $password);

    $sql = "INSERT INTO message (name, message) VALUES(:name_IN, :message_IN)";
    $stmt = $pdo->prepare($sql);

    $stmt->bindParam(':name_IN', $name);
    $stmt->bindParam(':message_IN', $message);

    echo $stmt->execute();

    