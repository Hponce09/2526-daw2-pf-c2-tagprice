<?php
session_start();
include_once __DIR__ . '/../config/paths.php';
include_once PATH_BASE . 'includes/db_connect.php';
if(!isset($_SESSION['autenticated']) || $_SESSION['autenticated'] !== true){
    header('Location:' . URL_BASE . 'views/login.php');
    exit;
}

if(isset($_REQUEST["id_user"])){
    $id = $_REQUEST["id_user"];

    $stmt=$db->prepare('DELETE FROM users WHERE usu_id = :id_usu');
    $stmt->bindValue(':id_usu', $id, PDO::PARAM_INT);
    $stmt->execute();
    header('Location:' . URL_BASE . 'views/panelAdmin.php');
    exit;

}else{
    echo "ni veo el id";
}

?>