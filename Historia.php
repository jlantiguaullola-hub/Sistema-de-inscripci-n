<?php
// include("conexion.php");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Historia Fe y Alegría RD</title>

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

/* ===== CONTENIDO ===== */
.contenido {
    max-width: 1200px;
    margin: 60px auto;
    padding: 0 40px;
}

/* ORIGEN */
.origen {
    display: grid;
    grid-template-columns: 1fr 400px;
    gap: 40px;
    align-items: center;
    margin-bottom: 80px;
}

.origen img {
    width: 100%;
    max-width: 400px;
    height: auto;
}

.origen h1 {
    font-size: 32px;
    margin-bottom: 20px;
}

.origen p {
    font-size: 18px;
    line-height: 1.7;
}

.frase {
    margin-bottom: 20px;
}

.frase .rojo {
    color: #d60000;
}

.frase small {
    font-size: 14px;
    color: #666;
}

/* HISTORIA RD */
.historia h2 {
    font-size: 32px;
    margin-bottom: 20px;
}

.historia .rojo {
    color: #d60000;
}

.historia p {
    font-size: 18px;
    line-height: 1.7;
    margin-bottom: 25px;
}

.titulo-historia {
    color: #d60000;   /* rojo */
    text-align: left;
    font-size: 32px;
    margin-bottom: 30px;
}

/* IMAGEN FINAL */
.imagen-final {
    max-width: 1200px;
    margin: 60px auto;
    padding: 0 40px;
}

.imagen-final img {
    width: 100%;
    height: 80vh;
    object-fit: cover;
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

<!-- CONTENIDO -->
<div class="contenido">

    <!-- ORIGEN -->
    <div class="origen">
        <div>
            <h1>ORÍGEN DE FE Y ALEGRÍA</h1>

            <div class="frase">
                <span class="rojo">“Quizás esta chispa llegue a incendio: Nace una obra”</span><br>
                <small>
                    Quien por vivir en el amor sirve a sus hermanos por amor, vive ya en la tierra la felicidad.  
                    <br>— Padre José María Vélaz, SJ (1981)
                </small>
            </div>

            <p>El Padre José María Vélaz, s.j. (†1985), fundador de Fe y Alegría, nació en Chile, donde vivió sus primeros diez años, lo que marcó profundamente su sensibilidad latinoamericana. Desde joven estudió en colegios de la Compañía de Jesús y se formó como miembro jesuita. En 1946 fue enviado a Venezuela, un país con grandes desigualdades y alto analfabetismo, donde soñó con crear una red de escuelas en las comunidades más olvidadas, comenzando su trabajo con jóvenes universitarios en 1960.</p>

<p>El 5 de marzo de 1955 fundó la primera escuela de Fe y Alegría en la parroquia 23 de Enero de Caracas, con el apoyo de estudiantes de la Universidad Católica Andrés Bello. El grupo buscaba transformar el país ofreciendo ayuda a los más pobres, y bajo la guía del padre Vélaz preparó a 70 niños y niñas para su primera comunión.</p>

<p>La iniciativa fue posible gracias a la donación de Abraham Reyes y su esposa Patricia, quienes ofrecieron su hogar, reconstruido tras un incendio, para la escuela. Abraham expresó: "Si usted pone las maestras, yo pongo la casa. Si la convertimos en escuela, será la casa de todos los niños y niñas del barrio".</p>

<p>Así nació Fe y Alegría, iniciando labores con 100 niños y niñas sentados en el piso, y apoyado por tres jóvenes del barrio como primeras maestras. Con el tiempo, el proyecto creció hasta contar con más de 200 centros educativos en Venezuela, llevando educación y esperanza a miles de niños y jóvenes. De esta forma, los jóvenes universitarios iban "con fe y regresaban con alegría", de donde surge el nombre del movimiento.</p>

        </div>

        <img src="padrevelaz.jpg" alt="Padre José María Vélaz">
    </div>

    <!-- HISTORIA RD -->
    <div class="historia">
       <h2 class="titulo-historia">HISTORIA DE FE Y ALEGRÍA EN REPÚBLICA DOMINICANA</h2>


        <p>
           Los preparativos para la llegada de Fe y Alegría a la República Dominicana comenzaron en 1964, cuando el padre Federico Arvesú, sj, solicitó la ayuda del padre José María Vélaz, sj. Diversos factores retrasaron el avance hasta febrero de 1966. Entre las personas clave en los inicios destacan: José María Vélaz, Federico Arvesú, José Fernández Olmo, José Somoza, Felipe Arroyo Villar y Nelson C. García.</p>

<p>El 23 de marzo de 1990 se presentó el proyecto a 18 congregaciones religiosas femeninas para recabar apoyo. El 20 de septiembre de 1990, tras la visita de varios jesuitas, se instaló una Junta Directiva Provisional, con el padre Ignacio Villar (P. Chuco), sj como primer Director Nacional.</p>

<p>El 8 de diciembre de 1990, mediante el decreto presidencial 505-90, Fe y Alegría recibió personalidad jurídica y fue incorporada como institución sin fines de lucro. El 31 de mayo de 1991 firmó un acuerdo de cooperación con el Estado a través del Ministerio de Educación (MINERD), siendo definida como una esperanza en un contexto de conflictos educativos. Finalmente, el 26 de septiembre de 1991 se realizó la presentación oficial al público y se instaló la primera Junta Directiva formal, presidida por el Lic. Eduardo Fernández Pichardo.
        </p>
    </div>

</div>

<!-- IMAGEN GRANDE -->
<div class="imagen-final">
    <img src="Fe y alegria niños.jpg" alt="Historia RD">
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
