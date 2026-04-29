<?php
session_start();
include_once __DIR__ . '/../config/paths.php';
include_once PATH_BASE . 'includes/db_connect.php';
if(!isset($_SESSION['autenticated']) || $_SESSION['autenticated'] !== true){
    header('Location:' . URL_BASE . 'views/login.php');
    exit;
}

include PATH_BASE .'includes/header.php';


$id = $_REQUEST['id_user'] ?? null; // Capturamos el ID si existe
$usuario = null;

// Si hay ID, buscamos los datos actuales para rellenar el form
if ($id) {
    $stmt = $db->prepare("SELECT * FROM users WHERE usu_id = ?");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<form action="<?=URL_BASE?>actions/user_update.proc.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?php echo $usuario['usu_name'] ?? ''; ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $usuario['usu_mail'] ?? ''; ?>" required>

    <button type="submit">
        <?php echo $id ? 'Actualizar Usuario' : 'Crear Usuario'; ?>
    </button>
</form>