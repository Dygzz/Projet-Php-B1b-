<?php

require'connect.php';
if (!empty($_POST)) {


    $hashed_password = crypt($_POST['password'],'_J9..rasm');


    $stmt = $dbh->prepare('
                INSERT INTO users(pseudo, email, password) 
                VALUES (:pseudo, :email, :password);');
    $stmt->execute([
        ':pseudo' => $_POST['name'],
        ':email' => $_POST['email'],
        ':password' => $hashed_password
    ]);
}

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Document</title>
        <link rel="stylesheet" href="./styles/inscription.css">
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

    </head>
    <body>
        <body bgcolor="#C6EBF4">
            <center>

            </center>
            <table border="1" align="center" height="100%"; width="100%" cellpadding="40%" cellspacing="0">
                <tr height="120" align="center">
                    <td>
                        <table>
                            <tr>
                                <td><img src="./ImagesHtml/upload.png" width="100"></td>
                                <td>
                                    <FONT size="12"><i> Site For Upload </i></FONT>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <center><span id="date_heure"></span></center>
                <script type="text/javascript">window.onload = date_heure('date_heure');</script>



                <tr height="100%">
                    <td>
                        <form action="index.php" method="POST">

                            <table border="1" align="center" height="100%"; width="300" cellpadding="0" cellspacing="0">
                                <tr align="center">
                                    <h2 id="Titre"> Inscrivez-vous !</h2>

                                    <td>
                                        <br>
                                        <br>
                                        Entrez votre nom :
                                        <br>
                                        <input type="text" name="name" id="" placeholder="nom"> 
                                        <br>
                                        <br>

                                        Entrez votre email :
                                        <br>
                                        <input type="text" name="email" id="" placeholder="email"> 
                                        <br>
                                        <br>
                                        Entrez votre password :
                                        <input type="text" name="password" id="" placeholder="password">
                                        <br> 
                                        <br>
                                        <button type="submit">Inscription</button> 
                                        <br>
                                        <br>
                                        <br>
                                    </td>
                                </tr>
                            </table>
                        </form>

                        <tr height="50" align="center">
                            <td>Ingésup Students</td>
                        </tr>
            </table>

                </body>

            </html>

