<?php
session_start();
require_once __DIR__ . '/../config/paths.php';


$whitelist = ['tiendarunning', 'atmosferasport'];
$validacionTienda = false;


if(isset($_POST['url']) && !empty($_POST['url']) ){
    $url_a_buscar = $_POST['url'];

    foreach($whitelist as $store){
        if(str_contains($url_a_buscar,$store)){
            $validacionTienda = true;
            break;
        }
    }

    if ($validacionTienda === true){
        $url = $url_a_buscar;

        $comando = 'python3 ' . PATH_BASE . 'scripts_python/scraper.py ' . escapeshellarg($url);
        $output = shell_exec($comando);

        // 3. Procesamiento del resultado
        $resultado = trim($output);
        $partes = explode(";", $resultado);

        if (count($partes) >= 4) {
            [$nombre, $rebajado, $original, $imagen] = $partes;

            $_SESSION['producto'] = [
                'nombre' => $nombre,
                'precioRebajado' => $rebajado,
                'precio' => $original,
                'imagen' => $imagen
            ];

            header('Location: ' . URL_BASE . 'views/dashboard.php');
            exit;
        }else {
            // Si Python no devolvió lo esperado
            $_SESSION['errorUrl'] = "No pudimos extraer datos de este producto.";
            header('Location: ' . URL_BASE . 'index.php');
            exit;
        }

    }else{
        $_SESSION['errorUrl'] = "Esa tienda aún no la tenemos, pero estamos trabajando en ello";
        header('Location:' . URL_BASE . 'index.php');
        exit;
    }

}else{
    $_SESSION['errorUrl'] = "Error en el envio de los datos";
    header('Location:' . URL_BASE . 'index.php');
    exit;
}

?>