
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema</title>

    <style>

        /* 🔥 Fondo con imagen opaca */
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start; /* Login ya no está centrado verticalmente */
            align-items: center;
            font-family: Arial, sans-serif;

            padding-top: 120px; /* ⬇️ LOGIN MÁS ABAJO */

            background-image: url('Fe y alegria niños.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;

            position: relative;
        }

        /* Oscurecer la imagen */
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.65);
            z-index: 1;
        }

        /* Login */
        .login-container {
            position: relative;
            z-index: 2;
            background-color: white;
            padding: 25px;
            width: 330px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.25);
        }

        img {
            width: 100%;
            margin-bottom: 10px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input, select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #d02020;
            color: white;
            border: none;
            border-radius: 4px;
        }

        .toggle-form {
            text-align: center;
            margin-top: 10px;
        }

        .toggle-form a {
            color: red;
            text-decoration: none;
        }

        /* 📌 Texto debajo del login */
        .info-demo {
            position: relative;
            z-index: 2;
            margin-top: 25px;
            text-align: center;
            color: white;
            max-width: 900px;
            padding: 15px;
            backdrop-filter: blur(2px);
        }

        .cuentas {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-top: 15px;
        }

        .cuentas div {
            width: 32%;
        }

        .info-demo h3 {
            margin-bottom: 5px;
        }

    </style>
</head>
<body>

    <div class="login-container">
        <img src="fe.png">
        <h2 id="form-title">Iniciar Sesión</h2>

        <form id="auth-form" action="index.php" method="POST">

            <div class="form-group">
                <label>Correo electrónico</label>
                <input type="email" name="email" required>
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <input type="password" name="contraseña" required>
            </div>

            <div class="form-group" id="name-group" style="display:none;">
                <label>Nombre completo</label>
                <input type="text" name="nombres">
            </div>

            <div class="form-group" id="role-group" style="display:none;">
                <label>Rol</label>
                <select name="rol">
                    <option value="Administrador">Administrador</option>
                    <option value="Secretario">Secretario</option>
                    <option value="Docentes">Docentes</option>
                    <option value="Estudiantes">Estudiantes</option>
                    <option value="Tutores">Tutores</option>
                </select>
            </div>

            <button type="submit" id="submit-btn" name="login">Iniciar Sesión</button>

        </form>

        <div class="toggle-form">
            <a href="" id="toggle-link">¿No tienes cuenta? Regístrate</a>
        </div>
    </div>

    <!-- 📌 TEXTO DE CUENTAS DEBAJO DEL LOGIN -->
    <div class="info-demo">
        <p><strong>Nota:</strong> Puedes probar este sistema con las siguientes cuentas.</p>

        <div class="cuentas">
            <div>
                <h3>Cuenta administrador</h3>
                <p><strong>Cuenta:</strong> carlosangel@gmail.com</p>
                <p><strong>Contraseña:</strong>2345678</p>
            </div>

            <div>
                <h3>Cuenta de docente</h3>
                <p><strong>Cuenta:</strong> Yona123@gmail.com</p>
                <p><strong>Contraseña:</strong> yo1234</p>
            </div>

            <div>
                <h3>Cuenta de estudiante</h3>
                <p><strong>Cuenta:</strong> Mari@gmail.com</p>
                <p><strong>Contraseña:</strong> M1234</p>
            </div>
        </div>
    </div>

    <script>
        const formTitle = document.getElementById('form-title');
        const submitBtn = document.getElementById('submit-btn');
        const toggleLink = document.getElementById('toggle-link');
        const nameGroup = document.getElementById('name-group');
        const roleGroup = document.getElementById('role-group');

        let isLogin = true;

        toggleLink.addEventListener("click", e => {
            e.preventDefault();
            isLogin = !isLogin;

            if (isLogin) {
                formTitle.textContent = "Iniciar Sesión";
                submitBtn.textContent = "Iniciar Sesión";
                submitBtn.name = "login";

                nameGroup.style.display = "none";
                roleGroup.style.display = "none";
            } else {
                formTitle.textContent = "Registrarse";
                submitBtn.textContent = "Registrarse";
                submitBtn.name = "registrar";

                nameGroup.style.display = "block";
                roleGroup.style.display = "block";
            }
        });
    </script>

</body>
</html>
