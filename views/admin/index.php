<h1 class=""nombre-pagina>Panel de Administración</h1>
<?php include_once __DIR__ . '/../templates/barra.php'; ?>

<h2>Buscar Citas</h2>
<div class="busqueda">
    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date" id='fecha' name='fecha' value="<?php echo $fecha ?>" />
        </div>
    </form>
</div>
<div id="citas-admin">
    <?php if(isset($_SESSION['cita_eliminada']) && $_SESSION['cita_eliminada']): ?>
        <p class="alerta exito">Cita Eliminada Satisfactoriamente</p>        
    <?php 
            $_SESSION['cita_eliminada'] = '';
        endif; ?>
    <ul class="citas">
        <?php
            $idCita = 0;
            $primerCita = $citas[0]->id ?? 0;
            $total = 0;
            foreach($citas as $cita):
                if($primerCita === $cita->id){
                    $total += $cita->precio;
                }else{
                ?>
                <!-- Imprimimos el total antes de pasar a la sigueinte cita, con el útlimo no va a entrar acá así que tenemos que mostrarlo al final del foreach-->
                <p class="total">TOTAL: $<span><?php echo $total; ?></span></p>
                <form action="/api/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $primerCita; ?>">
                    <input type="submit" class="boton-eliminar" value="Eliminar">
                </form>
                <?php
                    $total = $cita->precio;
                    $primerCita = $cita->id;
                }

                if($idCita !== $cita->id):
                    $idCita = $cita->id;                   
        ?>            
                <li>
                    <p>ID: <span><?php echo $cita->id; ?></span></p>
                    <p>FECHA: <span><?php echo $cita->fecha; ?></span></p>
                    <p>CLIENTE: <span><?php echo $cita->cliente; ?></span></p>
                    <p>EMAIL: <span><?php echo $cita->email; ?></span></p>
                    <p>TELEFONO: <span><?php echo $cita->telefono; ?></span></p>
                </li>
                    <h3>Servicios</h3>                    
                    <?php endif; ?>
                <p class="servicio"><?php echo $cita->servicio . ' $' . $cita->precio; ?></p>
        <?php endforeach; ?>
        <!-- imprimimos el total del útlimo elemento del array que no cae en el if del principio-->
        <?php if ($total > 0): ?>
            <p class="total">TOTAL: $<span><?php echo $total ?></span></p>
            
            <form action="/api/eliminar" method="POST">
                    <input type="hidden" name="id" value="<?php echo $cita->id; ?>">
                    <input type="submit" class="boton-eliminar" value="Eliminar">
            </form>
        <?php else: ?>
            <h2>No hay citas</h2>
        <?php endif;?>
    </ul>    
</div>

<?php $script='<script src="build/js/buscador.js"></script>'; ?>