<?php
session_start();
require 'ConnectionBaseDonnes.php';

if(!empty($_POST['password']) && !empty($_POST['email'])){
    $stmt = $dbh->prepare('SELECT id
                       FROM users
                       WHERE Email = :email 
                       AND Password = :password'
    );
    $stmt->execute([
        ':email' => $_POST['Email'],
        ':password' => $_POST['Password']
    ]);
    $result = $stmt->fetchAll()[0]();

    if (count($result) > 0) {
        $_SESSION['connected'] = true;
        $_SESSION['id']= $result['id'];
        header('Location: ./Connecte.php');
    } elseif (count($result) == 0) {
        echo 'l\'email ou le mot de passe sont faux';
    }
}
?>

<form action="" method="post">
    <input type="text" name="email" id="">
    <input type="password" name="password" id="">
    <button type="submit">Valider</button>
</form>