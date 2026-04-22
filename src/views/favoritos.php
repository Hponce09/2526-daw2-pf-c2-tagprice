<?php
session_start();
require_once __DIR__ . '/../config/paths.php';
include_once PATH_BASE . 'includes/db_connect.php';

if(!isset($_SESSION['autenticated']) || $_SESSION['autenticated'] !== true){
    header('Location:' . URL_BASE . 'views/login.php');
    exit;
}

include PATH_BASE .'includes/header.php';

$usu_id = $_SESSION['id_user'];

$sql = "SELECT p.product_id, p.nombre, p.imagen, p.precio_actual, f.fecha_agregado 
        FROM product p
        INNER JOIN favorites f ON p.product_id = f.product_id
        WHERE f.usu_id = :usu_id
        ORDER BY f.fecha_agregado DESC";

$stmt = $db->prepare($sql);
$stmt->bindValue(':usu_id', $usu_id, PDO::PARAM_INT);
$stmt->execute();

$mis_favoritos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<main style="display: flex; flex-wrap: wrap; gap: 20px; padding: 20px;">
<?php if (!$mis_favoritos): ?>
            <p>Aún no tienes productos en tu lista de seguimiento.</p>
        <?php else: ?>
            <?php foreach ($mis_favoritos as $prod): ?>
                <div class="card" style="border: 1px solid #ddd; padding: 15px; border-radius: 8px; width: 200px; text-align: center;">
                    <img src="<?= $prod['imagen'] ?>" alt="Producto" style="width: 100%; border-radius: 5px;">
                    <h3 style="font-size: 1rem;"><?= htmlspecialchars($prod['nombre']) ?></h3>
                    <p style="font-weight: bold; color: #2c3e50;"><?= $prod['precio_actual'] ?> €</p>
                    <small>Guardado el: <?= $prod['fecha_agregado'] ?></small>
                    
                    <div style="margin-top: 10px;">
                        <a href="detalle_producto.php?id=<?= $prod['product_id'] ?>" 
                           style="background: #3498db; color: white; padding: 5px 10px; text-decoration: none; border-radius: 4px; font-size: 0.8rem;">
                           Ver Historial
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>


