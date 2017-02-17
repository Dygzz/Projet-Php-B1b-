<?php
//
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
        $_SESSION['id']= $result[0]['id'];
        header('Location: ./Connecter.php');
    }
    elseif (count($result) == 0) {
        echo 'l\'email ou le mot de passe sont faux';
    }
}
?>

<form action="" method="post">
    <input type="text" name="email" id="">
    <input type="password" name="password" id="">
    <button type="submit">Valider</button>
</form>