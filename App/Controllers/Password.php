<?php

namespace App\Controllers;

use Core\View;
use App\Models\User;

class Password extends \Core\Controller
{
    public function forgotAction()
    {
        View::renderTemplate('Password/forgot.html');
    }

    public function requestResetAction()
    {
        //wysyłamy do modelu żądanie przetworzenia prośby
        //tam będzie wygenerowany model

        //wyświetlenie komunikatu o wysłaniu emaila
        User::sendPasswordReset($_POST['email']);
    }
}
