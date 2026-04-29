<?php
session_start();

include_once __DIR__ . '/../config/paths.php';
include_once PATH_BASE . 'includes/db_connect.php';

$id = $_POST['id'] ?? null;
$nombre = $_POST['nombre'];
$email = $_POST['email'];

if ($id) {
    // ACCIÓN: ACTUALIZAR
    $sql = "UPDATE users SET usu_name = ?, usu_mail = ? WHERE usu_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$nombre, $email, $id]);
    $_SESSION['mensaje_confirmacion'] = "Usuario actualizado";
} else {
    // ACCIÓN: CREAR NUEVO
    $nombreLimpio = strtolower(str_replace(' ', '', $nombre));

    $passwordPlana = $nombreLimpio . date("Y");

    $passwordHash = password_hash($passwordPlana, PASSWORD_DEFAULT);

    //echo "contrasena con el hash: " . $passwordHash;

    $sql = "INSERT INTO users (usu_name, usu_mail, usu_rol, usu_password) VALUES (?, ?, 'user', ?)";    
    $stmt = $db->prepare($sql);
    $stmt->execute([$nombre, $email, $passwordHash]);
    $_SESSION['mensaje_confirmacion'] = "Usuario creado con éxito";
   
}

header('Location:' . URL_BASE . 'views/panelAdmin.php');
exit;