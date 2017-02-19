<?php
//
require 'connect.php';


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles/styles.css" />

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


        <div id="second" class="container">
            <?php
            if(!empty($_POST['password']) && !empty($_POST['email'])) {
                $psw = crypt($_POST['password'], '_J9..rasm');

                $stmt = $dbh->prepare('SELECT id
                       FROM users
                       WHERE Email = :email 
                       AND Password = :password'
                );
                $stmt->execute([
                    ':email' => $_POST['email'],
                    ':password' => $psw
                ]);
                $result = $stmt->fetchall();

                if (count($result) > 0) {
                    $_SESSION['connected'] = true;
                    $_SESSION['id'] = $result[0]['id'];
                    header('Location: ./Connecter.php');
                } elseif (count($result) == 0) {
                    echo '<div class="error">
                      <p> Le Mot Passe ou l\'Email sont faux!!!</p>
                  </div>';
                }
            }
            ?>
            <div class="row">

                <div class="col-sm-6 col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong> Veuillez saisir vos identifiants:</strong>
                        </div>
                        <div class="panel-body">
                            <form role="form"  method="post">
                                <fieldset>
                                    <div class="row">
                                        <div class="center-block">
                                            <img class="profile-img"
                                                 src="https://lh5.googleusercontent.com/-b0-k99FZlyE/AAAAAAAAAAI/AAAAAAAAAAA/eu7opA4byxI/photo.jpg?sz=120" alt="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-10  col-md-offset-1 ">
                                            <div class="form-group">
                                                <div class="input-group">
                                                        <span class="input-group-addon">
                                                            <i class="glyphicon glyphicon-user"></i>
                                                        </span>
                                                    <input class="form-control" placeholder="Email" name="email" type="email" autofocus>
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
                                                <input type="submit" class="btn btn-lg btn-primary btn-block" value="Connexion" >
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <h3 id="end">Si vous possedez un compte : <a href="./Connection.php" ><strong>Cliquez-ici</strong></a></h3>

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed --><!- Latest compiled and minified JavaScript -->
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
</body>
</html>
