<?php

namespace App\Controllers;

use Core\View;
use App\Models\User;
use App\Authentication;
use App\Flash;

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

        if ($user) {
            Authentication::login($user, $rememberMe);
            Flash::addMessage("Udane logowanie");
            $this->redirect(Authentication::getReturnToPage());
        } else {
            Flash::addMessage("Logowanie nieudane, spróbuj jeszcze raz", Flash::DANGER);
            View::renderTemplate('Login/show.html', [
                'login' => $_POST['login'],
                'rememberMe' => $rememberMe
            ]);
        }
    }

    public function logoutAction()
    {
        Authentication::logout();
        $this->redirect('/login');
    }
}
