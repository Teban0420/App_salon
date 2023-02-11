<?php

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;

class Email {

    // ATRIBUTOS
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    public function enviarConfirmacion(){

        // creamos objeto email
        $mail = new PHPMailer();
        $mail->isSMTP(); // PROTOCOLO ENVIO MAILS
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = 'b60c075e0aefd1';
        $mail->Password = 'c3e2c5aaa85e38';

        // servidor de correo electronico
        $mail->setFrom('cuentas@Appsalon.com'); // aqui iria el server de correo de la app
        $mail->addAddress('cuentas@Appsalon.com', 'AppSalon.com'); // aqui iria el nombre del dominio
        $mail->Subject = 'Confirma tu cuenta';

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        // mensaje
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola ". $this->nombre ."</strong> Has creado tu cuenta en App Salón, 
        debes confirmar presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/confirmar-cuenta?token=". $this->token."'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si no solicitaste este cuenta por favor ignora el mensaje</p>";
        $contenido .= "</html>";

        $mail->Body = $contenido; // agrego el mensaje al atributo Body

        // enviamos el email
        $mail->send();
    }

    // metodo para enviar email - restablecer contraseña
    public function enviarInstrucciones(){
        
        // no toma argumentos, al momento de instanciar 
        // el constructor ya estan ahi

         // creamos objeto email
         $mail = new PHPMailer();
         $mail->isSMTP(); // PROTOCOLO ENVIO MAILS
         $mail->Host = 'sandbox.smtp.mailtrap.io';
         $mail->SMTPAuth = true;
         $mail->Port = 2525;
         $mail->Username = 'b60c075e0aefd1';
         $mail->Password = 'c3e2c5aaa85e38';
 
         // servidor de correo electronico
         $mail->setFrom('cuentas@Appsalon.com'); // aqui iria el server de correo de la app
         $mail->addAddress('cuentas@Appsalon.com', 'AppSalon.com'); // aqui iria el nombre del dominio
         $mail->Subject = 'Restablece tu password';
 
         $mail->isHTML(true);
         $mail->CharSet = 'UTF-8';
 
         // mensaje
         $contenido = "<html>";
         $contenido .= "<p><strong>Hola ". $this->nombre ."</strong> Has solicitado restablecer tu password, sigue el siguiente enlace</p>";
         $contenido .= "<p>Presiona aqui: <a href='http://localhost:3000/recuperar?token=". $this->token."'>Restablecer Password</a></p>";
         $contenido .= "<p>Si no solicitaste este cuenta por favor ignora el mensaje</p>";
         $contenido .= "</html>";
 
         $mail->Body = $contenido; // agrego el mensaje al atributo Body
 
         // enviamos el email
         $mail->send();

    }

}