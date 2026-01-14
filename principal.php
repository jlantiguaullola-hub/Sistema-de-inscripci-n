<?php
// pagina_inicio_interactiva.php
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Página Interactiva</title>

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", sans-serif;
            background: url('colegio.png'); /* Cambia por tu imagen */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            overflow: hidden;
            position: relative; /* Necesario */
        }

        /* Pantalla inicial con logo */
        #intro-logo {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0,0,0,0.6);
            display: flex;
            justify-content: center;
            align-items: center;
            transition: opacity 1s ease-out;
            z-index: 10;
        }

        #intro-logo img {
            width: 350px; /* Más grande */
            opacity: 0;
            animation: fadeIn 1.8s forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.7); }
            to { opacity: 1; transform: scale(1); }
        }

        /* Contenido principal centrado */
        #contenido {
            opacity: 0;
            transform: translateY(40px);
            transition: 1s ease;
            color: white;
            padding: 20px;
            text-shadow: 0 0 10px rgba(0,0,0,0.9);
        }

        .visible {
            opacity: 1 !important;
            transform: translateY(0) !important;
        }

        h1 {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        p {
            font-size: 1.3rem;
            max-width: 700px;
            margin: 0 auto 25px auto;
        }

        /* Botón rojo */
        .btn-login {
            display: inline-block;
            padding: 14px 35px;
            background: #d82323;
            color: white;
            border-radius: 40px;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-login:hover {
            background: #b31212;
        }

    .fondo-opaco {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0,0,0,0.55); /* Opacidad permanente */
            z-index: 1;
        }

        #contenido {
            position: relative;
            z-index: 2;
        }

    </style>
</head>
<body>

    <!-- Capa oscura permanente -->
    <div class="fondo-opaco"></div>

    <!-- Logo inicial -->
    <div id="intro-logo">
        <img src="fe.png" alt="Logo" />
    </div>

    <!-- Contenido principal -->
    <div id="contenido">
        <h1> Bienvenido a Nuestro Sistema de Inscripción</h1>
        <p>
           Completa tu proceso de inscripción en línea de manera eficiente. Nuestro sistema te 
guía paso a paso para que puedas formalizar tu ingreso sin complicaciones.
        </p>

        <a href="login.php" class="btn-login">Comenzar</a>
    </div>

    <script>
        window.onload = function() {
            setTimeout(() => {
                document.getElementById("intro-logo").style.opacity = 0;

                setTimeout(() => {
                    document.getElementById("intro-logo").style.display = "none";
                    document.getElementById("contenido").classList.add("visible");
                }, 900);
            }, 2200);
        }
    </script>

</body>
</html>
