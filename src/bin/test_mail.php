<?php
require_once '/var/www/html/services/email.service.php';

echo "Lanzando prueba de correo...\n";

// Asegúrate de poner un correo real o el de Mailtrap aquí
$emailDestino = 'tu_correo@ejemplo.com'; 
$producto = 'Nike Pegasus ¡Prueba! €';
$precioV = '149.99';
$precioN = '139.99';
$url_de_prueba ='https://www.atmosferasport.es/adidas/camiseta-adidas-replica-messi-argentina-26-infantil-azul-159220.html';

// Pasamos las variables
if (enviarAlertaPrecio($emailDestino, $producto, $precioV, $precioN, $url_de_prueba)) {
    echo "¡Éxito! Revisa Mailtrap.\n";
} else {
    echo "Error en el envío.\n";
}