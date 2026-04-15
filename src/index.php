<?php
include __DIR__ . '/config/paths.php';
include PATH_BASE . 'includes/db_connect.php';

include PATH_BASE . 'database/dbInit.php';

echo "<h1>¡Docker funcionando!</h1>";

echo "Ruta del navegador (URL_BASE): ";
var_dump(URL_BASE);

echo "<br>Ruta del sistema (PATH_BASE): ";
var_dump(PATH_BASE);

//phpinfo();
?>