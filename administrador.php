<?php
include("conexion.php");
$mensaje = "";
$editarAdmin = null;

// -------- GUARDAR --------
if (isset($_POST['guardar'])) {
    $stmt = $conn->prepare("INSERT INTO administracion (tipo_admin, descripcion, responsable, fecha, estado, observaciones) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssss",
        $_POST['tipo_admin'],
        $_POST['descripcion'],
        $_POST['responsable'],
        $_POST['fecha'],
        $_POST['estado'],
        $_POST['observaciones']
    );
    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;font-weight:bold;'>✔ Administración registrada correctamente</div>";
    } else {
        $mensaje = "<div style='color:red;'>❌ Error: ".$stmt->error."</div>";
    }
    $stmt->close();
}

// -------- EDITAR --------
if (isset($_GET['editar'])) {
    $id = intval($_GET['editar']);
    $res = $conn->query("SELECT * FROM administracion WHERE id_admin=$id");
    $editarAdmin = $res->fetch_assoc();
}

// -------- ACTUALIZAR --------
if (isset($_POST['actualizar'])) {
    $stmt = $conn->prepare("UPDATE administracion SET tipo_admin=?, descripcion=?, responsable=?, fecha=?, estado=?, observaciones=? WHERE id_admin=?");
    $stmt->bind_param("ssssssi",
        $_POST['tipo_admin'],
        $_POST['descripcion'],
        $_POST['responsable'],
        $_POST['fecha'],
        $_POST['estado'],
        $_POST['observaciones'],
        $_POST['id_admin']
    );
    $stmt->execute();
    $stmt->close();
    $mensaje = "<div style='color:green;font-weight:bold;'>✔ Administración actualizada</div>";
}

// -------- ELIMINAR --------
if (isset($_GET['eliminar'])) {
    $id = intval($_GET['eliminar']);
    $conn->query("DELETE FROM administracion WHERE id_admin=$id");
    $mensaje = "<div style='color:green;font-weight:bold;'>✔ Administración eliminada</div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Administración | Estilo Gestión</title>
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
    margin:60px auto;
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
    letter-spacing:1px;
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
    justify-content:center;
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

.input-icon input,
.input-icon textarea,
.input-icon select{
    border:none;
    outline:none;
    padding:10px;
    width:100%;
    resize: vertical;
}

.full{ grid-column: span 1; }

.form-actions{
    margin-top:30px;
    display:flex;
    gap:15px;
    justify-content:flex-start;
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
    .full{ grid-column: span 1; }
}
</style>

<script>
function toggleLista(){
    let tabla = document.getElementById("tablaAdmin");
    tabla.style.display = tabla.style.display === "none" ? "block" : "none";
}
</script>

</head>
<body>

<div class="form-wrapper">

    <div class="form-header">
        <i class="fa-solid fa-building"></i> Administración
    </div>

    <div class="form-body">
        <?= $mensaje ?>

        <form method="POST">
            <div class="form-grid">

                <div class="form-group">
                    <label>Tipo Administración</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-clipboard-list"></i>
                        <input type="text" name="tipo_admin" required value="<?= $editarAdmin['tipo_admin'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group full">
                    <label>Descripción</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-file-lines"></i>
                        <textarea name="descripcion" required><?= $editarAdmin['descripcion'] ?? '' ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label>Responsable</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="responsable" required value="<?= $editarAdmin['responsable'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Fecha</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-calendar"></i>
                        <input type="date" name="fecha" required value="<?= $editarAdmin['fecha'] ?? '' ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Estado</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-toggle-on"></i>
                        <select name="estado" required>
                            <option value="<?= $editarAdmin['estado'] ?? '' ?>"><?= $editarAdmin['estado'] ?? 'Seleccione...' ?></option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="En proceso">En proceso</option>
                            <option value="Finalizado">Finalizado</option>
                        </select>
                    </div>
                </div>

                <div class="form-group full">
                    <label>Observaciones</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-comment"></i>
                        <textarea name="observaciones"><?= $editarAdmin['observaciones'] ?? '' ?></textarea>
                    </div>
                </div>

            </div>

            <div class="form-actions">
                <?php if($editarAdmin): ?>
                    <button class="btn-guardar" name="actualizar">Actualizar</button>
                <?php else: ?>
                    <button class="btn-guardar" name="guardar">Guardar</button>
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
        <div class="table-wrapper" id="tablaAdmin">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Responsable</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $res = $conn->query("SELECT * FROM administracion ORDER BY id_admin DESC");
                while($row = $res->fetch_assoc()){
                    echo "<tr>
                        <td>{$row['id_admin']}</td>
                        <td>{$row['tipo_gestion']}</td>
                        <td>{$row['descripcion']}</td>
                        <td>{$row['responsable']}</td>
                        <td>{$row['fecha']}</td>
                        <td>{$row['estado']}</td>
                        <td>{$row['observaciones']}</td>
                        <td>
                            <a class='action edit' href='?editar={$row['id_admin']}'>Editar</a>
                            <a class='action delete' href='?eliminar={$row['id_admin']}'>Eliminar</a>
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
