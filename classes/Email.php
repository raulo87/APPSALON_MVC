<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public $email;
    public $nombre;
    public $token;

    public function __construct($nombre, $email, $token)
    {
        $this->nombre = $nombre;
        $this->email = $email;
        $this->token = $token;
    } //end __construct


    public function enviarConfirmacion(): void
    {
        // crear el objeto de email
        $mail = $this->crearObjetoMail();
        $mail->Subject = 'Confirma tu cuenta';

        $contenido = '<html>';
        $contenido .= '<p><strong>' . ' Hola ' . $this->nombre . ',</strong>';
        $contenido .= ' has credo tu cuenta en App Salon, debes confirmar presionando el siguiente enlace:</p>';
        $contenido .= '<p><a href="http://localhost/confirmar_cuenta?token=' . $this->token . '">Confirmar Cuenta</a> </p>';
        $contenido .= '<p>Si tu no solicitaste esta cuenta, puedes ignorar el mensaje</p>';
        $contenido .= '</html>';

        $mail->Body = $contenido;

        // enviar email
        $mail->send();
    } // end enviarConfirmacion

    public function enviarInstrucciones(): void {        
        // crear el objeto de email
        $mail = $this->crearObjetoMail();
        $mail->Subject = 'Restablecer tu Contraseña';

        $contenido = '<html>';
        $contenido .= '<p><strong>' . ' Hola ' . $this->nombre . ',</strong>';
        $contenido .= ' has solicitado restablecer tu contraseña, sigue el siguiente enlace para hacerlo:</p>';
        $contenido .= '<p>Presiona aquí: <a href="http://localhost/reestablecer?token=' . $this->token . '">Restablecer tu Contraseña</a> </p>';
        $contenido .= '<p>Si tu no solicitaste restablecer la contraseña, puedes ignorar el mensaje</p>';
        $contenido .= '</html>';

        $mail->Body = $contenido;

        // enviar email
        $mail->send();
    } //enviarInstrucciones

    public function crearObjetoMail(): PHPMailer {
        // crear el objeto de email
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '32f03bcd47fb12';
        $mail->Password = '299ad0c834d7bd';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'AppSalon.com');        

        // le indicamos que vamos a usar html
        $mail->isHTML(TRUE);
        $mail->CharSet = 'UTF-8';

        return $mail;
    } //end crearObjetoMail

} // end Email