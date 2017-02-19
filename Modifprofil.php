<?php 
require'connect.php';

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
        <link rel="stylesheet" href="./styles/Modifprofil.css">
        <link href="https://fonts.googleapis.com/css?family=Sansita" rel="stylesheet">
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
            <div id="second" class="container">
                <?php
    if (!empty($_POST)) {
        $stmt = $dbh->prepare('SELECT id
                  FROM users
                  WHERE Email = :email
                  '
                             );
        $stmt->execute([
            ':email' => $_POST['Email']
        ]);
        $result = $stmt->fetchall();
        if (count($result) > 0) {
            echo '<div class="error">
                      <p> L\'Email existe déjà !!!</p>
                  </div>';
        }
        elseif (count($result) == 0) {
            $hashed_password = crypt($_POST['password'], '_J9..rasm');
            $stmt = $dbh->prepare ('UPDATE users 
                            SET Pseudo = :name, Email = :email, password = :password
                            where id = :id');
            $stmt->execute([
                ':id' => $_SESSION['id'],
                ':email' =>$_POST['Email'],
                ':name' =>$_POST['Pseudo'],
                ':password' => $hashed_password
            ]);
            $stmt->fetchAll();
            header('Location: ./Profil.php');
        }
    }
                ?>
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-md-offset-4"> </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong> Modifiez Votre Profil</strong>
                        </div>
                        <div class="panel-body">
                            <form role="form" method="post">
                                <fieldset>
                                    <div id="marg">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-10  col-md-offset-1 ">

                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="glyphicon glyphicon-user"></i>
                                                        </span> 
                                                        <input class="form-control" placeholder="name" name="Pseudo" type="text" autofocus>
                                                    </div>
                                                </div>


                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="glyphicon glyphicon-user"></i>
                                                        </span> 
                                                        <input class="form-control" placeholder="Email" name="Email" type="email" autofocus>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="glyphicon glyphicon-lock"></i>
                                                        </span>
                                                        <input class="form-control" placeholder="Mot de passe" name="password" type="password" value="">
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <input type="submit" class="btn btn-lg btn-primary btn-block" value="Validez" >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

            </body>
        </html>