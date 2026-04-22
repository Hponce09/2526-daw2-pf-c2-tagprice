<?php

require_once __DIR__ . '/../config/paths.php';

session_start();
if(!isset($_SESSION['producto'])){
    header('Location:' . URL_BASE . 'index.php');
    exit;
}

include PATH_BASE .'includes/header.php';

if(isset($_SESSION['producto'])){
    ?>

    <div style="max-width: 400px; margin: auto; text-align: center; border: 1px solid #ddd; padding: 20px; border-radius: 10px;">
        <img src="<?php echo $_SESSION['producto']['imagen']; ?>" style="width: 100%; border-radius: 8px;">
        <h2><?php echo htmlspecialchars($_SESSION['producto']['nombre']); ?></h2>
        
        <div style="background: #f4f4f4; padding: 15px; border-radius: 8px;">
            <?php if ((float)$_SESSION['producto']['precio'] > (float)$_SESSION['producto']['precioRebajado']): ?>
                <p style="text-decoration: line-through; color: #777; margin: 0;">Antes: <?php echo $_SESSION['producto']['precio']; ?> €</p>
                <p style="font-size: 24px; color: #d9534f; font-weight: bold; margin: 5px 0;">Ahora: <?php echo $_SESSION['producto']['precioRebajado']; ?> €</p>
            <?php else: ?>
                <p style="font-size: 24px; color: #333; font-weight: bold;">Precio: <?php echo $_SESSION['producto']['precioRebajado']; ?> €</p>
            <?php endif; ?>
        </div>
        
        <br>
    </div>



<?php
}

?>