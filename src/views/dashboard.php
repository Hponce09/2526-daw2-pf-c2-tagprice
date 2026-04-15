<?php

require_once __DIR__ '/../config/paths.php';

session_start();
if(!isset($_SESSION['autenticated']) || $_SESSION['autenticated'] !== true){
    header('Location:' . URL_BASE . 'views/login.php');
    exit;
}

?>