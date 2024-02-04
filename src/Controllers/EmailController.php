<?php

namespace Controllers;


use lib\Pages;
use PHPMailer\PHPMailer\PHPMailer;

class EmailController{
    public static function enviarCorreo($email,$token) {
        $pages= new Pages();

        $correoCliente = $email;

        //Create a new PHPMailer instance
        $mail = new PHPMailer();

        //Tell PHPMailer to use SMTP
        $mail->isSMTP();

        //Enable SMTP debugging
        //SMTP::DEBUG_OFF = off (for production use)
        //SMTP::DEBUG_CLIENT = client messages
        //SMTP::DEBUG_SERVER = client and server messages
        $mail->SMTPDebug = 0;

        //Set the hostname of the mail server
        $mail->Host = 'smtp.gmail.com';
        //Use `$mail->Host = gethostbyname('smtp.gmail.com');`
        //if your network does not support SMTP over IPv6,
        //though this may cause issues with TLS

        //Set the SMTP port number:
        // - 465 for SMTP with implicit TLS, a.k.a. RFC8314 SMTPS or
        // - 587 for SMTP+STARTTLS
        $mail->Port = 465;

        //Set the encryption mechanism to use:
        // - SMTPS (implicit TLS on port 465) or
        // - STARTTLS (explicit TLS on port 587)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;

        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;

        //Username to use for SMTP authentication - use full email address for gmail
        $mail->Username = $email;

        //Password to use for SMTP authentication
        $mail->Password = 'aljl vkfk btgl vzrg';

        //Set who the message is to be sent from
        //Note that with gmail you can only use your account address (same as `Username`)
        //or predefined aliases that you have configured within your account.
        //Do not use user-submitted addresses in here
        $mail->setFrom('josemiguel41104@gmail.com', 'First Last');

        //Set an alternative reply-to address
        //This is a good place to put user-submitted addresses
        $mail->addReplyTo('replyto@example.com', 'First Last');

        //Set who the message is to be sent to
        $mail->addAddress($correoCliente, 'John Doe');

        //Set the subject line
        $mail->Subject = 'Asunto';

        //Read an HTML message body from an external file, convert referenced images to embedded,
        //convert HTML into a basic plain-text alternative body

        //Replace the plain text body with one created manually
        $mail->Body = '<h1>Su Token de verificacion y enlace de verificacion</h1><p>Token: '.$token.'</p><br><p>Confirmar Gmail: http://localhost/api_RESTful/Usuario/confirmarGmail/</p>';

        //Attach an image file

        //send the message, check for errors
        if (!$mail->send()) {
            echo 'Mensaje No Enviado: ' . $mail->ErrorInfo;
        } else {
            echo 'Mensaje Enviado!';
        }

        header("Location: ".BASE_URL);
}

}