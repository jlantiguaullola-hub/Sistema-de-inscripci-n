<?php
include("conexion.php");
$mensaje = "";
$editarDocente = null;

/* -------- GUARDAR -------- */
if (isset($_POST['guardar'])) {
    $stmt = $conn->prepare("INSERT INTO docente (id_docente,nombre_completo,especialidad,telefono,id_usuario) VALUES (?,?,?,?,?)");
    $stmt->bind_param("isssi",
        $_POST['id_docente'],
        $_POST['nombre_completo'],
        $_POST['especialidad'],
        $_POST['telefono'],
        $_POST['id_usuario']
    );

    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;font-weight:bold;'>✔ Docente registrado correctamente</div>";
    } else {
        $mensaje = "<div style='color:red;'>❌ Error: ".$stmt->error."</div>";
    }
    $stmt->close();
}

/* -------- EDITAR -------- */
if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    $res = $conn->query("SELECT * FROM docente WHERE id_docente=$id");
    $editarDocente = $res->fetch_assoc();
}

/* -------- ACTUALIZAR -------- */
if (isset($_POST['actualizar'])) {
    $stmt = $conn->prepare("UPDATE docente SET nombre_completo=?, especialidad=?, telefono=?, id_usuario=? WHERE id_docente=?");
    $stmt->bind_param("sssii",
        $_POST['nombre_completo'],
        $_POST['especialidad'],
        $_POST['telefono'],
        $_POST['id_usuario'],
        $_POST['id_docente']
    );

    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;font-weight:bold;'>✔ Docente actualizado</div>";
    }
    $stmt->close();
}

/* -------- ELIMINAR -------- */
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conn->query("DELETE FROM docente WHERE id_docente=$id");
    $mensaje = "<div style='color:green;font-weight:bold;'>✔ Docente eliminado</div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Docentes | Estilo Gestión</title>
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

/* CUADRO PRINCIPAL */
.form-wrapper{
    width:100%;
    max-width:1100px;
    margin:120px auto 0 auto; /* BAJADO AL CENTRO */
    background:var(--gris);
    border-radius:8px;
    overflow:hidden;
    box-shadow:0 0 10px rgba(0,0,0,0.15);
}

/* HEADER */
.form-header{
    background:linear-gradient(to right,var(--rojo),var(--rojo-oscuro));
    color:white;
    padding:20px;
    font-size:26px;
    font-weight:bold;
    display:flex;
    align-items:center;
    justify-content:flex-start; /* TITULO A LA IZQUIERDA */
    padding-left:20px; /* margen desde el borde */
    letter-spacing:1px;
    text-transform:uppercase;
}

/* CUERPO */
.form-body{
    padding:30px;
    text-align:center;
}

/* GRID */
.form-grid{
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap:20px;
    justify-content:center;
}

/* CAMPOS */
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

.full{ grid-column: span 1; }

/* BOTONES */
.form-actions{
    margin-top:30px;
    display:flex;
    gap:15px;
    justify-content:flex-start; /* BOTONES A LA IZQUIERDA */
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

/* TABLA */
.table-wrapper{
    margin:40px auto;
    max-width:1000px;
    background:white;
    border-radius:10px;
    padding:20px;
    display:none;
}

/* TABLA */
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
    .full{ grid-column: span 1; }
}

</style>

<script>
function toggleLista(){
    let tabla = document.getElementById("tablaDocentes");
    tabla.style.display = tabla.style.display === "none" ? "block" : "none";
}
</script>

</head>
<body>

<div class="form-wrapper">

    <div class="form-header">
        <i class="fa-solid fa-chalkboard-user"></i> Docentes
    </div>

    <div class="form-body">
        <?= $mensaje ?>

        <form method="POST">
            <div class="form-grid">

                <div class="form-group">
                    <label>ID Docente</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-id-card"></i>
                        <input type="number" name="id_docente" required
                        value="<?= $editarDocente['id_docente'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group full">
                    <label>Nombre completo</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="nombre_completo" required
                        value="<?= $editarDocente['nombre_completo'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Especialidad</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-book"></i>
                        <input type="text" name="especialidad" required
                        value="<?= $editarDocente['especialidad'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Teléfono</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="telefono" required
                        value="<?= $editarDocente['telefono'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>ID Usuario</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-user-gear"></i>
                        <input type="number" name="id_usuario" required
                        value="<?= $editarDocente['id_usuario'] ?? '' ?>">
                    </div>
                </div>

            </div>

            <div class="form-actions">
                <?php if($editarDocente): ?>
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
        <div class="table-wrapper" id="tablaDocentes">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Especialidad</th>
                        <th>Teléfono</th>
                        <th>ID Usuario</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $res = $conn->query("SELECT * FROM docente");
                while($row = $res->fetch_assoc()){
                    echo "<tr>
                        <td>{$row['id_docente']}</td>
                        <td>{$row['nombre_completo']}</td>
                        <td>{$row['especialidad']}</td>
                        <td>{$row['telefono']}</td>
                        <td>{$row['id_usuario']}</td>
                        <td>
                            <a class='action edit' href='?editar={$row['id_docente']}'>Editar</a>
                            <a class='action delete' href='?eliminar={$row['id_docente']}'>Eliminar</a>
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
