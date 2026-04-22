<?php

include_once __DIR__ . '/../config/paths.php';

include_once PATH_BASE . 'includes/db_connect.php';

session_start();

if(!empty($_REQUEST['usu_mail']) && !empty($_REQUEST['usu_password'])){
    $mail = $_REQUEST['usu_mail'];
    $password = $_REQUEST['usu_password'];

    //echo $mail . "<br>";
    //echo $passwor;

}else{
    header('Location:' . URL_BASE . 'views/login.php');
    exit;
}

$stmt = $db->prepare("SELECT * FROM users WHERE usu_mail = :mail");
$stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
$result = $stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$_SESSION['autenticated']= false;

if($user){

    if(password_verify($password,$user['usu_password'])){
        $_SESSION['autenticated']= true;
        $_SESSION['id_user'] = $user['usu_id'];
        $_SESSION['mail_user'] = $user['usu_mail'];
        $_SESSION['name_user'] = $user['usu_name'];
        $_SESSION['rol_usu'] = $user['usu_rol'];

        if($_SESSION['rol_usu'] === 'admin'){
            header('Location:' . URL_BASE . 'views/panelAdmin.php');
            exit;
        }else{
            header('Location:' . URL_BASE . 'index.php');
            exit;
        }

    }else{
        $_SESSION['msgError']="Credenciales incorrectas";
        header('Location:' . URL_BASE . 'views/login.php');
        exit;
    }


}else{
    $_SESSION['msgError']="Credenciales incorrectas";
    header('Location:' . URL_BASE . 'views/login.php');
    exit;
}

?>