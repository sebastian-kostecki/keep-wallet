<?php

namespace App\Controllers;

use Core\View;

class Login extends \Core\Controller
{
    public function showAction()
    {
        View::renderTemplate('Login/show.html');
    }
}
