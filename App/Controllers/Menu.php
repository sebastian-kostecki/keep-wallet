<?php

namespace App\Controllers;

use Core\View;

class Menu extends Authenticated
{
    public function showAction()
    {
        View::renderTemplate('Menu/menu.html');
    }
}
