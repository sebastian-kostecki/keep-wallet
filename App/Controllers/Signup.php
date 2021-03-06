<?php

namespace App\Controllers;

use Core\View;
use App\Models\User;

class Signup extends \Core\Controller
{
    public function newAction()
    {
        View::renderTemplate('Signup/new.html');
    }

    public function createUserAction()
    {
        $user = new User($_POST);
        if ($user->saveUser()) {
            $user->sendActivationEmail();
            $this->redirect('/signup/success');
        } else {
            View::renderTemplate('Signup/new.html', [
                'user' => $user
            ]);
        }
    }

    public function successAction()
    {
        View::renderTemplate('Signup/success.html');
    }

    public function activateAction()
    {
        User::activateUser($this->route_params['token']);
        $this->redirect('/signup/activated');
    }

    public function activatedAction()
    {
        View::renderTemplate('Signup/activated.html');
    }

    protected function before()
    {
        if (isset($_SESSION['userId'])) {
            $this->redirect('/menu');
        }
    }
}
