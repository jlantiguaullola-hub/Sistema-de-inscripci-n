<?php
include("conexion.php");
$mensaje = "";
$editarGestion = null;

// -------- GUARDAR NUEVA GESTIÓN --------
if (isset($_POST['guardar'])) {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $responsable = trim($_POST['responsable']);
    $fecha = $_POST['fecha'];
    $estado = trim($_POST['estado']) ?: 'Inactivo';
    $observaciones = trim($_POST['observaciones']);

    $stmt = $conn->prepare("INSERT INTO gestion 
        (titulo, descripcion, responsable, fecha, estado, observaciones)
        VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssss", $titulo, $descripcion, $responsable, $fecha, $estado, $observaciones);

    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;font-weight:bold;'>✔ Gestión registrada correctamente</div>";
    } else {
        $mensaje = "<div style='color:red;'>❌ Error: ".$stmt->error."</div>";
    }
    $stmt->close();
}

// -------- EDITAR GESTIÓN --------
if (isset($_GET['editar'])) {
    $id_editar = intval($_GET['editar']);
    $stmt = $conn->prepare("SELECT * FROM gestion WHERE id_gestion=?");
    $stmt->bind_param("i", $id_editar);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows > 0) {
        $editarGestion = $res->fetch_assoc();
    }
    $stmt->close();
}

// -------- ACTUALIZAR GESTIÓN --------
if (isset($_POST['actualizar']) && isset($_POST['id_gestion'])) {
    $id_gestion = intval($_POST['id_gestion']);
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $responsable = trim($_POST['responsable']);
    $fecha = $_POST['fecha'];
    $estado = trim($_POST['estado']) ?: 'Inactivo';
    $observaciones = trim($_POST['observaciones']);

    $stmt = $conn->prepare("
        UPDATE gestion 
        SET titulo=?, descripcion=?, responsable=?, fecha=?, estado=?, observaciones=? 
        WHERE id_gestion=?
    ");
    $stmt->bind_param("ssssssi", $titulo, $descripcion, $responsable, $fecha, $estado, $observaciones, $id_gestion);

    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;font-weight:bold;'>✔ Gestión actualizada correctamente</div>";
    } else {
        $mensaje = "<div style='color:red;'>❌ Error al actualizar: ".$stmt->error."</div>";
    }
    $stmt->close();
}

// -------- CAMBIAR ESTADO ACTIVO/INACTIVO --------
if (isset($_POST['cambiar_estado']) && isset($_POST['id_gestion'])) {
    $id_gestion = intval($_POST['id_gestion']);
    $nuevo_estado = $_POST['cambiar_estado'] === 'Activo' ? 'Inactivo' : 'Activo';
    $stmt = $conn->prepare("UPDATE gestion SET estado=? WHERE id_gestion=?");
    $stmt->bind_param("si", $nuevo_estado, $id_gestion);
    $stmt->execute();
    $stmt->close();
    $mensaje = "<div style='color:green;font-weight:bold;'>✔ Estado cambiado a $nuevo_estado</div>";

    // Recargar datos para mostrar el nuevo estado
    $res = $conn->prepare("SELECT * FROM gestion WHERE id_gestion=?");
    $res->bind_param("i", $id_gestion);
    $res->execute();
    $resultado = $res->get_result();
    if ($resultado && $resultado->num_rows > 0) {
        $editarGestion = $resultado->fetch_assoc();
    }
    $res->close();
}

// -------- ELIMINAR GESTIÓN --------
if (isset($_GET['eliminar'])) {
    $id_eliminar = intval($_GET['eliminar']);
    $stmt = $conn->prepare("DELETE FROM gestion WHERE id_gestion=?");
    $stmt->bind_param("i", $id_eliminar);

    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;font-weight:bold;'>✔ Gestión eliminada correctamente</div>";
    } else {
        $mensaje = "<div style='color:red;'>❌ Error al eliminar: ".$stmt->error."</div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión | Estilo Estudiantes</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
<style>
:root{
    --rojo: #6b0f1a;
    --rojo-oscuro: #4a0a12;
    --gris: #d0d0d0;
    --blanco: #ffffff;
}

body{
    margin:0;
    font-family:"Segoe UI", Arial, sans-serif;
    background:#f2f2f2;
    padding:20px;
}

.form-wrapper{
    max-width:1100px;
    margin:auto;
    background:var(--gris);
    border-radius:8px;
    overflow:hidden;
    box-shadow:0 0 10px rgba(0,0,0,0.15);
}

.form-header{
    background:linear-gradient(to right, var(--rojo), var(--rojo-oscuro));
    color:white;
    padding:15px 25px;
    font-size:22px;
    font-weight:bold;
    display:flex;
    align-items:center;
    gap:10px;
}

.form-body{
    padding:25px;
}

.form-grid{
    display:grid;
    grid-template-columns: repeat(3, 1fr);
    gap:20px;
}

.form-group{
    display:flex;
    flex-direction:column;
}

.form-group label{
    font-weight:bold;
    margin-bottom:6px;
    color:#222;
}

.input-icon{
    display:flex;
    align-items:center;
    background:white;
    border-radius:6px;
    border:1px solid #aaa;
    overflow:hidden;
}

.input-icon i{
    padding:10px;
    background:#eee;
    color:var(--rojo);
    min-width:40px;
    text-align:center;
}

.input-icon input,
.input-icon select,
.input-icon textarea{
    border:none;
    outline:none;
    padding:10px;
    width:100%;
    font-size:15px;
    resize: vertical;
}

.full{
    grid-column: span 3;
}

.form-actions{
    margin-top:25px;
    display:flex;
    gap:15px;
}

.form-actions button,
.form-actions a{
    padding:12px 20px;
    border:none;
    border-radius:6px;
    font-size:16px;
    cursor:pointer;
    text-decoration:none;
    color:white;
}

.btn-guardar{ background:green; }
.btn-eliminar{ background:red; }
.btn-volver{ background:var(--rojo); }
.btn-estado{ border:none; border-radius:6px; padding:12px 20px; color:white; cursor:pointer; margin-top:10px; }

.table-wrapper{
    margin-top:30px;
    background:white;
    border-radius:8px;
    overflow-x:auto;
    padding:20px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th, td{
    padding:12px;
    text-align:center;
    border-bottom:1px solid #ccc;
}

th{
    background:var(--rojo);
    color:white;
}

tr:hover{ background:#f0f0f0; }

a.action{
    text-decoration:none;
    color:white;
    padding:6px 10px;
    border-radius:5px;
    display:inline-block;
}

a.edit{ background:green; }
a.delete{ background:red; }

@media(max-width:900px){
    .form-grid{
        grid-template-columns:1fr;
    }
    .full{
        grid-column: span 1;
    }
}
</style>
<script>
function confirmarEliminar(titulo){
    return confirm("¿Eliminar la gestión: " + titulo + "?");
}
</script>
</head>
<body>

<div class="form-wrapper">

    <div class="form-header">
        <i class="fa-solid fa-clipboard-list"></i> Gestión
    </div>

    <div class="form-body">
        <?= $mensaje ?>

        <form method="POST">
            <div class="form-grid">

                <div class="form-group full">
                    <label>Título</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-heading"></i>
                        <input type="text" name="titulo" placeholder="Título" required
                        value="<?= htmlspecialchars($editarGestion['titulo'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group full">
                    <label>Descripción</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-file-lines"></i>
                        <textarea name="descripcion" placeholder="Descripción"><?= htmlspecialchars($editarGestion['descripcion'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label>Responsable</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="responsable" placeholder="Responsable" required
                        value="<?= htmlspecialchars($editarGestion['responsable'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Fecha</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-calendar"></i>
                        <input type="date" name="fecha" required
                        value="<?= htmlspecialchars($editarGestion['fecha'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Estado</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-toggle-on"></i>
                        <select name="estado" required>
                            <option value="">Seleccione...</option>
                            <option value="Pendiente" <?= ($editarGestion['estado'] ?? '')=='Pendiente'?'selected':'' ?>>Pendiente</option>
                            <option value="En proceso" <?= ($editarGestion['estado'] ?? '')=='En proceso'?'selected':'' ?>>En proceso</option>
                            <option value="Finalizado" <?= ($editarGestion['estado'] ?? '')=='Finalizado'?'selected':'' ?>>Finalizado</option>
                            <option value="Cancelado" <?= ($editarGestion['estado'] ?? '')=='Cancelado'?'selected':'' ?>>Cancelado</option>
                        </select>
                    </div>
                </div>

                <div class="form-group full">
                    <label>Observaciones</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-comment"></i>
                        <textarea name="observaciones" placeholder="Observaciones"><?= htmlspecialchars($editarGestion['observaciones'] ?? '') ?></textarea>
                    </div>
                </div>

            </div>

            <div class="form-actions">
                <?php if($editarGestion): ?>
                    <input type="hidden" name="id_gestion" value="<?= $editarGestion['id_gestion'] ?>">
                    <button class="btn-guardar" type="submit" name="actualizar">
                        <i class="fa-solid fa-check"></i> Actualizar Gestión
                    </button>
                <?php else: ?>
                    <button class="btn-guardar" type="submit" name="guardar">
                        <i class="fa-solid fa-check"></i> Guardar Gestión
                    </button>
                <?php endif; ?>

                <a href="index.php" class="btn-volver">
                    <i class="fa-solid fa-arrow-left"></i> Volver
                </a>
            </div>

            <!-- BOTÓN ACTIVO/INACTIVO -->
            <?php if($editarGestion): 
                $estado_actual = $editarGestion['estado'] ?? 'Inactivo';
                $color_btn = $estado_actual === 'Activo' ? 'green' : '#555';
                $texto_btn = $estado_actual === 'Activo' ? 'Activo' : 'Inactivo';
            ?>
                <button type="submit" name="cambiar_estado" value="<?= $estado_actual ?>" 
                    class="btn-estado" style="background:<?= $color_btn ?>;">
                    <?= $texto_btn ?>
                </button>
            <?php endif; ?>

        </form>

        <!-- TABLA -->
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Responsable</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $res = $conn->query("SELECT * FROM Gestion ORDER BY id_gestion DESC");
                    if($res && $res->num_rows>0){
                        while($row = $res->fetch_assoc()){
                            $id = $row['id_gestion'];
                            $titulo = htmlspecialchars($row['titulo']);
                            echo "<tr>
                                <td>{$id}</td>
                                <td>{$titulo}</td>
                                <td>".htmlspecialchars($row['responsable'])."</td>
                                <td>".htmlspecialchars($row['fecha'])."</td>
                                <td>".htmlspecialchars($row['estado'])."</td>
                                <td>".htmlspecialchars($row['observaciones'])."</td>
                                <td>
                                    <a class='action edit' href='?editar={$id}'>Editar</a>
                                    <a class='action delete' href='?eliminar={$id}' onclick='return confirmarEliminar(\"{$titulo}\")'>Eliminar</a>
                                </td>
                            </tr>";
                        }
                    }else{
                        echo "<tr><td colspan='7'>No hay gestiones registradas</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>
