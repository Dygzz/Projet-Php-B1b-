<?php

session_start();

if (!$_SESSION['connected']) {
    header('Location:Connection.php');
}

echo 'coucou';