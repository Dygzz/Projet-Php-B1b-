<?php

session_start();

if (empty($_SESSION['connected'])) {
    header('Location:Utilisateur.php');
}

echo 'coucou';