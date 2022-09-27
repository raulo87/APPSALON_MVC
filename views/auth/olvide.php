<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Ingrese su correo para recuperar su contraseña</p>

<?php
    include_once __DIR__ . '/../templates/alertas.php';
?>

<form class="formulario" action="/olvide" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Ingresa Tu Email"/>
    </div>

    <input type="submit" value="Enviar Instrucciones" class="boton">
</form>

<div class="acciones">
    <a href="/crear_cuenta">¿Aún no tienes cuenta? ¡Crea una!</a>
    <a href="/">¿Ya no tienes cuenta? ¡Inicia Sesión!</a>
</div>