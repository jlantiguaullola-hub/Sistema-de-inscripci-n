<?php include("conexion.php"); ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Fe y Alegría</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
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

        .fe-alegria {
            padding: 50px;
            position: relative;
        }

        .texto {
            max-width: 800px;
            margin: 0 auto;
        }

        .texto h1 {
            font-size: 40px;
            margin-bottom: 20px;
            color: #d60000;
            text-align: left;
        }

        .texto p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 20px;
            color: #555;
        }

        .contenedor-inferior {
            display: flex;
            justify-content: center;
            margin-top: 60px;
            gap: 40px;
            text-align: center;
        }

        .bloque {
            flex: 1;
            max-width: 300px;
        }

        .icono {
            width: 60px;
            height: 60px;
            background: #b40000;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin: 0 auto 15px;
        }

        .bloque h3 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .bloque p, .bloque li {
            font-size: 16px;
            color: #555;
            line-height: 1.6;
        }

        .bloque ul {
            list-style: none;
            padding: 0;
        }

        .bloque li::before {
            content: "❤️ ";
        }

        .caracteristicas {
            margin-top: 60px;
            max-width: 1000px;
            margin-left: auto;
            margin-right: auto;
        }

        .caracteristicas h2 {
            color: #d60000;
            font-size: 28px;
            margin-bottom: 20px;
            text-align: left;
        }

        .caracteristicas ul {
            list-style: none;
        }

        .caracteristicas li {
            font-size: 18px;
            line-height: 1.6;
            color: #555;
            margin-bottom: 20px;
            position: relative;
            padding-left: 30px;
        }

        .caracteristicas li::before {
            content: "❤️";
            position: absolute;
            left: 0;
            top: 2px;
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
    <a href="index.php" class="btn-volver">Volver</a>
    <img src="fe.png" alt="Logo">
</div>

<section class="fe-alegria">

    <div class="texto">
        <h1>¿Qué es Fe y Alegría?</h1>

        <p>
            Es un movimiento internacional de educación popular y promoción social, 
            gestionado por la Compañía de Jesús, en colaboración con diversas personas e 
            instituciones comprometidas con la construcción de un mundo más humano y justo; 
            promoviendo y defendiendo la universalidad del derecho a la educación de calidad 
            como bien público.
        </p>

        <p>
            Formamos parte de un movimiento de educación popular presente en 22 países, 
            donde promovemos y defendemos el derecho a la educación de calidad.
        </p>
    </div>

    <div class="contenedor-inferior">

        <div class="bloque">
            <div class="icono">🔥</div>
            <h3>Misión</h3>
            <p>
                Promover procesos educativos integrales e inclusivos para garantizar el 
                derecho universal a una educación de calidad como bien público, fomentando 
                la justicia social, la equidad y el desarrollo humano sostenible.
            </p>
        </div>

        <div class="bloque">
            <div class="icono">✏️</div>
            <h3>Visión</h3>
            <p>
                Ser un referente de educación popular integral, inclusiva y de calidad, con 
                incidencia en las políticas nacionales e internacionales, contribuyendo a 
                la transformación social y a la construcción de una sociedad más justa.
            </p>
        </div>

        <div class="bloque">
            <div class="icono">❤️</div>
            <h3>Valores</h3>
            <ul>
                <li>Calidad educativa</li>
                <li>Inclusión social</li>
                <li>Compromiso</li>
                <li>Solidaridad</li>
                <li>Justicia</li>
                <li>Responsabilidad</li>
            </ul>
        </div>

    </div>

    <div class="caracteristicas">

        <h2>Características propias de nuestro movimiento:</h2>

        <ul>
            <li><strong>Movimiento internacional:</strong> presente en más de 22 países.</li>
            <li><strong>Educación popular integral:</strong> desarrollo humano completo.</li>
            <li><strong>Opción por los excluidos:</strong> educación donde termina el asfalto.</li>
            <li><strong>Promoción social:</strong> compromiso comunitario.</li>
            <li><strong>Inspiración ignaciana:</strong> fe que se hace justicia.</li>
            <li><strong>Alianza y corresponsabilidad:</strong> la educación es tarea de todos.</li>
        </ul>

    </div>

</section>

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
