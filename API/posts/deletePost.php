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

$post = new Post($pdo);
echo $post->DeletePost($_GET['id']);