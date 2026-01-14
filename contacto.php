<?php
// Página de contacto – Politécnico Reverendo Andrés Amengual – Fe y Alegría
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contacto | Politécnico Reverendo Andrés Amengual – Fe y Alegría</title>

  <style>
    *{margin:0;padding:0;box-sizing:border-box}
    body{font-family:Arial, Helvetica, sans-serif;background:#f4f6f8}

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

    .container{
      max-width:1100px;
      margin:30px auto;
      padding:20px;
      background:#fff;
      border-radius:8px;
      box-shadow:0 4px 10px rgba(0,0,0,0.1);
    }

    .info{
      margin-bottom:20px;
      font-size:16px;
      line-height:1.6;
    }

    .map{
      width:100%;
      height:450px;
      border-radius:8px;
      overflow:hidden;
      margin-bottom: 60px; /* separación del mapa */
    }

    iframe{
      width:100%;
      height:100%;
      border:0;
    }

    /* ===== CIRCULOS ===== */
    .equipo {
        display: flex;
        justify-content: center;
        gap: 30px;
        flex-wrap: wrap;
        margin-bottom: 50px;
    }

    .persona {
        text-align: center;
        width: 120px;
    }

    .circulo {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        border: 4px solid #e5e5e5;
        transition: 0.4s ease;
        box-shadow: 0 8px 15px rgba(0,0,0,0.15);
    }

    .circulo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .circulo:hover {
        border-color: #d60000;
        transform: translateY(-8px) scale(1.05);
        box-shadow: 0 12px 25px rgba(214,0,0,0.3);
    }

    .nombre {
        margin-top: 12px;
        font-size: 14px;
        font-weight: bold;
        color: #333;
    }

    /* ===== FOOTER ===== */
    .footer {
        background: #f3f3f3;
        padding: 40px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 30px;
        font-size: 15px;
        margin-top: 30px;
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
    h1, h2 {
    text-align: center;
    margin: 40px 0 20px;
    font-size: 32px;
}
  </style>
</head>
<body>

<!-- HEADER -->
<div class="header">
    <a href="index.php" class="btn-volver">Volver</a>
    <img src="fe.png" alt="Logo">
</div>

<div class="container">
  <div class="info">
    <strong>Politécnico Reverendo Andrés Amengual – Fe y Alegría</strong><br>
    República Dominicana<br><br>
    Para más información, puede visitarnos en nuestra ubicación.
  </div>

  <!-- MAPA -->
  <div class="map">
    <iframe 
      src="https://www.google.com/maps?q=Politécnico%20Reverendo%20Andrés%20Amengual%20Fe%20y%20Alegría%20República%20Dominicana&output=embed"
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade">
    </iframe>
  </div>

 
</div>
<h1>Nuestro Equipo</h1>
 <!-- CIRCULOS -->
  <div class="equipo">
      <div class="persona">
          <div class="circulo"><img src="fe.png"></div>
          <div class="nombre">carlos</div>
      </div>

      <div class="persona">
          <div class="circulo"><img src="fe.png"></div>
          <div class="nombre">veralis</div>
      </div>

      <div class="persona">
          <div class="circulo"><img src="fe.png"></div>
          <div class="nombre">jose</div>
      </div>

      <div class="persona">
          <div class="circulo"><img src="fe.png"></div>
          <div class="nombre">yaskeilin</div>
      </div>

      <div class="persona">
          <div class="circulo"><img src="fe.png"></div>
          <div class="nombre">adrielis</div>
      </div>
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
