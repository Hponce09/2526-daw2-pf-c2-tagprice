<?php
include_once __DIR__ . '/../config/paths.php';
 

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
    <input type="text" name="Name" placeholder="Name" required>

    <label for="email">Email:</label>
    <input type="email" name="email" placeholder="Email" required>

    <label for="password">Contraseña:</label>
    <input type="password" name="password" placeholder="Password" required>
    <input type="password" name="password_confirm" placeholder="Confirma" required>

    <button type="submit">Entrar</button>

</form>