<?php
include("db.php");

$stm = $pdo->query("SELECT path FROM images");
while($row = $stm->fetch()) { 

    echo '<img src="'. $row['path'] .'" /><br />'; 

}