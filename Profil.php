<?php

require 'connect.php';

if (!$_SESSION['connected']) {
    header('Location: ./Connection.php');
}

$stmt = $dbh->prepare('SELECT *
                       FROM users
                       WHERE id = :id
                    ');
$stmt->execute([
    ':id' => $_SESSION['id']
]);
$user = $stmt->fetchAll();

?>

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
            <a >
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

    </div>
</div>
<div id="second">
    <h1>Les Image que vous avez Upload:</h1>

    <hr>

    <?php
    $stmt = $dbh->prepare('SELECT Name
                       FROM pictures p, users u
                       WHERE p.id_user = u.id
                       AND :id = u.id 
                    ');
    $stmt->execute([
        ':id' => $_SESSION['id']
    ]);
    $picture = $stmt->fetchAll();

    for ($i = 0; $i < count($picture); $i ++) {

        echo'

        <div class="col-md-3  col-md-offset-1 image">
           <img src="Images/' .$picture[$i][0] .'">
        </div>';
    }
    ?>

    <div class="clearfix"></div><br>
</div>



<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<button><a href="./Modifprofil.php">modifier</a></button>
</body>