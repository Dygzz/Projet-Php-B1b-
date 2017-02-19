<?php

require 'connect.php';

if (!empty($_SESSION['id'])) {
    $stmt = $dbh->prepare('SELECT *
                       FROM users
                       WHERE id = :id
                    ');
    $stmt->execute([
        ':id' => $_SESSION['id']
    ]);
    $user = $stmt->fetchAll();
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

            $stmt = $dbh->prepare('INSERT INTO pictures VALUES(NULL, :Name, :date, :id)');
            $stmt->execute([
                ':id' => $_SESSION['id'],
                ':Name' => $pixName,
                ':date' => date('d/m/Y')
            ]);

        }

        else{
            $stmt = $dbh->prepare('INSERT INTO pictures VALUES(NULL, :Name, :date, NULL)');
            $stmt->execute([
                ':Name' => $pixName,
                ':date' => date('d/m/Y')
            ]);
        }

        header('Location: ./Connecter.php');
    }
    else {
        echo 'Erreur de format';
    }
}?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/styles1.css" />

</head>
<body>
<div id="first">
    <div class="container">
        <div class="col-md-4 col-sm-4 col-xs-4" align="left">
            <a href="Connecter.php">
                <img src="ImagesHtml/upload.png" class="logo" class="img-responsive">
            </a>

        </div>

        <div class="col-md-4 col-sm-4 col-xs-4" align="center">
            <script language="javascript">
                function date_heure(id)
                {
                    date = new Date;
                    annee = date.getFullYear();
                    moi = date.getMonth();
                    mois = new Array('janvier', 'f&eacute;vrier', 'mars', 'avril', 'mai', 'juin', 'juillet', 'Ao&ucirc;t', 'septembre', 'octobre', 'novembre', 'D&eacute;cembre');
                    j = date.getDate();
                    jour = date.getDay();
                    jours = new Array('dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
                    h = date.getHours();
                    if(h<10)
                    {
                        h = "0"+h;
                    }
                    m = date.getMinutes();
                    if(m<10)
                    {
                        m = "0"+m;
                    }
                    s = date.getSeconds();
                    if(s<10)
                    {
                        s = "0"+s;
                    }
                    resultat = 'Nous sommes le '+jours[jour]+' '+j+' '+mois[moi]+' '+annee+' et il est '+h+':'+m+':'+s;
                    document.getElementById(id).innerHTML = resultat;
                    setTimeout('date_heure("'+id+'");','1000');
                    return true;
                }
            </script>
            <center><span id="date_heure"></span></center>
            <script type="text/javascript">window.onload = date_heure('date_heure');</script>

        </div>

        <?php

        if(empty($_SESSION['id'])) {
            echo '  <div class="col-md-2 col-sm-2 col-xs-2 logreg"  >
                        <a href="inscription.php" >Inscription </a>
                       
                       </div>
                       
                       <div class="col-md-2 col-sm-2 col-xs-2 logreg"  >
                       <a href="Connection.php">Connection</a>
                         </div>'
            ;
        }
        else {
            ?>
            <div class="col-md-4 col-sm-4 col-xs-4" align="right" >

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="glyphicon glyphicon-user"></span>
                        <strong>Compte</strong>
                        <span class="glyphicon glyphicon-chevron-down"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <div class="navbar-login">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <p class="text-left"><strong>Pseudo: </strong><?= htmlentities($user[0]['Pseudo']) ?></p>
                                        <p class="text-left small">Email: <?= htmlentities($user[0]['Email']) ?></p>
                                        <p class="text-left">
                                            <a href="Modifprofil.php" class="btn btn-primary btn-block btn-sm">Modification</a>
                                            <a href="Profil.php" class="btn btn-primary btn-block btn-sm">Profil</a>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="navbar-login navbar-login-session">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <a href="Deconexion.php" class="btn btn-danger btn-block">Deconnexion</a>

                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </li>
            </div>
            <?php
        }
        ?>
    </div>
</div>
<div id="second">
    <h1>Derniere Image Upload:</h1>

    <hr>

    <?php
    $stmt = $dbh->prepare('SELECT NAME 
                       FROM pictures
                       ORDER  by id DESC LIMIT 0, 5  
                       '
    );
    $stmt->execute();
    $lastPicture = $stmt->fetchall();

    for ($i = 0; $i < count($lastPicture); $i ++) {

        echo'

        <div class="col-md-3  col-md-offset-1 image">
            <img src="Images/' .$lastPicture[$i][0] .'" class="img-responsive">
        </div>';
    }
    ?>

    <div class="clearfix"></div><br>
</div>

<div id="third">


    <div class="row">
        <div class="pulse-btn" >
            <div class="container">
                <form action="" method="post" enctype="multipart/form-data">
                    <input type="file" name="picture" accept="image/*" id="">
                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed --><!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>