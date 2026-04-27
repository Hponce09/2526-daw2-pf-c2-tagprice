<?php
// src/api/get_history.php
session_start();
require_once __DIR__ . '/../config/paths.php';
require_once PATH_BASE . 'includes/db_connect.php';

header('Content-Type: application/json');

// --- CAPA 1: Seguridad de Sesión ---
if (!isset($_SESSION['autenticated']) || $_SESSION['autenticated'] !== true) {
    http_response_code(403);
    echo json_encode(["error" => "Acceso denegado"]);
    exit;
}

// --- CAPA 2: Captura de ID ---
$id_producto = $_GET['id'] ?? null;

if (!$id_producto) {
    echo json_encode(["error" => "ID missing"]);
    exit;
}

// --- CAPA 3: Consulta Directa ---
$query = "SELECT precio, fecha_registro FROM price_history 
          WHERE id_product = :id 
          ORDER BY fecha_registro ASC";

$stmt = $db->prepare($query);
$stmt->bindParam(':id', $id_producto, PDO::PARAM_INT);
$stmt->execute();

$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Preparar los arrays para Chart.js
$labels = [];
$precios = [];

foreach ($datos as $fila) {
    // Formato de fecha corto (día/mes)
    $labels[] = date('d/m', strtotime($fila['fecha_registro']));
    $precios[] = (float)$fila['precio'];
}

// Devolver el JSON
echo json_encode([
    "labels" => $labels,
    "precios" => $precios
]);