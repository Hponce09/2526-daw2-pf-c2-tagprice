<?php

require_once __DIR__ . '/../config/paths.php';
/*
session_start();
if(!isset($_SESSION['autenticated']) || $_SESSION['autenticated'] !== true){
    header('Location:' . URL_BASE . 'views/login.php');
    exit;
}
*/
include PATH_BASE .'includes/header.php';

$url_a_buscar = "https://tiendarunning.es/es/zapatillas/3260-15844-asics-gel-kayano-32.html#/3634-tallas-95_us_435_eu/3885-color-600";

$output = shell_exec('python3 ' . PATH_BASE . 'scripts_python/scraper.py ' . escapeshellarg($url_a_buscar));
echo "<h2>Resultado de Python:</h2>";

//echo "<p>Precio actual: <strong>$precio €</strong></p>";

echo "<pre>$output</pre>";
?>