<?php
/* ---------- CONEXIÓN ---------- */
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

if (!isset($conn) || !($conn instanceof mysqli)) {
    if (isset($conexion) && $conexion instanceof mysqli) {
        $conn = $conexion;
    } else {
        echo "<h3>ERROR: La conexión no es válida.</h3>";
        exit;
    }
}

/* ---------- GUARDAR ---------- */
if (isset($_POST['guardar'])) {
    $idestudiante = $_POST['idestudiante'];
    $idgrado = $_POST['idgrado'];
    $idtanda = $_POST['idtanda'];
    $fecha = $_POST['fecha'];
    $descripcion = $_POST['descripcion'];
    $observacion = $_POST['observacion'];

    $stmt = $conn->prepare("INSERT INTO reportes
        (idestudiante, idgrado, idtanda, fecha, descripcion, observacion)
        VALUES (?,?,?,?,?,?)");
    $stmt->bind_param("iiisss",$idestudiante,$idgrado,$idtanda,$fecha,$descripcion,$observacion);
    $stmt->execute();
    $stmt->close();
}

/* ---------- ELIMINAR ---------- */
if (isset($_GET['eliminar'])) {
    $id = $_GET['eliminar'];
    $stmt = $conn->prepare("DELETE FROM reportes WHERE idreporte=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

/* ---------- ACTUALIZAR ---------- */
if (isset($_POST['actualizar'])) {
    $stmt = $conn->prepare("UPDATE reportes SET 
            idestudiante=?, 
            idgrado=?, 
            idtanda=?, 
            fecha=?, 
            descripcion=?, 
            observacion=?
            WHERE idreporte=?");
    $stmt->bind_param("iiisssi",
        $_POST['idestudiante'],
        $_POST['idgrado'],
        $_POST['idtanda'],
        $_POST['fecha'],
        $_POST['descripcion'],
        $_POST['observacion'],
        $_POST['idreporte']
    );
    $stmt->execute();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reportes | Estilo Gestión</title>
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
.wrapper{
    width:100%;
    max-width:1100px;
    margin:60px auto;
    background:var(--blanco);
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.15);
    overflow:hidden;
}
.header{
    background:linear-gradient(to right,var(--rojo),var(--rojo-oscuro));
    color:white;
    padding:20px;
    font-size:26px;
    font-weight:bold;
    display:flex;
    align-items:center;
    letter-spacing:1px;
}
.header i{ margin-right:10px; }
.body{ padding:30px; text-align:center; }
.form-grid{
    display:grid;
    grid-template-columns: repeat(2,1fr);
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
tr:nth-child(even){ background:#fafafa; }
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
function toggleTabla(){
    let tabla = document.getElementById("tablaReportes");
    tabla.style.display = tabla.style.display === "none" ? "block" : "none";
}
function confirmarEliminar(){
    return confirm("¿Eliminar este reporte?");
}
</script>
</head>

<body>
<div class="wrapper">

<div class="header"><i class="fa-solid fa-clipboard-list"></i> Reportes</div>

<div class="body">

<!-- FORMULARIO -->
<form method="POST">
    <div class="form-grid">

        <div class="form-group">
            <label>ID Estudiante</label>
            <div class="input-icon">
                <i class="fa-solid fa-user"></i>
                <input type="number" name="idestudiante" required>
            </div>
        </div>

        <div class="form-group">
            <label>ID Grado</label>
            <div class="input-icon">
                <i class="fa-solid fa-graduation-cap"></i>
                <input type="number" name="idgrado" required>
            </div>
        </div>

        <div class="form-group">
            <label>ID Tanda</label>
            <div class="input-icon">
                <i class="fa-solid fa-clock"></i>
                <input type="number" name="idtanda" required>
            </div>
        </div>

        <div class="form-group">
            <label>Fecha</label>
            <div class="input-icon">
                <i class="fa-solid fa-calendar"></i>
                <input type="date" name="fecha" required>
            </div>
        </div>

        <div class="form-group full">
            <label>Descripción</label>
            <div class="input-icon">
                <i class="fa-solid fa-file-lines"></i>
                <textarea name="descripcion" required></textarea>
            </div>
        </div>

        <div class="form-group full">
            <label>Observación</label>
            <div class="input-icon">
                <i class="fa-solid fa-comment"></i>
                <textarea name="observacion"></textarea>
            </div>
        </div>

    </div>

    <div class="form-actions">
        <button class="btn-guardar" name="guardar">Guardar Reporte</button>
        <button type="button" class="btn-toggle" onclick="toggleTabla()"><i class="fa-solid fa-table"></i> Ver lista</button>
        <a href="index.php" class="btn-volver"><i class="fa-solid fa-arrow-left"></i> Volver</a>
    </div>
</form>

<!-- TABLA -->
<div class="table-wrapper" id="tablaReportes">
<table>
<thead>
<tr>
    <th>ID</th>
    <th>ID Est</th>
    <th>ID Grado</th>
    <th>ID Tanda</th>
    <th>Fecha</th>
    <th>Descripción</th>
    <th>Observación</th>
    <th>Acciones</th>
</tr>
</thead>
<tbody>
<?php
$result = $conn->query("SELECT * FROM reportes ORDER BY fecha DESC");
while($row = $result->fetch_assoc()){
    echo "<tr>
        <td>{$row['idreporte']}</td>
        <td>{$row['idestudiante']}</td>
        <td>{$row['idgrado']}</td>
        <td>{$row['idtanda']}</td>
        <td>{$row['fecha']}</td>
        <td>{$row['descripcion']}</td>
        <td>{$row['observacion']}</td>
        <td>
            <a class='action edit' href='?editar={$row['idreporte']}'>Editar</a>
            <a class='action delete' href='?eliminar={$row['idreporte']}' onclick='return confirmarEliminar()'>Eliminar</a>
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
