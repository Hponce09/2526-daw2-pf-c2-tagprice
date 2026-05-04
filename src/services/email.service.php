<?php
// src/services/email.service.php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Envía una alerta de bajada de precio
 */
function enviarAlertaPrecio($emailDestino, $nombreProducto, $precioViejo, $precioNuevo) {
    $mail = new PHPMailer(true);

    try {
        // Configuración Servidor
        $mail->isSMTP();
        $mail->Host       = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ad513ec4d5efd4'; 
        $mail->Password   = '106439df772d9b'; // Usa tu password real
        $mail->Port       = 2525;

        // Destinatarios
        $mail->setFrom('alertas@tagprice.com', 'TagPrice Alertas');
        $mail->addAddress($emailDestino);

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = "¡BAJADA DE PRECIO! - " . $nombreProducto;
        
        // Un diseño sencillo pero efectivo
        $mail->Body = "
            <div style='font-family: sans-serif; border: 1px solid #ddd; padding: 20px; border-radius: 10px;'>
                <h2 style='color: #2ecc71;'>¡Buenas noticias!</h2>
                <p>El producto <strong>$nombreProducto</strong> ha bajado de precio.</p>
                <p style='font-size: 1.2em;'>
                    Antes: <span style='text-decoration: line-through; color: #e74c3c;'>$precioViejo €</span><br>
                    <b>Ahora: <span style='color: #2ecc71;'>$precioNuevo €</span></b>
                </p>
                <a href='#' style='display: inline-block; padding: 10px 20px; background-color: #2ecc71; color: white; text-decoration: none; border-radius: 5px;'>Ver producto</a>
            </div>
        ";

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Error enviando mail: " . $mail->ErrorInfo);
        return false;
    }
}