<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sistema de Gestión Escolar | Politécnico Fe y Alegría</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">

  <style>
    /* Sidebar */
    .main-sidebar { background-color: #ffffffff !important; }
    .nav-sidebar .nav-link {
      color: #000000ff !important;
      background-color: rgba(223, 209, 209, 1) !important;
      margin: 4px 0;
      border-radius: 5px;
      font-size: 16px !important;
      padding: 12px 10px !important;
    }
    .nav-sidebar .nav-link:hover { background-color: #ffffffff !important; }
    .nav-treeview .nav-link { background-color: #ffffffff !important; font-size: 15px !important; padding: 10px 20px !important; }

    .brand-link {
      background-color: white !important;
      color: #000000f1 !important;
      border-bottom: 1px solid #ffffffff;
      font-size: 18px !important;
      padding: 10px !important;
    }

    body, .content-wrapper, .content, .content-header { background: white !important; font-family: Arial, sans-serif; }

    /* Redes sociales */
    .social-buttons { display: flex; gap: 10px; align-items: center; justify-content: center; margin-top: 8px; }
    .social-button {
      width: 50px !important;
      height: 50px !important;
      display: flex; justify-content: center; align-items: center;
      font-size: 25px !important;
      text-decoration: none;
      background: transparent !important;
      color: inherit !important;
      transition: transform 0.2s, opacity 0.2s;
    }
    .dropdown-menu {
  border-radius: 6px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.dropdown-item {
  font-size: 15px;
  padding: 10px 20px;
  color: #333;
}

.dropdown-item:hover {
  background-color: #f5f5f5;
}
    .social-button[title="Facebook"] { color: #1877F2 !important; }
    .social-button[title="Telegram"] { color: #0088cc !important; }
    .social-button[title="YouTube"] { color: #FF0000 !important; }
    .social-button[title="Instagram"] { color: #E4405F !important; }
    .social-button[title="LinkedIn"] { color: #0A66C2 !important; }
    .social-button[title="Twitter"] { color: #1DA1F2 !important; }
    .social-button:hover { transform: scale(1.2); opacity: .8; }

    /* Animaciones para tarjetas */
    .under-logo .card:hover { transform: translateY(-5px); transition: 0.3s; }

  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a></li>
      <li class="nav-item d-none d-sm-inline-block"><a href="#" class="nav-link">Inicio</a></li>
    </ul>

    <div class="social-buttons">
        <a href="https://www.facebook.com/feyalegriard/" target="_blank" class="social-button" title="Facebook"><i class="fab fa-facebook-f"></i></a>
        <a href="https://www.feyalegria.org.do/" target="_blank" class="social-button" title="Telegram"><i class="fab fa-telegram-plane"></i></a>
        <a href="https://www.youtube.com/@FeyAlegriaRD" target="_blank" class="social-button" title="YouTube"><i class="fab fa-youtube"></i></a>
        <a href="https://www.instagram.com/feyalegriadominicana/" target="_blank" class="social-button" title="Instagram"><i class="fab fa-instagram"></i></a>
        <a href="https://mx.linkedin.com/company/feyalegriadominicana" target="_blank" class="social-button" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
        <a href="https://www.feyalegria.org.do/" target="_blank" class="social-button" title="Twitter"><i class="fab fa-twitter"></i></a>
    </div>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item"><a class="nav-link" data-widget="fullscreen" href="#" role="button"><i class="fas fa-expand-arrows-alt"></i></a></li>
      <!-- QUIÉNES SOMOS -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="quienesSomos" role="button" data-toggle="dropdown">
          QUIÉNES SOMOS
        </a>

        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="quienesSomos" style="width:280px;">
          <a class="dropdown-item" href="Fe y Alegria.php">Fe y Alegria </a>
           <a class="dropdown-item" href="Historia.php">Historia en Dominicana</a>
          <a class="dropdown-item" href="Dnumeros.php">Dominicana en Números</a>
          <a class="dropdown-item" href="red.php">Trabajo en Red</a>
            <a class="dropdown-item" href="contacto.php">Contacto</a>
        </div>
      </li>

      <li class="nav-item"><a class="nav-link" href="login.php" role="button"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
    </ul>
  </nav>

  <!-- Sidebar -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link"><i class="fas fa-school ml-2"></i><span class="brand-text font-weight-light"><b>Politécnico Fe y Alegría</b></span></a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item"><a href="cofiguracion.php" class="nav-link"><i class="nav-icon fas fa-cog"></i><p>Configuración</p></a></li>
          <li class="nav-item"><a href="Gestion.php" class="nav-link"><i class="nav-icon fas fa-tasks"></i><p>Gestión</p></a></li>
          <li class="nav-item"><a href="periodo.php" class="nav-link"><i class="nav-icon fas fa-calendar-alt"></i><p>Períodos</p></a></li>
          <li class="nav-item"><a href="Grado.php" class="nav-link"><i class="nav-icon fas fa-graduation-cap"></i><p>Grados</p></a></li>
          <li class="nav-item"><a href="Tandas.php" class="nav-link"><i class="nav-icon fas fa-clock"></i><p>Tandas</p></a></li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link"><i class="nav-icon fas fa-sign-out-alt"></i><p>Salidas<i class="fas fa-angle-left right"></i></p></a>
            <ul class="nav nav-treeview">
              <li class="nav-item"><a href="politecnico.php" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Salidas técnicas</p></a></li>
              <li class="nav-item"><a href="Academica.php" class="nav-link"><i class="far fa-circle nav-icon"></i><p>Académica</p></a></li>
            </ul>
          </li>
          <li class="nav-item"><a href="tutores.php" class="nav-link"><i class="nav-icon fas fa-user-tie"></i><p>Tutores</p></a></li>
          <li class="nav-item"><a href="administrador.php" class="nav-link"><i class="nav-icon fas fa-user-tie"></i><p>Administrador</p></a></li>
          <li class="nav-item"><a href="docente.php" class="nav-link"><i class="nav-icon fas fa-user-tie"></i><p>Docentes</p></a></li>
          <li class="nav-item"><a href="estudiante.php" class="nav-link"><i class="nav-icon fas fa-user-tie"></i><p>Estudiantes</p></a></li>
          <li class="nav-item"><a href="Reporte.php" class="nav-link"><i class="nav-icon fas fa-file-alt"></i><p>Reportes</p></a></li>
        </ul>
      </nav>
    </div>
  </aside>

  <!-- Content Wrapper -->
  <section class="content">
    <div class="container-fluid">

     <!-- Texto de bienvenida -->
<div class="welcome-text" style="text-align: center; margin-bottom: 20px; margin-left: 300px;">
  <h1 style="font-weight: bold;">Bienvenido al Sistema de Gestión Escolar</h1>
</div>


 <!-- Logo centrado pero movido a la derecha -->
<div class="logo-wrapper" style="text-align: center; margin-bottom: 30px; margin-left: 300px;">
    <img src="fe.png" style="width: 950px; height: auto;">
</div>


 <!-- Sección bajo el logo -->
<div class="under-logo" style="text-align: center; margin-bottom: 50px;">
  <h2 style="color: #d32f2f; font-weight: bold; margin-bottom: 20px; margin-left: 300px;">
    <center>¡Aprendemos y crecemos juntos cada día!</center>
  </h2>
</div>



<!-- Tarjetas de información centradas y más grandes -->
<div style="display: flex; justify-content: center; gap: 30px; flex-wrap: wrap; margin-left: 300px;">
  <div class="card" style="background: #f8f9fa; padding: 25px; width: 260px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
    <h4>Últimas Noticias</h4>
    <p>Mira las actividades más recientes en nuestro politécnico.</p>
  </div>

  <div class="card" style="background: #f8f9fa; padding: 25px; width: 260px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
    <h4>Eventos</h4>
    <p>No te pierdas los próximos eventos y salidas académicas.</p>
  </div>

  <div class="card" style="background: #f8f9fa; padding: 25px; width: 260px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
    <h4>Recursos</h4>
    <p>Accede a materiales y recursos educativos desde aquí.</p>
  </div>
</div>

  <!-- Footer -->
  <footer class="main-footer">
    <div style="text-align: center;">
      <strong>Copyright &copy; 2025 <a href="#">Politécnico Reverendo Andres Amengual </a>.</strong>
      Todos los derechos reservados. <strong>P.Velaz. PENSANDO EN LOS QUE VENDRÁN.</strong>
    </div>
  </footer>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
