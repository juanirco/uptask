<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Email {
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;    
        $this->nombre = $nombre;    
        $this->token = $token;    
        
    }

    public function sendConfirmation() {
        $email = new PHPMailer();
        try {
            //Server settings
            $email->isSMTP();                                            //Send using SMTP
            $email->Host = $_ENV['EMAIL_HOST'];
            $email->SMTPAuth = true;
            $email->Port = $_ENV['EMAIL_PORT'];
            $email->Username = $_ENV['EMAIL_USER'];
            $email->Password = $_ENV['EMAIL_PASS'];
        
            $email->setFrom('cuentas@uptask.com');
            $email->addAddress($this->email);
            $email->Subject = 'Confirma tu cuenta';
            //Content
            $email->isHTML(true);                                  //Set email format to HTML
            $email->CharSet = 'UTF-8';

            $content = '<html>';
            $content .= "<p>Hola <strong>" . $this->nombre . "</strong> has creado tu cuenta en UpTask, solo debes confirmarla presionando el siguiente enlace</p>";
            $content .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/confirmar?token=" . $this->token . "'>Confirmar Cuenta</a> </p>";
            $content .= "<p> Si tu no solicitaste esta cuenta, puedes ignorar el mensaje";
            $content .= '</html>';
            $email->Body    = $content;

            $email->send();

        } catch (Exception $e) {
            echo "El Mensaje no pudo enviarse. Mailer Error: {$email->ErrorInfo}";
        }
    }

    public function sendInstructions() {
        $email = new PHPMailer();
        try {
            //Server settings
            $email->isSMTP();                                            //Send using SMTP
            $email->Host = $_ENV['EMAIL_HOST'];
            $email->SMTPAuth = true;
            $email->Port = $_ENV['EMAIL_PORT'];
            $email->Username = $_ENV['EMAIL_USER'];
            $email->Password = $_ENV['EMAIL_PASS'];

            //Recipients
            $email->setFrom('cuentas@uptask.com');
            $email->addAddress($this->email);
            $email->Subject = 'Reestablece tu password';
            //Content
            $email->isHTML(true);                                  //Set email format to HTML
            $email->CharSet = 'UTF-8';


            $content = '<html>';
            $content .= "<p>Hola <strong>" . $this->nombre . "</strong>, has solicitado reestablecer tu password, sigue el siguiente enlace para hacerlo</p>";
            $content .= "<p>Presiona aquí: <a href='" . $_ENV['APP_URL'] . "/reestablecer?token=" . $this->token . "'>Reestablecer Password</a> </p>";
            $content .= "<p> Si tu no solicitaste esta cuenta, puedes ignorar el mensaje";
            $content .= '</html>';
            $email->Body    = $content;

            $email->send();

        } catch (Exception $e) {
            echo "El Mensaje no pudo enviarse. Mailer Error: {$email->ErrorInfo}";
        }
    }

}