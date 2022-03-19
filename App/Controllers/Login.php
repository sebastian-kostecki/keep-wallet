<?php

namespace App\Controllers;

use Core\View;
use App\Models\User;

class Login extends \Core\Controller
{
    public function showAction()
    {
        View::renderTemplate('Login/show.html');
    }

    public function checkAction()
    {
        $user = User::authenticate($_POST['login'], $_POST['password']);
        $rememberMe = isset($_POST['rememberMe']);
    }
}
