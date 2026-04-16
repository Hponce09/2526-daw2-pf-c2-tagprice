<?php
include_once __DIR__ . '/../config/paths.php';

session_start();

if(isset($_SESSION['errUserRegistre'])){
    
    $errorRegistre = $_SESSION['errUserRegistre'];

    echo $errorRegistre;

    session_unset();
}elseif(isset($_SESSION['msgError'])){

    $errorLogin = $_SESSION['msgError'];
    echo $errorLogin;
    session_unset();
}

?>
<h2>iniciar</h2>

<form action="<?=URL_BASE?>actions/login.proc.php" method="Post">
    <label for="email">Email:</label>
    <input type="email" name="usu_mail" id="email" required>
    
    <label for="password">Contraseña:</label>
    <input type="password" name="usu_password" id="password" required>
    
    <button type="submit">Entrar</button>

</form>

<h2>registro</h2>

<form action="<?=URL_BASE?>actions/registre.proc.php" method="Post">

    <label for="name">Name:</label>
    <input type="text" name="name" placeholder="Name" required>

    <label for="email">Email:</label>
    <input type="email" name="email" placeholder="Email" required>

    <label for="password">Contraseña:</label>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password_confirm" placeholder="Confirma" required>

    <button type="submit">Entrar</button>

</form>