<?php
require_once __DIR__ . '/config/paths.php';
if (session_status() === PHP_SESSION_NONE) { session_start(); }

include PATH_BASE .'includes/header.php';

echo "<h1>¡Docker funcionando!</h1>";


//phpinfo();
?>