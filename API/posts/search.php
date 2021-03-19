<?php
include("../db.php");
include("Post.php");

if (empty($_GET['keyword'])) {
    $error = new stdClass();
    $error->message = "No keyword specified!";
    $error->code = "0008";
    print_r(json_encode($error));
    die();
}

$post = new Post($pdo);
echo $post->SearchPost($_GET['keyword']);