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
