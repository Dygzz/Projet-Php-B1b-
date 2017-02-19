<?php

require'connect.php';

if (!empty($_POST)) {

$stmt = $dbh->prepare('SELECT id
                       FROM users
                       WHERE Email = :email 
                      '
);
$stmt->execute([
    ':email' => $_POST['email']
]);
$result = $stmt->fetchall();

if (count($result) > 0) {
    echo 'l\'email existe deja';
}
elseif (count($result) == 0) {

    $hashed_password = crypt($_POST['password'], '_J9..rasm');


    $stmt = $dbh->prepare('
                INSERT INTO users(pseudo, email, password) 
                VALUES (:pseudo, :email, :password);');
    $stmt->execute([
        ':pseudo' => $_POST['name'],
        ':email' => $_POST['email'],
        ':password' => $hashed_password
    ]);

    header('Location: ./Connection.php');

    }
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
    </head>
    <body>
        <form action="" method="post">
            <label for="name">Pseudo</label>
            <input type="text" name="name" id="">
            <label for="email">Email</label>
            <input type="text" name="email" id="">
            <label for="password">Mot de Passe</label>
            <input type="text" name="password" id="">
            <button type="submit">Inscription</button>
        </form>
    </body>
</html>

