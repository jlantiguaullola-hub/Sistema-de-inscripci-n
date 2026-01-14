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
$editarPeriodo = null;

// -------- GUARDAR NUEVO PERÍODO --------
if (isset($_POST['guardar'])) {
    $id = trim($_POST['id_periodo']);
    $nombre = trim($_POST['nombre']);
    $inicio = $_POST['fecha_inicio'];
    $fin = $_POST['fecha_fin'];

    $stmt = $conn->prepare("
        INSERT INTO periodo_clases (id_periodo, nombre, fecha_inicio, fecha_fin)
        VALUES (?,?,?,?)
    ");
    $stmt->bind_param("ssss", $id, $nombre, $inicio, $fin);

    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;font-weight:bold;'>✔ Período guardado correctamente</div>";
    } else {
        $mensaje = "<div style='color:red;'>❌ Error: ".$stmt->error."</div>";
    }
    $stmt->close();
}

// -------- ELIMINAR PERÍODO --------
if (isset($_GET['eliminar'])) {
    $id_eliminar = $_GET['eliminar'];
    $stmt = $conn->prepare("DELETE FROM periodo_clases WHERE id_periodo=?");
    $stmt->bind_param("s", $id_eliminar);
    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;font-weight:bold;'>✔ Período eliminado correctamente</div>";
    } else {
        $mensaje = "<div style='color:red;'>❌ Error al eliminar: ".$stmt->error."</div>";
    }
    $stmt->close();
}

// -------- EDITAR PERÍODO --------
if (isset($_GET['editar'])) {
    $id_editar = $_GET['editar'];
    $stmt = $conn->prepare("SELECT * FROM periodo_clases WHERE id_periodo=?");
    $stmt->bind_param("s", $id_editar);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows > 0) {
        $editarPeriodo = $res->fetch_assoc();
    }
    $stmt->close();
}

// -------- ACTUALIZAR PERÍODO --------
if (isset($_POST['actualizar']) && isset($_POST['id_periodo'])) {
    $id = $_POST['id_periodo'];
    $nombre = trim($_POST['nombre']);
    $inicio = $_POST['fecha_inicio'];
    $fin = $_POST['fecha_fin'];

    $stmt = $conn->prepare("UPDATE periodo_clases SET nombre=?, fecha_inicio=?, fecha_fin=? WHERE id_periodo=?");
    $stmt->bind_param("ssss", $nombre, $inicio, $fin, $id);

    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;font-weight:bold;'>✔ Período actualizado correctamente</div>";
    } else {
        $mensaje = "<div style='color:red;'>❌ Error al actualizar: ".$stmt->error."</div>";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Períodos | Estilo Gestión</title>
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
    let tabla = document.getElementById("tablaPeriodos");
    tabla.style.display = tabla.style.display === "none" ? "block" : "none";
}
function confirmarEliminar(nombre){
    return confirm("¿Eliminar el período: " + nombre + "?");
}
</script>
</head>
<body>

<div class="form-wrapper">

    <div class="form-header">
        <i class="fa-solid fa-calendar-days"></i> Períodos
    </div>

    <div class="form-body">
        <?= $mensaje ?>

        <form method="POST">
            <div class="form-grid">

                <div class="form-group">
                    <label>ID Período</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-id-card"></i>
                        <input type="text" name="id_periodo" required value="<?= htmlspecialchars($editarPeriodo['id_periodo'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group full">
                    <label>Nombre Completo</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-file-lines"></i>
                        <input type="text" name="nombre" required value="<?= htmlspecialchars($editarPeriodo['nombre'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Fecha de Inicio</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-calendar"></i>
                        <input type="date" name="fecha_inicio" required value="<?= htmlspecialchars($editarPeriodo['fecha_inicio'] ?? '') ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label>Fecha de Fin</label>
                    <div class="input-icon">
                        <i class="fa-solid fa-calendar-check"></i>
                        <input type="date" name="fecha_fin" required value="<?= htmlspecialchars($editarPeriodo['fecha_fin'] ?? '') ?>">
                    </div>
                </div>

            </div>

            <div class="form-actions">
                <?php if($editarPeriodo): ?>
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

        <div class="table-wrapper" id="tablaPeriodos">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $result = $conn->query("SELECT * FROM periodo_clases ORDER BY fecha_inicio DESC");
                while($row = $result->fetch_assoc()){
                    $id = htmlspecialchars($row['id_periodo']);
                    $nombre = htmlspecialchars($row['nombre']);
                    echo "<tr>
                        <td>{$id}</td>
                        <td>{$nombre}</td>
                        <td>".htmlspecialchars($row['fecha_inicio'])."</td>
                        <td>".htmlspecialchars($row['fecha_fin'])."</td>
                        <td>
                            <a class='action edit' href='?editar={$id}'>Editar</a>
                            <a class='action delete' href='?eliminar={$id}' onclick='return confirmarEliminar(\"{$nombre}\")'>Eliminar</a>
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
