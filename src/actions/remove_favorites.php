<?php
session_start();
require_once __DIR__ . '/../config/paths.php';
include_once PATH_BASE . 'includes/db_connect.php';

if (isset($_REQUEST['id'])){

    $product_id = $_REQUEST['id'];
    $user_id = $_SESSION['id_user'];
    //echo $_SESSION['name_user'] . "<br>";

    $stmt =$db->prepare("DELETE FROM favorites WHERE usu_id = ? AND product_id = ?");

    if ($stmt->execute([$user_id, $product_id])) {
        // Guardamos el mensaje en la sesión
        $_SESSION['mensaje'] = "Producto eliminado de tus favoritos.";
        $_SESSION['tipo_mensaje'] = "success"; // Para el color verde
    } else {
        $_SESSION['mensaje'] = "Error al intentar eliminar el producto.";
        $_SESSION['tipo_mensaje'] = "error"; // Para el color rojo
    }

    header("Location: " . URL_BASE . "views/favoritos.php");
    exit();

}else{
    header("Location: " . URL_BASE . "views/favoritos.php");
    exit();
}

?>