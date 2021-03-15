<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Ladda upp bild!</h1>

    <form method="post" action="upload.php" enctype="multipart/form-data">
        <input type="file" name="imageToUpload" /><br />
        <input type="submit" value="Ladda upp!" />
    </form>

</body>
</html>