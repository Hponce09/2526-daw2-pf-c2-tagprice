<?php
include_once __DIR__ . '/../config/paths.php';
include_once PATH_BASE . '/../includes/db_connect.php'; 

try {
    $query = "SELECT product_id, url_compra, precio_actual FROM product";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($productos as $pro) {
        $id = $pro['product_id'];
        $url = $pro['url_compra'];
        $precioViejo = $pro['precio_actual'];

        // --- EL PUENTE CON PYTHON ---
        // Ejecutamos el script de python pasando la URL como argumento
        // Asegúrate de que scraper.py imprima SOLO el número del precio
        $comando = "python3 " . PATH_BASE . "/scripts_python/scraper.py " . escapeshellarg($url);
        $precioNuevo = trim(shell_exec($comando)); 
        // ----------------------------

        // Validamos que lo que devolvió Python sea un número
        if (is_numeric($precioNuevo) && $precioNuevo != $precioViejo) {
            
            // 1. Actualizamos el precio actual
            $upd = $pdo->prepare("UPDATE product SET precio_actual = ? WHERE product_id = ?");
            $upd->execute([$precioNuevo, $id]);

            // 2. Registramos en el historial para la gráfica
            $his = $pdo->prepare("INSERT INTO price_history (id_product, precio) VALUES (?, ?)");
            $his->execute([$id, $precioNuevo]);
            
            echo "✅ ID $id: Actualizado a $precioNuevo <br>";
        } else {
            echo "ℹ️ ID $id: Sin cambios o error (Precio recibido: '$precioNuevo')\n";
        }
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}