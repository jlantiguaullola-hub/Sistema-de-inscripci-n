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

$mensaje = "";
$editarEstudiante = null;

// -------- REGISTRAR --------
if (isset($_POST['guardar'])) {
    $nombre   = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $cedula   = trim($_POST['cedula']);
    $grado    = trim($_POST['grado']);
    $seccion  = trim($_POST['seccion']);
    $tanda    = $_POST['tanda'];
    $ano      = trim($_POST['ano_escolar']);

    $stmt = $conn->prepare("INSERT INTO academica 
    (nombre, apellido, cedula, grado, seccion, tanda, ano_escolar)
    VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param("sssssss", $nombre, $apellido, $cedula, $grado, $seccion, $tanda, $ano);

    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;'>✔ Estudiante registrado correctamente</div>";
    } else {
        $mensaje = "<div style='color:red;'>❌ Error: ".$stmt->error."</div>";
    }
    $stmt->close();
}

// -------- ELIMINAR --------
if (isset($_GET['eliminar'])) {
    $id_eliminar = intval($_GET['eliminar']);
    $stmt = $conn->prepare("DELETE FROM academica WHERE id=?");
    $stmt->bind_param("i", $id_eliminar);

    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;'>✔ Estudiante eliminado correctamente</div>";
    } else {
        $mensaje = "<div style='color:red;'>❌ Error al eliminar: ".$stmt->error."</div>";
    }
    $stmt->close();
}

// -------- EDITAR --------
if (isset($_GET['editar'])) {
    $id_editar = intval($_GET['editar']);
    $stmt = $conn->prepare("SELECT * FROM academica WHERE id=?");
    $stmt->bind_param("i", $id_editar);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows > 0) {
        $editarEstudiante = $res->fetch_assoc();
    }
    $stmt->close();
}

// -------- ACTUALIZAR --------
if (isset($_POST['actualizar']) && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $nombre   = trim($_POST['nombre']);
    $apellido = trim($_POST['apellido']);
    $cedula   = trim($_POST['cedula']);
    $grado    = trim($_POST['grado']);
    $seccion  = trim($_POST['seccion']);
    $tanda    = $_POST['tanda'];
    $ano      = trim($_POST['ano_escolar']);

    $stmt = $conn->prepare("UPDATE academica 
        SET nombre=?, apellido=?, cedula=?, grado=?, seccion=?, tanda=?, ano_escolar=?
        WHERE id=?");
    $stmt->bind_param("sssssssi", $nombre, $apellido, $cedula, $grado, $seccion, $tanda, $ano, $id);

    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;'>✔ Estudiante actualizado correctamente</div>";
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
<title>Salida Académica</title>

<!-- ========= ICONOS ========= -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root{
    --rojo:#6b0f1a;
    --rojo-oscuro:#4a0a12;
    --gris-claro:#f4f4f4;
    --blanco:#ffffff;
}
body{margin:0;font-family:"Segoe UI", Arial, sans-serif;background:var(--gris-claro);padding:20px;}
.btn-volver{position:absolute;top:20px;left:20px;background:var(--rojo);color:white;padding:10px 18px;text-decoration:none;}
.btn-volver:hover{background:var(--rojo-oscuro);}
.main-wrapper{max-width:1100px;margin:60px auto;background:white;border:2px solid var(--rojo);padding:25px;}

.header-tools{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:20px;
    flex-wrap: wrap;
    gap:10px;
}
.search-box input{
    padding:8px;
    width:300px;
    border:1px solid #aaa;
}

/* ===== BOTONES CON ICONOS ===== */
.export-btns a{
    background:transparent;
    padding:6px 10px;
    margin-left:5px;
    font-size:28px;
    text-decoration:none;
    display:inline-block;
    transition:.2s;
}

/* Word - azul */
.export-btns a.word{ color:#2b5797; }

/* Excel - verde */
.export-btns a.excel{ color:#217346; }

/* Imprimir - gris */
.export-btns a.print{ color:#333; }

.export-btns a:hover{
    transform: scale(1.2);
}

.form-container,.table-container{border:1px solid #d8d8d8;padding:20px;margin-bottom:25px;}
h2{color:var(--rojo);border-bottom:2px solid var(--rojo);padding-bottom:5px;}
input, select{width:100%;padding:10px;margin:8px 0 15px;border:1px solid #aaa;}
button{background:var(--rojo);color:white;padding:10px;width:100%;border:none;cursor:pointer;}
table{width:100%;border-collapse:collapse;}
th{background:var(--rojo);color:white;padding:10px;}
td{padding:10px;border:1px solid #ddd;text-align:center;}
tr:nth-child(even){background:#fafafa;}
a.action{color:var(--rojo);font-weight:bold;text-decoration:none;}
</style>

<script>
function buscarEstudiante() {
    let input = document.getElementById("buscar").value.toLowerCase();
    let filas = document.querySelectorAll("tbody tr");

    filas.forEach(fila => {
        let texto = fila.innerText.toLowerCase();
        fila.style.display = texto.includes(input) ? "" : "none";
    });
}

function imprimirTabla(){
    let contenido = document.querySelector(".table-container").innerHTML;
    let ventana = window.open('');
    ventana.document.write('<html><head><title>Imprimir</title></head><body>');
    ventana.document.write(contenido);
    ventana.document.write('</body></html>');
    ventana.print();
    ventana.close();
}

function confirmarEliminar(nombre){
    return confirm("¿Eliminar al estudiante: " + nombre + "?");
}
</script>
</head>

<body>

<a href="index.php" class="btn-volver">← Volver</a>

<div class="main-wrapper">

<?= $mensaje ?>

<!-- BARRA SUPERIOR -->
<div class="header-tools">
    <div class="search-box">
        <input type="text" id="buscar" onkeyup="buscarEstudiante()" placeholder="Buscar estudiante...">
    </div>

    <div class="export-btns">
        <a href="exportar_word_estudiantes.php" class="word" title="Exportar a Word">
            <i class="fa-solid fa-file-word"></i>
        </a>

        <a href="exportar_excel_estudiantes.php" class="excel" title="Exportar a Excel">
            <i class="fa-solid fa-file-excel"></i>
        </a>

        <a href="#" class="print" onclick="imprimirTabla()" title="Imprimir">
            <i class="fa-solid fa-print"></i>
        </a>
    </div>
</div>

<!---------------- FORMULARIO ---------------->
<div class="form-container">
<h2><?= $editarEstudiante ? "Editar Estudiante" : "Registrar Estudiante" ?></h2>

<form method="POST">
<?php if($editarEstudiante): ?>
    <input type="hidden" name="id" value="<?= $editarEstudiante['id'] ?>">
<?php endif; ?>

<input type="text" name="nombre" placeholder="Nombre" value="<?= htmlspecialchars($editarEstudiante['nombre'] ?? '') ?>" required>
<input type="text" name="apellido" placeholder="Apellido" value="<?= htmlspecialchars($editarEstudiante['apellido'] ?? '') ?>" required>
<input type="text" name="cedula" placeholder="Cédula" value="<?= htmlspecialchars($editarEstudiante['cedula'] ?? '') ?>" required>
<input type="text" name="grado" placeholder="Grado" value="<?= htmlspecialchars($editarEstudiante['grado'] ?? '') ?>" required>
<input type="text" name="seccion" placeholder="Sección" value="<?= htmlspecialchars($editarEstudiante['seccion'] ?? '') ?>" required>

<select name="tanda" required>
    <option value="">Seleccione tanda</option>
    <option value="Mañana" <?= (isset($editarEstudiante['tanda']) && $editarEstudiante['tanda']=="Mañana")?"selected":"" ?>>Mañana</option>
    <option value="Tarde" <?= (isset($editarEstudiante['tanda']) && $editarEstudiante['tanda']=="Tarde")?"selected":"" ?>>Tarde</option>
    <option value="Noche" <?= (isset($editarEstudiante['tanda']) && $editarEstudiante['tanda']=="Noche")?"selected":"" ?>>Noche</option>
</select>

<input type="text" name="ano_escolar" placeholder="Año escolar" value="<?= htmlspecialchars($editarEstudiante['ano_escolar'] ?? '') ?>" required>

<button type="submit" name="<?= $editarEstudiante ? 'actualizar' : 'guardar' ?>">
<?= $editarEstudiante ? 'Actualizar Estudiante' : 'Guardar Estudiante' ?>
</button>

</form>
</div>

<!---------------- TABLA ---------------->
<div class="table-container">
<h2>Lista de Estudiantes</h2>

<table>
<thead>
<tr>
    <th>ID</th>
    <th>Nombre</th>
    <th>Apellido</th>
    <th>Cédula</th>
    <th>Grado</th>
    <th>Sección</th>
    <th>Tanda</th>
    <th>Año</th>
    <th>Acciones</th>
</tr>
</thead>

<tbody>
<?php
$result = $conn->query("SELECT * FROM academica ORDER BY id DESC");
if($result && $result->num_rows>0){
    while($row=$result->fetch_assoc()){
        $id = $row['id'];
        $nombreCompleto = htmlspecialchars($row['nombre']." ".$row['apellido']);
        echo "<tr>
            <td>{$id}</td>
            <td>".htmlspecialchars($row['nombre'])."</td>
            <td>".htmlspecialchars($row['apellido'])."</td>
            <td>".htmlspecialchars($row['cedula'])."</td>
            <td>".htmlspecialchars($row['grado'])."</td>
            <td>".htmlspecialchars($row['seccion'])."</td>
            <td>".htmlspecialchars($row['tanda'])."</td>
            <td>".htmlspecialchars($row['ano_escolar'])."</td>
            <td>
                <a class='action' href='?editar={$id}'>Editar</a> |
                <a class='action' href='?eliminar={$id}' onclick='return confirmarEliminar(\"{$nombreCompleto}\")'>Eliminar</a>
            </td>
        </tr>";
    }
}else{
    echo "<tr><td colspan='9'>No hay estudiantes registrados</td></tr>";
}
?>
</tbody>
</table>
</div>

</div>
</body>
</html>
