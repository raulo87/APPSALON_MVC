<h1 class="nombre-pagina">Nuevo Servicios</h1>
<p class="descripcion-pagina">Completa el formulario para crear un nuevo servicio</p>

<?php
 //   include_once __DIR__ . '/../templates/barra.php';
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form action="/servicios/crear" method="POST" class="formulario">

<?php include_once __DIR__ . '/formulario.php'; ?>

<div class="barra-servicios">
    <input type="submit" class="boton" value="Nuevo Servicio"/>
    <a href="/admin" class="boton">Atrás</a>
</div>
</form>