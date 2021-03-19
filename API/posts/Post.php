<?php

class Post {

    private $database_connection;

    function __construct($db) {
        $this->database_connection = $db;
    }

    function CreatePost($title, $content) {

        $sql = "INSERT INTO posts (title, content, date_created) VALUES(:title_IN, :content_IN, NOW())";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":title_IN", $title);
        $statement->bindParam(":content_IN", $content);
        
        $message = new stdClass();

        if($statement->execute()) {
            $message->message = "Post successfully created!";
            $message->postId = $this->database_connection->lastInsertId();
             
        } else {
            $message->message = "Could not create post!";
            $message->code = "0005";
        }

        return $message;

    }

    function GetAllPosts() {
        $sql = "SELECT id, title, content, date_created FROM posts";
        $statement = $this->database_connection->prepare($sql);
        $statement->execute();
        return json_encode($statement->fetchAll(PDO::FETCH_ASSOC));
    }

    function GetPost($id) {
        $sql = "SELECT id, title, content, date_created FROM posts WHERE id=:id_IN";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":id_IN", $id);
        
        if($statement->execute()) {
            return json_encode($statement->fetch());
        }

    }

    function DeletePost($id) {
        $sql = "DELETE FROM posts WHERE id=:id_IN";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":id_IN", $id);
        if($statement->execute()) {

            $message = new stdClass();
            $message->message = "Successfully deleted post!";
            return json_encode($message);

        }
    }

    function UpdatePost($id, $title = "", $content = "") {

        if(!empty($title)) {
            $this->updateTitle($id, $title);
        }

        if(!empty($content)) {
            $this->updateContent($id, $content);

        }

    }

    private function updateTitle($id, $title) {
        $sql = "UPDATE posts SET title=:title_IN WHERE id=:id_IN";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":title_IN", $title);
        $statement->bindParam(":id_IN", $id);
        $statement->execute();
    }

    private function updateContent($id, $content) {
        $sql = "UPDATE posts SET content=:content_IN WHERE id=:id_IN";
        $statement = $this->database_connection->prepare($sql);
        $statement->bindParam(":content_IN", $content);
        $statement->bindParam(":id_IN", $id);
        $statement->execute();
    }

    function SearchPost($keyword) {
        $sql = "SELECT id, title, content, date_created FROM posts WHERE title LIKE :keyword_IN OR content LIKE :keyword_IN";
        $statement = $this->database_connection->prepare($sql);
        $keyword = '%'. $keyword .'%';
        $statement->bindParam(":keyword_IN", $keyword);
        $statement->execute();
        return json_encode($statement->fetchAll());
    }

}