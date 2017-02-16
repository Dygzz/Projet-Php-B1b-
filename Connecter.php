<?php

require 'connect.php';

$stmt = $dbh->prepare('SELECT NAME 
                       FROM pictures
                       ORDER  by id DESC LIMIT 0, 5  
                       '
);
$stmt->execute();
$lastPicture = $stmt->fetchall();

for ($i = 0; $i < count($lastPicture); $i ++) {

    echo '<img src="Images/' .$lastPicture[$i][0] .'">';
}

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

        if ($_SESSION['connected'] == true) {

            $stmt = $dbh->prepare('INSERT INTO pictures VALUES(NULL, :Name, :id)');
            $stmt->execute([
                ':id' => $_SESSION['id'],
                ':Name' => $pixName
            ]);

        }

        else{
            $stmt = $dbh->prepare('INSERT INTO pictures VALUES(NULL, :Name, NULL)');
            $stmt->execute([

                ':Name' => $pixName
            ]);
        }

        header('Location: ./Connecter.php');
    }
    else {
        echo 'Erreur de format';
    }
}?>
<?php
var_dump($_SESSION);
if(empty($_SESSION['id'])) {
    echo '<a href="Connection.php">log</a>
          <a href="inscription.php">register</a>';
}
else{
    echo '<a href="Profil.php">profil</a>';
}
?>
<form action="" method="post" enctype="multipart/form-data">
    <input type="file" name="picture" accept="image/*" id="">
    <button type="submit">
        Upload
    </button>
</form>

<button><a href="Deconexion.php">Deconnexion</a></button>