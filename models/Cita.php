<?php

namespace Model;

use Model\ActiveRecord;

class Cita extends ActiveRecord {
  // Base de datos
  protected static $tabla = 'citas';
  protected static $columnasDB = ['id', 'fecha', 'hora', 'usuario_id'];

  public $id;
  public $fecha;
  public $hora;
  public $usuario_id;

  public function __construct($args = [])
  {
    $this->id = $args['id'] ?? null;
    $this->fecha = $args['fecha'] ?? null;
    $this->hora = $args['hora'] ?? null;
    $this->usuario_id = $args['usuarioId'] ?? null;
  } //end __constructs



} //end Cita