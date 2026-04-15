<?php
include_once __DIR__ . '/../config/paths.php';
include_once PATH_BASE . 'includes/db_connect.php';

// Cambios realizados: INTEGER PRIMARY KEY AUTOINCREMENT (en ese orden)
$sqlCreateUser = 'CREATE TABLE IF NOT EXISTS users (
    usu_id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
    usu_mail VARCHAR(50) NOT NULL UNIQUE,
    usu_password VARCHAR(255) NOT NULL,
    usu_name VARCHAR(200) NOT NULL,
    usu_rol TEXT NOT NULL DEFAULT "user" -- Por defecto, todos son usuarios
);';

$sqlCreateProduct = 'CREATE TABLE IF NOT EXISTS product (
    product_id INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre VARCHAR(255),
    imagen VARCHAR(255),
    url_compra TEXT,
    precio_actual DECIMAL(10,2)
);';

$sqlCreatesizes = 'CREATE TABLE IF NOT EXISTS sizes (
    id_talla INTEGER PRIMARY KEY AUTOINCREMENT,
    id_product INTEGER NOT NULL,
    talla_valor VARCHAR(20),
    stock INTEGER DEFAULT 0,
    FOREIGN KEY (id_product) REFERENCES product(product_id) ON DELETE CASCADE
);';

$sqlCreatefavoritos = 'CREATE TABLE IF NOT EXISTS favorites (
    favoritos_id INTEGER PRIMARY KEY AUTOINCREMENT,
    usu_id INTEGER NOT NULL,
    product_id INTEGER NOT NULL,
    fecha_agregado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usu_id) REFERENCES users(usu_id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES product(product_id) ON DELETE CASCADE
);';

$sqlCreateHistorialPrecios = 'CREATE TABLE IF NOT EXISTS price_history (
    id_historial INTEGER PRIMARY KEY AUTOINCREMENT,
    id_product INTEGER NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_product) REFERENCES product(product_id) ON DELETE CASCADE
);';

// El Insert (Asegúrate de que las tablas existan antes de insertar)
$sqlInsertUsers = 'INSERT INTO users (usu_mail, usu_password, usu_name, usu_rol) VALUES 
("admin@test.com", "$2a$12$dwNzvtVZQT2RTIfRd8ZS7efGZtH3lbJSY6mbA2uN.klyEBdQElVAy", "Administrador", "admin"),
("user1@gmail.com", "$2a$12$Uz43.QaQePRviQGWolv8S.yNbGQyZ00CrbZ4VqWmLTKdwXCR.ShhK", "Juan Pérez", "user"),
("test_girl@hotmail.com", "$2a$12$5MtTooQ391AoM9zs41muvuxtQU9G.s7m98b5LARCN435nJblR0rRW", "María García", "user");';

if($db != null){
    try {
        $db->exec('PRAGMA foreign_keys = OFF;');
        $db->exec("DROP TABLE IF EXISTS price_history;");
        $db->exec("DROP TABLE IF EXISTS favorites;");
        $db->exec("DROP TABLE IF EXISTS sizes;");
        $db->exec("DROP TABLE IF EXISTS product;");
        $db->exec("DROP TABLE IF EXISTS users;");
        $db->exec('PRAGMA foreign_keys = ON;');

        $db->exec($sqlCreateUser);
        $db->exec($sqlCreateProduct);
        $db->exec($sqlCreatesizes);
        $db->exec($sqlCreatefavoritos);
        $db->exec($sqlCreateHistorialPrecios);
        
        // Insertamos los usuarios iniciales
        $db->exec($sqlInsertUsers);

        echo 'Base de datos creada e inicializada con éxito ✅';
    } catch (PDOException $e) {
        echo 'Error ejecutando el SQL: ' . $e->getMessage();
    }
} else {
    echo 'nooooo error de conexión';
}
?>