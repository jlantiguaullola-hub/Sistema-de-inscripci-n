<?php
include("conexion.php");
$mensaje = "";
$editarEstudiante = null;

/* -------- GUARDAR -------- */
if (isset($_POST['guardar'])) {
    $stmt = $conn->prepare("
        INSERT INTO estudiantes
        (rnc, correo, telefono, direccion, modalidad, grado, seccion, profesor, nombre_completo, fecha_nacimiento)
        VALUES (?,?,?,?,?,?,?,?,?,?)
    ");
    $stmt->bind_param(
        "ssssssssss",
        $_POST['rnc'],
        $_POST['correo'],
        $_POST['telefono'],
        $_POST['direccion'],
        $_POST['modalidad'],
        $_POST['grado'],
        $_POST['seccion'],
        $_POST['profesor'],
        $_POST['nombre_completo'],
        $_POST['fecha_nacimiento']
    );

    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;font-weight:bold;'>✔ Estudiante registrado correctamente</div>";
    } else {
        $mensaje = "<div style='color:red;'>❌ Error: ".$stmt->error."</div>";
    }
    $stmt->close();
}

/* -------- EDITAR -------- */
if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    $res = $conn->query("SELECT * FROM estudiante WHERE idestudiantes=$id");
    $editarEstudiante = $res->fetch_assoc();
}

/* -------- ACTUALIZAR -------- */
if (isset($_POST['actualizar'])) {
    $stmt = $conn->prepare("
        UPDATE estudiante
        SET rnc=?, correo=?, telefono=?, direccion=?, modalidad=?, grado=?, seccion=?, profesor=?, nombre_completo=?, fecha_nacimiento=?
        WHERE idestudiantes=?
    ");
    $stmt->bind_param(
        "ssssssssssi",
        $_POST['rnc'],
        $_POST['correo'],
        $_POST['telefono'],
        $_POST['direccion'],
        $_POST['modalidad'],
        $_POST['grado'],
        $_POST['seccion'],
        $_POST['profesor'],
        $_POST['nombre_completo'],
        $_POST['fecha_nacimiento'],
        $_POST['idestudiantes']
    );

    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;font-weight:bold;'>✔ Estudiante actualizado</div>";
    }
    $stmt->close();
}

/* -------- ELIMINAR -------- */
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conn->query("DELETE FROM estudiante WHERE idestudiantes=$id");
    $mensaje = "<div style='color:green;font-weight:bold;'>✔ Estudiante eliminado</div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Estudiantes</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

<style>
:root{
    --rojo:#6b0f1a;
    --rojo-oscuro:#4a0a12;
    --gris:#d0d0d0;
}

body{
    margin:0;
    font-family:"Segoe UI", Arial, sans-serif;
    background:#f2f2f2;
    padding:20px;
    display:flex;
    justify-content:center;
}

.form-wrapper{
    width:100%;
    max-width:1100px;
    margin:120px auto 0 auto;
    background:var(--gris);
    border-radius:8px;
    overflow:hidden;
    box-shadow:0 0 10px rgba(0,0,0,0.15);
}

.form-header{
    background:linear-gradient(to right,var(--rojo),var(--rojo-oscuro));
    color:white;
    padding:20px;
    font-size:26px;
    font-weight:bold;
    display:flex;
    align-items:center;
    gap:10px;
    text-transform:uppercase;
}

.form-body{
    padding:30px;
    text-align:center;
}

.form-grid{
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap:20px;
}

.form-group{
    display:flex;
    flex-direction:column;
    align-items:center;
}

.form-group label{
    font-weight:bold;
    margin-bottom:6px;
}

.input-icon{
    display:flex;
    align-items:center;
    background:white;
    border-radius:8px;
    border:1px solid #aaa;
    overflow:hidden;
    width:100%;
    max-width:380px;
}

.input-icon i{
    padding:10px;
    background:#eee;
    color:var(--rojo);
    min-width:40px;
    text-align:center;
}

.input-icon input{
    border:none;
    outline:none;
    padding:10px;
    width:100%;
}

.form-actions{
    margin-top:30px;
    display:flex;
    gap:15px;
}

.form-actions button,
.form-actions a{
    padding:12px 22px;
    border:none;
    border-radius:8px;
    font-size:16px;
    cursor:pointer;
    text-decoration:none;
    color:white;
}

.btn-guardar{ background:green; }
.btn-volver{ background:var(--rojo); }
.btn-toggle{ background:#333; }

.table-wrapper{
    margin:40px auto;
    max-width:1000px;
    background:white;
    border-radius:10px;
    padding:20px;
    display:none;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #ccc;
}

th{ background:var(--rojo); color:white; }

a.action{
    text-decoration:none;
    color:white;
    padding:6px 10px;
    border-radius:5px;
}

.edit{ background:green; }
.delete{ background:red; }

@media(max-width:900px){
    .form-grid{ grid-template-columns:1fr; }
}
</style>

<script>
function toggleLista(){
    let tabla = document.getElementById("tablaEstudiantes");
    tabla.style.display = tabla.style.display === "none" ? "block" : "none";
}
</script>

</head>
<body>

<div class="form-wrapper">

    <div class="form-header">
        <i class="fa-solid fa-user-graduate"></i> Estudiantes
    </div>

    <div class="form-body">
        <?= $mensaje ?>

        <form method="POST">
            <div class="form-grid">

                <div class="form-group">
                    <label>RNC</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-id-card"></i>
                        <input type="text" name="rnc" value="<?= $editarEstudiante['rnc'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Correo</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="correo" required value="<?= $editarEstudiante['correo'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Teléfono</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="telefono" required value="<?= $editarEstudiante['telefono'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Dirección</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-map-marker-alt"></i>
                        <input type="text" name="direccion" required value="<?= $editarEstudiante['direccion'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Modalidad</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-school"></i>
                        <input type="text" name="modalidad" value="<?= $editarEstudiante['modalidad'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Grado</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <input type="text" name="grado" value="<?= $editarEstudiante['grado'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Sección</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-chalkboard"></i>
                        <input type="text" name="seccion" value="<?= $editarEstudiante['seccion'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Profesor</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-user-tie"></i>
                        <input type="text" name="profesor" value="<?= $editarEstudiante['profesor'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Nombre completo</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="nombre_completo" required value="<?= $editarEstudiante['nombre_completo'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Fecha de nacimiento</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-calendar"></i>
                        <input type="date" name="fecha_nacimiento" required value="<?= $editarEstudiante['fecha_nacimiento'] ?? '' ?>">
                    </div>
                </div>

            </div>

            <div class="form-actions">
                <?php if($editarEstudiante): ?>
                    <input type="hidden" name="idestudiantes" value="<?= $editarEstudiante['idestudiantes'] ?>">
                    <button class="btn-guardar" name="actualizar">
                        <i class="fa-solid fa-check"></i> Actualizar
                    </button>
                <?php else: ?>
                    <button class="btn-guardar" name="guardar">
                        <i class="fa-solid fa-check"></i> Guardar
                    </button>
                <?php endif; ?>

                <button type="button" class="btn-toggle" onclick="toggleLista()">
                    <i class="fa-solid fa-table"></i> Ver lista
                </button>

                <a href="index.php" class="btn-volver">
                    <i class="fa-solid fa-arrow-left"></i> Volver
                </a>
            </div>
        </form>

        <!-- TABLA -->
        <div class="table-wrapper" id="tablaEstudiantes">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>RNC</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Dirección</th>
                        <th>Modalidad</th>
                        <th>Grado</th>
                        <th>Sección</th>
                        <th>Profesor</th>
                        <th>Nombre completo</th>
                        <th>Fecha Nac.</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $res = $conn->query("SELECT * FROM estudiante");
                while($row = $res->fetch_assoc()){
                    echo "<tr>
                        <td>{$row['idestudiantes']}</td>
                        <td>{$row['rnc']}</td>
                        <td>{$row['correo']}</td>
                        <td>{$row['telefono']}</td>
                        <td>{$row['direccion']}</td>
                        <td>{$row['modalidad']}</td>
                        <td>{$row['grado']}</td>
                        <td>{$row['seccion']}</td>
                        <td>{$row['profesor']}</td>
                        <td>{$row['nombre_completo']}</td>
                        <td>{$row['fecha_nacimiento']}</td>
                        <td>
                            <a class='action edit' href='?editar={$row['idestudiantes']}'>Editar</a>
                            <a class='action delete' href='?eliminar={$row['idestudiantes']}'
                               onclick='return confirm(\"¿Eliminar estudiante?\")'>Eliminar</a>
                        </td>
                    </tr>";
                }
                ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>
