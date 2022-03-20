<?php

namespace App;

use \PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Mail
{

    public static function sendMail($recipient, $subject, $htmlContent, $txtContent)
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

            $mail->setFrom(\App\Config::EMAIL_USER, 'Ogarniam portfel');
            $mail->addAddress($recipient);

            $mail->CharSet = "UTF-8";
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $htmlContent;
            $mail->AltBody = $txtContent;
            $mail->AddEmbeddedImage("img/title.png", "image", "img/title.png");

            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
