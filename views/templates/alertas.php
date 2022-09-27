<?php
    foreach ($alertas as $llave => $mensajes):
        foreach($mensajes as $mensaje):
?>
    <div class="alerta <?php echo $llave; ?>">
            <?php echo $mensaje; ?>
    </div>
<?php
        endforeach;
    endforeach;
?>