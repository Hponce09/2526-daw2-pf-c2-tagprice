<?php
include_once __DIR__ . '/../config/paths.php';
 

?>
<form action="<?=URL_BASE?>actions/login.proc.php" method="Post">
    <label for="email">Email:</label>
    <input type="email" name="usu_mail" id="email" required>
    
    <label for="password">Contraseña:</label>
    <input type="password" name="usu_password" id="password" required>
    
    <button type="submit">Entrar</button>

</form>