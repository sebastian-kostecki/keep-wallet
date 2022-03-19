<?php

namespace App\Controllers;

use Core\View;

class Menu extends \Core\Controller
{
    public function showAction()
    {
        View::renderTemplate('Menu/menu.html');
    }
}
