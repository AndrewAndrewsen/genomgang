<?php
include("../db.php");
include("Post.php");

$post = new Post($pdo);
print_r($post->GetAllPosts());
