<?php
require 'connect.php';

session_destroy();

header('Location: ./Connecter.php');

?>