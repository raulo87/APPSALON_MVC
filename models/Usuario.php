<?php

namespace Model;

use Model\ActiveRecord;

class Usuario extends ActiveRecord{
    // Base de datos
    protected static $tabla = 'usuarios';
    // para normalizar los datos
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'telefono', 'password', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $telefono;
    public $password;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';
    } //end __construct

    // validación
    public function validarNuevaCuenta() : array {
        if(!$this->nombre){
            self::$alertas['error'][] = 'El nombre del cliente es obligatorio';
        }

        if(!$this->apellido){
            self::$alertas['error'][] = 'El apellido del cliente es obligatorio';
        }

        if(!$this->email){
            self::$alertas['error'][] = 'El email del cliente es obligatorio';
        }

        if(!$this->telefono){
            self::$alertas['error'][] = 'El telefono del cliente es obligatorio';
        }

        if(!$this->password){
            self::$alertas['error'][] = 'El password del cliente es obligatorio';
        }else if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe contener al menos 6 caracteres';
        }

        return self::$alertas;
    } //end validarCuentaNueva

    public function existeUsuario() : bool {
        // Creamos la cadena de consulta
        $query = 'SELECT * FROM ' . self::$tabla . ' WHERE email = \'' . $this->email . '\' LIMIT 1';
        // ejecutamos la consulta y obtenemos el valor
        $resultado = self::$db->query($query);

        if($resultado->num_rows){
            self::$alertas['error'][] = 'El Usuario ya está registrado ';
            return true;
        }

        return false;
    } // end existeUsuario

    public function hashPassword(): void {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    } // end hashPassword

    public function crearToken(): void {
        $this->token = uniqid();
    } // end crearToken

    public function validarLogin() : array {
        // validamos que el email no este vacío        
        $this->validarEmail();

        // si la contraseña está vacía y tiene menos caracteres de los necesarios
        $this->validarPassword();

        return self::$alertas;
    } // end validarLogin

    public function validarEmail(): array {
        // validamos que el email no este vacío
        if(! $this->email){
            self::$alertas['error'][] = 'El email es obligatorio';        
        }

        return self::$alertas;
    } //end validarEmail

    public function validarPassword(): array {
        // si la contraseña está vacía
        if(! $this->password){
            self::$alertas['error'][] = 'Debe ingresar una contraseña';            
        }else if(strlen($this->password) < 8){
            self::$alertas['error'][] = 'La contraseña debe tener al menos 6 caracteres';
        }

        return self::$alertas;
    } //end validarPassword
    

    public function comprarPassAndVerificar(string $password) : bool{
        $resultado = password_verify($password, $this->password);
        return $resultado;

    }//end comprarPassAndVerificar

    public function cuentaConfirmada() : bool{        
        return $this->confirmado;

    }//end cuentaConfirmada

} //end Usuario