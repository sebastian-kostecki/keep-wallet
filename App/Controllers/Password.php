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
        User::sendPasswordReset($_POST['email']);
        View::renderTemplate('Password/sendInfo.html');
    }

    public function resetAction()
    {
        $token = $this->route_params['token'];

        //pobieramy użytkownika na podstawie przesłanego przez niego tokenu

        //wyświetlamy stronę z formularzem zawierającym zmianę hasła
        //dodajemy to niego token, aby potem przekazać go do metody zmieniającej hasło
    }
}
