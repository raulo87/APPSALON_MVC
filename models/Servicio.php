<?php

namespace Model;

use Model\ActiveRecord;

class Servicio extends ActiveRecord {
    // Base de datos
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = []) {
            $this->id = $args['id'] ?? null;
            $this->nombre = $args['nombre'] ?? '';
            $this->precio = $args['precio'] ?? 0;
    } //end __constructs
    
    public function validar () : array {
        if(!$this->nombre){
            self::$alertas['error'][] = 'Ingrese el nombre del servicio.';
        }

        if(!$this->precio){
            self::$alertas['error'][] = 'Ingrese el costo del servicio.';
        }else if(! is_numeric($this->precio)){
            self::$alertas['error'][] = 'Ingrese solo números en el precio.';
        }
        
        return self::$alertas;
    }
} //end Servicio