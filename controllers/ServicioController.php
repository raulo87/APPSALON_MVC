<?php

namespace Controllers;

use MVC\Router;
use Model\Servicio;

class ServicioController
{

    public static function index(Router $router)
    {

        isAuth();

        if (!isset($_SESSION['admin'])) {
            header('Location: /');
        }

        $servicios = Servicio::all();

        $router->render('servicios/index', [
            'nombre' => $_SESSION['nombre'],
            'servicios' => $servicios
        ]);
    } //end index


    public static function crear(Router $router)
    {
        isAuth();

        if (!isset($_SESSION['admin'])) {
            header('Location: /');
        }

        $servicio = new Servicio();
        $alertas = [];


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validar();

            if (empty($alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/crear', [
            'nombre' => $_SESSION['nombre'],
            'servicio' => $servicio,
            'alertas' => $alertas
        ]);
    } //end crear

    public static function actualizar(Router $router)
    {
        isAuth();

        if (!isset($_SESSION['admin'])) {
            header('Location: /');
        }

        $alertas = [];

        // obtengo el id pasado por método GET, si está vacío asigno 0
        $id = $_GET['id'] ?? 0;

        // controlar que id es númerico y mayor o igual a cero
        if (!is_numeric($id) || (is_numeric($id) && intval($id) <= 0)) {
            //redirigo a listar servicios                
            header('Location:/servicios');
        }

        // busco el servicio por id
        $servicio = Servicio::find(intval($id));

        // si el método es POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // sincronizo los nuevos datos del servicio
            $servicio->sincronizar($_POST);
            // revisamos los datos ingresados
            $alertas = $servicio->validar();
            // si alertas está vació lo guardamos
            if (empty($$alertas)) {
                $servicio->guardar();
                header('Location: /servicios');
            }
        }

        $router->render('servicios/actualizar', [
            'nombre' => $_SESSION['nombre'],
            'alertas' => $alertas,
            'servicio' => $servicio
        ]);
    } //end actualizar

    public static function eliminar()
    {
        isAuth();

        if (!isset($_SESSION['admin'])) {
            header('Location: /');
        }


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // obtenemos el valor de id que tiene el campo oculto
            $id = $_POST['id'];

            // validamos el id
            // controlar que id es númerico y mayor o igual a cero
            if (!is_numeric($id) || (is_numeric($id) && intval($id) <= 0)) {
                //redirigo a listar servicios                
                header('Location:/servicios');
            }

            // en caso de que este todo bien buscamos y obtenemos el servicio
            $servicio = Servicio::find($id);

            // si el servicio existe
            if(! is_null($servicio)){
                // lo eliminamos de la base de datos
                $servicio->eliminar();
                header('Location: /servicios');
            }
        }
    } //end eliminar


} //end ServicioController