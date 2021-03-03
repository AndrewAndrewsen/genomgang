<center>
    <?php
    include("db.php");
    session_start();

    $stm = $pdo->query("SELECT id, path FROM images");
    while ($row = $stm->fetch()) {

    

        echo '<p><img src="' . $row['path'] . '" /><br />';
    ?>
        <form method="post" action="handleComments.php?id=<?=$row['id']?>">
            <b><?= $_SESSION['username'] ?></b><br />
            <textarea name="comment"></textarea><br />
            <input type="submit" value="Skicka" />
        </form>
    <?php
        echo "<h2>Kommentarer:</h2></p>";
        $comments_stm = $pdo->query("SELECT comment, user FROM comments WHERE image_id=".$row['id']);
        while($comment = $comments_stm->fetch()) {
            echo "<p><b>". $comment['user'] ."</b><br />";
            echo $comment['comment'] ."</p>";
        }

    }
    ?>
</center>