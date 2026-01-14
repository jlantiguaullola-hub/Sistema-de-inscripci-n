<?php
include("conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Secretaria</title>

    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: #fff7e6;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 450px;
            margin: 50px auto;
            padding: 30px;
            background: #ffffff;
            border-radius: 15px;
            border: 2px solid #ffd9a3;
            box-shadow: 0 0 15px rgba(255, 165, 60, 0.2);
        }

        h2 {
            text-align: center;
            color: #b56800;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
            color: #b56800;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ffce94;
            border-radius: 8px;
            background: #fff4e2;
            transition: 0.3s;
        }

        input:focus {
            border-color: #ffb766;
            background: #ffe8cc;
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #ff9900;
            border: none;
            color: white;
            font-size: 17px;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #e68a00;
        }

        .mensaje {
            margin-top: 20px;
            padding: 15px;
            background: #fff5e6;
            border: 1px solid #ffd9a3;
            border-radius: 10px;
            color: #b56800;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Formulario de Secretaria</h2>

    <form method="POST">

        <label>Nombre Completo:</label>
        <input type="text" name="nombre_completo" required>

        <label>Correo Electrónico:</label>
        <input type="email" name="correo" required>

        <label>Teléfono:</label>
        <input type="text" name="telefono" required>

        <label>Usuario:</label>
        <input type="text" name="usuario" required>

        <label>Contraseña:</label>
        <input type="password" name="contrasena" required>

        <button type="submit">Guardar Secretaria</button>
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $nombre_completo = $_POST['nombre_completo'];
        $correo          = $_POST['correo'];
        $telefono        = $_POST['telefono'];
        $usuario         = $_POST['usuario'];
        $contrasena      = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO secretarias (nombre_completo, correo, telefono, usuario, contrasena)
                VALUES ('$nombre_completo', '$correo', '$telefono', '$usuario', '$contrasena')";

        if ($conn->query($sql)) {
            echo "<div class='mensaje'>¡Secretaria registrada correctamente!</div>";
        } else {
            echo "<div class='mensaje'>Error SQL: " . $conn->error . "</div>";
        }
    }
    ?>

</div>

</body>
</html>