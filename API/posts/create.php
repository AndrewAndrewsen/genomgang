<?php
include("../db.php");
include("Post.php");

$error = new stdClass();
if(empty($_GET['title'])) {
    $error->message = "A post needs a title!";
    $error->code = "0006";
    print_r(json_encode($error));
    die();
}

if(empty($_GET['content'])) {
    $error->message = "A post needs content!";
    $error->code = "0007";
    print_r(json_encode($error));
    die();
}


$post = new Post($pdo);
print_r(json_encode($post->CreatePost($_GET['title'], $_GET['content'])));
