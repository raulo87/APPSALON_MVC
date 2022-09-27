<?php

namespace Controllers;

use MVC\Router;

class CitaController {

    public static function index(Router $router){

        // si no existe session lo mandamos al home
       isAuth();
       
        $router->render('cita/index', [
            'nombre' => $_SESSION['nombre'],
            'id' => $_SESSION['id']
        ]);
    } //end index

} //end CitaController