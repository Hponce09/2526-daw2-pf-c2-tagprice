<?php

include_once __DIR__ . '/../config/paths.php';

$db_path = PATH_BASE . 'database/tagPrice.db';

try {

    $db = new PDO("sqlite:" . $db_path);

    // 1. Configurar para que lance excepciones en caso de error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 2. Configurar para que devuelva los datos como arrays asociativos por defecto
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // 3. Activar claves foráneas
    $db->exec('PRAGMA foreign_keys = ON;');

} catch (PDOException $e) {

    die("Error de conexión PDO: " . $e->getMessage());

}