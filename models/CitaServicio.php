<?php

namespace Model;

use Model\ActiveRecord;

class CitaServicio extends ActiveRecord
{
    // Base de datos
    protected static $tabla = 'citas_servicios';
    protected static $columnasDB = ['id', 'cita_id', 'servicio_id'];

    public $id;
    public $cita_id;
    public $servicio_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->cita_id = $args['citaId'] ?? null;
        $this->servicio_id = $args['servicioId'] ?? null;
    } //end __construct
    
} //end CitaServicio56