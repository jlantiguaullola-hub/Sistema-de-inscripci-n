<?php
// trabajo-en-red.php
?><!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trabajo en Red | Fe y Alegría</title>

  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      margin: 0;
      line-height: 1.6;
      color: #333;
    }

    /* HEADER */
    header {
      background: #ffffff;
      border-bottom: 4px solid #c40000;
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      position: relative;
    }

    .btn-volver {
      text-decoration: none;
      background: #c40000;
      color: #fff;
      padding: 8px 16px;
      border-radius: 5px;
      font-size: 14px;
    }

    .logo-header img {
      height: 50px;
    }

    header h1 {
      color: #c40000;
      margin: 0;
      font-size: 32px;
      text-transform: uppercase;
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
    }

    section {
      padding: 40px;
      max-width: 1200px;
      margin: auto;
    }

    .highlight {
      color: #c40000;
      font-weight: bold;
    }

    /* SLIDER */
    .slider-section {
      background: #f4f6f8;
      padding: 40px 0;
      text-align: center;
    }

    .slider-container {
      position: relative;
      max-width: 1000px;
      height: 420px;
      margin: auto;
      overflow: hidden;
      border-radius: 10px;
    }

    .slider-container img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: none;
    }

    .slider-container img.active {
      display: block;
    }

    .slider-title {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: rgba(196,0,0,0.8);
      color: #fff;
      padding: 12px 30px;
      font-size: 28px;
      font-weight: bold;
      border-radius: 8px;
      letter-spacing: 2px;
    }

    /* REDES */
    .networks h2 {
      color: #c40000;
      text-transform: uppercase;
      margin-bottom: 20px;
    }

    .initiatives {
      margin-top: 30px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }

    .initiative {
      border-left: 5px solid #c40000;
      padding: 12px 16px;
      background: #fafafa;
    }

    footer {
      background: #c40000;
      color: #fff;
      padding: 20px 40px;
      text-align: center;
      font-size: 14px;
    }
  </style>
</head>

<body>

<header>
  <a href="index.php" class="btn-volver">← Volver</a>

  <h1>Trabajo en Red</h1>

  <div class="logo-header">
    <img src="fe.png" alt="Logo">
  </div>
</header>

<section class="intro">
  <p>
    En <span class="highlight">Fe y Alegría</span> trabajamos desde una lógica de 
    <strong>redes internacionales</strong>.
  </p>
  <p>
    Somos una asociación presente en más de <strong>22 países</strong>.
  </p>
</section>

<!-- SLIDER DE CAMPAÑAS -->
<section class="slider-section">
  <div class="slider-container">
    
    <div class="slider-title">CAMPAÑAS</div>

    <img src="Fe y alegria niños.png" class="active">
    <img src="Fe.png">
    <img src="Fe y alegria niños.png">
    <img src="Fe.png">

  </div>
</section>

<section class="networks">
  <h2>Redes Internacionales</h2>
  <p>
    En Fe y Alegría nos organizamos a través de la <strong>redarquía</strong>.
  </p>

  <div class="initiatives">
    <?php
    $iniciativas = [
      'Formación Pedagógica',
      'Calidad Educativa',
      'Evaluación e Impacto',
      'Ecología Integral',
      'Formación para el Trabajo',
      'Jóvenes',
      'Ciudadanía',
      'Género',
      'Educación Inclusiva',
      'Migración'
    ];

    foreach ($iniciativas as $item) {
      echo '<div class="initiative"><strong>' . $item . '</strong></div>';
    }
    ?>
  </div>
</section>

<footer>
  © Fe y Alegría – Trabajo en Red | Federación Internacional
</footer>

<script>
  let index = 0;
  const images = document.querySelectorAll(".slider-container img");

  setInterval(() => {
    images[index].classList.remove("active");
    index = (index + 1) % images.length;
    images[index].classList.add("active");
  }, 3500);
</script>

</body>
</html>
