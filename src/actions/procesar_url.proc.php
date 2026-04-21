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

$url_a_buscar = "https://tiendarunning.es/es/zapatillas/3955-19564-ASICSSUPERBLAST3.html#/3363-color-100/3556-tallas-9_us_425_eu";

$comando = 'python3 ' . PATH_BASE . 'scripts_python/scraper.py ' . escapeshellarg($url_a_buscar);
$output = shell_exec($comando);

// 3. Procesamiento del resultado
$resultado = trim($output);
$partes = explode(";", $resultado);

echo "<div class='container' style='margin-top: 50px; font-family: Arial, sans-serif;'>";

// Verificamos que Python devolvió los 4 campos esperados
if (count($partes) >= 4) {
    [$nombre, $precio_rebajado, $precio_original, $imagen] = $partes;

    // Convertimos a número para poder comparar
    $rebajado_num = (float)$precio_rebajado;
    $original_num = (float)$precio_original;

    ?>
    <div class="card-producto" style="max-width: 500px; margin: auto; border: 1px solid #ddd; border-radius: 15px; padding: 30px; box-shadow: 0 10px 20px rgba(0,0,0,0.1); text-align: center;">
        
        <div style="margin-bottom: 20px;">
            <img src="<?php echo htmlspecialchars($imagen); ?>" alt="Producto" style="width: 100%; max-width: 350px; height: auto; border-radius: 10px;">
        </div>

        <h2 style="font-size: 1.4em; color: #333; margin-bottom: 15px;">
            <?php echo htmlspecialchars($nombre); ?>
        </h2>

        <div style="background: #f9f9f9; padding: 15px; border-radius: 10px;">
            <?php if ($original_num > $rebajado_num): ?>
                <p style="margin: 0; color: #888; text-decoration: line-through; font-size: 1.1em;">
                    Antes: <?php echo number_format($original_num, 2); ?> €
                </p>
                <p style="margin: 5px 0; color: #e74c3c; font-size: 2.2em; font-weight: bold;">
                    <?php echo number_format($rebajado_num, 2); ?> €
                </p>
                <span style="background: #e74c3c; color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.9em; font-weight: bold;">
                    ¡OFERTA!
                </span>
            <?php else: ?>
                <p style="margin: 0; color: #2ecc71; font-size: 2.2em; font-weight: bold;">
                    <?php echo number_format($rebajado_num, 2); ?> €
                </p>
            <?php endif; ?>
        </div>

        <div style="margin-top: 20px;">
            <a href="<?php echo $url_a_buscar; ?>" target="_blank" style="display: inline-block; padding: 12px 25px; background: #333; color: white; text-decoration: none; border-radius: 5px; font-weight: bold;">
                Ver en la tienda
            </a>
        </div>
    </div>
    <?php

} else {
    // Si Python falla o no devuelve 4 partes
    echo "<div style='background: #fee; border: 1px solid red; padding: 20px; border-radius: 10px;'>";
    echo "<h3 style='color: red;'>Error en la extracción:</h3>";
    echo "<p>El motor de búsqueda devolvió un formato no válido.</p>";
    echo "<strong>Detalle técnico:</strong><pre>" . htmlspecialchars($resultado) . "</pre>";
    echo "</div>";
}

echo "</div>";
?>