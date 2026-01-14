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

// ---------- VARIABLES ----------
$mensaje = "";
$editarGrado = null;

// ---------- GUARDAR GRADO ----------
if (isset($_POST['guardar'])) {
    $nombre = trim($_POST['nombre_grado']);
    $nivel  = $_POST['nivel'];

    $stmt = $conn->prepare("INSERT INTO grado (nombre_grado, nivel) VALUES (?, ?)");
    $stmt->bind_param("ss", $nombre, $nivel);

    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;'>✔ Grado registrado correctamente</div>";
    } else {
        $mensaje = "<div style='color:red;'>❌ Error: ".$stmt->error."</div>";
    }
    $stmt->close();
}

// ---------- EDITAR GRADO ----------
if (isset($_GET['editar'])) {
    $id_editar = $_GET['editar'];
    $stmt = $conn->prepare("SELECT * FROM grado WHERE idgrado=?");
    $stmt->bind_param("i", $id_editar);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $res->num_rows > 0) {
        $editarGrado = $res->fetch_assoc();
    }
    $stmt->close();
}

// ---------- ACTUALIZAR GRADO ----------
if (isset($_POST['actualizar']) && isset($_POST['idgrado'])) {
    $id = $_POST['idgrado'];
    $nombre = trim($_POST['nombre_grado']);
    $nivel  = $_POST['nivel'];

    $stmt = $conn->prepare("UPDATE grado SET nombre_grado=?, nivel=? WHERE idgrado=?");
    $stmt->bind_param("ssi", $nombre, $nivel, $id);

    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;'>✔ Grado actualizado correctamente</div>";
    } else {
        $mensaje = "<div style='color:red;'>❌ Error al actualizar: ".$stmt->error."</div>";
    }
    $stmt->close();
}

// ---------- ELIMINAR GRADO ----------
if (isset($_GET['eliminar'])) {
    $id_eliminar = $_GET['eliminar'];
    $stmt = $conn->prepare("DELETE FROM grado WHERE idgrado=?");
    $stmt->bind_param("i", $id_eliminar);
    if ($stmt->execute()) {
        $mensaje = "<div style='color:green;'>✔ Grado eliminado correctamente</div>";
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
<title>CRUD Grados</title>

<!-- ICONOS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
:root{--rojo:#6b0f1a;--rojo-oscuro:#4a0a12;--gris-claro:#f4f4f4;--blanco:#ffffff;}
body{margin:0;font-family:"Segoe UI", Arial, sans-serif;background:var(--gris-claro);padding:20px;}
.btn-volver{position:absolute;top:20px;left:20px;background:var(--rojo);color:white;padding:10px 18px;text-decoration:none;}
.btn-volver:hover{ background:var(--rojo-oscuro); }
.main-wrapper{max-width:1100px;margin:60px auto;background:white;border:2px solid var(--rojo);padding:25px;}
.header-tools{display:flex;justify-content: space-between;align-items:center;margin-bottom:20px;flex-wrap: wrap;gap:10px;}
.search-box input{padding:8px;width:300px;border:1px solid #aaa;}

/* ✅ ICONOS CON COLORES REALES */
.export-btns a{
    background: transparent;
    padding:6px 10px;
    margin-left:5px;
    font-size:28px;
    text-decoration:none;
    display:inline-block;
    transition:.2s;
}
.export-btns a.word{ color:#2b5797; }
.export-btns a.excel{ color:#217346; }
.export-btns a.print{ color:#333; }
.export-btns a:hover{ transform:scale(1.15); }

.form-container,.table-container{border:1px solid #d8d8d8;padding:20px;margin-bottom:25px;}
h2{color:var(--rojo);border-bottom:2px solid var(--rojo);padding-bottom:5px;}
input,select{width:100%;padding:10px;margin:8px 0 15px;border:1px solid #aaa;}
button{background:var(--rojo);color:white;padding:10px;width:100%;border:none;cursor:pointer;}
button:hover{background:var(--rojo-oscuro);}
table{width:100%;border-collapse:collapse;}
th{background:var(--rojo);color:white;padding:10px;}
td{padding:10px;border:1px solid #ddd;text-align:center;}
tr:nth-child(even){background:#fafafa;}
a.action{color:var(--rojo);font-weight:bold;text-decoration:none;}
</style>

<script>
function buscarGrado() {
    let input = document.getElementById("buscar").value.toLowerCase();
    let filas = document.querySelectorAll("tbody tr");
    filas.forEach(fila => {
        let texto = fila.innerText.toLowerCase();
        fila.style.display = texto.includes(input) ? "" : "none";
    });
}

function confirmarEliminar(nombre){
    return confirm("¿Eliminar el grado: "+nombre+"?");
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
</script>
</head>

<body>

<a href="index.php" class="btn-volver">← Volver</a>

<div class="main-wrapper">
<?= $mensaje ?>

<!-- ===== BUSCAR + ICONOS ===== -->
<div class="header-tools">
    <div class="search-box">
        <input type="text" id="buscar" onkeyup="buscarGrado()" placeholder="Buscar grado...">
    </div>

    <div class="export-btns">
        <a href="exportar_grados_word.php" class="word" title="Exportar a Word">
            <i class="fa-solid fa-file-word"></i>
        </a>

        <a href="exportar_grados_excel.php" class="excel" title="Exportar a Excel">
            <i class="fa-solid fa-file-excel"></i>
        </a>

        <a href="#" class="print" onclick="imprimirTabla()" title="Imprimir">
            <i class="fa-solid fa-print"></i>
        </a>
    </div>
</div>

<!-------------------- FORMULARIO -------------------->
<div class="form-container">
<h2><?= $editarGrado ? "Editar Grado" : "Registrar Grado" ?></h2>

<form method="POST">
    <?php if($editarGrado): ?>
        <input type="hidden" name="idgrado" value="<?= $editarGrado['idgrado'] ?>">
    <?php endif; ?>

    <input type="text" name="nombre_grado" placeholder="Nombre del grado (ej: 1ero, 2do...)"
    value="<?= htmlspecialchars($editarGrado['nombre_grado'] ?? '') ?>" required>

    <select name="nivel" required>
        <option value="">Seleccione nivel...</option>
        <option value="inicial" <?= (isset($editarGrado['nivel']) && $editarGrado['nivel']=="inicial")?"selected":"" ?>>Inicial</option>
        <option value="primaria" <?= (isset($editarGrado['nivel']) && $editarGrado['nivel']=="primaria")?"selected":"" ?>>Primaria</option>
        <option value="secundaria" <?= (isset($editarGrado['nivel']) && $editarGrado['nivel']=="secundaria")?"selected":"" ?>>Secundaria</option>
    </select>

    <button type="submit" name="<?= $editarGrado ? 'actualizar' : 'guardar' ?>">
        <?= $editarGrado ? "Actualizar Grado" : "Guardar Grado" ?>
    </button>
</form>
</div>

<!-------------------- TABLA -------------------->
<div class="table-container">
<h2>Lista de Grados</h2>
<table>
<thead>
<tr>
<th>ID</th>
<th>Nombre del grado</th>
<th>Nivel</th>
<th>Acciones</th>
</tr>
</thead>

<tbody>
<?php
$result = $conn->query("SELECT * FROM grado ORDER BY idgrado DESC");
if($result && $result->num_rows>0){
    while($row=$result->fetch_assoc()){
        $id = htmlspecialchars($row['idgrado']);
        $nombre = htmlspecialchars($row['nombre_grado']);
        echo "<tr>
            <td>{$id}</td>
            <td>{$nombre}</td>
            <td>".htmlspecialchars($row['nivel'])."</td>
            <td>
                <a class='action' href='?editar={$id}'>Editar</a> |
                <a class='action' href='?eliminar={$id}' onclick='return confirmarEliminar(\"{$nombre}\")'>Eliminar</a>
            </td>
        </tr>";
    }
}else{
    echo "<tr><td colspan='4'>No hay grados registrados</td></tr>";
}
?>
</tbody>
</table>
</div>

</div>
</body>
</html>
