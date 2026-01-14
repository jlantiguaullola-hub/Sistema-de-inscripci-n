<?php
// include("conexion.php"); // Si la necesitas
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Dominicana en Números</title>

<style>
body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #ffffff;
    color: #333;
}

/* ===== HEADER ===== */
.header {
    background: #f3f3f3;
    padding: 20px 40px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header img {
    height: 58px;
}

.btn-volver {
    background: #d60000;
    color: white;
    padding: 10px 25px;
    border-radius: 30px;
    font-size: 16px;
    font-weight: bold;
    text-decoration: none;
    transition: 0.3s;
    box-shadow: 0 4px 10px rgba(214,0,0,0.3);
}

.btn-volver:hover {
    background: #a80000;
    transform: translateY(-2px);
}

/* ===== TITULOS ===== */
h1, h2 {
    text-align: center;
    margin: 40px 0 20px;
    font-size: 32px;
}

/* ===== CIRCULOS ===== */
.circulos {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 35px;
    margin-bottom: 60px;
}

.circulo {
    width: 140px;
    height: 140px;
    border: 3px solid #e5e5e5;
    border-radius: 50%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    font-size: 22px;
    font-weight: bold;
    padding: 10px;
    transition: 0.3s;
    cursor: pointer;
}

.circulo span {
    font-size: 12px;
    font-weight: normal;
    margin-top: 8px;
    line-height: 1.2;
    max-width: 110px;
}

.circulo:hover {
    border-color: #d60000;
    color: #d60000;
    transform: scale(1.08);
}

/* ===== FOOTER ===== */
.footer {
    background: #f3f3f3;
    padding: 40px;
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 30px;
    font-size: 15px;
}

.footer h3 {
    margin-bottom: 10px;
    font-size: 18px;
}

.footer hr {
    width: 30px;
    height: 3px;
    background: #d60000;
    border: none;
    margin: 8px 0 15px;
}
</style>
</head>

<body>

<!-- HEADER -->
<div class="header">
    <!-- BOTÓN A LA IZQUIERDA -->
    <a href="index.php" class="btn-volver">Volver</a>

    <!-- LOGO A LA DERECHA -->
    <img src="fe.png" alt="Logo">
</div>

<!-- CONTENIDO -->
<h1>Dominicana en Números</h1>

<div class="circulos">
    <div class="circulo">34,048 <span>ESTUDIANTES</span></div>
    <div class="circulo">1,461 <span>DOCENTES</span></div>
    <div class="circulo">726 <span>PERSONAL ADMINISTRATIVO</span></div>
    <div class="circulo">943 <span>PERSONAL DE APOYO</span></div>
    <div class="circulo">63 <span>CENTROS EDUCATIVOS</span></div>
</div>

<h2>Centros por Región</h2>

<div class="circulos">
    <div class="circulo">15 <span>PROVINCIAS</span></div>
    <div class="circulo">07 <span>ZONA ESTE</span></div>
    <div class="circulo">17 <span>ZONA SUR</span></div>
    <div class="circulo">11 <span>ZONA NORTE</span></div>
    <div class="circulo">28 <span>SANTO DOMINGO</span></div>
</div>

<!-- FOOTER -->
<div class="footer">
    <div>
        <h3>Fe y Alegría RD</h3>
        <hr>
        <p>Asociación Fe y Alegría Inc. establecida en 1990.</p>
    </div>

    <div>
        <h3>Últimas Noticias</h3>
        <hr>
        <p>- Plan Estratégico 2026–2030</p>
        <p>- Fe y Alegría Dominicana en NY</p>
    </div>

    <div>
        <h3>Nuestras Alianzas</h3>
        <hr>
        <p>- Empresas</p>
        <p>- Instituciones académicas</p>
        <p>- Fundaciones</p>
    </div>

    <div>
        <h3>Contacto</h3>
        <hr>
        <p><strong>Dirección:</strong> Calle Cayetano Rodríguez #114</p>
        <p><strong>Teléfono:</strong> (809) 221-2786</p>
        <p><strong>Email:</strong> info@feyalegria.org.do</p>
    </div>
</div>

</body>
</html>
