<?php

$upload_dir = "uploads/";
$target_file = $upload_dir . basename($_FILES['imageToUpload']['name']);
$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

if (isset($_POST['submit'])) {

    $check = getimagesize($_FILES['imageToUpload']['tmp_name']);
    if ($check == false) {
        echo "The file is not an image!";
        die;
    }
}

if (file_exists($target_file)) {
    echo "The file already exists!";
    die;
}

if ($_FILES['imageToUpload']['size'] > 1000000) {
    echo "The file is too big!";
    die;
}

if ($fileType != "png" && $fileType != "gif" && $fileType != "jpg" && $fileType != "jpeg") {
    echo "You can only upload PNG, GIF, JPG or JPEG";
    die;
}


if (move_uploaded_file($_FILES['imageToUpload']['tmp_name'], $target_file)) {
    include("db.php");

    $sql = "INSERT INTO images (path) VALUES('$target_file')";
    $stm = $pdo->prepare($sql);
    
    if ($stm->execute()) {
        echo "File uploaded successfully!";
    } else {
        echo "Something went wrong!";
    }
} else {
    echo "Something went wrong!";
}
