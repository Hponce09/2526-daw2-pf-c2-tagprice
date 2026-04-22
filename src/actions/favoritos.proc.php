<?php
session_start();
require_once __DIR__ . '/../config/paths.php';
include_once PATH_BASE . 'includes/db_connect.php';

if(!isset($_SESSION['autenticated']) || $_SESSION['autenticated'] !== true){
    header('Location:' . URL_BASE . 'views/login.php');
    exit;
}


if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: ' . URL_BASE . 'index.php');
    exit; 
}
// 2. Recoger datos del formulario
$nombre = $_POST['nombre'] ?? '';
$precio = $_POST['precio'] ?? 0;
$imagen = $_POST['imagen'] ?? '';
$url    = $_POST['url'] ?? '';
$usu_id = $_SESSION['id_user'];
// 3. Buscar si el producto ya existe
$stmt = $db->prepare("SELECT product_id FROM product WHERE url_compra = :url");
$stmt->bindValue(':url', $url, PDO::PARAM_STR);
$stmt->execute();
$producto_existente = $stmt->fetch(PDO::FETCH_ASSOC);

if ($producto_existente) {
    // Si ya existe, guardamos su ID
    $product_id = $producto_existente['product_id'];
} else {
    // 4. Si no existe, lo insertamos en la tabla 'product'
    $sqlProd = "INSERT INTO product (nombre, imagen, url_compra, precio_actual) 
                VALUES (:nombre, :imagen, :url, :precio)";
    $stmtProd = $db->prepare($sqlProd);
    $stmtProd->bindValue(':nombre', $nombre, PDO::PARAM_STR);
    $stmtProd->bindValue(':imagen', $imagen, PDO::PARAM_STR);
    $stmtProd->bindValue(':url', $url, PDO::PARAM_STR);
    $stmtProd->bindValue(':precio', $precio, PDO::PARAM_STR);
    $stmtProd->execute();
    
    // Obtenemos el ID que se acaba de generar
    $product_id = $db->lastInsertId();

    // Insertamos el primer registro en el historial para la gráfica
    $stmtHist = $db->prepare("INSERT INTO price_history (id_product, precio) VALUES (:id, :precio)");
    $stmtHist->bindValue(':id', $product_id, PDO::PARAM_INT);
    $stmtHist->bindValue(':precio', $precio, PDO::PARAM_STR);
    $stmtHist->execute();
}

// 5. Verificar si ya es favorito para no duplicar la relación
$stmtFavCheck = $db->prepare("SELECT * FROM favorites WHERE usu_id = :usu_id AND product_id = :prod_id");
$stmtFavCheck->bindValue(':usu_id', $usu_id, PDO::PARAM_INT);
$stmtFavCheck->bindValue(':prod_id', $product_id, PDO::PARAM_INT);
$stmtFavCheck->execute();

if (!$stmtFavCheck->fetch(PDO::FETCH_ASSOC)) {
    // 6. Insertar en la tabla de favoritos
    $stmtFav = $db->prepare("INSERT INTO favorites (usu_id, product_id) VALUES (:usu_id, :prod_id)");
    $stmtFav->bindValue(':usu_id', $usu_id, PDO::PARAM_INT);
    $stmtFav->bindValue(':prod_id', $product_id, PDO::PARAM_INT);
    $stmtFav->execute();
}

// Redirigir directamente a la web de favoritos
header('Location: ' . URL_BASE . 'views/favoritos.php');
exit;

?>