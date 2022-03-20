<?php

namespace App\Controllers;

use Core\View;

class Home extends \Core\Controller
{
    public function indexAction()
    {
        View::renderTemplate('Home/index.html');
    }

    protected function before()
    {
        if (isset($_SESSION['userId'])) {
            $this->redirect('/menu');
        }
    }
}
