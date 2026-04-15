<?php

// 1. Incluimos la conexión
include_once __DIR__ . '/../config/paths.php';
include_once PATH_BASE . 'includes/db_connect.php';

// 2. Definimos el orden de borrado (de hijos a padres)
$tables = [
    'price_history',
    'favorites',
    'sizes', 
    'product',
    'users'
];

if ($db != null) {
    try {
        // Desactivamos claves foráneas para un borrado limpio
        $db->exec('PRAGMA foreign_keys = OFF;');

        foreach ($tables as $table) {

            $sql = "DROP TABLE IF EXISTS $table";
            $db->exec($sql);
            echo "Tabla '$table' eliminada con éxito.<br>";
        }

        // Volvemos a activar la integridad referencial
        $db->exec('PRAGMA foreign_keys = ON;');
        

        echo "<br><strong style='color: green;'>✅ Base de datos limpia y lista para la nueva estructura.</strong><br>";
        echo "<a href='init.php' style='display: inline-block; margin-top: 10px; padding: 10px; background: #059669; color: white; text-decoration: none; border-radius: 5px;'>🚀 Ejecutar nuevo init.php</a>";

    } catch (Exception $e) {
        echo "❌ Error al resetear: " . $e->getMessage();
    }
} else {
    echo "Error de conexión con la base de datos.";
}
?>
