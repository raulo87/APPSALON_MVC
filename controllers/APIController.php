<?php

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use MVC\Router;
use Model\Servicio;

class APIController {

    public static function index(Router $router){

        // arrancamos la sesion para ver que tenemos en la sesión
       //if(!isset($_SESSION['nombre'])){
       //    header('Location: /');
       //}
       
       // obtenemos todos los servicios
       $servicios = Servicio::all(); 
       // los convertimos a JSON
       echo json_encode($servicios);
    } //end index

    public static function guardar(Router $router){
        // almacena la cita y devuelve el id
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        $idCita = $resultado['id'];
        //Alacemna la cita y el servicio
       //var_dump($_POST['servicios']);
        $idServicios = explode(',', $_POST['servicios']);
        
        foreach($idServicios as $idServicio){
            $args =[
                'citaId' => $idCita,
                'servicioId' => $idServicio
            ];

            $citaServicio = new CitaServicio($args);
            $resultado = $citaServicio->guardar();
            
        }        

        echo json_encode(['resultado' => $resultado]);
    } //end guardar

    public static function eliminar(Router $router) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {            
            $cita = Cita::find($_POST['id']);
            $resultado = $cita->eliminar();            
            if($resultado){
                $_SESSION['cita_eliminada'] = true;
            } else{
                $_SESSION['cita_eliminada'] = false;
            }
            // para volver a la página de la cual veníamos
            header('Location:' . $_SERVER['HTTP_REFERER']); //clase 553
            
        }
    } // end eliminar

} // end APIController