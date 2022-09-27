<h1 class="nombre-pagina">Registrar Cuenta</h1>
<p class="descripcion-pagina">Completa el formulario para crear tu cuenta</p>

<?php
    include_once __DIR__ . '/../templates/alertas.php';
?>
<form class="formulario" method="POST" action="/crear_cuenta">

    <div class="campo">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" placeholder="escribe tu Nombre" value="<?php echo s($usuario->nombre); ?>"/>
    </div>
    <div class="campo">
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" placeholder="escribe tu Apellido" value="<?php echo s($usuario->apellido); ?>"/>
    </div>
    <div class="campo">
        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" placeholder="escribe tu Teléfono" value="<?php echo s($usuario->telefono); ?>"/>
    </div>

    <div class="campo">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="escribe tu Email" value="<?php echo s($usuario->email); ?>"/>
    </div>
    <div class="campo">
        <label for="password">Contraseña:</label>
        <input type="password" id="password" name="password" placeholder="escribe tu Contraseña" />
    </div>

    <input type="submit" value="Crear Cuenta" class="boton" />
</form>

<div class="acciones">
    <a href="/">¿Ya no tienes cuenta? ¡Inicia Sesión!</a>
    <a href="/olvide">Olvidé mi contraseña</a>
</div>