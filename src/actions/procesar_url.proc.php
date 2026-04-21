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

$url_a_buscar = "https://www.atmosferasport.es/asics/zapatillas-de-running-asics-gel-kayano-32-hombre-negro-blanco-142494.html?utm_source=awin&utm_medium=afiliacion&sv1=affiliate&sv_campaign_id=332637&awc=26255_1776783939_a6e7591044709bfcebd65b350dcdd58a";

$comando = 'python3 ' . PATH_BASE . 'scripts_python/scraper.py ' . escapeshellarg($url_a_buscar);
$output = shell_exec($comando);

// 3. Procesamiento del resultado
$resultado = trim($output);
$partes = explode(";", $resultado);
if (count($partes) >= 4) {
    [$nombre, $rebajado, $original, $imagen] = $partes;

    // --- ARREGLO CRÍTICO PARA LA IMAGEN ---
    // Si la imagen empieza por // (como en GigaSport), le añadimos https:
    if (strpos($imagen, '//') === 0) {
        $imagen = "https:" . $imagen;
    }

    ?>
    <div style="max-width: 400px; margin: auto; text-align: center; border: 1px solid #ddd; padding: 20px; border-radius: 10px;">
        <img src="<?php echo $imagen; ?>" style="width: 100%; border-radius: 8px;">
        <h2><?php echo htmlspecialchars($nombre); ?></h2>
        
        <div style="background: #f4f4f4; padding: 15px; border-radius: 8px;">
            <?php if ((float)$original > (float)$rebajado): ?>
                <p style="text-decoration: line-through; color: #777; margin: 0;">Antes: <?php echo $original; ?> €</p>
                <p style="font-size: 24px; color: #d9534f; font-weight: bold; margin: 5px 0;">Ahora: <?php echo $rebajado; ?> €</p>
            <?php else: ?>
                <p style="font-size: 24px; color: #333; font-weight: bold;">Precio: <?php echo $rebajado; ?> €</p>
            <?php endif; ?>
        </div>
        
        <br>
        <a href="<?php echo $url_a_buscar; ?>" style="background: #333; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;">Ir a la tienda</a>
    </div>
    <?php
} else {
    echo "Error: Python devolvió: " . htmlspecialchars($resultado);
}
?>