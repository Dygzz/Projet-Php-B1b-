<?php

require 'connect.php';

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);



// initialisation du nom de la photo
$pixName = '';

// Upload de photo
if (!empty($_FILES['picture']) && $_FILES['picture']['error'] == 0) {

    $mime_valid = ['image/png', 'image/jpeg','image/jpg','image/gif'];
    $extension_valid = ['png', 'jpeg','jpg','gif'];

    $extension = pathinfo($_FILES['picture']['name'])['extension'];

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['picture']['tmp_name']);

    // test le mime & l'extension avec pathinfo() -- On ne veut que des fichiers PNG
    if(in_array($extension, $extension_valid) && in_array($mime, $mime_valid)){
        move_uploaded_file($_FILES['picture']['tmp_name'], 'Images/' . $_FILES['picture']['name']);

        // L'enregistrement du nom de la photo suite à l'upload
        $pixName = $_FILES['picture']['name'];


        $stmt = $dbh->prepare('INSERT INTO pictures VALUES(NULL, :Name, NULL)');
        $stmt->execute([

            ':Name' => $pixName
        ]);

    } else {
        echo 'Erreur de format';
    }
}




?>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="picture" accept="image/*" id="">
    <button type="submit">
        Upload
    </button>
</form>