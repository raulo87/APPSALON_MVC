<?php

namespace Controllers;

use MVC\Router;
use Classes\Email;
use Model\Usuario;


class LoginController
{

    public static function login(Router $router) {

        // si está logueado lo mandamos a cita
       /* if(isset($_SESSION['admin'])){
            header('Location: /admin');
        } else if(isset($_SESSION['nombre'])){
            header('Location: /cita');
        }*/
        
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            $alertas = $auth->validarLogin();

            if (empty($alertas)) {
                // buscamos si existe y luego si la contraseña ingresada es correcta
                $usuario = Usuario::where('email', $auth->email);
                // si existe el email verificamos la password
                if ($usuario) {
                    if ($usuario->comprarPassAndVerificar($auth->password)) {
                        if ($usuario->cuentaConfirmada()) {
                            // como todo está bien vamos a guardar en las variables de sesión algunos datos
                            session_start();
                            $_SESSION['id'] = $usuario->id;
                            $_SESSION['nombre'] = $usuario->nombre . ' ' . $usuario->apellido;
                            $_SESSION['email'] = $usuario->email;
                            $_SESSION['login'] = true;

                            // y luego a redireccionar
                            if ($usuario->admin === 1) {
                                $_SESSION['admin'] = $usuario->admin ?? null;
                                header('Location: /admin');
                            } else {
                                header('Location: /cita');
                            }
                        } else {
                            Usuario::setAlerta('error', 'Su cuenta no está confirmada, revise su correo y confirme su cuenta');
                        }
                    } else {
                        USuario::setAlerta('error', 'La contraseña no es correcta');
                    };
                } else {
                    Usuario::setAlerta('error', 'Usuario no encontrado');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'alertas' => $alertas
        ]);
    } //end login

    public static function logout()
    {
        $_SESSION = [];
        header('Location: /');
    } //end logout

    public static function olvide(Router $router)
    {
        $alertas = [];
        $email = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $autorizar = new Usuario($_POST);
            $alertas = $autorizar->validarEmail();

            // si el correo no es vacío
            if (empty($alertas)) {
                // guardamos el email temporalmente
                $email = $autorizar->email;
                // verificamos si el email existe en nuestra base de datos
                $usuario = Usuario::where('email', $autorizar->email);

                // verificamos que el usuario existe y además que está confirmado
                if ($usuario && $usuario->confirmado === 1) {
                    // en caso de que el email este registrado y el usuario este confirmado, tendremos que generar un token para darle la oportunidad de resetear la contraseña
                    // generamos token de un solo uso
                    $usuario->crearToken();
                    $usuario->guardar();
                    // enviar email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarInstrucciones();
                    Usuario::setAlerta('exito', 'Revisa tu email para resetear la contraseña');
                } else {
                    Usuario::setAlerta('error', 'El usuario no existe o el mismo no ha confirmado su cuenta');
                }
            }
        }

        $alertas = Usuario::getAlertas();

        $router->render('auth/olvide', [
            'alertas' => $alertas
        ]);
    } //end olvide

    public static function reestablecer(Router $router)
    {
        // definimos alertas como array vacío para guardar los mensajes que vamos a mostrar en pantalla
        $alertas = [];
        $error = false;

        // obtenemos el token sanitizado, sin espacios ni caracteres especiales.
        $token = s($_GET['token']);

        // buscamos el usuario por token
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            Usuario::setAlerta('error', 'El enlace que ha usado para restablecer la contraseña no es válido');
            $error = true;
        
        }else{
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // leer el nuevo password y la repetición            
                $clave = $_POST['password'];
                $clave_repetir = $_POST['repeat_password'];
                if ($clave === $clave_repetir) {
                    // validamos la contraseña
                    $usuarioClave = new Usuario();
                    $usuarioClave->password = $clave;
                    $alertas = $usuarioClave->validarPassword();

                    // si no hay alertas es porque está todo bien
                    if (empty($alertas)) {
                        // limpiamos el password del objeto usuario que obtuvimos al buscar por token al principio
                        $usuario->password = null;
                        // Eliminamos el token
                        $usuario->token = null;
                        // asignamos la nueva clave
                        $usuario->password = $usuarioClave->password;
                        // hasheamos esa clave
                        $usuario->hashPassword();
                        // guardamos el objeto en base de datos.
                        $resultado = $usuario->guardar();

                        // si resultado es verdadero es porque pudo guardarlo
                        if ($resultado) {
                            // creamos mensaje de éxito
                            Usuario::setAlerta('exito', 'La contraseña se ha actualizado satisfactoriamente');
                            $error = true;
                        }
                    }
                } else {
                    $alertas = Usuario::setAlerta('error', 'Las contraseñas no coinciden, vuelva a intentarlo');
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/reestablecer_clave', [
            'alertas' => $alertas,
            'error' => $error
        ]);
    } //end recuperar

    public static function crear(Router $router)
    {
        // definimos el nuevo usuario, pasamos los datos a la vista vacíos
        $usuario = new Usuario();
        // definimos un array de alertas el cual pasa a la vista vacío
        $alertas = [];

        // si Request_Method es post entonces el usuario presionó el botón para enviar los datos del formulario
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // sincronizamos los datos del usuario con le contenido del array $_POST (datos del formulario)
            $usuario->sincronizar($_POST);
            // validamos los datos del usuario, nos retorna un array con los errores o uno vacío si no encuentra            
            $alertas = $usuario->validarNuevaCuenta();

            // si $alertas está vacío entonces no hay errores, por lo tanto podemos guardar los datos en la BD
            if (empty($alertas)) {
                // si existe el usuario
                if ($usuario->existeUsuario()) {
                    // obtenemos la alerta para mostrar en pantalla
                    $alertas = Usuario::getAlertas();
                    // si no esta registradp lo guardamos
                } else {
                    // hashear la contraseña
                    $usuario->hashPassword();

                    // Generar token automático
                    $usuario->crearToken();

                    // Enviar Email
                    $email = new Email($usuario->nombre, $usuario->email, $usuario->token);
                    $email->enviarConfirmacion();

                    //crear usuario
                    $resultado = $usuario->guardar();

                    if ($resultado) {
                        header('Location: /mensaje');
                    } else {
                        echo 'Error, pruebe más tarde';
                    }
                }
            }
        }

        $router->render('auth/crear_cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    } //end crear

    public static function mensaje(Router $router)
    {
        $router->render('auth/mensaje');
    } //end mensaje

    public static function confirmar(Router $router)
    {
        $alertas = [];
        $token = s($_GET['token']);
        $usuario = Usuario::where('token', $token);

        if (empty($usuario)) {
            // si está vacío creamos la alerta para mostrarla más adelante en pantalla
            Usuario::setAlerta('error', 'El token no es válido');
        } else {
            // modificamos al usuarios
            $usuario->confirmado = 1;
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta confirmada correctamente');
        }
        // Obtener alertas
        $alertas = Usuario::getAlertas();
        // mostrar la vista
        $router->render('auth/confirmar_cuenta', [
            'alertas' => $alertas
        ]);
    } // end confirmar

} //end LoginController