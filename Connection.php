<?php



require 'connect.php';


if(!empty($_POST['password']) && !empty($_POST['email'])){
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
        $_SESSION['id']= $result['id'];
        header('Location: ./Connecter.php');
    }
    elseif (count($result) == 0) {
        echo 'l\'email ou mot de passe incorrect!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
    <body bgcolor="#C6EBF4" >
        <table border="1" align="center" height="100%"; width="100%" cellpadding="50%" cellspacing="0">
            <tr height="120" align="center">
                <td>
                    <table>
                        <tr>
                            <td><img src="ImagesHtml/upload.png" width="100"></td>
                            <td>
                                <FONT size="12"><i>Site For Upload</i></FONT>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <center><span id="date_heure"></span></center>
            <script type="text/javascript">window.onload = date_heure('date_heure');</script>
            <tr height="100%">
                <td>
                    <form action="" method="post">
                        <table border="1" align="center" height="100%"; width="300" cellpadding="0" cellspacing="0">
                            <tr align="center">
                                <td>
                                    <br>
                                    <br>
                                    Veuillez saisir vos identifiants:
                                    <br>
                                    <br>
                                    Votre email :
                                    <br>
                                    <input type="text" name="email" id="" placeholder="email">
                                    <br>
                                    Votre mot de passe :
                                    <br>
                                    <input type="password" name="password" id="" placeholder="mot de passe">
                                    <br>
                                    <br>
                                    <button type="submit" value="Connexion" >Connexion</button>
                                    <br>
                                    <br>
                                </td>
                            </tr>
                        </table>
                    </form>
                </td>
            </tr>
            <tr height="50" align="center">
                <td>Ingésup Students</td>
            </tr>
        </table>
    </body>
</html>

