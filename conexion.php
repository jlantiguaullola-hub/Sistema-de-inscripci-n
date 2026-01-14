<?php
$server = "localhost";
$user = "Jlantigua";
$pass = "JoSe2L20";
$db = "amengual";

$conn = new mysqli($server, $user, $pass, $db);

if ($conn->connect_errno) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
