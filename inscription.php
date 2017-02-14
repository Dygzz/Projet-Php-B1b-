<?php

require'connect.php'
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
    </head>
    <body>
        <form action="" method="post">
            <input type="text" name="name" id="">
            <input type="text" name="email" id="">
            <input type="text" name="password" id="">
            <button type="submit">Enregistrer</button>
            
        </form>
    </body>
</html>

