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

echo 'Le pseudo est : ' . htmlentities($user[0]['Pseudo']) . '<br>';
echo 'L\'email est : ' . htmlentities($user[0]['Email']) . '<br>';


if (!empty($_POST)){
    $stmt = $dbh->prepare ('UPDATE users 
                            SET Pseudo = :name, Email = :email
                            where id = :id');
    $stmt->execute([
        ':id' => $user[0]['id'],
        ':email' =>$_POST['Email'],
        ':name' =>$_POST['Pseudo']
    ]);
    $stmt->fetchAll();
    $user[0]['Pseudo'] = $_POST['Pseudo'];
    $user[0]['Email'] = $_POST['Email'];
    echo 'information modifiée' ;
    header('Location: ./Profil.php');
}

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

    echo '<img src="Images/' .$picture[$i][0] .'">';
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
    <label for="Nom">Pseudo :</label>
    <input type="text" name="Pseudo" value="<?= htmlentities($user[0]['Pseudo']) ?> " >
    <br>
    <label for="Email">L'Email:</label>
    <input type="text" name="Email" value="<?= htmlentities($user[0]['Email']) ?>">

    <br>
    <button type="submit" >Valider</button>
</form>
</body>