<?php
$dsn = 'mysql:dbname=projet_php_b1;host:127.0.0.1';
$user = 'root';
$password = '';
try {
    $dbh = new PDO($dsn, $user, $password);
} catch (Exception $e) {
    echo $e->getMessage();
}