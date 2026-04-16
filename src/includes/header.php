<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TagPrice</title>
</head>
<body>
    
<header>

    <?php
        $homeLink = URL_BASE . "index.php";
        if(isset($_SESSION['rol_usu'])){
            $homeLink = ($_SESSION['rol_usu'] == 'admin')
                ? URL_BASE . "views/panelAdmin.php"
                : URL_BASE . "index.php";;
        }
    ?>

    <div>
        <a href="<?= $homeLink ?>">
            <span>TagPrice</span>
        </a>
    </div>

    <?php   if(isset($_SESSION['autenticated']) && $_SESSION['autenticated'] === true): ?>

        <span><?= $_SESSION['name_user'] ?></span>
        <a href="<?=URL_BASE?>actions/logout.php">logout</a>

    <?php else: ?>

        <a href="<?= URL_BASE; ?>views/login.php">login</a>

    <?php endif;    ?>



</header>