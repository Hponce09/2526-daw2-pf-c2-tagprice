<?php
require_once __DIR__ . '/config/paths.php';

if (session_status() === PHP_SESSION_NONE) { session_start(); }

include PATH_BASE .'includes/header.php';

echo "<h1>¡Docker funcionando!</h1>";

if(isset($_SESSION['errorUrl'])){
    
    $errorUrl = $_SESSION['errorUrl'];

    echo $errorUrl;

    session_unset();
}

//phpinfo();
?>

<form action="<?=URL_BASE?>actions/procesar_url.proc.php" method="POST">
    <input type="text" name="url">

    <input type="submit">
</form>