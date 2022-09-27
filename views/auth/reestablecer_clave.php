<h1 class="nombre-pagina">Recuperar Contraseña</h1>
<p class="descripcion-pagina">Ingrese la nueva contraseña</p>

<?php
    include_once __DIR__ . '/../templates/alertas.php';
?>

<?php if(!$error): ?>

<form class="formulario" method="POST" autocomplete="off">
    <div class="campo">
        <label for="password">Nueva</label>
        <input type="password" id="password" name="password" placeholder="Nueva Contraseña"/>
    </div>

    <div class="campo">
        <label for="repeat_password">Repetir</label>
        <input type="password" id="repeat_password" name="repeat_password" placeholder="Repite la Contraseña" />
    </div>
    
    <input type="submit" class="boton" value="Restablecer Contraseña" />
</form>

<?php endif; ?>
<div class="acciones">
    <a href="/">Volver al Inicio</a>    
</div>