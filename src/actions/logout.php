<?php

require_once __DIR__ . '/../config/paths.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$_SESSION = array();

session_destroy();
header('Location:' . URL_BASE . 'index.php');
exit();
?>