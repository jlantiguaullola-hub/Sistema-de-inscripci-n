<?php
// ------- CONEXIÓN -------
$possible_paths = [
    __DIR__ . '/conexion.php',
    __DIR__ . '/includes/conexion.php',
    __DIR__ . '/php/conexion.php',
    __DIR__ . '/../conexion.php'
];

$included_path = null;
foreach ($possible_paths as $p) {
    if (file_exists($p) && is_readable($p)) {
        require_once $p;
        $included_path = $p;
        break;
    }
}

if (!$included_path) {
    echo "<h3>ERROR: No se encontró conexion.php</h3>";
    exit;
}

if (!isset($conn) || !($conn instanceof mysqli)) {
    if (isset($conexion) && $conexion instanceof mysqli) {
        $conn = $conexion;
    } else {
        echo "<h3>ERROR: La variable \$conn no se creó correctamente.</h3>";
        exit;
    }
}

// -------- VARIABLES --------
$mensaje = "";
$editarTutor = null;

// -------- GUARDAR NUEVO TUTOR --------
if (isset($_POST['guardar'])) {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $responsable = trim($_POST['responsable']);
    $fecha = $_POST['fecha'];
    $estado = $_POST['estado'];
    $observaciones = trim($_POST['observaciones']);

    $stmt = $conn->prepare("INSERT INTO tutores 
        (titulo, descripcion, responsable, fecha, estado, observaciones)
        VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("ssssss", $titulo, $descripcion, $responsable, $fecha, $estado, $observaciones);

    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;font-weight:bold;margin-bottom:15px;'>✔ Tutor registrado correctamente</div>";
    } else {
        $mensaje = "<div style='color:red;margin-bottom:15px;'>❌ Error: ".$stmt->error."</div>";
    }
    $stmt->close();
}

// -------- ELIMINAR TUTOR --------
if (isset($_GET['eliminar'])) {
    $id_eliminar = intval($_GET['eliminar']);
    $stmt = $conn->prepare("DELETE FROM tutores WHERE id_tutor=?");
    $stmt->bind_param("i", $id_eliminar);

    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;font-weight:bold;margin-bottom:15px;'>✔ Tutor eliminado correctamente</div>";
    } else {
        $mensaje = "<div style='color:red;margin-bottom:15px;'>❌ Error al eliminar: ".$stmt->error."</div>";
    }
    $stmt->close();
}

// -------- EDITAR TUTOR --------
if (isset($_GET['editar'])) {
    $id_editar = intval($_GET['editar']);
    $stmt = $conn->prepare("SELECT * FROM tutores WHERE id_tutor=?");
    $stmt->bind_param("i", $id_editar);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res && $res->num_rows > 0) {
        $editarTutor = $res->fetch_assoc();
    }
    $stmt->close();
}

// -------- ACTUALIZAR TUTOR --------
if (isset($_POST['actualizar']) && isset($_POST['id_tutor'])) {
    $id_tutor = intval($_POST['id_tutor']);
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $responsable = trim($_POST['responsable']);
    $fecha = $_POST['fecha'];
    $estado = $_POST['estado'];
    $observaciones = trim($_POST['observaciones']);

    $stmt = $conn->prepare("UPDATE tutores 
        SET titulo=?, descripcion=?, responsable=?, fecha=?, estado=?, observaciones=? 
        WHERE id_tutor=?");
    $stmt->bind_param("ssssssi", $titulo, $descripcion, $responsable, $fecha, $estado, $observaciones, $id_tutor);

    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;font-weight:bold;margin-bottom:15px;'>✔ Tutor actualizado correctamente</div>";
    } else {
        $mensaje = "<div style='color:red;margin-bottom:15px;'>❌ Error al actualizar: ".$stmt->error."</div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Tutores | Estilo Gestión</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>

<style>
:root{
    --rojo:#6b0f1a;
    --rojo-oscuro:#4a0a12;
    --gris:#f2f2f2;
    --blanco:#fff;
}
body{
    margin:0;
    font-family:"Segoe UI", Arial, sans-serif;
    background:var(--gris);
    padding:20px;
    display:flex;
    justify-content:center;
}
.form-wrapper{
    width:100%;
    max-width:1100px;
    margin:60px auto;
    background:var(--blanco);
    border-radius:10px;
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
    grid-template-columns: repeat(2, 1fr);
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
    align-self:flex-start;
}
.input-icon{
    display:flex;
    align-items:center;
    background:white;
    border-radius:8px;
    border:1px solid #aaa;
    overflow:hidden;
    width:100%;
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
.full{ grid-column: span 2; }
.form-actions{
    margin-top:20px;
    display:flex;
    gap:15px;
    flex-wrap:wrap;
    justify-content:flex-start;
}
.form-actions button,
.form-actions a{
    padding:12px 20px;
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
    margin:30px auto;
    max-width:1000px;
    background:white;
    border-radius:10px;
    padding:20px;
    display:none;
}
table{
    width:100%;
    border-collapse:collapse;
    font-size:16px;
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
    margin:0 2px;
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
    let tabla = document.getElementById("tablaTutores");
    tabla.style.display = tabla.style.display === "none" ? "block" : "none";
}
function confirmarEliminar(titulo){
    return confirm("¿Eliminar el tutor: " + titulo + "?");
}
</script>
</head>
<body>

<div class="form-wrapper">

    <div class="form-header">
        <i class="fa-solid fa-chalkboard-user"></i> Tutores
    </div>

    <div class="form-body">

        <?= $mensaje ?>

        <form method="POST">
            <div class="form-grid">

                <div class="form-group full">
                    <label>Nombre del Tutor</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-user"></i>
                        <input type="text" name="titulo" required value="<?= htmlspecialchars($editarTutor['titulo'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group full">
                    <label>Descripción</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-file-lines"></i>
                        <textarea name="descripcion"><?= htmlspecialchars($editarTutor['descripcion'] ?? '') ?></textarea>
                    </div>
                </div>

                <div class="form-group">
                    <label>Responsable</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-user-tie"></i>
                        <input type="text" name="responsable" required value="<?= htmlspecialchars($editarTutor['responsable'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Fecha</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-calendar"></i>
                        <input type="date" name="fecha" required value="<?= htmlspecialchars($editarTutor['fecha'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Estado</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-toggle-on"></i>
                        <select name="estado" required>
                            <option value="Activo" <?= (isset($editarTutor['estado']) && $editarTutor['estado']=="Activo")?"selected":"" ?>>Activo</option>
                            <option value="Inactivo" <?= (isset($editarTutor['estado']) && $editarTutor['estado']=="Inactivo")?"selected":"" ?>>Inactivo</option>
                        </select>
                    </div>
                </div>

                <div class="form-group full">
                    <label>Observaciones</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-comment"></i>
                        <textarea name="observaciones"><?= htmlspecialchars($editarTutor['observaciones'] ?? '') ?></textarea>
                    </div>
                </div>

            </div>

            <div class="form-actions">
                <?php if($editarTutor): ?>
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

        <div class="table-wrapper" id="tablaTutores">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Responsable</th>
                        <th>Fecha</th>
                        <th>Estado</th>
                        <th>Observaciones</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $result = $conn->query("SELECT * FROM tutores ORDER BY id_tutor DESC");
                while($row = $result->fetch_assoc()){
                    $id = $row['id_tutor'];
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
                ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

</body>
</html>
