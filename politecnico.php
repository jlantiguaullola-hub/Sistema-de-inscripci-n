<?php
include("conexion.php");

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Tomar datos del formulario y limitar longitud
    $carrera  = substr($_POST['area'], 0, 50);  
    $nombre   = substr($_POST['nombre'], 0, 100);
    $apellido = substr($_POST['apellido'], 0, 100);
    $cedula   = substr($_POST['cedula'], 0, 20);
    $curso    = substr($_POST['curso'], 0, 50);
    $seccion  = substr($_POST['seccion'], 0, 10);
    $ano      = substr($_POST['ano_escolar'], 0, 20);

    // Verificar si la cédula ya existe
    $stmt_check = $conn->prepare("SELECT id FROM politecnico WHERE cedula = ?");
    $stmt_check->bind_param("s", $cedula);
    $stmt_check->execute();
    $stmt_check->store_result();

    if ($stmt_check->num_rows > 0) {
        $mensaje = "<div class='msg-error'>❌ La cédula ya está registrada</div>";
    } else {
        // Insertar nuevo registro
        $stmt_insert = $conn->prepare("INSERT INTO politecnico (nombre, apellido, cedula, tecnico, curso, seccion, ano_escolar) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt_insert->bind_param("sssssss", $nombre, $apellido, $cedula, $carrera, $curso, $seccion, $ano);

        if ($stmt_insert->execute()) {
            $mensaje = "<div class='msg-ok'>✔ Registrado correctamente en el área: " . htmlspecialchars($carrera) . "</div>";
        } else {
            $mensaje = "<div class='msg-error'>❌ Error en la consulta: " . $stmt_insert->error . "</div>";
        }

        $stmt_insert->close();
    }

    $stmt_check->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Salidas - Politécnico</title>
<style>
:root{
    --rojo: #6b0f1a;
    --rojo-oscuro: #4a0a12;
    --gris-claro: #f4f4f4;
    --blanco: #ffffff;
}
body{margin:0;padding:0;background: var(--gris-claro);font-family: "Segoe UI", Arial, sans-serif;}
.botones-top{position:absolute;top:20px;left:20px;display:flex;gap:10px;}
.botones-top a{background: var(--rojo);color:white;padding:10px 18px;text-decoration:none;font-weight:500;border-radius:6px;transition:.2s;}
.botones-top a:hover{background: var(--rojo-oscuro);}
.container{max-width:900px;margin:80px auto;background: var(--blanco);padding:30px;}
h2{color: var(--rojo);padding-bottom:5px;margin-bottom:25px;text-align:center;}
.areas{display:flex;justify-content:center;gap:30px;margin-bottom:30px;}
.opcion{width:45%;padding:25px;border:1px solid var(--rojo);color: var(--rojo);text-align:center;font-size:20px;font-weight:bold;cursor:pointer;transition:.2s;border-radius:8px;}
.opcion:hover{background: var(--rojo);color:white;}
.formulario{display:none;}
label{display:block;margin-bottom:5px;font-weight:600;color:#333;}
input, select{width:100%;padding:12px;border:1px solid #aaa;margin-bottom:15px;border-radius:5px;}
input:focus, select:focus{border:1px solid var(--rojo);outline:none;}
button{width:100%;padding:14px;background: var(--rojo);color:white;border:none;cursor:pointer;font-size:17px;border-radius:6px;}
button:hover{background: var(--rojo-oscuro);}
.msg-ok{background:#e6ffea;border-left:5px solid green;padding:10px;margin-bottom:15px;}
.msg-error{background:#ffe6e6;border-left:5px solid red;padding:10px;margin-bottom:15px;}
</style>
<script>
function mostrarFormulario(area) {
    document.getElementById("form-seleccion").style.display = "none";
    document.getElementById("tituloPrincipal").style.display = "none";
    document.getElementById("formulario").style.display = "block";
    document.getElementById("area").value = area;
    document.getElementById("titulo-area").innerText = "Registro de " + area;
}
</script>
</head>
<body>

<div class="botones-top">
    <a href="">↻ Volver</a>
    <a href="index.php">🏠 Ir al Index</a>
</div>

<div class="container">
    <h2 id="tituloPrincipal">Seleccione el Área del Politécnico</h2>
    <?= $mensaje ?>

    <div id="form-seleccion" class="areas">
        <div class="opcion" onclick="mostrarFormulario('Informática')">INFORMÁTICA</div>
        <div class="opcion" onclick="mostrarFormulario('Enfermería')">ENFERMERÍA</div>
    </div>

    <div id="formulario" class="formulario">
        <h2 id="titulo-area"></h2>
        <form method="POST">
            <input type="hidden" id="area" name="area">

            <label>Nombre</label>
            <input type="text" name="nombre" required>

            <label>Apellido</label>
            <input type="text" name="apellido" required>

            <label>Cédula</label>
            <input type="text" name="cedula" required>

            <label>Curso</label>
            <input type="text" name="curso" placeholder="Ej: 4to, 5to, 10-A" required>

            <label>Sección</label>
            <input type="text" name="seccion" required>

            <label>Año Escolar</label>
            <input type="text" name="ano_escolar" required>

            <button type="submit">Registrar</button>
        </form>
    </div>
</div>

</body>
</html>
