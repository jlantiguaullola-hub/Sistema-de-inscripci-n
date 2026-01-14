<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Registro de Usuario</title>

<style>
body {
    background: #f0f0f0;
    font-family: Arial;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
.container {
    width: 430px;
    background: #fff;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 0 12px rgba(0,0,0,0.15);
    text-align: center;
}
img.logo { width: 180px; margin-bottom: 15px; }
h2 { margin-bottom: 20px; }
input, select {
    width: 100%; padding: 12px; margin: 7px 0; border: 1px solid #ccc; border-radius: 6px;
}
button {
    width: 100%; padding: 12px; background: #d41a1a; border: none; border-radius: 6px;
    color: #fff; cursor: pointer; margin-top: 10px; font-size: 16px;
}
button:hover { background: #b91414; }
a { display: block; margin-top: 10px; color: #d41a1a; font-weight: bold; }
.mensaje { font-weight: bold; margin-bottom: 10px; color: red; }
</style>

</head>
<body>

<div class="container">

    <img src="fe.png" class="logo">
    <h2>Registro de usuarios</h2>

    <?php if (isset($_GET['msg'])): ?>
        <p class="mensaje">
            <?php
                if ($_GET['msg']=='correo_existente') echo "Este correo ya está registrado.";
                if ($_GET['msg']=='error_bd') echo "Error al registrar. Intente nuevamente.";
            ?>
        </p>
    <?php endif; ?>

    <form action="procesar.php" method="POST">

        <input type="text" name="nombre_usuario" placeholder="Nombre completo" required>
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="contraseña" placeholder="Contraseña" required>

        <select name="rol" required>
            <option value="">Seleccione Rol</option>
            <option value="Administrador">Administrador</option>
            <option value="Secretario">Secretario</option>
            <option value="Docentes">Docentes</option>
            <option value="Estudiantes">Estudiantes</option>
            <option value="Tutores">Tutores</option>
        </select>

        <button type="submit" name="registrar">Registrar</button>
    </form>

    <a href="login.php">¿Ya tienes cuenta? Inicia sesión</a>

</div>

</body>
</html>
