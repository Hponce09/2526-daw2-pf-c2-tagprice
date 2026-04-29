<?php
// src/bin/update_prices.php

// 1. ESCUDO DE SEGURIDAD: Solo ejecución por consola (CLI)
/*if (php_sapi_name() !== 'cli') {
    header('HTTP/1.1 403 Forbidden');
    exit("ERROR: Este script solo puede ser ejecutado por el sistema (Cron Job).\n");
}
*/
include_once __DIR__ . '/../config/paths.php';
include_once PATH_BASE . 'includes/db_connect.php'; 

echo "\n--- INICIANDO RASTREO TAGPRICE [" . date('Y-m-d H:i:s') . "] ---\n";

// 2. VERIFICACIÓN DE CONEXIÓN
if (!$db) {
    exit("❌ Error Crítico: No hay conexión con la base de datos.\n");
}

// 3. OBTENCIÓN DE PRODUCTOS
$query = "SELECT product_id, url_compra, precio_actual FROM product";
$stmt = $db->prepare($query);
$stmt->execute();
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (!$productos) {
    exit("ℹ️ La base de datos está vacía. No hay nada que rastrear.\n");
}

// 4. BUCLE DE ACTUALIZACIÓN
foreach ($productos as $pro) {
    $id = $pro['product_id'];
    $url = $pro['url_compra'];
    $precioViejo = (float)$pro['precio_actual'];

    // EJECUCIÓN DEL SCRAPER
    $comando = "python3 " . PATH_BASE . "scripts_python/scraper.py " . escapeshellarg($url);
    $salidaPython = trim(shell_exec($comando)); 

    // PROCESAMIENTO DE LA SALIDA (Extraer el precio de la cadena con ';')
    $partes = explode(';', $salidaPython);
    
    // Si la cadena tiene el formato 'Nombre;Precio;...', el precio está en el índice 1
    $precioNuevoStr = (isset($partes[1])) ? $partes[1] : $salidaPython;
    
    // Limpiamos espacios y convertimos a número
    $precioNuevo = (float)trim($precioNuevoStr);

    // 5. LÓGICA DE ACTUALIZACIÓN
    if ($precioNuevo > 0) {
        
        // Solo guardamos si el precio ha cambiado
        
            
            // A. Actualizamos la tabla principal
            $upd = $db->prepare("UPDATE product SET precio_actual = ? WHERE product_id = ?");
            $upd->execute([$precioNuevo, $id]);

            // B. Insertamos en el historial para la gráfica
            $his = $db->prepare("INSERT INTO price_history (id_product, precio) VALUES (?, ?)");
            $his->execute([$id, $precioNuevo]);
            
            echo "✅ ID $id: PRECIO CAMBIADO (De $precioViejo € a $precioNuevo €)\n";
        

    } else {
        echo "❌ ID $id: Error en el rastreo (Salida inválida: '$salidaPython')\n";
    }

    // Pequeño descanso para evitar bloqueos del servidor externo (Nike, etc.)
    sleep(1);
}

echo "--- RASTREO FINALIZADO ---\n\n";