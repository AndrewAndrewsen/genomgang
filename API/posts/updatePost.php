<?php
include("../db.php");
include("Post.php");

if (empty($_GET['id'])) {
    $error = new stdClass();
    $error->message = "No id specified!";
    $error->code = "0004";
    print_r(json_encode($error));
    die();
}

if (empty($_GET['title'])) {
    $error = new stdClass();
    $error->message = "No title specified!";
    $error->code = "0007";
    print_r(json_encode($error));
    die();
}

if (empty($_GET['content'])) {
    $error = new stdClass();
    $error->message = "No content specified!";
    $error->code = "0008";
    print_r(json_encode($error));
    die();
}


$post = new Post($pdo);
$post->UpdatePost($_GET['id'], $_GET['title'], $_GET['content']);