<?php

namespace Controllers;

use DateTime;
use MVC\Router;
use Model\AdminCita;

class AdminController
{

    public static function index(Router $router)
    {
        isAuth();

        if (!isset($_SESSION['admin'])) {
            header('Location: /');
        }

        // creamos la variable fecha para asignar el valor actual o la fecha pasada por get
        $fecha = empty($_GET['fecha']) ? '' : $_GET['fecha'];
        $fechaArray = explode('-', $fecha);
        if (count($fechaArray) !== 3 || !checkdate($fechaArray[1], $fechaArray[2], $fechaArray[0])) {
            $fecha = (new DateTime('now'))->format('Y-m-d');
        }

        // consultar la base de datos
        $consulta = 'SELECT c.id, CONCAT(c.fecha, \' \', c.hora) AS fecha, CONCAT(u.nombre, \' \' , u.apellido) AS cliente, ';
        $consulta .= 'u.email, u.telefono, s.nombre AS servicio, s.precio FROM citas AS c ';
        $consulta .= 'LEFT OUTER JOIN usuarios AS u ON c.usuario_id = u.id ';
        $consulta .= 'LEFT OUTER JOIN citas_servicios AS cs ON c.id = cs.cita_id ';
        $consulta .= 'LEFT OUTER JOIN servicios AS s ON cs.servicio_id = s.id ';
        $consulta .= 'WHERE c.fecha = \'' . $fecha . '\';';

        $citas = AdminCita::PersonalizadaSQL($consulta);
        //depurar($citas[0]->id);
        $router->render('admin/index', [
            'nombre' => $_SESSION['nombre'],
            'citas' => $citas,
            'fecha' => $fecha
        ]);
    } //end index   

} //end AdminController
