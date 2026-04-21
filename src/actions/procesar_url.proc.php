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

$comando = 'python3 ' . PATH_BASE . 'scripts_python/scraper.py ' . escapeshellarg($url_a_buscar);
$output = shell_exec($comando);

$partes = explode(";", trim($output));

if (count($partes) >= 4) {
    [$nombre, $precio_oferta, $precio_pvp, $imagen] = $partes;

    echo "<div style='text-align:center; border:1px solid #ddd; padding:20px; border-radius:15px; max-width:400px; margin:auto;'>";
        echo "<img src='$imagen' style='width:100%; border-radius:10px;'>";
        echo "<h3>$nombre</h3>";
        
        // Si hay descuento, mostramos el precio viejo tachado
        if ((float)$precio_pvp > (float)$precio_oferta) {
            echo "<p style='color:red; text-decoration:line-through; margin-bottom:0;'>Antes: $precio_pvp €</p>";
        }
        
        echo "<p style='font-size:2em; color:green; margin-top:0;'>Ahora: <strong>$precio_oferta €</strong></p>";
        
        // Cálculo del ahorro opcional
        $ahorro = (float)$precio_pvp - (float)$precio_oferta;
        if ($ahorro > 0) {
            echo "<span style='background:yellow; padding:5px;'>¡Ahorras " . number_format($ahorro, 2) . " €!</span>";
        }
    echo "</div>";
}
?>