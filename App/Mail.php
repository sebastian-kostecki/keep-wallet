<?php

namespace App;

use \PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Mail
{

    public static function sendMail()
    {
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
            $mail->isSMTP();
            $mail->Host       = \App\Config::EMAIL_HOST;
            $mail->SMTPAuth   = true;
            $mail->Username   = \App\Config::EMAIL_USER;
            $mail->Password   = \App\Config::EMAIL_PASSWORD;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = \App\Config::EMAIL_PORT;;

            $mail->setFrom('sebastian.kostecki.programista@gmail.com', 'Ogarniam portfel');
            $mail->addAddress('sebastian.kostecki@gmail.com');

            $mail->isHTML(true);
            $mail->Subject = 'Here is the subject';
            $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            echo 'Message has been sent';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
