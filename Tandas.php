<?php
include("conexion.php");

/* GUARDAR */
if(isset($_POST['guardar'])){

    $stmt = $conn->prepare("INSERT INTO tandas (nombre_tanda, hora_inicio, hora_fin) VALUES (?,?,?)");
    $stmt->bind_param("sss",
        $_POST['nombre_tanda'],
        $_POST['hora_inicio'],
        $_POST['hora_fin']
    );
    $stmt->execute();

    header("Location: tandas.php");
    exit;
}

/* ELIMINAR */
if(isset($_GET['eliminar'])){

    $stmt = $conn->prepare("DELETE FROM tandas WHERE idtanda=?");
    $stmt->bind_param("i", $_GET['eliminar']);
    $stmt->execute();

    header("Location: tandas.php");
    exit;
}

/* LISTAR */
$result = $conn->query("SELECT * FROM tandas");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Gestión de Tandas</title>

<style>
:root{
    --rojo:#6b0f1a;
    --rojo-oscuro:#4a0a12;
    --gris:#f2f2f2;
}

body{
    font-family:Arial, sans-serif;
    background:var(--gris);
    padding:20px;
}

.main-wrapper{
    max-width:900px;
    margin:auto;
    background:white;
    padding:25px;
    border:2px solid var(--rojo);
}

.btn-volver{
    display:inline-block;
    background:var(--rojo);
    color:white;
    padding:8px 15px;
    text-decoration:none;
    margin-bottom:15px;
}

.btn-volver:hover{
    background:var(--rojo-oscuro);
}

h2{
    color:var(--rojo);
    border-bottom:2px solid var(--rojo);
    padding-bottom:5px;
}

input{
    width:100%;
    padding:8px;
    margin:5px 0 10px;
    border:1px solid #aaa;
}

button{
    background:var(--rojo);
    color:white;
    padding:10px;
    border:none;
    width:100%;
    cursor:pointer;
}

button:hover{
    background:var(--rojo-oscuro);
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

th{
    background:var(--rojo);
    color:white;
    padding:8px;
}

td{
    padding:8px;
    border:1px solid #ddd;
}

a{
    color:var(--rojo);
    text-decoration:none;
    font-weight:bold;
}
</style>
</head>
<body>

<div class="main-wrapper">

<a class="btn-volver" href="index.php">↩ Volver</a>

<h2>Registrar Tanda</h2>

<form method="POST">

    <input type="text"
           name="nombre_tanda"
           placeholder="Nombre de la tanda (Ej: Matutina)"
           required>

    <label>Hora inicio:</label>
    <input type="time" name="hora_inicio" required>

    <label>Hora fin:</label>
    <input type="time" name="hora_fin" required>

    <button type="submit" name="guardar">Guardar Tanda</button>

</form>


<h2>Listado de Tandas</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Tanda</th>
        <th>Hora Inicio</th>
        <th>Hora Fin</th>
        <th>Acción</th>
    </tr>

<?php while($row = $result->fetch_assoc()){ ?>

<tr>
    <td><?= $row['idtanda'] ?></td>
    <td><?= $row['nombre_tanda'] ?></td>
    <td><?= $row['hora_inicio'] ?></td>
    <td><?= $row['hora_fin'] ?></td>
    <td>
        <a href="?eliminar=<?= $row['idtanda'] ?>"
           onclick="return confirm('¿Eliminar esta tanda?')">
           Eliminar
        </a>
    </td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>
