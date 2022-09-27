<?php

namespace Model;

use Model\ActiveRecord;

class AdminCita extends ActiveRecord {
  // Base de datos
  protected static $tabla = 'citas_servicios';
  protected static $columnasDB = ['id', 'fecha', 'cliente', 'email', 'telefono', 'servicio', 'precio'];

  public $id;
  public $fecha;
  public $cliente;
  public $email;
  public $telefono;
  public $servicio;
  public $precio;

  public function __construct($args = []) {
    $this->id = $args['id'] ?? null;
    $this->fecha = $args['fecha'] ?? null;
    $this->cliente = $args['cliente'] ?? null;
    $this->email = $args['email'] ?? null;
    $this->telefono = $args['telefono'] ?? null;
    $this->servicio = $args['servicio'] ?? null;
    $this->precio = $args['precio'] ?? null;
  } //end __constructs


} //end Cita