<?php
require_once "conexion.php";

if (!isset($conn) || !($conn instanceof mysqli)) {
    die("Error de conexión");
}

$mensaje = "";

// Cargar datos actuales (si existen)
$datos = [
    "nombre" => "",
    "telefono" => "",
    "email" => "",
    "direccion" => "",
    "sitio_web" => "",
    "logo" => ""
];

$consulta = $conn->query("SELECT * FROM configuracion LIMIT 1");
if ($consulta && $consulta->num_rows > 0) {
    $datos = $consulta->fetch_assoc();
}

/* ---------- GUARDAR / ACTUALIZAR ---------- */
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nombre     = trim($_POST["nombre"] ?? "");
    $telefono   = trim($_POST["telefono"] ?? "");
    $email      = trim($_POST["email"] ?? "");
    $direccion  = trim($_POST["direccion"] ?? "");
    $sitio_web  = trim($_POST["sitio_web"] ?? "");

    $errores = [];

    if ($nombre === "") {
        $errores[] = "El nombre es obligatorio.";
    }

    if ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "Correo inválido.";
    }

    /*========= LOGO =========*/
    $logo_db = null;

    if (!empty($_FILES["logo"]["name"])) {

        $permitidos = ["image/jpeg","image/png","image/jpg","image/webp"];

        if (!in_array($_FILES["logo"]["type"], $permitidos)) {
            $errores[] = "Formato de imagen no permitido.";
        } else {
            $carpeta = "uploads/logos/";

            if (!is_dir($carpeta)) {
                mkdir($carpeta, 0777, true);
            }

            $ext = pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION);
            $nuevoNombre = time() . "_" . uniqid() . "." . $ext;

            if (move_uploaded_file($_FILES["logo"]["tmp_name"], $carpeta . $nuevoNombre)) {
                $logo_db = $carpeta . $nuevoNombre;
            } else {
                $errores[] = "No se pudo subir el logo.";
            }
        }
    }

    if (empty($errores)) {

        // Ver si ya hay registro
        $check = $conn->query("SELECT id FROM configuracion LIMIT 1");

        if ($check && $check->num_rows > 0) {

            $row = $check->fetch_assoc();
            $id = $row["id"];

            if ($logo_db) {
                $sql = "UPDATE configuracion 
                        SET nombre=?, telefono=?, email=?, direccion=?, sitio_web=?, logo=?
                        WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssssssi",
                    $nombre, $telefono, $email, $direccion, $sitio_web, $logo_db, $id
                );
            } else {
                $sql = "UPDATE configuracion 
                        SET nombre=?, telefono=?, email=?, direccion=?, sitio_web=?
                        WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("sssssi",
                    $nombre, $telefono, $email, $direccion, $sitio_web, $id
                );
            }

        } else {

            $sql = "INSERT INTO configuracion
                    (nombre, telefono, email, direccion, sitio_web, logo)
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssss",
                $nombre, $telefono, $email, $direccion, $sitio_web, $logo_db
            );
        }

        if ($stmt->execute()) {
            $mensaje = "✅ Configuración guardada correctamente";
            header("Refresh:0");
        } else {
            $mensaje = "❌ Error: " . $stmt->error;
        }

        $stmt->close();

    } else {
        $mensaje = implode("<br>", $errores);
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Configuración</title>

<style>
body{
    font-family: "Segoe UI", Arial;
    margin:0;
    padding:0;
    background:#ffffff;
}

/* BOTÓN VOLVER - ESTILO CONSISTENTE */
.btn-volver{
    position: absolute;       /* Fijado en la esquina superior izquierda */
    top: 20px;
    left: 20px;
    background: #7a0f1b;      /* Color principal */
    color: white;             /* Texto blanco */
    padding: 10px 18px;       /* Espaciado */
    text-decoration: none;    /* Sin subrayado */
    border-radius: 5px;       /* Bordes redondeados */
    font-weight: bold;
    font-size: 16px;
    transition: 0.2s;
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}
.btn-volver:hover{
    background: #5a0a14;      /* Hover más oscuro */
    transform: translateY(-1px);
}

/* CONTENEDOR */
.container{
    width:90%;
    max-width:850px;
    margin:80px auto;
    padding:35px 40px;
    background:#fff;
    border-radius:15px;
    box-shadow: 0 10px 25px rgba(0,0,0,.08);
}

h2{
    text-align:center;
    margin-bottom:25px;
    color:#7a0f1b;
}

.form-row{
    display:flex;
    gap:25px;
    margin-bottom:18px;
}

.form-group{
    width:100%;
}

label{
    font-weight:600;
    display:block;
    margin-bottom:6px;
}

input{
    width:100%;
    padding:12px;
    border-radius:8px;
    border:1px solid #ccc;
    outline:none;
}

input:focus{
    border-color:#7a0f1b;
}

button{
    width:100%;
    padding:14px;
    margin-top:15px;
    border:none;
    border-radius:10px;
    background:#7a0f1b;
    color:white;
    font-size:16px;
    cursor:pointer;
}

button:hover{
    background:#8f1d2a;
}

.mensaje{
    margin-top:20px;
    padding:15px;
    text-align:center;
    border-radius:8px;
    background:#e8ffe8;
    color:#0b7a0b;
}

.logo-preview{
    text-align:center;
    margin-top:10px;
}

.logo-preview img{
    max-width:120px;
}
</style>

</head>

<body>

<a href="index.php" class="btn-volver">← Volver</a>

<div class="container">
    <h2>Configurar Centro Educativo</h2>

    <form method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($datos['nombre']) ?>">
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Teléfono</label>
                <input type="text" name="telefono" value="<?= htmlspecialchars($datos['telefono']) ?>">
            </div>

            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($datos['email']) ?>">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label>Dirección</label>
                <input type="text" name="direccion" value="<?= htmlspecialchars($datos['direccion']) ?>">
            </div>

            <div class="form-group">
                <label>Sitio web</label>
                <input type="text" name="sitio_web" value="<?= htmlspecialchars($datos['sitio_web']) ?>">
            </div>
        </div>

        <div class="form-group">
            <label>Logo</label>
            <input type="file" name="logo" accept="image/*">
        </div>

        <?php if(!empty($datos['logo'])): ?>
        <div class="logo-preview">
            <img src="fe.png">
        </div>
        <?php endif; ?>

        <button type="submit">Guardar cambios</button>

        <?php if($mensaje): ?>
            <div class="mensaje"><?= $mensaje ?></div>
        <?php endif; ?>

    </form>

</div>

</body>
</html>
