<?php
require_once __DIR__ . '/../config/paths.php';

session_start();
if(!isset($_SESSION['autenticated']) || $_SESSION['autenticated'] !== true){
    header('Location:' . URL_BASE . 'views/login.php');
    exit;
}

$mensaje = $_SESSION['mensaje_confirmacion'] ?? null;
if($mensaje) unset($_SESSION['mensaje_confirmacion']);

include PATH_BASE .'includes/header.php';
include_once PATH_BASE . 'includes/db_connect.php'; 

$sql = $db->prepare("SELECT usu_id, usu_mail, usu_name, usu_rol FROM users");

if($sql->execute()){
?>

    <?php if($mensaje): ?>
        <div class="bg-red-500/10 border border-red-500/20 text-red-400 text-[11px] font-bold uppercase tracking-wider p-3 rounded-xl mb-6 flex items-center gap-2">
            <span class="w-1.5 h-1.5 bg-red-500 rounded-full animate-pulse"></span>
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>
    <div class="mb-4">
        <a href="<?=URL_BASE?>views/user_uptade.php" class="btn">Nuevo Usuario</a>
    </div>

    <?php while($file = $sql->fetch(PDO::FETCH_ASSOC)): 
        // 1. Corregido: El nombre de la variable debe coincidir (usaremos $esAdmin)
        $esAdmin = ($file['usu_rol'] === 'admin');
    ?>
        <div class="user-card mb-6 p-4 border rounded">
            <p><strong>ID:</strong> <?=$file['usu_id']?></p>
            <p><strong>Nombre:</strong> <?=$file['usu_name']?></p>
            <p><strong>Email:</strong> <?=$file['usu_mail']?></p>
            <p><strong>Rol:</strong> <?=$file['usu_rol']?></p>

            <?php if (!$esAdmin): ?>
                <div class="flex gap-2">
                    <form action="<?= URL_BASE ?>views/user_uptade.php" method="post">
                        <input type="hidden" name="id_user" value="<?= $file['usu_id'] ?>">
                        <button type="submit" class="bg-blue-100 text-blue-700 px-4 py-2 rounded-md">Editar</button>
                    </form>
                    
                    <form action="<?= URL_BASE ?>actions/user_delete.proc.php" method="post">
                        <input type="hidden" name="id_user" value="<?= $file['usu_id'] ?>">
                        <button type="submit" class="bg-red-100 text-red-700 px-4 py-2 rounded-md" 
                                onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                    </form>
                </div>
            <?php else: ?>
                <span class="text-gray-500 italic">Cuenta de Administrador protegida</span>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>

<?php
} else {
    echo "error en la consulta";
}
?>