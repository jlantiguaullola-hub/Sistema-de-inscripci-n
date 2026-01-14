<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login_registro.php");
    exit();
}
?>
<h2>Bienvenido, <?php echo $_SESSION['usuario']; ?></h2>
<p>Tu rol es: <?php echo $_SESSION['rol']; ?></p>
