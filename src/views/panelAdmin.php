<?php

require_once __DIR__ . '/../config/paths.php';

session_start();
if(!isset($_SESSION['autenticated']) || $_SESSION['autenticated'] !== true){
    header('Location:' . URL_BASE . 'views/login.php');
    exit;
}

include PATH_BASE .'includes/header.php';
include_once PATH_BASE . 'includes/db_connect.php'; 


?>