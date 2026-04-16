<?php

include_once __DIR__ . '/../config/paths.php';

include_once PATH_BASE . 'includes/db_connect.php';

session_start();

if(!empty($_REQUEST['email']) && !empty($_REQUEST['password'])){
    $mail = $_REQUEST['email'];
    $password = $_REQUEST['password'];
    $passwordConfirm = $_REQUEST['password_confirm'];
    $name = $_REQUEST['name'];
    $rol = 'user';


    //echo $mail . "<br>";
    //echo $password . "<br>";
    //echo $passwordConfirm . "<br>";
    //echo $name;

}else{
    header('Location:' . URL_BASE . 'views/login.php');
    exit;
}

if($password === $passwordConfirm){
    $passworSuccess = password_hash($password, PASSWORD_DEFAULT);
    //echo "contrasena confirmada y hasheada: ".$passworSuccess;

    $stmt = $db->prepare("SELECT * FROM users WHERE usu_mail = :mail");
    $stmt->bindValue(':mail', $mail, PDO::PARAM_STR);
    $result = $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user){
        $_SESSION['errUserRegistre']="Email ya registrado";
        header('Location:' . URL_BASE . 'views/login.php');
        exit;
    }else{
        $stmtInsertUsers = $db->prepare("INSERT INTO users(usu_mail,usu_password,usu_name,usu_rol) VALUES(:mail, :usu_password, :name, :rol)");
        $stmtInsertUsers -> bindValue('mail', $mail, PDO::PARAM_STR);
        $stmtInsertUsers -> bindValue(':usu_password', $passworSuccess, PDO::PARAM_STR);
        $stmtInsertUsers -> bindValue(':name', $name, PDO::PARAM_STR);
        $stmtInsertUsers -> bindValue(':rol', $rol, PDO::PARAM_STR);
        $stmtInsertUsers->execute();
        
        $usu_id_added= $db->lastInsertId();

        $_SESSION['autenticated']= true;
        $_SESSION['id_user'] = $usu_id_added;
        $_SESSION['mail_user'] = $mail;
        $_SESSION['name_user'] = $name;
        $_SESSION['rol_usu'] = $rol;
        header('Location:' . URL_BASE . 'views/dashboard.php');
        exit;


    }

        
}else{
    $_SESSION['errUserRegistre']="La contraseña no concide";
    header('Location:' . URL_BASE . 'views/login.php');
    exit;
}



?>